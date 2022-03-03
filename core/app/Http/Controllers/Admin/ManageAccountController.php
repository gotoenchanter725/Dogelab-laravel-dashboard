<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Deposit;
use App\Models\GeneralSetting;
use App\Models\ReferralLog;
use App\Models\Withdrawal;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ManageAccountController extends Controller
{
    public function index()
    {
        $accounts   = Account::latest()->paginate(20);
        $page_title = 'All Accounts';
        $empty_message = 'No Account Found';
        return view('admin.account.index', compact('accounts', 'page_title', 'empty_message'));
    }

    public function active()
    {
        $accounts   = Account::where('status', 1)->latest()->paginate(20);
        $page_title = 'Active Accounts';
        $empty_message = 'No Account Found';
        return view('admin.account.index', compact('accounts', 'page_title', 'empty_message'));
    }

    public function referred()
    {
        $accounts   = Account::where('ref_by', '!=', null)->latest()->paginate(20);
        $page_title = 'Referred Accounts';
        $empty_message = 'No Account Found';
        return view('admin.account.index', compact('accounts', 'page_title', 'empty_message'));
    }

    public function banned()
    {
        $accounts   = Account::where('status', 0)->latest()->paginate(20);
        $page_title = 'Banned Accounts';
        $empty_message = 'No Account Found';
        return view('admin.account.index', compact('accounts', 'page_title', 'empty_message'));
    }

    public function single($id)
    {
        $account    = Account::where('id', $id)->with('track')->firstOrFail();
        $deposits   = $account->deposits()->where('status', 1)->take(3)->get();
        $withdrawals= $account->withdrawals()->take(3)->get();
        $general    = GeneralSetting::first();
        $diff       = Carbon::now()->diffInSeconds($account->track->created_at);
        $daily      = $account->track->speed*$general->daily;
        $perSec     = $daily/86400;
        $total      = $diff*$perSec;
        $balance    = $total - $account->track->withdraw;

        $page_title = 'Details of '.$account->unique_id;
        return view('admin.account.single', compact('account', 'page_title', 'deposits', 'withdrawals', 'balance'));
    }

    public function action(Request $request, $id)
    {
        $request->validate([
            'type'=>'required|in:0,1'
        ]);

        $account = Account::findOrFail($id);
        $account->status = $request->type;
        $account->save();
        $account->track->status = $request->type;
        $account->track->save();

        $notify[]=['success','Account status changed successfully'];
        return back()->withNotify($notify);
    }

    public function deposits($id) {
        $account = Account::findOrFail($id);
        $deposits = Deposit::where('status', 1)->where('account_id', $id)->paginate(getPaginate());
        $page_title = 'All Deposits of '. $account->unique_id;
        $empty_message = 'No deposit yet';
        return view('admin.deposit.index', compact('page_title', 'empty_message', 'deposits'));
    }
    public function withdrawals($id) {
        $account = Account::findOrFail($id);
        $withdrawals = Withdrawal::where('account_id', $id)->paginate(getPaginate());
        $page_title = 'All Withdrawals of '. $account->unique_id;
        $empty_message = 'No withdrawal yet';
        return view('admin.withdrawal.index', compact('page_title', 'empty_message', 'withdrawals'));
    }

    public function referralLog()
    {
        $logs           = ReferralLog::orderBy('id','DESC')->with(['referee', 'account'])->paginate(getPaginate());
        $page_title     = 'Referral Bonus Logs';
        $empty_message  = 'No data found';
        return view('admin.referral.index', compact('logs', 'page_title', 'empty_message'));
    }

}
