<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rate extends Model
{
    use HasFactory;
    use SoftDeletes;

   protected $guarded = [];


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public $appends = ['image'];

    public function getImageAttribute()
    {
        return array_key_exists('photo', $this->attributes) && $this->attributes['photo'] != null ? asset('storage/rates/' . $this->attributes['photo']) : null;
    }


    public function rateable()
    {
        return $this->morphTo();
    }
}
