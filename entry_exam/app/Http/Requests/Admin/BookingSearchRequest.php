<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BookingSearchRequest extends FormRequest
{
    /**
     * The route that users should be redirected to if validation fails.
     *
     * @var string
     */
    protected $redirectRoute = 'adminBookingSearchPage';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "customer_name" => ["nullable", "string", "max:255"],
            "customer_contact" => ["nullable", "string", "max:255"],
            "checkin_date" => ["nullable", "date"],
            "checkout_date" => ["nullable", "date"],
        ];
    }

    public function withValidator(\Illuminate\Validation\Validator $validator): void
    {
        $validator->after(function (\Illuminate\Validation\Validator $validator) {
            if (
                !$this->filled("customer_name") &&
                !$this->filled("customer_contact") &&
                !$this->filled("checkin_date") &&
                !$this->filled("checkout_date")
            ) {
                $validator->errors()->add("customer_name", "何も入力されていません");
            }
        });
    }

    public function messages(): array
    {
        return [
            "customer_name.max" => "顧客名は255文字以内で入力してください",
            "customer_contact.max" => "顧客連絡先は255文字以内で入力してください",
            "checkin_date.date" => "チェックイン日時の形式が正しくありません",
            "checkout_date.date" => "チェックアウト日時の形式が正しくありません",
        ];
    }
}
