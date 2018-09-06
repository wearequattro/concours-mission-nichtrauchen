@extends('register-teacher.layout-sidebar')

@section('title', 'Mes Documents')

@section('content')
    <h1 class="display-4 text-center">Mes Documents</h1>

    <div class="row">
        @for($i = 0; $i < 10; $i++)
            <div class="col-sm-3">
                <div class="card mb-3">
                    <div class="card-header">Document {{ $i }}</div>
                    <div class="card-body">
                        <h5 class="card-title">Document {{ $i }}</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="card-link">Download</a>
                    </div>
                </div>
            </div>
        @endfor
    </div>

@endsection