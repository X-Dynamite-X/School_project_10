<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Design</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .notification-container {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 50;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="notification-container" id="notification">
        <div class="max-w-md w-full bg-white shadow-lg rounded-lg flex p-4 relative">
            <img class="h-12 w-12 rounded-full" src="http://192.168.1.204:8000/imageProfile/1717199159.jpg"
                alt="User Image">
            <div class="ml-4 flex-1">
                <h2 class="text-lg font-semibold">Emilia Gates</h2>
                <p class="text-gray-600">Sure! 8:30pm works great!</p>
            </div>
            <a href="#" class="text-blue-500 hover:underline ml-4 mt-7">Reply</a>
            <button onclick="closeNotification()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
    <script>
        function closeNotification() {
            document.getElementById('notification').style.display = 'none';
        }
    </script>
</body>

</html>
