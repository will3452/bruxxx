<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Multicaret\Acquaintances\Traits\CanBeSubscribed;

class Art extends Model
{
    use HasFactory, SoftDeletes;
    use CanBeSubscribed;

    protected $table = 'arts';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function recommendation()
    {
        return $this->morphOne(Recommendation::class, 'recommendationable');
    }

    public function tickets()
    {
        return $this->morphMany(Ticket::class, 'ticketable');
    }

    public static function GETPUBLISHED()
    {
        return self::get();
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function stars()
    {
        return $this->morphMany(Star::class, 'starable');
    }

    public function collections()
    {
        return $this->morphToMany(Collection::class, 'collectionable');
    }

    public function albums()
    {
        return $this->morphToMany(Album::class, 'albumable');
    }

    public function boxes()
    {
        return $this->morphToMany(Box::class, 'boxable');
    }

    public function games()
    {
        return $this->hasMany(Game::class);
    }

}
