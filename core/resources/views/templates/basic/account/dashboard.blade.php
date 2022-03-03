@extends($activeTemplate.'layouts.master')

@php
    $content    = getContent('user_dashboard.content',true);
@endphp

@section('content')
<section class="dashboard-section bg--theme--overlay-2 bg_img bg_fixed" data-background="{{getImage('assets/images/frontend/user_dashboard/' . @$content->data_values->background_image, '1920x1080')}}">
    <div class="container">
        <div class="dashboard__hero__content">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <h3 class="subtitle text-white m-0 mb-4">@lang($page_title)</h3>
                    <div class="card custom--card mb-5 text--white">
                        <div class="card-header py-3">
                            <h5 class="card-title m-0">{{ $account->wallet }}</h5>
                        </div>
                        <div class="card-body py-5">
                            <h4 class="card__dogecoin__balance text--white"><span id="mined">{{ $track->balance }}</span> @lang($general->cur_sym)</h4>
                        </div>
                        <div class="card-footer py-3">
                            <span class="card__text">
                                @lang('MINER SPEED'): <span>{{ $track->speed }}</span> @lang('DH/S') | @lang('DAILY PROFIT') <span id="dailyProfit"> {{ $track->speed * $general->daily_earning }} </span> @lang($general->cur_text)
                            </span>
                        </div>
                    </div>

                    @if($general->referral_system)
                    <div class="card custom--card mb-5 text--white">
                        <div class="card-header py-3">
                            <h5 class="card-title m-0">@lang('Your Referral Link')</h5>
                        </div>

                        <div class="card-body p-lg-5 p-sm-0">
                            <div class="form-group m-0">
                                <div class="input-group m-0">
                                    <input type="url" id="ref" value="{{ route('home').'?ref='.$account->unique_id }}" class="form-control form--control bg-transparent" readonly>

                                    <button  type="button"  data-copytarget="#ref" class="input-group-text bg--base border--light text--white copybtn"><i class="fa fa-copy"></i> &nbsp; @lang('Copy')</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endif

                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('account.deposit') }}" class="d-block">
                                <div class="card custom--card mb-5 text--white">
                                    <div class="card-header py-3">
                                        <h5 class="card-title m-0">@lang('Deposits')</h5>
                                    </div>
                                    <div class="card-body">
                                        <span class="digit-count">{{ $deposit_count }}</span>
                                        <hr>
                                        <p class="digit-amount-label">@lang('Total Deposited Amount')</p>
                                        <span class="digit-amount">{{ getAmount($deposit_total) }} @lang($general->cur_text)</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('account.withdraw') }}" class="d-block">
                                <div class="card custom--card mb-5 text--white">
                                    <div class="card-header py-3">
                                        <h5 class="card-title m-0">@lang('Withdrawals')</h5>
                                    </div>
                                    <div class="card-body">
                                        <span class="digit-count">{{ $withdraw_count }}</span>
                                        <hr>
                                        <p class="digit-amount-label">@lang('Total Witdrawal Amount')</p>
                                        <span class="digit-amount d-block">{{ getAmount($withdraw_total) }} @lang($general->cur_text)</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('account.referrals') }}" class="d-block">
                                <div class="card custom--card mb-5 text--white">
                                    <div class="card-header py-3">
                                        <h5 class="card-title m-0">@lang('Referrals')</h5>
                                    </div>
                                    <div class="card-body">
                                        <span class="digit-count">{{ $referral_count }}</span>
                                        <hr>
                                        <p class="digit-amount-label">@lang('Total Referral Bonus')</p>
                                        <span class="digit-amount">{{ getAmount($account->referrals->sum('bonus_value')) }} @lang($general->cur_text)</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('script')
    <script>
        'use strict';
        (function($){
            let dailyProfit             = $('#dailyProfit').text();
            let dailyProfitInSeconds    = dailyProfit/864000;

            let minedAmount             = {{$track->balance}};
                setInterval(function(){
                minedAmount += dailyProfitInSeconds;
                $('#mined').text(minedAmount.toFixed(8));
            }, 100);
        })(jQuery);

        document.querySelectorAll('.copybtn').forEach((element)=>{
            element.addEventListener('click', copy, true);
        })

        function copy(e) {
            var
                t = e.target,
                c = t.dataset.copytarget,
                inp = (c ? document.querySelector(c) : null);
            if (inp && inp.select) {
                inp.select();
                try {
                    document.execCommand('copy');
                    inp.blur();
                    t.classList.add('copied');
                    setTimeout(function() { t.classList.remove('copied'); }, 1500);
                }catch (err) {
                    alert(`@lang('Please press Ctrl/Cmd+C to copy')`);
                }
            }
        }


    </script>
@endpush
