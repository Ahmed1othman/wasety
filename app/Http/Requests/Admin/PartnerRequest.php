<?php

namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;

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
                    'name_ar' => 'required|string|min:2',
                    'name_en' => 'required|string|min:2',
                    'photo'=>'image|mimes:jpeg,bmp,png|max:4096|nullable',
                    'url' => 'string|min:2|nullable',
                ];
            }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'name_ar.required' => 'name ar is required!',
            'name_en.required' => 'name en is required!',
            'name_ar.unique' => 'name ar is unique!',
            'name_en.unique' => 'name en is unique!',
            'photo.required' => 'photo is required!',
            'photo.image' => 'photo is image!'
        ];
    }

}


