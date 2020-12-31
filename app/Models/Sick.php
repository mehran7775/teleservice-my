<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sick extends Model
{
    protected $guarded=['id'];
    public $timestamps=false;
    
    public function cases(){
        return $this->hasMany(CaseFile::calss,'sick_id');
    }

}
