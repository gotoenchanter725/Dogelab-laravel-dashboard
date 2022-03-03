<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Deposit;
use App\Models\Gateway;
use App\Models\GeneralSetting;
use App\Models\ReferralLog;
use App\Models\Track;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }

    public function home()
    {
        $account        = session('ACCOUNT');
        $account        = Account::where('wallet', $account)->first();

        $general        = GeneralSetting::first();
        $page_title     = 'Dashboard';
        $track          = Track::where('account_id', $account->id)->where('status', 1)->first();

        $diff_in_seconds= Carbon::now()->diffInSeconds($track->updated_at);

        $daily_earning  = $track->speed * $general->daily_earning;
        $per_sec_earning= $daily_earning / 86400;

        $total          = round($diff_in_seconds * $per_sec_earning, 8);

        $track->balance += $total;
        $track->save();

        $deposits       = Deposit::where('account_id', $account->id)->where('status', 1);
        $deposit_count  = $deposits->count();
        $deposit_total  = $deposits->sum('amount');

        $withdraws      = Withdrawal::where('account_id', $account->id);
        $withdraw_count = $withdraws->count();
        $withdraw_total = $withdraws->sum('amount');

        $referral_count = Account::where('ref_by', $account->id)->count();

        return view($this->activeTemplate . 'account.dashboard', compact('account', 'track', 'page_title', 'deposit_count', 'deposit_total', 'withdraw_count', 'withdraw_total', 'referral_count'));

    }

    public function deposit()
    {
        $account    = session('ACCOUNT');
        $account    = Account::where('wallet', $account)->first();
        $deposits   = Deposit::where('account_id', $account->id)
                        ->where('status', 1)
                        ->paginate(getPaginate());

        $gateway    = Gateway::findOrFail(1);
        $page_title = 'Deposit';

        return view($this->activeTemplate . 'account.deposit', compact('account', 'gateway', 'deposits', 'page_title'));
    }

    public function withdraw(Type $var = null)
    {
        $account    = session('ACCOUNT');
        $account    = Account::where('wallet', $account)->first();
        $page_title = 'Withdraw';
        $track      = Track::where('account_id', $account->id)->first();
        $withdrawals= Withdrawal::where('account_id', $account->id)->paginate(getPaginate());
        $gateway    = Gateway::findOrFail(1);

        return view($this->activeTemplate . 'account.withdraw', compact('account', 'gateway', 'withdrawals', 'track', 'page_title'));

    }

    public function myReferrals()
    {
        $general = GeneralSetting::first();
        if(!$general->referral_system){
            $notify[]=['error','Referral system is not available now'];
            return back()->withNotify($notify);
        }

        $account    = session('ACCOUNT');
        $account    = Account::where('wallet', $account)->first();
        $ref_logs   = ReferralLog::where('account_id', $account->id)->with('referee')->paginate(getPaginate());
        $page_title = 'Referral';

        return view($this->activeTemplate . 'account.referrals', compact('account', 'page_title', 'ref_logs'));

    }

    public function login(Request $request)
    {

        $checkAccount = curl_init('https://dogechain.info/api/v1/address/balance/' . $request->wallet);
        curl_setopt($checkAccount, CURLOPT_RETURNTRANSFER, 1);

        $data = curl_exec($checkAccount);
        curl_close($checkAccount);
        $type = json_decode($data);

        if(!$type->success){
            return response()->json(['error' => 'Address is invalid']);
        }else{
            //Check if the wallet has already been taken
            $account = Account::where('wallet', $request->wallet)->first();

            if($account){
                if($account->status==0){
                    return response()->json(['error' => 'This address is banned by admin']);
                }
                session()->put('ACCOUNT', $request->wallet);
                return response()->json(['success' => 'Account found']);
            }

            $ref_by = null;

            $ref_id     = session()->get('reference');

            if($ref_id){
                $ref_user   = Account::where('unique_id', $ref_id)->first();
                $ref_by     = $ref_user->id;
            }

            $account            = new Account();
            $account->ref_by    = $ref_by;
            $account->unique_id = getUniqueId();
            $account->wallet    = $request->wallet;
            $account->save();

            $general            = GeneralSetting::first();

            $track              = new Track();
            $track->account_id  = $account->id;
            $track->speed       = $general->free_dhs;
            $track->balance     = 0;
            $track->save();

            session()->put('ACCOUNT', $request->wallet);
            session()->forget('REFER_BY');

            return response()->json(['success' => 'New account created successfully']);
        }
    }

    public function logout()
    {
        session()->forget('ACCOUNT');
        return redirect('/');
    }

}
