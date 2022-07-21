<?php

namespace App\Services;

use App\Repositories\ColorRepository;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class ColorService extends BaseService
{
    function repositoryName(): string
    {
        return ColorRepository::class;
    }

}
