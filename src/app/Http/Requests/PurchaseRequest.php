<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'method' => ['required', 'in:コンビニ払い,カード払い'],
            'post' => ['required','regex:/^\d{3}-\d{4}$/',],
            'address' => ['required'],
        ];
    }

    public function messages()
    {
        return[
            'method.required' => '支払方法を選択してください。',
            'method.in' => '支払い方法は「コンビニ払い」または「カード払い」を選択してください。',
            'post.required' => '郵便番号を入力してください。',
            'post.regex' =>'郵便番号は「123-4567」の形式で入力してください。',
            'address.required' =>'住所を入力してください。',
        ];
    }
}
