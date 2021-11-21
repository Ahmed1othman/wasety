<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class ProductRequest extends FormRequest
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
                    'name_en' => 'required|string|min:2',
                    'name_ar' => 'required|string|min:2',
                    'details_en' => 'required|string|min:2',
                    'details_ar' => 'required|string|min:2',
                    'price' => 'required|integer',
                    'photo'=>'sometimes|nullable|image|mimes:jpeg,bmp,png|max:4096'
                ];
            }
            case 'PATCH':
            case 'PUT':
            {
                return [
                    'name_en' => 'sometimes|string|min:2',
                    'name_ar' => 'sometimes|string|min:2',
                    'price' => 'sometimes|integer',
                    'details_en' => 'sometimes|string|min:2',
                    'details_ar' => 'sometimes|string|min:2',
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
