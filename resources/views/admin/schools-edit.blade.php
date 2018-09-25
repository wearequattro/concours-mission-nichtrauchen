@extends('layouts.app-sidebar')

@section('title', 'Mise à jour lycée')

@section('content')
    <h1 class="text-center"><span class="display-5">Mise à jour</span> <span class="text-muted">&laquo;{{ $school->name }}&raquo;</span></h1>

    <form method="post" action="{{ route('admin.schools.edit.post', [$school]) }}">
        @csrf

        <div class="form-group">
            <label for="school_name">Nom</label>
            <input required type="text" name="school_name" id="school_name"
                   class="form-control {{ inputValidationClass($errors, 'school_name') }}"
                   value="{{ old('school_name') ?? $school->name }}">
            <div class="invalid-feedback">
                {{ inputValidationMessages($errors, 'school_name') }}
            </div>
        </div>

        <div class="form-group">
            <label for="school_address">Adresse de l'école</label>
            <input required type="text" name="school_address" id="school_address"
                   class="form-control {{ inputValidationClass($errors, 'school_address') }}"
                   value="{{ old('school_address') ?? $school->address }}">
            <div class="invalid-feedback">
                {{ inputValidationMessages($errors, 'school_address') }}
            </div>
        </div>

        <div class="form-group">
            <label for="school_postal_code">Code Postal</label>
            <input required type="text" name="school_postal_code" id="school_postal_code"
                   class="form-control {{ inputValidationClass($errors, 'school_postal_code') }}"
                   value="{{ old('school_postal_code') ?? $school->postal_code }}">
            <div class="invalid-feedback">
                {{ inputValidationMessages($errors, 'school_postal_code') }}
            </div>
        </div>

        <div class="form-group">
            <label for="school_city">Ville</label>
            <input required type="text" name="school_city" id="school_city"
                   class="form-control {{ inputValidationClass($errors, 'school_city') }}"
                   value="{{ old('school_city') ?? $school->city }}">
            <div class="invalid-feedback">
                {{ inputValidationMessages($errors, 'school_city') }}
            </div>
        </div>

        <input type="submit" class="btn btn-primary" value="Mettre à jour">

    </form>

@endsection