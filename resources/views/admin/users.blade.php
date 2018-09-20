@extends('layouts.app-sidebar')

@section('title', 'Utilisateurs administratifs')

@section('content')
    <h1 class="display-4 text-center">Utilisateurs administratifs</h1>

    @if(Session::has('message'))
        <div class="alert alert-success">
            {{ Session::get('message') }}
        </div>
    @endif

    <div class="col-sm-6 mb-2">
        <div class="card">
            <div class="card-header">
                Ajoutez un utilisateur
            </div>
            <div class="card-body">
                <p class="card-text">
                    Ajoutez un utilisateur qui aura accès à toutes les fonctions administratives.
                </p>
                <a href="{{ route('admin.users.add') }}" class="card-link btn btn-primary">
                    Je veux ajouter un utilisateur
                </a>
            </div>
        </div>
    </div>

    <div class="table-responsive">

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Email</th>
            </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->email }}</td>
                </tr>
            @empty
                <tr>
                    <td class="text-center">Aucun utilisateur disponible</td>
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