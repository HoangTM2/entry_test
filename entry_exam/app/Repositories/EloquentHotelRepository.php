<?php

namespace App\Repositories;

use App\DTOs\HotelSearchCriteria;
use App\Models\Hotel;
use App\Repositories\Contracts\HotelRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentHotelRepository implements HotelRepositoryInterface
{
    /**
     * Partial match on hotel name and/or exact match on prefecture.
     */
    public function search(HotelSearchCriteria $criteria): Collection
    {
        return Hotel::query()
            ->with("prefecture")
            ->when($criteria->hotelName !== null && $criteria->hotelName !== "", function ($query) use ($criteria) {
                // Escape LIKE wildcards so user input is matched literally.
                $escaped = addcslashes($criteria->hotelName, "%_\\");
                $query->where("hotel_name", "LIKE", "%" . $escaped . "%");
            })
            ->when($criteria->prefectureId !== null, function ($query) use ($criteria) {
                $query->where("prefecture_id", $criteria->prefectureId);
            })
            ->orderBy("hotel_id")
            ->get();
    }

    public function findOrFail(int $hotelId): Hotel
    {
        return Hotel::with("prefecture")->findOrFail($hotelId);
    }

    public function create(array $attributes): Hotel
    {
        return Hotel::create($attributes);
    }

    public function update(Hotel $hotel, array $attributes): Hotel
    {
        $hotel->update($attributes);

        return $hotel->refresh();
    }

    public function delete(Hotel $hotel): void
    {
        $hotel->delete();
    }
}
