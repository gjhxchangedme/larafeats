<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DummyRequest extends FormRequest
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
            'email' => 'required|email',
            'name' => 'required'
        ];
    }

    /**
     * Force application to return json
     *
     * @return boolean
     */
    public function wantsJson()
    {
        return true;
    }

    /**
     * Overriding the default response of form request
     * add the following lines to the beginning of the
     * script...
     *
     * use Illuminate\Contracts\Validation\Validator;
     * use Illuminate\Http\Exceptions\HttpResponseException;
     *
     * @param  Validator $validator
     * @return object
     */
    public function failedValidation(Validator $validator) {

       throw new HttpResponseException(response()->json([
           'payload' => $validator->errors(),
           'message' => 'Invalid request passed',
           'code' => 422,
           'status' => 'error',
       ], 422));
   }
}
