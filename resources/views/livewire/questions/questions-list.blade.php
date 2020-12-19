<div>
    <div class="overflow-hidden sm:rounded-lg">
        <div class="flex flex-wrap -m-4">
            @foreach ($question_list as $question)
                <div class="w-full p-4 {{ $loop->last ? 'mb-10' : '' }}">
                    <a href="#">
                        <div class="hover:shadow-xl hover:border-indigo-500 bg-white border border-gray-300 p-6 rounded-lg">
                            <h4 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                                {{ $question->question_text }}
                            </h4>
                            <p class="text-gray-600 dark:text-gray-400">
                                {{ Str::limit($question->question_description, 300, '...') }}
                            </p>
                            <div class="mt-2 leading-none w-full">
                                <span class=" mb-1 leading-none text-sm">
                                    Asked by: {{ $question->user->name }}
                                </span>
                                <br>
                                <span class=" mr-3 leading-none text-sm  py-1 ">
                                    On: {{ \Carbon\Carbon::parse($question->created_at)->format('F j, Y g:i A') }}
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
