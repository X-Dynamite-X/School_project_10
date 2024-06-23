<div class="w-full flex my_h_93 flex-col chat "id="chatConversationSbace" data-conversation-id="{{ $conversation->id }}">
    <div class="p-4 border-b bg-white chat">
        @if ($conversation->user1_id == auth()->user()->id)
            <img class="h-8 w-8 rounded-full inline" id="imgAvatarConversation"
                data-img_avatar1="{{ asset('imageProfile/' . $conversation->user1->image) }}"
                src="{{ asset('imageProfile/' . $conversation->user2->image) }}" alt="">
            <h2 class="text-2xl font-semibold inline">{{ $conversation->user2->name }}</h2>
            <p class="text-xs status inline" id="user-status-chat-{{ $conversation->user2->id }}"
                data-last-seen="{{ $conversation->user2->status ? 'null' : $conversation->user2->last_seen_at }}">
                @if ($conversation->user2->status == 1)
                    <span class="text-green-500 inline">Online
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                            class="size-4 inline">
                            <path fill-rule="evenodd"
                                d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm3.844-8.791a.75.75 0 0 0-1.188-.918l-3.7 4.79-1.649-1.833a.75.75 0 1 0-1.114 1.004l2.25 2.5a.75.75 0 0 0 1.15-.043l4.25-5.5Z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                @else
                    <span class="text-red-500 inline  ">Offline
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                            class="size-4 inline">
                            <path fill-rule="evenodd"
                                d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm3.844-8.791a.75.75 0 0 0-1.188-.918l-3.7 4.79-1.649-1.833a.75.75 0 1 0-1.114 1.004l2.25 2.5a.75.75 0 0 0 1.15-.043l4.25-5.5Z">
                            </path>
                        </svg>
                    </span>
                    <span class="block ml-5" id="data-last-seen-{{ $conversation->user2->id }}">
                        {{ Helpers::formatLastSeen($conversation->user2->last_seen_at) }}
                    </span>
                @endif
            </p>
        @else
            <img class="h-8 w-8 rounded-full inline" id="imgAvatarConversation"
                src="{{ asset('imageProfile/' . $conversation->user1->image) }}"data-img_avatar1="{{ asset('imageProfile/' . $conversation->user1->image) }}"
                alt="">
            <h2 class="text-2xl font-semibold inline">{{ $conversation->user1->name }}</h2>
            <p class="text-xs status inline" id="user-status-chat-{{ $conversation->user1->id }}"
                data-last-seen="{{ $conversation->user1->status ? 'null' : $conversation->user1->last_seen_at }}">
                @if ($conversation->user1->status == 1)
                    <span class="text-green-500 inline">Online
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                            class="size-4 inline">
                            <path fill-rule="evenodd"
                                d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm3.844-8.791a.75.75 0 0 0-1.188-.918l-3.7 4.79-1.649-1.833a.75.75 0 1 0-1.114 1.004l2.25 2.5a.75.75 0 0 0 1.15-.043l4.25-5.5Z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                @else
                    <span class="text-red-500 inline  ">Offline
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                            class="size-4 inline">
                            <path fill-rule="evenodd"
                                d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm3.844-8.791a.75.75 0 0 0-1.188-.918l-3.7 4.79-1.649-1.833a.75.75 0 1 0-1.114 1.004l2.25 2.5a.75.75 0 0 0 1.15-.043l4.25-5.5Z">
                            </path>
                        </svg>
                    </span>
                    <span class="block ml-5" id="data-last-seen-{{ $conversation->user1->id }}">
                        {{ Helpers::formatLastSeen($conversation->user1->last_seen_at) }}
                    </span>
                @endif
            </p>
        @endif
    </div>
    <div class="flex-1 overflow-y-auto p-4 message_spase chat">
        <div></div>
        @foreach ($messages as $message)

            @if ($message->sender->id == auth()->user()->id)
            <div class="flex justify-end mb-4 items-end" id="con_{{$message->conversation_id}}_sender_{{$message->sender->id}}_receiver_{{$message->receiver->id}}_message_{{$message->id}}">
                <div class="bg-green-500 text-white p-3 rounded-tl-lg rounded-bl-lg rounded-tr-lg inline-block relative min-w-40  max-w-sm w-1/5">
                    <p class="break-words text-left items-end">{{ $message->message_text }}</p>
                    <div class="absolute bottom-0 right-0 flex items-end space-x-1">
                        <span class="text-gray-200 text-xs">
                            {{ Helpers::formatMessageDate($message->created_at) }}
                        </span>
                        <svg width="1rem" height="1rem" viewBox="0 0 24.00 24.00" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.096"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M4 12.6111L8.92308 17.5L20 6.5" stroke="#fff" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                        </svg>
                    </div>
                </div>
                <img class="h-8 w-8 rounded-full ml-2" id="imgAvatar1" src="{{ asset('imageProfile/' . $message->sender->image) }}" alt="">
            </div>
            @else
                <div class="flex justify-start mb-4 items-start "id="con_{{$message->conversation_id}}_sender_{{$message->sender->id}}_receiver_{{$message->receiver->id}}_message_{{$message->id}}">
                    <img class="h-8 w-8 rounded-full mr-2" id="imgAvatar1"
                        src="{{ asset('imageProfile/' . $message->sender->image) }}" alt="">
                    <div
                        class="bg-gray-500 text-white p-3 rounded-tr-lg rounded-bl-lg rounded-br-lg inline-block relative min-w-40  max-w-sm w-1/5">
                        <p class="inline break-words">{{ $message->message_text }}</p>
                        <div class="absolute bottom-0 right-0  pr-5  flex items-end space-x-1">
                            <span class="text-gray-200 text-xs">
                                {{ Helpers::formatMessageDate($message->created_at) }}
                            </span>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    <div class="p-4 bg-white border-t bottom-0 right-0 chat">
        <form class="flex" id="chatForm"
            action="{{ route('store_ConversationController', ['conversation_id' => $conversation->id]) }}">
            @csrf
            <input type="text" id="message_text" placeholder="Message..." name="message_text"
                class="flex-1 border border-gray-300 p-2 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button data-conversation_id_inbut="{{ $conversation->id }}" type="button"
                class="bg-blue-500 text-white p-2 rounded-r-lg hover:bg-blue-600 send_btn_input">Send</button>
        </form>
    </div>
</div>
