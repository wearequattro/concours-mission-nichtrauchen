<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('images/favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('images/favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('images/favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('images/favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('images/favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('images/favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('images/favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
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
                       class="nav-link {{ \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'teacher.profile') ? 'active' : '' }}">
                        <i class="fa fa-fw fa-user-circle"></i>
                        Mon profil
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('teacher.classes') }}"
                       class="nav-link {{ \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'teacher.classes') ? 'active' : '' }}">
                        <i class="fa fa-fw fa-graduation-cap"></i>
                        Mes classes
                    </a>
                </li>
                @if(isRegistrationOpen())
                <li class="nav-item">
                    <a href="{{ route('teacher.classes.add') }}"
                       class="nav-link {{ \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'teacher.classes.add') ? 'active' : '' }}">
                        <i class="fa fa-fw fa-plus-circle"></i>
                        Je veux ajouter une classe
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('teacher.documents') }}"
                       class="nav-link {{ \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'teacher.documents') ? 'active' : '' }}">
                        <i class="fa fa-fw fa-file-text"></i>
                        Mes documents
                    </a>
                </li>
                @if(Auth::user()->hasAccessToParty())
                <li class="nav-item">
                    <a href="{{ route('teacher.party') }}"
                       class="nav-link {{ \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'teacher.party') ? 'active' : '' }}">
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
                        <a href="{{ route('admin.users') }}"
                           class="nav-link {{ \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.users') ? 'active' : '' }}">
                            <i class="fa fa-fw fa-user"></i>
                            Utilisateurs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.classes') }}"
                           class="nav-link {{ \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.classes') ? 'active' : '' }}">
                            <i class="fa fa-fw fa-graduation-cap"></i>
                            Classes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.certificates') }}"
                           class="nav-link {{ \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.certificates') ? 'active' : '' }}">
                            <i class="fa fa-fw fa-file"></i>
                            Certificats
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.schools') }}"
                           class="nav-link {{ \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.schools') ? 'active' : '' }}">
                            <i class="fa fa-fw fa-university"></i>
                            Lyc&eacute;es
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.teachers') }}"
                           class="nav-link {{ \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.teachers') ? 'active' : '' }}">
                            <i class="fa fa-fw fa-users"></i>
                            Enseignants
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.emails') }}"
                           class="nav-link {{ \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.emails') ? 'active' : '' }}">
                            <i class="fa fa-fw fa-envelope"></i>
                            E-mails
                        </a>
                    </li>
                    {{--
                    Disabled because merging with emails route
                    <li class="nav-item">
                        <a href="{{ route('admin.dates') }}"
                           class="nav-link {{ Route::currentRouteName() == 'admin.dates' ? 'active' : '' }}">
                            <i class="fa fa-fw fa-calendar"></i>
                            Dates
                        </a>
                    </li>
                    --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.quiz') }}"
                           class="nav-link {{ \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.quiz') ? 'active' : '' }}">
                            <i class="fa fa-fw fa-check-square"></i>
                            Quiz
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.documents') }}"
                           class="nav-link {{ \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.documents') ? 'active' : '' }}">
                            <i class="fa fa-fw fa-file-text"></i>
                            Documents
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.party') }}"
                           class="nav-link {{ \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.party') ? 'active' : '' }}">
                            <i class="fa fa-fw fa-birthday-cake"></i>
                            F&ecirc;te de cl&ocirc;ture
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.settings') }}"
                           class="nav-link {{ \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.settings') ? 'active' : '' }}">
                            <i class="fa fa-fw fa-gear"></i>
                            Paramètres
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
<script src="{{ mix('js/app.js') }}"></script>
@stack('js')
</body>
</html>
