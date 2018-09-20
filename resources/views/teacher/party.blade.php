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
                        <h5 class="card-title">{{ $document->title }}</h5>
                        <p class="card-text">{{ $document->description }}</p>
                        <a href="{{ route('teacher.documents.download', [$document]) }}" target="_blank" download class="card-link btn btn-primary">
                            <i class="fa fa-fw fa-download text-white"></i>
                            T&eacute;l&eacute;charger
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-sm-4 offset-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center text-muted font-italic">Aucun fichier disponible</h4>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <h1 class="display-5 text-center">Inscriptions</h1>
    @foreach($classes as $class)
        @if($class->partyGroups()->doesntExist())
        <div class="row">
            <div class="col-xs-12 col-sm-12 mt-4 mb-2">
                <div class="card">
                    <div class="card-body">
                        <h3>
                            Classe {{ $class->name }} <small class="text-muted text">{{ $class->school->name }}</small>
                        </h3>
                        <a class="btn btn-primary text-white" href="{{ route('party.class', [$class]) }}">
                            Inscrire
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @else
            <div class="row">
                <div class="col-xs-12 col-sm-12 mt-4 mb-2">
                    <div class="card">
                        <div class="card-body bg-light">
                            <h3>
                                Classe {{ $class->name }} <small class="text-muted text">{{ $class->school->name }}</small>
                            </h3>
                            <p class="mb-0">Déjà inscrit</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    @endforeach

@endsection