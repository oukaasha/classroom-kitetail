<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->name('dashboard');

    Route::group(['namespace' => 'App\Http\Livewire'], function () {
        
        Route::get('/courses', Courses\ShowCourses::class)->name('courses');
        Route::get('/courses/{course_id}/content', Courses\ShowCourseContent::class)->name('course_content');
        Route::get('/questions', Questions\ShowQuestions::class)->name('questions');
        Route::get('/questions/{question_id}/answers', Answers\ShowAnswers::class)->name('answers');
        Route::get('/whiteboard', Whiteboard\ShowWhiteboard::class)->name('whiteboard');

    });
});

