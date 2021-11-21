<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

class Slider extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded=[];
    public $appends=['name','description','image'];


    public function getNameAttribute()
    {
        if(App::isLocale('en'))
        {
            return $this->attributes['title_en'] ?? $this->attributes['title_ar'];
        }
        else{
            return $this->attributes['title_ar'] ?? $this->attributes['title_en'];
        }
    }

    public function getDescriptionAttribute()
    {
        if(App::isLocale('en'))
        {
            return $this->attributes['title_en'] ?? $this->attributes['title_ar'];
        }
        else{
            return $this->attributes['title_ar'] ?? $this->attributes['title_en'];
        }
    }


    public function getImageAttribute()
    {
        return $this->attributes['photo'] != null ? asset('storage/sliders/'.$this->attributes['photo'] ) : null;
    }
}
