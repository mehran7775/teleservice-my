<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class CaseFile extends Model
{
    protected $guarded=['id'];
    public $timestamps=false;


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
