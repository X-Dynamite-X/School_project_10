<div class="mb-4">
    <div class="bg-gray-200 p-3 rounded-lg inline-block">
        <img class="h-8 w-8 rounded-full inline " id="imgAvatar1"
            src="{{ asset('imageProfile/' . $message->sender->image) }}" alt="">
        <p class="inline">{{ $message->message_text }}</p>

    </div>
</div>
