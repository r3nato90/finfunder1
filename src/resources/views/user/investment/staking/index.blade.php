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
                        <div class="row row-cols-lg-4 row-cols-md-4 row-cols-sm-2 row-cols-1 g-3">
                            <div class="col">
                                <button class="i-btn btn--lg btn--primary w-100" data-bs-toggle="modal" data-bs-target="#staking-investment"><i class="bi bi-wallet me-3"></i> {{ __('Invest Now') }}</button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row align-items-center gy-4 mb-3">
                            <div class="table-container">
                                <table id="myTable" class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">{{ __('Initiated At') }}</th>
                                            <th scope="col">{{ __('Amount') }}</th>
                                            <th scope="col">{{ __('Interest') }}</th>
                                            <th scope="col">{{ __('Total Return') }}</th>
                                            <th scope="col">{{ __('Expiration Date') }}</th>
                                            <th scope="col">{{ __('Status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($stakingInvestments as $key => $item)
                                        <tr>
                                            <td data-label="{{ __('Initiated At') }}">{{ showDateTime($item->created_at) }}</td>
                                            <td data-label="{{ __('Amount') }}">{{ getCurrencySymbol() }}{{ shortAmount($item->amount) }}</td>
                                            <td data-label="{{ __('Interest') }}">{{ getCurrencySymbol() }}{{ shortAmount($item->interest) }}</td>
                                            <td data-label="{{ __('Total Return') }}">{{ getCurrencySymbol() }}{{ shortAmount($item->amount + $item->interest) }}</td>
                                            <td data-label="{{ __('Expiration Date') }}">{{ showDateTime($item->expiration_date) }}</td>
                                            <td data-label="{{ __('Status') }}">
                                                <span class="i-badge {{ \App\Enums\Investment\Staking\Status::getColor((int)$item->status) }}"> {{ \App\Enums\Investment\Staking\Status::getName((int)$item->status) }}</span>
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
                    <div class="mt-4">{{ $stakingInvestments->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="staking-investment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg--dark">
                    <h5 class="modal-title">{{ __('Staking Invest Now') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="{{ route('user.staking-investment.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="amount" class="col-form-label">{{ __('Duration') }}</label>
                            <select class="form-control" name="plan_id" id="plan-select">
                                @foreach ($plans as $plan)
                                    <option value="{{ $plan->id }}"
                                        data-min="{{ getCurrencySymbol() }}{{ shortAmount($plan->minimum_amount) }}"
                                        data-max="{{ getCurrencySymbol() }}{{ shortAmount($plan->maximum_amount) }}"
                                        data-interest="{{ $plan->interest_rate }}"
                                    >{{ $plan->duration }} {{ __('Days') }} - {{ __('Interest') }} {{ shortAmount($plan->interest_rate) }}%</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="col-form-label">{{ __('Amount') }} (<span id="min-amount"></span> - <span id="max-amount"></span>)</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="amount" name="amount" placeholder="{{ __('Enter Amount') }}" aria-label="Amount" aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2">{{ getCurrencyName() }}</span>
                            </div>
                            <small id="total-return" class="text--light"></small>
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
@endsection

@push('script-push')
    <script>
        "use strict";
        $(document).ready(function() {
            var interestRate = 0;

            function updateMinMax() {
                const selectedOption = $('#plan-select option:selected');
                const minAmount = selectedOption.data('min');
                const maxAmount = selectedOption.data('max');
                interestRate = selectedOption.data('interest');

                $('#min-amount').text(minAmount);
                $('#max-amount').text(maxAmount);
            }

            function updateTotalReturn(amount) {
                var parsedAmount = parseFloat(amount);
                if (isNaN(parsedAmount)) {
                    $("#total-return").text("");
                    return;
                }
                var returnAmount = parsedAmount * interestRate / 100 + parsedAmount;
                $("#total-return").text("Total Return: {{ getCurrencySymbol() }}" + returnAmount.toFixed(2) + " after the complete investment period");
            }

            updateMinMax();

            $('#plan-select').change(function() {
                updateMinMax();
            });

            $('#amount').on('keyup', function() {
                var amount = $(this).val();
                updateTotalReturn(amount);
            });
        });
    </script>
@endpush



