<?php

namespace App;

use App\Models\CaseFile;
use App\Models\File;
use App\Models\Address;
use App\Models\CodeVerify;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;/**
 * The attributes that are mass assignable.
 *
 * @var array
 */
    public $timestamps=false;

    const OPERATOR = 1;
    const EXPERT = 2;
    const ADMIN = 3;

    protected $guarded = [
        'id'
    ];
    protected $hidden = [
        'id','remember_token','password'
    ];

    public function codeVerifies()
    {
        return $this->hasMany(CodeVerify::class,'user_id');
    }
    public function setPasswordAttribute($value)
    {
        $this->attributes['password']=bcrypt($value);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class,'user_id');
    }

    public function caseFiles()
    {
        return $this->hasMany(CaseFile::class);
    }
}
