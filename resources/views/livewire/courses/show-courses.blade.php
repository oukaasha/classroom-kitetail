<div
    x-data="{ new_course: false, course_name: '' }"
    x-init="() => {
        $watch('new_course', (value) => {
            if (value) {
                course_name = ''
            }
        })
    }"
    @course-added.window="new_course = false"
    >
    {{-- The best athlete wants his opponent at his best. --}}
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Courses') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (Auth::user()->is_teacher())
                <button @click="new_course = true" type="button" class="inline-flex justify-center mb-5 py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    New Course
                </button>
                
                @livewire('courses.course-form')
            @endif

            @livewire('courses.courses-list')
        </div>
    </div>
</div>
