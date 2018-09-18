@extends('layouts.app-sidebar')

@section('title', 'Gestion des classes')

@section('content')
    <h1 class="display-4 text-center">Ajouter une classe</h1>

    <form method="post" action="{{ route('teacher.classes.add.post') }}">
        @csrf

        <div class="form-group">
            <label for="class_name">Nom de la classe</label>
            <input required type="text" name="class_name" id="class_name"
                   class="form-control {{ inputValidationClass($errors, 'class_name') }}"
                   value="{{ old('class_name') }}">
            <div class="invalid-feedback">
                {{ inputValidationMessages($errors, 'class_name') }}
            </div>
        </div>

        <div class="form-group">
            <label for="class_students">Nombre d'&eacute;l&egrave;ves</label>
            <input required type="number" name="class_students" id="class_students"
                   min="1" max="99"
                   class="form-control {{ inputValidationClass($errors, 'class_students') }}"
                   value="{{ old('class_students') }}">
            <div class="invalid-feedback">
                {{ inputValidationMessages($errors, 'class_students') }}
            </div>
        </div>


        <div class="form-group">
            <label for="class_school">Lyc&eacute;e</label>
            <select required class="form-control {{ inputValidationClass($errors, 'class_school') }}" name="class_school" id="class_school">
                @foreach($schools as $school)
                    <option value="{{ $school->id }}"
                            data-address="{{ $school->full_address }}">{{ $school->name }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">
                {{ inputValidationMessages($errors, 'class_school') }}
            </div>
        </div>

        <div class="form-group">
            <label for="class_school_address">Adresse du lyc&eacute;e</label>
            <input type="text" readonly class="form-control" id="class_school_address">
        </div>

        <div class="form-group text-left ml-4">
            <input type="checkbox" name="data_protection" id="data_protection"
                   class="custom-control-input {{ inputValidationClass($errors, 'data_protection') }}"
                    {{ old('data_protection') != null ? 'checked' : '' }}>
            <label for="data_protection" class="custom-control-label">
                <a href="#">Information sur la protection des données</a> {{-- TODO LINK TO PDF --}}
            </label>
            <div class="invalid-feedback">
                {{ inputValidationMessages($errors, 'data_protection') }}
            </div>
        </div>

        <input type="submit" class="btn btn-primary" value="Enregistrer">

    </form>
@endsection

@push('js')
    <script>
        $('#class_school').on('change', function () {
            let address = $('#class_school :selected').attr('data-address');
            $('#class_school_address').val(address);
        }).trigger('change');
    </script>
@endpush