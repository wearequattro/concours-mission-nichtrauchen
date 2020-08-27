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

        <form method="post" action="{{ $quiz->exists ? route('admin.quiz.edit.post', [$quiz]) : route('admin.quiz.create.post') }}">
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
                <input required type="number" name="max_score" id="max_score" min="1"
                       class="form-control {{ inputValidationClass($errors, 'max_score') }}"
                       value="{{ old('max_score') ?? $quiz->max_score }}">
                <div class="invalid-feedback">
                    {{ inputValidationMessages($errors, 'max_score') }}
                </div>
            </div>

            @if(!$quiz->exists)

                @foreach($languages as $language)

                <div class="form-group">
                    <label for="quiz_url[{{ $language }}]">URL Quiz ({{ $language }})</label>
                    <input required type="text" name="quiz_url[{{ $language }}]" id="quiz_url[{{ $language }}]"
                           class="form-control {{ inputValidationClass($errors, "quiz_url.$language") }}"
                           value="{{ old("quiz_url.$language") }}">
                    <div class="invalid-feedback">
                        {{ inputValidationMessages($errors, "quiz_url.$language") }}
                    </div>
                </div>

                @endforeach

            @endif

            <div class="form-group">
                <label for="closes_at">Date de clôturation (à 00:00h)</label>
                <input type="text" name="closes_at" id="closes_at" required
                       placeholder="yyyy-mm-dd" min="{{ date('Y-m-d', strtotime('+1day')) }}"
                       class="form-control datepicker {{ inputValidationClass($errors, 'closes_at') }}"
                       value="{{ old('closes_at', optional($quiz->closes_at)->format('Y-m-d')) }}">
                <div class="invalid-feedback">
                    {{ inputValidationMessages($errors, 'closes_at') }}
                </div>
            </div>

            <div class="form-group">
                <label for="classes">Classes</label>
                <select required
                        multiple
                        name="classes[]"
                        id="classes"
                        {{ $quiz->exists ? 'disabled' : '' }}
                        class="form-control {{ inputValidationClass($errors, 'classes') }}">
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{
                                in_array($class->id, old('classes', [])) || $quiz->assignments()->where('school_class_id', $class->id)->exists()
                                 ? 'selected' : '' }}>
                            {{ sprintf("%s (%s, %s)", $class->name, $class->teacher->full_name, $class->school->name) }}
                        </option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                    {{ inputValidationMessages($errors, 'classes') }}
                </div>
            </div>

            @if($quiz->state === \App\Quiz::STATE_NEW)

            <div class="form-group">
                <label for="email_text">Text Email</label>
                <textarea name="email_text" id="email_text"
                >{{ old('email_text') ?? $quiz->email_text }}</textarea>
                <div class="invalid-feedback">
                    {{ inputValidationMessages($errors, 'email_text') }}
                </div>
            </div>

            @else
                <div class="form-group">
                    <label>Text Email</label>
                    <div class="card">
                        <div class="card-body">
                            {!! $quiz->email_text !!}
                        </div>
                    </div>
                </div>
            @endif

            <input type="submit" class="btn btn-primary" value="{{ $quiz->exists ? 'Mettre à jour' : 'Ajouter' }}">

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
        });
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            startDate: '{{ date('Y-m-d', strtotime('+1day')) }}'
        });
    </script>
@endpush
