@extends('emails.layout')

@section("content")
    <p>Merci d'avoir participer</p>

    <p>
        <a href="{{ route('admin.certificates.download', [$certificate]) }}">télécharger certificat</a>
    </p>
@endsection
