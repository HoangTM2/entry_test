<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class HotelStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "hotel_name" => ["required", "string", "max:255"],
            "prefecture_id" => ["required", "integer", "exists:prefectures,prefecture_id"],
            "image" => ["nullable", "image", "mimes:jpg,jpeg,png", "max:2048"],
        ];
    }

    public function messages(): array
    {
        return [
            "hotel_name.required" => "ホテル名を入力してください",
            "hotel_name.max" => "ホテル名は255文字以内で入力してください",
            "prefecture_id.required" => "都道府県を選択してください",
            "prefecture_id.exists" => "都道府県が正しくありません",
            "image.image" => "画像ファイルを選択してください",
            "image.mimes" => "画像はjpg、jpeg、png形式のみ対応しています",
            "image.max" => "画像は2MB以内にしてください",
        ];
    }
}
