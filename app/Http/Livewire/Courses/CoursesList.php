<?php

namespace App\Http\Livewire\Courses;

use Auth;
use App\Models\Course;
use App\Models\CourseContent;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class CoursesList extends Component
{
    public $display_edit_course_form = false;
    public $confirming_course_deletion = false;

    public $selected_course_id;

    public $course_name;
    
    protected $listeners = [
        'course-added' => '$refresh',
        'course-deleted' => '$refresh',
        'course-updated' => '$refresh'
    ];

    protected $rules = [
        'course_name' => 'required',
    ];

    public function render()
    {
        $course_list = Course::orderBy('created_at', 'desc')->get();
        return view('livewire.courses.courses-list', compact('course_list'));
    }

    /**
     * Confirm deletion of a course.
     * 
     * @param  int $course_id
     */
    public function confirm_deletion($course_id)
    {
        $course = Course::findOrFail($course_id);
        if ($course->user_id == Auth::id() && Auth::user()->is_teacher())
        {
            $this->selected_course_id = $course_id;
            $this->confirming_course_deletion = true;
        }
    }

    /**
     * Delete an existing course.
     * 
     */
    public function delete_course()
    {
        $course = Course::findOrFail($this->selected_course_id);
        if ($course->user_id == Auth::id() && Auth::user()->is_teacher())
        {
            $course_content_list = CourseContent::where('course_id', $course->course_id)->get();
            foreach ($course_content_list as $course_content)
            {
                try
                {
                    Storage::delete($course_content->course_content_file_path);
                }
                catch (\Throwable $e)
                {
                    // Do something
                }
    
                $course_content->delete();
            }
            $course->delete();
    
            $this->selected_course_id = null;
            $this->confirming_course_deletion = false;
    
            $this->emit('course-deleted');
        }
    }

    /**
     * Display form for editing a course.
     * 
     * @param  int $course_id
     */
    public function display_edit_form($course_id)
    {
        $course = Course::findOrFail($course_id);
        if ($course->user_id == Auth::id() && Auth::user()->is_teacher())
        {
            $this->selected_course_id = $course->course_id;
            
            $this->course_name = $course->course_name;

            $this->display_edit_course_form = true;
        }
    }

    /**
     * Update an existing course.
     * 
     */
    public function update_course()
    {
        $course = Course::findOrFail($this->selected_course_id);
        if ($course->user_id == Auth::id() && Auth::user()->is_teacher())
        {
            $this->validate();

            $course->course_name = $this->course_name;

            $course->save();

            $this->course_name = '';
            $this->selected_course_id = null;
            $this->display_edit_course_form = false;
    
            $this->emit('course-updated');
        }
    }
}
