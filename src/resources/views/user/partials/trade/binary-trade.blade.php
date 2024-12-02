<div class="d-flex align-items-center justify-content-between gap-3 mb-3">
    <div class="card--title mb-0">
        <h5 class="mb-0">{{ __('Rise/Fall') }}</h5>
    </div>
    <a href="{{ route('user.dashboard') }}" class="i-btn btn--primary btn--md capsuled"><i class="bi bi-chevron-left me-1"></i>{{ __('Dashboard') }}</a>
</div>
<div class="market-widget mb-4">
    <form method="POST" action="{{ route('user.trade.store', $crypto->id) }}">
        @csrf
        <input type="hidden" value="{{ request()->routeIs('user.trade.practice') ? \App\Enums\Trade\TradeType::PRACTICE->value : \App\Enums\Trade\TradeType::TRADE->value }}" name="type">
        <div class="input-single">
            <label for="amount">{{ __('Amount') }}</label>
            <input type="text" id="amount" name="amount" value="{{ old('amount') }}" placeholder="0.00" required>
        </div>

        <div class="input-single">
            <label for="parameter">{{ __('Expiry Time') }}</label>
            <select type="text" id="parameter" name="parameter_id" required>
                <option value="">{{ __('Select Expiration Time') }}</option>
                @foreach($parameters as $key => $parameter)
                    <option value="{{ $parameter->id }}">
                        {{ __('Time') }}: {{$parameter->time.' ' .\App\Enums\Trade\TradeParameterUnit::getName($parameter->unit) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="profit-card">
            <div class="percent">
                <span id="profit_amount">+0.00</span>
                <sub> / {{ getArrayValue($setting->commissions_charge, 'binary_trade_commissions', 0) }} %</sub>
            </div>
            <p>{{ __('Profit') }}</p>
        </div>
        <div class="d-flex justify-content-center align-items-center gap-3">
            <button type="submit" name="volume" value="{{ \App\Enums\Trade\TradeVolume::HIGH->value }}" class="i-btn btn--md btn--success capsuled w-100">{{ __(\App\Enums\Trade\TradeVolume::getName(\App\Enums\Trade\TradeVolume::HIGH->value)) }} <i class="bi bi-arrow-up"></i></button>
            <button type="submit" name="volume" value="{{ \App\Enums\Trade\TradeVolume::LOW->value }}" class="i-btn btn--md btn--danger capsuled w-100">{{ __(\App\Enums\Trade\TradeVolume::getName(\App\Enums\Trade\TradeVolume::LOW->value)) }} <i class="bi bi-arrow-down"></i></button>
        </div>
    </form>
</div>
