@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Slug')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($pdata as $k => $data)
                                <tr>
                                    <td data-label="@lang('Name')">{{ __($data->name) }}</td>
                                    <td data-label="@lang('Slug')">{{ __($data->slug) }}</td>
                                    <td data-label="@lang('Action')">
                                        <a href="{{ route('admin.frontend.manage.section', $data->id) }}" class="icon-btn btn--primary ml-1" data-toggle="tooltip" data-original-title="@lang('Edit')"><i class="la la-pen"></i></a>
                                        @if($data->is_default == 0)
                                            <button class="icon-btn btn--danger ml-1 removeBtn" data-id="{{ $data->id }}" data-toggle="tooltip" data-original-title="@lang('Delete')">
                                                <i class="las la-trash"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
            </div><!-- card end -->
        </div>
    </div>


@endsection



@push('script')

    <script>
        (function ($) {
            "use strict";

            $('.removeBtn').on('click', function () {
                var modal = $('#removeModal');
                modal.find('input[name=id]').val($(this).data('id'))
                modal.modal('show');
            });

            $('.addBtn').on('click', function () {
                var modal = $('#addModal');
                modal.find('input[name=id]').val($(this).data('id'))
                modal.modal('show');
            });

        })(jQuery);

    </script>

@endpush
