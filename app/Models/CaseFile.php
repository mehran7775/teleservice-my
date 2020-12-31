<?php

namespace App\Models;

use App\User;
use App\Models\Sick;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class CaseFile extends Model
{
    protected $table='cases';
    protected $guarded=['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function sick(){
        return $this->belongsTo(Sick::class,'sick_id');
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
