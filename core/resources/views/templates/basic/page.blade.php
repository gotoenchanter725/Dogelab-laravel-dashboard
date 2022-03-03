@extends($activeTemplate.'layouts.master')


@section('content')
@php
	$content = getContent('breadcrumb.content', true);
@endphp

    <div class="hero-section bg--theme--overlay position-relative bg_img" data-background="{{getImage('assets/images/frontend/breadcrumb/' . @$content->data_values->image, '1920x400')}}">
        <div class="container">
            <h2 class="hero-title text--white">@lang($page_title)</h2>
        </div>
    </div>


    <div class="pt-120 pb-120">
        <div class="container">

            @lang(@$data->data_values->description)
        </div>
    </div>

@endsection

