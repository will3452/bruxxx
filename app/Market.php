<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function bulletin(){
        return $this->hasOne(Bulletin::class, 'market_id');
    }

    public function announcement(){
        return $this->hasOne(Announcement::class, 'market_id');
    }
}
