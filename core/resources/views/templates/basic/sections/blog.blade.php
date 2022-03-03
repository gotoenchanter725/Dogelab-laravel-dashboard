@php
	$content    = getContent('blog.content', true);
	$blogs      = getContent('blog.element', false, 3);
@endphp
    <section class="blog-section pt-120 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="section__header section__header__center">
                    <span class="section__cate">
                        @lang(@$content->data_values->title)
                    </span>
                    <h3 class="section__title">@lang(@$content->data_values->subtitle)</h3>
                    <p>@lang(@$content->data_values->description)</p>
                </div>
            </div>
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
        </div>
    </section>
