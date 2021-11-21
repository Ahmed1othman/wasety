<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded=[];
    public $appends=['image'];




    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
    public function offer()
    {
        return $this->belongsTo('App\Models\Offer','offer_id','id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($model) {
             $model->offer()->delete();
        });
    }

    public function getImageAttribute()
    {
        return array_key_exists('photo', $this->attributes) && $this->attributes['photo'] != null ? asset('storage/projects/' . $this->attributes['photo']) : null;
    }

    public function rateable()
    {
        return $this->morphMany('App\Models\Rate', 'rateable');
    }

}
