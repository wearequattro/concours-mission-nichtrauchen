<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>@yield('title')</title>
</head>
<body class="teacher">
<div class="container-fluid">
    <div class="row">
        <div id="nav-bg"></div>
        <nav class="col-md-2">
            <ul class="nav">
                <li class="nav-item">
                    <a href="{{ route('teacher.profile') }}" class="nav-link">
                        <i class="fa fa-fw fa-user-circle"></i>
                        Mon Profil
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('teacher-register.classes') }}" class="nav-link">
                        <i class="fa fa-fw fa-graduation-cap"></i>
                        Mes Classes
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('teacher-register.classes.add') }}" class="nav-link">
                        <i class="fa fa-fw fa-plus-circle"></i>
                        Ajouter une classe
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('teacher.documents') }}" class="nav-link">
                        <i class="fa fa-fw fa-file-text"></i>
                        Mes Documents
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('teacher.party') }}" class="nav-link">
                        <i class="fa fa-fw fa-birthday-cake"></i>
                        F&ecirc;te de Cl&ocirc;ture
                    </a>
                </li>
            </ul>
        </nav>


        <div class="col-md-10 pr-4 pl-4">
            @yield('content')
        </div>

    </div>
</div>
<script src="{{ asset('js/app.js') }}"></script>
@stack('js')
</body>
</html>