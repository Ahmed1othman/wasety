<?php

namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;

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
    public function messages()
    {
        return [

        ];
    }

}


