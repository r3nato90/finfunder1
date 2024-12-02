<section class="topbar">
    <div class="container-fluid px-0">
        <div class="marquee marquee-one" data-gap='10' data-duplicated='true'>
            <div class="marquee-items">
               @foreach($cryptoCurrencies as $key => $currency)
                    <div class="marquee-item">
                        <div class="marquee-item-img">
                            <img src="{{ $currency->file }}" alt="{{ __($currency->name) }}">
                        </div>
                        <h6>{{ __($currency->pair) }}</h6>
                        <span>{{ getArrayValue($currency->meta, 'current_price') }} ({{ getArrayValue($currency->meta, 'price_change_24h') }}%)</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>


<header class="header-area style-1">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="header-left">
            <button class="header-item-btn sidebar-btn d-lg-none d-block">
                <i class="bi bi-bars"></i>
            </button>

            <div class="header-logo">
                <a href="{{route('home')}}">
                    <img src="{{ displayImage(getArrayValue($setting?->logo, 'white'), "592x89") }}" alt="{{ __('White Logo') }}">
                </a>
            </div>
        </div>

        <div class="main-nav">
            <div class="mobile-logo-area d-xl-none d-flex justify-content-between align-items-center">
                <div class="mobile-logo-wrap">
                    <img src="{{ displayImage(getArrayValue($setting?->logo, 'white'), "592x89") }}" alt="{{ __('White Logo') }}">
                </div>
                <div class="menu-close-btn">
                    <i class="bi bi-x-lg"></i>
                </div>
            </div>
            <ul class="menu-list">
                @foreach($menus as $menu)
                    @if($menu->name == 'Home')
                        <li class="menu-item-has-children">
                            <a href="{{ route('home') }}" class="drop-down {{ request()->routeIs('home') ? 'active' : '' }}">{{$menu->name}}</a>
                        </li>
                    @elseif($menu->name == 'Trade')

                        @if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::TRADE_PREDICTION->name)) == 1)
                            <li class="menu-item-has-children">
                                <a href="{{ route('trade') }}" class="drop-down {{ request()->routeIs('trade') ? 'active' : '' }}">{{$menu->name}}</a>
                            </li>
                        @endif
                    @elseif($menu->children->isEmpty())
                        <li><a href="{{route('dynamic.page', $menu->url)}}">{{$menu->name}}</a></li>
                    @elseif($menu->children->isNotEmpty())
                        <li class="menu-item-has-children">
                            <a href="{{$menu->url}}" class="drop-down">{{$menu->name}}</a>
                            <i class="bi bi-chevron-down dropdown-icon"></i>
                            <ul class="sub-menu">
                                @foreach($menu->children as $subMenu)
                                    <li><a href="{{$subMenu->url}}">{{$subMenu->name}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endforeach
                <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">{{ __('Contact') }}</a></li>
            </ul>

            @guest
                <a href="{{route('login')}}" class="i-btn btn--md d-xl-none d-flex capsuled btn--primary">@lang('Sign In')</a>
            @endguest

            @auth
                <a href="{{route('user.dashboard')}}" class="i-btn btn--md d-xl-none d-flex capsuled btn--primary">@lang('Dashboard')</a>
            @endauth
        </div>

        <div class="nav-right">
            @if(getArrayValue($setting?->system_configuration, 'language.value') == \App\Enums\Status::ACTIVE->value)
                <div class="dropdown-language">
                    <select class="language">
                        @foreach($languages as $lang)
                            <option value="{{ $lang->code }}" @if (session('lang') == $lang->code) selected @endif>{{ $lang?->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @guest
                <a href="{{route('login')}}" class="i-btn btn--md d-xl-flex d-none capsuled btn--primary-outline">@lang('Sign In')</a>
            @endguest

            @auth
                <a href="{{route('user.dashboard')}}" class="i-btn btn--md d-xl-flex d-none capsuled btn--primary-outline">@lang('Dashboard')</a>
            @endauth

            <div class="sidebar-btn d-xl-none d-flex">
                <i class="bi bi-list"></i>
            </div>
        </div>
    </div>
</header>

@push('script-push')
    <script>
        "use strict";
        $(document).ready(function () {
            $('.language').on('change', function () {
                const languageCode = $(this).val();
                changeLanguage(languageCode);
            });

            function changeLanguage(languageCode) {
                $.ajax({
                    url: "{{ route('home') }}/language-change/" + languageCode,
                    method: 'GET',
                    success: function (response) {
                        notify('success', response.message);
                        location.reload();
                    },
                    error: function (error) {
                        console.error('Error changing language', error);
                    }
                });
            }
        });
    </script>
@endpush

