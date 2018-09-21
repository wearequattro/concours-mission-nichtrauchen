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
<div class="container-fluid external">

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Lycée</th>
            <th>Enseignant</th>
            <th>Classe</th>
        </tr>
        </thead>
        <tbody>
        @foreach($classes as $class)
            <tr>
                <td>{{ $class->school->name }}</td>
                <td>{{ $class->teacher->full_name }}</td>
                <td>{{ $class->name }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th colspan="3">
                Total : {{ $classes->count() }} classes
            </th>
        </tr>
        </tfoot>
    </table>

</div>
</body>
</html>