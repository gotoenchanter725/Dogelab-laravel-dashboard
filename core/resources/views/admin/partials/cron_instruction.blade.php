{{--   modal----}}
<div class="modal fade bd-example-modal-lg" id="cronModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('Cron Job Setting Instruction')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 my-2">
                        <p class="cron-p-style"> @lang('To automate the track balance, please set the')
                            <code> @lang('cron job') </code> @lang('on your server. Set the Cron time as minimum as possible. Once per')
                            <code>@lang('5-15')</code> @lang('minutes is ideal.')</p>
                    </div>
                    <div class="col-md-12">
                        <label>@lang('Cron Command')</label>
                        <div class="input-group ">
                            <input id="ref" type="text" class="form-control form-control-lg"
                                   value="curl -s {{route('cron')}}"  readonly="">
                            <div class="input-group-append" id="copybtn">
                                <span class="input-group-text btn--success"
                                      title="" onclick="myFunction()" > @lang('COPY')</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
            </div>
        </div>
    </div>
</div>

@push('script')
    @if(Carbon\Carbon::parse($general->last_cron)->diffInSeconds()>=900 || !$general->last_cron)
        <script>
            'use strict';
            (function($){
                $("#cronModal").modal('show');
            })(jQuery)

            function myFunction() {
                var copyText = document.getElementById("ref");
                copyText.select();
                copyText.setSelectionRange(0, 99999)
                document.execCommand("copy");
                notify('success', 'Url copied successfully ' + copyText.value);
            }
        </script>
    @endif
@endpush

