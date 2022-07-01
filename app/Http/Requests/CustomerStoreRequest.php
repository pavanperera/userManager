<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerStoreRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'contact_email' => 'required|email',
            'phone_number' => 'required|regex:/^(\+)([1-9]{2})(\s{0,1})(\d{9})$/|min:10',
            'gender' => 'required',
            'address' => 'required',
            'dob' => 'required',
            'is_active' => 'required',
        ];
    }
}
