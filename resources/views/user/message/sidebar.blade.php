<div class="w-1/4 bg-white border-r overflow-y-auto fexd my_h_93">
    <div class="p-4 border-b">
        <h2 class="text-2xl font-semibold">Messages</h2>
        <input id="search" type="text" name="search" placeholder="Search To User .."
            class="w-full border border-gray-300 p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 search">
    </div>


        <ul class="contacts_search ">
        </ul>
    <hr>
    <ul class="myContacts">
        @foreach ($conversations as $conversation)
            @if ($conversation->user1_id == auth()->user()->id)
                <li  class="showConversation flex justify-between gap-x-6 py-5" data-conversation_id="{{$conversation->id}}" >
                        <div class="flex min-w-0 gap-x-4">
                            <img class="h-12 w-12 flex-none rounded-full bg-gray-50"
                                src="{{ asset('imageProfile/' . $conversation->user2->image) }}" alt="">
                            <div class="min-w-0 flex-auto">
                                <p class="text-sm font-semibold leading-6 text-gray-900">
                                    {{ $conversation->user2->name }}</p>
                                <p class="mt-1 truncate text-xs leading-5 text-gray-500">
                                    {{ $conversation->user2->email }}</p>
                            </div>
                        </div>
                        <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                            <p class="text-sm leading-6 text-gray-900">Co-Founder / CEO</p>
                            <p class="mt-1 text-xs leading-5 text-gray-500">Last seen <time
                                    datetime="2023-01-23T13:23Z">3h
                                    ago</time></p>
                        </div>
                </li>
            @elseif ($conversation->user2_id == auth()->user()->id)
                <li  class="showConversation flex justify-between gap-x-6 py-5" data-conversation_id="{{$conversation->id}}" >

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
                        <p class="mt-1 text-xs leading-5 text-gray-500">Last seen <time datetime="2023-01-23T13:23Z">3h
                                ago</time></p>
                    </div>
                </li>
            @endif
        @endforeach
    </ul>

</div>

<!-- منطقة المحادثة -->
