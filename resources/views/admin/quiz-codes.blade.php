@extends('layouts.app-sidebar')

@section('title', 'Quiz')

@section('content')
    <h1 class="display-4 text-center">Quiz</h1>

    @if(Session::has('message'))
        <div class="alert alert-success">
            {{ Session::get('message') }}
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-12 col-xl-10" style="max-width: 918px">
            <div class="card">
                <div class="card-body">
                    <p class="lead text-center">
                        Vidéo explicative qui montre la génération des codes pour un quiz.
                    </p>
                    <video class="embed-responsive" controls>
                        <source src="{{ asset('/images/6GQjmsEYEo.mp4') }}" type="video/mp4">
                    </video>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.quiz.show.codes.post', [$quiz]) }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="row mt-5">
        @foreach($languages as $lang)
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h1>
                            <img class="d-inline" style="max-height: 1em; width: auto;" src="{{ asset("/images/flags/$lang.svg") }}" alt="flag {{ $lang }}">
                            {{ $lang }}
                        </h1>

                        Vous devez générer au moins {{ $quiz->assignments()->count() }} codes uniques pour ce quiz.

                        <div class="form-group">
                            <label for="files[{{ $lang }}]">Sélectionnez le fichier avec les codes</label>
                            <div class="custom-file">
                                <input type="file"
                                       class="custom-file-input {{ inputValidationClass($errors, "files.$lang") }}"
                                       id="files[{{ $lang }}]"
                                       name="files[{{ $lang }}]"
                                       required
                                >
                                <label class="custom-file-label" for="files[{{ $lang }}]">Choose file</label>
                                <div class="invalid-feedback">
                                    {{ inputValidationMessages($errors, "files.$lang") }}
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        @endforeach
        </div>

        <div class="row">
            <div class="col mt-5">
                <input type="submit" class="btn btn-success btn-block btn-lg" value="Ajouter">
            </div>
        </div>

    </form>

    <div style="height: 200px">
        <!-- spacer -->
    </div>

@endsection

@push('js')

@endpush
