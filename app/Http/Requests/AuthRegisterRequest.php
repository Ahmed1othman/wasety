<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class AuthRegisterRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'type'=>'required|in:customer,dealer',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'bio' => 'sometimes|string',
            'country_id' => 'nullable|required_if:type,dealer|exists:countries,id',
            'city_id' => 'nullable|required_if:type,dealer|exists:cities,id',
            'coin_price' => 'nullable|required_if:type,dealer|integer',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(responseFail($errors[array_keys($errors)[0]], 401, $errors));
    }
}
