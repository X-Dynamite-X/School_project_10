<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view("admin.user", ['users' => $users]);
    }
    public function getUserData($id)
    {
        $user = User::find($id);
        $roles = $user->getRoleNames();
        $permission = $user->getPermissionNames();
        if ($user) {
            return response()->json([$user,$roles,$permission]);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }
    public function getUser()
    {
        $users = User::query();
        return DataTables::of($users)
            ->addColumn('roles', function ($user) {
                $roles = '';
                foreach ($user->getRoleNames() as $role) {
                    $roles .= ' <span class="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">' . $role . '</span><br>';
                }
                return $roles;
            })
            ->addColumn('actev', function ($user) {
                $permission = '';
                foreach ($user->getPermissionNames() as $permission) {
                    if("isActev"==$permission){
                        $permission = ' <span id="userActevSpanId_'.$user->id.'" class="bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">' . $permission . '</span>';
                    }
                    else{
                        $permission = ' <span id="userActevSpanId_'.$user->id.'" class="bg-red-400 text-white text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">' . $permission . '</span>';

                    }
                }
                return $permission;
            })
            ->addColumn("userInSubject", function ($user) {
                return $user->subjects->count();
            })
            ->rawColumns(["actev",'roles', "Action",])
            ->setRowId('trUser_{{$id}}')
            ->addColumn("Action", "admin.dataTables.user.actionUserTable",)
            ->toJson();
    }


    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                "email" => "required|email|unique:users",
                'password' => 'required|string|min:3|confirmed',
            ],
            [
                'name.required' => 'The name field is required',
                'email.required' => 'The email field is required',
                'email.unique' => 'The email field is already exist',
                'password.confirmed' => 'The password confirmation does not match.',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['error' => 'Validation failed', 'message' => $validator->errors()], 422);
        }
        $user = User::create([
            "name" => $request->input('name'),
            "email" => $request->input('email'),
            "password" => $request->input('password'),
        ]);
        $user->assignRole('user');
        $user->givePermissionTo("notActev");

        return response()->json($user);
    }

    public function update(Request $request, string $id)
    {
        // dd([$request,$request->image,$request->hasFile("image")]);

        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'user not found'], 404);
        }


        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'image' => 'image|mimes:png,jpg,jpeg,gif,svg|max:2048',
                'files[]' => 'max:2048',

            ],
            [
                'name.required' => 'The name field is required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => 'Validation failed', 'message' => $validator->errors()], 422);
        }
        if ($request->hasFile('image')) {
            $image_name = time() . '.' . $request->image->extension();
            $request->image->move(public_path('imageProfile/'), $image_name);
            $user->image = $image_name;
        }
        $permission = "";
        if($request->actev == "on"){
            $user->revokePermissionTo("notActev");
            $user->givePermissionTo("isActev");
            $permission = "isActev";
        }
        else{
            $user->revokePermissionTo("isActev");
            $user->givePermissionTo("notActev");
            $permission = "notActev";
        }
        $user->name = $request->input('name');
        $user->save();

        return response()->json([$user,$permission]);
    }


    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([], 404);
        }

        $user->delete();
        return response()->json(["message"=>"Delete Successfuly"]);
    }
}
