<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $primaryKey = 'answer_id';

    public function user () {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function question () {
        return $this->belongsTo('App\Models\Question', 'question_id', 'question_id');
    }
}
