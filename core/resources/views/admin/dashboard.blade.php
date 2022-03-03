@extends('admin.layouts.app')

@section('panel')
@if(@json_decode($general->sys_version)->version > systemDetails()['version'])
<div class="row">
    <div class="col-md-12">
        <div class="card text-white bg-warning mb-3">
            <div class="card-header">
                <h3 class="card-title"> @lang('New Version Available') <button class="btn btn--dark float-right">@lang('Version') {{json_decode($general->sys_version)->version}}</button> </h3>
            </div>
            <div class="card-body">
                <h5 class="card-title text-dark">@lang('What is the Update ?')</h5>
                <p><pre  class="f-size--24">{{json_decode($general->sys_version)->details}}</pre></p>
            </div>
        </div>
    </div>
</div>
@endif
@if(@json_decode($general->sys_version)->message)
<div class="row">
    @foreach(json_decode($general->sys_version)->message as $msg)
      <div class="col-md-12">
          <div class="alert border border--primary" role="alert">
              <div class="alert__icon bg--primary"><i class="far fa-bell"></i></div>
              <p class="alert__message">@php echo $msg; @endphp</p>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
      </div>
    @endforeach
</div>
@endif

    <div class="row mb-none-30">
        <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--primary b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{ $account['total'] }}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Account')</span>
                    </div>
                    <a href="{{route('admin.account.index')}}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--success b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-user-check"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{ $account['active'] }}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Active Account')</span>
                    </div>
                    <a href="{{route('admin.account.active')}}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--danger b-radius--10 box-shadow ">
                <div class="icon">
                    <i class="la la-ban"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{ $account['banned'] }}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Banned Account')</span>
                    </div>

                    <a href="{{route('admin.account.banned')}}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--10 b-radius--10 box-shadow ">
                <div class="icon">
                    <i class="fa fa-user-friends"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{ $account['referred'] }}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Referred Account')</span>
                    </div>

                    <a href="{{route('admin.account.referred')}}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->


        <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--15 b-radius--10 box-shadow" >
                <div class="icon">
                    <i class="fa fa-wallet"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{ getAmount($payment['total_deposit_amount']) }}</span>
                        <span class="currency-sign">@lang($general->cur_text)</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Deposit Amount')</span>
                    </div>

                    <a href="{{ route('admin.deposit.index') }}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--10 b-radius--10 box-shadow" >
                <div class="icon">
                    <i class="fa fa-money-bill"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{ getAmount($paymentWithdraw['total_withdraw_amount']) }}</span>
                        <span class="currency-sign">@lang($general->cur_text)</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Withdrwal Amount')</span>
                    </div>

                    <a href="{{ route('admin.withdraw.index') }}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--3 b-radius--10 box-shadow" >
                <div class="icon">
                    <i class="la la-hammer"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{ getAmount($account['track_balance']) }}</span>
                        <span class="currency-sign">@lang($general->cur_text)</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Minnig Track Balance')</span>
                    </div>
                    <a href="{{ route('admin.mining.track') }}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--gradi-50 b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-hand-holding-usd"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{ getAmount($account['referral_bonus']) }}</span>
                        <span class="currency-sign">@lang($general->cur_text)</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Referral Bonus')</span>
                    </div>

                    <a href="{{ route('admin.referral.log') }}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
    </div><!-- row end-->

    <div class="row mt-50 mb-none-30">
        <div class="col-xl-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Deposit & Withdraw  Report of Last 12 Months')</h5>
                    <div id="apex-bar-chart"> </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Last 30 days Withdraw History')</h5>
                    <div id="withdraw-line"></div>
                </div>
            </div>
        </div>
    </div><!-- row end -->

    <div class="row mb-none-30 mt-5">
        <div class="col-xl-6 mb-30">
            <div class="card ">
                <div class="card-header">
                    <h6 class="card-title mb-0">@lang('Latest Accounts')</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Unique ID')</th>
                                <th scope="col">@lang('Wallet')</th>
                                <th scope="col">@lang('Referred By')</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($latest_accounts as $item)
                                    <tr>
                                        <td data-label="@lang('Unique ID')">
                                            <a href="{{ route('admin.account.single', $item->id) }}">{{ $item->unique_id }}</a>
                                        </td>
                                        <td data-label="@lang('Wallet')">{{ $item->wallet }}</td>

                                        <td data-label="@lang('Referred By')">
                                            @if($item->ref_by)
                                            <a href="{{ route('admin.account.single', $item->ref_by) }}">
                                                {{ $item->referrer->unique_id }}
                                            </a>
                                            @else
                                                @lang('N/A')
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
            </div><!-- card end -->
        </div>

        <div class="col-xl-6 mb-30">
            <div class="card ">
                <div class="card-header">
                    <h6 class="card-title mb-0">@lang('Ltest Deposits')</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Unique ID')</th>
                                <th scope="col">@lang('Wallet')</th>
                                <th scope="col">@lang('Amount')</th>

                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($latest_deposits as $item)
                                    <tr>
                                        <td data-label="@lang('Unique ID')">
                                            <a href="{{ route('admin.account.single', $item->account->id) }}">{{ @$item->account->unique_id }}</a>
                                        </td>
                                        <td data-label="@lang('Unique ID')">{{ $item->wallet }}</td>
                                        <td data-label="@lang('Unique ID')">{{ getAmount($item->amount) }} @lang($general->cur_text)</td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
            </div><!-- card end -->
        </div>
    </div>

    @include('admin.partials.cron_instruction')
