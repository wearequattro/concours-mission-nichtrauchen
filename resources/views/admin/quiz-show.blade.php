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
                                <th>Nom</th>
                                <th>Max Score</th>
                                <th>Closes At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse([] as $q)
                                {{--                        <tr>--}}
                                {{--                            <td>{{ $q->name }}</td>--}}
                                {{--                            <td>{{ $q->max_score }}</td>--}}
                                {{--                            <td>{{ $q->closes_at }}</td>--}}
                                {{--                            <td>--}}
                                {{--                                <a href="{{ route('admin.quiz', [$q]) }}" class="btn btn-primary">--}}
                                {{--                                    <i class="fa fa-fw fa-eye"></i>--}}
                                {{--                                </a>--}}
                                {{--                            </td>--}}
                                {{--                        </tr>--}}
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Aucune réponse disponible</td>
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
