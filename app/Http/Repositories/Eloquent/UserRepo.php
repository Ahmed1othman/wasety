<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\UserRepoInterface;
use App\Http\Repositories\Eloquent\AbstractRepo;
use App\Models\User;



class UserRepo extends AbstractRepo implements UserRepoInterface
{
    public function __construct()
    {
        parent::__construct(User::class);
    }



}
