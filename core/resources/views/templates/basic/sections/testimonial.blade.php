@php
    $content       = getContent('testimonial.content',true);
    $testimonials  = getContent('testimonial.element');
@endphp

<div class="client-section bg--theme--overlay bg_fixed pt-120 pb-120 bg_img top--wave-wrapper bottom--wave-wrapper" data-background="{{ getImage('assets/images/frontend/testimonial/'.@$content->data_values->background_image, '1920x820') }}">
    <div class="banner-shape">
        <img src="{{asset('assets/templates/basic/images/wave.png')}}" alt="@lang('banner')">
    </div>
    <div class="banner-shape-top">
        <img src="{{asset('assets/templates/basic/images/wave-rev.png')}}" alt="@lang('banner')">
    </div>
    <div class="container">
        <div class="client-slider">
            <div class="sync1 owl-theme owl-carousel">
                @foreach ($testimonials as $item)
                    <div class="client__content">
                        <p>
                            @lang($item->data_values->quote)
                        </p>
                        <div class="ratings">
                            @php echo __(displayRating(intval($item->data_values->rating))) @endphp
                        </div>
                        <h5 class="title text--white">@lang($item->data_values->author)</h5>
                        <span class="designation">@lang($item->data_values->designation)</span>
                    </div>
                @endforeach
            </div>
            <div class="sync2 owl-theme owl-carousel">
                @foreach ($testimonials as $item)
                <div class="client__thumb">
                    <img src="{{ getImage('assets/images/frontend/testimonial/'.@$item->data_values->image, '120x120') }}" alt="@lang('client')">
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
