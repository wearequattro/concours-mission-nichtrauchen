@extends('layouts.app-sidebar')

@section('title', 'Inscription Fête de clôture')

@section('content')
    <h1 class="display-4 text-center">Inscription Fête de clôture</h1>

    <form action="{{ route('party.class.post', [$class]) }}" method="post">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 mt-4 mb-2">
                <div class="card bg-light">
                    <div class="card-body">
                        <h3>
                            Classe {{ $class->name }}
                            <small class="text-muted text">{{ $class->school->name }}</small>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @php($i = 0)
            @foreach ($groups as $numStudents)

                <div class="col-xs-12 col-sm-6 col-lg-4 mb-2">
                    <div class="card">
                        <div class="card-body">

                            <div class="form-group">
                                <label for="name_{{ $i }}">Nom du groupe</label>
                                <input required type="text" name="class[{{ $i }}][name]" id="name_{{ $i }}"
                                       class="form-control {{ inputValidationClass($errors, 'class.' . $i . '.name') }}"
                                       value="{{ old('class.' . $i . '.name') }}">
                                <div class="invalid-feedback">
                                    {{ inputValidationMessages($errors, 'class.' . $i . '.name') }}
                                </div>
                                <small id="name_help">
                                    Le nom choisi doit avoir un rapport avec la santé.
                                </small>
                            </div>

                            <div class="form-group">
                                <label for="students_{{ $i }}">Nombre d'élèves</label>
                                <input required type="number" name="class[{{ $i }}][students]" id="students_{{ $i }}"
                                       class="form-control {{ inputValidationClass($errors, 'class.' . $i . '.students') }}"
                                       value="{{ old('class.' . $i . '.students') ?? $numStudents }}">
                                <div class="invalid-feedback">
                                    {{ inputValidationMessages($errors, 'class.' . $i . '.students') }}
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="language_{{ $i }}">Langue souhaitée pour le questionnaire du rallye des
                                    élèves</label>
                                <select required type="text" name="class[{{ $i }}][language]" id="language_{{ $i }}"
                                        class="form-control {{ inputValidationClass($errors, 'class.' . $i . '.language') }}">
                                    <option value="DE" {{ old('class.' . $i . '.language') === 'DE' ? 'selected' : '' }}>DE</option>
                                    <option value="FR" {{ old('class.' . $i . '.language') === 'FR' ? 'selected' : '' }}>FR</option>
                                </select>
                                <div class="invalid-feedback">
                                    {{ inputValidationMessages($errors, 'class.' . $i . '.language') }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                @php($i++)
            @endforeach
        </div>
        <div class="row">
            <div class="col-2">
                <input type="submit" class="btn btn-primary btn-lg btn-block" value="Inscrire">
            </div>
        </div>
    </form>


@endsection