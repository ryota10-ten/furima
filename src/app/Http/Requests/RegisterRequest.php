<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => ['required','email','unique:users,email'],
            'password' => ['required','min:8','confirmed'],
        ];
    }

    public function messages()
    {
        return[
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => '有効なメールアドレス形式を入力してください',
            'email.unique' => 'このメールアドレスはすでに登録されています。',
            'password.required' =>'パスワードを入力してください',
            'password.min' =>'パスワードは最低:min文字以上で入力してください',
            'password.confirmed' =>'パスワードが一致しません'
        ];
    }

}
