<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CaseFile;
class Category extends Model
{
    protected $table='categorises';
    protected $guarded=['id'];
    protected $hidden=['id'];

    public function cases(){
        return $this->hasMany(CaseFile::class,'category_id');
    }
}
