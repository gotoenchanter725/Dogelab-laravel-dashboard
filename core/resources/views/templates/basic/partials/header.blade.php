 <!-- Header Section -->
 <header class="header-section">
    <div class="container">
        <div class="header-wrapper">
            <div class="logo">
                <a href="{{url('/')}}">
                    <img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}"  alt="@lang('site-logo')">
                </a>
            </div>
            <ul class="menu">
                @if(!session('ACCOUNT'))
                <li class="nav-item">
                    <a class="nav-link" @if(request()->routeIs('home')) href="#how_work"  @else href="{{url('/')}}#how_we_work" @endif>@lang('How To Start')</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" @if(request()->routeIs('home'))  href="#about-us" @else href="{{url('/')}}#about-us" @endif >@lang('About Us')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" @if(request()->routeIs('home'))  href="#transaction" @else href="{{url('/')}}#transaction" @endif>@lang('Transactions')</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" @if(request()->routeIs('home'))href="#faq"  @else href="{{url('/')}}#faq" @endif >@lang('FAQ')</a>
                </li>


                @php
                    $blogs      = getContent('blog.element')->count();
                @endphp

                @if($blogs)
                <li class="nav-item">
                    <a class="nav-link"  href="{{route('blogs')}}" >@lang('Blogs')</a>
                </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link"  href="{{route('contact')}}" >@lang('Contact')</a>
                </li>


                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{route('account.home')}}">@lang('Dashboard')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('account.deposit')}}">@lang('Deposit')</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{route('account.withdraw')}}">@lang('Withdraw')</a>
                </li>

                @if($general->referral_system)
                <li class="nav-item">
                    <a class="nav-link" href="{{route('account.referrals')}}">@lang('Referral')</a>
                </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link" href="{{route('account.logout')}}">@lang('Logout')</a>
                </li>

            @endif
            </ul>
            <select class="select-bar langSel">
                @foreach ($language as $lang)
                    <option value="{{$lang->code}}" @if(session('lang') == $lang->code) selected  @endif >
                        {{__($lang->name)}}
                    </option>
                @endforeach
            </select>
            <div class="header-bar m-0">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
</header>
<!-- Header Section -->
