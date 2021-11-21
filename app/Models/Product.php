<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded=[];
    public $appends=['image','name','details'];

    public function getImageAttribute()
    {
        return array_key_exists('photo', $this->attributes) && $this->attributes['photo'] != null ? asset('storage/products/' . $this->attributes['photo']) : null;
    }

    public function getNameAttribute()
    {
        if(App::isLocale('en'))
        {
            return $this->attributes['name_en'] ?? $this->attributes['name_ar'];
        }
        else{
            return $this->attributes['name_ar'] ?? $this->attributes['name_en'];
        }
    }

    public function getDetailsAttribute()
    {
        if(App::isLocale('en'))
        {
            return $this->attributes['details_en'] ?? $this->attributes['details_ar'];
        }
        else{
            return $this->attributes['details_ar'] ?? $this->attributes['details_en'];
        }
    }
}
