<div class="w-1/5 bg-white border-r overflow-y-auto fexd my_h_93 min-w-80">
    <div class="p-4 border-b">
        <h2 class="text-2xl font-semibold">Messages</h2>
        <input id="search" type="text" name="search" placeholder="Search To User .."
            class="w-full border border-gray-300 p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 search">
    </div>


    <ul class="contacts_search ">
    </ul>
    <hr>
    <ul class="myContacts" id="myContacts">
        @foreach ($conversations as $conversation)
            @if ($conversation->user1_id == auth()->user()->id)
                <li class="showConversation flex justify-between gap-x-6 py-5"
                    data-conversation_id="{{ $conversation->id }}">
                    <div class="flex min-w-0 gap-x-4">
                        <img class="h-12 w-12 flex-none rounded-full bg-gray-50"
                            src="{{ asset('imageProfile/' . $conversation->user2->image) }}" alt="">
                        <div class="min-w-0 flex-auto">
                            <p class="text-sm font-semibold leading-6 text-gray-900">{{ $conversation->user2->name }}
                            </p>
                            <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{ $conversation->user2->email }}
                            </p>
                        </div>
                    </div>
                    <div class="hidden shrink-0 sm:flex  sm:flex-col sm:items-end">
                        <p class="text-sm leading-6 text-gray-900">Co-Founder / CEO</p>
                        <p class=" text-xs">
                            @if ($conversation->user2->is_online)
                            <span class="text-green-500 inline">
                                Online
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4 inline">
                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm3.844-8.791a.75.75 0 0 0-1.188-.918l-3.7 4.79-1.649-1.833a.75.75 0 1 0-1.114 1.004l2.25 2.5a.75.75 0 0 0 1.15-.043l4.25-5.5Z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            @else
                            <span class="text-red-500 inline-block flex justify-end">
                                Offline
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4 inline">
                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm2.78-4.22a.75.75 0 0 1-1.06 0L8 9.06l-1.72 1.72a.75.75 0 1 1-1.06-1.06L6.94 8 5.22 6.28a.75.75 0 0 1 1.06-1.06L8 6.94l1.72-1.72a.75.75 0 1 1 1.06 1.06L9.06 8l1.72 1.72a.75.75 0 0 1 0 1.06Z" clip-rule="evenodd" />
                                </svg>
                            </span>
                                <span class="block">
                                    @if ($conversation->user2->last_seen_at)
                                        Last seen
                                        {{ \Carbon\Carbon::parse($conversation->user1->last_seen_at)->diffForHumans(['short' => true]) }}
                                    @else
                                        No data available
                                    @endif
                                </span>
                            @endif
                        </p>

                    </div>
                </li>
            @elseif ($conversation->user2_id == auth()->user()->id)
                <li class="showConversation flex justify-between gap-x-6 py-5"
                    data-conversation_id="{{ $conversation->id }}">
                    <div class="flex min-w-0 gap-x-4">
                        <img class="h-12 w-12 flex-none rounded-full bg-gray-50"
                            src="{{ asset('imageProfile/' . $conversation->user1->image) }}" alt="">
                        <div class="min-w-0 flex-auto">
                            <p class="text-sm font-semibold leading-6 text-gray-900">{{ $conversation->user1->name }}
                            </p>
                            <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{ $conversation->user1->email }}
                            </p>
                        </div>
                    </div>
                    <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                        <p class="text-sm leading-6 text-gray-900">Co-Founder / CEO</p>
                        <p>
                            @if ($conversation->user1->is_online)
                                <span class="text-green-500 inline">
                                    Online
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                        class="size-4 inline">
                                        <path fill-rule="evenodd"
                                            d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm3.844-8.791a.75.75 0 0 0-1.188-.918l-3.7 4.79-1.649-1.833a.75.75 0 1 0-1.114 1.004l2.25 2.5a.75.75 0 0 0 1.15-.043l4.25-5.5Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            @else
                                <span class="text-red-500 inline-block flex justify-end ">
                                    Offline
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                        class="size-4 inline">
                                        <path fill-rule="evenodd"
                                            d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm2.78-4.22a.75.75 0 0 1-1.06 0L8 9.06l-1.72 1.72a.75.75 0 1 1-1.06-1.06L6.94 8 5.22 6.28a.75.75 0 0 1 1.06-1.06L8 6.94l1.72-1.72a.75.75 0 1 1 1.06 1.06L9.06 8l1.72 1.72a.75.75 0 0 1 0 1.06Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <span class="block">
                                    @if ($conversation->user1->last_seen_at)
                                        Last seen
                                        {{ \Carbon\Carbon::parse($conversation->user1->last_seen_at)->diffForHumans(['short' => true]) }}
                                    @else
                                        No data available
                                    @endif
                                </span>
                            @endif
                        </p>


                    </div>
                </li>
            @endif
        @endforeach

    </ul>

</div>

<!-- منطقة المحادثة -->
