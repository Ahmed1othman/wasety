<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\ProductRepoInterface;
use App\Http\Repositories\Eloquent\AbstractRepo;
use App\Models\Product;



class ProductRepo extends AbstractRepo implements ProductRepoInterface
{
    public function __construct()
    {
        parent::__construct(Product::class);
    }



}
