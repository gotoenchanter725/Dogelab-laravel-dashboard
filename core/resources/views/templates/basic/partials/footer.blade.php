@php
    $content    = getContent('footer.content',true);
@endphp

<footer class="bg--theme--overlay footer-section bg_fixed bg_img" data-background="{{getImage('assets/images/frontend/footer/' . @$content->data_values->image, '1920x826')}}">
    @if(Route::currentRouteName()=='home' || Route::currentRouteName()=='contact')
    <div class="banner-shape-top">
        <img src="{{asset('assets/templates/basic/images/wave-rev.png')}}" alt="@lang('banner')">
    </div>
    @endif
    <div class="container">
        <div class="footer-top pt-120 pb-3 @if(Route::currentRouteName()== 'home' || Route::currentRouteName()== 'contact') top--wave-wrapper @endif">
            <div class="footer-logo">
                <a href="javascript:void(0)">
                    <img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="@lang('logo')">
                </a>
            </div>
            <p class="footer--text">
                @lang(@$content->data_values->short_description)
            </p>
            <ul class="social__icons">
                @foreach($socials as $social)
                <li>
                    <a href="{{@$social->data_values->url}}" class="facebook">
                        @php echo @$social->data_values->icon; @endphp
                    </a>
                </li>
                @endforeach
            </ul>

            <ul class="footer-links pt-5">
                @if($policy_pages->count() > 0)
                    @foreach ($policy_pages as $item)
                        <li class="p-0"><a href="{{route('page', ['id' => $item->id, 'slug'=> slug($item->data_values->page_title) ])}}">@php echo __($item->data_values->page_title) @endphp</a></li>
                    @endforeach
                @endif
            </ul>
        </div>
        <div class="footer-bottom py-3">
            <div class="copyright text--white text-center">
                @lang(@$content->data_values->copyright_text)
            </div>
        </div>
    </div>
</footer>
