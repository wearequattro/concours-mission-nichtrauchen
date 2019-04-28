@extends('layouts.app-sidebar')

@section('title', 'Fête de clôture')

@section('content')
    <h1 class="display-4 text-center">Inscription fête de clôture</h1>

    <p>
        <a class="btn btn-primary" href="{{ route('admin.party.export') }}">
            Exporter
        </a>
    </p>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>Nom du groupe</th>
            <th>Nombre d'élèves du groupe</th>
            <th>Lycée</th>
            <th>Classe</th>
            <th>Langue souhaitée</th>
            <th>Nom du prof</th>
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
                <td>{{ $group->schoolClass->teacher->full_name }}</td>
                <td>{{ $group->schoolClass->teacher->phone }}</td>
                <td></td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection

@push("js")
    <script>
        $('table').DataTable({
            pageLength: 100,
        });
    </script>
@endpush
