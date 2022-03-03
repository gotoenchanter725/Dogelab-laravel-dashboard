@extends('admin.layouts.app')

@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4 form-group">
                                <label class="form-control-label font-weight-bold"> @lang('Site Title') </label>
                                <input class="form-control form-control-lg" type="text" name="sitename" value="{{$general->sitename}}">
                            </div>
                            <div class="form-group col-lg-4">
                                <label class="form-control-label font-weight-bold">@lang('Currency')</label>
                                <input class="form-control form-control-lg" type="text" value="{{$general->cur_text}}" readonly>
                            </div>

                            <div class="col-lg-4 form-group">
                                <label class="form-control-label font-weight-bold">@lang('Currency Symbol') </label>
                                <input class="form-control form-control-lg" type="text" value="{{$general->cur_sym}}" readonly>
                            </div>

                            <div class="col-lg-4 form-group">
                                <label>@lang('DH/S Price')</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">@lang('1 DH/S') =</span>
                                    </div>
                                    <input type="text" class="form-control form-control-lg numeric-validation" value="{{ $general->dhs_price }}" name="dhs_price" required >

                                    <div class="input-group-append">
                                        <span class="input-group-text">@lang($general->cur_text)</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 form-group">
                                <label>@lang('Free DH/S')</label>
                                <div class="input-group">

                                    <input type="text" class="form-control form-control-lg integer-validation" value="{{ $general->free_dhs }}" name="free_dhs" required >

                                    <div class="input-group-append">
                                        <span class="input-group-text">@lang($general->cur_text)</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 form-group">
                                <label>@lang('Daily Earning Per DH/S')</label>
                                <div class="input-group">

                                    <input type="text" class="form-control form-control-lg numeric-validation" value="{{ $general->daily_earning }}" name="daily_earning" required>

                                    <div class="input-group-append">
                                        <span class="input-group-text">@lang($general->cur_text)</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 form-group">
                                <label>@lang('Referral Bonus')</label>
                                <div class="input-group">
                                    <input type="text" name="referral_bonus" class="form-control form-control-lg numeric-validation" value="{{ $general->referral_bonus }}" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">@lang('%')</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-lg-4">
                                <label class="form-control-label font-weight-bold"> @lang('Site Base Color')</label>
                                <div class="input-group">
                                <span class="input-group-addon ">
                                    <input type='text' class="form-control form-control-lg colorPicker" value="{{$general->base_color}}"/>
                                </span>
                                    <input type="text" class="form-control form-control-lg colorCode" name="base_color" value="{{ $general->base_color }}"/>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-control-label font-weight-bold"> @lang('Site Secondary Color')</label>
                                <div class="input-group">
                                <span class="input-group-addon">
                                    <input type='text' class="form-control form-control-lg colorPicker" value="{{$general->secondary_color}}"/>
                                </span>
                                    <input type="text" class="form-control form-control-lg colorCode" name="secondary_color" value="{{ $general->secondary_color }}"/>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-control-label font-weight-bold">@lang('Referral System')</label>
                                <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disabled')" name="referral_system" @if($general->referral_system) checked @endif>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="form-control-label font-weight-bold">@lang('Force SSL')</label>
                                <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disabled')" name="force_ssl" @if($general->force_ssl) checked @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Update')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-lib')
    <script src="{{ asset('assets/admin/js/spectrum.js') }}"></script>
@endpush

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/spectrum.css') }}">
@endpush


@push('style')
    <style>
        .sp-replacer {
            padding: 0;
            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: 5px 0 0 5px;
            border-right: none;
        }

        .sp-preview {
            width: 100px;
            height: 46px;
            border: 0;
        }

        .sp-preview-inner {
            width: 110px;
        }

        .sp-dd {
            display: none;
        }
    </style>
@endpush

@push('script')
    <script>
        $(function () {
            "use strict";
            $('.colorPicker').spectrum({
                color: $(this).data('color'),
                change: function (color) {
                    $(this).parent().siblings('.colorCode').val(color.toHexString().replace(/^#?/, ''));
                }
            });

            $('.colorCode').on('input', function () {
                var clr = $(this).val();
                $(this).parents('.input-group').find('.colorPicker').spectrum({
                    color: clr,
                });
            });
        });
    </script>
@endpush

