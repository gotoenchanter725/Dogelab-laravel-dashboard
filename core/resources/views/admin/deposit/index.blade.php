@extends('admin.layouts.app')

@section('panel')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card b-radius--10">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th scope="col">@lang('Wallet')</th>
                                <th scope="col">@lang('Trx Number')</th>
                                <th scope="col">@lang('Wallet')</th>
                                @if(!request()->routeIs('admin.account.deposits'))
                                <th scope="col">@lang('Account')</th>
                                @endif
                                <th scope="col">@lang('Amount')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($deposits as $deposit)

                            <tr>
                                <td data-label="@lang('Date')"> {{ showDateTime($deposit->created_at) }}</td>
                                <td data-label="@lang('Trx Number')" class="font-weight-bold text-uppercase">{{ $deposit->trx }}</td>
                                <td data-label="@lang('Wallet')">{{ $deposit->wallet }}</td>
                                @if(!request()->routeIs('admin.account.deposits'))
                                <td data-label="@lang('Account')"><a href="{{ route('admin.account.single', $deposit->account_id) }}">{{ @$deposit->account->unique_id }}</a></td>
                                @endif

                                <td data-label="@lang('Amount')" class="font-weight-bold">{{ getAmount($deposit->amount ) }} {{ __($general->cur_text) }}</td>
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
                {{ paginateLinks($deposits) }}
            </div>
        </div>
    </div>
</div>


@endsection


@push('breadcrumb-plugins')
    @if(!request()->routeIs('admin.account.deposits'))
        <form action="{{route('admin.deposit.search')}}" method="GET" class="form-inline float-sm-right bg--white mb-2">
            <div class="input-group has_append  ">
                <input type="text" name="search" class="form-control" placeholder="@lang('Search')..." value="{{ $search ?? '' }}">
                <div class="input-group-append">
                    <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>

        <form action="{{route('admin.deposit.dateSearch')}}" method="GET" class="form-inline float-sm-right bg--white mr-0 mr-xl-2 mr-lg-0">
            <div class="input-group has_append ">
                <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en" class="datepicker-here form-control" data-position='bottom right' placeholder="@lang('Start Date - End Date')" autocomplete="off" value="{{ @$dateSearch }}">
                <input type="hidden" name="method" value="{{ @$methodAlias }}">
                <div class="input-group-append">
                    <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>

    @endif
@endpush

@if(!request()->routeIs('admin.account.deposits'))
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
@endif
