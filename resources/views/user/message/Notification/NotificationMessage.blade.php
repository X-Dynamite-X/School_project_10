<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind CSS Email Template</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                <p class="text-gray-700 mb-4">Hello [{{auth()->user()->name}}],</p>
                <p class="text-gray-700 mb-4">You have received a new message from [{{$receiver->name}}] in our messaging app.</p>
                <p class="text-green-700 mb-4">Message : (" {{$message_text}} ")</p>
                <p class="text-gray-700">Best regards,<br> The Messaging App Team</p>
            </div>

            <!-- Footer -->
            <div class="border-t pt-4 text-center text-gray-600">
                <p>&copy; 2024 Messaging App. All rights reserved.</p>
                <p class="text-sm">1234 Street, City, Country</p>
                <p class="text-sm">
                    <a href="#" class="text-blue-500 hover:underline">Unsubscribe</a> |
                    <a href="#" class="text-blue-500 hover:underline">Privacy Policy</a>
                </p>
            </div>
        </div>
</body>

</html>
