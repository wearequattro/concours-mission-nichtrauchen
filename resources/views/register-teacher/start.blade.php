<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Hello, world!</title>
</head>
<body>
<div class="container">

    <h1 class="display-4 text-center">Inscription enseingnants</h1>

    <form method="post">
        @csrf

        <div class="form-group">
            <label for="teacher_salutation">Titre</label>
            <select required name="teacher_salutation" id="teacher_salutation" class="form-control">
                <option>Monsieur</option>
                <option>Madame</option>
            </select>
        </div>

        <div class="form-group">
            <label for="teacher_name">Nom</label>
            <input required type="text" name="teacher_name" id="teacher_name" class="form-control">
        </div>

        <div class="form-group">
            <label for="teacher_surname">Prénom</label>
            <input required type="text" name="teacher_surname" id="teacher_surname" class="form-control">
        </div>

        <div class="form-group">
            <label for="teacher_email">Addresse Email</label>
            <input required type="email" name="teacher_email" id="teacher_email" class="form-control">
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="teacher_password">Mot de passe</label>
                    <input required type="password" name="teacher_password" id="teacher_password" class="form-control">
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="teacher_password_confirmation">Confirmation mot de passe</label>
                    <input required type="password" name="teacher_password_confirmation"
                           id="teacher_password_confirmation"
                           class="form-control">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="teacher_phone">Numéro de Téléphone</label>
            <input required type="text" name="teacher_phone" id="teacher_phone" class="form-control"
                   aria-describedby="phone_help">
            <small id="phone_help" class="form-text text-muted">Selon ce format: +352 621123456</small>
        </div>

        <input type="submit" class="btn btn-primary" value="Inscrire">

    </form>

</div>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>