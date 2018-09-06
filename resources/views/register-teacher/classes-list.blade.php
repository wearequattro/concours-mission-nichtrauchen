@extends('register-teacher.layout-sidebar')

@section('title', 'Gestion des classes')

@section('content')
    <h1 class="display-4 text-center">Vos classes</h1>

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <p class="card-text">
                        Inscrivez vos classes avec lesquels vous voulez participer &agrave; la mission &laquo;Nichtrauchen&raquo;
                    </p>

                    <a href="{{ route('teacher-register.classes.add') }}" class="card-link">
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
                        Date de clot&ucirc;re des inscriptions: {{ $inscription_date_end }} ({{ $inscription_date_end_relative }})
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 table-responsive mt-2">

            <table class="table table-bordered table-striped bg-white">
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
                <tr>
                    <td colspan="7" class="text-center">
                        Aucune classe est enregistr&eacute;e
                    </td>
                </tr>
                </tbody>
            </table>

        </div>
    </div>

@endsection