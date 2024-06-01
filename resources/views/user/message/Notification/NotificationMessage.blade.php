<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind CSS Email Template</title>
    <style>
        /* أنماط Tailwind مدمجة هنا */
        .bg-gray-100 {
            background-color: #f7fafc;
        }

        .max-w-2xl {
            max-width: 42rem;
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }

        .p-6 {
            padding: 1.5rem;
        }

        .bg-white {
            background-color: #ffffff;
        }

        .rounded-lg {
            border-radius: 0.5rem;
        }

        .shadow-md {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .text-center {
            text-align: center;
        }

        .border-b {
            border-bottom: 1px solid #e2e8f0;
        }

        .pb-4 {
            padding-bottom: 1rem;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .text-2xl {
            font-size: 1.5rem;
        }

        .font-semibold {
            font-weight: 600;
        }

        .text-gray-800 {
            color: #2d3748;
        }

        .text-gray-600 {
            color: #718096;
        }

        .mb-6 {
            margin-bottom: 1.5rem;
        }

        .text-gray-700 {
            color: #4a5568;
        }

        .h-8 {
            height: 2rem;
        }

        .w-8 {
            width: 2rem;
        }

        .rounded-full {
            border-radius: 9999px;
        }

        .text-green-700 {
            color: #2f855a;
        }

        .border-t {
            border-top: 1px solid #e2e8f0;
        }

        .pt-4 {
            padding-top: 1rem;
        }

        .text-sm {
            font-size: 0.875rem;
        }
    </style>
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
                    src="{{ $message->embed('imageProfile/' . $receiver->image) }}" alt="user image a message sender  ">
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
