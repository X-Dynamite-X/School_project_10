@extends('layouts.app')

{{-- @section('css')
    <link rel="stylesheet" href="{{ asset('css/table_ajax.css') }}">
@endsection --}}
@section('content')
<div class=" p-4   mt-4   ">
    <div class="card flex justify-center">
        <div class="bg-gray-100 shadow-md rounded-lg p-6 max-w-md w-full">
            <div class="flex items-center justify-center mb-4">
                <img id="userAvatar" class="w-24 h-24 rounded-full" src="{{ asset('imageProfile/' . auth()->user()->image) }}"
                    alt="User Avatar">
            </div>
            <h2 id="userName" class="text-2xl font-semibold text-center mb-2">{{ auth()->user()->name }}</h2>
            <p id="userEmail" class="text-gray-600 text-center mb-4">{{ auth()->user()->email }}</p>
        </div>
    </div>


</div>
    <div class=" p-4   mt-4 flex justify-center  ">


        <div class="container ">
            <table id="userInfoTable" class=
            "w-full border-collapse border border-gray-300  ">
                <thead>
                    <tr class="">
                        <th class="px-4 py-2 text-sm font-semibold text-gray-900 bg-gray-100">User Name</th>
                        <th class="px-4 py-2 text-sm font-semibold text-gray-900 bg-gray-100">Name Subject</th>
                        <th class="px-4 py-2 text-sm font-semibold text-gray-900 bg-gray-100">Subject Code</th>
                        <th class="px-4 py-2 text-sm font-semibold text-gray-900 bg-gray-100">Success Mark</th>
                        <th class="px-4 py-2 text-sm font-semibold text-gray-900 bg-gray-100">Mark</th>
                        <th class="px-4 py-2 text-sm font-semibold text-gray-900 bg-gray-100">Full Mark</th>
                    </tr>
                </thead>
                <tbody id = "tbodyUser" class="bg-white divide-y divide-gray-200">
                    @foreach ($subjects as $subject)
                        <tr id="tr_subjects{{ $subject->id }}" class="text-center">
                            <td class="px-4 py-2 text-sm text-gray-900  whitespace-nowrap">{{ auth()->user()->name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900  whitespace-nowrap">{{ $subject->name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900  whitespace-nowrap">{{ $subject->subject_code }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900  whitespace-nowrap">{{ $subject->success_mark }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900  whitespace-nowrap">{{ $subject->pivot->mark }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900  whitespace-nowrap">{{ $subject->full_mark }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
@endsection
