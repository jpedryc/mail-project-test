<?php

namespace App\Http\Requests;

use App\Rules\Base64;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class SendEmailsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mails' => 'required|array',
            'mails.*.to' => 'required|email|max:512',
            'mails.*.subject' => 'nullable|string|max:512',
            'mails.*.body' => 'nullable|string',
            'mails.*.attachments' => 'nullable|array',
            'mails.*.attachments.*.filename' => 'required|string|max:512',
            'mails.*.attachments.*.content' => [ 'required', 'string', new Base64 ]
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException(null, response()->json($validator->errors(), 422));
    }
}
