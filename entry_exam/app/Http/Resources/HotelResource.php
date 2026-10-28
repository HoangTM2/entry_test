<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Hotel
 */
class HotelResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $rawPath = $this->getRawOriginal('file_path');
        $hasImage = $rawPath !== null && file_exists(public_path('assets/img/' . $rawPath));

        return [
            "hotel_id" => $this->hotel_id,
            "hotel_name" => $this->hotel_name,
            "prefecture_id" => $this->prefecture_id,
            "prefecture_name" => $this->prefecture?->prefecture_name,
            "image_url" => $hasImage ? asset("assets/img/" . $rawPath) : null,
            "created_at" => $this->created_at?->format("Y-m-d H:i:s"),
            "updated_at" => $this->updated_at?->format("Y-m-d H:i:s"),
        ];
    }
}
