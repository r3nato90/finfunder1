<header class="header">
    <div class="header_sub_content">
        <div class="topbar-left">
            <div class="sidebar-controller">
                <button class="sidebar-control-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" viewBox="0 0 24 24" xml:space="preserve" class=""><g><path d="M2 5a1 1 0 0 1 1-1h13a1 1 0 1 1 0 2H3a1 1 0 0 1-1-1zm19 6H3a1 1 0 1 0 0 2h18a1 1 0 1 0 0-2zm-9 7H3a1 1 0 1 0 0 2h9a1 1 0 1 0 0-2z" data-original="#000000" class=""></path></g></svg>
                </button>
            </div>
        </div>

        <div class="topbar-right d-flex align-items-center justify-content-center gap-lg-4 gap-3">
            <div class="lang-dropdown">
                <div class="btn-icon dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="las la-cog"></i>
                </div>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a href="{{ route('admin.setting.index') }}" class="dropdown-item"> <i class="las la-cogs me-1"></i>{{__('Application Settings')}}</a></li>
                    <li><a href="{{ route('admin.setting.automation') }}" class="dropdown-item"> <i class="las la-stream me-1"></i> {{__('Automation')}}</a></li>
                    <li><a href="{{ route('admin.plugin.index') }}" class="dropdown-item"> <i class="las la-icicles me-1"></i> {{__('Plugin Configuration')}}</a></li>
                    <li><a href="{{ route('admin.pages.index') }}" class="dropdown-item"> <i class="las la-map-marked-alt me-1"></i> {{__('Pages')}}</a></li>
                </ul>
            </div>

            <div class="header-icon">
                <div class="notification-dropdown">
                    <span>{{ $notifications->count() }}</span>
                    <div class="btn-icon dropdown-toggle" role="button"  data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="lar la-bell "></i>
                    </div>
                    <div class="dropdown-menu dropdown-menu-end">
                        <div class="dropdown-menu-title d-flex justify-content-between align-items-center">
                            <h6 class="fs-14">{{ __('Notification') }}</h6>
                        </div>
                        <div class="notification-items" data-simplebar>
                            <div class="notification-item">
                                <ul>
                                    @foreach($notifications as $notification)
                                        <li>
                                            <a href="{{ getArrayValue($notification->data, 'url') }}">
                                                <div class="notification-item-content">
                                                    <h5>{{ diffForHumans($notification->created_at) }}</h5>
                                                    <p>{{ getArrayValue($notification->data, 'message') }}</p>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        @if($notifications->count() != 0)
                            <div class="dropdown-menu-footer">
                                <a href="{{ route('admin.notification') }}">{{ __('admin.button.view') }}</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <ul>
                <li class="profile-dropdown drop-down">
                    <div class="pointer dropdown-toggle d-flex align-items-center" role="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="profile-nav-img">
                            <img src="{{ displayImage(auth()->guard('admin')->user()->image) }}" alt="{{ auth()->guard('admin')->user()->name }}">
                        </span>
                        <p class="ms-1 hide_small admin--profile--notification">{{auth()->guard('admin')->user()->name}}</p>
                    </div>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li>
                            <a class="dropdown-item" href="{{route('admin.profile')}}"><i class="me-1 las la-cog"></i> {{ __('Profile Setting')}}</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{route('admin.logout')}}"><i class="me-1 las la-sign-in-alt"></i> {{ __('Logout')}}</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</header>

@push('script-push')
    <script>
        "use strict";
        const header = document.querySelector(".header");
        if (header) {
            const checkScroll = () => {
                if (window.scrollY > 0) {
                    header.classList.add("sticky");
                } else {
                    header.classList.remove("sticky");
                }
            };
            window.addEventListener("scroll", checkScroll);
            window.addEventListener("load", checkScroll);
        }
    </script>
@endpush
