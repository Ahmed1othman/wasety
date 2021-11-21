<?php

namespace App\Http\Repositories\Eloquent;
use App\Http\Repositories\Interfaces\NotificationsRepoInterface;
use App\Models\NotificationApi;
class NotificationsRepo extends AbstractRepo implements NotificationsRepoInterface
{

    public function __construct()
    {
        parent::__construct(NotificationApi::class);
    }

}
