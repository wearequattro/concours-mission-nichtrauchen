@extends('layouts.app-sidebar')

@section('title', 'Emails')

@section('content')
    <h1 class="display-4 text-center">E-mails</h1>

    @if(Session::has('message'))
        <div class="alert alert-success">
            {{ Session::get('message') }}
        </div>
    @endif

    <div class="table-responsive">

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Sujet</th>
                <th>Date d'envoi</th>
                <th>Aper&ccedil;u du texte</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($emails as $email)
                <tr>
                    <td>{{ $email->subject }}</td>
                    <td>{{ $email->dates_string }}</td>
                    <td>{{ \Illuminate\Support\Str::words(html_entity_decode(strip_tags($email->text)), 15) }}</td>
                    <td>
                        <a href="{{ route('admin.emails.edit', [$email]) }}" class="btn btn-primary">
                            <i class="fa fa-fw fa-pencil"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Aucune email disponible</td>
                </tr>
            @endforelse
            </tbody>
        </table>

    </div>
@endsection
