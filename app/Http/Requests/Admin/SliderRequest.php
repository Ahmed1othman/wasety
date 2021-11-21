<?php

namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
                    'title_ar' => 'required|string|min:2|unique:sliders,title_ar,NULL,id,deleted_at,NULL',
                    'title_en' => 'required|string|min:2|unique:sliders,title_en,NULL,id,deleted_at,NULL',
                    'photo'=>'required|image|mimes:jpeg,bmp,png|max:4096',
                    'description_ar' => 'string|min:2|nullable',
                    'description_en' => 'string|min:2|nullable',
                ];
            }
            case 'PATCH':
            case 'PUT':
            {
                return [
                    'title_ar' => 'required|string|min:2',
                    'title_en' => 'required|string|min:2',
                    'photo'=>'image|mimes:jpeg,bmp,png|max:4096|nullable',
                    'description_ar' => 'string|min:2|nullable',
                    'description_en' => 'string|min:2|nullable',
                ];
            }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'title_ar.required' => 'title ar is required!',
            'title_en.required' => 'title en is required!',
            'description_ar.unique' => 'description ar is unique!',
            'description_en.unique' => 'description en is unique!',
            'photo.required' => 'photo is required!',
            'photo.image' => 'photo is image!'
        ];
    }

}


