<?php

namespace App;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password','role', 'aan_id','picture','vip','bruname','room'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        if (is_null($this->last_name)) {
            return "{$this->first_name}";
        }

        return "{$this->first_name} {$this->last_name}";
    }

    public function getCollegeAttribute(){
        return $this->interests()->where('type', 'college')->first()->name ?? '';
    }

    /**
     * Set the user's password.
     *
     * @param string $value
     * @return void
     */
    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = bcrypt($value);
    // }

    public function aan(){
        return $this->belongsTo(AAN::class, 'aan_id');
    }

    public function pens(){
        return $this->hasMany(Pen::class, 'user_id');
    }

    public function bio(){
        return $this->hasOne(Bio::class, 'user_id');
    }

    public function interests(){
        return $this->hasMany(Interest::class, 'user_id');
    }

    
    public function books(){
        return $this->hasMany(Book::class);
    }

    public function arts(){
        return $this->hasMany(Art::class);
    }

    public function thrailers(){
        return $this->hasMany(Thrailer::class);
    }

    public function avatar(){
        return $this->belongsTo(Avatar::class);
    }


    public function events(){
        return $this->morphMany(Event::class, 'eventable');
    }

    public function audio(){
        return $this->hasMany(Audio::class);
    }

    public function songs(){
        return $this->hasMany(Song::class);
    }

    public function podcasts(){
        return $this->hasMany(Podcast::class);
    }


    public function createGroups(){
        return $this->hasMany(Group::class,'creator_id');
    }

    public function groups(){
        return $this->belongsToMany(Group::class)->withPivot('title');
    }

    public function getApprovedGroupsAttribute(){
        return $this->groups()->whereNotNull('approved');
    }

    public function conversations(){
        return $this->belongsToMany(Conversation::class);
    }

    public function inboxes(){
        return  $this->hasMany(Message::class, 'receiver_id');
    }

    public function outboxes(){
        return  $this->hasMany(Message::class, 'sender_id');
    }

    public function getUnreadMessagesAttribute(){
        return $this->inboxes()->whereNull('read_at')->get();
    }

    public function series(){
        return $this->hasMany(Series::class);
    }

    public function collections(){
        return $this->hasMany(Collection::class);
    }

    public function albums(){
        return $this->hasMany(Album::class);
    }

    public function sharedSeries(){
        //books, audio books, film, podcasts 
       $shared_series =collect();
       $id = $this->id;

       $no_series = Series::where('user_id', '!=', $this->id)->get();

       foreach($no_series as $s){
           if(
               $s->books()->where('user_id',$id)->get()||
               $s->audios()->where('user_id', $id)->get() || 
               $s->films()->where('user_id', $id)->get() || 
               $s->podcasts()->where('user_id', $id)
               ){
                   $shared_series->push($s);
               }
       }
       return $shared_series->all();
    }

    

}
