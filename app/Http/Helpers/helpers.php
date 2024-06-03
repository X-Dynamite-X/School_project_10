<?php

use Carbon\Carbon;

class Helpers
{
    public static  function formatMessageDate($created_at)
    {
        $date = Carbon::parse($created_at);
        if ($date->isToday()) {
            return "Today : ". $date->format('H:i'); 
        } elseif ($date->isYesterday()) {
            return 'Yesterday : ' . $date->format('H:i'); 
        } else {
            return $date->format('d/m/y H:i'); 
        }
    }
}
