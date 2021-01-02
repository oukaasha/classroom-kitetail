<?php

namespace App\Http\Livewire\Courses;

use Auth;
use App\Models\Course;
use App\Models\CourseContent;

use Livewire\Component;
use Livewire\WithFileUploads;

use Illuminate\Support\Facades\Storage;

class ShowCourseContent extends Component
{
    use WithFileUploads;

    public $course_content_files = [];


    public $confirming_course_content_deletion = false;
    public $selected_course_content_id;

    public $course;

    protected $listeners = [
        'course-content-uploaded' => '$refresh',
        'course-content-deleted' => '$refresh',
    ];

    protected $rules = [
        'course_content_files.*' => 'required',
    ];

    public function mount($course_id)
    {
        $this->course = Course::findOrFail($course_id);
    }

    public function render()
    {
        $course_content_list = CourseContent::where('course_id', $this->course->course_id)
                                            ->orderBy('created_at', 'desc')
                                            ->get();
        return view('livewire.courses.show-course-content', compact('course_content_list'));
    }

    public function upload_course_content()
    {
        if ($this->course->user_id == Auth::id() && Auth::user()->is_teacher())
        {
            $this->validate();
    
            foreach ($this->course_content_files as $course_content_file)
            {
                $course_content_file_path = $course_content_file->store('files');
    
                $course_content = new CourseContent;
    
                $course_content->course_content_file_name = $course_content_file->getClientOriginalName();
                $course_content->course_content_file_extension = $course_content_file->getClientOriginalExtension();
                $course_content->course_content_file_path = $course_content_file_path;
    
                $course_content->course_id = $this->course->course_id;
                $course_content->user_id = Auth::id();
    
                $course_content->save();
            }
    
            $this->course_content_files = [];
    
            $this->dispatchBrowserEvent('course-content-uploaded');
            $this->emit('course-content-uploaded');
        }
    }

    /**
     * Confirm deletion of CourseContent.
     * 
     * @param  int $course_content_id
     */
    public function confirm_deletion($course_content_id)
    {
        $course_content = CourseContent::findOrFail($course_content_id);
        if ($course_content->user_id == Auth::id() && Auth::user()->is_teacher())
        {
            $this->selected_course_content_id = $course_content_id;
            $this->confirming_course_content_deletion = true;
        }
    }

    /**
     * Delete an existing CourseContent.
     * 
     */
    public function delete_course_content()
    {
        $course_content = CourseContent::findOrFail($this->selected_course_content_id);
        if ($course_content->user_id == Auth::id() && Auth::user()->is_teacher())
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
    
            $this->selected_course_content_id = null;
            $this->confirming_course_content_deletion = false;
    
            $this->emit('course-content-deleted');
        }
    }
}
