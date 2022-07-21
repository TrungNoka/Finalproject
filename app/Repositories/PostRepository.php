<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class PostRepository extends BaseRepository
{
    function modelName(): string
    {
        return Post::class;
    }

}
