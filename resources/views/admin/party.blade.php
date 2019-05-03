@extends('layouts.app-sidebar')

@section('title', 'Fête de clôture')

@section('content')
    <h1 class="display-4 text-center">Inscription fête de clôture</h1>

    <div class="row">
        <div class="col-sm-3 mb-4">
            <div class="card">
                <div class="card-header">
                    Exporter fichier des classes
                </div>
                <div class="card-body">
                    @php
                        $countClasses = $groups->count();
                        $countTeacher = $groups->pluck('schoolClass.teacher')->unique()->count();
                        $countSchool = $groups->pluck('schoolClass.school.name')->unique()->count();
                        $countStudents = $groups->sum('students');
                    @endphp
                    <p>
                        L'export contiendra <strong>{{ $countClasses }} {{ $countClasses > 1 ? 'groupes' : 'groupe' }}</strong>,
                        <strong>{{ $countTeacher }} {{ $countTeacher > 1 ? 'enseignants' : 'enseignant' }}</strong>,
                        <strong>{{ $countSchool }} {{ $countSchool > 1 ? 'lycées' : 'lycée' }}</strong>,
                        <strong>{{ $countStudents }} {{ $countStudents > 1 ? 'étudiants' : 'étudiant' }}</strong>.
                    </p>
                    <a class="btn btn-primary" href="{{ route('admin.party.export') }}">
                        Exporter
                    </a>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>Nom du groupe</th>
            <th>Nombre d'élèves du groupe</th>
            <th>Lycée</th>
            <th>Classe</th>
            <th>Langue souhaitée</th>
            <th>Enseignant titre</th>
            <th>Enseignant prénom</th>
            <th>Enseignant nom</th>
            <th>Télephone prof</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($groups as $group)
            <tr>
                <td>{{ $group->name }}</td>
                <td>{{ $group->students }}</td>
                <td>{{ $group->schoolClass->school->name }}</td>
                <td>{{ $group->schoolClass->name }}</td>
                <td>{{ $group->language }}</td>
                <td>{{ $group->schoolClass->teacher->salutation->long_form }}</td>
                <td>{{ $group->schoolClass->teacher->first_name }}</td>
                <td>{{ $group->schoolClass->teacher->last_name }}</td>
                <td>{{ $group->schoolClass->teacher->phone }}</td>
                <td>
                    <a href="{{ route('admin.party.class', [$group->schoolClass]) }}" class="btn btn-primary text-white">
                        <i class="fa fa-pencil"></i>
                    </a>
                    <a href="{{ route('admin.party.class.delete', [$group]) }}" class="btn btn-danger text-white">
                        <i class="fa fa-trash-o"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection

@push("js")
    <script>
        $('table').DataTable({
            pageLength: 100,
            order: [
                [2, "asc"]
            ]
        });
    </script>
@endpush
