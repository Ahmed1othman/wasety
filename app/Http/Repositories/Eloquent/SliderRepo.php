<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\SliderRepoInterface;
use App\Http\Repositories\Eloquent\AbstractRepo;
use App\Models\Slider;



class SliderRepo extends AbstractRepo implements SliderRepoInterface
{
    public function __construct()
    {
        parent::__construct(Slider::class);
    }



}
