@php
	$captcha = getCustomCaptcha();
@endphp
@if($captcha)
    <div class="form-group row ">
        <div class="col-md-12">
            @php echo $captcha @endphp
        </div>
        <div class="col-md-6 mt-4">
            <input type="text" name="captcha" placeholder="@lang('Enter Code')" class="form-control">
        </div>
    </div>
@endif
