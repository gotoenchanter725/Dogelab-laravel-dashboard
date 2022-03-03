@extends($activeTemplate.'layouts.master')

@section('content')
@php
	$breadcrumb = getContent('breadcrumb.content', true);
    $content    = getContent('blog.content', true);
@endphp

<div class="hero-section bg--theme--overlay position-relative bg_img" data-background="{{getImage('assets/images/frontend/breadcrumb/' . @$breadcrumb->data_values->image, '1920x400')}}">
    <div class="container">
        <h2 class="hero-title text--white">@lang($page_title)</h2>
    </div>
</div>

@if($content)
    <!-- blog-section start -->
    <section class="blog-section pt-120 pb-120 bg--section">
        <div class="container">
            <div class="row justify-content-center g-4">
                @foreach($blogs as $blog)
                    <div class="col-lg-4 col-md-6 col-sm-12 mrb-30">
                        <div class="post__item">
                            <div class="post__thumb">
                                <img src="{{ getImage('assets/images/frontend/blog/thumb_'.@$blog->data_values->blog_image,'318x212') }}" alt="@lang('Blog')">
                            </div>

                            <div class="post__content">
                                <h6 class="post__title">
                                    <a href="{{ route('blog.details',[$blog->id,str_slug($blog->data_values->title)]) }}">{{ $blog->data_values->title }}</a>
                                </h6>

                                <div class="meta__date">
                                    <div class="meta__item">
                                        <i class="las la-calendar"></i>{{ showDateTime($blog->created_at, 'd, M') }}
                                    </div>

                                    <div class="meta__item">
                                        <i class="las la-user"></i>
                                       @lang(' Admin')
                                    </div>
                                </div>

                                <a href="{{ route('blog.details',[$blog->id,str_slug($blog->data_values->title)]) }}" class="post__read">@lang('Read More') <i class="las la-long-arrow-alt-right"></i></a>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $blogs->links() }}
        </div>
    </section>
    <!-- blog-section end -->

    @endif

    @if($sections->secs != null)
        @foreach(json_decode($sections->secs) as $sec)
            @include($activeTemplate.'sections.'.$sec)
        @endforeach
    @endif
