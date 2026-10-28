<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface PrefectureRepositoryInterface
{
    public function all(): Collection;
}
