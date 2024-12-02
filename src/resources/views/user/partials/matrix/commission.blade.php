<div class="filter-area">
    <form action="{{ $route }}">
        <div class="row row-cols-lg-3 row-cols-md-4 row-cols-sm-2 row-cols-1 g-3">
            <div class="col">
                <input type="text" name="search" placeholder="{{ __('Trx ID') }}" value="{{ request()->get('search') }}">
            </div>
            <div class="col">
                <input type="text" id="date" class="form-control datepicker-here" name="date"
                   value="{{ request()->get('date') }}" data-range="true" data-multiple-dates-separator=" - "
                   data-language="en" data-position="bottom right" autocomplete="off"
                   placeholder="{{ __('Date') }}">
            </div>
            <div class="col">
                <button type="submit" class="i-btn btn--lg btn--primary w-100"><i class="bi bi-search me-3"></i>{{ __('Search') }}</button>
            </div>
        </div>
    </form>
</div>

<div class="table-container">
    <table id="myTable" class="table">
        <thead>
            <tr>
                <th scope="col">{{ __('Initiated At') }}</th>
                <th scope="col">{{ __('Trx') }}</th>
                @if($type != \App\Enums\CommissionType::INVESTMENT->value)
                    <th scope="col">{{ __('User') }}</th>
                @endif
                <th scope="col">{{ __('Amount') }}</th>
                <th scope="col">{{ __('Details') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($commissions as $key => $commission)
                <tr>
                    <td data-label="{{ __('Initiated At') }}">
                        {{ showDateTime($commission->created_at) }}
                    </td>
                    <td data-label="{{ __('Trx') }}">
                        {{ $commission->trx }}
                    </td>
                    @if($type != \App\Enums\CommissionType::INVESTMENT->value)
                        <td data-label="{{ __('User') }}">
                            {{ $commission->fromUser->email }}
                        </td>
                    @endif
                    <td data-label="{{ __('Amount') }}">
                        {{ getCurrencySymbol() }}{{ shortAmount($commission->amount) }}
                    </td>
                    <td data-label="{{ __('Details') }}">
                        {{ $commission->details }}
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
