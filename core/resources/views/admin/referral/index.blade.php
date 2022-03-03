@extends('admin.layouts.app')

@section('panel')

<!-- Page Content -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive--md  table-responsive">
            <table class="table table--light style--two">
                <thead>
                    <tr>
                        <th>@lang('Deposited By')</th>
                        <th>@lang('Bonus Received By')</th>
                        <th>@lang('Deposit Amount')</th>
                        <th>@lang('Bonus Amount')</th>
                    </tr>
                </thead>
                <tbody class="list">
                    @forelse ($logs as $log)
                    <tr>
                        <td data-label="@lang('Deposited By')">
                            <a href="{{route('admin.account.single', $log->referee->id)}}" class="text--base">{{ @$log->referee->unique_id }}</a>
                        </td>

                        <td data-label="@lang('Bonus Received By')">
                            <a href="{{route('admin.account.single', @$log->account->id)}}" class="text--cyan">{{ @$log->account->unique_id }}</a>
                        </td>
                        <td data-label="@lang('Deposit Amount')">{{ @$log->deposit_amount }}</td>
                        <td data-label="@lang('Bonus Amount')"><strong>{{ $log->bonus_value }}</strong></td>
                    </tr>

                    @empty
                        <tr>
                            <td colspan="100%" class="text-center">@lang($empty_message)</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($logs->hasPages())
    <div class="card-footer">
        <nav aria-label="...">
            {{$accounts->links()}}
        </nav>
    </div>
    @endif
</div>


@endsection


