<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayLog extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function user(){//test
        return $this->belongsTo(User::class);
    }
}
