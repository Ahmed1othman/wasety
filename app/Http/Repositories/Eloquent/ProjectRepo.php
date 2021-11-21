<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\ProjectRepoInterface;
use App\Http\Repositories\Eloquent\AbstractRepo;
use App\Models\Project;



class ProjectRepo extends AbstractRepo implements ProjectRepoInterface
{
    public function __construct()
    {
        parent::__construct(Project::class);
    }



}
