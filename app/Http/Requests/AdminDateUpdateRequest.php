<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class AdminDateUpdateRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return \Auth::user() != null && \Auth::user()->type === User::TYPE_ADMIN;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'dates.*.key' => 'string|required|exists:editable_dates,key',
            'dates.*.value' => 'date|required',
        ];
    }
}
