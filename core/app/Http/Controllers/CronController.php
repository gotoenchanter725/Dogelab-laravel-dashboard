<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use App\Models\Track;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CronController extends Controller
{
    public function runCron()
    {
        $general = GeneralSetting::first();

        $general->last_cron = Carbon::now()->toDateTimeString();
        $general->save();

        $tracks = Track::where('status', 1)->get();

        foreach ($tracks as $track) {
            $diff_in_seconds= Carbon::now()->diffInSeconds($track->updated_at);
            $daily_earning  = $track->speed * $general->daily_earning;
            $per_sec_earning= $daily_earning / 86400;
            $total          = round($diff_in_seconds * $per_sec_earning, 8);
            $track->balance += $total;
            $track->save();
        }
    }
}
