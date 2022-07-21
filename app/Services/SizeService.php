<?php

namespace App\Services;

use App\Repositories\SizeRepository;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class SizeService extends BaseService
{
    function repositoryName(): string
    {
        return SizeRepository::class;
    }

}
