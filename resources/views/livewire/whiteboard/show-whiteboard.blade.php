<div>
    {{-- Success is as dangerous as failure. --}}

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Whiteboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div id="sketchpad" class="shadow-xl border-indigo-500 bg-white border p-0 rounded-lg">
                <iframe src="https://sketch.io/sketchpad" frameborder="0" class="h-full w-full rounded-lg"></iframe>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        #sketchpad {
            height: calc(100vh - 2rem);
        }
    </style>
@endpush
