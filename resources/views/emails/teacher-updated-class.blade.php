@extends('emails.layout')

@section("content")
    <p>L'enseignant <u>{{ $teacher->full_name }}</u> a changé une classe</p>
    <p>
        <strong>Nom de la classe :</strong><br>
        Précédemment : {{ $old['name'] }}<br>
        Nouvelle valeur : {{ $new['name'] }}
    </p>
    <p>
        <strong>Nombre d'étudiants :</strong><br>
        Précédemment : {{ $old['students'] }}<br>
        Nouvelle valeur : {{ $new['students'] }}
    </p>
@endsection