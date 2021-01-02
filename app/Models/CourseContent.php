<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseContent extends Model
{
    use HasFactory;

    protected $primaryKey = 'course_content_id';

    public function user () {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function course () {
        return $this->belongsTo('App\Models\Course', 'course_id', 'course_id');
    }
}