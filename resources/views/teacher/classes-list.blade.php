@extends('layouts.app-sidebar')

@section('title', 'Gestion des classes')

@section('content')
    <h1 class="display-4 text-center">Vos classes</h1>

    @if(isRegistrationOpen())
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    Ajoutez une classe
                </div>
                <div class="card-body">
                    <p class="card-text">
                        Ajoutez les classes qui participeront &agrave; la &laquo;Mission Nichtrauchen&raquo;. Vous pourrez inscrire une ou
                        plusieurs classes de différents Lycées !
                    </p>
                    <a href="{{ route('teacher.classes.add') }}" class="card-link btn btn-primary">
                        Je veux ajouter une classe
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card bg-warning">
                <div class="card-header">
                    Inscription limit&eacute;e
                </div>
                <div class="card-body">
                    <p class="card-text">
                        Date de cl&ocirc;t&ucircure des inscriptions : {{ $inscription_date_end }}
                        ({{ $inscription_date_end_relative }})
                    </p>
                </div>
            </div>
        </div>
    </div>
    @else
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        Inscriptions fermées
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            Les inscriptions sont fermées.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-xs-12 table-responsive mt-2 pl-3 pr-3">

            <table class="table table-bordered table-striped bg-white school-classes">
                <caption>Liste de vos classes</caption>
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Nombre d'&eacute;l&egrave;ves</th>
                    <th>Lyc&eacute;e</th>
                    @if($show_january)
                    <th>Statut janvier</th>
                    @endif
                    @if($show_march)
                    <th>Statut mars</th>
                    @endif
                    @if($show_may)
                    <th>Statut mai</th>
                    @endif
                    @if($show_party)
                    <th>Inscrire &agrave; la f&ecirc;te</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @forelse($classes as $class)
                    <tr>
                        <td>{{ $class->name }}</td>
                        <td>{{ $class->students }}</td>
                        <td>{{ $class->school->name }}</td>
                        @if($show_january)
                        <td>{{ statusToIcon($class->status_january) }}</td>
                        @endif
                        @if($show_march)
                        <td>{{ statusToIcon($class->status_march) }}</td>
                        @endif
                        @if($show_may)
                        <td>{{ statusToIcon($class->status_may) }}</td>
                        @endif
                        @if($show_party)
                        <td>{{ statusToIcon($class->status_party) }}</td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            Aucune classe n'est enregistr&eacute;e
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

        </div>
    </div>

@endsection