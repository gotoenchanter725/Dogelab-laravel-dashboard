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
                            <h5 class="card-title m-0">@lang('Your Referral Link')</h5>
                        </div>

                        <div class="card-body p-lg-5 p-sm-0">
                            <div class="form-group m-0">
                                <div class="input-group m-0">
                                    <input type="url" id="ref" value="{{ route('home').'?ref='.$account->unique_id }}" class="form-control form--control bg-transparent" readonly>

                                    <button  type="button"  data-copytarget="#ref" class="input-group-text bg--base border--light text--white copybtn"><i class="fa fa-copy"></i> &nbsp; @lang('Copy')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="active--miners">
                        <h4 class="subtitle text-white pt-5 mb-4">@lang('Your Refferral Bonus Log')</h4>
                        <div class="table--responsive">
                            <table class="cmn--table table--white">
                                <thead>
                                    <tr>
                                        <th>
                                            @lang('Time')
                                        </th>
                                        <th>
                                            @lang('Account Id')
                                        </th>
                                        <th>
                                            @lang('Bonus')
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($ref_logs as $item)
                                        <tr>

                                            <td data-label="@lang('Time')">
                                                {{ showDateTime($item->created_at) }}
                                            </td>

                                            <td data-label="@lang('Account Id')">
                                                <span>{{@$item->referee->unique_id}}</span>
                                            </td>

                                            <td data-label="@lang('Bonus')">
                                                {{ $item->bonus_value }} {{ $general->cur_text }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="100%">@lang('NO DATA AVAILABLE')</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                            @if($ref_logs->hasPages())
                                {{ $ref_logs->links() }}
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
        document.querySelectorAll('.copybtn').forEach((element)=>{
            element.addEventListener('click', copy, true);
        })

        function copy(e) {
            var
                t = e.target,
                c = t.dataset.copytarget,
                inp = (c ? document.querySelector(c) : null);
            if (inp && inp.select) {
                inp.select();
                try {
                    document.execCommand('copy');
                    inp.blur();
                    t.classList.add('copied');
                    setTimeout(function() { t.classList.remove('copied'); }, 1500);
                }catch (err) {
                    alert(`@lang('Please press Ctrl/Cmd+C to copy')`);
                }
            }
        }
    </script>
@endpush
