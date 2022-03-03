@extends($activeTemplate.'layouts.master')
@section('content')
@php
    $content    = getContent('user_dashboard.content',true);
@endphp

<section class="dashboard-section bg--theme--overlay-2 bg_img bg_fixed" data-background="{{getImage('assets/images/frontend/user_dashboard/' . @$content->data_values->background_image, '1920x1080')}}">
    <div class="container">
        <div class="dashboard__hero__content">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="card custom--card mb-5 text--white">
                        <div class="card-header py-3">
                            <h5 class="card-title m-0">@lang('Your Deposit Address')</h5>
                        </div>
                        <div class="card-body py-3">
                            <h4 class="card__dogecoin__balance text--white py-3 deposit-address d-none"></h4>
                            <img id="qrCodeImg"/>

                            <div id="waitingLoader" class="mb-2 d-none">
                                <i class="fas fa-spinner fa-2x fa-spin"></i>
                            </div>

                            <h4 class="mb-2 d-none error-message text--danger"></h4>

                            <form id="depositForm">
                                @csrf
                                <button type="submit" id="submitBtn" class="cmn--btn">@lang('Generate Deposit Address')</button>
                            </form>


                        </div>
                        <div class="card-footer py-3">
                            <span class="card__text">
                                @lang('Minimum Deposit Limit'): {{$gateway->minimum_deposit}} @lang($general->cur_text) | @lang('1 DH/S') = {{$general->dhs_price}} @lang($general->cur_text) | @lang('Daily') <strong>{{ $general->daily_earning }}</strong> @lang($general->cur_text) @lang('Per DH/S')
                            </span>
                        </div>
                    </div>
                    <div class="active--miners">
                        <h4 class="subtitle text-white pt-5 mb-4">@lang('Your Deposits')</h4>
                        <div class="table--responsive">
                            <table class="cmn--table table--white">
                                <thead>
                                    <tr>
                                        <th>@lang('TIME')</th>
                                        <th>@lang('WALLET')</th>
                                        <th>@lang('TRX NNUMBER')</th>
                                        <th>@lang('AMOUNT')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($deposits as $item)
                                    <tr>
                                        <td data-label="@lang('TIME')">
                                            <span>{{ showDateTime($item->created_at) }}</span>
                                        </td>
                                        <td data-label="@lang('Wallet')">
                                            {{$item->wallet}}
                                        </td>
                                        <td data-label="@lang('TRX NUMBER')">
                                            <span>{{$item->trx}}</span>
                                        </td>
                                        <td data-label="@lang('AMOUNT')">
                                            <span>{{$item->amount}} {{$general->cur_text}}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if($deposits->hasPages())
                                {{ $deposits->links() }}
                            @endif
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
            $('#depositForm').on('submit', function(e){
                e.preventDefault();
                $('#waitingLoader').removeClass('d-none').hide().show('slow');
                $('#submitBtn').attr('disabled', 'disabled');

                var data = $(this).serialize();
                $.ajax({
                    type:"POST",
                    url:"{{route('account.deposit')}}",
                    data: data,
                    dataType: "json",
                    success:function(data)
                    {
                        if(data.error){
                            $('#waitingLoader').addClass('d-none');
                            $('#submitBtn').removeAttr('disabled');

                            $('.error-message').removeClass('d-none').text(data.error);
                        }
                        else
                        {
                            $('#waitingLoader').addClass('d-none');
                            $('#depositForm').hide();
                            $('.deposit-address').text(data.address).removeClass('d-none');
                            let qrcode = 'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl='+data.address+'&choe=UTF-8';
                            $('#qrCodeImg').attr('src', qrcode);
                        }
                    }
                });
            })
        })(jQuery)
    </script>
@endpush
