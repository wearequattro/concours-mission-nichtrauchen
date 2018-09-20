<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Input;

class PartyGroupRegistrationRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return \Auth::user() !== null && \Auth::user()->type === User::TYPE_TEACHER && \Auth::user()->teacher !== null
            && Input::route('class')->partyGroups()->doesntExist();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'class.*.name' => 'required|string',
            'class.*.language' => 'required|string',
            'class.*.students' => 'required|numeric|max:10',
        ];
    }
}
