@extends('emails.layout')

@section("content")
    <p>Chers enseignants,</p>

    <p>Cet e-mail pour vous informer que le concours <i>Mission Nichtrauchen 2024-2025</i> est officiellement terminé.</p>

    <p>La persévérance et le dévouement de vos classes en valaient la peine, et nous vous remercions pour votre participation au concours. En tout, 143 classes du Luxembourg avec 2760 élèves ont participé à cette édition, qui a donc été, grâce à vous, un grand succès !</p>

    <p>Vous trouverez dans votre espace personnel, sous ce <a href="{{ route('certificate.page', ['uid' => $certificate->uid]) }}">lien</a>, votre certificat de participation.</p>

    <p>Nous avons également le plaisir d’annoncer les trois classes gagnantes de cette année, que nous félicitons très chaleureusement :</p>

    <ul>
        <li> 1<sup>er</sup> prix – 1 000 € :  la classe <i>5C8</i> de l’<i>Athénée Luxembourg </i> (enseignante : Laurence Waltzing)</li>
        <li> 2<sup>ème</sup> prix – 500 € : la classe <i>5C4</i> du lycée <i>Lycée Robert-Schuman Luxembourg</i> (enseignante : Michèle Steines)</li>
        <li> 3<sup>ème</sup> prix – 250 € : la classe <i>7C</i> du <i>Nordstad Lycée</i> (enseignant : Pit Ullmann)</li>
    </ul>

    <p>Pour tous ceux qui ont été présents à la fête de clôture hier, qui a été une réussite éclatante grâce à votre engagement, les solutions des stations quiz sont désormais disponibles dans <a href="https://concours.missionnichtrauchen.lu/login" target="_blank">espace personnel</a>.</p>

    <p>Et ne manquez pas non plus de découvrir les photos de l’événement sur le site internet : <a href="https://missionnichtrauchen.lu/medias" target="_blank">https://missionnichtrauchen.lu/medias</a></p>

    <p>En attendant, nous vous souhaitons une agréable fin d’année scolaire et nous vous donnons d’ores et déjà rendez-vous pour l’édition 2025-2026 du concours <i>Mission Nichtrauchen</i> !</p>

    <p>Mat beschte Gréiss,</p>

    <p>D’Ekipp vun der Fondation Cancer</p>
@endsection
