<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind CSS Email Template</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite('resources/css/app.css')
</head>


<body class="bg-gray-100">
    <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
        <!-- Header -->
        <div class="text-center border-b pb-4 mb-4">
            <h1 class="text-2xl font-semibold text-gray-800">You've Got a New Message!</h1>
            <p class="text-gray-600">Check your inbox in our messaging app</p>
        </div>

        <!-- Main Content -->
        <div class="mb-6">
            <p class="text-gray-700 mb-4">Hello [{{ $receiver->name }}],</p>
            <p class="text-gray-700 mb-4">You have received a new message from [' {{ auth()->user()->name }} '] in our
                messaging app.</p>
            <div>
                <img class="h-8 w-8 rounded-full inline "
                    src="{{ $message->embed('imageProfile/' . $receiver->image) }}"
                    alt="user image a message sender  ">
                <p class="text-green-700 mb-4 inline">Message : (" {{ $message_text }} ")</p>
            </div>

        </div>

        <!-- Footer -->
        <div class="border-t pt-4 text-center text-gray-600">
            <p>&copy; 2024 Messaging App. All rights reserved.</p>
            <p class="text-sm">1234 Street, City, Country</p>
        </div>
    </div>
</body>

</html>
