<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }


     public function series()
    {
        return $this->morphToMany(Series::class, 'seriesable');
    }

    public function tickets()
    {
        return $this->morphMany(Ticket::class, 'ticketable');
    }

}
