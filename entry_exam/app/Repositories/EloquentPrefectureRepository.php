<?php

namespace App\Repositories;

use App\Models\Prefecture;
use App\Repositories\Contracts\PrefectureRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentPrefectureRepository implements PrefectureRepositoryInterface
{
    public function all(): Collection
    {
        return Prefecture::query()->orderBy("prefecture_id")->get();
    }
}
