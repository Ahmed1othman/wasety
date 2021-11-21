<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\RateRepoInterface;
use App\Models\Rate;

class RateRepo extends AbstractRepo implements RateRepoInterface
{

    public function __construct()
    {
        parent::__construct(Rate::class);
    }

}
