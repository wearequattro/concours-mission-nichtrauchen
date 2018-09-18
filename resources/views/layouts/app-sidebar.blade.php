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
<nav class="navbar navbar-dark bg-dark mb-2">
    <a href="{{ route('login.redirect') }}" class="navbar-brand">
        <img src="{{ asset('images/logo-contrast.png') }}" height="70px">
    </a>
    <a href="{{ route('logout') }}" class="navbar-text text-white">
        <i class="fa fa-fw fa-sign-out"></i>
        D&eacute;connecter
    </a>
</nav>
<div class="container-fluid">
    <div class="row">
        <div id="nav-bg"></div>
        @if(Auth::user() !== null && Auth::user()->type === \App\User::TYPE_TEACHER && Auth::user()->teacher != null)
        <nav id="sidebar" class="col-md-2">
            <ul class="nav">
                <li class="nav-item">
                    <a href="{{ route('teacher.profile') }}"
                       class="nav-link {{ Route::currentRouteName() == 'teacher.profile' ? 'active' : '' }}">
                        <i class="fa fa-fw fa-user-circle"></i>
                        Mon profil
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('teacher.classes') }}"
                       class="nav-link {{ Route::currentRouteName() == 'teacher.classes' ? 'active' : '' }}">
                        <i class="fa fa-fw fa-graduation-cap"></i>
                        Mes classes
                    </a>
                </li>
                @if(isRegistrationOpen())
                <li class="nav-item">
                    <a href="{{ route('teacher.classes.add') }}"
                       class="nav-link {{ Route::currentRouteName() == 'teacher.classes.add' ? 'active' : '' }}">
                        <i class="fa fa-fw fa-plus-circle"></i>
                        Je veux ajouter une classe
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('teacher.documents') }}"
                       class="nav-link {{ Route::currentRouteName() == 'teacher.documents' ? 'active' : '' }}">
                        <i class="fa fa-fw fa-file-text"></i>
                        Mes documents
                    </a>
                </li>
                @if(Auth::user()->hasAccessToParty())
                <li class="nav-item">
                    <a href="{{ route('teacher.party') }}"
                       class="nav-link {{ Route::currentRouteName() == 'teacher.party' ? 'active' : '' }}">
                        <i class="fa fa-fw fa-birthday-cake"></i>
                        F&ecirc;te de cl&ocirc;ture
                    </a>
                </li>
                @endif
            </ul>
        </nav>
        @elseif(Auth::user() !== null && Auth::user()->type === \App\User::TYPE_ADMIN)
            <nav id="sidebar" class="col-md-2">
                <ul class="nav">
                    <li class="nav-item">
                        <a href="{{ route('admin.classes') }}"
                           class="nav-link {{ Route::currentRouteName() == 'admin.classes' ? 'active' : '' }}">
                            <i class="fa fa-fw fa-graduation-cap"></i>
                            Classes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.schools') }}"
                           class="nav-link {{ Route::currentRouteName() == 'admin.schools' ? 'active' : '' }}">
                            <i class="fa fa-fw fa-university"></i>
                            Lyc&eacute;es
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.teachers') }}"
                           class="nav-link {{ Route::currentRouteName() == 'admin.teachers' ? 'active' : '' }}">
                            <i class="fa fa-fw fa-users"></i>
                            Enseignants
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.emails') }}"
                           class="nav-link {{ Route::currentRouteName() == 'admin.emails' ? 'active' : '' }}">
                            <i class="fa fa-fw fa-envelope"></i>
                            Emails
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.dates') }}"
                           class="nav-link {{ Route::currentRouteName() == 'admin.dates' ? 'active' : '' }}">
                            <i class="fa fa-fw fa-calendar"></i>
                            Dates
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.documents') }}"
                           class="nav-link {{ Route::currentRouteName() == 'admin.documents' ? 'active' : '' }}">
                            <i class="fa fa-fw fa-file-text"></i>
                            Documents
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.party') }}"
                           class="nav-link {{ Route::currentRouteName() == 'admin.party' ? 'active' : '' }}">
                            <i class="fa fa-fw fa-birthday-cake"></i>
                            F&ecirc;te de cl&ocirc;ture
                        </a>
                    </li>
                </ul>
            </nav>
        @endif


        <div class="col-md-10 pr-4 pl-4">
            @yield('content')
        </div>

    </div>
</div>
<script src="{{ asset('js/app.js') }}"></script>
@stack('js')
</body>
</html>