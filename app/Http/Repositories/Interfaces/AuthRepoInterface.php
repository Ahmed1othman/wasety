<?php

namespace App\Http\Repositories\Interfaces;


interface AuthRepoInterface
{
    public function login(array $data);
    public function register(array $data);
    public function currentUser();

    public function logout($request);
}
