<?php

namespace App\DTOs;

/**
 * Immutable search criteria for bookings. Dates are Y-m-d strings.
 */
final class BookingSearchCriteria
{
    public function __construct(
        public readonly ?string $customerName = null,
        public readonly ?string $customerContact = null,
        public readonly ?string $checkinDate = null,
        public readonly ?string $checkoutDate = null,
    ) {
    }
}
