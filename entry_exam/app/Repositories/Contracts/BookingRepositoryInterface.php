<?php

namespace App\Repositories\Contracts;

use App\DTOs\BookingSearchCriteria;
use Illuminate\Support\Collection;

interface BookingRepositoryInterface
{
    public function search(BookingSearchCriteria $criteria): Collection;
}
