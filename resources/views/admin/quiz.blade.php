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
        <div class="col">
            <a class="btn btn-primary" href="{{ route('admin.quiz.create') }}">
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
                        <th>Statut</th>
                        <th>Date de clôturation</th>
                        <th>Date de clôturation</th>
                        <th>Créée</th>
                        <th>Créée</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($quizzes as $q)
                        <tr>
                            <td>{{ $q->name }}</td>
                            <td>{{ $q->max_score }}</td>
                            <td>{{ $q->responses()->count() }}</td>
                            <td>
                                <span class="badge badge-pill badge-{{ $q->stateColor() }}">
                                    {{ __("quiz.state.$q->state") }}
                                </span>
                            </td>
                            <td>{{ $q->closes_at->format('Y-m-d') }}</td>
                            <td>{{ $q->closes_at->format('U') }}</td>
                            <td>{{ $q->created_at }}</td>
                            <td>{{ $q->created_at->format('U') }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.quiz.show', [$q]) }}" class="btn btn-secondary">
                                        <i class="fa fa-fw fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.quiz.edit', [$q]) }}" class="btn btn-primary">
                                        <i class="fa fa-fw fa-pencil"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Aucun quiz disponible</td>
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
            order: [
                [4, 'desc'],
            ],
            columnDefs: [
                { targets: 4, orderData: [5] },
                { targets: 5, visible: false },

                { targets: 6, orderData: [7] },
                { targets: 7, visible: false },
            ],
        });
    </script>
@endpush
