@extends('layouts.app-sidebar')

@section('title', 'Mise à jour classe')

@section('content')
    <h1 class="display-5 text-center">
        Mise à jour &laquo;{{ $class->name }} <span class="text-muted">{{ $class->school->name }}</span>&raquo;
    </h1>

    <form method="post" action="{{ route('admin.classes.edit.post', [$class]) }}">
        @csrf

        <div class="form-group">
            <label for="name">Nom</label>
            <input required type="text" name="name" id="name"
                   class="form-control {{ inputValidationClass($errors, 'name') }}"
                   value="{{ old('name') ?? $class->name }}">
            <div class="invalid-feedback">
                {{ inputValidationMessages($errors, 'name') }}
            </div>
        </div>

        <div class="form-group">
            <label for="students">Étudiants</label>
            <input required type="number" name="students" id="students" min="1" max="99"
                   class="form-control {{ inputValidationClass($errors, 'students') }}"
                   value="{{ old('students') ?? $class->students }}">
            <div class="invalid-feedback">
                {{ inputValidationMessages($errors, 'students') }}
            </div>
        </div>

        <div class="form-group">
            <label for="school_id">Lycée</label>
            <select class="form-control" required name="school_id" id="school_id">
                @foreach($schools as $school)
                    <option value="{{ $school->id }}" {{ $class->school_id === $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">
                {{ inputValidationMessages($errors, 'school_id') }}
            </div>
        </div>

        <div class="form-group">
            <label for="teacher_id">Enseignant</label>
            <select class="form-control" required name="teacher_id" id="teacher_id">
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ $teacher->teacher_id === $teacher->id ? 'selected' : '' }}>{{ $teacher->full_name }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">
                {{ inputValidationMessages($errors, 'teacher_id') }}
            </div>
        </div>

        <input type="submit" class="btn btn-primary" value="Mettre à jour">

    </form>

@endsection