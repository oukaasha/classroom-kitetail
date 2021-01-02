<div>
    {{-- Stop trying to control. --}}
    <div class="flex flex-wrap -mx-1 lg:-mx-4">
        @foreach ($course_list as $course)
            <div class="my-1 px-1 w-full md:w-1/3 lg:my-4 lg:px-4 lg:w-1/4">

                <a href="{{ route('course_content', ['course_id' => $course->course_id]) }}">
                    <article class="overflow-hidden rounded-lg shadow-lg bg-white hover:shadow-xl hover:border-indigo-500 border border-gray-300">
    
                        <header class="flex items-center justify-between leading-tight p-2 md:p-4">
                            <h1 class="text-lg">
                                {{ $course->course_name }}
                            </h1>
                        </header>
    
                        <footer class="leading-none p-2 md:p-4">
                            <p class="text-sm">
                                {{ $course->user->name }}
                            </p>
                            <p class="mt-2 text-grey-darker text-sm">
                                {{ \Carbon\Carbon::parse($course->created_at)->format('F j, Y') }}
                            </p>
                        </footer>
    
                    </article>
                </a>

                @if (
                    $course->user_id == Auth::id()
                    && Auth::user()->is_teacher()
                    )
                    <div class="flex justify-end">
                        <button wire:click="display_edit_form({{ $course->course_id }})" class="mt-2 mr-2 py-1 px-4 shadow-md no-underline rounded-full text-blue-600 font-sans font-semibold text-sm border border-blue-600 btn-primary hover:text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 active:shadow-none" type="button">
                            Edit
                        </button>
                        <button wire:click="confirm_deletion({{ $course->course_id }})" class="mt-2 py-1 px-4 shadow-md no-underline rounded-full text-red-600 font-sans font-semibold text-sm border border-red-600 btn-primary hover:text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 active:shadow-none" type="button">
                            Delete
                        </button>
                    </div>
                @endif

            </div>
        @endforeach
    </div>

    <x-jet-confirmation-modal wire:model="confirming_course_deletion">
        <x-slot name="title">
            Delete Course
        </x-slot>
    
        <x-slot name="content">
            Are you sure you want to delete this course? Once this course is deleted, all of its content will also be permanently deleted.
        </x-slot>
    
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirming_course_deletion')" wire:loading.attr="disabled">
                Nevermind
            </x-jet-secondary-button>
    
            <x-jet-danger-button class="ml-2" wire:click="delete_course" wire:loading.attr="disabled">
                Delete Course
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <x-jet-dialog-modal wire:model="display_edit_course_form">
        <x-slot name="title">
            Edit Course
        </x-slot>
    
        <x-slot name="content">
            <div class="grid grid-cols-6">
                <div class="col-span-6">
                    <label for="course_name" class="block text-sm font-medium text-gray-700">Course Name</label>
                    <input type="text" name="course_name" id="course_name" autocomplete="course-name" wire:model.lazy="course_name"
                        class="p-2 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border border-gray-600 rounded-md">
                    @error('course_name') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>
        </x-slot>
    
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('display_edit_course_form')" wire:loading.attr="disabled">
                Nevermind
            </x-jet-secondary-button>
    
            <x-jet-button class="ml-2" wire:click="update_course" wire:loading.attr="disabled">
                Update Course
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
