<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\OfferRepoInterface;
use App\Models\Offer;

class OfferRepo extends AbstractRepo implements OfferRepoInterface
{

    public function __construct()
    {
        parent::__construct(Offer::class);
    }

}
