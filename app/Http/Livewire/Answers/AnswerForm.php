<?php

namespace App\Http\Livewire\Answers;

use Auth;
use App\Models\Answer;

use Livewire\Component;

class AnswerForm extends Component
{
    public $answer_text;
    public $question;

    protected $rules = [
        'answer_text' => 'required|min:50',
    ];

    public function mount($question)
    {
        $this->question = $question;
    }

    public function render()
    {
        return view('livewire.answers.answer-form');
    }

    /**
     * Store a new answer.
     * 
     */
    public function create_answer()
    {
        $this->validate();

        $answer = new Answer;

        $answer->answer_text = $this->answer_text;
        $answer->question_id = $this->question->question_id;

        $answer->user_id = Auth::id();

        $answer->save();

        $this->dispatchBrowserEvent('answer-given');
        $this->emit('answer-given');
    }
}
