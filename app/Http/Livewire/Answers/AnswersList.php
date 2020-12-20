<?php

namespace App\Http\Livewire\Answers;

use Auth;
use App\Models\Answer;
use App\Models\Question;

use Livewire\Component;

class AnswersList extends Component
{
    public $question;

    protected $listeners = [
        'answer-given' => '$refresh',
        'answer-accepted' => '$refresh'
    ];

    public function mount($question)
    {
        $this->question = $question;
    }

    public function render()
    {
        $accepted_answer_array = $this->accepted_answer();
        $accepted_answer_id = $accepted_answer_array[0];
        $accepted_answer = $accepted_answer_array[1];
        $answers_list = Answer::where('question_id', $this->question->question_id)
                                ->when($accepted_answer_id, function ($query, $accepted_answer_id) {
                                    return $query->orderByRaw("answer_id <> $accepted_answer_id");
                                })
                                ->orderBy('created_at', 'desc')
                                ->get();
        return view('livewire.answers.answers-list', [
            'answers_list' => $answers_list,
            'question' => $this->question,
            'accepted_answer' => $accepted_answer
        ]);
    }

    public function accepted_answer()
    {
        $question = Question::find($this->question->question_id);
        $accepted_answer = $question->accepted_answer;
        $accepted_answer_id = null;
        if ($accepted_answer)
        {
            $accepted_answer_id = $accepted_answer->answer_id;
        }
        return [$accepted_answer_id, $accepted_answer];
    }

    public function accept_answer($answer_id)
    {
        $answer = Answer::findOrFail($answer_id);
        if (
            !$this->accepted_answer()[0]
            && $answer->question_id == $this->question->question_id
            && (
                $this->question->user_id == Auth::id()
                || Auth::user()->role == 'teacher'
                )
            )
        {
            $this->question->accepted_answer_id = $answer->answer_id;
            $this->question->save();

            $this->emit('answer-accepted');
        }
    }
}
