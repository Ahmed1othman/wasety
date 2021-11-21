<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\PaymentRepoInterface;
use App\Http\Repositories\Eloquent\AbstractRepo;
use App\Models\Payment;



class PaymentRepo extends AbstractRepo implements PaymentRepoInterface
{
    public function __construct()
    {
        parent::__construct(Payment::class);
    }



}
