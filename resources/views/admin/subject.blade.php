@extends('admin.layouts.admin')
@section('css')
    <script src="{{ asset('css/tailwindcss.css') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/table_ajax.css') }}">
@endsection
@section('content_admin')
    <div class="flex-grow p-4 container mt-4">

        <table id="subject_table" class="w-full border-collapse border border-gray-300">
            <button id="openCreatSubject" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Create
            </button>
            <thead>
                <tr>
                    <th class="px-4 py-2 text-sm font-semibold text-gray-900 bg-gray-100">ID</th>
                    <th class="px-4 py-2 text-sm font-semibold text-gray-900 bg-gray-100">Name Subject</th>
                    <th class="px-4 py-2 text-sm font-semibold text-gray-900 bg-gray-100">Code Subject</th>
                    <th class="px-4 py-2 text-sm font-semibold text-gray-900 bg-gray-100">User in Subject</th>
                    <th class="px-4 py-2 text-sm font-semibold text-gray-900 bg-gray-100">Success Mark</th>
                    <th class="px-4 py-2 text-sm font-semibold text-gray-900 bg-gray-100">Full Mark</th>
                    <th class="px-4 py-2 text-sm font-semibold text-gray-900 bg-gray-100 text-center">Action</th>
                </tr>
            </thead>
            <tbody id="tbodySubject" class="bg-white divide-y divide-gray-200">
            </tbody>
        </table>

        <div class="modl">
            @include('admin.model.subjects.allModle')
        </div>
    @endsection
    @section('js')

        <script src="{{ asset('js/DataTables/subjectDataTable.js') }}"></script>
        <script src="{{ asset('js/admin/subject/CreateSubject.js') }}"></script>
        <script src="{{ asset('js/admin/subject/EditSubject.js') }}"></script>
        <script src="{{ asset('js/admin/subject/DeleteSubject.js') }}"></script>
        <script src="{{ asset('js/DataTables/subjectUserDataTable.js') }}"></script>
        <script src="{{ asset('js/admin/subjectUser/createSubjectUser.js') }}"></script>
        <script src="{{ asset('js/admin/subjectUser/editSubjectUser.js') }}"></script>
        <script src="{{ asset('js/admin/subjectUser/deleteSubjectUser.js') }}"></script>

    @endsection
