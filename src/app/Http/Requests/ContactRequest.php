<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Category;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:1,2,3',
            'email' => 'required|email|max:255',
            'tel' => 'required|string|regex:/^[0-9]+$/|max:11',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'detail' => 'required|string|max:120',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => '姓を入力してください',
            'first_name.string' => '姓を文字列で入力してください',
            'first_name.max' => '姓は255文字以内で入力してください',
            'last_name.required' => '名を入力してください',
            'last_name.string' => '名を文字列で入力してください',
            'last_name.max' => '名は255文字以内で入力してください',
            'gender.required' => '性別を選択してください',
            'gender.in' => '性別は指定された値から選択してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'email.max' => 'メールアドレスは255文字以内で入力してください',
            'tel.required' => '電話番号を入力してください',
            'tel.string' => '電話番号は文字列で入力してください',
            'tel.regex' => '電話番号は半角数字で入力してください',
            'tel.max' => '電話番号は11桁以内で入力してください',
            'address.required' => '住所を入力してください',
            'address.string' => '住所は文字列で入力してください',
            'address.max' => '住所は255文字以内で入力してください',
            'building.string' => '建物名は文字列で入力してください',
            'building.max' => '建物名は255文字以内で入力してください',
            'category_id.required' => 'お問い合わせの種類を選択してください',
            'category_id.exists' => 'お問い合わせの種類は指定された値から選択してください',
            'detail.required' => 'お問い合わせ内容を入力してください',
            'detail.max' => 'お問合せ内容は120文字以内で入力してください',
        ];
    }
}
