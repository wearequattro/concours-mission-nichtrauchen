@extends('layouts.app-sidebar')

@section('title', 'Quiz')

@section('content')
    <h1 class="display-4 text-center">Quiz</h1>

    @if(Session::has('message'))
        <div class="alert alert-success">
            {{ Session::get('message') }}
        </div>
    @endif

    <div class="col-12 mb-5">

        <form method="post" action="{{ route('admin.quiz.create.post') }}">
            @csrf

            <div class="form-group">
                <label for="name">Nom</label>
                <input required type="text" name="name" id="name"
                       class="form-control {{ inputValidationClass($errors, 'name') }}"
                       value="{{ old('name') ?? $quiz->name }}">
                <div class="invalid-feedback">
                    {{ inputValidationMessages($errors, 'name') }}
                </div>
            </div>

            <div class="form-group">
                <label for="max_score">Score maximal</label>
                <input required type="number" name="max_score" id="max_score" min="1" max="99"
                       class="form-control {{ inputValidationClass($errors, 'max_score') }}"
                       value="{{ old('max_score') ?? $quiz->max_score }}">
                <div class="invalid-feedback">
                    {{ inputValidationMessages($errors, 'max_score') }}
                </div>
            </div>

            <div class="form-group">
                <label for="classes">Classes</label>
                <select class="form-control" required multiple name="classes[]" id="classes">
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}">
                            {{ sprintf("%s (%s, %s)", $class->name, $class->teacher->full_name, $class->school->name) }}
                        </option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                    {{ inputValidationMessages($errors, 'classes') }}
                </div>
            </div>

            <div class="form-group">
                <label for="email_text">Text Email</label>
                <textarea name="email_text" id="email_text"
                >{{ old('email_text') ?? $quiz->email_text }}</textarea>
                <div class="invalid-feedback">
                    {{ inputValidationMessages($errors, 'students') }}
                </div>
            </div>




            <input type="submit" class="btn btn-primary" value="Mettre à jour">

        </form>

    </div>

@endsection

@push('js')
    <script>
        $('table').dataTable({
            pageLength: 100,
        });
        tinymce.init({
            selector: '#email_text',
            height: 500,
            setup: editor => {
                editor.on('input', e => {
                    $('#textarea').val(editor.get('text').getContent())
                })
            }
        });
    </script>
@endpush
