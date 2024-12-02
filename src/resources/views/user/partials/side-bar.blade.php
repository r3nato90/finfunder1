<div class="d-sidebar" id="user-sidebar">
    <div class="sidebar-logo">
        <a href="{{ route('home') }}">
            <img src="{{ displayImage(getArrayValue($setting->logo, 'dark'), "592x89") }}" alt="{{ __('logo') }}">
        </a>
    </div>
    <div class="main-nav sidebar-menu-container">
        <ul class="sidebar-menu">
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link {{ request()->routeIs('user.dashboard') ? "active" :""}}" href="{{ route('user.dashboard') }}" aria-expanded="false">
                    <span><i class="bi bi-speedometer2"></i></span>
                    <p>{{ __('frontend.menu.dashboard') }}</p>
                </a>
            </li>

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link {{ request()->routeIs('user.transaction') ? "active" :""}}" href="{{ route('user.transaction') }}" aria-expanded="false">
                    <span><i class="bi bi-credit-card-fill"></i></span>
                    <p>{{ __('frontend.menu.transaction') }}</p>
                </a>
            </li>

            @if (getArrayValue($setting->system_configuration, 'investment_reward.value') == \App\Enums\Status::ACTIVE->value && getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::INVESTMENT->name)) == \App\Enums\Status::ACTIVE->value)
                <li class="sidebar-menu-item">
                    <a class="sidebar-menu-link {{ request()->routeIs('user.reward') ? "active" :""}}" href="{{ route('user.reward') }}" aria-expanded="false">
                        <span><i class="bi bi-award-fill"></i></span>
                        <p>{{ __('frontend.menu.reward_badge') }}</p>
                    </a>
                </li>
            @endif

            @if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::MATRIX->name)) == 1)
                <li class="sidebar-menu-item">
                    <a class="sidebar-menu-link collapsed {{ request()->routeIs(['user.matrix.index', 'user.commission.rewards', 'user.commission.index']) ? 'active' : '' }}" data-bs-toggle="collapse" href="#collapseWithdraw" role="button" aria-expanded="false" aria-controls="collapseWithdraw">
                        <span><i class="bi la-money-bill-wave"></i></span>
                        <p>{{ __('frontend.menu.matrix') }}<small><i class="las la-angle-{{ request()->routeIs(['user.matrix.index', 'user.commission.rewards','user.commission.index']) ? 'up' : 'down' }}"></i></small></p>
                    </a>
                    <div class="side-menu-dropdown collapse {{ request()->routeIs(['user.matrix.index', 'user.commission.rewards', 'user.commission.index']) ? 'show' : '' }}" id="collapseWithdraw">
                        <ul class="sub-menu {{ request()->routeIs(['user.matrix.index','user.commission.rewards','user.commission.index']) ? 'open-slide' : '' }}">
                            @foreach(['matrix.index' => __('frontend.menu.scheme'), 'commission.rewards' => __('frontend.menu.referral_reward'), 'commission.index' => __('frontend.menu.commission'),] as $route => $label)
                                <li class="sub-menu-item">
                                    <a class="sidebar-menu-link {{ request()->routeIs("user.$route") ? 'active' : '' }}"  href="{{ route("user.$route") }}" aria-expanded="false">
                                        <p>{{ __($label) }}</p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
            @endif

            @if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::INVESTMENT->name)) == 1)
                <li class="sidebar-menu-item">
                    <a class="sidebar-menu-link collapsed {{ request()->routeIs('user.investment.*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#collapsePaymentProcessor" role="button" aria-expanded="false" aria-controls="collapsePaymentProcessor">
                        <span><i class="bi bi-wallet-fill"></i></span>
                        <p>{{ __('frontend.menu.investment') }}  <small><i class="las la-angle-{{ request()->routeIs(['user.investment.index','user.investment.funds','user.investment.profit.statistics']) ? "up" : "down" }}"></i></small></p>
                    </a>
                    <div class="side-menu-dropdown collapse {{ request()->routeIs('user.investment.*') ? 'show' : '' }}" id="collapsePaymentProcessor">
                        <ul class="sub-menu  {{ request()->routeIs(['user.investment.index','user.investment.funds','user.investment.profit.statistics']) ? "open-slide" : "" }}">
                        @foreach(['index' => __('frontend.menu.scheme'), 'funds' => __('frontend.menu.fund'), 'profit.statistics' => __('frontend.menu.profit_statistics')] as $route => $label)
                            <li class="sub-menu-item">
                                <a class="sidebar-menu-link {{ request()->routeIs("user.investment.$route") ? 'active' : '' }}"  href="{{ route("user.investment.$route") }}" aria-expanded="false">
                                    <p>{{ __($label) }}</p>
                                </a>
                            </li>
                        @endforeach
                        </ul>
                    </div>
                </li>
            @endif


            @if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::STAKING_INVESTMENT->name)) == 1)
                <li class="sidebar-menu-item">
                    <a class="sidebar-menu-link {{ request()->routeIs('user.staking-investment.index') ? "active" :""}}"  href="{{ route('user.staking-investment.index') }}" aria-expanded="false">
                        <span><i class="bi bi-currency-euro"></i></span>
                        <p>{{ __('frontend.menu.staking_investment') }}</p>
                    </a>
                </li>
            @endif

            @if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::TRADE_PREDICTION->name)) == 1)
                <li class="sidebar-menu-item">
                    <a class="sidebar-menu-link collapsed {{ request()->routeIs('user.trade.*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#collapseTrade" role="button" aria-expanded="false" aria-controls="collapseTrade">
                        <span><i class="bi bi-bar-chart"></i></span>
                        <p>{{ __('frontend.menu.trades')  }}  <small><i class="las la-angle-{{ request()->routeIs(['user.investment.index','user.investment.funds','user.investment.profit.statistics']) ? "up" : "down" }}"></i></small></p>
                    </a>
                    <div class="side-menu-dropdown collapse {{ request()->routeIs('user.trade.*') ? 'show' : '' }}" id="collapseTrade">
                        <ul class="sub-menu  {{ request()->routeIs('user.trade.*') ? "open-slide" : "" }}">
                            @foreach(['index' => __('frontend.menu.trade_now'), 'tradelog' => __('frontend.menu.history'), 'practicelog' => __('frontend.menu.practices')] as $trade => $label)
                                <li class="sub-menu-item">
                                    <a class="sidebar-menu-link {{ request()->routeIs("user.trade.$trade") ? 'active' : '' }}"  href="{{ route("user.trade.$trade") }}" aria-expanded="false">
                                        <p>{{ __($label) }}</p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
            @endif

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link collapsed {{ request()->routeIs('user.payment.*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#collapseDeposit" role="button" aria-expanded="false" aria-controls="collapseTrade">
                    <span><i class="bi bi-wallet2"></i></span>
                    <p>{{ __('frontend.menu.deposit') }}  <small><i class="las la-angle-{{ request()->routeIs(['user.payment.index']) ? "up" : "down" }}"></i></small></p>
                </a>
                <div class="side-menu-dropdown collapse {{ request()->routeIs('user.payment.*') ? 'show' : '' }}" id="collapseDeposit">
                    <ul class="sub-menu  {{ request()->routeIs('user.payment.*') ? "open-slide" : "" }}">
                        @foreach(['index' => __('frontend.menu.instant'), 'commission' => __('frontend.menu.commission')] as $deposit => $label)
                            <li class="sub-menu-item">
                                <a class="sidebar-menu-link {{ request()->routeIs("user.payment.$deposit") ? 'active' : '' }}"  href="{{ route("user.payment.$deposit") }}" aria-expanded="false">
                                    <p>{{ __($label) }}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link {{ request()->routeIs('user.referral.index') ? "active" :""}}"  href="{{ route('user.referral.index') }}" aria-expanded="false">
                    <span><i class="bi bi-command"></i></span>
                    <p>{{ __('frontend.menu.referrals') }}</p>
                </a>
            </li>

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link {{ request()->routeIs('user.withdraw.index') ? "active" :""}}"  href="{{ route('user.withdraw.index') }}" aria-expanded="false">
                    <span><i class="bi bi-wallet"></i></span>
                    <p>{{ __('frontend.menu.cash_out')  }}</p>
                </a>
            </li>

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link {{ request()->routeIs('user.recharge.index') ? "active" :""}}"  href="{{ route('user.recharge.index') }}" aria-expanded="false">
                    <span><i class="bi bi-cash"></i></span>
                    <p>{{ __('frontend.menu.instapin_recharge')  }}</p>
                </a>
            </li>

            <li class="sidebar-menu-item">
            <a class="sidebar-menu-link {{ request()->routeIs('profile.edit') ? "active" :""}}"  href="{{ route('profile.edit') }}" aria-expanded="false">
                    <span><i class="bi bi-gear"></i></span>
                    <p>{{ __('frontend.menu.setting') }}</p>
                </a>
            </li>
        </ul>
    </div>
</div>
