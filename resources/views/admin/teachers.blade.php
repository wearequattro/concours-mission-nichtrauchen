@extends('layouts.app-sidebar')

@section('title', 'Enseignants')

@section('content')
    <h1 class="display-4 text-center">Enseignants</h1>

    @if(Session::has('message'))
        <div class="alert alert-success">
            {{ Session::get('message') }}
        </div>
    @endif

            <div class="table-responsive">

                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Téléphone</th>
                        <th>Adresse Email</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($teachers as $teacher)
                        <tr>
                            <td>{{ $teacher->salutation->long_form }}</td>
                            <td>{{ $teacher->first_name }}</td>
                            <td>{{ $teacher->last_name }}</td>
                            <td>{{ $teacher->phone }}</td>
                            <td>{{ $teacher->user->email }}</td>
                            <td>
                                <a href="{{ route('admin.teachers.edit', [$teacher]) }}" class="btn btn-warning">
                                    <i class="fa fa-fw fa-pencil"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Aucun lycée disponible</td>
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