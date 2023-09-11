<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AllStudents extends Model
{   
    public function localStudents(){
        return $this->belongsTo(LocalStudents::class, 'local_student_id');
    }
    public function foreignStudents(){
        return $this->belongsTo(ForeignStudents::class, 'foreign_student_id');
    }

    protected $table = 'all_students';
}