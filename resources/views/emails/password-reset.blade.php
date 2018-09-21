@extends('emails.layout')

@section("content")
    <p>Récupération de votre mot de passe pour &laquo;Mission Nichtrauchen&raquo;</p>
    <p>
        Vous avez demandé pour réinitialiser votre mot de passe. Si vous n'avez pas demandé un nouveau mot de passe,
        vous pouvez ignorer cette email.
    </p>
    <p>
        <a href="{{ route('login.password.reset', [$token]) }}">Réinitialiser mon mot de passe</a>
    </p>
@endsection