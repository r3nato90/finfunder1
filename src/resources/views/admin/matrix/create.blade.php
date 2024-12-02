@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="container-fluid p-0">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $setTitle }}</h4>
                </div>

                <div class="card-body">
                    <form action="{{route('admin.matrix.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="text-center mb-2">
                            <div class="admin-commission"></div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-xl-6">
                                <label class="form-label" for="name">{{ __('admin.input.name') }} <sup class="text-danger">*</sup></label>
                                <input type="text" name="name" id="name" value="{{old('name')}}" placeholder="{{ __('admin.placeholder.name') }}" class="form-control" required="">
                            </div>

                            <div class="col-xl-6">
                                <label class="form-label" for="amount">{{ __('admin.input.amount') }} <sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                        {{getCurrencySymbol()}}
                                    </div>
                                    <input type="number" class="form-control" id="amount" name="amount"  placeholder="{{ __('admin.placeholder.number') }}" step="any" required>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <label class="form-label" for="referral-reward">{{ __('admin.input.referral') }} <sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                        {{getCurrencySymbol()}}
                                    </div>
                                    <input type="number" class="form-control" id="referral-reward" name="referral_reward" step="any" placeholder="{{ __('admin.placeholder.referral') }}" required>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <label class="form-label" for="status">{{ __('admin.input.status') }} <sup class="text-danger">*</sup></label>
                                <select class="form-select" id="status" name="status">
                                    <option value="" selected>{{ __('admin.filter.placeholder.select') }}</option>
                                    @foreach(\App\Enums\Matrix\PlanStatus::toArray() as $key =>  $status)
                                        <option value="{{ $status }}">{{ replaceInputTitle($key) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-xl-4 mb-3">
                                <label for="duration" class="form-label">@lang('Is Recommend') <sup class="text-danger">*</sup></label>
                                <div class="border px-2 py-2 rounded">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" value="1" name="is_recommend" id="flexCheckChecked" >
                                        <label class="form-check-label" for="flexCheckChecked">{{ __('Yes') }}</label>
                                    </div>
                                </div>
                            </div>

                            <h5 class="mt-5 mb-0">{{__('admin.input.referral_commission')}}</h5>

                            @for ($i = 0; $i < getArrayValue($setting->matrix_parameters, 'height', 1); $i++)
                                <div class="col-lg-6">
                                    <label for="{{$i}}" class="form-label">@lang('Level '){{ $i + 1 }}</label>
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            {{getCurrencySymbol()}}
                                        </div>
                                        <input type="number" class="form-control referral-commission-amount" id="{{$i}}" name="matrix_levels[{{$i+1}}]" placeholder="{{__('admin.placeholder.number')}}" step="any" required>
                                    </div>
                                </div>
                            @endfor
                        </div>
                        <button class="i-btn btn--primary btn--lg">{{ __('admin.button.save') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script-push')
    <script>
        "use strict";
        $(document).ready(function () {
            function calculateAdminGainLoss() {
                const referralCommissionInputs = $('.referral-commission-amount');
                const planAmountInput = $('#amount');
                const referralRewardInput = $('#referral-reward');

                let referralCommissionTotal = 0;
                referralCommissionInputs.each(function calculateReferralCommissionTotal() {
                    if ($(this).val() !== '') {
                        referralCommissionTotal += +$(this).val();
                    }
                });

                const planAmount = Number(planAmountInput.val());
                const referralReward = Number(referralRewardInput.val());
                const totalAmount = referralCommissionTotal + referralReward;
                const currency = "{{getCurrencyName()}}";
                const finalAmount = planAmount - totalAmount;

                if (planAmount > totalAmount) {
                    $('.admin-commission').html(`<span class="text--success">{{ __('admin.placeholder.take_commission') }} : ${parseFloat(finalAmount).toFixed(2)} ${currency}</span>`);

                } else {
                    $('.admin-commission').html(`<span class="text--danger">{{ __('admin.placeholder.loss_commission') }} : ${parseFloat(finalAmount).toFixed(2)} ${currency}</span>`);
                }
            }

            $(document).on('keyup', '.referral-commission-amount, #amount, #referral-reward', function onInputChange() {
                calculateAdminGainLoss();
            });
        });
    </script>
@endpush


