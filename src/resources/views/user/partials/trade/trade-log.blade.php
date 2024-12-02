<div class=" scroll-design">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>{{ __('Initiated At') }}</th>
                    <th>{{ __('Amount') }}</th>
                    <th>{{ __('Volume') }}</th>
                    <th>{{ __('Price') }}</th>
                    <th>{{ __('Type') }}</th>
                    <th>{{ __('Outcome') }}</th>
                </tr>
            </thead>
            <tbody>
            @forelse($tradeLogs as $tradeKey => $tradeLog)
                <tr>
                    <td data-label="Initiated At">{{ diffForHumans($tradeLog->created_at) }}</td>
                    <td data-label="{{ __('Amount') }}">
                        @if($tradeLog->outcome == \App\Enums\Trade\TradeOutcome::WIN->value)
                            {{ getCurrencySymbol() }}{{ shortAmount($tradeLog->amount) }}
                            +
                            {{ getCurrencySymbol() }}{{ shortAmount($tradeLog->winning_amount) }}
                            =
                            {{ getCurrencySymbol() }}{{ shortAmount($tradeLog->amount + $tradeLog->winning_amount) }}
                        @elseif($tradeLog->outcome == \App\Enums\Trade\TradeOutcome::LOSE->value)
                           {{ getCurrencySymbol() }}{{ shortAmount($tradeLog->amount) }}
                        @else
                            {{ getCurrencySymbol() }}{{ shortAmount($tradeLog->amount) }}
                        @endif
                    </td>
                    <td data-label="Volume">
                        <span class="i-badge {{ \App\Enums\Trade\TradeVolume::getColor($tradeLog->volume) }}">
                            {{ \App\Enums\Trade\TradeVolume::getName($tradeLog->volume) }}
                        </span>
                    </td>
                    <td data-label="Price">${{ shortAmount($tradeLog->original_price) }}</td>
                    <td data-label="Outcome">
                        <span class="i-badge {{ \App\Enums\Trade\TradeType::getColor($tradeLog->type) }}">{{ \App\Enums\Trade\TradeType::getName($tradeLog->type) }}</span>
                    </td>
                    <td data-label="Outcome">
                        <span class="i-badge {{ \App\Enums\Trade\TradeOutcome::getColor($tradeLog->outcome) }}">{{ \App\Enums\Trade\TradeOutcome::getName($tradeLog->outcome) }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-white text-center" colspan="100%">{{ __('No Data Found')}}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
