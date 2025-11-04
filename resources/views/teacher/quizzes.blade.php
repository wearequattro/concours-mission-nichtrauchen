@extends('layouts.app-sidebar')

@section('title', 'Mes quiz')

@section('content')
    <h1 class="display-4 text-center">Mes quiz</h1>

    <div class="row">
        <div class="col-12">
            @forelse($quizzes as $quiz)
                <div style="margin-bottom: 20px; overflow: hidden; border-radius: .25rem; border: 1px solid rgba(0,0,0,.125)">
                    <div style="padding: 12px 20px; background: #fab234; color: #333333; font-weight: bold; border-top-left-radius: .25rem; border-top-right-radius: .25rem;">{{ $quiz->name }}</div>
                    <ul style="margin: 0; padding: 0; list-style: none;">
                        @forelse($quiz->assignments as $key => $assignment)
                            <li class="d-flex justify-content-between align-items-center" style="position: relative; display: block; padding: .75rem 1.25rem; background-color: #fff; border-bottom: 1px solid rgba(0,0,0,.125) {{ $key === $quiz->assignments->count() - 1 ? 'border-bottom: 0' : '' }}">
                                <span>{{ $assignment->schoolClass->name }}</span>
                                @if($assignment->isAnswered())
                                    <button class="btn btn-success" disabled style="display: inline-flex; align-items: center; gap: 4px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 16px; height: 16px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                        Quiz complété
                                    </button>
                                @elseif($assignment->codes->isEmpty())
                                    <button class="btn btn-light" disabled style="display: inline-flex; align-items: center; gap: 4px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 16px; height: 16px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                                        </svg>
                                        Lien pas encore disponible
                                    </button>
                                @else
                                    <a href="{{ route('external.quiz.show', [$assignment->uuid]) }}" target="_blank" class="btn btn-outline-success" style="display: inline-flex; align-items: center; gap: 4px;">
                                        Accéder aux quiz
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"  style="width: 16px; height: 16px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                        </svg>
                                    </a>
                                @endif
                            </li>
                            @empty
                                <li class="d-flex justify-content-between align-items-center" style="position: relative; display: block; padding: .75rem 1.25rem; background-color: #fff; border-bottom: 0">
                                    Pas d'affectations pour ce quiz
                                </li>
                            @endforelse
                    </ul>
                </div>
                @empty
                <div class="col-sm-4 offset-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-center text-muted font-italic">Aucun quiz disponible</h4>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

@endsection
