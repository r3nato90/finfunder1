@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="container-fluid p-0">
            <div class="filter-action">
                <button type="button" data-bs-toggle="modal" data-bs-target="#referralSettingModal"
                        class="i-btn btn--dark btn--md">
                    <i class="las la-cog"></i>{{ __('Referral Activation') }}
                </button>
            </div>
            <div class="row">
                @foreach(\App\Enums\Referral\ReferralCommissionType::commissionTypes() as $key => $commissionType)
                    <div class="col-lg-4 mb-4">
                        <div class="card">
                            <div class="card-header bg--primary">
                                <h4 class="card-title text-white">{{ __($commissionType) }}</h4>
                            </div>

                            <div class="card-body">
                                <ul class="list-group detail-list">
                                    @foreach($referrals->where('commission_type', $key) as $commissionKey => $referral )
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ __('Level') }} {{ $referral->level }}
                                            <span class="fw-bold fs-14">{{ shortAmount($referral->percent)  }} %</span>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Enter Number of Level"
                                           name="total-level" aria-label="Recipient's username"
                                           aria-describedby="basic-addon2">
                                    <span class="input-group-text pointer level-generate"
                                          id="basic-addon2">{{ __('Generate') }}</span>
                                </div>

                                <form action="{{ route('admin.binary.referral.update') }}" method="POST"
                                      class="d-none level-setting-form">
                                    @csrf
                                    <input type="hidden" name="commission_type" value="{{ $key  }}">
                                    <h6 class="text-center">{{ __('The previous setting will be replaced when creating new') }}</h6>
                                    <div class="referral-setting mt-2"></div>
                                    <button class="i-btn btn--primary btn--md">{{ __('admin.button.save') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <div class="modal fade" id="referralSettingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Referral Activation Update') }}</h5>
                </div>
                <form action="{{route('admin.binary.referral.setting')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            @foreach(\App\Enums\Referral\ReferralCommissionType::commissionTypes() as $key => $commissionType)
                                <div class="col-lg-12 mb-3">
                                    <label class="form-label" for="status">{{ __($commissionType) }} <sup
                                            class="text-danger">*</sup></label>
                                    <select class="form-select" id="status"
                                            name="status[{{ \App\Enums\Referral\ReferralCommissionType::getColumnName((int) $key) }}]">
                                        @foreach(\App\Enums\Status::toArray() as $statusKey =>  $status)
                                            <option value="{{ $status }}"
                                                    @if(getArrayValue($setting->referral_setting, \App\Enums\Referral\ReferralCommissionType::getColumnName((int) $key)) == $status) selected @endif>{{ replaceInputTitle($statusKey) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn--outline btn--sm"
                                data-bs-dismiss="modal">{{ __('admin.button.close') }}</button>
                        <button type="submit" class="btn btn--primary btn--sm">{{ __('admin.button.save') }}</button>
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
            $('.level-generate').on('click', function () {
                const totalLevel = $(this).closest('.card-body').find('input[name="total-level"]').val();
                const form = $(this).closest('.card-body').find('.level-setting-form');
                const referralSetting = $(this).closest('.card-body').find('.referral-setting');

                console.log('Total Level:', totalLevel);
                console.log('Form:', form);
                console.log('Referral Setting:', referralSetting);

                referralSetting.empty();

                if (totalLevel && totalLevel > 0) {
                    for (let i = 1; i <= totalLevel; i++) {
                        const html = `
                        <div class="row remove-field">
                            <div class="col-lg-10">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">@lang('Level') ${i}</span>
                                    <input type="text" name="percent[]" class="form-control" placeholder="@lang('Commission Percentage')" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>

                            <div class="col-lg-2 mt-md-0 mt-2 text-right">
                                <span class="input-group-btn">
                                    <button class="i-btn btn--danger btn--md text--white removeBtn w-100" type="button">
                                        <i class="las la-times"></i>
                                    </button>
                                </span>
                            </div>
                        </div>`;
                        referralSetting.append(html);
                    }
                    form.removeClass('d-none');
                } else {
                    form.addClass('d-none');
                }
            });

            $(document).on('click', '.removeBtn', function () {
                $(this).closest('.remove-field').remove();
            });
        });
    </script>
@endpush

