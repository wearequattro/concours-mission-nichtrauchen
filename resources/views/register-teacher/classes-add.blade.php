@extends('register-teacher.layout-sidebar')

@section('title', 'Gestion des classes')

@section('content')
    <h1 class="display-4 text-center">Ajouter une classe</h1>

    <form method="post" action="{{ route('teacher-register.classes.add.post') }}">
        @csrf

        <div class="form-group">
            <label for="class_name">Nom de la classe</label>
            <input type="text" required class="form-control" name="class_name" id="class_name">
        </div>

        <div class="form-group">
            <label for="class_students">Nombre d'&eacute;l&egrave;ves</label>
            <input type="number" required class="form-control" min="1" max="99" name="class_students"
                   id="class_students">
        </div>

        <div class="form-group">
            <label for="class_school">Lyc&eacute;e</label>
            <select required class="form-control" name="class_school" id="class_school">
                @foreach($schools as $school)
                    <option value="{{ $school->id }}"
                            data-address="{{ $school->full_address }}">{{ $school->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="class_school_address">Adresse du Lyc&eacute;e</label>
            <input type="text" readonly class="form-control" id="class_school_address">
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