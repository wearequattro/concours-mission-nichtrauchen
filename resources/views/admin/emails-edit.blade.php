@extends('layouts.app-sidebar')

@section('title', 'Mise à jour email')

@section('content')
    <h1 class="display-4 text-center">Mise à jour e-mail</h1>

    @if(Session::has('message'))
        <div class="alert alert-success">
            {{ Session::get('message') }}
        </div>
    @endif

    <div class="alert alert-info">
        <i class="fa fa-fw fa-info-circle"></i> {{ $email->title }}
    </div>



    <form action="{{ route('admin.emails.edit.post', [$email]) }}" method="post">
        @csrf

        <div class="form-group">
            <label for="subject">Sujet</label>
            <input required type="text" name="subject" id="subject"
                   class="form-control {{ inputValidationClass($errors, 'subject') }}"
                   value="{{ old('subject') ?? $email->subject }}">
            <div class="invalid-feedback">
                {{ inputValidationMessages($errors, 'subject') }}
            </div>
        </div>

        <div class="row">

            <div class="col-xs-12 col-sm-6">

                <div class="form-group">
                    <label for="text">Texte</label>
                    <textarea required class="form-control {{ inputValidationClass($errors, 'text') }}" name="text"
                              id="text"
                              rows="13"
                    >{{ old('text') ?? $email->text }}</textarea>
                    <div class="invalid-feedback">
                        {{ inputValidationMessages($errors, 'text') }}
                    </div>
                </div>

            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="card mt-4">
                    <div class="card-header">Aper&ccedil;u</div>
                    <div class="card-body" id="preview"></div>
                </div>
            </div>
        </div>


        <input type="submit" class="btn btn-primary" value="Actualiser">

    </form>


@endsection

@push('js')
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: '#text',
            plugins: ['advlist autolink link lists charmap hr pagebreak',
                'searchreplace wordcount visualblocks visualchars insertdatetime nonbreaking',
                'table contextmenu directionality emoticons template paste textcolor'],
            setup: function (editor) {
                editor.addButton('placeholder', {
                    title: 'Texte réservé',
                    image: '{{ asset('images/placeholder.png') }}',
                    type: 'listbox',
                    name: '',
                    onselect: function (e) {
                        editor.insertContent(this.value() + ' ');
                    },
                    values: {!! $placeholders !!}
                });
                editor.on('keyUp', refreshPreview);
                editor.on('Change', refreshPreview);
                editor.on('init', refreshPreview);
            },
            toolbar: 'undo redo | styleselect | bold italic | link | alignleft aligncenter alignright | placeholder',
        });

        var placeholders = {!! $placeholders !!};

        function refreshPreview() {
            var text = tinymce.get('text').getContent();
            for (p in placeholders) {
                var o = placeholders[p];
                text = text.replace(new RegExp(o.value, "g"), o.preview);
            }

            $('#preview').html(text);
            $('#text').html(text);
        }

    </script>
@endpush
