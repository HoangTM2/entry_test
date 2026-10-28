<?php

namespace App\DTOs;

/**
 * Immutable search criteria for hotels.
 */
final class HotelSearchCriteria
{
    public function __construct(
        public readonly ?string $hotelName = null,
        public readonly ?int $prefectureId = null,
    ) {
    }
}
