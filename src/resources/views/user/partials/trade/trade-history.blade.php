<table id="myTable" class="table">
    <thead>
        <tr>
            <th scope="col">{{ __('Initiated At') }}</th>
            <th scope="col">{{ __('Crypto') }}</th>
            <th scope="col">{{ __('Price') }}</th>
            <th scope="col">{{ __('Amount') }}</th>
            <th scope="col">{{ __('Arrival Time') }}</th>
            <th scope="col">{{ __('Volume') }}</th>
            <th scope="col">{{ __('Outcome') }}</th>
            <th scope="col">{{ __('Status') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse($tradeLogs as $key => $tradeLog)
            <tr>
                <td data-label="{{ __('Initiated At') }}">
                    {{ showDateTime($tradeLog->created_at) }}
                </td>
                <td data-label="{{ __('Crypto') }}">
                    {{ $tradeLog->cryptoCurrency->name }}
                </td>
                <td data-label="Price">
                    ${{ shortAmount($tradeLog->original_price) }}
                </td>
                <td data-label="{{ __('Amount') }}">
                    @if($tradeLog->outcome == \App\Enums\Trade\TradeOutcome::WIN->value)
                        {{ getCurrencySymbol() }}{{ shortAmount($tradeLog->amount) }}
                        +
                        {{ getCurrencySymbol() }}{{ shortAmount($tradeLog->winning_amount) }}
                        =
                        <span class="text--success">
                            {{ getCurrencySymbol() }}{{ shortAmount($tradeLog->amount + $tradeLog->winning_amount) }}
                        </span>
                    @elseif($tradeLog->outcome == \App\Enums\Trade\TradeOutcome::LOSE->value)
                        <span class="text--danger">{{ getCurrencySymbol() }}{{ shortAmount($tradeLog->amount) }}</span>
                    @else
                        <span class="text--primary">{{ getCurrencySymbol() }}{{ shortAmount($tradeLog->amount) }}</span>
                    @endif
                </td>
                <td data-label="{{ __('Arrival Time') }}">
                    {{ showDateTime($tradeLog->arrival_time) }}
                </td>
                <td data-label="{{ __('Volume') }}">
                    <span class="i-badge {{ \App\Enums\Trade\TradeVolume::getColor($tradeLog->volume) }}">
                     {{ \App\Enums\Trade\TradeVolume::getName($tradeLog->volume) }}
                    </span>
                </td>
                <td data-label="{{ __('Outcome') }}">
                     <span class="i-badge {{ \App\Enums\Trade\TradeOutcome::getColor($tradeLog->outcome) }}">
                         {{ \App\Enums\Trade\TradeOutcome::getName($tradeLog->outcome) }}
                    </span>
                </td>
                <td data-label="{{ __('Status') }}">
                     <span class="i-badge {{ \App\Enums\Trade\TradeStatus::getColor($tradeLog->status) }}">
                         {{ \App\Enums\Trade\TradeStatus::getName($tradeLog->status) }}
                    </span>
                </td>
            </tr>
        @empty
            <tr>
                <td class="text-white text-center" colspan="100%">{{ __('No Data Found')}}</td>
            </tr>
        @endforelse
    </tbody>
</table>
