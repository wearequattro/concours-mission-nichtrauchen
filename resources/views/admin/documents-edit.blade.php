@extends('layouts.app-sidebar')

@section('title', 'Documents')

@section('content')
    <h1 class="text-center"><span class="display-5">Mise à jour document</span> <span class="text-muted">{{ $document->title }}</span></h1>

    @if(Session::has('message'))
        <div class="alert alert-success">
            {{ Session::get('message') }}
        </div>
    @endif

    <form action="{{ route('admin.documents.update', [$document]) }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="title">Nom du fichier</label>
            <input required type="text" name="title" id="title"
                   class="form-control {{ inputValidationClass($errors, 'title') }}"
                   value="{{ old('title') ?? $document->title }}">
            <div class="invalid-feedback">
                {{ inputValidationMessages($errors, 'title') }}
            </div>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" name="description" id="description"
                   class="form-control {{ inputValidationClass($errors, 'description') }}"
                   value="{{ old('description') ?? $document->description }}">
            <div class="invalid-feedback">
                {{ inputValidationMessages($errors, 'description') }}
            </div>
        </div>

        <input type="submit" class="btn btn-primary" value="Mettre à jour">

    </form>
@endsection

