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
        <div class="col-4">
            <a class="btn btn-success" href="{{ route('admin.quiz.create') }}">
                <i class="fa fa-fw fa-plus"></i> Crééer Quiz
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mt-2">

            <div class="table-responsive">

                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Max Score</th>
                        <th>Réponses</th>
                        <th>Closes At</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($quizzes as $q)
                        <tr>
                            <td>{{ $q->name }}</td>
                            <td>{{ $q->max_score }}</td>
                            <td>24</td>
                            <td>{{ $q->closes_at }}</td>
                            <td>
                                <a href="{{ route('admin.quiz.show', [$q]) }}" class="btn btn-primary">
                                    <i class="fa fa-fw fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Aucun quiz disponible</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

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
