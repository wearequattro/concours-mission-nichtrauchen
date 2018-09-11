@extends('layouts.app-sidebar')

@section('title', 'Inscription Fête de clôture')

@section('content')
    <h1 class="display-4 text-center">Inscription Fête de clôture</h1>

    @foreach($classes as $class)
        @if($class->partyGroups()->doesntExist())
        <div class="row">
            <div class="col-xs-12 col-sm-12 mt-4 mb-2">
                <div class="card">
                    <div class="card-body">
                        <h3 class="display-5 mb-0">
                            Classe {{ $class->name }} <small class="text-muted text">{{ $class->school->name }}</small>
                        </h3>
                        <a class="btn btn-primary text-white mt-3" href="{{ route('party.class', [$class]) }}">
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
                            <h3 class="display-5 mb-0">
                                Classe {{ $class->name }} <small class="text-muted text">{{ $class->school->name }}</small>
                            </h3>
                            <p class="mt-2 mb-0">Déjà inscrit</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    @endforeach

@endsection