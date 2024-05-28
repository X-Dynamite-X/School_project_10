@extends('layouts.app')
@section('content')
    <div class="message" id="app">
        {{-- <div class=" width-100">
        </div> --}}

        <main class="flex ">
            @include('user.message.sidebar')
            <div class="chatCode w-3/4" >

                @include('user.message.startPage')
            </div>
        </main>
    </div>
@endsection
@section('js')
    <script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
    {{-- <script>
        const conversationId = "{{ $conversation->id }}";
        console.log(conversationId);
    </script> --}}

    <script src="{{ asset('js/message/search.js') }}"></script>
    <script src="{{ asset('js/message/createConversation.js') }}"></script>
    <script src="{{ asset('js/message/showConversation.js') }}"></script>
    <script src="{{ asset('js/message/chat.js') }}"></script>
@endsection
