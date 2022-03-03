<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
@include('partials.seo')

    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'/css/fontawesome.all.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'/css/line-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'/css/owl.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'/css/bootstrap-fileinput.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'/css/main.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'/css/custom.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'/css/custom.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset($activeTemplateTrue ."css/color.php?color=$general->base_color&secondColor=$general->secondary_color") }}">
   @stack('style-lib')

    @stack('style')
</head>
<body>

    @php
        $socials = getContent('socials.element');
    @endphp

    <div class="preloader">
        <div class="spinner">
            <div class="cube1"><img src="{{ getImage(imagePath()['logoIcon']['path'] .'/favicon.png') }}" alt=""></div>
            <div class="cube2"><img src="{{ getImage(imagePath()['logoIcon']['path'] .'/favicon.png') }}" alt=""></div>
        </div>
    </div>

    <a href="javascript:void(0)" class="scrollToTop"><i class="las la-angle-up"></i></a>
    <div class="cursor"></div>
    <div class="overlay"></div>

    @include($activeTemplate.'partials.header')

@yield('content')


@include($activeTemplate.'partials.footer')
<!-- Optional JavaScript -->

<script src="{{asset($activeTemplateTrue.'/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'/js/bootstrap.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'/js/rafcounter.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'/js/owl.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'/js/main.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'/js/bootstrap-fileinput.js')}}"></script>

@stack('script-lib')

@include('admin.partials.notify')

@include('partials.plugins')

@stack('script')

@if(!session('ACCOUNT'))
@php
    $cookie = App\Models\Frontend::where('data_keys','cookie.data')->first();
@endphp

    <!-- Cookie Modal -->
    <div class="cookie-modal" id="cookieModal">
        <div class="container">
            <div class="cookie-header mb-1">
                <h5 class="text--base">@lang('Cookie Policy')</h5>
                <button class="close-btn"><i class="fas fa-times"></i></button>
            </div>
            <p class="mb-2 d-inline">
                @php echo @$cookie->data_values->description @endphp
            </p>

            <a class="btn btn-sm btn--success ms-3" href="{{ @$cookie->data_values->link }}" target="_blank">@lang('Learn More')</a>
            <button type="button" class="btn btn-sm btn--base cookie-accept">@lang('Accept')</button>
        </div>
    </div>

@endif

<script>
    'use strict';
    (function($){
        $(document).on("change", ".langSel", function() {
            window.location.href = "{{url('/')}}/change/"+$(this).val() ;
        });

        @if(!session('ACCOUNT'))

            let myModal = document.getElementById('cookieModal');

            @if(@$cookie->data_values->status && !session('cookie_accepted'))
                setTimeout(function () {
                    myModal.classList.add('show');
                }, 2000)

            @else
                myModal.classList.remove('show');
            @endif

            $('.cookie-modal .close-btn').on('click', function(){
                $('#cookieModal').removeClass('show');
            });

            $('.cookie-accept').on('click', function(){
                $.get("{{ route('cookie.accept') }}",
                    function (response) {
                        if(response.success){
                            notify('success', response.success);
                            $('#cookieModal').removeClass('show');
                        }
                    }
                );
            });
        @endif

    })(jQuery)


</script>

</body>
</html>
