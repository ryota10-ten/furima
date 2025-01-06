<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'detail' => ['required','max:255'],
            'img' => ['required','file','mimes:jpeg,png,jpg'],
            'price' => ['required','integer','min:0'],
            'condition_id' => ['required'],
            'category' => ['required','array'],
            'category.*' => ['integer','exists:categories,id'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください。',
            'detail.required' => '商品の説明を入力してください。',
            'detail.max' => '商品の説明は最大:max文字以下で入力してください。',
            'img.required' => '商品画像をアップロードしてください。',
            'img.file' => 'アップロードされたファイルが無効です。',
            'img.mimes' => '商品画像は .jpeg または .png または .jpgの形式である必要があります。',
            'price.required' => '販売価格を入力してください。',
            'price.integer' => '販売価格は数字で入力してください。',
            'price.min' => '販売価格は:min円以上で入力してください。',
            'condition_id.required' => '商品の状態を選択してください。',
            'category.required'  => 'カテゴリーを1つ以上選択してください。',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'price' => str_replace('¥', '', $this->price),
        ]);
    }
}
