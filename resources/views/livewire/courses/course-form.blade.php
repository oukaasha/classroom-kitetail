<div>
    {{-- Be like water. --}}
    <div class="mb-5" x-show="new_course">
        <form wire:submit.prevent="create_course" method="POST">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6">
                            <label for="course_name" class="block text-sm font-medium text-gray-700">Course Name</label>
                            <input type="text" name="course_name" id="course_name" autocomplete="course-name" x-model="course_name" wire:model.lazy="course_name"
                                class="p-2 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border border-gray-600 rounded-md">
                            @error('course_name') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="button" @click="new_course = false"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Cancel
                    </button>
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Create
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
