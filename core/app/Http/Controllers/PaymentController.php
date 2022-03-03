<?php

namespace App\Http\Controllers;

use App\Http\Lib\CoinPaymentHosted;
use App\Models\Account;
use App\Models\Deposit;
use App\Models\Gateway;
use App\Models\GeneralSetting;
use App\Models\ReferralLog;
use App\Models\Track;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function depositWallet()
    {
        $account = session('ACCOUNT');
        $account = Account::where('wallet', $account)->first();
        $general = GeneralSetting::first();

        if (isset($account)) {
            $gateway            = Gateway::find(1);
            $coinPayment        = new CoinPaymentHosted();
            $coinPayment->Setup($gateway->key_2, $gateway->key_1);
            $callbackUrl        = route('ipn.coinpayment.deposit');
            $result             = $coinPayment->GetCallbackAddress($general->cur_text, $callbackUrl);
            if ($result['error'] == 'ok') {
                $wallet                 = $result['result']['address'];
                $deposit                = new Deposit();
                $deposit->account_id    = $account->id;
                $deposit->amount        = 0;
                $deposit->wallet        = $wallet;
                $deposit->trx           = getTrx();
                $deposit->status        = 0;
                $deposit->save();
                return response()->json(['address' => $wallet]);
            } else {
                return response()->json(['error' => 'Sorry! something went wrong! '.$result['error']]);
            }
        } else {
            return redirect('/');
        }
    }


    public function ipnDeposit(Request $request)
    {
        $data = Deposit::where('status', 0)->where('wallet', $request->address)->orderBy('id', 'DESC')->first();

        if (($request->status >= 100 || $request->status == 2) && $data) {
            $gateway            = Gateway::find(1);
            if ($gateway->minimum_deposit > $request->amount) {
                $notify[] = ['error', 'Please follow the minimum deposit limit'];
                return back()->withNotify($notify);
            }
            $data->amount   = $request->amount;
            $data->status = 1;
            $data->save();
            $general                = GeneralSetting::first();
            $track                  = Track::find($data->account_id);
            $track->account_id      = $data->account_id;
            $track->speed           += intval($request->amount / $general->dhs_price);
            $track->save();

            $account = Account::find($data->account_id);

            if ($account && $general->referral_system) {

                $track = Track::where('account_id', $account->ref_by)->first();
                if ($track && $general->referral_bonus > 0) {
                    $bonus_amount         = ($request->amount * $general->referral_bonus) / 100;
                    $track->balance       += floatval($bonus_amount);
                    $track->save();

                    if ($track) {
                        $refLog                 = new ReferralLog();
                        $refLog->account_id     = $account->ref_by;
                        $refLog->ref_user_id    = $data->account_id;
                        $refLog->deposit_amount = $request->amount;
                        $refLog->bonus_value    = floatval($bonus_amount);
                        $refLog->save();
                    }
                }
            }
        }
    }

    public function withdrawMoney(Request $request)
    {
        $account = session('ACCOUNT');
        $account = Account::where('wallet', $account)->first();
        $track = $track = Track::find($account->id);
        if ($track) {
            $gateway = Gateway::find(1);
            $validate = Validator::make($request->except('_token'), [
                "amount" => "required|numeric|min:$gateway->minimum_withdraw"
            ]);
            if ($validate->fails()) {
                return response()->json(['error' => $validate->errors()->all()]);
            }
            if ($request->amount > $track->balance) {
                return response()->json(['error' => 'You don\'t have sufficient balance']);
            }else{
                $track->balance       = $track->balance - $request->amount;
                $track->withdraw      = $track->withdraw + $request->amount;
                $track->save();
                $general            = GeneralSetting::first();
                $cps                = new CoinPaymentHosted();
                $cps->Setup($gateway->key_2, $gateway->key_1);
                $result             = $cps->CreateWithdrawal($request->amount, strtoupper($general->cur_text), $account->wallet, 1);

                if($result['error'] == 'ok') {
                    $withdrawal             = new Withdrawal();
                    $withdrawal->account_id =  $account->id;
                    $withdrawal->amount     =  $request->amount;
                    $withdrawal->trx        =  getTrx();
                    $withdrawal->save();
                    return response()->json(['success'=>'Withdrawal completed successfully']);
                } else {
                    $track->balance      = $track->balance + $request->amount;
                    $track->withdraw     = $track->withdraw - $request->amount;
                    $track->save();
                    return response()->json(['error' => 'Something went wrong! '.$result['error']]);
                }
            }
        } else {
            return redirect('/');
        }
    }
}
