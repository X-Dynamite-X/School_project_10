<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Events\UserOnline;
use App\Events\UserOffline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{

    // public function getUserStatus(Request $request )
    // {
    //     $userId = $request->input('user_id');
    //     $status = $request->input('status');
    //     event(new UserOnline($userId, $status));
    //     return response()->json(['status' => 'success']);

    // }
    public function getUserStatus(Request $request)
    {
        $userId = $request->input('user_id');
        $status = (int) $request->input('status');

        $user = User::find($userId);
        if ($user) {
            $user->status = $status;
            if ($status == 0) {
                $user->last_seen_at = Carbon::now()->toDateTimeString();
            } else {
                $user->last_seen_at = null;
            }
            $user->save();
            event(new UserOnline($userId, $status));

            return response()->json(['status' => 'success', 'user' => $user]);
        }

        return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
    }


    public function editUserStatus(Request $request )
    {
        $userId = $request->input('user_id');
        $status = false;
        $user = User::find($userId)->first();
        $user->status = $status;
        $user->save();
        event(new UserOnline($userId, $status));
        return response()->json(['status' => 'success']);
    }
    public function usersStatusCheck()
    {
        $users = User::all();
        return view("test",["users"=>$users]);
    }

}
