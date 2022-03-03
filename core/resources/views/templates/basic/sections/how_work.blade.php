@php
    $content    = getContent('how_work.content',true);
    $elements   = getContent('how_work.element', false, 4, true);
@endphp
@if($content)
<section class="how-section pt-120 pb-120" id="how_work">
    <div class="container">
        <div class="section__header section__header__center">
            <span class="section__cate">
                @lang(@$content->data_values->title)
            </span>
            <h3 class="section__title">@lang(@$content->data_values->subtitle)</h3>
            <p>@lang(@$content->data_values->description)</p>
        </div>
        <div class="row g-4">
            @foreach($elements as $item)
            <div class="col-sm-6 col-lg-3 mb-30">
                <div class="how__item">
                    <div class="how__thumb">
                        <div class="thumb">
                            {{ $loop->iteration }}
                        </div>
                    </div>
                    <h5 class="title">{{__(@$item->data_values->title)}}</h5>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
