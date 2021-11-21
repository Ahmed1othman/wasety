<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class ProjectRequest extends FormRequest
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
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'title' => 'required|string|min:2',
                    'description' => 'required|string|min:2',
                    'amount' => 'required|integer',
                    'photo'=>'sometimes|nullable|image|mimes:jpeg,bmp,png|max:4096'
                ];
            }
            case 'PATCH':
            case 'PUT':
            {
                return [
                    'title' => 'sometimes|string|min:2',
                    'amount' => 'sometimes|integer',
                    'status' => 'sometimes|in:something,pending,recieve_offer,implementation,delivery,completed,cancelled,rejected',
                    'description' => 'sometimes|string|min:2',
                    'photo'=>'sometimes|nullable|image|mimes:jpeg,bmp,png|max:4096'
                ];
            }
            default:break;
        }
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(responseFail('Validation Error',401,$errors));
    }

}
