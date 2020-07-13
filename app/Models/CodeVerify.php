<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class CodeVerify extends Model
{
    protected $table='code_verifies';
    protected $guarded=['id'];
    public $timestamps=false;

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
