@extends($activeTemplate.'layouts.master')
@section('content')
@php
	$bannerContent = getContent('banner.content', true);
@endphp

    <section class="banner-section bg--theme--overlay">
        <div class="shapes-banner bg_img" data-background="{{getImage('assets/images/frontend/banner/' . @$bannerContent->data_values->background_image, '1920x875')}}"></div>
        <div class="particles-js" id="particles-js"></div>

        <div class="banner-shape">
            <img src="{{asset('assets/templates/basic/images/wave.png')}}" alt="@lang('banner')">
        </div>

        <div class="doge1 d-none d-lg-block">
            <img src="{{getImage('assets/images/frontend/banner/' . @$bannerContent->data_values->image, '40x40')}}" alt="@lang('banner')">
        </div>
        <div class="doge2 d-none d-lg-block">
            <img src="{{getImage('assets/images/frontend/banner/' . @$bannerContent->data_values->image, '40x40')}}" alt="@lang('banner')">
        </div>
        <div class="container">
            <div class="banner__content text--white">
                <h4 class="banner__category text--white">{{ __($bannerContent->data_values->title) }}</h4>
                <h1 class="banner__title text--white">{{ __($bannerContent->data_values->subtitle) }}</h1>
                <p class="banner__text">{{ __($bannerContent->data_values->description) }}</p>
            </div>
            <div class="banner__bottom__content text--white">
                <div class="row justify-content-center">
                    <div class="col-lg-7 col-md-10">
                        <form class="account__form" id="loginForm" action="{{ route('account.login') }}">
                            @csrf
                            <div class="form-group position-relative">
                                <input type="text" name="wallet"  class="form-control" placeholder="@lang('Your Dogecoin Wallet Address')">
                                <button type="submit" class="cmn--btn">@lang('Enter')</button>
                            </div>
                        </form>
                        <h4 class="dogecoin__amount text--white"><span id="mined">0</span> {{ $general->cur_text }}</h4>
                        <p class="banner__bottom__text">
                            @lang('MINER SPEED'): <span>{{ $general->free_dhs }}</span> @lang('DH/S') | @lang('DAILY PROFIT') <span id="dailyProfit"> {{ $general->free_dhs * $general->daily_earning }} </span> @lang($general->cur_text)
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($sections->secs != null)
        @foreach(json_decode($sections->secs) as $sec)
            @include($activeTemplate.'sections.'.$sec)
        @endforeach
    @endif
@endsection

@push('script')
    <script src="{{asset($activeTemplateTrue.'/js/particles.min.js')}}"></script>
    <script>
        'use strict';
        (function($){
            let dailyProfit             = $('#dailyProfit').text();
            let dailyProfitInSeconds    = dailyProfit/864000;
            let minedAmount             = 0;
            setInterval(function(){
                minedAmount += dailyProfitInSeconds;
            $('#mined').text(minedAmount.toFixed(8));
            }, 100);


            $('#loginForm').on('submit', function(e){
                e.preventDefault();
                var data = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ route('account.login') }}",
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        if(response.error) {
                            notify('error', response.error)
                        }else{
                            notify('success', response.success)

                            setTimeout(function(){
                                window.location.href = "{{route('account.home')}}";
                            }, 1000)
                        }
                    }
                });
            })

            // Particle
            particlesJS('particles-js',

                {
                    "particles": {
                    "number": {
                        "value": 100,
                        "density": {
                        "enable": true,
                        "value_area": 800
                        }
                    },
                    "color": {
                        "value": "#000000"
                    },
                    "shape": {
                        "type": "image",
                        "stroke": {
                        "width": 0,
                        "color": "#000000"
                        },
                        "polygon": {
                        "nb_sides": 5
                        },
                        "image": {
                        "src": "{{ getImage(imagePath()['logoIcon']['path'] .'/favicon.png') }}",

                        "width": 300,
                        "height": 300
                        }
                    },
                    "opacity": {
                        "value": 0.9,
                        "random": false,
                        "anim": {
                        "enable": false,
                        "speed": 1,
                        "opacity_min": 0.1,
                        "sync": false
                        }
                    },
                    "size": {
                        "value": 5,
                        "random": true,
                        "anim": {
                        "enable": false,
                        "speed": 40,
                        "size_min": 0.1,
                        "sync": false
                        }
                    },
                    "line_linked": {
                        "enable": true,
                        "distance": 150,
                        "color": "#ffffff",
                        "opacity": 0.2,
                        "width": 1
                    },
                    "move": {
                        "enable": true,
                        "speed": 6,
                        "direction": "none",
                        "random": false,
                        "straight": false,
                        "out_mode": "out",
                        "attract": {
                        "enable": false,
                        "rotateX": 600,
                        "rotateY": 1200
                        }
                    }
                    },
                    "interactivity": {
                    "detect_on": "canvas",
                    "events": {
                        "onhover": {
                        "enable": true,
                        "mode": "repulse"
                        },
                        "onclick": {
                        "enable": true,
                        "mode": "push"
                        },
                        "resize": true
                    },
                    "modes": {
                        "grab": {
                        "distance": 400,
                        "line_linked": {
                            "opacity": 1
                        }
                        },
                        "bubble": {
                        "distance": 400,
                        "size": 80,
                        "duration": 2,
                        "opacity": 8,
                        "speed": 3
                        },
                        "repulse": {
                        "distance": 200
                        },
                        "push": {
                        "particles_nb": 4
                        },
                        "remove": {
                        "particles_nb": 2
                        }
                    }
                    },
                    "retina_detect": true,
                    "config_demo": {
                    "hide_card": false,
                    "background_color": "#b61924",
                    "background_image": "",
                    "background_position": "50% 50%",
                    "background_repeat": "no-repeat",
                    "background_size": "cover"
                    }
                }

);


        })(jQuery)
    </script>
@endpush