@endsection


@push('breadcrumb-plugins')

    @if($general->last_cron)
    <a href="javascript:void(0)" class="btn @if(Carbon\Carbon::parse($general->last_cron)->diffInSeconds()<600)
        btn--success @elseif(Carbon\Carbon::parse($general->last_cron)->diffInSeconds()<1200) btn--warning @else
        btn--danger @endif "><i class="fa fa-fw fa-clock"></i>@lang('Last Cron Run') : {{Carbon\Carbon::parse($general->last_cron)->difFforHumans()}}</a>

    @endif

@endpush

@push('script')

    <script src="{{asset('assets/admin/js/vendor/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/vendor/chart.js.2.8.0.js')}}"></script>
    <script>
          "use strict";
           // apex-bar-chart js
        var options = {
            series: [{
                name: 'Total Deposit',
                data: [
                  @foreach($months as $month)
                    {{ getAmount(@$depositsMonth->where('months',$month)->first()->depositAmount) }},
                  @endforeach
                ]
            }, {
                name: 'Total Withdraw',
                data: [
                  @foreach($months as $month)
                    {{ getAmount(@$withdrawalMonth->where('months',$month)->first()->withdrawAmount) }},
                  @endforeach
                ]
            }],
            chart: {
                type: 'bar',
                height: 400,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '50%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: @json($months),
            },
            yaxis: {
                title: {
                    text: "{{__($general->cur_sym)}}",
                    style: {
                        color: '#7c97bb'
                    }
                }
            },
            grid: {
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                yaxis: {
                    lines: {
                        show: false
                    }
                },
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "{{__($general->cur_sym)}}" + val + " "
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#apex-bar-chart"), options);
        chart.render();


        // apex-line chart
        var options = {
            chart: {
                height: 400,
                type: "area",
                toolbar: {
                    show: false
                },
                dropShadow: {
                    enabled: true,
                    enabledSeries: [0],
                    top: -2,
                    left: 0,
                    blur: 10,
                    opacity: 0.08
                },
                animations: {
                    enabled: true,
                    easing: 'linear',
                    dynamicAnimation: {
                        speed: 1000
                    }
                },
            },
            dataLabels: {
                enabled: false
            },
            series: [
                {
                    name: "Series 1",
                    data: @json($withdrawals['per_day_amount']->flatten())
                }
            ],
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.9,
                    stops: [0, 90, 100]
                }
            },
            xaxis: {
                categories: @json($withdrawals['per_day']->flatten())
            },
            grid: {
                padding: {
                    left: 5,
                    right: 5
                },
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                yaxis: {
                    lines: {
                        show: false
                    }
                },
            },
        };

        var chart = new ApexCharts(document.querySelector("#withdraw-line"), options);

        chart.render();


    </script>
@endpush
