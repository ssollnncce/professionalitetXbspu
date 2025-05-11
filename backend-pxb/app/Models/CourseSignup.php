<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseSignup extends Model
{
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
    public function user()
    {
        return $this->belongsToMany(User::class, 'users_id');
    }
}
