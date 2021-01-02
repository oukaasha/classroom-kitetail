<?php

namespace App\Http\Livewire\Questions;

use Auth;
use App\Models\Question;

use Livewire\Component;

class QuestionsList extends Component
{
    public $display_edit_question_form = false;
    public $confirming_question_deletion = false;

    public $selected_question_id;

    public $question_text;
    public $question_description;

    protected $listeners = [
        'question-added' => '$refresh',
        'question-deleted' => '$refresh',
        'question-updated' => '$refresh'
    ];

    protected $rules = [
        'question_text' => 'required|max:120',
        'question_description' => 'required',
    ];

    public function render()
    {
        $question_list = Question::orderBy('created_at', 'desc')->get();
        return view('livewire.questions.questions-list', compact('question_list'));
    }

    /**
     * Confirm deletion of a question.
     * 
     * @param  int $question_id
     */
    public function confirm_deletion($question_id)
    {
        $question = Question::findOrFail($question_id);
        if ($question->user_id == Auth::id() || Auth::user()->is_teacher())
        {
            $this->selected_question_id = $question_id;
            $this->confirming_question_deletion = true;
        }
    }

    /**
     * Delete an existing question.
     * 
     */
    public function delete_question()
    {
        $question = Question::findOrFail($this->selected_question_id);
        if ($question->user_id == Auth::id() || Auth::user()->is_teacher())
        {
            $question->answers()->delete();
            $question->delete();
    
            $this->selected_question_id = null;
            $this->confirming_question_deletion = false;
    
            $this->emit('question-deleted');
        }
    }

    /**
     * Display form for editing a question.
     * 
     * @param  int $question_id
     */
    public function display_edit_form($question_id)
    {
        $question = Question::findOrFail($question_id);
        if ($question->user_id == Auth::id() || Auth::user()->is_teacher())
        {
            $this->selected_question_id = $question->question_id;
            
            $this->question_text = $question->question_text;
            $this->question_description = $question->question_description;

            $this->display_edit_question_form = true;
        }
    }

    /**
     * Update an existing question.
     * 
     */
    public function update_question()
    {
        $question = Question::findOrFail($this->selected_question_id);
        if ($question->user_id == Auth::id() || Auth::user()->is_teacher())
        {
            $this->validate();

            $question->question_text = $this->question_text;
            $question->question_description = $this->question_description;

            $question->save();

            $this->question_text = '';
            $this->question_description = '';
            $this->selected_question_id = null;
            $this->display_edit_question_form = false;
    
            $this->emit('question-updated');
        }
    }

}
