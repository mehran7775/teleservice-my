<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $guarded=['id'];
    protected $hidden=['id'];
    public $timestamps=false;
    public function user()
    {
        return $this->belongsTo(User::class);
        
    }
}
