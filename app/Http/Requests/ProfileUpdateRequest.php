<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return \Auth::user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'teacher_salutation' => 'required|exists:salutations,id',
            'teacher_last_name' => 'required|string',
            'teacher_first_name' => 'required|string',
            'teacher_email' => 'required|email|unique:users,email,' . \Auth::user()->id,
            'teacher_phone' => 'required|string',
            'teacher_password' => 'nullable|string|min:6|confirmed',
        ];
    }
}
