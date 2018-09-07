@extends('layouts.app')

@section('content')
    <div class="col-sm-6 offset-3">

        <form class="text-center mt-4" method="post" action="{{ route('login.post') }}">
            @csrf
            <h1>Login &laquo;Mission Nichtrauchen&raquo;</h1>

            <div class="form-group mt-4">
                <label for="email">Adresse Email</label>
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
                       class="form-control {{ inputValidationClass($errors, 'password') }}"
                       value="{{ old('password') }}">
                <div class="invalid-feedback">
                    {{ inputValidationMessages($errors, 'password') }}
                </div>
            </div>
            

            <div class="form-group">
                <input type="submit" class="btn btn-block btn-lg btn-primary" value="Connecter">
            </div>

            <div>
                <p>
                    <a href="{{ route('login.password.recover') }}">Mot de passe oubli&eacute;?</a>
                </p>
            </div>

        </form>

    </div>
@endsection
