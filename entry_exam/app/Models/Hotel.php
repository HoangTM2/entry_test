<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hotel extends Model
{
    /**
     * @var string
     */
    protected $primaryKey = 'hotel_id';

    /**
     * @var array
     */
    protected $guarded = ['hotel_id'];

    public const DEFAULT_IMAGE = 'no_image.png';

    /**
     * Fallback to default image when image is missing or physical file was deleted.
     */
    public function getFilePathAttribute(?string $value): string
    {
        if ($value && file_exists(public_path('assets/img/' . $value))) {
            return $value;
        }

        return self::DEFAULT_IMAGE;
    }

    /**
     * Determine if hotel has custom uploaded image that exists on disk.
     */
    public function hasCustomImage(): bool
    {
        $raw = $this->getRawOriginal('file_path');

        return $raw !== null && file_exists(public_path('assets/img/' . $raw));
    }

    /**
     * @return BelongsTo
     */
    public function prefecture(): BelongsTo
    {
        return $this->belongsTo(Prefecture::class, 'prefecture_id', 'prefecture_id');
    }

    /**
     * @return HasMany
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'hotel_id', 'hotel_id');
    }

    /**
     * Search hotel by hotel name (partial match).
     *
     * @param string $hotelName
     * @return array
     */
    public static function getHotelListByName(string $hotelName): array
    {
        $escaped = addcslashes($hotelName, "%_\\");

        return self::query()
            ->where('hotel_name', 'LIKE', '%' . $escaped . '%')
            ->with('prefecture')
            ->orderBy('hotel_id')
            ->get()
            ->toArray();
    }

    /**
     * Override serializeDate method to customize date format
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
