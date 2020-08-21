<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class QuizMakerValidUrlRule implements Rule
{
    public static string $PATTERN = "/https?:\/\/(www.)?quiz-maker\.com\/([A-Za-z0-9]*)/";

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
        return preg_match(self::$PATTERN, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('The :attribute must be a valid Quiz-Maker URL. Format: https://www.quiz-maker.com/XXXXX');
    }
}
