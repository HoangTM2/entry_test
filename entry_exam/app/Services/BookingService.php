<?php

namespace App\Services;

use App\DTOs\BookingSearchCriteria;
use App\Repositories\Contracts\BookingRepositoryInterface;
use Illuminate\Support\Collection;

class BookingService
{
    public function __construct(private readonly BookingRepositoryInterface $bookings)
    {
    }

    public function search(BookingSearchCriteria $criteria): Collection
    {
        return $this->bookings->search($criteria);
    }
}
