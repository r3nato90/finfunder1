<header class="d-header">
    <div class="container-fluid px-0">
        <div class="row align-items-cener">
            <div class="col-lg-5 col-6 d-flex align-items-center">
                <div class="d-header-left">
                    <div class="sidebar-button" id="dash-sidebar-btn">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-6">
                <div class="d-header-right">
                    <div class="i-dropdown user-dropdown dropdown">
                        <div class="user-dropdown-meta dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <div class="user-img">
                                <img src="{{ displayImage(Auth::user()->image, '400x400') }}" alt="{{ __('Profile image') }}">
                            </div>
                            <div class="user-dropdown-info">
                                <p>{{ Auth::user()->name }}</p>
                            </div>
                        </div>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <span>{{ __('Welcome') }} {{ Auth::user()->name }}!</span>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('user.wallet.index') }}">
                                    {{ __('Wallet Top-Up') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Log Out') }}
                                </a>

                                <form id="logout-form" method="POST" action="{{ route('logout') }}">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
