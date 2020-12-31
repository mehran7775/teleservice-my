<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $guarded=['id'];
    public $timestamps=false;
    protected $table='addresses';
}
