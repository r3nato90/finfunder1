@extends('layouts.user')
@section('content')
    <div class="main-content" data-simplebar>
        <h3 class="page-title">{{ __($setTitle) }}</h3>
        <div class="i-card-sm">
            <div class="row">
                <div class="user-form">
                    <div class="col-lg-12 mb-4">
                        <ul class="list-group">
                             <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Gateway') }}
                                <span class="fw-bold">  {{ $withdrawLog->withdrawMethod->name ?? 'N/A' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Trx') }}
                                <span class="fw-bold">{{ getCurrencySymbol() }}{{shortAmount($withdrawLog->after_charge)}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Rate') }}
                                <span class="fw-bold">{{ getCurrencySymbol() }}1 =  {{shortAmount($withdrawLog->rate)}} {{ $withdrawLog?->withdrawMethod?->currency_name ?? getCurrencyName() }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Withdraw Amount') }}
                                <span class="fw-bold">{{ getCurrencySymbol() }}{{shortAmount($withdrawLog->amount)}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Charge') }}
                                <span class="fw-bold">{{ getCurrencySymbol() }}{{shortAmount($withdrawLog->charge)}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Final Amount') }}
                                <span class="fw-bold">{{ getCurrencySymbol() }}{{shortAmount($withdrawLog->final_amount)}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('After Charge') }}
                                <span class="fw-bold">{{ getCurrencySymbol() }}{{shortAmount($withdrawLog->after_charge)}}</span>
                            </li>
                        </ul>
                    </div>

                    <form method="POST" action="{{route('user.withdraw.success', $uid)}}">
                        @csrf
                        @if(!is_null($withdrawLog?->withdrawMethod->parameter))
                            <div class="row">
                                @foreach($withdrawLog?->withdrawMethod->parameter as $key => $parameter)
                                    <div class="col-lg-12">
                                        <div class="form-inner">
                                            <label for="{{ getArrayValue($parameter,'field_label') }}">{{ __(getArrayValue($parameter,'field_label')) }}</label>
                                            <input type="text" id="{{ getArrayValue($parameter,'field_label') }}" name="{{ getArrayValue($parameter,'field_name') }}" placeholder="{{ __("Enter ". getArrayValue($parameter,'field_label')) }}" required>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div class="col-12">
                            <button type="submit" class="i-btn btn--primary btn--lg">{{ __('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

