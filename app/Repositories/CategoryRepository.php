<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CategoryRepository extends BaseRepository
{
    function modelName(): string
    {
        return Category::class;
    }

}
