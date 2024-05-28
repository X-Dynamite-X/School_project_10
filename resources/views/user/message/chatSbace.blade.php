<div class="w-full flex my_h_93 flex-col chat " data-conversation-id="{{ $conversation->id }}">

 <div class="p-4 border-b bg-white chat">
        @if ($conversation->user1_id == auth()->user()->id)
            <img class="h-8 w-8 rounded-full inline" id="imgAvatar1"
                src="{{ asset('imageProfile/' . $conversation->user2->image) }}" alt="">
            <h2 class="text-2xl font-semibold inline">{{ $conversation->user2->name }}</h2>
        @else
            <img class="h-8 w-8 rounded-full inline" id="imgAvatar1"
                src="{{ asset('imageProfile/' . $conversation->user1->image) }}" alt="">
            <h2 class="text-2xl font-semibold inline">{{ $conversation->user1->name }}</h2>
        @endif
    </div>
    <div class="flex-1 overflow-y-auto p-4 message_spase chat">
        <div></div>
        @foreach ($messages as $message)
            @if ($message->sender->id == auth()->user()->id)
                <div class="mb-4 text-right">
                    <div class="bg-blue-500 text-white p-3 rounded-lg inline-block">
                        <p class="inline">{{ $message->message_text }}</p>
                        <img class="h-8 w-8 rounded-full inline" id="imgAvatar1"
                            src="{{ asset('imageProfile/' . $message->sender->image) }}" alt="">
                    </div>
                </div>
            @else
                <div class="mb-4">
                    <div class="bg-gray-200 p-3 rounded-lg inline-block">
                        <img class="h-8 w-8 rounded-full inline" id="imgAvatar1"
                            src="{{ asset('imageProfile/' . $message->sender->image) }}" alt="">
                        <p class="inline">{{ $message->message_text }}</p>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    <div class="p-4 bg-white border-t bottom-0 right-0 chat">
        <form class="flex" id="chatForm" action="{{ route('store_ConversationController', ['conversation_id' => $conversation->id]) }}">
            @csrf
            <input type="text" id="message_text" placeholder="Message..." name="message_text"
                class="flex-1 border border-gray-300 p-2 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button data-conversation_id_inbut="{{ $conversation->id }}" type="button"
                class="bg-blue-500 text-white p-2 rounded-r-lg hover:bg-blue-600 send_btn_input">Send</button>
        </form>
    </div>
</div>
