<?php

namespace App\Repositories\Contracts;

use App\DTOs\HotelSearchCriteria;
use App\Models\Hotel;
use Illuminate\Support\Collection;

interface HotelRepositoryInterface
{
    public function search(HotelSearchCriteria $criteria): Collection;

    public function findOrFail(int $hotelId): Hotel;

    public function create(array $attributes): Hotel;

    public function update(Hotel $hotel, array $attributes): Hotel;

    public function delete(Hotel $hotel): void;
}
