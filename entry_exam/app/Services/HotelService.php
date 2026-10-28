<?php

namespace App\Services;

use App\DTOs\HotelSearchCriteria;
use App\Models\Hotel;
use App\Repositories\Contracts\HotelRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

class HotelService
{
    public function __construct(
        private readonly HotelRepositoryInterface $hotels,
        private readonly HotelImageStorage $images,
    ) {
    }

    public function search(HotelSearchCriteria $criteria): Collection
    {
        return $this->hotels->search($criteria);
    }

    public function find(int $hotelId): Hotel
    {
        return $this->hotels->findOrFail($hotelId);
    }

    public function create(string $name, int $prefectureId, ?UploadedFile $image): Hotel
    {
        return $this->hotels->create([
            "hotel_name" => $name,
            "prefecture_id" => $prefectureId,
            "file_path" => $image ? $this->images->store($image) : null,
        ]);
    }

    /**
     * Step 2 (confirm): keep the new image as a temp file and return data to hold in session.
     */
    public function stageUpdate(
        string $name,
        int $prefectureId,
        ?UploadedFile $image,
        ?array $previous = null,
        ?string $existingTempImage = null
    ): array {
        $tempImage = null;
        if ($image) {
            $this->discardStaged($previous);
            $tempImage = $this->images->storeTemp($image);
        } elseif ($existingTempImage && $previous && ($previous["temp_image"] ?? null) === $existingTempImage) {
            $tempImage = $existingTempImage;
        } else {
            $this->discardStaged($previous);
        }

        return [
            "hotel_name" => $name,
            "prefecture_id" => $prefectureId,
            "temp_image" => $tempImage,
        ];
    }

    /**
     * Step 3 (complete): persist staged data.
     */
    public function commitUpdate(int $hotelId, array $staged): Hotel
    {
        $hotel = $this->hotels->findOrFail($hotelId);
        $attributes = [
            "hotel_name" => $staged["hotel_name"],
            "prefecture_id" => $staged["prefecture_id"],
        ];

        if (!empty($staged["temp_image"])) {
            $this->images->delete($hotel->file_path);
            $attributes["file_path"] = $this->images->promote($staged["temp_image"]);
        }

        return $this->hotels->update($hotel, $attributes);
    }

    public function discardStaged(?array $staged): void
    {
        if (!empty($staged["temp_image"])) {
            $this->images->delete($staged["temp_image"]);
        }
    }

    public function delete(int $hotelId): void
    {
        $hotel = $this->hotels->findOrFail($hotelId);
        $this->images->delete($hotel->file_path);
        $this->hotels->delete($hotel);
    }
}
