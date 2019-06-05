@extends('layouts.app-sidebar')

@section('title', 'Certificates')

@section('content')
    <h1 class="display-4 text-center">Certificates</h1>

    @if(Session::has('message'))
        <div class="alert alert-success">
            {{ Session::get('message') }}
        </div>
    @endif

    <div class="row">

        <div class="col-12 col-sm-6 col-xl-3 mb-4">
            <div class="card">
                <div class="card-header">
                    Exporter fichier des classes
                </div>
                <div class="card-body">
                    <a class="btn btn-primary btn-block" href="{{ route('admin.certificates.generate.all') }}">
                        <i class="fa fa-refresh"></i> Générer les certificats
                    </a>
                    <br>
                    Génère des certificats pour toutes les classes éligibles, même si elles ont déjà un certificat.
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3 mb-4">
            <div class="card">
                <div class="card-header">
                    Statistiques
                </div>
                <div class="card-body">
                    <span class="badge badge-primary text-white">{{ $classes->count() }}</span>
                    classes sont éligibles pour recevoir un certificat.
                </div>
            </div>
        </div>

    </div>

            <div class="table-responsive">

                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>N° d'étudiants</th>
                        <th>Lycée</th>
                        <th>Enseignant titre</th>
                        <th>Enseignant prénom</th>
                        <th>Enseignant nom</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($classes as $class)
                        <tr>
                            <td>{{ $class->name }}</td>
                            <td>{{ $class->students }}</td>
                            <td>{{ $class->school->name }}</td>
                            <td>{{ $class->teacher->salutation->long_form }}</td>
                            <td>{{ $class->teacher->first_name }}</td>
                            <td>{{ $class->teacher->last_name }}</td>
                            <td>
                                @php($cert = $class->certificate()->exists())
                                <div class="btn-group pull-right">
                                    <a href="{{ route('admin.certificates.download', [$class->certificate]) }}" class="btn btn-info text-white {{ !$cert ? 'disabled' : '' }}">
                                        <i class="fa fa-fw fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.certificates.generate', [$class]) }}" class="btn btn-primary">
                                        <i class="fa fa-fw fa-refresh"></i>
                                    </a>
                                    <a href="{{ route('admin.certificates.delete', [$class->certificate]) }}" class="btn btn-danger {{ !$cert ? 'disabled' : '' }}">
                                        <i class="fa fa-fw fa-trash-o"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">Aucune classe n'est enregistr&eacute;e</td>
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
            order: [
                [2, 'asc'],
                [5, 'asc'],
            ],
        });
    </script>
@endpush