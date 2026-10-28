<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class HotelSearchRequest extends FormRequest
{
    /**
     * The route that users should be redirected to if validation fails.
     *
     * @var string
     */
    protected $redirectRoute = 'adminHotelSearchPage';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "hotel_name" => ["nullable", "string", "max:255"],
            "prefecture_id" => ["nullable", "integer", "exists:prefectures,prefecture_id"],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if (!$this->filled("hotel_name") && !$this->filled("prefecture_id")) {
                $validator->errors()->add("hotel_name", "何も入力されていません");
            }
        });
    }

    public function messages(): array
    {
        return [
            "hotel_name.max" => "ホテル名は255文字以内で入力してください",
            "prefecture_id.exists" => "都道府県が正しくありません",
        ];
    }
}
