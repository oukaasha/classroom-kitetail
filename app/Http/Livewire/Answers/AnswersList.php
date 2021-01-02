<?php

namespace App\Http\Livewire\Answers;

use Auth;
use App\Models\Answer;
use App\Models\Question;

use Livewire\Component;

class AnswersList extends Component
{
    public $display_edit_answer_form = false;
    public $confirming_answer_deletion = false;

    public $selected_answer_id;

    public $answer_text;

    public $question;

    protected $listeners = [
        'answer-given' => '$refresh',
        'answer-accepted' => '$refresh',
        'answer-deleted' => '$refresh',
        'answer-updated' => '$refresh',
        'question-deleted' => '$refresh'
    ];

    protected $rules = [
        'answer_text' => 'required|min:50',
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

    /**
     * Confirm deletion of a answer.
     * 
     * @param  int $answer_id
     */
    public function confirm_deletion($answer_id)
    {
        $answer = Answer::findOrFail($answer_id);
        if ($answer->user_id == Auth::id() || $this->question->user_id == Auth::id() || Auth::user()->is_teacher())
        {
            $this->selected_answer_id = $answer_id;
            $this->confirming_answer_deletion = true;
        }
    }

    /**
     * Delete an existing answer.
     * 
     */
    public function delete_answer()
    {
        $answer = Answer::findOrFail($this->selected_answer_id);
        if ($answer->user_id == Auth::id() || $this->question->user_id == Auth::id() || Auth::user()->is_teacher())
        {
            $answer->delete();
    
            $this->selected_answer_id = null;
            $this->confirming_answer_deletion = false;
    
            $this->emit('answer-deleted');
        }
    }

    /**
     * Display form for editing a answer.
     * 
     * @param  int $answer_id
     */
    public function display_edit_form($answer_id)
    {
        $answer = Answer::findOrFail($answer_id);
        if ($answer->user_id == Auth::id() || $this->question->user_id == Auth::id() || Auth::user()->is_teacher())
        {
            $this->selected_answer_id = $answer->answer_id;
            
            $this->answer_text = $answer->answer_text;

            $this->display_edit_answer_form = true;
        }
    }

    /**
     * Update an existing answer.
     * 
     */
    public function update_answer()
    {
        $answer = Answer::findOrFail($this->selected_answer_id);
        if ($answer->user_id == Auth::id() || $this->question->user_id == Auth::id() || Auth::user()->is_teacher())
        {
            $this->validate();

            $answer->answer_text = $this->answer_text;

            $answer->save();

            $this->answer_text = '';
            $this->selected_answer_id = null;
            $this->display_edit_answer_form = false;
    
            $this->emit('answer-updated');
        }
    }

}
