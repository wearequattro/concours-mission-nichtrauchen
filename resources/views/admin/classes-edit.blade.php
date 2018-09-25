@extends('layouts.app-sidebar')

@section('title', 'Mise à jour classe')

@section('content')
    <h1 class="text-center">
        <span class="display-5">Mise à jour</span> <span class="text-muted">&laquo; {{ $class->name }} {{ $class->school->name }} &raquo;</span>
    </h1>

    <!-- Delete Modal -->
    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDeleteTitle">Supprimer &laquo;{{ $class->name }}&raquo; ?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Attention, cette action est irréversible ! Si cette classe est déjà enregistrée pour la fête de
                    clôture, les inscriptions sont aussi supprimées.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn" data-dismiss="modal">Fermer</button>
                    <a class="btn btn-danger text-white" href="{{ route('admin.classes.delete', [$class]) }}">
                        <i class="fa fa-trash-o"></i>
                        Supprimer
                    </a>
                </div>
            </div>
        </div>
    </div>

    <form method="post" action="{{ route('admin.classes.edit.post', [$class]) }}">
        @csrf

        <div class="form-group">
            <label for="name">Nom</label>
            <input required type="text" name="name" id="name"
                   class="form-control {{ inputValidationClass($errors, 'name') }}"
                   value="{{ old('name') ?? $class->name }}">
            <div class="invalid-feedback">
                {{ inputValidationMessages($errors, 'name') }}
            </div>
        </div>

        <div class="form-group">
            <label for="students">Étudiants</label>
            <input required type="number" name="students" id="students" min="1" max="99"
                   class="form-control {{ inputValidationClass($errors, 'students') }}"
                   value="{{ old('students') ?? $class->students }}">
            <div class="invalid-feedback">
                {{ inputValidationMessages($errors, 'students') }}
            </div>
        </div>

        <div class="form-group">
            <label for="school_id">Lycée</label>
            <select class="form-control" required name="school_id" id="school_id">
                @foreach($schools as $school)
                    <option value="{{ $school->id }}" {{ $class->school_id === $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">
                {{ inputValidationMessages($errors, 'school_id') }}
            </div>
        </div>

        <div class="form-group">
            <label for="teacher_id">Enseignant</label>
            <select class="form-control" required name="teacher_id" id="teacher_id">
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ $class->teacher_id === $teacher->id ? 'selected' : '' }}>{{ $teacher->full_name }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">
                {{ inputValidationMessages($errors, 'teacher_id') }}
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">

                <div class="form-group">
                    <label for="status_january">Status janvier</label>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="status_january_null" name="status_january" class="custom-control-input" value="" {{ $class->status_january === null ? 'checked' : '' }}>
                        <label class="custom-control-label" for="status_january_null">
                            <i class="fa fa-fw fa-circle text-info"></i> Pas de réponse
                        </label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="status_january_yes" name="status_january" class="custom-control-input" value="1" {{ $class->status_january === 1 ? 'checked' : '' }}>
                        <label class="custom-control-label" for="status_january_yes">
                            <i class="fa fa-fw fa-check-circle text-success"></i> Réponse positive
                        </label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="status_january_no" name="status_january" class="custom-control-input" value="0" {{ $class->status_january === 0 ? 'checked' : '' }}>
                        <label class="custom-control-label" for="status_january_no">
                            <i class="fa fa-fw fa-times-circle text-danger"></i> Réponse négative
                        </label>
                    </div>
                    <div class="invalid-feedback">
                        {{ inputValidationMessages($errors, 'status_january') }}
                    </div>
                </div>

            </div>
            <div class="col-sm-4">
                
                <div class="form-group">
                    <label for="status_march">Status mars</label>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="status_march_null" name="status_march" class="custom-control-input" value="" {{ $class->status_march === null ? 'checked' : '' }}>
                        <label class="custom-control-label" for="status_march_null">
                            <i class="fa fa-fw fa-circle text-info"></i> Pas de réponse
                        </label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="status_march_yes" name="status_march" class="custom-control-input" value="1" {{ $class->status_march === 1 ? 'checked' : '' }}>
                        <label class="custom-control-label" for="status_march_yes">
                            <i class="fa fa-fw fa-check-circle text-success"></i> Réponse positive
                        </label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="status_march_no" name="status_march" class="custom-control-input" value="0" {{ $class->status_march === 0 ? 'checked' : '' }}>
                        <label class="custom-control-label" for="status_march_no">
                            <i class="fa fa-fw fa-times-circle text-danger"></i> Réponse négative
                        </label>
                    </div>
                    <div class="invalid-feedback">
                        {{ inputValidationMessages($errors, 'status_march') }}
                    </div>
                </div>
                
            </div>
            <div class="col-sm-4">

                <div class="form-group">
                    <label for="status_mai">Status mai</label>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="status_mai_null" name="status_mai" class="custom-control-input" value="" {{ $class->status_mai === null ? 'checked' : '' }}>
                        <label class="custom-control-label" for="status_mai_null">
                            <i class="fa fa-fw fa-circle text-info"></i> Pas de réponse
                        </label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="status_mai_yes" name="status_mai" class="custom-control-input" value="1" {{ $class->status_mai === 1 ? 'checked' : '' }}>
                        <label class="custom-control-label" for="status_mai_yes">
                            <i class="fa fa-fw fa-check-circle text-success"></i> Réponse positive
                        </label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="status_mai_no" name="status_mai" class="custom-control-input" value="0" {{ $class->status_mai === 0 ? 'checked' : '' }}>
                        <label class="custom-control-label" for="status_mai_no">
                            <i class="fa fa-fw fa-times-circle text-danger"></i> Réponse négative
                        </label>
                    </div>
                    <div class="invalid-feedback">
                        {{ inputValidationMessages($errors, 'status_mai') }}
                    </div>
                </div>

            </div>
        </div>


        <input type="submit" class="btn btn-primary" value="Mettre à jour">

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalDelete">
            Supprimer &laquo;{{ $class->name }}&raquo;
        </button>

    </form>

@endsection