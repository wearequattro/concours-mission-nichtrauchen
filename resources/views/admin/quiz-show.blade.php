@extends('layouts.app-sidebar')

@section('title', 'Quiz')

@section('content')
    <h1 class="display-4 text-center">Quiz</h1>

    @if(Session::has('message'))
        <div class="alert alert-success">
            {{ Session::get('message') }}
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-12">
                            <h2 class="text-center">
                                {{ $quiz->name }}
                            </h2>
                            <p>
                                Score Maximal: {{ $quiz->max_score }}<br>
                                @foreach($quiz->quizInLanguage as $ql)
                                    <a href="{{ $ql->url }}">
                                        <img style="height: 0.8em; width: auto;" src="{{ asset('/images/flags/' . $ql->language . '.svg') }}" alt="flag {{ $ql->language }}">
                                        {{ $ql->url }}
                                        <br>
                                    </a>
                                @endforeach
                            </p>

                            @if(!$quiz->quizInLanguage->filter(fn ($ql) => $ql->hasEnoughCodes())->count() > 0)
                                <p>
                                    Ce quiz n'a pas assez de codes uniques enregistrés pour que tous les classes puissent avoir un.
                                    <br>
                                    <a class="btn btn-primary" href="{{ route('admin.quiz.show.codes', [$quiz]) }}">
                                        Ajouter les codes
                                    </a>
                                </p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mt-4">

            <div class="card">
                <div class="card-header">
                    Réponses
                </div>
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Nom classe</th>
                                <th>Nom enseignant</th>
                                <th>Points</th>
                                <th>Date répondue</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($quiz->assignments as $a)
                                <tr>
                                    <td>{{ $a->schoolClass->name }}</td>
                                    <td>{{ $a->schoolClass->teacher->full_name }}</td>
                                    <td>{{ optional($a->response)->score }}</td>
                                    <td>{{ optional($a->response)->responded_at }}</td>
                                    <td></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Aucune réponse disponible</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@push('js')
    <script>
        $('table').dataTable({
            pageLength: 100,
        });
    </script>
@endpush
