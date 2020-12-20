<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <div class="mb-5" x-show="give_answer">
        <form wire:submit.prevent="create_answer" method="POST">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6">
                            <label for="answer_text" class="block text-sm font-medium text-gray-700">
                                Answer
                            </label>
                            <div class="mt-1">
                                <textarea id="answer_text" name="answer_text" rows="6" x-model="answer_text" wire:model.lazy="answer_text"
                                    class="p-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-600 rounded-md"></textarea>
                                @error('answer_text') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <p class="mt-2 text-sm text-gray-500">
                                Describe your answer in a simple language.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="button" @click="give_answer = false"
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
