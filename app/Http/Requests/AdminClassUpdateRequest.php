<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminClassUpdateRequest extends FormRequest {
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
            'name' => 'string|required',
            'students' => 'string|required',
            'school_id' => 'integer|required|exists:schools,id',
            'teacher_id' => 'integer|required|exists:teachers,id',
            'status_january' => ['integer', 'nullable', Rule::in([0, 1])],
            'status_march' => ['integer', 'nullable', Rule::in([0, 1])],
            'status_may' => ['integer', 'nullable', Rule::in([0, 1])],
            'status_party' => ['integer', 'nullable', Rule::in([0, 1])],
        ];
    }
}
