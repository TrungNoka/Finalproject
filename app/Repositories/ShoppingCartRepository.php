<?php

namespace App\Repositories;

use App\Models\ShoppingCart;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ShoppingCartRepository extends BaseRepository
{
    function modelName(): string
    {
        return ShoppingCart::class;
    }
}
