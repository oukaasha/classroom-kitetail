<div
    x-data="{ new_question: false, question_text: '', question_description: '' }"
    x-init="() => {
        $watch('new_question', (value) => {
            if (value) {
                question_text = ''
                question_description = ''
            }
        })
    }"
    @question-added.window="new_question = false"
    >
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Questions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <button @click="new_question = true" type="button" class="inline-flex justify-center mb-5 py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                New Question
            </button>
            
            @livewire('questions.question-form')

            @livewire('questions.questions-list')
        </div>
    </div>
</div>
