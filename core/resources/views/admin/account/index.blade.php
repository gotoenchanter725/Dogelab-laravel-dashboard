@extends('admin.layouts.app')

@section('panel')

<!-- Page Content -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive--md  table-responsive">
            <table class="table table--light style--two">
                <thead>
                    <tr>
                        <th>@lang('Unique ID')</th>
                        <th>@lang('Wallet')</th>
                        <th>@lang('Track Speed')</th>
                        <th>@lang('Referred By')</th>
                        @if(request()->routeIs('admin.account.index') || request()->routeIs('admin.account.referred') )
                        <th>@lang('Status')</th>
                        @endif
                        <th>@lang('View')</th>
                    </tr>
                </thead>
                <tbody class="list">
                        @if(count($accounts)==0)
                        <tr>
                            <td class="text-center" colspan="3">{{ $empty_message }}</td>
                        </tr>
                        @endif
                    @foreach ($accounts as $item)
                    <tr>
                        <td data-label="@lang('Unique ID')">{{ $item->unique_id }}</td>
                        <td data-label="@lang('Wallet')">{{ $item->wallet }}</td>
                        <td data-label="@lang('Track Speed')">{{$item->track->speed}} @lang('DH/S')</td>

                        <td data-label="@lang('Referred By')">
                            @if($item->ref_by)
                            <a href="{{ route('admin.account.single', $item->ref_by) }}">
                                {{ $item->referrer->unique_id }}
                            </a>
                            @else
                                @lang('N/A')
                            @endif
                        </td>


                        @if(request()->routeIs('admin.account.index') || request()->routeIs('admin.account.referred') )
                        <td data-label="@lang('Status')">
                            @if($item->status)
                            <span class="badge--success text--small font-weight-normal">
                                @lang('Active')
                            </span>
                            @else
                            <span class="badge--danger text--small font-weight-normal">
                                @lang('Deactivated')
                            </span>
                            @endif
                        </td>
                        @endif
                        <td><a href="{{route('admin.account.single', $item->id)}}" class="icon-btn btn--primary"><i class="las la-desktop    "></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @if($accounts->hasPages())
    <div class="card-footer">
        <nav aria-label="...">
            {{$accounts->links()}}
        </nav>
    </div>
    @endif
</div>


@endsection


