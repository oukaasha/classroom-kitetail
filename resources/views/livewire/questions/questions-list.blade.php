<div>
    <div class="overflow-hidden sm:rounded-lg" wire:poll.5s>
        <div class="flex flex-wrap -m-4">
            @foreach ($question_list as $question)
                <div class="w-full p-4 {{ $loop->last ? 'mb-10' : '' }}">
                    @if (Auth::user()->is_teacher())
                        <button wire:click="confirm_deletion({{ $question->question_id }})" class="inline-flex justify-center float-right mr-3 mt-3 mb-1 py-2 px-4 border border-red-600 shadow-sm text-sm font-medium rounded-md text-red-600 hover:bg-red-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" type="button">
                            Delete
                        </button>
                        <button wire:click="display_edit_form({{ $question->question_id }})" class="inline-flex justify-center float-right mr-3 mt-3 mb-1 py-2 px-4 border border-blue-600 shadow-sm text-sm font-medium rounded-md text-blue-600 hover:bg-blue-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" type="button">
                            Edit
                        </button>
                    @endif
                    <a href="{{ route('answers', ['question_id' => $question->question_id]) }}">
                        <div class="hover:shadow-xl hover:border-indigo-500 bg-white border border-gray-300 p-6 rounded-lg">
                            <h4 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                                {{ $question->question_text }}
                            </h4>
                            <p class="text-gray-600 dark:text-gray-400">
                                {{ Str::limit($question->question_description, 300, '...') }}
                            </p>
                            <div class="mt-2 leading-none w-full">
                                <span class=" mb-1 leading-none text-sm">
                                    Asked by: {{ $question->user->name }}
                                </span>
                                <br>
                                <span class=" mr-3 leading-none text-sm  py-1 ">
                                    On: {{ \Carbon\Carbon::parse($question->created_at)->format('F j, Y g:i A') }}
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <x-jet-confirmation-modal wire:model="confirming_question_deletion">
        <x-slot name="title">
            Delete Question
        </x-slot>
    
        <x-slot name="content">
            Are you sure you want to delete this question? Once this question is deleted, all of its answers will also be permanently deleted.
        </x-slot>
    
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirming_question_deletion')" wire:loading.attr="disabled">
                Nevermind
            </x-jet-secondary-button>
    
            <x-jet-danger-button class="ml-2" wire:click="delete_question" wire:loading.attr="disabled">
                Delete Question
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <x-jet-dialog-modal wire:model="display_edit_question_form">
        <x-slot name="title">
            Edit Question
        </x-slot>
    
        <x-slot name="content">
            <div class="grid grid-cols-6">
                <div class="col-span-6">
                    <label for="question_text" class="block text-sm font-medium text-gray-700">Question</label>
                    <input type="text" name="question_text" id="question_text" autocomplete="question-text" wire:model.lazy="question_text"
                        class="p-2 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border border-gray-600 rounded-md">
                    @error('question_text') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="col-span-6">
                    <label for="question_description" class="block text-sm font-medium text-gray-700">
                        Description
                    </label>
                    <div class="mt-1">
                        <textarea id="question_description" name="question_description" rows="6" wire:model.lazy="question_description"
                            class="p-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-600 rounded-md"></textarea>
                        @error('question_description') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        Explain your question clearly.
                    </p>
                </div>
            </div>
        </x-slot>
    
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('display_edit_question_form')" wire:loading.attr="disabled">
                Nevermind
            </x-jet-secondary-button>
    
            <x-jet-button class="ml-2" wire:click="update_question" wire:loading.attr="disabled">
                Update Question
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
