@extends('emails.layout')

@section("content")
    {!! $text !!}

    <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
        <tbody>
        <tr>
            <td align="left">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td> <a href="{{ route('external.quiz.show', [$uuid]) }}" target="_blank">Participer au quiz</a> </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
@endsection
