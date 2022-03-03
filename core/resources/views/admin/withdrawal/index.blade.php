@extends('admin.layouts.app')

@section('panel')
    <div class="row justify-content-center">

        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">

                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('Date')</th>
                                <th>@lang('Trx Number')</th>
                                @if(!request()->routeIs('admin.account.withdrawals'))
                                <th>@lang('Account')</th>
                                @endif
                                <th>@lang('Amount')</th>

                            </tr>
                            </thead>
                            <tbody>
                            @forelse($withdrawals as $withdraw)

                                <tr>
                                    <td data-label="@lang('Date')">{{ showDateTime($withdraw->created_at) }}</td>
                                    <td data-label="@lang('Trx Number')" class="font-weight-bold">{{ strtoupper($withdraw->trx) }}</td>
                                    @if(!request()->routeIs('admin.account.withdrawals'))
                                        <td data-label="@lang('Account')">
                                            <a href="{{ route('admin.account.single', $withdraw->account_id) }}">{{ @$withdraw->account->unique_id }}</a>
                                        </td>
                                    @endif
                                    <td data-label="@lang('Amount')" class="budget font-weight-bold">{{ getAmount($withdraw->amount) }} {{__($general->cur_text)}}</td>

                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer py-4">
                    {{ paginateLinks($withdrawals) }}
                </div>
            </div>
        </div>
    </div>

@endsection

@push('breadcrumb-plugins')

    @if(!request()->routeIs('admin.account.withdrawals'))

        <form action="{{ route('admin.withdraw.search') }}" method="GET" class="form-inline float-sm-right bg--white mb-lg-2 mb-0">
            <div class="input-group has_append">
                <input type="text" name="search" class="form-control" placeholder="@lang('Search')..." value="{{ $search ?? '' }}">
                <div class="input-group-append">
                    <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>

        <form action="{{route('admin.withdraw.dateSearch')}}" method="GET" class="form-inline float-sm-right bg--white mr-0 mr-xl-2 mr-lg-0">
            <div class="input-group has_append">
                <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en" class="datepicker-here form-control" data-position='bottom right' placeholder="@lang('Start Date - End Date')" autocomplete="off" value="{{ @$dateSearch }}">
                <input type="hidden" name="method" value="{{ @$method->id }}">
                <div class="input-group-append">
                    <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
    @endif
@endpush

@push('script')
  <script src="{{ asset('assets/admin/js/vendor/datepicker.min.js') }}"></script>
  <script src="{{ asset('assets/admin/js/vendor/datepicker.en.js') }}"></script>
  <script>
    'use strict';
    (function($){
        if(!$('.datepicker-here').val()){
            $('.datepicker-here').datepicker();
        }
    })(jQuery)
    </script>
@endpush
