@extends('agent.layouts.main')
@section('panel')
    <section>
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="title">{{ __($setTitle) }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center gy-4 mb-3">
                            @foreach($withdrawMethods as $key => $withdrawMethod)
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                    <div class="card primary-light shadow-none">
                                        <div class="row justify-content-between align-items-center g-lg-2 g-1">
                                            <h5 class="text-center mb-3 my-3">{{ __($withdrawMethod->name) }}</h5>
                                            <button class="btn btn--primary cash-out-process"
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
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header primary--light border-0">
                        <h5 class="modal-title" id="methodTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    @if(getArrayValue($setting->system_configuration, 'withdraw_request.value') == \App\Enums\Status::ACTIVE->value)
                        <form method="POST" action="{{ route('agent.withdraw.process') }}">
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
                                <button type="button" class="btn btn--outline btn--sm" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                <button type="submit" class="btn btn--primary btn--sm">{{ __('Submit') }}</button>
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
    </section>
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
