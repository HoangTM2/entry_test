<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Handles hotel image files under public/assets/img/hotel.
 * Paths returned are relative to public/assets/img (the value stored in hotels.file_path).
 */
class HotelImageStorage
{
    private const BASE_DIR = "assets/img/";
    private const HOTEL_DIR = "hotel";
    private const TEMP_DIR = "hotel/tmp";

    public function store(UploadedFile $file): string
    {
        return $this->move($file, self::HOTEL_DIR);
    }

    /**
     * Keep an uploaded file temporarily until the edit is confirmed.
     */
    public function storeTemp(UploadedFile $file): string
    {
        return $this->move($file, self::TEMP_DIR);
    }

    /**
     * Move a temp image to its permanent location.
     */
    public function promote(string $tempPath): string
    {
        $target = self::HOTEL_DIR . "/" . basename($tempPath);

        File::ensureDirectoryExists($this->absolute(self::HOTEL_DIR));
        File::move($this->absolute($tempPath), $this->absolute($target));

        return $target;
    }

    /**
     * Delete only images uploaded through the admin (never the seeded hoteltype images).
     */
    public function delete(?string $path): void
    {
        if ($path === null || !Str::startsWith($path, self::HOTEL_DIR . "/")) {
            return;
        }

        File::delete($this->absolute($path));
    }

    private function move(UploadedFile $file, string $dir): string
    {
        $targetDir = $this->absolute($dir);
        File::ensureDirectoryExists($targetDir);

        $name = Str::uuid() . "." . $file->getClientOriginalExtension();
        $file->move($targetDir, $name);

        return $dir . "/" . $name;
    }

    private function absolute(string $path): string
    {
        return public_path(self::BASE_DIR . $path);
    }
}
