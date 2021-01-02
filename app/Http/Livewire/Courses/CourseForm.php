<?php

namespace App\Http\Livewire\Courses;

use Auth;
use App\Models\Course;

use Livewire\Component;

class CourseForm extends Component
{
    public $course_name;

    protected $rules = [
        'course_name' => 'required'
    ];

    public function render()
    {
        return view('livewire.courses.course-form');
    }

    /**
     * Store a new course.
     * 
     */
    public function create_course()
    {
        $this->validate();

        $course = new Course;

        $course->course_name = $this->course_name;

        $course->user_id = Auth::id();

        $course->save();

        $this->dispatchBrowserEvent('course-added');
        $this->emit('course-added');
    }
}
