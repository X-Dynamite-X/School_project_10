@extends('layouts.app')
@section('content')
    <div class="message" id="app">
        {{-- <div class=" width-100">
        </div> --}}

        <main class="flex ">
            @include('user.message.sidebar')
            @include('user.message.chatSbace')


        </main>
    </div>
@endsection
@section('js')

<script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
    <script>
        const conversationId  = "{{$conversation->id}}";
    </script>

    <script src="{{ asset('js/message/search.js') }}"></script>
    <script src="{{ asset('js/message/chat.js') }}"></script>
@endsection

