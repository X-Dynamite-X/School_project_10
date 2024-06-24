<div class="w-full flex my_h_93 flex-col chat "id="chatConversationSbace" data-conversation-id="{{ $conversation->id }}">
    <div class="p-4 border-b bg-white chat">
        @php
            $userAuth = auth()->user();
            $userAuthId = auth()->user()->id;

            $userId = $conversation->user1_id == $userAuthId ? $conversation->user2_id : $conversation->user1_id;
            $user = $conversation->user1_id == $userAuthId ? $conversation->user2 : $conversation->user1;
        @endphp
        <img class="h-8 w-8 rounded-full inline" id="imgAvatarConversation"
            data-img_avatar1="{{ asset('imageProfile/' . $userAuth->image) }}"
            src="{{ asset('imageProfile/' . $user->image) }}" alt="">
        <h2 class="text-2xl font-semibold inline">{{ $user->name }}</h2>
        <p class="text-xs status inline" id="user-status-chat-{{ $user->id }}"
            data-last-seen="{{ $user->status ? 'null' : $user->last_seen_at }}">
            @if ($user->status == 1)
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
                <span class="block ml-5" id="data-last-seen-{{ $user->id }}">
                    {{ Helpers::formatLastSeen($user->last_seen_at) }}
                </span>
            @endif
        </p>

    </div>
    <div class="flex-1 overflow-y-auto p-4 message_spase chat">
        <div></div>
        @foreach ($messages as $message)
            @php
                $isSender = $message->sender->id == auth()->user()->id;
                $messageClasses = $isSender ? 'justify-end items-end' : 'justify-start items-start';
                $messageBgColor = $isSender ? 'bg-green-500' : 'bg-gray-500';
                $messageAlignment = $isSender
                    ? 'rounded-tl-lg rounded-bl-lg rounded-tr-lg'
                    : 'rounded-tr-lg rounded-bl-lg rounded-br-lg';
                $messageId = "con_{$message->conversation_id}_sender_{$message->sender->id}_receiver_{$message->receiver->id}_message_{$message->id}";
                $avatarMargin = $isSender ? 'ml-2' : 'mr-2';
            @endphp

            <div class="flex {{ $messageClasses }} mb-4" id="{{ $messageId }}">
                @unless ($isSender)
                    <img class="h-8 w-8 rounded-full {{ $avatarMargin }}"
                        src="{{ asset('imageProfile/' . $message->sender->image) }}" alt="">
                @endunless

                <div
                    class="{{ $messageBgColor }} text-white p-3 {{ $messageAlignment }} inline-block relative min-w-40 max-w-sm w-1/5 break-words">
                    <div class="items-center">
<div class="flex justify-end ">

                            @if ($isSender)
                                <!-- Dropdown Menu Button -->
                                <div class="relative inline-block text-left">
                                    <button data-message_id="{{ $message->id }}" id="menu-button-{{ $message->id }}"
                                        type="button"
                                        class="inline-flex justify-center w-full text-sm font-medium text-white menu-button"
                                        aria-expanded="true" aria-haspopup="true">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M6 10a2 2 0 114 0 2 2 0 01-4 0zm0-4a2 2 0 114 0 2 2 0 01-4 0zm0 8a2 2 0 114 0 2 2 0 01-4 0z" />
                                        </svg>
                                    </button>
                                    <!-- Dropdown Menu -->
                                    <div data-message_id="{{ $message->id }}" id="dropdown-menu-{{ $message->id }}"
                                        class="hidden origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 dropdown-menu">
                                        <ul class="py-1" role="menu" aria-orientation="vertical"
                                            aria-labelledby="menu-button">
                                            <li class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center edit_button_message"
                                                data-message_con_id="{{ $messageId }}"
                                                id="editMessageTextButton_{{ $message->id }}"
                                                onclick="showEditMessageTextModal('{{ $message->id }}')"
                                                data-message_id="{{ $message->id }}"
                                                data-conversation_id="{{ $message->conversation_id }}">

                                                <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500 mr-2"  fill="none">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <path fill="#facc15" fill-rule="evenodd"
                                                            d="M15.198 3.52a1.612 1.612 0 012.223 2.336L6.346 16.421l-2.854.375 1.17-3.272L15.197 3.521zm3.725-1.322a3.612 3.612 0 00-5.102-.128L3.11 12.238a1 1 0 00-.253.388l-1.8 5.037a1 1 0 001.072 1.328l4.8-.63a1 1 0 00.56-.267L18.8 7.304a3.612 3.612 0 00.122-5.106zM12 17a1 1 0 100 2h6a1 1 0 100-2h-6z">
                                                        </path>
                                                    </g>
                                                </svg>
                                                Edit
                                            </li>
                                            <li class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center delete-button"
                                                data-message_con_id="{{ $messageId }}"
                                                data-message_id="{{ $message->id }}">
                                                <svg class="w-5 h-5 text-red-500 mr-2" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M7.10002 5H3C2.44772 5 2 5.44772 2 6C2 6.55228 2.44772 7 3 7H4.06055L4.88474 20.1871C4.98356 21.7682 6.29471 23 7.8789 23H16.1211C17.7053 23 19.0164 21.7682 19.1153 20.1871L19.9395 7H21C21.5523 7 22 6.55228 22 6C22 5.44772 21.5523 5 21 5H19.0073C19.0018 4.99995 18.9963 4.99995 18.9908 5H16.9C16.4367 2.71776 14.419 1 12 1C9.58104 1 7.56329 2.71776 7.10002 5ZM9.17071 5H14.8293C14.4175 3.83481 13.3062 3 12 3C10.6938 3 9.58254 3.83481 9.17071 5ZM17.9355 7H6.06445L6.88085 20.0624C6.91379 20.5894 7.35084 21 7.8789 21H16.1211C16.6492 21 17.0862 20.5894 17.1192 20.0624L17.9355 7ZM14.279 10.0097C14.83 10.0483 15.2454 10.5261 15.2068 11.0771L14.7883 17.0624C14.7498 17.6134 14.2719 18.0288 13.721 17.9903C13.17 17.9517 12.7546 17.4739 12.7932 16.9229L13.2117 10.9376C13.2502 10.3866 13.7281 9.97122 14.279 10.0097ZM9.721 10.0098C10.2719 9.97125 10.7498 10.3866 10.7883 10.9376L11.2069 16.923C11.2454 17.4739 10.83 17.9518 10.2791 17.9903C9.72811 18.0288 9.25026 17.6134 9.21173 17.0625L8.79319 11.0771C8.75467 10.5262 9.17006 10.0483 9.721 10.0098Z"
                                                            fill="#f81717"></path>
                                                    </g>
                                                </svg>
                                                Delete
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <p class="  break-words text-left flex-1 message-text" id="message_text_{{$message->id}}">{{ $message->message_text }}</p>

                    </div>
                    <div class="absolute bottom-0 right-0 flex items-end space-x-1 pr-5">
                        <span
                            class="text-gray-200 text-xs">{{ Helpers::formatMessageDate($message->created_at) }}</span>
                        @if ($isSender)
                            <svg width="1rem" height="1rem" viewBox="0 0 24.00 24.00" fill="none"
                                xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                                <path d="M4 12.6111L8.92308 17.5L20 6.5" stroke="#fff" stroke-width="1"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        @endif
                    </div>
                </div>

                @if ($isSender)
                    <img class="h-8 w-8 rounded-full {{ $avatarMargin }}"
                        src="{{ asset('imageProfile/' . $message->sender->image) }}" alt="">
                @endif
            </div>
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
