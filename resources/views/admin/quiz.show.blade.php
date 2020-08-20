@extends('layouts.app-sidebar')

@section('title', 'Quiz')

@section('content')
    <h1 class="display-4 text-center">Quiz</h1>

    @if(Session::has('message'))
        <div class="alert alert-success">
            {{ Session::get('message') }}
        </div>
    @endif

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
            @forelse($quizzes as $q)
                <tr>
                    <td>{{ $q->name }}</td>
                    <td>{{ $q->max_score }}</td>
                    <td>{{ $q->closes_at }}</td>
                    <td>
                        <a href="{{ route('admin.quiz', [$q]) }}" class="btn btn-primary">
                            <i class="fa fa-fw fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Aucun lycée disponible</td>
                </tr>
            @endforelse
            </tbody>
        </table>

    </div>
@endsection

@push('js')
    <script>
        $('table').dataTable({
            pageLength: 100,
        });
    </script>
@endpush
