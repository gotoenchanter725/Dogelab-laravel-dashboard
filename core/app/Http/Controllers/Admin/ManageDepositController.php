<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Track;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ManageDepositController extends Controller
{
    public function index()
    {
        $deposits = Deposit::where('status',1)->orderBy('id','DESC')->paginate(getPaginate());
        $page_title = 'All Deposits';
        $empty_message = 'No deposit yet';
        return view('admin.deposit.index', compact('deposits', 'page_title', 'empty_message'));
    }

    public function depositSearch(Request $request)
    {
        $search = $request->search;
        $empty_message = 'No deposit found';

        $deposits = Deposit::with('account')->where('status','!=',0)->where(function ($q) use ($search) {
            $q->where('trx', 'like', "%$search%")
            ->orWhere('wallet', 'like', "%$search%")
            ->orWhereHas('account', function ($account) use ($search) {
                $account->where('unique_id', 'like', "%$search%");
            });
        });

        $deposits = $deposits->paginate(getPaginate());
        $page_title = 'Search results for - "' . $search.'"';

        return view('admin.deposit.index', compact('page_title', 'search', 'empty_message', 'deposits'));
    }

    public function dateSearch(Request $request)
    {
        $search = $request->date;
        if (!$search) {
            return back();
        }
        $date = explode('-',$search);
        $notify[]=['error','Invalid Date'];
        if(!(@strtotime($date[0]))){
            return back()->withNotify($notify);
        }
        if(isset($date[1]) && !strtotime($date[1])){
            return back()->withNotify($notify);
        }
        $start  = @$date[0];
        $end    = @$date[1];
        if ($start)
            $deposits = Deposit::where('status','!=',0)->where('created_at','>',Carbon::parse($start)->subDays(1))->where('created_at','<=',Carbon::parse($start)->addDays(1));

        if($end)
            $deposits = Deposit::where('status','!=',0)->where('created_at','>',Carbon::parse($start)->subDays(1))->where('created_at','<',Carbon::parse($end)->addDays(1));


        $deposits = $deposits->with('account')->latest()->paginate(getPaginate());

        if(!$end) $page_title = 'Deposits on '.showDateTime($start, 'd M, Y');
        else $page_title = 'Deposits between '.showDateTime($start, 'd M, Y').' to '.showDateTime($end, 'd M, Y');

        $empty_message = 'No deposit found';
        $dateSearch = $search;
        return view('admin.deposit.index', compact('page_title', 'empty_message', 'deposits','dateSearch'));
    }

    public function miningTracks()
    {
        $tracks = Track::orderBy('id','DESC')->paginate(getPaginate());
        $page_title = 'All Mining Tracks';
        $empty_message = 'No mining track yet';
        return view('admin.track.index', compact('tracks', 'page_title', 'empty_message'));
    }


}
