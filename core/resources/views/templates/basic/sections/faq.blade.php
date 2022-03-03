@php
    $content    = getContent('faq.content', true);
    $faqs       = getContent('faq.element');
    $faqs       = $faqs->chunk(ceil($faqs->count()/2));
@endphp

@if($content)
<section class="faqs-section pt-120 pb-120" id="faq">
    <div class="container">
        <div class="section__header section__header__center">
            <span class="section__cate">
                @lang(@$content->data_values->title)
            </span>
            <h3 class="section__title">@lang(@$content->data_values->subtitle)</h3>
            <p>@lang(@$content->data_values->description)</p>
        </div>
        <div class="row justify-content-center gy-3">
            <div class="col-lg-6">
                <div class="faq__wrapper">
                    @foreach($faqs[0] as $key => $faql)
                        <div class="faq__item  {{ $loop->first? 'open active' : ''  }}">
                            <div class="faq__title">
                                <h5 class="title">@lang(@$faql->data_values->question)</h5>
                                <span class="right-icon"></span>
                            </div>
                            <div class="faq__content">
                                <p>
                                    @lang(@$faql->data_values->answer)
                                </p>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6">
                <div class="faq__wrapper">
                    @foreach($faqs[0] as $key => $faqr)
                        <div class="faq__item  {{ $loop->first? 'open active' : ''  }}">
                            <div class="faq__title">
                                <h5 class="title">@lang(@$faqr->data_values->question)</h5>
                                <span class="right-icon"></span>
                            </div>
                            <div class="faq__content">
                                <p>
                                    @lang(@$faqr->data_values->answer)
                                </p>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif
