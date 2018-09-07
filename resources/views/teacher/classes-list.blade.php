@extends('layouts.app-sidebar')

@section('title', 'Gestion des classes')

@section('content')
    <h1 class="display-4 text-center">Vos classes</h1>

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    Ajoutez une classe
                </div>
                <div class="card-body">
                    <p class="card-text">
                        Ajoutez les classes qui participerons &agrave; la &laquo;Mission Nichtrauchen&raquo;
                    </p>
                    <a href="{{ route('teacher.classes.add') }}" class="card-link btn btn-info text-white">
                        Ajouter une classe
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
                        Date de clot&ucirc;re des inscriptions: {{ $inscription_date_end }}
                        ({{ $inscription_date_end_relative }})
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 table-responsive mt-2 pl-3 pr-3">

            <table class="table table-bordered table-striped bg-white school-classes">
                <caption>Liste de vos classes</caption>
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Nombre d'&eacute;l&egrave;ves</th>
                    <th>Lyc&eacute;e</th>
                    <th>Statut janvier</th>
                    <th>Statut mars</th>
                    <th>Statut mai</th>
                    <th>Inscrire &agrave; la f&ecirc;te</th>
                </tr>
                </thead>
                <tbody>
                @forelse($classes as $class)
                    <tr>
                        <td>{{ $class->name }}</td>
                        <td>{{ $class->students }}</td>
                        <td>{{ $class->school->name }}</td>
                        <td>{{ statusToIcon($class->status_january) }}</td>
                        <td>{{ statusToIcon($class->status_march) }}</td>
                        <td>{{ statusToIcon($class->status_may) }}</td>
                        <td>{{ statusToIcon($class->status_party) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            Aucune classe est enregistr&eacute;e
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

        </div>
    </div>

@endsection