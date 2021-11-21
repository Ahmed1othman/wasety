<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class SettingRequest extends FormRequest
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
                    'appStore_link' => 'nullable|string|min:2',
                    'googlePlay_link' => 'nullable|string|min:2',
                    'name_ar' => 'nullable|string|min:2',
                    'name_en' => 'nullable|string|min:2',
                    'phone' => 'nullable|string|min:2',
                    'email' => 'nullable|email|min:2',
                    'email_message' => 'nullable|string|min:2',
                    'phone_message' => 'nullable|string|min:2',
                    'logo'=>'nullable|image|mimes:jpeg,bmp,png|max:4096'
                ];
            }
            case 'PATCH':
            case 'PUT':
            {
                return [];
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
            'logo.required' => 'Logo is required!',
            'logo.image' => 'Logo is image!'
        ];
    }


}
