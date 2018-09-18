@extends('layouts.app-sidebar')

@section('title', 'Dates')

@section('content')
    <h1 class="display-4 text-center">Dates</h1>

    @if(Session::has('message'))
        <div class="alert alert-success">
            {{ Session::get('message') }}
        </div>
    @endif

    <form action="{{ route('admin.dates.post') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-sm-12">

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Libellé</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dates as $date)
                            <tr>
                                <td>{{ $date->label }}</td>
                                <td>
                                    <input type="hidden" name="dates[{{ $loop->index }}][key]" value="{{ $date->key }}">
                                    <input type="text" name="dates[{{ $loop->index }}][value]"
                                           class="datepicker form-control" value="{{ $date->value->format('Y-m-d') }}">
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">

                <input type="submit" class="btn btn-primary btn-block" value="Actualiser">

            </div>
        </div>
    </form>
@endsection

@push('js')
    <script>
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
        });
    </script>
@endpush