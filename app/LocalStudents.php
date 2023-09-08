<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocalStudents extends Model
{
    public function allStudents(){
        return $this->hasMany(AllStudents::class);
    }
    
}