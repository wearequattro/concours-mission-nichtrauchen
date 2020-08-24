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
                            Score Maximal: {{ $quiz->max_score }}
                            <hr>
                        </div>

                        @foreach($quiz->quizInLanguage as $ql)
                        <div class="col">
                            <p>
                                <a href="{{ $ql->url }}">
                                    <img src="{{ asset('images/flags/' . $ql->language . '.png') }}" alt="flag {{ $ql->language }}">
                                    {{ $ql->url }}
                                </a>
                                <br>
                                {{ $ql->responses()->count() }} réponses
                            </p>
                        </div>
                        @endforeach
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
                                <th>Langue répondue</th>
                                <th>Points</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($responses as $r)
                                <tr>
                                    <td>{{ $r->assignment->schoolClass->name }}</td>
                                    <td>{{ $r->assignment->schoolClass->teacher->full_name }}</td>
                                    <td>{{ $r->assignment->quizInLanguage->language }}</td>
                                    <td>{{ $r->score }}</td>
                                    <td>{{ $r->created_at }}</td>
                                    <td></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Aucune réponse disponible</td>
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
