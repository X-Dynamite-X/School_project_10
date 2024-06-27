@extends('layouts.app')
@section('content')
    <div class="message" id="app">
        <main class="flex ">
            @include('user.message.sidebar')
            <div class="chatCode w-4/5" >
                @include('user.message.startPage')
            </div>
            <div class="modle">
                <div class="editMessageTextModle"></div>
                <div class="deleteMessageTextModle"></div>

            </div>
        </main>
    </div>
@endsection
@section('js')
    <script src="{{ asset('js/Conversation/search.js') }}"></script>
    <script src="{{ asset('js/Conversation/NewConversation.js') }}"></script>
    <script src="{{ asset('js/Conversation/createConversation.js') }}"></script>
    <script src="{{ asset('js/Conversation/showConversation.js') }}"></script>
    <script src="{{ asset('js/Conversation/showChatConversation.js') }}"></script>
    <script src="{{ asset('js/message/sendeMessage.js') }}"></script>
    <script src="{{ asset('js/message/styleBoxMessage.js') }}"></script>
    <script src="{{ asset('js/message/updateMessage.js') }}"></script>
    <script src="{{ asset('js/message/deleteMessage.js') }}"></script>



@endsection
