@php
    $content    = getContent('about.content',true);
    $elements   = getContent('about.element',false, null, true);
@endphp
@if($content)
<section class="about-section pt-120 pb-120" id="about-us">
    <div class="container">
        <div class="row gy-5">
            <div class="col-lg-6">
                <div class="about__thumb">
                    <div class="thumb">
                        <img src="{{getImage('assets/images/frontend/about/' . @$content->data_values->image, '576x480')}}" alt="@lang('about')">
                    </div>
                    <blockquote class="chairman--quote">
                        @lang(@$content->data_values->quote)
                    </blockquote>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about__content">
                    <div class="section__header">
                        <span class="section__cate">
                            @lang(@$content->data_values->title)
                        </span>
                        <h3 class="section__title">@lang(@$content->data_values->subtitle)</h3>
                        <p>
                            @lang(@$content->data_values->short_description)
                        </p>
                    </div>
                    <p class="about__para">
                        @lang(@$content->data_values->details)
                    </p>
                    <ul class="about--list">
                        @foreach ($elements as $item)
                            <li>{{ $item->data_values->about_list_item }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
