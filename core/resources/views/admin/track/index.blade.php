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
                                <th>@lang('Starts From')</th>
                                <th>@lang('Account')</th>
                                <th>@lang('Speed')</th>
                                <th>@lang('Withdraw')</th>
                                <th>@lang('Current Balance')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($tracks as $track)

                        @php
                            $diff_in_seconds= Carbon\Carbon::now()->diffInSeconds($track->updated_at);
                            $daily_earning  = $track->speed * $general->daily_earning;
                            $per_sec_earning= $daily_earning / 86400;
                            $total          = round($diff_in_seconds * $per_sec_earning, 8);
                            $balance        = $total - $track->withdraw;
                        @endphp
                            <tr>
                                <td data-label="@lang('Starts From')">{{$track->created_at}}</td>
                                <td data-label="@lang('Account')">
                                    <a href="{{route('admin.account.single', $track->account_id)}}">
                                        {{@$track->account->wallet}}
                                    </a>
                                </td>
                                <td data-label="@lang('Speed')">{{$track->speed}} @lang('DH/S')</td>
                                <td data-label="@lang('Withdraw')">{{getAmount($track->withdraw,8)}} @lang($general->cur_text)</td>
                                <td data-label="@lang('Current Balance')">{{getAmount($track->balance - $track->withdraw,8)}} @lang($general->cur_text)</td>
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
                {{ paginateLinks($tracks) }}
            </div>
        </div>
    </div>
</div>
@endsection
