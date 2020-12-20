<div>
    {{-- Success is as dangerous as failure. --}}

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Whiteboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
        </div>
    </div>
</div>

@push('styles')
@endpush

@push('scripts')
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {

        })
    </script>
@endpush
