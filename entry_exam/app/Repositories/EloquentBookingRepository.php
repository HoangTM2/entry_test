<?php

namespace App\Repositories;

use App\DTOs\BookingSearchCriteria;
use App\Models\Booking;
use App\Repositories\Contracts\BookingRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentBookingRepository implements BookingRepositoryInterface
{
    public function search(BookingSearchCriteria $criteria): Collection
    {
        return Booking::query()
            ->when($criteria->customerName, fn ($q, $v) => $q->where("customer_name", "LIKE", $this->like($v)))
            ->when($criteria->customerContact, fn ($q, $v) => $q->where("customer_contact", "LIKE", $this->like($v)))
            ->when($criteria->checkinDate, fn ($q, $v) => $q->whereDate("chekin_time", $v))
            ->when($criteria->checkoutDate, fn ($q, $v) => $q->whereDate("checkout_time", $v))
            ->orderBy("booking_id")
            ->get();
    }

    /**
     * Partial match with LIKE wildcards escaped.
     */
    private function like(string $value): string
    {
        return "%" . addcslashes($value, "%_\\") . "%";
    }
}
