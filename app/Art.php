<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Art extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'arts';
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    
    public function cpy(){
        return $this->morphOne(Cpy::class, 'cpiable');
    }

    public function tags(){
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function  recommendation(){
        return $this->morphOne(Recommendation::class, 'recommendationable');
    }

    public static function GETPUBLISHED(){
        return self::get();
    }

}
