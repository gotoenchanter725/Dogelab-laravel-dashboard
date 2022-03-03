<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Carbon\Carbon;

class ManageWithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Withdrawal::orderBy('id','DESC')->paginate(25);
        $page_title = 'All Withdrawals';
        $empty_message = 'No withdrawal yet';
        return view('admin.withdrawal.index', compact('withdrawals', 'page_title', 'empty_message'));
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $page_title = 'Withdrawal search results for ';
        $empty_message = 'No withdrawal found.';

        $withdrawals = Withdrawal::with('account')->where(function ($q) use ($search) {
            $q->where('trx', 'like', "%$search%")
            ->orWhereHas('account', function ($account) use ($search) {
                $account->where('unique_id', 'like', "%$search%");
            });
        });

        $withdrawals = $withdrawals->paginate(getPaginate());
        $page_title = 'Search results for - "' . $search.'"';

        return view('admin.withdrawal.index', compact('page_title', 'search', 'empty_message', 'withdrawals'));
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
            $withdrawals = Withdrawal::where('created_at','>',Carbon::parse($start)->subDays(1))->where('created_at','<=',Carbon::parse($start)->addDays(1));

        if($end)
            $withdrawals = Withdrawal::where('created_at','>',Carbon::parse($start)->subDays(1))->where('created_at','<',Carbon::parse($end)->addDays(1));


        $withdrawals = $withdrawals->with('account')->latest()->paginate(getPaginate());

        if(!$end) $page_title = 'Withdrawals on '.showDateTime($start, 'd M, Y');
        else $page_title = 'Withdrawals between '.showDateTime($start, 'd M, Y').' to '.showDateTime($end, 'd M, Y');

        $empty_message = 'No withdrawal found';
        $dateSearch = $search;
        return view('admin.withdrawal.index', compact('page_title', 'empty_message', 'withdrawals','dateSearch'));
    }
}
