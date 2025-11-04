@extends('layouts.app-sidebar')

@section('title', 'Mes quiz')

@section('content')
    <h1 class="display-4 text-center">Mes quiz</h1>

    <div class="row">
        <div class="col-12">
            @forelse($quizzes as $quiz)
                <ul class="list-group" style="border-radius: 0;">
                    <li class="list-group-item" style="padding: 0;">
                        <div style="padding: 12px 20px; background: #fab234; color: #333333; font-weight: bold;">{{ $quiz->name }}</div>
                        <ul class="list-group" style="border-radius: 0; margin-bottom: -1px;">
                            @forelse($quiz->assignments as $assignment)
                            <li class="list-group-item d-flex justify-content-between align-items-center" style="border-left: 0; border-right: 0;">
                                {{ $assignment->schoolClass->name }}
                                <a href="{{ route('external.quiz.show', [$assignment->uuid]) }}" target="_blank" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 4px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 16px; height: 16px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                                    </svg>
                                    Accéder aux quiz
                                </a>
                            </li>
                            @empty
                                <li class="list-group-item d-flex justify-content-between align-items-center" style="border-left: 0; border-right: 0;  border-bottom: 0;">
                                    Pas d'affectations pour ce quiz
                                </li>
                            @endforelse
                        </ul>
                    </li>
                </ul>
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
