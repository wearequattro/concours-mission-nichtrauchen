<?php

namespace App\Rules;

use App\QuizInLanguage;
use Illuminate\Contracts\Validation\Rule;

class QuizMakerUniqueRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $id = QuizMakerValidUrlRule::extractIdFromUrl($value);
        return QuizInLanguage::query()
            ->where('quiz_maker_id', '=', $id)
            ->doesntExist();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.unique');
    }
}
