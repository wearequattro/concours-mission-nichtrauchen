@extends('layouts.app')

@section('title', 'Quiz')

@section('content')
    <h1 class="display-4 text-center">Quiz</h1>

    @if(Session::has('message'))
        <div class="alert alert-success">
            {{ Session::get('message') }}
        </div>
    @endif

    <div class="row">
        <div class="col">
            <h1 class="dislpay-1 text-center">
                {{ $quiz->name }}
            </h1>
            <h4 class="text-center">
                Date de clôturation : {{ $quiz->closes_at->format('Y-m-d') }}
            </h4>
        </div>
    </div>

    @if($assignment->isAnswered())

        <div class="row">
            <div class="col mt-5 mb-5 text-center">

                <h1>Vous avez déjà répondu au quiz</h1>
                <h1>Votre score: {{ $assignment->response->score }} / {{ $quiz->max_score }}</h1>

            </div>
        </div>

    @else

        <div class="row align-items-center justify-content-center mt-5 mb-5">
            @foreach($codes as $code)
                @php
                    $qIL = $code->quizInLanguage;
                @endphp
                <div class="col col-lg-4">
                    <a href="{{ $code->quiz_maker_url }}">
                        <div class="card">
                            <div class="card-body">
                                <img src="{{ asset("images/flags/$qIL->language.svg") }}" alt="Flag {{ $qIL->language }}">
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

    @endif

@endsection

@push('js')

@endpush
