<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'icon' => ['file','mimes:jpeg,png,jpg'],
        ];
    }

    public function messages()
    {
        return [
            'icon.file' => 'アップロードされたファイルが無効です。',
            'icon.mimes' => 'アイコン画像は .jpeg または .png または .jpgの形式である必要があります。',
            'icon.uploaded' => 'アイコン画像のアップロードに失敗しました。',
        ];
    }
}
