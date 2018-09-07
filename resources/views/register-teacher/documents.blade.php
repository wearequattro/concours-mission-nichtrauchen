@extends('register-teacher.layout-sidebar')

@section('title', 'Mes Documents')

@section('content')
    <h1 class="display-4 text-center">Mes Documents</h1>

    <div class="row">
        @forelse($documents as $document)
            <div class="col-sm-3">
                <div class="card mb-3">
                    <div class="card-header">{{ $document->title }}</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $document->title }}</h5>
                        <p class="card-text">{{ $document->description }}</p>
                        <a href="{{ $document->getDownloadUrl() }}" target="_blank" download class="card-link">T&eacute;l&eacute;charger</a>
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

@endsection