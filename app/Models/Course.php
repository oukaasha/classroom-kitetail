<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $primaryKey = 'course_id';

    public function user () {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function course_content () {
        return $this->hasMany('App\Models\CourseContent', 'course_id', 'course_id');
    }
}
