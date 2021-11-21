<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

class Country extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='countries';
    protected $guarded=[];

    public function users()
    {
        return $this->hasMany('App\User');
    }

}
