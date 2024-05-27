<div class="mb-4 text-right">
    <div class="bg-blue-500 text-white p-3 rounded-lg inline-block">
        <p class="inline" >{{ $message->message_text }}</p>
        <img class="h-8 w-8 rounded-full inline " id="imgAvatar1"
        src="{{ asset('imageProfile/' . $message->sender->image) }}" alt="">
    </div>
