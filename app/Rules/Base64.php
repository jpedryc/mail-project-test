<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Log;

class Base64 implements Rule
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
        /**
         * TEST-PROJECT-COMMENT
         *
         *  With more time, I would check if this actually will handle all different file types correctly etc.
         *  I'm assuming attachments are not only images but also pdfs etc.
         */

        // Returns false if not a valid base64 string
        return base64_decode($value, true);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid base64 string.';
    }
}
