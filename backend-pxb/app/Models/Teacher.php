<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name} {$this->patronymic}";
    }

    public function courses(){
        return $this->hasMany(Course::class, 'teacher_id');
    }
}
