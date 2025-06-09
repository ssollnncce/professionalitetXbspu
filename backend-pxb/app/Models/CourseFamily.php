<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseFamily extends Model
{
    public function courses()
    {
        return $this->hasMany(Course::class, 'course_family_id');
    }
}
