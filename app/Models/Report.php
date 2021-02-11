<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\CaseFile;

class Report extends Model
{
    protected $guarded=['id'];
    protected $hidden=['id','content','case_id','user_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function caseFile()
    {
        return $this->belongsTo(CaseFile::class,'case_id');
    }
}
