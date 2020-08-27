@extends('layouts.app-single-page')

@section('title', 'Suivi')

@section('content')

    <div class="card">
        <div class="card-body">
            <p class="text-center lead pt-3">

                @if($status === false)
                    Malheureusement votre classe {{ $class->name }} ne pourra donc plus participer au concours. C’est bien dommage !
                    Si vous désirez cependant aborder divers aspects du tabagisme (risques, coûts, dépendance, etc.) avec
                    votre classe, vous pouvez utiliser nos fiches pédagogiques.
                @endif

                @if($status === true)
                    Félicitations, votre classe {{ $class->name }} est toujours non-fumeur et vous continuez à
                    participer au concours Mission Nichtrauchen.
                @endif

            </p>
        </div>
    </div>

@endsection
