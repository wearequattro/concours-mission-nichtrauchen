@extends('layouts.app-sidebar')

@section('title', 'Classes')

@section('content')
    <h1 class="display-4 text-center">Classes</h1>

    @if(Session::has('message'))
        <div class="alert alert-success">
            {{ Session::get('message') }}
        </div>
    @endif

    <p>
        <a class="btn btn-primary" href="{{ route('admin.classes.export') }}">
            Export
        </a>
    </p>

            <div class="table-responsive">

                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>N° d'étudiants</th>
                        <th>Lycée</th>
                        <th>Enseignant</th>
                        <th>Status janvier</th>
                        <th>Status mars</th>
                        <th>Status mai</th>
                        <th>Status fête</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($classes as $class)
                        <tr>
                            <td>{{ $class->name }}</td>
                            <td>{{ $class->students }}</td>
                            <td>{{ $class->school->name }}</td>
                            <td>{{ $class->teacher->full_name }}</td>
                            <td>{{ statusToIcon($class->status_january ) }}</td>
                            <td>{{ statusToIcon($class->status_march ) }}</td>
                            <td>{{ statusToIcon($class->status_may ) }}</td>
                            <td>{{ statusToIcon($class->status_party ) }}</td>
                            <td>
                                <a href="{{ route('admin.classes.edit', [$class]) }}" class="btn btn-warning">
                                    <i class="fa fa-fw fa-pencil"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Aucun lycée disponible</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </div>
@endsection

@push('js')
    <script>
        $('table').dataTable();
    </script>
@endpush