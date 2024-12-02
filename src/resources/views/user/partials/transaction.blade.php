<div class="filter-area">
    <form action="{{ route('user.transaction') }}">
        <div class="row row-cols-lg-4 row-cols-md-4 row-cols-sm-2 row-cols-1 g-3">
            <div class="col">
                <input type="text" name="search" placeholder="{{ __('Trx ID') }}" value="{{ request()->get('search') }}">
            </div>
            <div class="col">
                <select class="select2-js" name="wallet_type" >
                    @foreach (App\Enums\Transaction\WalletType::cases() as $status)
                        @unless($status->value == App\Enums\Transaction\WalletType::PRACTICE->value)
                            <option value="{{ $status->value }}" @if($status->value == request()->wallet_type) selected @endif>{{ $status->name  }}</option>
                        @endunless
                    @endforeach
                </select>
            </div>
            <div class="col">
                <select class="select2-js" name="source" >
                    @foreach (App\Enums\Transaction\Source::cases() as $source)
                        <option value="{{ $source->value }}" @if($source->value == request()->source) selected @endif>{{ $source->name  }}</option>
                    @endforeach
                </select>
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

<div class="card-body">
    <div class="row align-items-center gy-4 mb-3">
        <div class="table-container">
            <table id="myTable" class="table">
                <thead>
                    <tr>
                        <th scope="col">{{ __('Initiated At') }}</th>
                        <th scope="col">{{ __('Trx') }}</th>
                        <th scope="col">{{ __('Amount') }}</th>
                        <th scope="col">{{ __('Post Balance') }}</th>
                        <th scope="col">{{ __('Charge') }}</th>
                        <th scope="col">{{ __('Source') }}</th>
                        <th scope="col">{{ __('Wallet') }}</th>
                        <th scope="col">{{ __('Details') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $key => $item)
                        <tr>
                            <td data-label="{{ __('Initiated At') }}">{{ showDateTime($item->created_at) }}</td>
                            <td data-label="{{ __('Trx') }}">{{ $item->trx }}</td>
                            <td data-label="{{ __('Amount') }}">
                                <span class="text--{{ \App\Enums\Transaction\Type::getTextColor((int)$item->type) }}">
                                   {{ getCurrencySymbol() }}{{ shortAmount($item->amount) }}
                                </span>
                            </td>
                            <td data-label="{{ __('Post Balance') }}"> {{ \App\Enums\Transaction\WalletType::getName((int)$item->wallet_type) }} : {{ getCurrencySymbol() }}{{ shortAmount($item->post_balance) }}</td>
                            <td data-label="{{ __('Charge') }}">{{ getCurrencySymbol() }}{{ shortAmount($item->charge) }}</td>
                            <td data-label="{{ __('Source') }}">
                                <span class="i-badge {{ \App\Enums\Transaction\Source::getColor((int)$item->source) }}">
                                    {{ \App\Enums\Transaction\Source::getName((int)$item->source) }}
                                </span>
                            </td>
                            <td data-label="{{ __('Wallet') }}">
                                <span class="i-badge {{ \App\Enums\Transaction\WalletType::getColor((int)$item->wallet_type) }}">
                                    {{ \App\Enums\Transaction\WalletType::getWalletName((int)$item->wallet_type) }}
                                </span>
                            </td>
                            <td data-label="{{ __('Details') }}">
                                {{ $item->details }}
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
</div>

@if($is_paginate)
    <div class="mt-4">{{ $transactions->links() }}</div>
@endif



