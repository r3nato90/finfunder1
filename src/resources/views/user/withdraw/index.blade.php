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
                        <div class="row align-items-center gy-4 mb-3">
                            @foreach($withdrawMethods as $key => $withdrawMethod)
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                    <div class="i-card-sm card--dark shadow-none">
                                        <div class="row justify-content-between align-items-center g-lg-2 g-1">
                                            <div class="col-12">
                                                <h5 class="title-sm border-bottom pb-3">{{ __($withdrawMethod->name) }}</h5>
                                            </div>

                                            <div class="col-lg-7 col-md-7 col-sm-7 text-end">
                                                <button class="i-btn btn--primary btn--lg capsuled cash-out-process"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal"
                                                    data-id="{{ $withdrawMethod->id }}"
                                                    data-name="{{ $withdrawMethod->name }}"
                                                    data-min_limit="{{ shortAmount($withdrawMethod->min_limit) }}"
                                                    data-max_limit="{{ shortAmount($withdrawMethod->max_limit) }}"
                                                >{{ __('Withdraw Now') }}<i class="bi bi-box-arrow-up-right ms-2"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="i-card-sm">
                    <div class="filter-area">
                        <form action="{{ route('user.withdraw.index') }}">
                            <div class="row row-cols-lg-4 row-cols-md-4 row-cols-sm-2 row-cols-1 g-3">
                                <div class="col">
                                    <input type="text" name="search" placeholder="Trx ID" value="{{ request()->get('search') }}">
                                </div>
                                <div class="col">
                                    <select class="select2-js" name="status" >
                                        @foreach (App\Enums\Payment\Withdraw\Status::cases() as $status)
                                            @unless($status->value == App\Enums\Payment\Withdraw\Status::INITIATED->value)
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
                                            <th scope="col">{{ __('Conversion') }}</th>
                                            <th scope="col">{{ __('Status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($withdrawLogs as $key => $withdrawLog)
                                            <tr>
                                                <td data-label="{{ __('Initiated At') }}">
                                                    {{ showDateTime($withdrawLog->created_at) }}
                                                </td>
                                                <td data-label="{{ __('Trx') }}">
                                                    {{ $withdrawLog->trx }}
                                                </td>
                                                <td data-label="{{ __('Gateway') }}">
                                                    {{ $withdrawLog?->withdrawMethod?->name ?? 'N/A' }}
                                                </td>
                                                <td data-label="{{ __('Amount') }}">
                                                    {{ getCurrencySymbol() }}{{ shortAmount($withdrawLog->amount) }}
                                                </td>
                                                <td data-label="{{ __('Charge') }}">
                                                    {{ getCurrencySymbol() }}{{ shortAmount($withdrawLog->charge) }}
                                                </td>
                                                <td data-label="{{ __('Final Amount') }}">
                                                    {{ getCurrencySymbol() }}{{ shortAmount($withdrawLog->final_amount) }}
                                                </td>
                                                <td data-label="{{ __('Conversion') }}">
                                                    {{ getCurrencySymbol() }}1 = {{ shortAmount($withdrawLog->rate) }} {{ $withdrawLog?->withdrawMethod?->currency_name ?? getCurrencyName() }}
                                                </td>
                                                <td data-label="{{ __('Status') }}">
                                                    <span class="i-badge {{ App\Enums\Payment\Withdraw\Status::getColor($withdrawLog->status)}}">{{ App\Enums\Payment\Withdraw\Status::getName($withdrawLog->status)}}</span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-muted text-white" colspan="100%">{{ __('No Data Found')}}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">{{ $withdrawLogs->links() }}</div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg--dark">
                    <h5 class="modal-title" id="methodTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @if(getArrayValue($setting->system_configuration, 'withdraw_request.value') == \App\Enums\Status::ACTIVE->value)
                    <form method="POST" action="{{ route('user.withdraw.process') }}">
                        @csrf
                        <input type="hidden" name="id" value="">
                        <div class="modal-body">
                            <div class="text-end">
                                <p class="mb-0" id="withdraw_limit"></p>
                            </div>
                            <div class="mb-3">
                                <label for="amount" class="col-form-label">{{ __('Amount') }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="amount" name="amount" placeholder="{{ __('Enter Amount') }}" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                    <span class="input-group-text" id="basic-addon2">{{ getCurrencyName() }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="i-btn btn--outline btn--sm" data-bs-dismiss="modal">{{ __('Close') }}</button>
                            <button type="submit" class="i-btn btn--primary btn--sm">{{ __('Submit') }}</button>
                        </div>
                    </form>
                @else
                    <div class="modal-body">
                        <p>{{ __('Withdraw Request Currently Unavailable') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('script-push')
    <script>
        "use strict";
        $(document).ready(function() {
            $('.cash-out-process').click(function() {
                const name = $(this).data('name');
                const id = $(this).data('id');
                const currencySymbol = "{{ getCurrencySymbol() }}"
                const minLimit = $(this).data('min_limit');
                const maxLimit = $(this).data('max_limit');
                $('input[name="id"]').val(id);

                const withdrawLimit = "Withdraw Limit " + currencySymbol + minLimit + " - " + currencySymbol + maxLimit;
                const gatewayTitle = "Withdraw with " + name + " now";
                $('#methodTitle').text(gatewayTitle);
                $('#withdraw_limit').text(withdrawLimit);
            });
        });
    </script>
@endpush
