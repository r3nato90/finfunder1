@extends('layouts.user')
@section('content')
    <div class="main-content" data-simplebar>
        <div class="row">
            <div class="col-lg-12">
                <div class="i-card-sm">
                    <div class="card-header">
                        <h4 class="title">{{ __($setTitle) }}</h4>
                    </div>
                    <div class="filter-area">
                        <form action="{{ route('user.investment.funds') }}">
                            <div class="row row-cols-lg-4 row-cols-md-4 row-cols-sm-2 row-cols-1 g-3">
                                <div class="col">
                                    <input type="text" name="search" placeholder="{{ __('Trx ID') }}" value="{{ request()->get('search') }}">
                                </div>
                                <div class="col">
                                    <select class="select2-js" name="status" >
                                        @foreach (App\Enums\Investment\Status::cases() as $status)
                                            <option value="{{ $status->value }}" @if($status->value == request()->status) selected @endif>{{ replaceInputTitle($status->name)  }}</option>
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
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-container">
                                    <table id="myTable" class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">{{ __('Initiated At') }}</th>
                                                <th scope="col">{{ __('Trx') }}</th>
                                                <th scope="col">{{ __('Plan') }}</th>
                                                <th scope="col">{{ __('Amount') }}</th>
                                                <th scope="col">{{ __('Interest') }}</th>
                                                <th scope="col">{{ __('Should Pay') }}</th>
                                                <th scope="col">{{ __('Paid') }}</th>
                                                <th scope="col">{{ __('Upcoming Payment') }}</th>
                                                <th scope="col">{{ __('Status') }}</th>
                                                <th scope="col">{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($investmentLogs as $key => $investLog)
                                                <tr>
                                                    <td data-label="{{ __('Initiated At') }}">
                                                        {{ showDateTime($investLog->created_at) }}
                                                    </td>
                                                    <td data-label="{{ __('Trx') }}">
                                                        {{ $investLog->trx }}
                                                    </td>
                                                    <td data-label="{{ __('Plan') }}">
                                                        {{ __($investLog->plan_name) }}
                                                    </td>
                                                    <td data-label="{{ __('Amount') }}">
                                                        {{ getCurrencySymbol() }}{{ shortAmount($investLog->amount) }}
                                                    </td>
                                                    <td data-label="{{ __('Interest') }}">
                                                        @if(@$investLog->interest_type == \App\Enums\Investment\InterestType::PERCENT->value)
                                                            {{ shortAmount($investLog->interest_rate) }} %
                                                        @else
                                                            {{ getCurrencySymbol() }}{{ shortAmount($investLog->interest_rate) }}
                                                        @endif
                                                    </td>
                                                    <td data-label="{{ __('Should Pay') }}">
                                                        {{ $investLog->should_pay != -1 ? getCurrencySymbol(). shortAmount($investLog->should_pay) : '****' }}
                                                    </td>
                                                    <td data-label="{{ __('Paid') }}">
                                                        {{ getCurrencySymbol() }}{{ shortAmount($investLog->profit) }}
                                                    </td>
                                                    <td data-label="{{ __('Upcoming Payment	') }}">
                                                        @if($investLog->status == \App\Enums\Investment\Status::INITIATED->value)
                                                            <div data-profit-time="{{ \Carbon\Carbon::parse($investLog->profit_time)->toIso8601String() }}" class="payment_time"></div>
                                                        @else
                                                            <span>{{ __('N/A') }}</span>
                                                        @endif
                                                    </td>
                                                    <td data-label="{{ __('Status') }}">
                                                        <span
                                                            class="i-badge {{ \App\Enums\Investment\Status::getColor((int)$investLog->status) }} capsuled">
                                                           {{ \App\Enums\Investment\Status::getName((int)$investLog->status) }}
                                                        </span>
                                                    </td>
                                                    <td data-label="Action">
                                                        @if($investLog->status == \App\Enums\Investment\Status::PROFIT_COMPLETED->value || ($investLog->status == \App\Enums\Investment\Status::INITIATED->value && $investLog->profit == 0) )
                                                            <div class="table-action">
                                                                <div class="i-dropdown">
                                                                    <button class="dropdown-toggle style-2 p-0"
                                                                            type="button" data-bs-toggle="dropdown"
                                                                            aria-expanded="false">{{ __('Action') }}</button>
                                                                    <ul class="dropdown-menu">
                                                                        @if($investLog->status === \App\Enums\Investment\Status::PROFIT_COMPLETED->value)
                                                                            <li>
                                                                                <a class="dropdown-item icon-btn warning re-investment-process"
                                                                                   href="javascript:void(0)"
                                                                                   data-bs-toggle="modal"
                                                                                   data-bs-target="#reInvestModal"
                                                                                   data-name="{{ $investLog->plan->name }}"
                                                                                   data-uid="{{ $investLog->uid }}">
                                                                                    <i class="bi bi-credit-card"></i> {{ __('Re-Investment') }}
                                                                                </a>
                                                                            </li>

                                                                            <li>
                                                                                <a class="dropdown-item icon-btn warning transfer-process"
                                                                                   href="javascript:void(0)"
                                                                                   data-bs-toggle="modal"
                                                                                   data-bs-target="#transferModal"
                                                                                   data-uid="{{ $investLog->uid }}"
                                                                                   data-deducted_amount="{{  shortAmount($investLog->amount) }}"
                                                                                >
                                                                                    <i class="bi bi-credit-card-fill"></i> {{ __('Investment Transfer') }}
                                                                                </a>
                                                                            </li>
                                                                        @endif

                                                                        @if($investLog->status == \App\Enums\Investment\Status::INITIATED->value && $investLog->profit == 0)
                                                                            <li>
                                                                                <a class="dropdown-item icon-btn warning cancel-process"
                                                                                   href="javascript:void(0)"
                                                                                   data-bs-toggle="modal"
                                                                                   data-bs-target="#cancelModal"
                                                                                   data-uid="{{ $investLog->uid }}"
                                                                                ><i class="bi bi-trash"></i> {{ __('Cancel') }}
                                                                                </a>
                                                                            </li>
                                                                        @endif
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <span>N/A</span>
                                                        @endif
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
                </div>
                <div class="mt-4">{{ $investmentLogs->links() }}</div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reInvestModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg--dark">
                    <h5 class="modal-title">{{ __('Confirmed Re-Investment Process') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="{{ route('user.investment.make.re-investment') }}">
                    @csrf
                    <input type="hidden" name="uid" value="">
                    <div class="modal-body">
                        <p>{{ __("You're reinvesting in your current plan. Add more funds by including a new amount") }}</p>
                        <div class="mb-3">
                            <label for="amount" class="col-form-label">{{ __("Amount") }}</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="amount" name="amount"
                                       placeholder="{{ __('Enter investment amount') }}"
                                       aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2">{{ getCurrencyName() }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="i-btn btn--primary btn--md">{{ __('Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg--dark">
                    <h5 class="modal-title">{{ __('Confirmed Cancellation of Investment Process') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="{{ route('user.investment.cancel') }}">
                    @csrf
                    <input type="hidden" name="uid" value="">
                    <div class="modal-body">
                        <p>{{ __("Are you sure you want to cancel this investment?") }}</p>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="i-btn btn--primary btn--md">{{ __('Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="transferModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg--dark">
                    <h5 class="modal-title">{{ __('Confirm Investment Transfer') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="{{ route('user.investment.complete.profitable') }}">
                    @csrf
                    <input type="hidden" name="uid" value="">
                    <div class="modal-body">
                        <p>
                            <span class="deducted_amount"></span> {{ __('Transferred to Your Investment Wallet') }}
                        </p>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="i-btn btn--primary btn--md">{{ __('Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('script-push')
    <script>
        "use strict";
        $(document).ready(function () {
            $('.re-investment-process').click(function () {
                const name = $(this).data('name');
                const uid = $(this).data('uid');
                $('input[name="uid"]').val(uid);
            });

            $('.cancel-process').click(function () {
                const uid = $(this).data('uid');
                $('input[name="uid"]').val(uid);
            });

            $('.transfer-process').click(function () {
                const uid = $(this).data('uid');
                const currency = "{{ getCurrencySymbol() }}"
                const deductedAmount = $(this).data('deducted_amount');
                $('input[name="uid"]').val(uid);
                $('.deducted_amount').text(currency + deductedAmount);
            });
        });


        function upcomingPaymentCount() {
            const elements = document.querySelectorAll('.payment_time');
            elements.forEach(function(element) {
                var profitTime = element.getAttribute('data-profit-time');
                var countDownDate = new Date(profitTime).getTime();

                var x = setInterval(function() {
                    var now = new Date().getTime();
                    var distance = countDownDate - now;

                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    element.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

                    if (distance < 0) {
                        clearInterval(x);
                        element.innerHTML = "EXPIRED";
                    }
                }, 1000);
            });
        }

        document.addEventListener('DOMContentLoaded', upcomingPaymentCount);
    </script>
@endpush
