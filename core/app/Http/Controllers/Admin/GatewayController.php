<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gateway;
use App\Models\GatewayCurrency;

use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GatewayController extends Controller
{
    public function deposit()
    {
        $page_title = 'Payment Gateway';

        $gateway = Gateway::find(1);

        return view('admin.gateway.index', compact('page_title', 'gateway'));
    }


    public function update(Request $request,Gateway $gateway)
    {
        $request->validate([
            'minimum_deposit_limit'     => 'required|numeric|gt:0',
            'minimum_withdrawal_limit'  => 'required|numeric|gt:0',
            'maximum_withdrawal_limit'  => 'required|numeric|gt:minimum_withdrawal_limit',
            'public_key'                => 'required|string',
            'private_key'               => 'required|string',
        ]);

        $gateway->key_1             = $request->public_key;
        $gateway->key_2             = $request->private_key;
        $gateway->minimum_deposit   = $request->minimum_deposit_limit;
        $gateway->minimum_withdraw  = $request->minimum_withdrawal_limit;
        $gateway->maximum_withdraw  = $request->maximum_withdrawal_limit;
        $gateway->enable_withdraw   = $request->withdraw_system=='on'?1:0;

        $gateway->save();

        if($gateway){
            $notify[]=['success','Gateway Data Updated successfully'];
            return back()->withNotify($notify);
        }
    }
}
