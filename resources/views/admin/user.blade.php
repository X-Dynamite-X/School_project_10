@extends('admin.layouts.admin')
@section('css')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/table_ajax.css') }}">
@endsection
@section('content_admin')
    <div class="flex-grow p-4  container mt-4">
        <button id="openCreatUser" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            Create
        </button>
        <div class="container ">
            <table id="user_table" class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="">
                        <th class="px-4 py-2 text-sm font-semibold text-gray-900 bg-gray-100">id</th>
                        <th class="px-4 py-2 text-sm font-semibold text-gray-900 bg-gray-100">Name</th>
                        <th class="px-4 py-2 text-sm font-semibold text-gray-900 bg-gray-100">Email</th>
                        <th class="px-4 py-2 text-sm font-semibold text-gray-900 bg-gray-100">Subject in user</th>
                        <th class="px-4 py-2 text-sm font-semibold text-gray-900 bg-gray-100">Actev</th>
                        <th class="px-4 py-2 text-sm font-semibold text-gray-900 bg-gray-100">Role</th>
                        <th class="px-4 py-2 text-sm font-semibold text-gray-900 bg-gray-100">Action</th>
                    </tr>
                </thead>
                <tbody id = "tbodyUser" class="bg-white divide-y divide-gray-200">
                </tbody>
            </table>
        </div>
        <div class="modle">
            @include('admin.model.user.allModle')

        </div>

    </div>
@endsection
@section('js')
    
    @include("admin.model.user.routeUser")
    <script src="{{ asset('js/DataTables/userDataTable.js') }}"></script>
    <script src="{{ asset('js/admin/user/createUser.js') }}"></script>
    <script src="{{ asset('js/admin/user/editUser.js') }}"></script>
    <script src="{{ asset('js/admin/user/infoUser.js') }}"></script>
    <script src="{{ asset('js/admin/user/delete.js') }}"></script>



@endsection
