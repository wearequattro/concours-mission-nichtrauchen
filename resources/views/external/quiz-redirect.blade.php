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
                        Date de clôturation : {{ $quiz->closes_at->format('Y-m-d') }}
                    </h4>

                    @if($assignment->isAnswered())

                        <h1>Vous avez déjà répondu au quiz</h1>
                        <h1>Votre score: {{ $assignment->response->score }} / {{ $quiz->max_score }}</h1>

                    @elseif($quiz->state == \App\Quiz::STATE_CLOSED)

                        <h1>Désolé, le quiz est clôturé</h1>

                    @else

                        <h3>Sélectionnez votre langue préférée du quiz</h3>

                        <div class="row align-items-center justify-content-center mt-5 mb-5">
                            @foreach($codes as $code)
                                @php
                                    $qIL = $code->quizInLanguage;
                                @endphp
                                <div class="col col-lg-4">
                                    <a href="{{ route('external.quiz.redirect', [$code]) }}">
                                        <div class="card">
                                            <div class="card-body">
                                                <img src="{{ asset("images/flags/$qIL->language.svg") }}"
                                                     alt="Flag {{ $qIL->language }}">
                                            </div>
                                        </div>
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
