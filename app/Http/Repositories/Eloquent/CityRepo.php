<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\CityRepoInterface;
use App\Http\Repositories\Eloquent\AbstractRepo;
use App\Models\City;



class CityRepo extends AbstractRepo implements CityRepoInterface
{
    public function __construct()
    {
        parent::__construct(City::class);
    }



}
