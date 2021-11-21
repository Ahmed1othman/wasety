<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class PartnerRequest extends FormRequest
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
                    'name_ar' => 'required|string|min:2|unique:partners,name_ar,NULL,id,deleted_at,NULL',
                    'name_en' => 'required|string|min:2|unique:partners,name_en,NULL,id,deleted_at,NULL',
                    'photo'=>'required|image|mimes:jpeg,bmp,png|max:4096',
                    'url' => 'string|min:2|nullable',


                ];
            }
            case 'PATCH':
            case 'PUT':
            {
                return [
                    'name_ar' => 'required|string|min:2|unique:partners,name_ar,NULL,id,deleted_at,NULL' . request()->segment(3),
                    'name_en' => 'required|string|min:2|unique:partners,name_en,NULL,id,deleted_at,NULL' . request()->segment(3),
                'photo'=>'image|mimes:jpeg,bmp,png|max:4096',
                    'url' => 'string|min:2',

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
