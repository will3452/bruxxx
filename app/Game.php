<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function questions(){
        return $this->hasMany(Question::class);
    }


}