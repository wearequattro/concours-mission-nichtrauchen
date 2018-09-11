@extends('layouts.app-sidebar')

@section('title', 'Fête de clôture')

@section('content')
    <h1 class="display-4 text-center">Inscription Fête de clôture</h1>

    @foreach($groups as $group)
        <div class="row">
            <div class="col-12 mt-4">
                <div class="card bg-light mb-2">
                    <div class="card-body">
                        <h3>
                            Classe {{ $group->first()->schoolClass->name }} <small class="text-muted text">{{ $group->first()->schoolClass->school->name }}</small>
                        </h3>
                        <p class="mb-0">
                            Enseignant: <a href="{{ route('admin.teachers.edit', [$group->first()->schoolClass->teacher]) }}">
                                {{ $group->first()->schoolClass->teacher->full_name }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            @foreach ($group as $partyGroup)

            <div class="col-sm-6 col-md-3 mb-2">
                <div class="card">
                    <div class="card-header">
                        {{ $partyGroup->name }}
                    </div>
                    <div class="card-body">
                        <p>
                            <strong>Nombre d'étudiants: </strong>
                            {{ $partyGroup->students }}
                        </p>
                        <p>
                            <strong>Langue: </strong>
                            {{ $partyGroup->language }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach

        </div>

    @endforeach

@endsection