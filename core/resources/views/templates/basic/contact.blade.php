@extends($activeTemplate.'layouts.master')

@section('content')
    @php
        $content    = getContent('contact.content', true);
    @endphp
@if($content)

    <section class="contact-hero-section bg--theme--overlay-2 bg_img bg_fixed" data-background="{{getImage('assets/images/frontend/contact/' . @$content->data_values->header_background, '1920x826')}}">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="contact__item">
                        <div class="contact__icon">
                            <i class="las la-map-marker"></i>
                        </div>
                        <div class="contact__content">
                            <h6 class="contact__title">@lang('Address')</h6>
                            <ul>
                                <li>@lang($content->data_values->address)</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="contact__item">
                        <div class="contact__icon">
                            <i class="las la-envelope-open-text"></i>
                        </div>
                        <div class="contact__content">
                            <h6 class="contact__title">@lang('Email Address')</h6>
                            <ul>
                                <li>
                                    <a href="Mailto:{{ $content->data_values->email_one }}">
                                        {{ $content->data_values->email_one }}
                                    </a>
                                </li>
                                <li>
                                    <a href="Mailto:{{ $content->data_values->email_two }}">{{ $content->data_values->email_two }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="contact__item">
                        <div class="contact__icon">
                            <i class="las la-mobile-alt"></i>
                        </div>
                        <div class="contact__content">
                            <h6 class="contact__title">@lang('Phone')</h6>
                            <ul>
                                <li>
                                    <a href="Tel:{{ $content->data_values->phone_one }}">{{ $content->data_values->phone_one }}</a>
                                </li>
                                <li>
                                    <a href="Tel:{{ $content->data_values->phone_two }}">{{ $content->data_values->phone_two }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endif
    <!-- Contact Section -->
    <section class="contact-section pt-120 pb-120">
        <div class="container">
            <h3 class="title text-center mb-4">@lang($content->data_values->form_title)</h3>
            <div class="contact-form-wrapper bg--theme--overlay overflow-hidden bg_img bg_fixed" data-background="{{getImage('assets/images/frontend/contact/' . @$content->data_values->image, '900x370')}}">
                <form class="contact-form row" method="POST" action="">
                    @csrf
                    <div class="form-group col-sm-6">
                        <label class="cmn--label" for="name">@lang('Name')</label>
                        <input type="text" name="name" class="form-control form--control" id="name" placeholder="@lang('Enter Your Name')" required>
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="cmn--label" for="email">@lang('Email')</label>
                        <input type="text" name="email" class="form-control form--control" id="email" placeholder="@lang('Enter Your Email')" required>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="cmn--label" for="subject">@lang('Subject')</label>
                        <input type="text" class="form-control form--control" name="subject" id="subject" placeholder="@lang('Enter Your Subject')" required>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="cmn--label" for="message">@lang('Message')</label>
                        <textarea name="message" id="message" class="form-control form--control" placeholder="@lang('Enter Your Message')" required></textarea>
                    </div>
                    <div class="form-group col-sm-12 text-end mb-0">
                        <button type="submit" class="cmn--btn form--control">@lang('Send Message')</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Contact Section -->

    @if($sections->secs != null)
    @foreach(json_decode($sections->secs) as $sec)
        @include($activeTemplate.'sections.'.$sec)
    @endforeach
@endif

@endsection
