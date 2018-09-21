@extends('layouts.app-sidebar')

@section('title', 'Classes')

@section('content')
    <h1 class="display-4 text-center">Classes</h1>

    @if(Session::has('message'))
        <div class="alert alert-success">
            {{ Session::get('message') }}
        </div>
    @endif

    <div class="row">

        <div class="col-sm-3 mb-4">
            <div class="card">
                <div class="card-header">
                    Exporter fichier des classes
                </div>
                <div class="card-body">
                    @php
                        $countClasses = $classes->count();
                        $countTeacher = $classes->pluck('teacher')->unique()->count();
                        $countSchool = $classes->pluck('teacher')->pluck('school')->unique()->count();
                    @endphp
                    <p>
                        L'export contiendra <strong>{{ $countClasses }} {{ $countClasses > 1 ? 'classes' : 'classe' }}</strong>,
                        <strong>{{ $countTeacher }} {{ $countTeacher > 1 ? 'enseignants' : 'enseignant' }}</strong>,
                        <strong>{{ $countSchool }} {{ $countSchool > 1 ? 'lycées' : 'lycée' }}</strong>.
                    </p>
                    <a class="btn btn-primary" href="{{ route('admin.classes.export') }}">
                        Exporter
                    </a>
                </div>
            </div>
        </div>

        <div class="col-sm-5">
            <div class="card">
                <div class="card-header">
                    Légende
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <p>
                                <strong>Icônes :</strong><br>
                                {{ statusToIcon(null) }}: Pas répondu<br>
                                {{ statusToIcon(1) }}: Réponse positive<br>
                                {{ statusToIcon(0) }}: Réponse négative
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <strong>Enseignants :</strong><br>
                            <p class="bg-multiple-classes mb-1 mt-0 p-1">
                                L'enseignant a plusieurs classes
                            </p>
                            <p class="bg-multiple-schools mb-0 p-1">
                                L'enseignant a des classes dans plusieurs lycées
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-4">

            <div class="card">
                <div class="card-header">
                    Envoyer rappels
                </div>
                <div class="card-body">
                    <p>
                        Les rappels seront activés dès que les dates des suivis respectifs sont atteints.
                    </p>
                    @if($show_january)
                        <a href="{{ route('admin.classes.resend', [\App\SchoolClass::STATUS_JANUARY]) }}" class="btn btn-primary">
                            Janvier
                        </a>
                    @else
                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" data-placement="bottom"
                              title="Sera activé : {{ \App\EditableDate::find(\App\EditableDate::FOLLOW_UP_1)->toDateString() }}">
                            <button disabled class="btn btn-primary" type="button" style="pointer-events: none;">
                                Janvier
                            </button>
                        </span>
                    @endif
                    @if($show_march)
                        <a href="{{ route('admin.classes.resend', [\App\SchoolClass::STATUS_MARCH]) }}" class="btn btn-primary">
                            Mars
                        </a>
                    @else
                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" data-placement="bottom"
                              title="Sera activé : {{ \App\EditableDate::find(\App\EditableDate::FOLLOW_UP_2)->toDateString() }}">
                            <button disabled class="btn btn-primary" type="button" style="pointer-events: none;">
                                Mars
                            </button>
                        </span>
                    @endif
                    @if($show_may)
                        <a href="{{ route('admin.classes.resend', [\App\SchoolClass::STATUS_MAY]) }}" class="btn btn-primary">
                            Mai
                        </a>
                        @else
                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" data-placement="bottom"
                              title="Sera activé : {{ \App\EditableDate::find(\App\EditableDate::FOLLOW_UP_3)->toDateString() }}">
                            <button disabled class="btn btn-primary" type="button" style="pointer-events: none;">
                                Mai
                            </button>
                        </span>
                    @endif
                </div>
            </div>

        </div>

    </div>

            <div class="table-responsive">

                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>N° d'étudiants</th>
                        <th>Lycée</th>
                        <th>Enseignant</th>
                        <th>Status janvier</th>
                        <th>Status mars</th>
                        <th>Status mai</th>
                        <th>Status fête</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($classes as $class)
                        @php
                        $css = "";
                        if($class->teacher->has_multiple_classes)
                            $css = "bg-multiple-classes";
                        if($class->teacher->has_multiple_schools)
                            $css = "bg-multiple-schools";
                        @endphp
                        <tr class="{{ $css }}">
                            <td>{{ $class->name }}</td>
                            <td>{{ $class->students }}</td>
                            <td>{{ $class->school->name }}</td>
                            <td>{{ $class->teacher->full_name }}</td>
                            <td>{{ statusToIcon($class->status_january ) }}</td>
                            <td>{{ statusToIcon($class->status_march ) }}</td>
                            <td>{{ statusToIcon($class->status_may ) }}</td>
                            <td>{{ statusToIcon($class->status_party ) }}</td>
                            <td>
                                <a href="{{ route('admin.classes.edit', [$class]) }}" class="btn btn-primary">
                                    <i class="fa fa-fw fa-pencil"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Aucune classe n'est enregistr&eacute;e</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </div>
@endsection

@push('js')
    <script>
        $('[data-toggle="tooltip"]').tooltip();
        $('table').dataTable();
    </script>
@endpush