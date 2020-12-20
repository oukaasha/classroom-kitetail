<div wire:poll.5s>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    @foreach ($answers_list as $answer)
        <div class="bg-white border p-6 rounded-lg mb-5 {{ $accepted_answer && $accepted_answer->answer_id == $answer->answer_id ? 'border-green-600 shadow-xl' : 'border-black-500 shadow-md' }}">
            <div class="flex justify-between items-center">
                <span class="font-light text-gray-600">{{ \Carbon\Carbon::parse($answer->created_at)->format('F j, Y g:i A') }}</span>
                @if (!$accepted_answer)
                    @if (
                        $this->question->user_id == Auth::id()
                        || Auth::user()->role == 'teacher'
                        )
                        <button wire:click="accept_answer({{ $answer->answer_id }})" class="inline-flex justify-center mb-5 py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" type="button">
                            Accept Answer
                        </button>
                    @endif
                @elseif ($accepted_answer->answer_id == $answer->answer_id)
                    <span class="px-4 py-2 inline-flex text-lg leading-5 font-semibold rounded-full bg-green-600 text-white">
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
