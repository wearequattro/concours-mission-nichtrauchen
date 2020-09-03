@extends('layouts.app-single-page')

@section('title', 'Quiz')

@section('content')

    <div class="row">
        <div class="col">

            <div class="card">
                <div class="card-body text-center">

                    <h1 class="dislpay-1">
                        {{ $quiz->name }}
                    </h1>

                    <h4 class="text-center mb-5">
                        Date de clôture : {{ $quiz->closes_at->format('d/m/Y') }}
                    </h4>

                    @if($assignment->isAnswered())

                        <h1>Vous avez déjà répondu au quiz</h1>
                        <h1>Votre score: {{ $assignment->response->score }} / {{ $quiz->max_score }}</h1>

                    @elseif($quiz->state == \App\Quiz::STATE_CLOSED)

                            <h1>Désolé, ce quiz est clôturé</h1>

                            @if(!$quiz->isLastQuiz())
                                <p class="lead">
                                    Vous aurez prochainement accès au nouveau quiz.
                                </p>
                            @endif

                            <h1 class="mt-5">Dieses Quiz ist abgeschlossen</h1>

                            @if(!$quiz->isLastQuiz())
                                <p class="lead">Sie erhalten demnächst Zugang zu einem neuen Quiz.</p>
                            @endif

                    @else

                        <h3>Sélectionner la langue</h3>

                        <h3>Wählen Sie die Sprache aus</h3>

                        <div class="row align-items-center justify-content-center mt-5 mb-5">
                            @foreach($codes as $code)
                                @php
                                    $qIL = $code->quizInLanguage;
                                @endphp
                                <div class="col col-lg-4">
                                    <a href="{{ route('external.quiz.redirect', [$code]) }}" class="btn btn-primary btn-block">
                                        {{ trans("language." . $qIL->language, [], $qIL->language) }}
                                    </a>
                                </div>
                            @endforeach
                        </div>

                    @endif

                </div>
            </div>
        </div>
    </div>

@endsection
