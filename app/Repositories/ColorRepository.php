<?php

namespace App\Repositories;

use App\Models\Color;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ColorRepository extends BaseRepository
{
    function modelName(): string
    {
        return Color::class;
    }

}
