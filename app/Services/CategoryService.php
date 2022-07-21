<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class CategoryService extends BaseService
{
    function repositoryName(): string
    {
        return CategoryRepository::class;
    }

  

}
