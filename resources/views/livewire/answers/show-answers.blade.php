<div
    x-data="{ give_answer: false, answer_text: '' }"
    x-init="() => {
        $watch('give_answer', (value) => {
            if (value) {
                answer_text = ''
            }
        })
    }"
    @answer-given.window="give_answer = false"
    >
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Answers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('questions') }}" class="inline-flex justify-center mb-5 py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                Go Back
            </a>

            <div class="shadow-xl border-indigo-500 bg-white border border-gray-300 p-6 rounded-lg">
                <span class="font-light text-gray-600">{{ \Carbon\Carbon::parse($question->created_at)->format('F j, Y g:i A') }}</span>
                <div class="mt-2">
                    <h2 class="text-2xl text-gray-800 font-bold">{{ $question->question_text }}</h2>
                    <p class="mt-2 text-gray-600">{!! nl2br(e($question->question_description)) !!}</p>
                </div>
                <div class="mt-4 text-right">
                    <h1 class="text-gray-700 font-bold">{{ $question->user->name }}</h1>
                </div>
            </div>

            <h4 class="font-semibold text-xl text-gray-800 leading-tight mb-5 mt-15">{{ __('Answers') }}</h4>
            <div class="border-t border-gray-200 mb-10"></div>

            <button @click="give_answer = true" type="button" class="inline-flex justify-center mb-5 py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Give Answer
            </button>

            @livewire('answers.answer-form', ['question' => $question])

            @livewire('answers.answers-list', ['question' => $question])
        </div>
    </div>
</div>
