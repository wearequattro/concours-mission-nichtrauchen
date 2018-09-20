<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>@yield('title')</title>
</head>
<body>
<div class="container-fluid">

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Nom de la classe</th>
            <th>Lycée</th>
        </tr>
        </thead>
        <tbody>
        @foreach($classes as $class)
            <tr>
                <td>{{ $class->name }}</td>
                <td>{{ $class->school->name }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th colspan="2">
                Total : {{ $classes->count() }} classes
            </th>
        </tr>
        </tfoot>
    </table>

</div>
</body>
</html>