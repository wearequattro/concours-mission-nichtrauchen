@extends('emails.layout')

@section("content")
    <h3> {{$teacher->getFullNameAttribute()}} </h3>

    <p>Pour cette édition, 109 classes du Luxembourg ont participé avec 2 027 élèves.</p>
    <p>Nous avons ainsi le plaisir de vous annoncer les 4 gagnants de cette année :</p>
    <ul>
        <li> 1er prix – 1 000 € : la classe 5CCL2 du Lycée Josy Barthel Mamer (enseignante : Mme Dominique Schmit)
        </li>
        <li> 2ème prix – 500 € : la classe 7C6 du Lycée Ermesinde (enseignante : Mme Justine Godziewski)
        </li>
        <li> 3ème prix – 250 € : la classe LNBD du Lycée Nic-Biever (enseignante : Mme Martine Linden) ex aequo avec la classe 6C3 du Lycée Josy Barthel
            Mamer (enseignante : Mme Dominique Schmit)
        </li>
    </ul>


    <p>La persévérance et le dévouement de vos classes en valaient la peine, et nous vous remercions d’avoir participé avec succès au concours Mission
        Nichtrauchen 2020-2021 !</p>

    <p>En pièce jointe, vous trouverez votre <a href="{{ route('admin.certificates.download', [$certificate]) }}">certification de participation</a>.</p>

    <p>En attendant, nous vous souhaitons une agréable fin d’année scolaire et nous vous donnons d’ores et déjà rendez-vous pour l’édition 2021/2022 du
        concours
        Mission Nichtrauchen, en espérant pouvoir enfin se retrouver en présentiel !</p>

    <p>Prenez soin de vous et de vos proches.</p>

    <p>Bien à vous,</p>

    <p>L’équipe Fondation Cancer</p>
@endsection
