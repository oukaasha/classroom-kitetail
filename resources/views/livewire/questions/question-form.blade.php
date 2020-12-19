<div>
    <div class="mb-5" x-show="new_question">
        <form wire:submit.prevent="create_question" method="POST">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6">
                            <label for="question_text" class="block text-sm font-medium text-gray-700">Question</label>
                            <input type="text" name="question_text" id="question_text" autocomplete="question-text" x-model="question_text" wire:model.lazy="question_text"
                                class="p-2 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border border-gray-600 rounded-md">
                            @error('question_text') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-span-6">
                            <label for="question_description" class="block text-sm font-medium text-gray-700">
                                Description
                            </label>
                            <div class="mt-1">
                                <textarea id="question_description" name="question_description" rows="6" x-model="question_description" wire:model.lazy="question_description"
                                    class="p-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-600 rounded-md"></textarea>
                                @error('question_description') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <p class="mt-2 text-sm text-gray-500">
                                Explain your question clearly.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="button" @click="new_question = false"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Cancel
                    </button>
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Save
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
