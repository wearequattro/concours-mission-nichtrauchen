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
        return trans('validation.quiz_maker_url');
    }

    public static function extractIdFromUrl($value): ?string {
        $matches = [];
        if(preg_match(self::$PATTERN, $value, $matches)) {
            return $matches[2];
        }
        return null;
    }
}
