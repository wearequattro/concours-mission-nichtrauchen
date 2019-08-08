@extends('layouts.frontend')

@section('title', 'Login')

@section('content')
    <h1 class="display-4 text-center">Login</h1>
    <div class="col-sm-6 offset-sm-3">

        <form class="text-center mt-4" method="post" action="{{ route('login.post') }}">
            @csrf

            <div class="form-group mt-4 text-left">
                <label for="email">Adresse e-mail</label>
                <input required type="email" name="email" id="email"
                       class="form-control {{ inputValidationClass($errors, 'email') }}"
                       value="{{ old('email') }}">
                <div class="invalid-feedback">
                    {{ inputValidationMessages($errors, 'email') }}
                </div>
            </div>

            <div class="form-group text-left">
                <label for="password">Mot de passe</label>
                <input required type="password" name="password" id="password"
                       class="form-control {{ inputValidationClass($errors, 'password') }}"
                       value="{{ old('password') }}">
                <div class="invalid-feedback">
                    {{ inputValidationMessages($errors, 'password') }}
                </div>
            </div>

            <div class="form-group text-left ml-4">
                <input type="checkbox" name="remember" id="remember"
                       class="custom-control-input" {{ old('remember') != null ? 'checked' : '' }}>
                <label for="remember" class="custom-control-label">Se souvenir de moi</label>
            </div>


            <div class="form-group">
                <input type="submit" class="btn btn-block btn-lg btn-primary" value="Je me connecte">
            </div>

            <div>
                <p>
                    <a href="{{ route('login.password.recover') }}">Mot de passe oubli&eacute; ?</a>
                </p>
            </div>

        </form>

    </div>
@endsection
