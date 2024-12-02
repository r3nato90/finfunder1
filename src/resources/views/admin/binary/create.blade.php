@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="container-fluid p-0">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $setTitle }}</h4>
                </div>

                <div class="card-body">
                    <form action="{{route('admin.binary.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4 mb-3">
                            <div class="col-lg-6">
                                <label class="form-label" for="name">@lang('Name') <sup class="text-danger">*</sup></label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" placeholder="@lang('Enter Name')" required>
                            </div>

                            <div class="col-lg-6">
                                <label class="form-label" for="type">@lang('Type') <sup class="text-danger">*</sup></label>
                                <select class="form-select range-type" id="type" name="type" required>
                                    <option value="{{ App\Enums\Investment\InvestmentRage::RANGE->value }}">{{ __(\App\Enums\Investment\InvestmentRage::getName(App\Enums\Investment\InvestmentRage::RANGE->value)) }}</option>
                                    <option value="{{ App\Enums\Investment\InvestmentRage::FIXED->value }}">{{ __(\App\Enums\Investment\InvestmentRage::getName(App\Enums\Investment\InvestmentRage::FIXED->value)) }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row amount-fields"></div>

                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="interest_type">@lang('Interest Type') <sup class="text-danger">*</sup></label>
                                <select class="form-select" id="interest_type" name="interest_type" required>
                                    <option value="{{ App\Enums\Investment\InterestType::PERCENT->value }}" selected>{{ __(\App\Enums\Investment\InterestType::getName(App\Enums\Investment\InterestType::PERCENT->value)) }}</option>
                                    <option value="{{ App\Enums\Investment\InterestType::FIXED->value }}">{{ __(\App\Enums\Investment\InterestType::getName(App\Enums\Investment\InterestType::FIXED->value)) }}</option>
                                </select>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label for="interest_rate" class="form-label">@lang('Interest Rate') <sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="text" value="{{ old('interest_rate') }}" class="form-control" id="interest_rate"
                                           name="interest_rate" placeholder="@lang('Enter rate')"
                                           aria-describedby="basic-addon1" required>
                                    <span class="input-group-text intertest-rate-symbol" id="basic-addon1">%</span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="time">@lang('Time') <sup class="text-danger">*</sup></label>
                                <select class="form-select" id="time" name="time_id" required>
                                    <option value="" selected disabled>@lang('Select Time')</option>
                                    @foreach($timeTables as $timeTable)
                                        <option value="{{ $timeTable->id }}">{{ __($timeTable->name) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="interest_return_type">@lang('Return Type') <sup class="text-danger">*</sup></label>
                                <select class="form-select" id="interest_return_type" name="interest_return_type" required>
                                    <option value="{{ \App\Enums\Investment\ReturnType::LIFETIME->value }}" selected>{{ __(\App\Enums\Investment\ReturnType::getName(App\Enums\Investment\ReturnType::LIFETIME->value)) }}</option>
                                    <option value="{{ \App\Enums\Investment\ReturnType::REPEAT->value }}">{{ __(\App\Enums\Investment\ReturnType::getName(App\Enums\Investment\ReturnType::REPEAT->value)) }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row interest-return-type-fields"></div>

                        <div class="row mb-4">
                            <div class="col-lg-6 mb-3">
                                <label for="duration" class="form-label">@lang('Is Recommend') <sup class="text-danger">*</sup></label>
                                <div class="border px-2 py-2 rounded">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" value="1" name="is_recommend" id="flexCheckChecked" >
                                        <label class="form-check-label" for="flexCheckChecked">{{ __('Yes') }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="status">@lang('Status') <sup class="text-danger">*</sup></label>
                                <select class="form-select" id="status" name="status" required>
                                    @foreach(\App\Enums\Status::toArray() as $key =>  $status)
                                        <option value="{{ $status }}">{{ replaceInputTitle($key) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4 col-lg-12">
                                <label for="terms_policy" class="form-label">{{ __('Terms Policy') }}<sup class="text-danger">*</sup></label>
                                <textarea class="form-control" name="terms_policy" id="terms_policy" rows="3" required>{{ old('terms_policy') }}</textarea>
                            </div>

                            <div class="col-12">
                                <div class="shadow-md border p-3 bg-body rounded mb-3">
                                    <h5>@lang('Features')</h5>
                                    <hr>
                                    <div class="row my-3">
                                        <div class="col-lg-10 col-md-8 col-sm-12">
                                            @lang('To add scheme features, please click the "Add New" button located on the right-hand side.')
                                        </div>

                                        <div class="col-lg-2 col-md-4 col-sm-12">
                                            <a href="javascript:void(0)" class="btn btn-primary text-light border-0 rounded features">
                                                <i class="las la-plus"></i> @lang('Add New')
                                            </a>
                                        </div>
                                    </div>
                                    <div class="add-data"></div>
                                </div>

                                <div class="shadow-md border p-3 bg-body rounded ">
                                    <h5>@lang('Notify users')</h5>
                                    <hr>
                                    <div class="row gy-3 my-3">
                                        <div class="col-lg-10 col-md-8 col-sm-12">
                                            @lang('If you activate the notification status, all users will be notified and have the opportunity to review and consider investing in this plan.')
                                        </div>

                                        <div class="col-lg-2 col-md-4 col-sm-12">
                                            <label class="custom--switch" for="notify">
                                                <input
                                                    type="checkbox"
                                                    name="notify"
                                                    class="default_status"
                                                    id="notify"
                                                    value="1">
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="i-btn btn--primary btn--lg">@lang('Submit')</button>
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
            const createNewData = () => {
                const html = `
                    <div class="row item my-2">
                         <div class="mb-3 col-lg-8">
                             <input name="features[]" class="form-control" type="text" required placeholder="@lang('Enter feature')">
                         </div>

                        <div class="col-lg-4 mt-md-0 mt-2 text-right">
                            <span class="input-group-btn">
                                <button class="btn btn-danger remove-item w-100" type="button">
                                    <i class="las la-times"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                  `;
                $('.add-data').append(html);
            };

            const removeData = (event) => {
                const item = $(event.target).closest('.item');
                if (item.length) {
                    item.remove();
                }
            };

            $('.features').on('click', createNewData);

            $(document).on('click', '.remove-item', function (event) {
                removeData(event);
            });

            function getInvestType(type) {
                if (type == 1) {
                    var amount = `
                        <div class="col-lg-6 mb-3">
                            <label class="form-label" for="minimum">@lang('Minimum') <sup class="text-danger">*</sup></label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    {{getCurrencySymbol()}}
                                </div>
                                <input type="number" class="form-control" id="minimum" name="minimum" placeholder="@lang('Enter Amount')" step="any" required>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label class="form-label" for="maximum">@lang('Maximum') <sup class="text-danger">*</sup></label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    {{getCurrencySymbol()}}
                                </div>
                                <input type="number" class="form-control" id="maximum" name="maximum" placeholder="@lang('Enter Amount')" step="any" required>
                            </div>
                        </div>`;
                } else {
                    var amount = `
                        <div class="col-lg-12 mb-3">
                            <label class="form-label" for="minimum">@lang('Amount') <sup class="text-danger">*</sup></label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    {{getCurrencySymbol()}}
                                </div>
                                <input type="number" class="form-control" id="amount" name="amount" placeholder="@lang('Enter Amount')" step="any" required>
                            </div>
                        </div>`;
                }

                $('.amount-fields').html(amount);
            }

            function createInterestFields(type) {
                if (type == 2) {
                    var interestFields = `
                        <div class="col-lg-6 mb-3">
                            <label class="form-label" for="repeat_time">@lang('Repeat Times') <sup class="text-danger">*</sup></label>
                            <input type="text" name="repeat_time" id="repeat_time" class="form-control" placeholder="@lang('Enter Number')">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label" for="recapture_type">@lang('Capital back') <sup class="text-danger">*</sup></label>
                            <select class="form-select" id="recapture_type" name="recapture_type">
                                <option value="{{ \App\Enums\Investment\Recapture::YES->value }}" selected>{{ __(\App\Enums\Investment\Recapture::getName(App\Enums\Investment\Recapture::YES->value)) }}</option>
                                <option value="{{ \App\Enums\Investment\Recapture::NO->value }}">{{ __(\App\Enums\Investment\Recapture::getName(App\Enums\Investment\Recapture::NO->value)) }}</option>
                                <option value="{{ \App\Enums\Investment\Recapture::HOLD->value }}">{{ __(\App\Enums\Investment\Recapture::getName(App\Enums\Investment\Recapture::HOLD->value)) }}</option>
                            </select>
                            <div class="form-text"> @lang("Hold means the user can reinvest this amount or transfer it to the user's main account after completing the profit.")</div>
                        </div>`;

                    $('.interest-return-type-fields').html(interestFields);
                }else{
                    $('.interest-return-type-fields').empty();
                }
            }

            $(".range-type").on('change', function () {
                const type = $('#type').val();
                getInvestType(type);
            }).change();

            $("#interest_type").on('change', function () {
                const interestType = $('#interest_type').val();
                getInterestType(interestType);
            }).change();

            $("#interest_return_type").on('change', function () {
                const type = $('#interest_return_type').val();
                createInterestFields(type);
            }).change();

            function getInterestType(type){
                let interestValue = "%";
                if (type == 2){
                    interestValue = "{{ getCurrencyName() }}"
                }
                $(".intertest-rate-symbol").text(interestValue);
            }
        });
    </script>
@endpush
