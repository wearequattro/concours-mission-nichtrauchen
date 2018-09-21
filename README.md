# Mission Nichtrauchen

Web portal for teachers to register their classes in a contest to 
not smoke during a full school year. Admins can manage, view and export
all the data contained in the application.

## Installation for deployment

The easiest way to install this app is using [Docker](https://docker.io). 
Once installed, proceed with the installation.

### Install MySQL

Generate a random password for MySQL (preferably only alphanumeric)
characters to easily use it in the command line.
We'll be persisting MySQL's data folder in `/root/nichtrauchen/mysql_data` 

Create the MySQL instance like this:

```bash
docker run --name mysql-nichtrauchen -e MYSQL_ROOT_PASSWORD=randompassword \
   -v /root/nichtrauchen/mysql_data:/var/lib/mysql -e MYSQL_DATABASE=nichtrauchen -d mysql:5.7
```

### Install the app

First you need to create the `.env` file for this deployment. The location doesn't matter, although a nice
structured folder is always nice. In this case we'll use `/root/nichtrauchen/.env`. Fill in the values
as needed. We'll mount this file into the container.

To communicate with the mysql installation, we'll link the `mysql-nichtrauchen` container into 
the app container under the hostname `mysql`. You can use this hostname as the `DB_HOST` env var.

We'll expose the instance's port 80 to 9000, so the host (where a web server is running) can proxy 
the requests to the instance. This way we have easy installation and management of 
SSL using [Let's Encrypt](https://letsencrypt.org/).

To persist uploaded documents, we'll also mount the `storage/app/` folder from the instance
to the host. This way when re-creating the container all files will still be present.

If you want to use this instance as a development environment, you'll just need to mount the complete
web app into the container, like so: `-v /home/user/projects/nichtrauchen:/var/www/html`, or on
Windows: `-v C:\Users\user\Projects\nichtrauchen:/var/www/html`.

```bash
docker run --name nichtrauchen --link mysql-nichtrauchen:mysql -p 9000:80 \
    -v /root/nichtrauchen/.env:/var/www/html/.env \
    -v /root/nichtrauchen/storage/app/documents:/var/www/html/storage/app/documents \
    -d kirepo/nichtrauchen
``` 

Note: The storage folder permissions could be wrong. To fix this, run this command:
`docker exec -it nichtrauchen chown -R www-data:www-data storage`

### NGINX Configuration

This guide assumes the host's web server is [NGINX](https://www.nginx.com/). We'll just route everything
coming in to `https://concours.missionnichtrauchen.lu` to the docker instance.

```nginx
server {
    server_name concours.missionnichtrauchen.lu;
    location / {
        proxy_pass          http://127.0.0.1:9000;
        proxy_redirect      http://127.0.0.1:9000 https://concours.missionnichtrauchen.lu;
        proxy_set_header    Host $host;
        proxy_set_header    X-Real-IP $remote_addr;
        proxy_set_header    X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header    X-Forwarded-Proto $scheme;
    }
}
```

Now you can run Let's Encrypt's certbot tool to configure SSL and you're all set!
