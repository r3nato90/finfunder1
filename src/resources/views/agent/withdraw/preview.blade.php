@extends('agent.layouts.main')
@section('panel')
    <section>
        <h3 class="page-title">{{ __($setTitle) }}</h3>
        <div class="card  p-4">
            <div class="row">
                <div class="col-lg-12 mb-4"> <!-- Use col-lg-12 for proper column sizing -->
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('Gateway') }}
                            <span class="fw-bold">{{ $withdrawLog->withdrawMethod->name ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('Trx') }}
                            <span class="fw-bold">{{ getCurrencySymbol() }}{{ shortAmount($withdrawLog->after_charge) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('Rate') }}
                            <span class="fw-bold">{{ getCurrencySymbol() }}1 = {{ shortAmount($withdrawLog->rate) }} {{ $withdrawLog?->withdrawMethod?->currency_name ?? getCurrencyName() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('Withdraw Amount') }}
                            <span class="fw-bold">{{ getCurrencySymbol() }}{{ shortAmount($withdrawLog->amount) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('Charge') }}
                            <span class="fw-bold">{{ getCurrencySymbol() }}{{ shortAmount($withdrawLog->charge) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('Final Amount') }}
                            <span class="fw-bold">{{ getCurrencySymbol() }}{{ shortAmount($withdrawLog->final_amount) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('After Charge') }}
                            <span class="fw-bold">{{ getCurrencySymbol() }}{{ shortAmount($withdrawLog->after_charge) }}</span>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-12">
                    <form method="POST" action="{{ route('agent.withdraw.success', $uid) }}">
                        @csrf
                        @if(!is_null($withdrawLog?->withdrawMethod->parameter))
                            @foreach($withdrawLog?->withdrawMethod->parameter as $key => $parameter)
                                <div class="mb-3">
                                    <label for="{{ getArrayValue($parameter, 'field_label') }}" class="form-label">{{ __(getArrayValue($parameter, 'field_label')) }}</label>
                                    <input type="text" class="form-control" id="{{ getArrayValue($parameter, 'field_label') }}" name="{{ getArrayValue($parameter, 'field_name') }}" placeholder="{{ __("Enter ". getArrayValue($parameter, 'field_label')) }}" required>
                                </div>
                            @endforeach
                        @endif
                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-primary btn-md">{{ __('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
