<?php

namespace App\Http\Requests\Api;

use App\Rules\RateExists;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class RateRequest extends FormRequest
{

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
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'value' => 'required|string|max:5',
                    'photo' => 'image',
                    'type' => 'required|in:project,user',
                    'id' => ['required',new RateExists($this->type)],
                ];
            }
            case 'PATCH':
            case 'PUT':
            {
                return [
                    'value' => 'required|string|max:5',
                    'photo' => 'image',
                    'type' => 'in:product,user,Auction',
                    'id' => 'required',
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
