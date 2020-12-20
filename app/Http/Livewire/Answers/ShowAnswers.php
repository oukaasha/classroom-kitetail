<?php

namespace App\Http\Livewire\Answers;

use Auth;
use App\Models\Question;

use Livewire\Component;

class ShowAnswers extends Component
{
    public $question;

    public function mount($question_id)
    {
        $this->question = Question::findOrFail($question_id);
    }

    public function render()
    {
        return view('livewire.answers.show-answers');
    }
}
