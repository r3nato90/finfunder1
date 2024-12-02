<div class="table-container">
    <table id="myTable" class="table">
        <thead>
        <tr>
            <th scope="col">{{ __('Name') }}</th>
            <th scope="col">{{ __('Pair Price') }}</th>
            <th scope="col">{{ __('Daily Change') }}</th>
            <th scope="col">{{ __('Daily High') }}</th>
            <th scope="col">{{ __('Daily Low') }}</th>
            <th scope="col">{{ __('Total Volume') }}</th>
            <th scope="col">{{ __('Market Cap') }}</th>
            <th scope="col">{{ __('Total Supply') }}</th>
            <th scope="col">{{ __('Action') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($currencyExchanges as $exchange)
            <tr>
                <td data-label="{{ __('Name') }}">
                    <a href="{{ route('user.trade.binary', $exchange->crypto_id) }}" class="our-currency-item">
                        <div class="name d-flex gap-2">
                            <div class="avatar--md">
                                <img src="{{ $exchange->file }}" alt="{{ __($exchange->name) }}">
                            </div>
                            <div class="content">
                                <h5>{{ __($exchange->name) }}</h5>
                                <span>{{ strtoupper($exchange->symbol)  }} {{ __('Coin') }}</span>
                            </div>
                        </div>
                    </a>
                </td>
                <td data-label="{{ __('Pair Price') }}">
                    <div class="amount">
                        {{ getCurrencySymbol() }}{{ getArrayValue($exchange->meta, 'current_price') }}
                    </div>
                </td>
                <td data-label="{{ __('Daily Change') }}">
                    <div class="rate">
                        <p>{{ shortAmount(getArrayValue($exchange->meta, 'price_change_24h')) }}%</p>
                    </div>
                </td>
                <td data-label="{{ __('Daily High') }}">
                    <div class="high">
                        <p>{{ shortAmount(getArrayValue($exchange->meta, 'high_24h')) }}%</p>
                    </div>
                </td>
                <td data-label="{{ __('Daily Low') }}">
                    <div class="low">
                        <p>{{ shortAmount(getArrayValue($exchange->meta, 'low_24h')) }}%</p>
                    </div>
                </td>
                <td data-label="{{ __('Total Volume') }}">
                    <div class="total_volume">
                        <p>{{ shortAmount(getArrayValue($exchange->meta, 'total_volume')) }}%</p>
                    </div>
                </td>
                <td data-label="{{ __('Market Cap') }}">
                    <div class="total_volume">
                        <p>{{ shortAmount(getArrayValue($exchange->meta, 'market_cap')) }}</p>
                    </div>
                </td>
                <td data-label="{{ __('Total Supply') }}">
                    <div class="total_volume">
                        <p>{{ shortAmount(getArrayValue($exchange->meta, 'total_supply')) }}</p>
                    </div>
                </td>

                <td data-label="{{ __('Action') }}">
                    @if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::TRADE_PREDICTION->name)) == 1)
                        <div class="action">
                            @if (getArrayValue($setting->system_configuration, 'binary_trade.value') == \App\Enums\Status::ACTIVE->value)
                                <a href="{{ route('user.trade.binary', $exchange->crypto_id) }}" class="i-btn btn--sm btn--primary-outline capsuled">{{ __('Trade') }}</a>
                            @endif
                            @if (getArrayValue($setting->system_configuration, 'practice_trade.value') == \App\Enums\Status::ACTIVE->value)
                                <a href="{{ route('user.trade.practice', $exchange->crypto_id) }}" class="i-btn btn--sm btn--lite--secondary capsuled">{{ __('Practice') }}</a>
                            @endif
                            @if (getArrayValue($setting->system_configuration, 'binary_trade.value') != \App\Enums\Status::ACTIVE->value && getArrayValue($setting->system_configuration, 'practice_trade.value') != \App\Enums\Status::ACTIVE->value)
                                <span>{{ __('N/A') }}</span>
                            @endif
                        </div>
                    @else
                        <span>{{ __('N/A') }}</span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
