<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForeignStudents extends Model
{
    public function allStudents(){
        return $this->hasMany(AllStudents::class);
    }

    protected $table = 'foreign_students';
    protected $fillable = ['student_type', 'id_number', 'name', 'age', 'gender', 'city', 'mobile_number', 'grades', 'email'];
}