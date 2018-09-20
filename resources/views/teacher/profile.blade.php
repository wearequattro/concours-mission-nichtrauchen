@extends('layouts.app-sidebar')

@section('title', 'Mon Profil')

@section('content')
<h1 class="display-4 text-center">Mise &agrave; jour de mon profil</h1>

@if(Session::has('message'))
    <div class="alert alert-success">
        {{ Session::get('message') }}
    </div>
@endif

<form method="post" action="{{ route('teacher.profile.post') }}">
    @csrf

    <div class="form-group">
        <label for="salutation_id">Titre</label>
        <select required name="salutation_id" id="salutation_id" class="form-control">
            @foreach($salutations as $s)
                <option value="{{ $s->id }}" {{ $s->id === $teacher->salutation_id ? 'selected': '' }}>{{ $s->long_form }}</option>
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
        <label for="first_name">Pr&eacute;nom</label>
        <input required type="text" name="first_name" id="first_name"
               class="form-control {{ inputValidationClass($errors, 'first_name') }}"
               value="{{ old('first_name') ?? $teacher->first_name }}">
        <div class="invalid-feedback">
            {{ inputValidationMessages($errors, 'first_name') }}
        </div>
    </div>

    <div class="form-group">
        <label for="email">Adresse e-mail</label>
        <input required type="text" name="email" id="email"
               class="form-control {{ inputValidationClass($errors, 'email') }}"
               value="{{ old('email') ?? $user->email }}">
        <div class="invalid-feedback">
            {{ inputValidationMessages($errors, 'email') }}
        </div>
    </div>

    <div class="form-group">
        <label for="phone">Num&eacute;ro de t&eacute;l&eacute;phone portable</label>
        <input required type="text" name="phone" id="phone"
               class="form-control {{ inputValidationClass($errors, 'phone') }}"
               value="{{ old('phone') ?? $teacher->phone }}" aria-describedby="phone_help">
        <div class="invalid-feedback">
            {{ inputValidationMessages($errors, 'phone') }}
        </div>
        <small id="phone_help" class="form-text text-muted">Selon ce format: +352 621123456</small>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" aria-describedby="password_help"
                       class="form-control {{ inputValidationClass($errors, 'password') }}">
                <div class="invalid-feedback">
                    {{ inputValidationMessages($errors, 'password') }}
                </div>
                <small id="password_help">
                    Si vous ne voulez pas changer votre mot de passe, laissez les champs vides.
                </small>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="password_confirmation">Confirmation mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="form-control {{ inputValidationClass($errors, 'password') }}">
            </div>
        </div>
    </div>

    <input type="submit" class="btn btn-primary" value="J'actualise mon profil">

</form>
@endsection