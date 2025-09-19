<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind CSS Email Template</title>
    <script src="{{ asset('css/tailwindcss.css') }}"></script>

    <style>
        /* أنماط Tailwind مدمجة هنا */
        .bg-gray-100 {
            background-color: #f7fafc;
        }

        .max-w-2xl {
            max-width: 42rem;
        }
        a{
            text-decoration: inherit;
        }
        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }
        .inline-block {    display: inline-block;}
        .p-6 {
            padding: 1.5rem;
        }

        .bg-white {
            background-color: #ffffff;
        }

        .rounded-lg {
            border-radius: 0.5rem;
        }

        .bg-white {
            --tw-bg-opacity: 1;
            background-color: rgb(255 255 255 / var(--tw-bg-opacity));
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

        .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .bg-blue-600 {
            --tw-bg-opacity: 1;
            background-color: rgb(37 99 235 / var(--tw-bg-opacity));
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .text-gray-700 {
            color: #4a5568;
        }

        .text-gray-700 {
            --tw-text-opacity: 1;
            color: rgb(55 65 81 / var(--tw-text-opacity));
        }

        .mb-6 {
            margin-bottom: 1.5rem;
        }

        .text-center {
            text-align: center;
        }

        .pb-4 {
            padding-bottom: 1rem;
        }

        .border-b {
            border-bottom-width: 1px;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .pb-4 {
            padding-bottom: 1rem;
        }

        .border-b {
            border-bottom: 1px solid #e2e8f0;
        }

        .text-center {
            text-align: center;
        }

        .shadow-md {
            --tw-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --tw-shadow-colored: 0 4px 6px -1px var(--tw-shadow-color), 0 2px 4px -2px var(--tw-shadow-color);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
        }


        .p-6 {
            padding: 1.5rem;
        }

        .bg-white {
            --tw-bg-opacity: 1;
            background-color: rgb(255 255 255 / var(--tw-bg-opacity));
        }

        .rounded-lg {
            border-radius: 0.5rem;
        }

        .max-w-2xl {
            max-width: 42rem;
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }

        .text-white {
            --tw-text-opacity: 1;
            color: rgb(255 255 255 / var(--tw-text-opacity));
        }

        .border-t {
            border-top-width: 1px;
        }

        .pt-4 {
            padding-top: 1rem;
        }

        .border-t {
            border-top: 1px solid #e2e8f0;
        }

        .text-gray-600 {
            color: #718096;
        }

        .text-center {
            text-align: center;
        }

        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem;
        }
    </style>
</head>

<body class="bg-gray-100">
    @yield('content')
</body>

</html>
