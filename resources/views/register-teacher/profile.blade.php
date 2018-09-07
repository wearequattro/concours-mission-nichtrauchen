@extends('layouts.app-sidebar')

@section('title', 'Mon Profil')

@section('content')
<h1 class="display-4 text-center">Mise &agrave; jour de mon Profil</h1>

@if(Session::has('message'))
    <div class="alert alert-success">
        {{ Session::get('message') }}
    </div>
@endif

<form method="post" action="{{ route('teacher.profile.post') }}">
    @csrf

    <div class="form-group">
        <label for="teacher_salutation">Titre</label>
        <select required name="teacher_salutation" id="teacher_salutation" class="form-control">
            @foreach($salutations as $s)
                <option value="{{ $s->id }}" {{ $s->id === $teacher->salutation_id ? 'selected': '' }}>{{ $s->long_form }}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            {{ inputValidationMessages($errors, 'teacher_salutation') }}
        </div>
    </div>

    <div class="form-group">
        <label for="teacher_last_name">Nom</label>
        <input required type="text" name="teacher_last_name" id="teacher_last_name"
               class="form-control {{ inputValidationClass($errors, 'teacher_last_name') }}"
               value="{{ old('teacher_last_name') ?? $teacher->last_name }}">
        <div class="invalid-feedback">
            {{ inputValidationMessages($errors, 'teacher_last_name') }}
        </div>
    </div>

    <div class="form-group">
        <label for="teacher_first_name">Pr&eacute;nom</label>
        <input required type="text" name="teacher_first_name" id="teacher_first_name"
               class="form-control {{ inputValidationClass($errors, 'teacher_first_name') }}"
               value="{{ old('teacher_first_name') ?? $teacher->first_name }}">
        <div class="invalid-feedback">
            {{ inputValidationMessages($errors, 'teacher_first_name') }}
        </div>
    </div>

    <div class="form-group">
        <label for="teacher_email">Adresse Email</label>
        <input required type="text" name="teacher_email" id="teacher_email"
               class="form-control {{ inputValidationClass($errors, 'teacher_email') }}"
               value="{{ old('teacher_email') ?? $user->email }}">
        <div class="invalid-feedback">
            {{ inputValidationMessages($errors, 'teacher_email') }}
        </div>
    </div>

    <div class="form-group">
        <label for="teacher_phone">Num&eacute;ro de T&eacute;l&eacute;phone</label>
        <input required type="text" name="teacher_phone" id="teacher_phone"
               class="form-control {{ inputValidationClass($errors, 'teacher_phone') }}"
               value="{{ old('teacher_phone') ?? $teacher->phone }}" aria-describedby="phone_help">
        <div class="invalid-feedback">
            {{ inputValidationMessages($errors, 'teacher_phone') }}
        </div>
        <small id="phone_help" class="form-text text-muted">Selon ce format: +352 621123456</small>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="teacher_password">Mot de passe</label>
                <input type="password" name="teacher_password" id="teacher_password" aria-describedby="password_help"
                       class="form-control {{ inputValidationClass($errors, 'teacher_password') }}">
                <div class="invalid-feedback">
                    {{ inputValidationMessages($errors, 'teacher_password') }}
                </div>
                <small id="password_help">
                    Si vous ne voulez pas changer votre mot de passe, laisser les champs vides.
                </small>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="teacher_password_confirmation">Confirmation mot de passe</label>
                <input type="password" name="teacher_password_confirmation" id="teacher_password_confirmation"
                       class="form-control {{ inputValidationClass($errors, 'teacher_password') }}">
            </div>
        </div>
    </div>

    <input type="submit" class="btn btn-primary" value="Actualiser">

</form>
@endsection