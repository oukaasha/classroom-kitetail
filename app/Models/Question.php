<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $primaryKey = 'question_id';

    public function user () {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function answers () {
        return $this->hasMany('App\Models\Answer', 'question_id', 'question_id');
    }

    public function accepted_answer () {
        return $this->belongsTo('App\Models\Answer', 'accepted_answer_id', 'answer_id');
    }
}
