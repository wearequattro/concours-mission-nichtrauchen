@extends('layouts.app-sidebar')

@section('title', 'Paramètres')

@section('content')
    <h1 class="display-4 text-center">Paramètres</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.settings.post') }}" method="post">
                @csrf

                @foreach($settings as $setting)
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="setting[{{ $setting->key }}]" data-setting="{{ $setting->key }}" {{ $setting->value ? 'checked' : '' }}>
                            {{ __('settings.' . $setting->key) }}
                        </label>
                    </div>
                @endforeach

                <input type="submit" class="btn btn-primary" value="Mettre à jour">
            </form>
        </div>
    </div>

@endsection

