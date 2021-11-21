<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

class Partner extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=['name_en','name_ar','photo','url','active'];
    public $appends=['name','image'];


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


    public function getImageAttribute()
    {
        return $this->attributes['photo'] != null ? asset('storage/partners/'.$this->attributes['photo'] ) : null;

    }
}

