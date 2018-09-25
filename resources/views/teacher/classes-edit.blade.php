@extends('layouts.app-sidebar')

@section('title', 'Gestion des classes')

@section('content')
    <h1 class="display-4 text-center">Ajouter une classe</h1>

    <form method="post" action="{{ route('teacher.classes.edit.post', [$class]) }}">
        @csrf

        <div class="form-group">
            <label for="name">Nom de la classe</label>
            <input required type="text" name="name" id="name"
                   class="form-control {{ inputValidationClass($errors, 'name') }}"
                   value="{{ old('name') ?? $class->name }}">
            <div class="invalid-feedback">
                {{ inputValidationMessages($errors, 'name') }}
            </div>
        </div>

        <div class="form-group">
            <label for="students">Nombre d'&eacute;l&egrave;ves</label>
            <input required type="number" name="students" id="students"
                   min="1" max="99"
                   class="form-control {{ inputValidationClass($errors, 'students') }}"
                   value="{{ old('students') ?? $class->students }}">
            <div class="invalid-feedback">
                {{ inputValidationMessages($errors, 'students') }}
            </div>
        </div>

        <input type="submit" class="btn btn-primary" value="Mettre à jour">

    </form>
@endsection
