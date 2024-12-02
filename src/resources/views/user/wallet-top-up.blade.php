@extends('layouts.user')
@section('content')
    <div class="main-content" data-simplebar>
        <div class="i-card-sm p-3 mb-4">
            <div class="row g-3">
                <div class="col-lg-4 col-md-6">
                    <div class="i-card-sm style-2 bg--dark shadow-none rounded-2">
                        <span class="text--light">{{ __('Primary Balance') }}</span><span class="text-white fw-bold">{{ getCurrencySymbol() }}{{shortAmount(Auth::user()->wallet->primary_balance)}}</span>
                    </div>
                </div>
                @if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::INVESTMENT->name)) == \App\Enums\Status::ACTIVE->value)
                    <div class="col-lg-4 col-md-6">
                        <div class="i-card-sm style-2 bg--dark shadow-none rounded-2">
                            <span class="text--light">{{ __('Investment Balance') }}</span> <span class="text-white fw-bold"> {{ getCurrencySymbol() }}{{shortAmount(Auth::user()->wallet->investment_balance)}}</span>
                        </div>
                    </div>
                @endif

                @if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::TRADE_PREDICTION->name)) == \App\Enums\Status::ACTIVE->value)
                    <div class="col-lg-4 col-md-6">
                        <div class="i-card-sm style-2 bg--dark shadow-none rounded-2">
                            <span class="text--light">{{ __('Trade Balance') }}</span> <span class="text-white fw-bold">{{ getCurrencySymbol() }}{{shortAmount(Auth::user()->wallet->trade_balance)}}</span>
                        </div>
                    </div>
                @endif


                @php
                    $investmentIsActive= false;
                    $stakingInvestmentIsActive = false;
                    $tradeIsActive = false;
                    if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::STAKING_INVESTMENT->name)) == \App\Enums\Status::ACTIVE->value){
                        $investmentIsActive = true;
                    }
                    if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::INVESTMENT->name)) == \App\Enums\Status::ACTIVE->value){
                        $investmentIsActive = true;
                    }
                    if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::TRADE_PREDICTION->name)) == \App\Enums\Status::ACTIVE->value){
                        $tradeIsActive = true;
                    }
                @endphp
            </div>
        </div>
        <div class="row">
            @if($investmentIsActive || $tradeIsActive || $stakingInvestmentIsActive)
                <div class="col-lg-6">
                    <div class="i-card-sm mb-4">
                        <div class="card-header">
                            <h4 class="fs-17 border--left mb-4">{{ __("Transfer the balance from your trade and investment account to your primary account, and subsequently initiate a withdrawal of your balance.")}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center gy-4">
                                <div class="user-form">
                                    <form method="POST" action="{{ route('user.wallet.transfer.own-account') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-inner">
                                                    <label for="account">{{ __('Account') }}</label>
                                                    <select id="account" name="account" required>
                                                        <option value="">{{ __('Select One') }}</option>
                                                        @if($investmentIsActive || $stakingInvestmentIsActive)
                                                            <option value="{{ \App\Enums\Transaction\WalletType::INVESTMENT->value }}">{{ \App\Enums\Transaction\WalletType::INVESTMENT->name  }}</option>
                                                        @endif
                                                        @if($tradeIsActive)
                                                            <option value="{{ \App\Enums\Transaction\WalletType::TRADE->value }}">{{ \App\Enums\Transaction\WalletType::TRADE->name  }}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-inner">
                                                    <label for="amount">{{ __('Amount') }}</label>
                                                    <input type="number" id="amount" name="amount" placeholder="{{ __('Enter Amount') }}" required>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <button type="submit" class="i-btn btn--primary btn--lg">{{ __('Save') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-lg-6">
                <div class="i-card-sm">
                    <div class="card-header">
                        <h4 class="fs-17 border--left mb-4">{{ __("Transfer the balance from your primary account to other users.") }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center gy-4">
                            @if(getArrayValue($setting->system_configuration, 'balance_transfer.value') == \App\Enums\Status::ACTIVE->value)
                                <div class="user-form">
                                    <form method="POST" action="{{ route('user.wallet.transfer.other-account') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-inner">
                                                    <label for="user">{{ __('User') }} ({{ __('Check the dashboard for UID if not found.') }})</label>
                                                    <input type="text" id="user" class="find-user" name="uuid" placeholder="Enter User UID" required>
                                                    <span class="user-message text-danger"></span>
                                                    <span class="user-success-message text-success"></span>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-inner">
                                                    <label for="amount">{{ __('Amount') }}</label>
                                                    <input type="number" id="amount" name="amount" placeholder="{{ __('Enter Amount') }}" required>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <button type="submit" class="i-btn btn--primary btn--lg">{{ __('Save') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @else
                                <p>{{ __('Balance Transfer Currently Unavailable') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-push')
    <script>
        $('.find-user').on('focusout', function(e) {
            const url = '{{ route('user.find.user') }}';
            const uuid = $(this).val();
            const token = '{{ csrf_token() }}';

            const data = {
                uuid: uuid,
                _token: token
            };

            $.get(url, data, function(response) {
                if (response.status) {
                    $('.user-message').text(response.message);
                } else {
                    $('.user-success-message').text(response.message);
                }
            });
        });
    </script>
@endpush
