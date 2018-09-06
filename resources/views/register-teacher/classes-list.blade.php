@extends('register-teacher.layout')

@section('title', 'Gestion des classes')

@section('content')
    <h1 class="display-4 text-center">Vos classes</h1>

    <div class="row">
        <div class="col-xs-12">
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
    </div>

    <div class="row">
        <div class="col-xs-12 table-responsive mt-2">

            <table class="table table-bordered table-striped bg-white">
                <caption>Liste de vos classes</caption>
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Nombre d'&eacute;l&egrave;ves</th>
                    <th>Lyc&euml;e</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="3" class="text-center">
                        Aucune classe est enregistr&eacute;e
                    </td>
                </tr>
                </tbody>
            </table>

        </div>
    </div>
@endsection