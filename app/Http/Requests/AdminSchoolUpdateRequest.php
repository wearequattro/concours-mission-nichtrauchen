<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class AdminSchoolUpdateRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return \Auth::user() !== null && \Auth::user()->type === User::TYPE_ADMIN;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'school_name' => 'required|string',
            'school_address' => 'required|string',
            'school_postal_code' => 'required|string',
            'school_city' => 'required|string',
        ];
    }
}
