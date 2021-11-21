<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\CountryRepoInterface;
use App\Http\Repositories\Eloquent\AbstractRepo;
use App\Models\Country;



class CountryRepo extends AbstractRepo implements CountryRepoInterface
{
    public function __construct()
    {
        parent::__construct(Country::class);
    }



}
