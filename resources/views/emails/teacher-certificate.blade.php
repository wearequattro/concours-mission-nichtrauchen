@extends('emails.layout')

@section("content")
    <p> {{$teacher->getFullNameAttribute()}}, </p>

    <p>Cet e-mail pour vous informer que l'édition 2022-2023 du concours de la Mission Nichtrauchen est officiellement terminée.</p>
    <p>163 classes du Luxembourg avec 2973 élèves ont participé à cette édition, qui a donc été, grâce à vous, un grand succès !</p>
    <p>Nous avons ainsi le plaisir de vous annoncer les 3 gagnants de cette année :</p>
    <ul>
        <li> 1<sup>er</sup> prix – 1 000 € : la classe 5CCL2 du Lycée Josy Barthel Mamer (enseignante : Mme Dominique Schmit)
        </li>
        <li> 2<sup>ème</sup> prix – 500 € : la classe 7C6 du Lycée Ermesinde (enseignante : Mme Justine Godziewski)
        </li>
        <li> 3<sup>ème</sup> prix – 250 € : la classe LNBD du Lycée Nic-Biever (enseignante : Mme Martine Linden) ex aequo avec la classe 6C3 du Lycée Josy Barthel
            Mamer (enseignante : Mme Dominique Schmit)
        </li>
    </ul>

    <p>La persévérance et le dévouement de vos classes en valaient la peine, et nous vous remercions d'avoir participé au concours Mission Nichtrauchen 2022-2023 !</p>

    <p>Vous trouverez votre certificat de participation sous ce <a href="{{ route('certificate.page', ['uid' => $certificate->uid]) }}">lien</a>.</p>

    <p>Ne manquez pas non plus de découvrir les photos de la fête de clôture sur le site internet : <a href="https://missionnichtrauchen.lu/medias" target="_blank">https://missionnichtrauchen.lu/medias</a></p>

    <p>En attendant, nous vous souhaitons une agréable fin d'année scolaire et nous vous donnons d'ores et déjà rendez-vous pour l'édition 2023-2024 du concours Mission Nichtrauchen !</p>

    <p>Mat beschte Gréiss,</p>
    <p>D'Ekipp vun der Fondation Cancer</p>
@endsection
