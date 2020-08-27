@extends('layouts.app-sidebar')

@section('title', 'Inscription Fête de clôture')

@section('content')
    <h1 class="display-4 text-center">Fête de clôture</h1>

    <h1 class="display-5 text-center">Documents utils</h1>
    <div class="row">
        @forelse($documents as $document)
            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="card mb-3">
                    <div class="card-header">{{ $document->title }}</div>
                    <div class="card-body">
                        <p class="card-text">{{ $document->description }}</p>
                        <a href="{{ route('teacher.documents.download', [$document]) }}" target="_blank" download class="card-link btn btn-primary btn-block">
                            <i class="fa fa-fw fa-download text-white"></i>
                            T&eacute;l&eacute;charger
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-sm-8 offset-sm-2 col-lg-4 offset-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center text-muted font-italic">Aucun fichier disponible</h4>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <h1 class="display-5 text-center mt-3">Inscriptions</h1>
    <p class="text-center">
        <strong>
            @if($open)
                Vous pouvez modifier les données de votre (vos) classe(s) jusqu'au 26 mai.
            @else
                Les inscriptions pour la fête de clôture de la Mission Nichtrauchen sont closes.
            @endif
        </strong>
    </p>
    @foreach($classes as $class)
        @if($class->partyGroups()->doesntExist())
        <div class="row">
            <div class="col-xs-12 col-sm-12 mt-4 mb-2">
                <div class="card">
                    <div class="card-body">
                        <h3>
                            Classe {{ $class->name }} <small class="text-muted text">{{ $class->school->name }}</small>
                        </h3>
                        @if($open)
                            <p>
                                <strong>
                                    Cliquez sur &laquo; Inscrire &raquo; pour compléter et valider l'inscription de votre classe.
                                </strong>
                            </p>
                            <a class="btn btn-primary text-white" href="{{ route('teacher.party.class', [$class]) }}">
                                Inscrire
                            </a>
                        @else
                            <p>Votre classe n'est pas inscrite à la fête de clôture.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @else
            <div class="row">
                <div class="col-xs-12 col-sm-12 mt-4 mb-2">
                    <div class="card">
                        <div class="card-body">
                            <h3>
                                Classe {{ $class->name }} <small class="text-muted text">{{ $class->school->name }}</small>
                                @if($open)
                                    <a class="btn btn-primary text-white pull-right" href="{{ route('teacher.party.class', [$class]) }}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                @else
                                    <a class="btn btn-primary text-white pull-right" href="{{ route('teacher.party.class', [$class]) }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                @endif
                            </h3>
                            <p class="mb-0">
                                Votre classe est bien inscrite à la fête de clôture.<br>
                                N'oubliez pas de consulter les documents &laquo; Programme &raquo; et &laquo; Infos pratiques &raquo; ci-dessus.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    @endforeach

@endsection
