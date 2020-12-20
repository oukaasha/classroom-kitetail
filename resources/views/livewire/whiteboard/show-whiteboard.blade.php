<div>
    {{-- Success is as dangerous as failure. --}}

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Whiteboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div id="literally-canvas" class="shadow-xl border-indigo-500 bg-white border p-6 rounded-lg"></div>
        </div>
    </div>
</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/literallyCanvas.css') }}">
    <style>
        #literally-canvas {
            height: calc(100vh - 10rem);
        }
    </style>
@endpush
    
@push('scripts')
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('js/react-with-addon.js') }}"></script>
    <script src="{{ asset('js/literallyCanvas.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            LC.init(document.getElementById('literally-canvas'))
        })
    </script>
@endpush
