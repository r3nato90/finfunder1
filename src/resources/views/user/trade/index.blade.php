@extends('layouts.user')
@section('content')
    <div class="main-content" data-simplebar>
        <div class="row">
            <div class="col-lg-12">
                <div class="i-card-sm mb-4">
                    <div class="card-header">
                        <h4 class="title">{{ __($setTitle) }}</h4>
                    </div>

                    <div class="table-container">
                        <table id="myTable" class="table">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('Pair') }}</th>
                                    <th scope="col">{{ __('Price') }}</th>
                                    <th scope="col">{{ __('Market Cap') }}</th>
                                    <th scope="col">{{ __('Daily High') }}</th>
                                    <th scope="col">{{ __('Daily Low') }}</th>
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($cryptoCurrency as $key => $crypto)
                                <tr>
                                    <td data-label="{{ __('Pair') }}">
                                        <div class="name d-flex align-items-center justify-content-md-start justify-content-end gap-lg-3 gap-2">
                                            <div class="icon">
                                                <img src="{{ $crypto->file }}" class="avatar--sm" alt="{{ __('Crypto-Image') }}">
                                            </div>
                                            <div class="content">
                                                <h6 class="fs-14">{{ $crypto->pair }}</h6>
                                                <span class="fs-13 text--light">{{ $crypto->name }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="{{ __('Price') }}">
                                        ${{ getArrayValue($crypto->meta, 'current_price') }}
                                    </td>
                                    <td data-label="{{ __('Market Cap') }}">
                                        {{ getArrayValue($crypto->meta, 'market_cap') }}
                                    </td>
                                    <td data-label="{{ __('Daily High') }}">
                                        {{ getArrayValue($crypto->meta, 'high_24h') }} %
                                    </td>
                                    <td data-label="{{ __('Daily Low') }}">
                                        {{ getArrayValue($crypto->meta, 'low_24h') }} %
                                    </td>
                                    <td data-label="{{ __('Action') }}">
                                        @if (getArrayValue($setting->system_configuration, 'binary_trade.value') == \App\Enums\Status::ACTIVE->value)
                                            <a href="{{ route('user.trade.binary', $crypto->crypto_id) }}" class="i-btn btn--sm btn--primary capsuled">{{ __('Trade') }}</a>
                                        @endif
                                        @if (getArrayValue($setting->system_configuration, 'practice_trade.value') == \App\Enums\Status::ACTIVE->value)
                                            <a href="{{ route('user.trade.practice', $crypto->crypto_id) }}" class="i-btn btn--sm btn--primary-outline capsuled">{{ __('Practice') }}</a>
                                        @endif
                                        @if (getArrayValue($setting->system_configuration, 'binary_trade.value') != \App\Enums\Status::ACTIVE->value && getArrayValue($setting->system_configuration, 'practice_trade.value') != \App\Enums\Status::ACTIVE->value)
                                            <span>{{ __('N/A') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $cryptoCurrency->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection


