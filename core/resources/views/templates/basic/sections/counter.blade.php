@php
    $content    = getContent('counter.content',true);
    $elements   = getContent('counter.element', false, null, true);
@endphp
@if($content)
<section class="counter-section bg--theme--overlay-2 bg_fixed top--wave-wrapper bottom--wave-wrapper pt-120 pb-120 bg_img" data-background="{{getImage('assets/images/frontend/counter/' . @$content->data_values->background_image, '1920x1280')}}">
    <div class="banner-shape">
        <img src="{{asset('assets/templates/basic/images/wave.png')}}" alt="@lang('banner')">
    </div>
    <div class="banner-shape-top">
        <img src="{{asset('assets/templates/basic/images/wave-rev.png')}}" alt="@lang('banner')">
    </div>
    <div class="container">
        <div class="row g-4">
            @foreach ($elements as $item)
                <div class="col-sm-6 col-lg-3">
                    <div class="counter__item">
                        <div class="counter__header">
                            @php echo $item->data_values->icon @endphp
                            <h3 class="title">
                                <span class="rafcounter" data-counter-end="{{ $item->data_values->digit }}">00</span>
                                <span>{{ $item->data_values->unit }}</span>
                            </h3>
                        </div>
                        <p>@lang(@$item->data_values->title)</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
