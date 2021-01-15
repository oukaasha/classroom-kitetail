<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\Course;
use App\Models\CourseContent;

use App\Models\Question;
use App\Models\Answer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with all stats.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $number_of_students = User::where('role', 'student')->count();
        $number_of_teachers = User::where('role', 'teacher')->count();
        $number_of_course = Course::count();
        $number_of_content_uploaded = CourseContent::count();
        
        $uploaded_file_paths_array = Storage::allFiles('files');
        $course_content_disk_usage = 0;
        foreach ($uploaded_file_paths_array as $file_path)
        {
            $course_content_disk_usage += Storage::size($file_path)/1000000;
        }
        $course_content_disk_usage = number_format($course_content_disk_usage, 4).' MB';

        $number_of_questions = Question::count();
        $number_of_open_questions = Question::whereNull('accepted_answer_id')->count();
        $number_of_closed_questions = Question::whereNotNull('accepted_answer_id')->count();
        $number_of_unanswered_questions = Question::select('questions.question_id')
                                                ->leftJoin('answers', 'answers.question_id', 'questions.question_id')
                                                ->whereNull('answers.answer_id')
                                                ->count();

        return view('dashboard', compact(
            'number_of_students',
            'number_of_teachers',
            'number_of_course',
            'number_of_content_uploaded',
            'course_content_disk_usage',
            'number_of_questions',
            'number_of_open_questions',
            'number_of_closed_questions',
            'number_of_unanswered_questions'
        ));
    }
}
