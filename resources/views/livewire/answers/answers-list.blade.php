<div>
    <div wire:poll.5s>
        {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
        @foreach ($answers_list as $answer)
            <div class="bg-white border p-6 rounded-lg mb-5 {{ $accepted_answer && $accepted_answer->answer_id == $answer->answer_id ? 'border-green-600 shadow-xl' : 'border-black-500 shadow-md' }}">
                @if (
                    $answer->user_id == Auth::id()
                    || $this->question->user_id == Auth::id()
                    || Auth::user()->is_teacher()
                    )
                    @if (
                        (
                            $accepted_answer
                            && $accepted_answer->answer_id != $answer->answer_id
                        )
                        || !$accepted_answer
                        )
                        <button wire:click="confirm_deletion({{ $answer->answer_id }})" class="inline-flex justify-center float-right mb-1 py-2 px-4 border border-red-600 shadow-sm text-sm font-medium rounded-md text-red-600 hover:bg-red-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" type="button">
                            Delete
                        </button>
                    @endif
                    <button wire:click="display_edit_form({{ $answer->answer_id }})" class="inline-flex justify-center float-right mr-3 mb-1 py-2 px-4 border border-blue-600 shadow-sm text-sm font-medium rounded-md text-blue-600 hover:bg-blue-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" type="button">
                        Edit
                    </button>
                @endif
                <div class="flex justify-between items-center">
                    <span class="font-light text-gray-600">{{ \Carbon\Carbon::parse($answer->created_at)->format('F j, Y g:i A') }}</span>
                    @if (!$accepted_answer)
                        @if (
                            $this->question->user_id == Auth::id()
                            || Auth::user()->is_teacher()
                            )
                            <button wire:click="accept_answer({{ $answer->answer_id }})" class="inline-flex justify-center mb-5 mr-3 py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" type="button">
                                Accept Answer
                            </button>
                        @endif
                    @elseif ($accepted_answer->answer_id == $answer->answer_id)
                        <span class="px-4 mr-3 py-2 inline-flex text-lg leading-5 font-semibold rounded-full bg-green-600 text-white">
                            Best Answer
                        </span>
                    @endif
                </div>
                <p class="mt-2 text-black-600 font-semibold">{!! nl2br(e($answer->answer_text)) !!}</p>
                <div class="mt-4 text-right">
                    <h1 class="text-gray-700 font-bold">{{ $answer->user->name }}</h1>
                </div>
            </div>
        @endforeach
    </div>

    <x-jet-confirmation-modal wire:model="confirming_answer_deletion">
        <x-slot name="title">
            Delete Answer
        </x-slot>
    
        <x-slot name="content">
            Are you sure you want to delete this answer?
        </x-slot>
    
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirming_answer_deletion')" wire:loading.attr="disabled">
                Nevermind
            </x-jet-secondary-button>
    
            <x-jet-danger-button class="ml-2" wire:click="delete_answer" wire:loading.attr="disabled">
                Delete Answer
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <x-jet-dialog-modal wire:model="display_edit_answer_form">
        <x-slot name="title">
            Edit Answer
        </x-slot>
    
        <x-slot name="content">
            <div class="grid grid-cols-6">
                <div class="col-span-6">
                    <label for="answer_text" class="block text-sm font-medium text-gray-700">
                        Answer
                    </label>
                    <div class="mt-1">
                        <textarea id="answer_text" name="answer_text" rows="6" wire:model.lazy="answer_text"
                            class="p-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-600 rounded-md"></textarea>
                        @error('answer_text') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        Describe your answer in a simple language.
                    </p>
                </div>
            </div>
        </x-slot>
    
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('display_edit_answer_form')" wire:loading.attr="disabled">
                Nevermind
            </x-jet-secondary-button>
    
            <x-jet-button class="ml-2" wire:click="update_answer" wire:loading.attr="disabled">
                Update Answer
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
