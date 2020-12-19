<?php

namespace App\Http\Livewire\Questions;

use Auth;
use App\Models\Question;

use Livewire\Component;

class QuestionForm extends Component
{
    public $question_text;
    public $question_description;

    protected $rules = [
        'question_text' => 'required|max:120',
        'question_description' => 'required',
    ];

    public function render()
    {
        return view('livewire.questions.question-form');
    }

    /**
     * Store a new question.
     * 
     */
    public function create_question()
    {
        $this->validate();

        $question = new Question;

        $question->question_text = $this->question_text;
        $question->question_description = $this->question_description;

        $question->user_id = Auth::id();

        $question->save();

        $this->dispatchBrowserEvent('question-added');
        $this->emit('question-added');
    }
}
