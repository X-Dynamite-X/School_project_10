 @extends('emails.layouts.app')

 @section('content')
     <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
         <!-- Header -->
         <div class="text-center border-b pb-4 mb-4">
             <h1 class="text-2xl font-semibold text-gray-800">Verify Your Email Address</h1>
             <p class="text-gray-600">Please verify your email to continue using our app</p>
         </div>
         <!-- Main Content -->
         <div class="mb-6">
             <p class="text-gray-700 mb-4">Hello, {{ $user->name }}</p>
             <p class="text-gray-700 mb-4">Thank you for registering. Please click the button below to verify your email
                 address.</p>
             <div class="text-center">
                 <a href="{{ url('/verify/' . $user->verification_token) }}"
                     class="inline-block px-6 py-2 mt-4 text-white bg-blue-600 rounded-full">Verify Email</a>
             </div>
         </div>
         <!-- Footer -->
         <div class="border-t pt-4 text-center text-gray-600">
             <p>&copy; 2024 Messaging App. All rights reserved.</p>
             <p class="text-sm">1234 Street, City, Country</p>
         </div>
     </div>
 @endsection
