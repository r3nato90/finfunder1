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
            <ul>
                <li class="profile-dropdown drop-down">
                    <div class="pointer dropdown-toggle d-flex align-items-center" role="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="profile-nav-img">
                            <img src="{{ displayImage(auth()->guard('agent')->user()->image) }}" alt="{{ auth()->guard('agent')->user()->name }}">
                        </span>
                        <p class="ms-1 hide_small admin--profile--notification">{{auth()->guard('agent')->user()->name}}</p>
                    </div>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li>
                            <a class="dropdown-item" href="{{route('agent.profile')}}"><i class="me-1 las la-cog"></i> {{ __('Profile Setting')}}</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{route('agent.logout')}}"><i class="me-1 las la-sign-in-alt"></i> {{ __('Logout')}}</a>
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
