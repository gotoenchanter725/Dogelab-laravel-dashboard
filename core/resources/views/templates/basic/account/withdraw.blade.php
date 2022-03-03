@extends($activeTemplate.'layouts.master')
@section('content')
@php
    $content    = getContent('user_dashboard.content',true);
@endphp

<section class="dashboard-section bg--theme--overlay-2 bg_img bg_fixed" data-background="{{getImage('assets/images/frontend/user_dashboard/' . @$content->data_values->background_image, '1920x1080')}}">
    <div class="container">
        <div class="dashboard__hero__content">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="card custom--card mb-5 text--white">
                        <div class="card-header py-3">
                            <h5 class="card-title m-0">@lang($page_title)</h5>
                        </div>
                        <div class="card-body py-5">
                            <form class="withdraw--form row mb--25" id="withdrawForm">
                                @csrf
                                <div class="form-group col-lg-10">
                                    <div class="input-group m-0">
                                        <input type="text" name="amount" class="form-control form--control" placeholder="Withdraw Amount">
                                        <div class="input-group-append"></div>
                                        <span class="input-group-text bg--base border--light text--white">{{ __($general->cur_text) }}</span>
                                      </div>
                                </div>
                                <div class="form-group col-lg-2">
                                    <button class="cmn--btn form-control form--control d-block" id="submitBtn" type="submit">@lang('Submit')</button>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer py-3">
                            <div class="row">
                                <span class="col-lg-6">@lang('Minimum Limit'): {{$gateway->minimum_withdraw}} {{$general->cur_text}}</span>

                                <span class="col-lg-6">@lang('Maximum Limit'): {{$gateway->maximum_withdraw}} {{$general->cur_text}}</span>

                            </div>
                        </div>
                    </div>
                    <div class="active--miners">
                        <h4 class="subtitle text-white pt-5 mb-4">@lang('Your Withdrawals')</h4>
                        <div class="table--responsive">
                            <table class="cmn--table table--white">
                                <thead>
                                    <tr>
                                        <th>@lang('TIME')</th>
                                        <th>@lang('TRX NUMBER')</th>
                                        <th>@lang('AMOUNT')</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse ($withdrawals as $item)
                                        <tr>
                                            <td data-label="@lang('TIME')">
                                                {{ showDateTime($item->created_at) }}
                                            </td>
                                            <td data-label="@lang('TRX NUMBER')">
                                                <span>{{$item->trx}}</span>
                                            </td>
                                            <td data-label="@lang('Amount')">
                                                <span>{{$item->amount}} {{ __($general->cur_text) }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                    <tr>
                                        <td class="text-center" colspan="100%">@lang('NO DATA AVAILABLE')</td>
                                    </tr>
                                    @endforelse

                                </tbody>
                            </table>
                            @if($withdrawals->hasPages())
                                {{ $withdrawals->links() }}
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
            $('#withdrawForm').on('submit', function(e){
                e.preventDefault();
                $('#submitBtn').attr('disabled', 'disabled');

                var data = $(this).serialize();
                $.ajax({
                    type:"POST",
                    url:"{{route('account.withdraw')}}",
                    data: data,
                    dataType: "json",
                    success:function(data)
                    {
                        if(data.error)
                        {
                            notify('error', data.error);
                            $('#submitBtn').removeAttr('disabled');
                        }
                        else
                        {
                            notify("success",data.success);
                        }
                    }
                });
            });
        })(jQuery)
    </script>
@endpush
