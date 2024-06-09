<?php

use App\Events\UserOffline;
use Carbon\Carbon;
use App\Events\UserOnline;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class Helpers
{
    public static  function formatMessageDate($created_at)
    {
        $date = Carbon::parse($created_at);
        if ($date->isToday()) {
            return "Today : " . $date->format('H:i');
        } elseif ($date->isYesterday()) {
            return 'Yesterday : ' . $date->format('H:i');
        } else {
            return $date->format('d/m/y H:i');
        }
    }

    public static function isUserOnline($user_id)
    {
        $user =User::find($user_id);
        if(Cache::has("user-is-online-".$user_id) && $user->status){
            // event(new UserOnline($user_id));
            return "Online";
        }
        else{
            event(new UserOnline($user_id,$user->status));
            $user->status = false;
            $user->save();
            return "Offline";
        }
    }
    public static function formatLastSeen($lastSeenAt) {
        if ($lastSeenAt === null) {
            return "I'm not login yeat";
        }

        $lastSeenDate = Carbon::parse($lastSeenAt);
        $now = Carbon::now();
        $diffInMinutes = $now->diffInMinutes($lastSeenDate);

        if ($diffInMinutes < 1) {
            return "Last seen Just now";
        } else if ($diffInMinutes < 60) {
            return "Last seen {$diffInMinutes} m ago";
        } else if ($diffInMinutes < 1440) {
            $diffInHours = floor($diffInMinutes / 60);
            return "Last seen {$diffInHours} h ago";
        } else {
            $diffInDays = floor($diffInMinutes / 1440);
            return "Last seen {$diffInDays} d ago";
        }
    }

}
