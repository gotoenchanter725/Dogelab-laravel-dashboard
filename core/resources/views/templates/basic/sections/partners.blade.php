@php
    $content       = getContent('partners.content',true);
    $partners  = getContent('partners.element');
@endphp

@if($content)
<div class="partners-section pt-120 pb-120">
    <div class="container">
        <div class="section__header section__header__center">
            <span class="section__cate">
                @lang(@$content->data_values->title)
            </span>
            <h3 class="section__title">@lang(@$content->data_values->subtitle)</h3>
            <p>@lang(@$content->data_values->description)</p>
        </div>
        <div class="partner-slider owl-theme owl-carousel">
            @foreach ($partners as $item)
                <a class="partner-thumb" href="javascript:void(0)">
                    <img src="{{ getImage('assets/images/frontend/partners/'.@$item->data_values->image, '120x120') }}" alt="@lang('partner')">
                    <img src="{{ getImage('assets/images/frontend/partners/'.@$item->data_values->image, '120x120') }}" alt="@lang('partner')">
                </a>
            @endforeach
        </div>
    </div>
</div>
@endif
