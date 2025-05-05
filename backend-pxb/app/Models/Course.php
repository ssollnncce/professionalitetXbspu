<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\CourseFamily;
use App\Models\Teacher;

class Course extends Model
{
    protected $casts = [
        'start_date' => 'datetime',
    ];

    public function teacher(){
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function courseFamily(){
        return $this->belongsTo(CourseFamily::class, 'course_family_id');
    }
}
