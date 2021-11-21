<?php

namespace App\Http\Requests\Api;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class AcceptOfferRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'id' => 'required|exists:offers,id,deleted_at,NULL',
                    'status' => 'required|in:accepted,rejected,canceld',
                ];
            }

            case 'PATCH':
            case 'PUT':
            {
                return [
                    'id' => 'required|exists:offers,id,deleted_at,NULL',

                    'status' => 'required|in:accepted,rejected,canceld',
                ];
            }
            default:
                break;
        }
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(responseFail('Validation Error', 401, $errors));
    }

}
