@extends('layouts.app-sidebar')

@section('title', 'Mise à jour enseignant')

@section('content')
    <h1 class="text-center"><span class="display-5">Mise à jour</span> <span class="text-muted">{{ $teacher->full_name }}</span></h1>

    <form method="post" action="{{ route('admin.teachers.edit.post', [$teacher]) }}">
        @csrf

        <div class="form-group">
            <label for="salutation_id">Titre</label>
            <select required name="salutation_id" id="salutation_id"
                    class="form-control {{ inputValidationClass($errors, 'salutation_id') }}">
                    @foreach($salutations as $salutation)
                        <option value="{{ $salutation->id }}"
                                {{ $teacher->salutation_id === $salutation->id ? 'selected' : '' }}>
                            {{ $salutation->long_form }}
                        </option>
                    @endforeach
            </select>
            <div class="invalid-feedback">
                {{ inputValidationMessages($errors, 'salutation_id') }}
            </div>
        </div>

        <div class="form-group">
            <label for="last_name">Nom</label>
            <input required type="text" name="last_name" id="last_name"
                   class="form-control {{ inputValidationClass($errors, 'last_name') }}"
                   value="{{ old('last_name') ?? $teacher->last_name }}">
            <div class="invalid-feedback">
                {{ inputValidationMessages($errors, 'last_name') }}
            </div>
        </div>

        <div class="form-group">
            <label for="first_name">Prénom</label>
            <input required type="text" name="first_name" id="first_name"
                   class="form-control {{ inputValidationClass($errors, 'first_name') }}"
                   value="{{ old('first_name') ?? $teacher->first_name }}">
            <div class="invalid-feedback">
                {{ inputValidationMessages($errors, 'first_name') }}
            </div>
        </div>

        <div class="form-group">
            <label for="phone">Télephone</label>
            <input required type="text" name="phone" id="phone"
                   class="form-control {{ inputValidationClass($errors, 'phone') }}"
                   value="{{ old('phone') ?? $teacher->phone }}">
            <div class="invalid-feedback">
                {{ inputValidationMessages($errors, 'phone') }}
            </div>
            <small id="phone_help" class="form-text text-muted">Selon ce format: +352 621123456</small>
        </div>

        <div class="form-group">
            <label for="email">Adresse Email</label>
            <input required type="email" name="email" id="email"
                   class="form-control {{ inputValidationClass($errors, 'email') }}"
                   value="{{ old('email') ?? $teacher->user->email }}">
            <div class="invalid-feedback">
                {{ inputValidationMessages($errors, 'email') }}
            </div>
        </div>

        <input type="submit" class="btn btn-primary" value="Mettre à jour">

    </form>

@endsection