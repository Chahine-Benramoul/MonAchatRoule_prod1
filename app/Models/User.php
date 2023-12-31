<?php

namespace App\Models;

use App\Models\rating;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Mockery\Undefined;
use PhpParser\Builder\Function_;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    // Defaults values for each of our data
    protected $attributes = [
        'is_admin' => false,
        'is_blocked' => false,
        'email_notification' => false,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'username',
        'phone',
        'email',
        "userimage",
        'password',
        'email_notification',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function getDisplayName(){
        $name = $this->name;
        $surname =  $this->surname;
        return $name . " " .$surname;
    }
    public function getNoteGlobale(){
        $ratings = rating::where('userid', $this->id)->pluck('etoiles');
        $avg = $ratings->avg();
        if($avg == null){return 0;}
        return $avg;
    }
    public function getImage(){
        if($this->userimage != null){
            return $this->userimage;
        }
        return "https://upload.wikimedia.org/wikipedia/commons/8/89/Portrait_Placeholder.png";
        //return "https://www.dovercourt.org/wp-content/uploads/2019/11/610-6104451_image-placeholder-png-user-profile-placeholder-image-png-286x300.jpg";
    }
    public function getPublications()
    {
        return $this->hasMany(Publication::class, 'user_id');
    }
    public function userrels() {
        return $this->hasMany(Userrels::class, 'user_sender', 'id')
                    ->orWhere('user_target', 'id');
    }
    public Function getPublicationsCountForDisplay(){
        $pubs = $this->getPublications;
        $count = 0;
        foreach ($pubs as $key => $p) {
            if($p->hidden == false)
                $count += 1;
        }
        return $count;
    }

    public function getAnnonces(){return $this->getPublications();}
    public function getMessages()
    {
        return $this->hasMany(chatmessages::class, 'userid');
    }
    public function getNotifications(){
        return $this->hasMany(notification::class,"userid");
    }

    public function isAdmin(){
        return $this->is_admin;
    }
    //https://stackoverflow.com/questions/46841159/laravel-hasmany-and-belongsto-parameters
    /*
        To simplify the syntax, think of the return $this->hasMany('App\Comment', 'foreign_key', 'local_key'); parameters as:

        The model you want to link to
        The column of the foreign table (the table you are linking to) that links back to the id column of the current table (unless you are specifying the third parameter, in which case it will use that)
        The column of the current table that should be used - i.e if you don't want the foreign key of the other table to link to the id column of the current table
    */
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

}
