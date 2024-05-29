@extends('layouts.app')
@section('content')
<div class="mt-5 fixed">

<div class="top-0 left-0 w-screen h-screen flex items-center justify-center">
    <div class="bg-gray-300 shadow-md rounded-lg p-6  w-1/3">
        <div class="flex items-center justify-center mb-4">
            <img id="userAvatar" class="w-24 h-24 rounded-full" src="{{ asset('imageProfile/' . auth()->user()->image) }}" alt="User Avatar">
        </div>
        <h2 id="userName" class="text-2xl font-semibold text-center mb-2">{{ auth()->user()->name }}</h2>
        <p id="userEmail" class="text-gray-600 text-center mb-4">{{ auth()->user()->email }}</p>
        <div class="flex justify-center">
            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Edit</button>
        </div>
    </div>
</div>
</div>
@endsection
