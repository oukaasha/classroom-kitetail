<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Course Content') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('courses') }}" class="inline-flex justify-center mb-5 py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                Go Back
            </a>

            <div class="border-b-2 border-gray-800 mb-5">
                <h2 class="leading-10 font-semibold text-xl text-gray-800">
                    {{ $this->course->course_name }}
                </h2>
            </div>

            @if (
                $this->course->user_id == Auth::id()
                && Auth::user()->is_teacher()
                )
                <form wire:submit.prevent="upload_course_content">
                    <div
                        x-data="{ isUploading: false, progress: 0 }"
                        x-on:livewire-upload-start="isUploading = true"
                        x-on:livewire-upload-finish="isUploading = false"
                        x-on:livewire-upload-error="isUploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress"
                        x-on:course-content-uploaded.window="document.getElementById('course_content_files').value=''"
                    >
                        <input type="file" id="course_content_files" wire:model="course_content_files" multiple>

                        @error('course_content_files.*') <span class="error">{{ $message }}</span> @enderror

                        <!-- Progress Bar -->
                        <div x-show="isUploading">
                            <progress max="100" x-bind:value="progress"></progress>
                        </div>
                    </div>

                    <button class="inline-flex justify-center mb-5 mt-3 py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" type="submit">Upload Content</button>
                </form>
            @endif

            <div class="flex flex-wrap -m-4">
                @foreach ($course_content_list as $course_content)
                    <div class="xl:w-1/6 md:w-1/4 p-4">
                        <a href="{{ Storage::url($course_content->course_content_file_path) }}" download>
                            <div class="border border-gray-300 py-6 px-2 rounded-lg text-center hover:shadow-xl hover:border-indigo-500">
                                <div class="w-20 h-20 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-4">
                                    {{ Str::upper($course_content->course_content_file_extension) }}
                                </div>
    
                                <h2 class="text-lg font-medium title-font mb-2 truncate" title="{{ $course_content->course_content_file_name }}">{{ $course_content->course_content_file_name }}</h2>
    
                                <div class="text-center mt-2 leading-none flex justify-center w-full">
                                    <span class="inline-flex items-center justify-center leading-none text-sm py-1">
                                        {{ \Carbon\Carbon::parse($course_content->created_at)->format('F j, Y') }}
                                    </span>
                                </div>
                            </div>
                        </a>
                        @if (
                            $course_content->user_id == Auth::id()
                            && Auth::user()->is_teacher()
                            )
                            <div class="flex justify-end">
                                <button wire:click="confirm_deletion({{ $course_content->course_content_id }})" class="mt-2 py-1 px-4 shadow-md no-underline rounded-full text-red-600 font-sans font-semibold text-sm border border-red-600 btn-primary hover:text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 active:shadow-none" type="button">
                                    Delete
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <x-jet-confirmation-modal wire:model="confirming_course_content_deletion">
        <x-slot name="title">
            Delete File
        </x-slot>
    
        <x-slot name="content">
            Are you sure you want to delete this file?
        </x-slot>
    
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirming_course_content_deletion')" wire:loading.attr="disabled">
                Nevermind
            </x-jet-secondary-button>
    
            <x-jet-danger-button class="ml-2" wire:click="delete_course_content" wire:loading.attr="disabled">
                Delete File
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

</div>
