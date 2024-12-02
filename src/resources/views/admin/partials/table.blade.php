<div class="card">
    <div class="responsive-table">
        <table>
            <thead>
                <tr>
                    @foreach($columns as $key =>  $column)
                        <th>@lang($column)</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
            @forelse($rows as $row)
                @php
                    $color = $name = $user = $fromUser = $plan = $parameter = $route = $withdrawGateway = $withdrawFinalAmount = $withdrawConversion = $withdrawRate = $withdrawLimit = $withdrawCharges = '';
                    if (\App\Enums\PageIdentifier::MATRIX->value == $page_identifier) {
                        $totalAmount = $row->matrixLevel->sum('amount') + $row->referral_reward;
                        $calculateAmount = $row->amount - $totalAmount;
                        $color = \App\Enums\Matrix\PlanStatus::getColor($row->status);
                        $name = \App\Enums\Matrix\PlanStatus::getName($row->status);
                        $route = '<a href="' . route('admin.matrix.edit', [$row->uid]) . '">' . __('Edit') . '</a>';
                    } elseif (\App\Enums\PageIdentifier::MATRIX_ENROLLED->value == $page_identifier) {
                        $color = \App\Enums\Matrix\InvestmentStatus::getColor($row->status);
                        $name = \App\Enums\Matrix\InvestmentStatus::getName($row->status);
                    } elseif (\App\Enums\PageIdentifier::STAKING_INVESTMENT->value == $page_identifier) {
                        $color = \App\Enums\Investment\Staking\Status::getColor($row->status);
                        $name = \App\Enums\Investment\Staking\Status::getName($row->status);
                    } elseif (\App\Enums\PageIdentifier::BINARY->value == $page_identifier) {
                        $color = \App\Enums\Matrix\PlanStatus::getColor($row->status);
                        $name = \App\Enums\Matrix\PlanStatus::getName($row->status);
                        $route = '<a href="' . route('admin.binary.edit', $row->uid) . '">'. __('Edit') . '</a>';
                    } elseif (\App\Enums\PageIdentifier::BINARY_INVESTMENT->value == $page_identifier) {
                        $plan = $row->plan_name;
                         $route = "<a href='" . route('admin.binary.details', $row->id) . "'>" . __('Details') . "</a>";
                    } elseif (\App\Enums\PageIdentifier::DAILY_COMMISSIONS->value == $page_identifier) {
                        $user = $row->user->email;
                    } elseif (\App\Enums\PageIdentifier::COMMISSIONS->value == $page_identifier) {
                        $fromUser = optional($row->fromUser)->email;
                    } elseif (\App\Enums\PageIdentifier::PIN_GENERATE->value == $page_identifier) {
                        if ($row->set_user_id) {
                            $user = "<a href=\"" . route('admin.user.details', $row->setUser->id) . "\">" . $row->setUser->email . "</a>";
                        } else {
                            $user = __('Admin');
                        }
                        $color = \App\Enums\Matrix\PinStatus::getColor($row->status);
                        $name = \App\Enums\Matrix\PinStatus::getName($row->status);
                    }elseif (\App\Enums\PageIdentifier::STAKING_PLAN->value == $page_identifier) {
                        $color = \App\Enums\Status::getColor($row->status);
                        $name = \App\Enums\Status::getName($row->status);
                        $route = "<a href='javascript:void(0)' class='updateBtn' data-toggle='modal' data-target='#updateModal' data-id='{$row->id}' data-duration='{$row->duration}' data-interest_rate='" . getAmount($row->interest_rate) . "' data-minimum_amount='" . getAmount($row->minimum_amount) . "' data-maximum_amount='" . getAmount($row->maximum_amount) . "'>" . __('Edit') . "</a>";
                    }
                    elseif (\App\Enums\PageIdentifier::TIME_TABLE->value == $page_identifier) {
                        $color = \App\Enums\Status::getColor($row->status);
                        $name = \App\Enums\Status::getName($row->status);
                        $route = "<a href='javascript:void(0)' class='updateBtn' data-toggle='modal' data-target='#updateModal' data-id='{$row->id}' data-time='{$row->time}' data-name='{$row->name}' data-status='{$row->status}'>" . __('Edit') . "</a>";
                    }
                    elseif (\App\Enums\PageIdentifier::KYC_IDENTITY->value == $page_identifier) {
                        $route = "<a href='javascript:void(0)' class='kyc_identity' data-toggle='modal' data-target='#kycIdentityModal' data-id='{$row->id}'>" . __('Update') . "</a>";
                    }
                    elseif (\App\Enums\PageIdentifier::REWARD->value == $page_identifier) {
                        $color = \App\Enums\Status::getColor($row->status);
                        $name = \App\Enums\Status::getName($row->status);
                        $route = "<a href='javascript:void(0)' class='updateBtn' data-toggle='modal' data-target='#rewardUpdateModal' data-id='{$row->id}' data-level='{$row->level}' data-reward='" . getAmount($row->reward) . "' data-referral_count='" . getAmount($row->referral_count) . "' data-deposit='" . getAmount($row->deposit) . "' data-team_invest='" . getAmount($row->team_invest) . "' data-invest='" . getAmount($row->invest) . "' data-name='{$row->name}' data-status='{$row->status}'>" . __('Edit') . "</a>";
                    }elseif (\App\Enums\PageIdentifier::HOLIDAY_SETTING->value == $page_identifier) {
                        $route = "<a href='javascript:void(0)' class='updateBtn' data-toggle='modal' data-target='#updateModal' data-id='{$row->id}' data-date='{$row->date}' data-name='{$row->name}'>" . __('Edit') . "</a>";
                    }elseif (\App\Enums\PageIdentifier::TRADE_PARAMETER->value == $page_identifier) {
                        $parameter = $row->time . ' ' . $row->unit;
                        $color = \App\Enums\Trade\TradeParameterStatus::getColor($row->status);
                        $name = \App\Enums\Trade\TradeParameterStatus::getName($row->status);
                        $route = "<a href='javascript:void(0)' class='updateBtn' data-toggle='modal' data-target='#updateModal' data-id='{$row->id}' data-time='{$row->time}' data-unit='{$row->unit}' data-status='{$row->status}'>" . __('Edit') . "</a>";
                    } elseif (\App\Enums\PageIdentifier::CRYPTO_CURRENCY->value == $page_identifier) {
                        $color = \App\Enums\Trade\CryptoCurrencyStatus::getColor($row->status);
                        $name = \App\Enums\Trade\CryptoCurrencyStatus::getName($row->status);
                        $route = "<a href='javascript:void(0)' class='updateBtn' data-toggle='modal' data-target='#updateModal' data-id='{$row->id}' data-status='{$row->status}'>" . __('Edit') . "</a>";
                    } elseif (\App\Enums\PageIdentifier::DEPOSIT->value == $page_identifier) {
                        $color = \App\Enums\Payment\Deposit\Status::getColor($row->status);
                        $name = \App\Enums\Payment\Deposit\Status::getName($row->status);
                        $route = "<a href='" . route('admin.deposit.details', $row->id) . "'>" . __('Details') . "</a>";
                    } elseif (\App\Enums\PageIdentifier::WITHDRAW_METHOD->value == $page_identifier) {
                        $color = \App\Enums\Payment\Withdraw\MethodStatus::getColor($row->status);
                        $name = \App\Enums\Payment\Withdraw\MethodStatus::getName($row->status);
                        $withdrawRate = getCurrencySymbol() . "1" . ' = ' . shortAmount($row->rate) . ' ' . $row->currency_name;
                        $withdrawLimit = getCurrencySymbol() . shortAmount($row->min_limit) . ' - ' . getCurrencySymbol() . shortAmount($row->max_limit);
                        $withdrawCharges = "Fixed charge: " . getCurrencySymbol() . shortAmount($row->fixed_charge, 2) . '<br>' . 'Percent Charge: ' . shortAmount($row->percent_charge, 2) . '%';
                        $route = "<a href='" . route('admin.withdraw.method.edit', $row->id) . "'>" . __('Edit') . "</a>";
                    } elseif (\App\Enums\PageIdentifier::WITHDRAW_LOG->value == $page_identifier) {
                        $color = \App\Enums\Payment\Withdraw\Status::getColor($row->status);
                        $name = \App\Enums\Payment\Withdraw\Status::getName($row->status);
                        $withdrawFinalAmount = getCurrencySymbol() . shortAmount($row->amount);
                        $withdrawConversion = getCurrencySymbol() . '1' . ' = ' . shortAmount($row->rate) . ' ' . __($row->currency);
                        $withdrawGateway = $row->withdrawMethod->name ?? 'N/A';
                        $route = "<a href='" . route('admin.withdraw.details', $row->id) . "'>" . __('Details') . "</a>";
                    } elseif (\App\Enums\PageIdentifier::AGENT_WITHDRAW_LOG->value == $page_identifier) {
                        $color = \App\Enums\Payment\Withdraw\Status::getColor($row->status);
                        $name = \App\Enums\Payment\Withdraw\Status::getName($row->status);
                        $withdrawFinalAmount = getCurrencySymbol() . shortAmount($row->amount);
                        $withdrawConversion = getCurrencySymbol() . '1' . ' = ' . shortAmount($row->rate) . ' ' . __($row->currency);
                        $withdrawGateway = $row->withdrawMethod->name ?? 'N/A';
                        $route = "<a href='" . route('admin.agent.withdraw.details', $row->id) . "'>" . __('Details') . "</a>";
                    } elseif (\App\Enums\PageIdentifier::SUPPORT_TICKET->value == $page_identifier) {
                        $color = \App\Enums\SupportTicketStatus::getColor($row->status);
                        $name = \App\Enums\SupportTicketStatus::getName($row->status);
                        $route = "<a href='" . route('admin.support.ticket.details', $row->uid) . "'>" . __('Details') . "</a>";
                    } elseif (\App\Enums\PageIdentifier::USER->value == $page_identifier) {
                        $color = \App\Enums\User\Status::getColor($row->status);
                        $name = \App\Enums\User\Status::getName($row->status);
                        $route = "<a href=\"" . route('admin.user.details', ['id' => $row->id]) . "\">" . __('Details') . "</a>";
                    } elseif (\App\Enums\PageIdentifier::AGENT->value == $page_identifier) {
                        $color = \App\Enums\Status::getColor($row->status);
                        $name = \App\Enums\Status::getName($row->status);
                    } elseif (\App\Enums\PageIdentifier::PAYMENT_GATEWAY->value == $page_identifier) {
                        $color = \App\Enums\Status::getColor($row->status);
                        $name = \App\Enums\Status::getName($row->status);
                        $route = "<a href='" . route('admin.payment.gateway.edit', $row->id) . "'>" . __('Edit') . "</a>";
                    }elseif (\App\Enums\PageIdentifier::MANUAL_PAYMENT_GATEWAY->value == $page_identifier) {
                        $color = \App\Enums\Status::getColor($row->status);
                        $name = \App\Enums\Status::getName($row->status);
                        $route = "<a href='" . route('admin.manual.gateway.edit', $row->id) . "'>" . __('Edit') . "</a>";
                    } elseif (\App\Enums\PageIdentifier::SMS_EMAIL_TEMPLATES->value == $page_identifier) {
                        $color = \App\Enums\Status::getColor($row->status);
                        $name = \App\Enums\Status::getName($row->status);
                        $route = "<a href='" . route('admin.notifications.edit', $row->id) . "'>" . __('Edit') . "</a>";
                    }elseif (\App\Enums\PageIdentifier::SMS_GATEWAYS->value == $page_identifier) {
                        $color = \App\Enums\Status::getColor($row->status);
                        $name = \App\Enums\Status::getName($row->status);
                        $route = "<a href='" . route('admin.sms.gateway.edit', $row->id) . "'>" . __('Edit') . "</a>";
                    }elseif (\App\Enums\PageIdentifier::TRADE->value == $page_identifier) {
                        $color = \App\Enums\Trade\TradeStatus::getColor($row->status);
                        $name = \App\Enums\Trade\TradeStatus::getName($row->status);
                    }
                @endphp
                <tr>
                    @foreach($columns as $dbColumn => $column)
                        <td data-label="{{ $column }}">
                            @if($dbColumn == 'created_at')
                                <span>{{ showDateTime($row->$dbColumn) }}</span>
                            @elseif($dbColumn == 'last_run')
                                @if(is_null($row->$dbColumn))
                                    {{ __('N/A') }}
                                @else
                                    <span>{{ showDateTime($row->$dbColumn) }}</span>
                                @endif
                            @elseif($dbColumn == 'pair')
                                <div  class="d-flex justify-content-sm-start justify-content-end align-items-center gap-2">
                                    <div class="crypto-currency-icon">
                                        <img src="{{ $row->file }}"  alt="{{ $row->name }}">
                                    </div>
                                    <span class="flex-shrink-0">{{ $row->pair }}</span>
                                </div>
                            @elseif($dbColumn == 'payment_gateway_name')
                                <div  class="d-flex justify-content-sm-start justify-content-end align-items-center gap-2">
                                    <div class="crypto-currency-icon">
                                        <img src="{{ displayImage($row->file, '400x400') }}"  alt="{{ $row->name }}">
                                    </div>
                                    <span class="flex-shrink-0">{{ $row->name }}</span>
                                </div>
                            @elseif($dbColumn == 'sms_gateway_name')
                                {{__(ucfirst($row->name))}}
                                @if($row->id == $setting->sms_gateway_id)
                                    <span class="text-success"><i class="las la-check"></i></span>
                                @endif
                            @elseif($dbColumn == 'parameter')
                                <span>{{ $parameter }} </span>
                            @elseif($dbColumn == 'transaction_name')
                                <span>{{ $row->agent->name ?? '' }} </span>
                            @elseif($dbColumn == 'duration')
                                <span>{{ $row->duration }} {{ __('Days') }} </span>
                            @elseif($dbColumn == 'holiday_date')
                                <span>{{ showDateTime($row->date, 'd M Y') }}</span>
                            @elseif(Str::contains($dbColumn, "crypto"))
                                @if($dbColumn == 'crypto_price_change_24h')
                                    <span>{{ getArrayValue($row->meta, Str::replaceFirst('crypto_', '', $dbColumn)) }}%</span>
                                @else
                                    <span>{{ getCurrencySymbol() }}{{ getArrayValue($row->meta, Str::replaceFirst('crypto_', '', $dbColumn)) }}</span>
                                @endif
                            @elseif($dbColumn == 'user_id')
                                <a href={{ route('admin.user.details', $row->user_id) }}>{{ $row->user->email }}</a>
                            @elseif($dbColumn == 'payment_gateway_id')
                                <span>{{ $row->gateway->name ?? 'N/A' }}</span>
                            @elseif($dbColumn == 'set_user_id')
                                <span>@php echo $user @endphp</span>
                            @elseif($dbColumn == 'from_user_id')
                                <a href={{ route('admin.user.details', $row->from_user_id) }}>{{ $fromUser }}</a>
                            @elseif($dbColumn == 'user_wallet')
                                <button type="button"
                                    class="badge badge--success-outline wallets"
                                    data-bs-toggle="modal" data-id="{{$row->wallet}}"
                                    data-bs-target="#list-wallet">{{ __('Wallet')}}
                                </button>
                            @elseif($dbColumn == 'user_identity_information')
                                <button type="button" class="badge badge--primary-outline identity-info"
                                        data-bs-toggle="modal"
                                        data-meta='@json($row->meta['identity'] ?? [])'
                                        data-bs-target="#identity-information">
                                    {{ __('Information') }}
                                </button>
                            @elseif($dbColumn == 'user_add_subtract')
                                <button type="button"
                                    class="badge badge--primary-outline created-update"
                                    data-bs-toggle="modal" data-id="{{$row->id}}"
                                    data-bs-target="#credit-add-return">{{ __('Add / Subtract')}}
                                </button>
                            @elseif($dbColumn == 'agent_action')
                                <a href="javascript:void(0)" class="badge badge--primary-transparent agentUpdate"
                                   data-toggle="modal"
                                   data-target="#agentUpdateModal"
                                   data-id="{{$row->id}}"
                                   data-name="{{$row->email}}"
                                   data-status="{{$row->status}}"
                                >{{ __('Edit') }}</a>
                            @elseif($dbColumn == 'agent_primary_balance')
                                <span> {{ getCurrencySymbol() }}{{ shortAmount($row->balance ?? 0) }} </span>
                            @elseif($dbColumn == 'transaction_post_balance')
                                {{ \App\Enums\Transaction\WalletType::getName((int)$row->wallet_type) }} : {{ getCurrencySymbol() }}{{ shortAmount($row->post_balance) }}
                            @elseif($dbColumn == 'transaction_amount')
                                <span class="text--{{ \App\Enums\Transaction\Type::getTextColor((int)$row->type) }}">
                                   {{ getCurrencySymbol() }}{{ shortAmount($row->amount) }}
                                </span>
                            @elseif($dbColumn == 'transaction_wallet_type')
                                <span class="badge {{ \App\Enums\Transaction\WalletType::getColor((int)$row->wallet_type) }}">
                                    {{ \App\Enums\Transaction\WalletType::getWalletName((int)$row->wallet_type) }}
                                </span>
                            @elseif($dbColumn == 'transaction_source')
                                <span class="badge {{ \App\Enums\Transaction\Source::getColor((int)$row->source) }}">
                                    {{ \App\Enums\Transaction\Source::getName((int)$row->source) }}
                                </span>
                            @elseif($dbColumn == 'withdraw_method_id')
                                <span>{{ $withdrawGateway  }}</span>
                            @elseif($dbColumn == 'withdraw_amount')
                                <span>{{ $withdrawFinalAmount  }}</span>
                            @elseif($dbColumn == 'time_table')
                                <span>{{ $row->time ?? ''  }} {{ __('Hours') }}</span>
                            @elseif($dbColumn == 'withdraw_conversion')
                                <span>{{ $withdrawConversion  }}</span>
                            @elseif($dbColumn == 'withdraw_rate')
                                <span>{{ $withdrawRate  }}</span>
                            @elseif($dbColumn == 'rate')
                                <span>{{ getCurrencySymbol() }}1 =  {{ shortAmount($row->$dbColumn)  }} {{ $row->currency  }}</span>
                            @elseif($dbColumn == 'withdraw_limit')
                                <span>{{ $withdrawLimit  }}</span>
                            @elseif($dbColumn == 'withdraw_charges')
                                <span>@php echo  $withdrawCharges @endphp</span>
                            @elseif($dbColumn == 'amount' || $dbColumn == 'reward' || $dbColumn == 'referral_reward' || $dbColumn == 'profit' || $dbColumn == 'minimum' || $dbColumn == 'maximum'
                                || $dbColumn == 'daily_profit' || $dbColumn == 'post_balance' || $dbColumn == 'charge' || $dbColumn == 'final_amount' || $dbColumn == 'after_charge' || $dbColumn == 'price' || $dbColumn == 'referral_commissions' || $dbColumn == 'level_commissions')
                                <span>{{ getCurrencySymbol() }}{{ shortAmount($row->$dbColumn) }}</span>
                            @elseif($dbColumn == 'invest' || $dbColumn == 'team_invest' || $dbColumn == 'deposit' || $dbColumn == 'referral_count')
                                @if (\App\Enums\PageIdentifier::REWARD->value == $page_identifier)
                                    <span>{{ $dbColumn == 'referral_count' ? '' : getCurrencySymbol() }}{{ shortAmount($row->$dbColumn) }}</span>
                                @endif
                            @elseif($dbColumn == 'trade_outcome_amount')
                                @if($row->outcome == \App\Enums\Trade\TradeOutcome::WIN->value)

                                        {{ getCurrencySymbol() }}{{ shortAmount($row->amount) }}
                                        +
                                        {{ getCurrencySymbol() }}{{ shortAmount($row->winning_amount) }}
                                        =
                                    <span class="text--success">
                                        {{ getCurrencySymbol() }}{{ shortAmount($row->amount + $row->winning_amount) }}
                                    </span>
                                @elseif($row->outcome == \App\Enums\Trade\TradeOutcome::LOSE->value)
                                    <span class="text--danger">{{ getCurrencySymbol() }}{{ shortAmount($row->amount) }}</span>
                                @else
                                    <span class="text--primary">{{ getCurrencySymbol() }}{{ shortAmount($row->amount) }}</span>
                                @endif
                            @elseif($dbColumn == 'return_percentage' || $dbColumn == 'interest_rate' || $dbColumn == 'percent_charge')
                                <span>{{ shortAmount($row->$dbColumn) }}%</span>
                            @elseif($dbColumn == 'staking_amount')
                                {{ getCurrencySymbol() }}{{ shortAmount($row->minimum_amount) }} -    {{ getCurrencySymbol() }}{{ shortAmount($row->maximum_amount) }}
                            @elseif($dbColumn == 'invest_limit')
                                @if($row->type == \App\Enums\Investment\InvestmentRage::RANGE->value)
                                    {{ getCurrencySymbol() }}{{ shortAmount($row->minimum) }} -    {{ getCurrencySymbol() }}{{ shortAmount($row->maximum) }}
                                @else
                                    {{ getCurrencySymbol() }}{{ shortAmount($row->amount) }}
                                @endif
                            @elseif($dbColumn == 'payment_limit')
                                {{ getCurrencySymbol() }}{{ shortAmount($row->minimum) }} - {{ getCurrencySymbol() }}{{ shortAmount($row->maximum) }}
                            @elseif($dbColumn == 'investment_interest_rate')
                                @if(@$row->interest_type == \App\Enums\Investment\InterestType::PERCENT->value)
                                   {{ shortAmount($row->interest_rate) }} %
                                @else
                                    {{ shortAmount($row->interest_rate) }} {{ getCurrencyName() }}
                                @endif
                            @elseif($dbColumn == 'investment_interest')
                                {{ getCurrencySymbol() }}{{ shortAmount($row->interest_rate) }}
                            @elseif($dbColumn == 'should_pay')
                                {{ $row->should_pay != -1 ? getCurrencySymbol(). shortAmount($row->should_pay) : '****' }}
                            @elseif($dbColumn == 'investment_time')
                                {{ $row->timeTable->time ?? 'N/A' }} {{ __('Hours') }}
                            @elseif($dbColumn == 'investment_return_type')
                                {{ \App\Enums\Investment\ReturnType::getName(@$row->interest_return_type) }}
                            @elseif($dbColumn == 'investment_recommend')
                                {{ $row->is_recommend ? 'Yes' : 'No' }}
                            @elseif($dbColumn == 'invest_type')
                                <span class="badge {{ \App\Enums\Investment\InvestmentRage::getColor($row->type) }}">{{ \App\Enums\Investment\InvestmentRage::getName($row->type) }}</span>
                            @elseif($dbColumn == 'plan_profit_loss')
                                @if ($row->amount > $totalAmount)
                                    <span class="text-success">@lang('Admin Profit') {{ getCurrencySymbol() }}{{ shortAmount($calculateAmount)}}</span>
                                @else
                                    <span class="text-danger">@lang('Admin Loss') {{ getCurrencySymbol() }}{{ abs(shortAmount($calculateAmount)) }}</span>
                                @endif
                            @elseif($dbColumn == 'is_reinvest')
                                @if($row->is_reinvest)
                                    <span class="badge badge--primary">{{ __('Yes') }}</span>
                                @else
                                    <span class="badge badge--danger">{{ __('No') }}</span>
                                @endif
                            @elseif($dbColumn == 'trade_currency_id')
                                <span> {{ $row->cryptoCurrency->name ?? 'N/A' }} </span>
                            @elseif($dbColumn == 'trade_original_price')
                                <span> ${{ shortAmount($row->original_price) }} </span>
                            @elseif($dbColumn == 'trade_volume')
                                <span class="badge {{ \App\Enums\Trade\TradeVolume::getColor($row->volume) }}">{{ \App\Enums\Trade\TradeVolume::getName($row->volume) }}</span>
                            @elseif($dbColumn == 'trade_outcome')
                                <span class="badge {{ \App\Enums\Trade\TradeOutcome::getColor($row->outcome) }}">{{ \App\Enums\Trade\TradeOutcome::getName($row->outcome) }}</span>
                            @elseif($dbColumn == 'status')
                                <span class="badge {{ $color }}">{{ $name }}</span>
                            @elseif($dbColumn == 'symbol')
                                {{ strtoupper($row->symbol) }}
                            @elseif($dbColumn == 'priority')
                                <span class="badge {{ \App\Enums\TicketPriorityStatus::getColor($row->$dbColumn) }}">{{ \App\Enums\TicketPriorityStatus::getColor($row->$dbColumn) }}</span>
                            @elseif($dbColumn == 'menu_parent_id')
                                <span> {{ optional($row->parent)->name ?? __('N/A') }} </span>
                            @elseif($dbColumn == 'language_action')
                                <div class="d-flex align-items-center justify-content-md-start justify-content-end gap-1">
                                    <a href="javascript:void(0)" class="badge badge--primary-transparent languageUpdateBtn"
                                       data-toggle="modal"
                                       data-target="#languageUpdateModal"
                                       data-id="{{$row->id}}"
                                       data-name="{{$row->name}}"
                                       data-is_default="{{$row->is_default}}"
                                    >{{ __('Edit') }}</a>
                                    @if($row->is_default != \App\Enums\Status::ACTIVE->value)
                                        <a href="javascript:void(0)" class="badge badge--warning-transparent languageDeleteBtn"
                                           data-toggle="modal"
                                           data-target="#languageDeleteModal"
                                           data-id="{{$row->id}}"
                                        >{{ __('Delete') }}</a>
                                    @endif
                                    <a href="{{ route('admin.language.edit', $row->id) }}"
                                       class="badge badge--success-transparent menuDeleteBtn"> {{ __('Translate') }}
                                    </a>
                                </div>
                            @elseif($dbColumn == 'language_is_default')
                                <span class="badge {{ \App\Enums\Status::getColor($row->is_default) }}">{{ \App\Enums\Status::getName($row->is_default, true) }}</span>
                            @elseif($dbColumn == 'menu_action')
                                <div class="d-flex align-items-center justify-content-md-start justify-content-end gap-1">
                                    @if(!$row->is_default)
                                        <a href="{{ route('admin.pages.section.sortable', $row->url) }}" class="badge badge--info-transparent">{{ __('Sections') }}</a>
                                        <a href="javascript:void(0)" class="badge badge--primary-transparent menuUpdateBtn"
                                           data-toggle="modal"
                                           data-target="#menuUpdateModal"
                                           data-id="{{$row->id}}"
                                           data-name="{{$row->name}}"
                                           data-url="{{$row->url}}"
                                           data-parent_id="{{$row->parent_id}}"
                                           data-status="{{$row->status}}"
                                        >{{ __('Edit') }}</a>
                                        <a href="javascript:void(0)"
                                           data-id="{{$row->id}}"
                                           class="badge badge--danger-transparent menuDeleteBtn"> {{ __('Delete') }}
                                        </a>
                                    @else
                                        <span>{{ __('N/A') }}</span>
                                    @endif
                                </div>
                            @elseif($dbColumn == 'action')
                                @php echo $route @endphp
                            @elseif($dbColumn == 'url')
                                {{ $row->url }}
                            @elseif($dbColumn == 'blocked')
                                <span class="badge {{ \App\Enums\Status::getColor($row->blocked) }}">{{ \App\Enums\Status::getName($row->blocked, true) }}</span>
                            @elseif($dbColumn == 'staking_interest')
                               {{ getCurrencySymbol() }}{{ shortAmount($row->interest) }}
                            @elseif($dbColumn == 'staking_total_return')
                                {{ getCurrencySymbol() }}{{ shortAmount($row->amount + $row->interest) }}
                            @elseif($dbColumn == 'staking_total_return')
                                {{ getCurrencySymbol() }}{{ shortAmount($row->amount + $row->interest) }}
                            @elseif($dbColumn == 'upcoming_investment_payment')
                                @if($row->status == \App\Enums\Investment\Status::INITIATED->value)
                                    <div data-profit-time="{{ $row->profit_time }}" class="payment_time"></div>
                                @else
                                    <span class="badge {{ \App\Enums\Status::getColor($row->status) }}">{{ \App\Enums\Status::getName($row->status) }}</span>
                                @endif
                            @elseif($dbColumn == 'user_kyc_status')
                                <span class="badge {{ \App\Enums\User\KycStatus::getColor($row->kyc_status) }}">{{ \App\Enums\User\KycStatus::getName($row->kyc_status) }}</span>
                            @elseif($dbColumn == 'pin_number')
                                {{ $row->pin_number }}  <span class="reference-copy" data-pin="{{ $row->pin_number }}"><i class="las la-copy"></i></span>
                            @else
                                <span>{{ $row->$dbColumn }}</span>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td class="text-muted text-center" colspan="100%">{{ __('No Data Found')}}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">
    {{$rows->appends(request()->all())->links()}}
</div>




