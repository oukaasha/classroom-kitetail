<?php

namespace App\Http\Livewire\Questions;

use App\Models\Question;

use Livewire\Component;

class QuestionsList extends Component
{
    protected $listeners = ['question-added' => 'render'];

    public function render()
    {
        $question_list = Question::orderBy('created_at', 'desc')->get();
        return view('livewire.questions.questions-list', compact('question_list'));
    }
}
