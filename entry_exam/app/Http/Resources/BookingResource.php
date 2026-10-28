<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Booking
 */
class BookingResource extends JsonResource
{
    private const FORMAT = "Y-m-d H:i:s";

    public function toArray(Request $request): array
    {
        return [
            "booking_id" => $this->booking_id,
            "customer_name" => $this->customer_name,
            "customer_contact" => $this->customer_contact,
            "chekin_time" => $this->chekin_time?->format(self::FORMAT),
            "checkout_time" => $this->checkout_time?->format(self::FORMAT),
            "created_at" => $this->created_at?->format(self::FORMAT),
            "updated_at" => $this->updated_at?->format(self::FORMAT),
        ];
    }
}
