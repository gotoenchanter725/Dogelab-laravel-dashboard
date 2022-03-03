@extends('admin.layouts.app')

@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body">
                <h3 class="card-title border-bottom text-center pb-3 text--info">
                    @lang("This system uses the <strong>Coinpayment</strong> gateway for both deposit and withdrawal")
                </h3>
                <form action="{{ route('admin.gateway.update', $gateway->id) }}" method="POST">
                    @csrf

                    <div class="row">

                        <div class="form-group col-xl-12">
                            <label class="font-weight-bold" for="key1">@lang('Public Key')</label>
                            <input type="text" name="public_key" value="{{ $gateway->key_1 }}" id="key1" class="form-control form-control-lg">
                        </div>

                        <div class="form-group col-xl-12">
                            <label class="font-weight-bold" for="key2">@lang('Private Key')</label>
                            <input type="text" name="private_key" value="{{ $gateway->key_2 }}" id="key2" class="form-control form-control-lg">
                        </div>

                        <div class="form-group col-xl-3">
                            <label class="font-weight-bold" for="minimum_deposit">@lang('Minimum Deposit Limit')</label>
                            <div class="input-group">
                                <input type="text" name="minimum_deposit_limit" id="minimum_deposit" value="{{ $gateway->minimum_deposit }}" id="min-limit" class="form-control form-control-lg">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        {{ $general->cur_text }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-xl-3">
                            <label class="font-weight-bold" for="minimum_withdrawal_limit">@lang('Minimum Withdrawal Limit')</label>
                            <div class="input-group">
                                <input type="text" name="minimum_withdrawal_limit" value="{{ $gateway->minimum_withdraw }}" id="minimum_withdrawal_limit" class="form-control form-control-lg">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        {{ $general->cur_text }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-xl-3">
                            <label class="font-weight-bold" for="maximum_withdrawal_limit">@lang('Maximum Withdrawal Limit')</label>
                            <div class="input-group">
                                <input type="text" name="maximum_withdrawal_limit" value="{{ $gateway->maximum_withdraw }}" id="maximum_withdrawal_limit" class="form-control form-control-lg">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        {{ $general->cur_text }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-xl-3">
                            <label class="form-control-label font-weight-bold"> @lang('Withdraw System')</label>
                            <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disable')" name="withdraw_system" @if($gateway->enable_withdraw) checked @endif>
                        </div>
                    </div>



                    <button type="submit" class="btn btn-lg btn-block btn--primary">@lang('Update')</button>
                </form>
            </div>
        </div><!-- card end -->
    </div>
</div>

@endsection
