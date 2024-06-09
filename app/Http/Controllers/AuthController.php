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
    public function getUserStatus(Request $request)
    {
        $userId = $request->input('user_id');
        $user = User::find($userId);
        if ($user) {
            return response()->json(['status' => 'success', 'user' => $user]);
        }
        return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
    }
    public function setUserStatus(Request $request)
    {
        $userId = $request->input('user_id');
        $status = (int) $request->input('status');

        $user = User::find($userId);
        if ($user) {
            $user->status = $status;
            $user->last_seen_at = $status == 0 ? Carbon::now()->toDateTimeString() : null;
            $user->save();

            event(new UserOnline($userId, $status));

            return response()->json(['status' => 'success', 'user' => $user]);
        }

        return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
    }

}
