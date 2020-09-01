@extends('layouts.app-sidebar')

@section('title', 'Gestion des classes')

@section('content')
    <h1 class="display-4 text-center">Mes classes</h1>

    @if(isRegistrationOpen())
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    Ajoutez une classe
                </div>
                <div class="card-body">
                    <p class="card-text">
                        Ajoutez les classes qui participeront &agrave; la <em>Mission Nichtrauchen</em>. Vous pourrez inscrire une ou
                        plusieurs classes de différents lycées !
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
                        Date de cl&ocirc;ture des inscriptions : {{ $inscription_date_end }}
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
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        Légende
                    </div>
                    <div class="card-body">
                        <p>
                            <strong>Icônes :</strong><br>
                            {{ statusToIcon(null) }}: Pas répondu<br>
                            {{ statusToIcon(1) }}: Classe « non-fumeur », continue à participer au concours<br>
                            {{ statusToIcon(0) }}: Classe « fumeur », ne continue plus à participer au concours
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-xs-12 mt-2 pl-3 pr-3">
            <div class="table-responsive">

            <table class="table table-bordered table-striped bg-white school-classes">
                <caption>Liste de vos classes</caption>
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Nombre d'&eacute;l&egrave;ves</th>
                    <th>Lyc&eacute;e</th>
                    @foreach($quizzes as $quiz)
                        <th>{{ $quiz->name }}</th>
                    @endforeach
                    <th>Quiz Total</th>
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
                    <th>Statut f&ecirc;te</th>
                    <th>Inscription fête complétée</th>
                    @endif
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($classes as $class)
                    <tr>
                        <td>{{ $class->name }}</td>
                        <td>{{ $class->students }}</td>
                        <td>{{ $class->school->name }}</td>
                        @foreach($quizzes as $quiz)
                            <td>
                                @if($quiz->getPointsForClass($class) !== null)
                                    {{ $quiz->getPointsForClass($class) }}
                                    /
                                    {{ $quiz->max_score  }}
                                @else
                                    /
                                @endif
                            </td>
                        @endforeach
                        <td>
                            {{ $class->getPoints($quizzes) }}
                            /
                            {{ $class->getMaxPoints($quizzes) }}
                        </td>
                        @if($show_january)
                            <td>{{ statusToIcon($class->getStatusJanuary() ) }}</td>
                        @endif
                        @if($show_march)
                            <td>{{ statusToIcon($class->getStatusMarch() ) }}</td>
                        @endif
                        @if($show_may)
                            <td>{{ statusToIcon($class->getStatusMay() ) }}</td>
                        @endif
                        @if($show_party)
                            <td>{{ statusToIcon($class->getStatusParty()) }}</td>
                            <td>{{ statusToIcon($class->getStatusPartyGroups() ) }}</td>
                        @endif
                        <td>
                            <a href="{{ route('teacher.classes.edit', [$class]) }}" class="btn btn-primary">
                                <i class="fa fa-pencil fa-fw"></i>
                            </a>
                        </td>
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
    </div>

@endsection
