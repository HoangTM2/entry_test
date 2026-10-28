<?php

namespace App\Http\Requests\Admin;

class HotelUpdateRequest extends HotelStoreRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            "hotel_id" => ["required", "integer", "exists:hotels,hotel_id"],
            "existing_temp_image" => ["nullable", "string"],
        ]);
    }
}
