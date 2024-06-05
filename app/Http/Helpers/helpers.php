<?php

use App\Events\UserOffline;
use Carbon\Carbon;
use App\Events\UserOnline;
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
        if(Cache::has("user-is-online-".$user_id)){
            // event(new UserOnline($user_id));
            return "Online";
        }
        else{
            // event(new UserOffline($user_id));
            return "Offline";
        }
    }


}
