<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class SchoolClassCreateRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return \Auth::user() !== null && \Auth::user()->type === User::TYPE_TEACHER && \Auth::user()->teacher !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'class_name' => 'string|required',
            'class_students' => 'integer|min:0|max:99|required',
            'class_school' => 'required|exists:schools,id',
            'data_protection' => 'required|accepted',
        ];
    }
}
