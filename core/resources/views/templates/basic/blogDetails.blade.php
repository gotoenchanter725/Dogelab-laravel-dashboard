@extends($activeTemplate.'layouts.master')
@section('content')

@php
	$breadcrumb = getContent('breadcrumb.content', true);
@endphp

<div class="hero-section bg--theme--overlay position-relative bg_img" data-background="{{getImage('assets/images/frontend/breadcrumb/' . @$breadcrumb->data_values->image, '1920x400')}}">
    <div class="container">
        <h2 class="hero-title text--white">@lang($page_title)</h2>
    </div>
</div>

<!-- blog-section start -->
<section class="blog-section pt-120 pb-120 bg--section">
    <div class="container">
        <div class="row gy-5 justify-content-center">
            <div class="col-lg-8">
                <div class="post__details pb-50">
                    <div class="post__header">
                        <h3 class="post__title">
                            {{ $blog->data_values->title }}
                        </h3>
                    </div>
                    <div class="post__thumb">
                        <img src="{{ getImage('assets/images/frontend/blog/'.@$blog->data_values->blog_image,'708x472') }}" alt="Blog">
                    </div>
                    <p>
                        @php echo $blog->data_values->description @endphp
                    </p>
                </div>
            </div>
            <div class="col-lg-4 mrb-30">
                <aside class="blog-sidebar bg--body">
                    <div class="widget widget__posts">
                        <h5 class="widget__title">@lang('Latest Blogs')</h5>
                        <ul>
                            @foreach($latestBlogs as $latestBlog)
                            <li>
                                <a href="{{ route('blog.details',[$latestBlog->id,str_slug($latestBlog->data_values->title)]) }}" class="widget__post">
                                    <div class="widget__post__thumb">
                                        <img src="{{ getImage('assets/images/frontend/blog/'.@$latestBlog->data_values->blog_image) }}" alt="@lang('blog')">
                                    </div>
                                    <div class="widget__post__content">
                                        <h6 class="widget__post__title">
                                            {{ shortDescription($blog->data_values->title, 35) }}
                                        </h6>
                                        <span>{{showDateTime(@$latestBlog->created_at,  $format = 'd F, Y')}}</span>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- blog-section end -->
@endsection

