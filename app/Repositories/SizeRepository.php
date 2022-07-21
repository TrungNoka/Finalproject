<?php

namespace App\Repositories;

use App\Models\Size;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SizeRepository extends BaseRepository
{
    function modelName(): string
    {
        return Size::class;
    }

}
