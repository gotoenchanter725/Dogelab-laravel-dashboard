@extends('admin.layouts.app')

@section('panel')

<div class="row mb-none-30">
    <div class="col-xl-4 mb-30">

        <div class="card b-radius--10 mb-30">
            <div class="card-header">
                <h5 class="title">
                    @lang('Account Details')
                </h5>
            </div>
            <div class="card-body">

                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>@lang('Unique Id')</strong>
                        <span>{{$account->unique_id}}</span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between">
                        <strong>@lang('Wallet')</strong>
                        <span>{{$account->wallet}}</span>
                    </li>


                    @if($account->ref_by)
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>@lang('Referred By')</strong>

                        <span>
                            <a href="{{ route('admin.account.single', $account->ref_by) }}">
                                {{$account->referrer->unique_id}}
                            </a>
                        </span>
                    </li>
                    @endif

                    <li class="list-group-item d-flex justify-content-between">
                        <strong>@lang('Status')</strong>
                        @if($account->status)
                        <span class="badge--success text--small font-weight-normal">
                            @lang('Active')
                        </span>
                        @else
                        <span class="badge--danger text--small font-weight-normal">
                            @lang('Deactivated')
                        </span>
                        @endif
                    </li>
                </ul>

            </div>
        </div>


        <div class="card b-radius--10 mb-30">
            <div class="card-header">
                <h5 class="title">
                    @lang('Track Details')
                </h5>
            </div>
            <div class="card-body">
                <ul class="list-group">

                    <li class="list-group-item d-flex justify-content-between">
                        <strong>@lang('Speed')</strong>
                        <span>{{$account->track->speed}} @lang('DH/S')</span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between">
                        <strong>@lang('Balance')</strong>
                        <span>{{getAmount($account->track->balance - $account->track->withdraw, 8)}} {{ __($general->cur_text) }}</span>
                    </li>


                    <li class="list-group-item d-flex justify-content-between">
                        <strong>@lang('Withdraw')</strong>
                        <span>{{ getAmount($account->track->withdraw, 8) }} {{ __($general->cur_text) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>@lang('Starts From')</strong>
                        <span>{{ showDateTime($account->track->created_at) }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card b-radius--10 mb-30">
            <div class="card-header">
                <h5 class="title">@lang('Action')</h5>
            </div>

            <div class="card-body">

                @if($account->status)
                    <button class="btn btn--danger btn-block action-btn" value="0">@lang('Deactivate')</button>
                @else
                    <button class="btn btn--success btn-block action-btn" value="1">@lang('Activate')</button>
                @endif
            </div>
        </div>
    </div>

    <div class="col-xl-8 mb-30">

        <div class="card b-radius--10  mb-4">
            <div class="card-header">
                <h5 class="title d-flex justify-content-between align-items-center">
                    @lang('Latest Deposits')</strong>
                    <a href="{{ route('admin.account.deposits', $account->id) }}" class="btn btn--info">@lang('View All')</a>
                </h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive table-responsive-xl">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>@lang('Time')</th>
                                <th>@lang('TRX Id')</th>
                                <th>@lang('Amount')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!$deposits->count())
                            <tr>
                                <td class="text-center" colspan="100%">@lang('No deposit yet')</td>
                            </tr>
                            @endif
                            @foreach ($deposits as $item)
                            <tr>
                                <td>{{ showDateTime($item->updated_at) }}</td>
                                <td>{{ $item->trx }}</td>
                                <td>{{ getAmount($item->amount) }} {{ $general->cur_text }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card b-radius--10">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="title">@lang('Latest Withdrawals')</h5>
                <a href="{{ route('admin.account.withdrawals', $account->id) }}" class="btn btn--info">@lang('View All')</a>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive table-responsive-xl">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>@lang('Time')</th>
                                <th>@lang('TRX Id')</th>
                                <th>@lang('Amount')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!$withdrawals->count())
                            <tr>
                                <td class="text-center" colspan="100%">@lang('No withdrawal yet')</td>
                            </tr>
                            @endif
                            @foreach ($withdrawals as $item)
                            <tr>
                                <td>{{$item->created_at}}</td>
                                <td>{{$item->trx}}</td>
                                <td>{{ getAmount($item->amount) }} {{ __($general->cur_text) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="actionModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Confirmation Alert')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <form action="{{ route('admin.account.action', $account->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" class="type">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('No')</button>
                    <button type="submit" class="btn btn--success">@lang('Yes')</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@push('script')
 <script>
    'use strict';
    (function($){
        $('.action-btn').on('click', function(){
            var modal = $('#actionModal');
            modal.find('.type').val(this.value);
            if(this.value == 0){
                modal.find('.modal-body').text("@lang('Are you sure to deactivate this account?')");
            }else{
                modal.find('.modal-body').text("@lang('Are you sure to active this account?')");
            }

            modal.modal('show');
        });
    })(jQuery)
 </script>
@endpush
