<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'name' => ['required'],
            'post' => ['required','regex:/^\d{3}-\d{4}$/',],
            'address' => ['required'],
            'building' => ['required'],
        ];
    }

    public function messages()
    {
        return[
            'name.required' => 'ユーザー名を入力してください。',
            'post.required' => '郵便番号を入力してください。',
            'post.regex' =>'郵便番号は「123-4567」の形式で入力してください。',
            'address.required' =>'住所を入力してください。',
            'building.required' =>'建物名を入力してください。',
        ];
    }
}