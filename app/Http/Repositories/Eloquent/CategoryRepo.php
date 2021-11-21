<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\CategoryRepoInterface;
use App\Http\Repositories\Eloquent\AbstractRepo;
use App\Models\Category;



class CategoryRepo extends AbstractRepo implements CategoryRepoInterface
{
    public function __construct()
    {
        parent::__construct(Category::class);
    }



}
