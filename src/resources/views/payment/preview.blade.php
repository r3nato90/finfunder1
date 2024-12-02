@extends('layouts.user')
@section('content')
    <div class="main-content" data-simplebar>
        <h3 class="page-title">{{ __($setTitle) }}</h3>
        <div class="i-card-sm">
            <div class="row">
                <div class="user-form">
                    <h5 class="card-header text-center text-white">{{ __('Payment Details') }}</h5>
                    <div class="card-body mb-4 mt-2 text-white">
                        @php echo $gateway->details ?? '' @endphp
                    </div>
                    @if($gateway->type == \App\Enums\Payment\GatewayType::AUTOMATIC->value && $gateway->code == \App\Enums\Payment\GatewayCode::BLOCK_CHAIN->value)
                        <div class="card-body card-body-deposit text-center">
                            <h4 class="my-2"> @lang('PLEASE SEND EXACTLY') <span class="text-success"> {{ $payment->btc_amount }}</span> @lang('BTC')</h4>
                            <h5 class="mb-2">@lang('TO') <span class="text-success"> {{ $payment->btc_wallet ?? '' }}</span></h5>
                            <img src="{{ cryptoQRCode($payment->btc_wallet ?? '') }}" alt="@lang('Image')">
                            <h4 class="text-white bold my-4">@lang('SCAN TO SEND')</h4>
                        </div>
                    @endif

                    @if($gateway->type == \App\Enums\Payment\GatewayType::MANUAL->value)
                        <div class="col-lg-12 mb-4">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ __('Rate') }}
                                    <span>{{ getCurrencySymbol() }}1 =  {{shortAmount($payment->rate)}} {{ $gateway->currency ?? getCurrencyName() }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ __('Deposit Amount') }}
                                    <span>{{ getCurrencySymbol() }}{{shortAmount($payment->amount)}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ __('Charge') }}
                                    <span>{{ getCurrencySymbol() }}{{shortAmount($payment->charge)}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ __('Final Amount') }}
                                    <span>{{ getCurrencySymbol() }}{{shortAmount($payment->final_amount)}}</span>
                                </li>
                            </ul>
                        </div>

                        <form method="POST" action="{{ route('user.payment.traditional') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="payment_intent" value="{{ $payment->trx }}">
                            <input type="hidden" name="gateway_code" value="{{ $gateway->code }}">
                            <div class="row">
                                @foreach($gateway->parameter as $key => $parameter)
                                    @php
                                        $parameter = is_array($parameter) ? $parameter : [];
                                    @endphp
                                    <div class="col-lg-12">
                                        <div class="form-inner">
                                            <label for="{{ getArrayValue($parameter,'field_label') }}">{{ __(getArrayValue($parameter,'field_label')) }}</label>
                                            @if(getArrayValue($parameter,'field_type') == 'file')
                                                <input type="file" id="{{ getArrayValue($parameter,'field_label') }}" name="{{ getArrayValue($parameter,'field_name') }}" required>
                                            @elseif(getArrayValue($parameter,'field_type') == 'text')
                                                <input type="text" id="{{ getArrayValue($parameter,'field_label') }}" name="{{ getArrayValue($parameter,'field_name') }}" placeholder="{{ __("Enter ". getArrayValue($parameter,'field_label')) }}" required>
                                            @elseif(getArrayValue($parameter,'field_type') == 'textarea')
                                                <textarea id="{{ getArrayValue($parameter,'field_label') }}" name="{{ getArrayValue($parameter,'field_name') }}" placeholder="{{ __("Enter ". getArrayValue($parameter,'field_label')) }}" required></textarea>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-12">
                                <button type="submit" class="i-btn btn--primary btn--lg">{{ __('Save') }}</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

