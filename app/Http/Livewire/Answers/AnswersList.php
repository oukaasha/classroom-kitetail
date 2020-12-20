<?php

namespace App\Http\Livewire\Answers;

use Auth;
use App\Models\Answer;
use App\Models\Question;

use Livewire\Component;

class AnswersList extends Component
{
    public $question;
    public $accepted_answer;

    protected $listeners = [
        'answer-given' => 'render',
        'answer-accepted' => 'render'
    ];

    public function mount($question)
    {
        $this->question = $question;
        $this->accepted_answer = $question->accepted_answer;
    }

    public function render()
    {
        $accepted_answer_id = $this->question->accepted_answer_id;
        $answers_list = Answer::where('question_id', $this->question->question_id)
                                ->when($accepted_answer_id, function ($query, $accepted_answer_id) {
                                    return $query->orderByRaw("answer_id <> $accepted_answer_id");
                                })
                                ->orderBy('created_at', 'desc')
                                ->get();
        return view('livewire.answers.answers-list', [
            'answers_list' => $answers_list,
            'question' => $this->question,
            'accepted_answer' => $this->accepted_answer
        ]);
    }

    public function accept_answer($answer_id)
    {
        $answer = Answer::findOrFail($answer_id);
        if (
            $answer->question_id == $this->question->question_id
            && (
                $this->question->user_id == Auth::id()
                || Auth::user()->role == 'teacher'
                )
            )
        {
            $this->question->accepted_answer_id = $answer->answer_id;
            $this->question->save();

            $this->accepted_answer = $answer;
            $this->emit('answer-accepted');
        }
    }
}
