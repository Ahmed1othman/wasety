<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\PartnerRepoInterface;
use App\Http\Repositories\Eloquent\AbstractRepo;
use App\Models\Partner;



class PartnerRepo extends AbstractRepo implements PartnerRepoInterface
{
    public function __construct()
    {
        parent::__construct(Partner::class);
    }



}
