@extends('layouts.app-single-page')

@section('title', 'Suivi')

@section('content')

    <div class="card">
        <div class="card-body">
            <p class="text-center lead pt-3">

                @if($status === false)
                    Votre classe {{ $class->name }} ne participera pas à la fête de clôture.<br>
                    Nous vous remercions pour votre engagement tout au long du concours et nous espérons pouvoir
                    vous retrouver parmi les enseignants participant à l’année prochaine.
                @endif

                @if($status === true)
                    Félicitations, votre classe {{ $class->name }} est toujours non-fumeur et vous continuez à
                    participer au concours Mission Nichtrauchen.
                @endif

            </p>
        </div>
    </div>

@endsection
