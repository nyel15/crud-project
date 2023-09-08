<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForeignStudents extends Model
{
    public function allStudents(){
        return $this->hasMany(AllStudents::class);
    }
}