@php
    $content    = getContent('feature.content',true);
    $elements   = getContent('feature.element', false, null, true);
@endphp
@if($content)
<section class="feature-section pt-120 pb-120 bg--theme--overlay top--wave-wrapper bottom--wave-wrapper bg_img bg_fixed" data-background="{{getImage('assets/images/frontend/feature/' . @$content->data_values->background_image, '1920x1280')}}">
    <div class="banner-shape">
        <img src="{{asset('assets/templates/basic/images/wave.png')}}" alt="@lang('banner')">
    </div>
    <div class="banner-shape-top">
        <img src="{{asset('assets/templates/basic/images/wave-rev.png')}}" alt="@lang('banner')">
    </div>
    <div class="container">
        <div class="section__header section__header__center text--white">
            <span class="section__cate">
                @lang(@$content->data_values->title)
            </span>
            <h3 class="section__title">@lang(@$content->data_values->subtitle)</h3>
            <p>@lang(@$content->data_values->description)</p>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach ($elements as $item)
                <div class="col-md-6 col-lg-4">
                    <div class="feature__item">
                        <div class="feature__icon">
                            @php echo $item->data_values->icon @endphp
                        </div>
                        <div class="feature__content">
                            <h5 class="feature__title">@lang(@$item->data_values->title)</h5>
                            <p>
                                @lang(@$item->data_values->description)
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
