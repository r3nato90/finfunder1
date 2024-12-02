@extends('layouts.user')
@section('content')
    <div class="main-content" data-simplebar>
        <div class="row">
            <div class="col-lg-12">
                <div class="i-card-sm mb-4">
                    <div class="card-header">
                        <h4 class="title">{{ __($setTitle) }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @foreach($gateways as $key => $gateway)
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                    <div class="i-card-sm card--dark shadow-none rounded-3">
                                        <div class="row justify-content-between align-items-center g-lg-2 g-1">
                                            <div class="col-12">
                                                <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3 gap-3" >
                                                    <h5 class="title-sm mb-0">{{ __($gateway->name) }}</h5>
                                                    @if($gateway->type == \App\Enums\Payment\GatewayType::MANUAL->value)
                                                        <button class="gateway-details"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#paymentDetailsModal"
                                                                data-details="{{ $gateway->details }}"
                                                        ><i class="bi bi-info-square-fill"></i></button>
                                                    @endif
                                                </div>

                                            </div>
                                            <div class="col-lg-5 col-md-5 col-sm-5">
                                                <img src="{{ displayImage($gateway->file) }}" class="mxw-80" alt="Vector">
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-7 text-end">
                                                <button class="i-btn btn--primary btn--md capsuled deposit-process"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal"
                                                        data-name="{{ $gateway->name }}"
                                                        data-code="{{ $gateway->code }}"
                                                        data-minimum="{{getCurrencySymbol()}}{{ shortAmount($gateway->minimum) }}"
                                                        data-maximum="{{getCurrencySymbol()}}{{ shortAmount($gateway->maximum) }}"
                                                >{{ __('Deposit Now') }}<i class="bi bi-box-arrow-up-right ms-2"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="i-card-sm">
                    <div class="card-header">
                        <h4 class="title">{{ __('Deposit Logs') }}</h4>
                    </div>

                    <div class="filter-area">
                        <form action="{{ route('user.payment.index') }}">
                            <div class="row row-cols-lg-4 row-cols-md-4 row-cols-sm-2 row-cols-1 g-3">
                                <div class="col">
                                    <input type="text" name="search" placeholder="{{ __('Trx ID') }}" value="{{ request()->get('search') }}">
                                </div>
                                <div class="col">
                                    <select class="select2-js" name="status" >
                                        @foreach (App\Enums\Payment\Deposit\Status::cases() as $status)
                                            @unless($status->value == App\Enums\Payment\Deposit\Status::INITIATED->value)
                                                <option value="{{ $status->value }}" @if($status->value == request()->status) selected @endif>{{ $status->name  }}</option>
                                            @endunless
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
                                        <th scope="col">{{ __('Gateway') }}</th>
                                        <th scope="col">{{ __('Amount') }}</th>
                                        <th scope="col">{{ __('Charge') }}</th>
                                        <th scope="col">{{ __('Final Amount') }}</th>
                                        <th scope="col">{{ __('Crypto Payment') }}</th>
                                        <th scope="col">{{ __('Wallet') }}</th>
                                        <th scope="col">{{ __('Status') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($deposits as $key => $deposit)
                                        <tr>
                                            <td data-label="{{ __('Initiated At') }}">
                                                {{ showDateTime($deposit->created_at) }}
                                            </td>
                                            <td data-label="{{ __('Trx') }}">
                                                {{ $deposit->trx }}
                                            </td>
                                            <td data-label="{{ __('Gateway') }}">
                                                {{ $deposit?->gateway?->name ?? 'N/A' }}
                                            </td>
                                            <td data-label="{{ __('Amount') }}">
                                                {{ getCurrencySymbol() }}{{ shortAmount($deposit->amount) }}
                                            </td>
                                            <td data-label="{{ __('Charge') }}">
                                                {{ getCurrencySymbol() }}{{ shortAmount($deposit->charge) }}
                                            </td>
                                            <td data-label="{{ __('Final Amount') }}">
                                                {{ getCurrencySymbol() }}{{ shortAmount($deposit->final_amount) }}
                                            </td>

                                            <td data-label="{{ __('Crypto') }}">
                                                @if($deposit->is_crypto_payment)
                                                    <a href="javascript:void(0)" class="i-badge badge--primary show-crypto-info"
                                                       data-bs-toggle="modal"
                                                       data-bs-target="#cryptoInfoModal"
                                                       data-address="{{ getArrayValue($deposit->crypto_meta, 'payment_info.pay_address') ?? 'N/A' }}"
                                                       data-amount="{{ getArrayValue($deposit->crypto_meta, 'payment_info.price_amount') ?? 'N/A' }}"
                                                       data-network="{{ strtoupper(getArrayValue($deposit->crypto_meta, 'payment_info.network')) ?? 'N/A' }}"
                                                       data-image="{{ getArrayValue($deposit->crypto_meta, 'image') ?? 'N/A' }}"
                                                       data-price_amount="{{ getArrayValue($deposit->crypto_meta, 'payment_info.price_amount'). ' '. strtoupper(getArrayValue($deposit->crypto_meta, 'payment_info.price_currency')) ?? 'N/A' }}"
                                                       data-crypto_amount="{{ getArrayValue($deposit->crypto_meta, 'payment_info.pay_amount'). ' '. strtoupper(getArrayValue($deposit->crypto_meta, 'payment_info.pay_currency')) ?? 'N/A' }}"
                                                    >
                                                        {{ __('Crypto Info') }}
                                                    </a>
                                                @else
                                                    <span>{{ __('N/A') }}</span>
                                                @endif
                                            </td>
                                            <td data-label="{{ __('Wallet') }}">
                                                {{ __(\App\Enums\Transaction\WalletType::getWalletName($deposit->wallet_type)) }}
                                            </td>
                                            <td data-label="{{ __('Status') }}">
                                                <span class="i-badge {{ App\Enums\Payment\Deposit\Status::getColor($deposit->status)}}">{{ App\Enums\Payment\Deposit\Status::getName($deposit->status)}}</span>
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
                </div>

                <div class="mt-4">
                    {{ $deposits->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg--dark">
                    <h5 class="modal-title" id="gatewayTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('user.payment.process') }}">
                    @csrf
                    <input type="hidden" name="code" value="">
                    <div class="modal-body">
                        <h6 id="paymentLimitTitle" class="mb-1 mt-1 text-center"></h6>
                        <div class="mb-3" id="currency-container" style="display: none;">
                            <select name="currency" id="currency" class="form-control">
                                @foreach (getCryptoOptions() as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="col-form-label">{{ __('Amount') }}</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="amount" name="amount" placeholder="{{ __('Enter Amount') }}" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2">{{ getCurrencyName() }}</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="col-form-label">{{ __('Wallet') }}</label>
                            <select class="form-control" name="wallet" >
                                @foreach (App\Enums\Transaction\WalletType::cases() as $status)
                                    @unless($status->value == \App\Enums\Transaction\WalletType::PRACTICE->value)
                                        <option value="{{ $status->value }}">{{ \App\Enums\Transaction\WalletType::getWalletName($status->value) }}</option>
                                    @endunless
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="i-btn btn--light btn--md" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="i-btn btn--primary btn--md">{{ __('Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="paymentDetailsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg--dark">
                    <h5 class="modal-title">{{ __('Payment Details') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="payment-details"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cryptoInfoModal" tabindex="-1" aria-labelledby="cryptoInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cryptoInfoModalLabel">{{ __('Crypto Information') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>{{ __('Pay Address') }}:</strong> <span id="cryptoAddress"></span></p>
                    <p><strong>{{ __('Price Amount') }}:</strong> <span id="priceAmount"></span></p>
                    <p><strong>{{ __('Crypto Amount') }}:</strong> <span id="cryptoCryptoAmount"></span></p>
                    <p><strong>{{ __('Network') }}:</strong> <span id="network"></span></p>
                    <p><strong>{{ __('Pay Image') }}:</strong> <img id="cryptoPayImage" alt="Crypto Pay Image"  /></p>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script-push')
    <script>
        "use strict";
        $(document).ready(function() {
            $('.deposit-process').click(function() {
                const name = $(this).data('name');
                const code = $(this).data('code');
                const minimum = $(this).data('minimum');
                const maximum = $(this).data('maximum');
                $('input[name="code"]').val(code);

                const gatewayTitle = "Deposit with " + name + " now";
                const paymentLimit = `Deposit Amount Limit ${minimum} - ${maximum}`;
                $('#paymentLimitTitle').text(paymentLimit);
                $('#gatewayTitle').text(gatewayTitle);

                if (code == "{{ \App\Enums\Payment\GatewayCode::NOW_PAYMENT->value }}") {
                    $("#currency-container").show();
                } else {
                    $("#currency-container").hide();
                }
            });

            $('.gateway-details').click(function (){
                const details = $(this).data('details');
                $('.payment-details').empty();
                $('.payment-details').append(details);
            });
        });


        $('.show-crypto-info').click(function() {
            const address = $(this).data('address');
            const cryptoAmount = $(this).data('crypto_amount');
            const priceAmount = $(this).data('price_amount');
            const network = $(this).data('network');
            const image = $(this).data('image');

            $('#cryptoAddress').text(address);
            $('#cryptoCryptoAmount').text(cryptoAmount);
            $('#priceAmount').text(priceAmount);
            $('#network').text(network);
            $('#cryptoPayImage').attr('src', image);

        });
    </script>
@endpush
