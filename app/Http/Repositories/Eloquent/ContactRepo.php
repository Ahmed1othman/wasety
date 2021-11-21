<?php

namespace App\Http\Repositories\Eloquent;
use App\Http\Repositories\Interfaces\ContactRepoInterface;
use App\Models\Contact;

class ContactRepo extends AbstractRepo  implements ContactRepoInterface
{
    public function __construct()
    {
        parent::__construct(Contact::class);
    }

}
