@extends('layouts.app-sidebar')

@section('title', 'Ajouter un utilisateur')

@section('content')
    <h1 class="display-5 text-center">
        Ajouter un utilisateur administratif
    </h1>

    <form method="post" action="{{ route('admin.users.add.post') }}">
        @csrf

        <div class="form-group">
            <label for="email">E-mail</label>
            <input required type="email" name="email" id="email"
                   class="form-control {{ inputValidationClass($errors, 'email') }}"
                   value="{{ old('email') }}">
            <div class="invalid-feedback">
                {{ inputValidationMessages($errors, 'email') }}
            </div>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input required type="password" name="password" id="password"
                   class="form-control {{ inputValidationClass($errors, 'password') }}">
            <div class="invalid-feedback">
                {{ inputValidationMessages($errors, 'password') }}
            </div>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmation du mot de passe</label>
            <input required type="password" name="password_confirmation" id="password_confirmation"
                   class="form-control {{ inputValidationClass($errors, 'password') }}">
        </div>

        <input type="submit" class="btn btn-primary" value="Ajouter">

    </form>

@endsection