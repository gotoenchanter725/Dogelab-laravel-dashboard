@php
    $content    = getContent('transaction.content',true);
@endphp
@if($content)
    @php
        $deposits      = \App\Models\Deposit::where('status',1)->orderBy('id','DESC')->take(25)->get();
        $withdrawals   = \App\Models\Withdrawal::orderBy('id','DESC')->take(25)->get();
    @endphp
    <section class="investment-section bg--theme--overlay bg_fixed pt-120 pb-120 bottom--wave-wrapper top--wave-wrapper bg_img" data-background="{{getImage('assets/images/frontend/transaction/' . @$content->data_values->background_image, '1920x1080')}}" id="transaction">
    <div class="banner-shape-top">
        <img src="{{asset('assets/templates/basic/images/wave-rev.png')}}" alt="@lang('banner')">
    </div>
    <div class="banner-shape">
        <img src="{{asset('assets/templates/basic/images/wave.png')}}" alt="@lang('banner')">
    </div>
    <div class="container">
            <div class="section__header section__header__center text--white">
                <span class="section__cate">
                    @lang(@$content->data_values->title)
                </span>
                <h3 class="section__title">@lang(@$content->data_values->subtitle)</h3>
                <p>@lang(@$content->data_values->description)</p>
            </div>
            <ul class="nav nav-tabs nav--tabs">
                <li class="nav-item">
                    <a href="#deposit" class="nav-link active" data-bs-toggle="tab">@lang('Deposit')</a>
                </li>
                <li class="nav-item">
                    <a href="#withdraw" class="nav-link" data-bs-toggle="tab">@lang('Withdraw')</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="deposit">
                    <div class="table--responsive">
                        <table class="cmn--table table--white">
                            <thead>
                                <tr>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Wallet')</th>
                                    <th>@lang('Time')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($deposits as $deposit)
                                    <tr>
                                        <td data-label="Amount">
                                            <span>{{$deposit->amount}} {{ __($general->cur_text) }}</span>
                                        </td>
                                        <td data-label="Wallet">
                                            {!!substr_replace($deposit->account->wallet, '<b>XXX</b>', -3)!!}
                                        </td>
                                        <td data-label="TRX Time">
                                            <span>{{$deposit->updated_at}}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td class="text-center" colspan="100%">@lang('NO DATA AVAILABLE')</td></tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="withdraw">
                    <div class="table--responsive">
                        <table class="cmn--table table--white">
                            <thead>
                                <tr>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Wallet')</th>
                                    <th>@lang('Time')</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($withdrawals as $withdrawal)
                                    <tr>
                                        <td data-label="Amount">
                                            <span>{{$withdrawal->amount}} {{ __($general->cur_text) }}</span>
                                        </td>
                                        <td data-label="Wallet">
                                            {!!substr_replace($withdrawal->account->wallet, '<b>XXX</b>', -3)!!}
                                        </td>
                                        <td data-label="TRX Time">
                                            <span>{{$withdrawal->updated_at}}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td class="text-center" colspan="100%">@lang('NO DATA AVAILABLE')</td></tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
