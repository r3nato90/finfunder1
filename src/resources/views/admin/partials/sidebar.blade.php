<aside class="sidebar" id="sidebar">
    <div class="sidebar-top">
        <div class="site-logo">
            <a href="{{route('admin.dashboard')}}">
                <img src="{{ displayImage(getArrayValue($setting->logo, 'white'), "592x89") }}" class="mx-auto" alt="{{ __('White Logo') }}">
            </a>
        </div>
    </div>

    <div class="sidebar-menu-container" data-simplebar>
        <ul class="sidebar-menu">
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link {{request()->routeIs('admin.dashboard') ? "active" :""}}" href="{{route('admin.dashboard')}}">
                    <span><i class="las la-cog"></i></span>
                    <p>{{ __('admin.dashboard.menu.name') }}</p>
                </a>
            </li>
            @php
                $routeNames = [
                    'admin.report.transactions',
                    'admin.report.investment',
                    'admin.report.trade',
                    'admin.report.matrix',
                ];
                $isStatisticsReportActive = request()->routeIs($routeNames);
            @endphp

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link collapsed {{ $isStatisticsReportActive ? "active" :"" }}" data-bs-toggle="collapse" href="#collapseStatisticsReport"
                   role="button" aria-expanded="true" aria-controls="collapseStatisticsReport">
                    <span><i class="las la-list"></i></span>
                    <p>{{ __('admin.report.menu.name')}}  <small><i class="las la-angle-down"></i></small></p>
                </a>

                <div class="side-menu-dropdown collapse {{ $isStatisticsReportActive ? "show" :"" }}"  id="collapseStatisticsReport">
                    <ul class="sub-menu">
                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('admin.report.transactions') ? "active" :"" }}" href="{{route('admin.report.transactions')}}">
                                <p>{{ __('admin.report.menu.sub_menus.first.name')}}</p>
                            </a>
                        </li>

                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('admin.report.investment') ? "active" :"" }}" href="{{route('admin.report.investment')}}">
                                <p>{{ __('admin.report.menu.sub_menus.second.name')}}</p>
                            </a>
                        </li>

                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('admin.report.trade') ? "active" :"" }}" href="{{route('admin.report.trade')}}">
                                <p>{{ __('admin.report.menu.sub_menus.third.name')}}</p>
                            </a>
                        </li>

                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('admin.report.matrix') ? "active" :"" }}" href="{{route('admin.report.matrix')}}">
                                <p>{{ __('admin.report.menu.sub_menus.fourth.name') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            @php
                $routeNames = [
                    'admin.user.index',
                    'admin.user.details',
                    'admin.user.identity',
                ];
                $isManageUserActive = request()->routeIs($routeNames);
            @endphp

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link collapsed {{ $isManageUserActive ? "active" :"" }}" data-bs-toggle="collapse" href="#collapseManageUser"
                   role="button" aria-expanded="true" aria-controls="collapseManageUser">
                    <span><i class="las la-users-cog"></i></span>
                    <p>{{ __('admin.user.menu.name')}}  <small><i class="las la-angle-down"></i></small></p>
                </a>

                <div class="side-menu-dropdown collapse {{ $isManageUserActive ? "show" :"" }}"  id="collapseManageUser">
                    <ul class="sub-menu">
                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{request()->routeIs(['admin.user.index', 'admin.user.details']) ? "active" :""}}" href="{{route('admin.user.index')}}">
                                <p>{{ __('admin.user.menu.user') }}</p>
                            </a>
                        </li>

                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('admin.user.identity') ? "active" :"" }}" href="{{route('admin.user.identity')}}">
                                <p>{{ __('admin.user.menu.kyc_log') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            @php
                $routeNames = [
                    'admin.agent.index',
                    'admin.agent.transaction',
                    'admin.agent.withdraw.index',
                    'admin.agent.withdraw.details'
                ];
                $isManageAgentActive = request()->routeIs($routeNames);
            @endphp

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link collapsed {{ $isManageAgentActive ? "active" :"" }}" data-bs-toggle="collapse" href="#collapseManageAgent"
                   role="button" aria-expanded="true" aria-controls="collapseManageAgent">
                    <span><i class="las la-user-tie"></i></span>
                    <p>{{ __('admin.agent.menu.name')}}  <small><i class="las la-angle-down"></i></small></p>
                </a>

                <div class="side-menu-dropdown collapse {{ $isManageAgentActive ? "show" :"" }}"  id="collapseManageAgent">
                    <ul class="sub-menu">
                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{request()->routeIs('admin.agent.index') ? "active" :""}}" href="{{route('admin.agent.index')}}">
                                <p>{{ __('admin.agent.menu.agent')}}</p>
                            </a>
                        </li>

                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('admin.agent.transaction') ? "active" :"" }}" href="{{route('admin.agent.transaction')}}">
                                <p>{{ __('admin.agent.menu.transaction')}}</p>
                            </a>
                        </li>

                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs(['admin.agent.withdraw.index', 'admin.agent.withdraw.details']) ? "active" :"" }}" href="{{route('admin.agent.withdraw.index')}}">
                                <p>{{ __('admin.agent.menu.withdraws')}}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link {{request()->routeIs('admin.binary.reward.index') ? "active" :""}}" href="{{route('admin.binary.reward.index')}}">
                    <span><i class="las la-medal"></i></span>
                    <p>{{ __('admin.user.menu.reward') }}</p>
                </a>
            </li>

            <li class="sidebar-menu-title" data-text="{{__('admin.sidebar.title.first')}}"> {{ __('admin.sidebar.title.first') }}</li>
            @php
                $routeNames = [
                    'admin.matrix.index',
                    'admin.matrix.create',
                    'admin.matrix.edit',
                    'admin.matrix.enrol',
                    'admin.matrix.level.commissions',
                    'admin.matrix.referral.commissions',
                    'admin.user.level',
                    'admin.user.referral',
                ];
                $isMatrixActive = request()->routeIs($routeNames);
            @endphp

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link {{request()->routeIs('admin.investment.setting.index') ? "active" :""}}" href="{{route('admin.investment.setting.index')}}">
                    <span><i class="las la-cog"></i></span>
                    <p>{{ __('admin.setting.menu.investment_setting') }}</p>
                </a>
            </li>

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link {{request()->routeIs('admin.binary.referral.index') ? "active" :""}}" href="{{route('admin.binary.referral.index')}}">
                    <span><i class="las la-sync"></i></span>
                    <p>{{ __('admin.setting.menu.referral_setting') }}</p>
                </a>
            </li>

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link collapsed {{$isMatrixActive ? "active" :"" }}" data-bs-toggle="collapse" href="#collapseMatrixLogs"
                   role="button" aria-expanded="true" aria-controls="collapseMatrixLogs">
                    <span><i class="las la-paper-plane"></i></span>
                    <p>{{ __('admin.matrix.menu.name')}}  <small><i class="las la-angle-down"></i></small></p>
                </a>

                <div class="side-menu-dropdown collapse {{$isMatrixActive ? "show" :"" }}"  id="collapseMatrixLogs">
                    <ul class="sub-menu">
                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs(['admin.matrix.index', 'admin.matrix.edit', 'admin.matrix.create']) ? "active" :"" }}" href="{{route('admin.matrix.index')}}">
                                <p>{{ __('admin.matrix.menu.sub_menus.first.name')}}</p>
                            </a>
                        </li>

                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('admin.matrix.enrol') ? "active" :"" }}" href="{{route('admin.matrix.enrol')}}">
                                <p>{{ __('admin.matrix.menu.sub_menus.second.name')}}</p>
                            </a>
                        </li>

                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs(['admin.matrix.level.commissions', 'admin.user.level']) ? "active" :"" }}" href="{{route('admin.matrix.level.commissions')}}">
                                <p>{{ __('admin.matrix.menu.sub_menus.third.name')}}</p>
                            </a>
                        </li>

                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs(['admin.matrix.referral.commissions', 'admin.user.referral']) ? "active" :"" }}" href="{{route('admin.matrix.referral.commissions')}}">
                                <p>{{ __('admin.matrix.menu.sub_menus.fourth.name') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            @php
                $routeNames = [
                    'admin.binary.index',
                    'admin.binary.create',
                    'admin.binary.edit',
                    'admin.binary.investment',
                    'admin.binary.daily.commissions',
                    'admin.user.investment',
                    'admin.binary.timetable.index',
                    'admin.binary.holiday-setting.index',
                    'admin.binary.details',
                ];
                $isBinaryActive = request()->routeIs($routeNames);
            @endphp

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link collapsed {{$isBinaryActive ? "active" :"" }}" data-bs-toggle="collapse" href="#collapseBinaryInvestment"
                   role="button" aria-expanded="true" aria-controls="collapseBinaryInvestment">
                    <span><i class="las la-plane-departure"></i></span>
                    <p>{{ __('admin.binary.menu.name') }}  <small><i class="las la-angle-down"></i></small>
                    </p>
                </a>

                <div class="side-menu-dropdown collapse {{$isBinaryActive ? "show" :"" }}"  id="collapseBinaryInvestment">
                    <ul class="sub-menu">
                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('admin.binary.timetable.index') ? "active" :"" }}" href="{{route('admin.binary.timetable.index')}}">
                                <p>{{ __('admin.binary.menu.timetable') }}</p>
                            </a>
                        </li>
                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('admin.binary.holiday-setting.index') ? "active" :"" }}" href="{{ route('admin.binary.holiday-setting.index') }}">
                                <p>{{ __('admin.binary.menu.holiday_setting') }}</p>
                            </a>
                        </li>
                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs(['admin.binary.index', 'admin.binary.edit', 'admin.binary.create']) ? "active" :"" }}" href="{{route('admin.binary.index')}}">
                                <p>{{ __('admin.binary.menu.sub_menus.first.name') }}</p>
                            </a>
                        </li>

                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs(['admin.binary.investment','admin.binary.details', 'admin.user.investment']) ? "active" :"" }}" href="{{route('admin.binary.investment')}}">
                                <p>{{ __('admin.binary.menu.sub_menus.second.name') }}</p>
                            </a>
                        </li>

                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('admin.binary.daily.commissions') ? "active" :"" }}" href="{{route('admin.binary.daily.commissions')}}">
                                <p>{{ __('admin.binary.menu.commission') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            @php
                $routeNames = [
                    'admin.binary.staking.plan.index',
                    'admin.binary.staking.investment',
                ];
                $isStakingActive = request()->routeIs($routeNames);
            @endphp

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link collapsed {{$isStakingActive ? "active" :"" }}" data-bs-toggle="collapse" href="#collapseStakingInvestment"
                   role="button" aria-expanded="true" aria-controls="collapseStakingInvestment">
                    <span><i class="las la-shekel-sign"></i></span>
                    <p>{{ __('admin.staking.menu.name') }}  <small><i class="las la-angle-down"></i></small></p>
                </a>

                <div class="side-menu-dropdown collapse {{$isStakingActive ? "show" :"" }}"  id="collapseStakingInvestment">
                    <ul class="sub-menu">
                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('admin.binary.staking.plan.index') ? "active" :"" }}" href="{{route('admin.binary.staking.plan.index')}}">
                                <p>{{ __('admin.staking.menu.plan') }}</p>
                            </a>
                        </li>
                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('admin.binary.staking.investment') ? "active" :"" }}" href="{{route('admin.binary.staking.investment')}}">
                                <p>{{ __('admin.staking.menu.investment') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="sidebar-menu-title" data-text="">{{ __('Trading Options') }}</li>

            @php
                $routeNames = [
                    'admin.trade.index',
                    'admin.trade.practice',
                    'admin.trade.parameter.index',
                    'admin.user.trade',
                ];
                $isTradeActive = request()->routeIs($routeNames);
            @endphp

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link  {{ request()->routeIs('admin.crypto.currencies.index') ? "active" : "" }}" href="{{route('admin.crypto.currencies.index')}}">
                    <span><i class="las la-coins"></i></span>
                    <p>{{ __('admin.crypto_currency.menu.name') }}</p>
                </a>
            </li>

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link collapsed {{$isTradeActive ? "active" :"" }}" data-bs-toggle="collapse" href="#collapseTradeLogs"
                   role="button" aria-expanded="true" aria-controls="collapseTradeLogs">
                    <span><i class="las la-exchange-alt"></i></span>
                    <p>{{ __('admin.crypto_currency.menu.trade_prediction') }} <small><i class="las la-angle-down"></i></small></p>
                </a>

                <div class="side-menu-dropdown collapse {{$isTradeActive ? "show" :"" }}"  id="collapseTradeLogs">
                    <ul class="sub-menu">
                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('admin.trade.parameter.index') ? "active" : "" }}" href="{{route('admin.trade.parameter.index')}}">
                                <p>{{ __('admin.trade_parameter.menu.name') }}</p>
                            </a>
                        </li>

                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs(['admin.trade.index', 'admin.user.trade']) ? "active" : "" }}" href="{{route('admin.trade.index')}}">
                                <p>{{ __('admin.trade_activity.menu.sub_menus.first.name') }}</p>
                            </a>
                        </li>

                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('admin.trade.practice') ? "active" : "" }}" href="{{route('admin.trade.practice')}}">
                                <p>{{ __('admin.trade_activity.menu.sub_menus.second.name') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            @php
                $routeNames = [
                    'admin.payment.gateway.index',
                    'admin.payment.gateway.edit',
                    'admin.manual.gateway.index',
                    'admin.manual.gateway.create',
                    'admin.manual.gateway.edit',
                ];
                $isPaymentGatewayActive = request()->routeIs($routeNames);
            @endphp

            <li class="sidebar-menu-title" data-text="{{ __('admin.sidebar.title.third')}}">{{__('admin.sidebar.title.second')}}</li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link collapsed {{$isPaymentGatewayActive ? "active" :"" }}" data-bs-toggle="collapse" href="#collapsePaymentProcessor"
                   role="button" aria-expanded="true" aria-controls="collapsePaymentProcessor">
                    <span><i class="las la-credit-card"></i></span>
                    <p>{{ __('admin.payment_processor.menu.name') }}  <small><i class="las la-angle-down"></i></small></p>
                </a>

                <div class="side-menu-dropdown collapse {{$isPaymentGatewayActive ? "show" :"" }}"  id="collapsePaymentProcessor">
                    <ul class="sub-menu">
                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('admin.payment.gateway.index') ? "active" :"" }}" href="{{route('admin.payment.gateway.index')}}">
                                <p>{{ __('admin.payment_processor.menu.sub_menus.first.name') }}</p>
                            </a>
                        </li>

                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('admin.manual.gateway.index') ? "active" :"" }}" href="{{route('admin.manual.gateway.index')}}">
                                <p>{{ __('admin.payment_processor.menu.sub_menus.second.name') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @php
                $routeNames = [
                    'admin.user.deposit',
                    'admin.deposit.index',
                    'admin.deposit.details',
                    'admin.deposit.commission',
                ];
                $isDepositActive = request()->routeIs($routeNames);
            @endphp
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link collapsed {{$isDepositActive ? "active" :"" }}" data-bs-toggle="collapse" href="#collapseDepositControl"
                   role="button" aria-expanded="true" aria-controls="collapseDepositControl">
                    <span><i class="las la-wallet"></i></span>
                    <p>{{ __('admin.deposit.menu.name') }}  <small><i class="las la-angle-down"></i></small></p>
                </a>

                <div class="side-menu-dropdown collapse {{$isDepositActive ? "show" :"" }}"  id="collapseDepositControl">
                    <ul class="sub-menu">
                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs(['admin.deposit.index', 'admin.deposit.details']) ? "active" :"" }}" href="{{route('admin.deposit.index')}}">
                                <p>{{ __('admin.deposit.menu.history') }}</p>
                            </a>
                        </li>

                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('admin.deposit.commission') ? "active" :"" }}" href="{{route('admin.deposit.commission')}}">
                                <p>{{ __('admin.deposit.menu.commission')  }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            @php
                $routeNames = [
                    'admin.withdraw.method.index',
                    'admin.withdraw.method.create',
                    'admin.withdraw.method.edit',
                    'admin.withdraw.index',
                    'admin.withdraw.details',
                    'admin.user.withdraw',
                ];
                $isWithdrawActive = request()->routeIs($routeNames);
            @endphp
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link collapsed {{$isWithdrawActive ? "active" :"" }}" data-bs-toggle="collapse" href="#collapseWithdraw"
                   role="button" aria-expanded="true" aria-controls="collapseWithdraw">
                    <span><i class="las la-money-bill"></i></span>
                    <p>{{ __('admin.withdraw.menu.name')}}<small><i class="las la-angle-down"></i></small></p>
                </a>

                <div class="side-menu-dropdown collapse {{$isWithdrawActive ? "show" :"" }}"  id="collapseWithdraw">
                    <ul class="sub-menu">
                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('admin.withdraw.method*') ? "active" :"" }}" href="{{route('admin.withdraw.method.index')}}">
                                <p>{{ __('admin.withdraw.menu.sub_menus.first.name')}}</p>
                            </a>
                        </li>

                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs(['admin.withdraw.index','admin.withdraw.details','admin.user.withdraw']) ? "active" :"" }}" href="{{route('admin.withdraw.index')}}">
                                <p>{{ __('admin.withdraw.menu.sub_menus.second.name')}}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link {{request()->routeIs('admin.pin*') ? "active" :""}}" href="{{route('admin.pin.index')}}">
                    <span><i class="las la-key"></i></span>
                    <p>{{ __('admin.pin.menu.name') }}</p>
                </a>
            </li>


            <li class="sidebar-menu-title" data-text="{{__('SETTINGS & OTHERS')}}">{{__('admin.sidebar.title.third')}}</li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link {{request()->routeIs(['admin.setting*', 'admin.general.index', 'admin.plugin.index']) ? "active" :""}}" href="{{route('admin.setting.index')}}">
                    <span><i class="las la-cogs"></i></span>
                    <p>{{__('admin.setting.menu.name')}}</p>
                </a>
            </li>

            @php
                $routeNames = [
                    'admin.security.index',
                    'admin.security.block.ip',
                    'admin.security.firewall',
                ];
                $isSecurityActive = request()->routeIs($routeNames);
            @endphp

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link collapsed {{$isSecurityActive ? "active" :"" }}" data-bs-toggle="collapse" href="#collapseSecurity"
                   role="button" aria-expanded="true" aria-controls="collapseWithdraw">
                    <span><i class="las la-lock"></i></span>
                    <p>{{ __('admin.security.menu.name') }}  <small><i class="las la-angle-down"></i></small></p>
                </a>

                <div class="side-menu-dropdown collapse {{$isSecurityActive ? "show" :"" }}"  id="collapseSecurity">
                    <ul class="sub-menu">
                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('admin.security.index') ? "active" :"" }}" href="{{route('admin.security.index')}}">
                                <p>{{ __('admin.security.menu.sub_menus.first.name') }}</p>
                            </a>
                        </li>

                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('admin.security.block.ip') ? "active" :"" }}" href="{{route('admin.security.block.ip')}}">
                                <p>{{ __('admin.security.menu.sub_menus.second.name') }}</p>
                            </a>
                        </li>

                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('admin.security.firewall') ? "active" :"" }}" href="{{route('admin.security.firewall')}}">
                                <p>{{ __('admin.security.menu.sub_menus.third.name') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            @php
                $routeNames = [
                    'admin.notifications.index',
                    'admin.notifications.template',
                    'admin.notifications.edit',
                    'admin.sms.gateway.index',
                    'admin.sms.gateway.edit',
                    'admin.mail.index'
                ];
                $isNotificationActive = request()->routeIs($routeNames);
            @endphp

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link collapsed {{$isNotificationActive ? "active" :"" }}" data-bs-toggle="collapse" href="#collapseNotification"
                   role="button" aria-expanded="true" aria-controls="collapseWithdraw">
                    <span><i class="las la-bell"></i></span>
                    <p>{{ __('admin.notification.menu.name') }}<small><i class="las la-angle-down"></i></small></p>
                </a>

                <div class="side-menu-dropdown collapse {{$isNotificationActive ? "show" :"" }}"  id="collapseNotification">
                    <ul class="sub-menu">
                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('admin.notifications.index') ? "active" :"" }}" href="{{route('admin.notifications.index')}}">
                                <p>{{ __('admin.notification.menu.sub_menus.first.name')}}</p>
                            </a>
                        </li>

                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs(['admin.notifications.template', 'admin.notifications.edit']) ? "active" :"" }}" href="{{route('admin.notifications.template')}}">
                                <p>{{ __('admin.notification.menu.sub_menus.second.name')}}</p>
                            </a>
                        </li>

                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('admin.mail.index') ? "active" :"" }}" href="{{route('admin.mail.index')}}">
                                <p>{{ __('admin.notification.menu.sub_menus.third.name')}}</p>
                            </a>
                        </li>

                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs(['admin.sms.gateway.index', 'admin.sms.gateway.edit']) ? "active" :"" }}" href="{{route('admin.sms.gateway.index')}}">
                                <p>{{ __('admin.notification.menu.sub_menus.fourth.name')}}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link {{request()->routeIs('admin.pages*') ? "active" :""}}" href="{{route('admin.pages.index')}}">
                    <span><i class="las la-map-marked-alt"></i></span>
                    <p>{{__('admin.page.menu.name')}}</p>
                </a>
            </li>

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link collapsed {{request()->routeIs('admin.frontend.section.*') ? "active" : "" }}" data-bs-toggle="collapse" href="#collapseFrontend"
                   role="button" aria-expanded="true" aria-controls="collapseFrontend">
                    <span><i class="las la-globe-americas"></i></span>
                    <p>{{ __('admin.appearance.menu.name')}} <small><i class="las la-angle-down"></i></small></p>
                </a>

                <div class="side-menu-dropdown collapse {{request()->routeIs('admin.frontend.section.*') ? "show" :"" }} "  id="collapseFrontend">
                    <ul class="sub-menu">
                        @php
                            $lastElement =  collect(request()->segments())->last();
                        @endphp
                        @foreach(\App\Services\FrontendService::getFrontendSection() as $key => $section)
                            <li class="sub-menu-item">
                                <a class="sidebar-menu-link @if($lastElement == $key) active @endif" href="{{ route('admin.frontend.section.index',$key) }}">
                                    <p>{{__(\Illuminate\Support\Arr::get($section, 'name',''))}}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>

            @php
                $subscriberRoute = [
                    'admin.subscriber.index',
                    'admin.subscriber.contact'
                ];
                $isSubscriberActive = request()->routeIs($subscriberRoute);
            @endphp

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link collapsed {{$isSubscriberActive ? "active" :"" }}" data-bs-toggle="collapse" href="#collapseSubscriber"
                   role="button" aria-expanded="true" aria-controls="collapseSubscriber">
                    <span><i class="las la-marker"></i></span>
                    <p>{{ __('admin.contact.menu.name') }}<small><i class="las la-angle-down"></i></small></p>
                </a>

                <div class="side-menu-dropdown collapse {{$isSubscriberActive ? "show" :"" }}"  id="collapseSubscriber">
                    <ul class="sub-menu">
                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('admin.subscriber.index') ? "active" :"" }}" href="{{route('admin.subscriber.index')}}">
                                <p>{{ __('admin.contact.menu.subscriber') }}</p>
                            </a>
                        </li>

                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('admin.subscriber.contact') ? "active" : "" }}" href="{{route('admin.subscriber.contact')}}">
                                <p>{{ __('admin.contact.menu.contact') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link" href="{{route('admin.setting.cache.clear')}}">
                    <span><i class="las la-broom"></i></span>
                    <p>{{__('admin.cache.menu.name')}}</p>
                </a>
            </li>
        </ul>
    </div>
</aside>


@push('script-push')
    <script>
        "use strict";
        (function(){
            const htmlRoot = document.documentElement;
            const sidebarControlBtn = document.querySelector('.sidebar-control-btn');
            const menuTitle = document.querySelectorAll('.sidebar-menu-title');
            const minWidth = 1199;

            window.addEventListener("DOMContentLoaded", () => {
                handleSetAttribute(htmlRoot, 'data-sidebar', "lg");
                handleResize();

                sidebarControlBtn.addEventListener("click", () => {
                    const windowWidth = window.innerWidth;
                    if (windowWidth <= minWidth) {
                        showSidebar();
                        createOverlay();
                    } else {
                        handleSidebarToggle();
                    }
                });
            });

            function createOverlay() {
                const overlay = document.createElement('div');
                overlay.setAttribute("id", "overlay-wrapper");

                overlay.style.cssText = `
                    position: fixed;
                    inset: 0;
                    width: 100%;
                    height: 100vh;
                    background: rgb(0 0 0 / 20%);
                    z-index: 19;
                `;
                document.body.appendChild(overlay);

                overlay.addEventListener("click", () => {
                    hideSidebar();
                    removeOverlay();
                });
            }

            function removeOverlay() {
                const overlayWrapper = document.querySelector("#overlay-wrapper")
                overlayWrapper && overlayWrapper.remove();
            }

            function handleSetAttribute(elem, attr, value = 'lg') {
                elem.setAttribute(attr, value);
            }

            function handleGetAttribute(elem, attr) {
                return elem.getAttribute(attr);
            }

            function showSidebar() {
                const sidebar = document.querySelector('.sidebar');
                if (sidebar) {
                    sidebar.style.transform = 'translateX(0%)';
                    sidebar.style.visibility = 'visible';
                }
            }

            function hideSidebar() {
                const sidebar = document.querySelector('.sidebar');
                if (sidebar) {
                    sidebar.style.transform = 'translateX(-100%)';
                    sidebar.style.visibility = 'hidden';
                }
            }

            function handleSidebarToggle() {
                const currentSidebar = handleGetAttribute(htmlRoot, 'data-sidebar');
                const newAttributes = currentSidebar === 'sm' ? 'lg' : 'sm';

                handleSetAttribute(htmlRoot, 'data-sidebar', newAttributes);

                for (const title of menuTitle) {
                    const dataText = title.getAttribute('data-text');
                    title.innerHTML = newAttributes === 'sm' ? '<i class="las la-ellipsis-h"></i>' : dataText;
                }
            }

            function handleResize() {
                const windowWidth = window.innerWidth;
                if (windowWidth <= minWidth) {
                    handleSetAttribute(htmlRoot, 'data-sidebar', "lg");
                    hideSidebar();
                    removeOverlay();
                } else {
                    removeOverlay();
                    showSidebar();
                }
            }

            window.addEventListener('resize', handleResize);
            if (document.querySelectorAll(".sidebar-menu .collapse")) {
                const collapses = document.querySelectorAll(".sidebar-menu .collapse");
                Array.from(collapses).forEach(function (collapse) {
                    const collapseInstance = new bootstrap.Collapse(collapse, {
                        toggle: false,
                    });
                    collapse.addEventListener("show.bs.collapse", function (e) {
                        e.stopPropagation();
                        const closestCollapse = collapse.parentElement.closest(".collapse");
                        if (closestCollapse) {
                            const siblingCollapses = closestCollapse.querySelectorAll(".collapse");
                            Array.from(siblingCollapses).forEach(function (siblingCollapse) {
                                const siblingCollapseInstance = bootstrap.Collapse.getInstance(siblingCollapse);
                                if (siblingCollapseInstance === collapseInstance) {
                                    return;
                                }
                                siblingCollapseInstance.hide();
                            });
                        } else {
                            const getSiblings = function (elem) {
                                const siblings = [];
                                let sibling = elem.parentNode.firstChild;
                                while (sibling) {
                                    if (sibling.nodeType === 1 && sibling !== elem) {
                                        siblings.push(sibling);
                                    }
                                    sibling = sibling.nextSibling;
                                }
                                return siblings;
                            };
                            const siblings = getSiblings(collapse.parentElement);
                            Array.from(siblings).forEach(function (item) {
                                if (item.childNodes.length > 2)
                                    item.firstElementChild.setAttribute("aria-expanded", "false");
                                const ids = item.querySelectorAll("*[id]");
                                Array.from(ids).forEach(function (item1) {
                                    item1.classList.remove("show");
                                    if (item1.childNodes.length > 2) {
                                        const val = item1.querySelectorAll("ul li a");
                                        Array.from(val).forEach(function (subitem) {
                                            if (subitem.hasAttribute("aria-expanded"))
                                                subitem.setAttribute("aria-expanded", "false");
                                        });
                                    }
                                });
                            });
                        }
                    });

                    collapse.addEventListener("hide.bs.collapse", function (e) {
                        e.stopPropagation();
                        const childCollapses = collapse.querySelectorAll(".collapse");
                        Array.from(childCollapses).forEach(function (childCollapse) {
                            let childCollapseInstance;
                            childCollapseInstance = bootstrap.Collapse.getInstance(childCollapse);
                            childCollapseInstance.hide();
                        });
                    });
                });
            }

        }());
    </script>
@endpush





