@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="container-fluid p-0">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $setTitle }}</h4>
                </div>

                <div class="card-body">
                    <form action="{{route('admin.binary.update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{ $scheme->uid }}" name="uid">

                        <div class="row g-4 mb-3">
                            <div class="col-lg-6">
                                <label class="form-label" for="name">@lang('Name') <sup class="text-danger">*</sup></label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $scheme->name }}" required>
                            </div>

                            <div class="col-lg-6">
                                <label class="form-label" for="type">@lang('Type') <sup class="text-danger">*</sup></label>
                                <select class="form-select range-type" id="type" name="type" required>
                                    @foreach(\App\Enums\Investment\InvestmentRage::toArray() as $key =>  $status)
                                        <option value="{{ $status }}" @if($scheme->type == $status) selected @endif>{{ replaceInputTitle($key) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row amount-fields"></div>

                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="interest_type">@lang('Interest Type') <sup class="text-danger">*</sup></label>
                                <select class="form-select" id="interest_type" name="interest_type" required>
                                    @foreach(\App\Enums\Investment\InterestType::toArray() as $key =>  $status)
                                        <option value="{{ $status }}" @if($scheme->interest_type == $status) selected @endif>{{ replaceInputTitle($key) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3 col-lg-6">
                                <label for="interest_rate" class="form-label">@lang('Interest Rate') <sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="interest_rate"
                                       name="interest_rate" value="{{ getAmount($scheme->interest_rate) }}" placeholder="@lang('Enter rate')"
                                       aria-describedby="basic-addon1" required>
                                    <span class="input-group-text" id="basic-addon1">%</span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="time">@lang('Time') <sup class="text-danger">*</sup></label>
                                <select class="form-select" id="time" name="time_id" required>
                                    <option value="" selected disabled>@lang('Select Time')</option>
                                    @foreach($timeTables as $timeTable)
                                        <option value="{{ $timeTable->id }}" @if($timeTable->id == $scheme->time_id) selected @endif>{{ __($timeTable->name) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="interest_return_type">@lang('Return Type') <sup class="text-danger">*</sup></label>
                                <select class="form-select" id="interest_return_type" name="interest_return_type" required>
                                    @foreach(\App\Enums\Investment\ReturnType::toArray() as $key =>  $status)
                                        <option value="{{ $status }}" @if($scheme->interest_return_type == $status) selected @endif>{{ __(\App\Enums\Investment\ReturnType::getName($status)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row interest-return-type-fields"></div>

                        <div class="row mb-4">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">@lang('Is Recommend') <sup class="text-danger">*</sup></label>
                                <div class="border px-2 py-2 rounded">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" @if($scheme->is_recommend) checked @endif value="1" name="is_recommend" id="flexCheckChecked" >
                                        <label class="form-check-label" for="flexCheckChecked">{{ __('Yes') }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="status">@lang('Status') <sup class="text-danger">*</sup></label>
                                <select class="form-select" id="status" name="status">
                                    <option value="" selected disabled>@lang('Select Status')</option>
                                    @foreach(\App\Enums\Status::toArray() as $key =>  $status)
                                        <option value="{{ $status }}" @if($scheme->status == $status) selected @endif>{{ replaceInputTitle($key) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4 col-lg-12">
                                <label for="terms_policy" class="form-label">{{ __('Terms Policy') }}<sup class="text-danger">*</sup></label>
                                <textarea class="form-control" name="terms_policy" id="terms_policy" rows="3" required>
                                    {{ $scheme->terms_policy }}
                                </textarea>
                            </div>

                            <div class="col-lg-12">
                                <div class="shadow-md border p-3 bg-body rounded ">
                                    <h5>@lang('Features')</h5>
                                    <hr>
                                    <div class="row mb-5 gy-3 gx-2">
                                        <div class="col-lg-10 col-md-8 col-sm-12">
                                            @lang('To add scheme features, please click the "Add New" button located on the right-hand side.')
                                        </div>

                                        <div class="col-lg-2 col-md-4 col-sm-12">
                                            <a href="javascript:void(0)" class="btn btn--primary btn--md text-light border-0 rounded features">
                                                <i class="las la-plus"></i> @lang('Add New')
                                            </a>
                                        </div>
                                    </div>

                                    @if(!empty($scheme->meta))
                                        @foreach($scheme->meta as $value)
                                            <div class="row item gx-2">
                                                <div class="mb-3 col-lg-10">
                                                    <input name="features[]" class="form-control" type="text" value="{{ $value }}" required placeholder="@lang('Enter feature')">
                                                </div>

                                                <div class="col-lg-2 mt-md-0 mt-2 text-right">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-danger remove-item w-100" type="button">
                                                            <i class="las la-times"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class="add-data"></div>
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
                    <div class="row item">
                         <div class="mb-3 col-lg-10">
                             <input name="features[]" class="form-control" type="text" required placeholder="@lang('Enter feature')">
                         </div>

                        <div class="col-lg-2 mt-md-0 mt-2 text-right">
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
                let amount;
                if (type == 1) {
                    amount = `
                        <div class="col-lg-6 mb-3">
                            <label class="form-label" for="minimum">@lang('Minimum') <sup class="text-danger">*</sup></label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    {{getCurrencySymbol()}}
                                </div>
                                <input type="number" class="form-control" id="minimum" name="minimum" value="{{ getAmount($scheme->minimum) }}" placeholder="@lang('Enter Amount')" step="any" required>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label class="form-label" for="maximum">@lang('Maximum') <sup class="text-danger">*</sup></label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    {{getCurrencySymbol()}}
                                </div>
                                 <input type="number" class="form-control" id="maximum" name="maximum" value="{{ getAmount($scheme->maximum) }}" placeholder="@lang('Enter Amount')" step="any" required>
                            </div>
                        </div>`;
                } else {
                    amount = `
                        <div class="col-lg-12 mb-3">
                            <label class="form-label" for="minimum">@lang('Amount') <sup class="text-danger">*</sup></label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    {{getCurrencySymbol()}}
                                </div>
                                <input type="number" class="form-control" id="amount" name="amount" value="{{ getAmount($scheme->amount) }}"  placeholder="@lang('Enter Amount')" step="any" required>
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
                            <input type="text" name="repeat_time" id="repeat_time" value="{{ shortAmount($scheme->duration) }}" class="form-control" placeholder="@lang('Enter Number')">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label" for="recapture_type">@lang('Investment Recapture') <sup class="text-danger">*</sup></label>
                            <select class="form-select" id="recapture_type" name="recapture_type">
                             @foreach(\App\Enums\Investment\Recapture::toArray() as $key =>  $status)
                                    <option value="{{ $status }}" @if($scheme->recapture_type == $status) selected @endif>{{ __(\App\Enums\Investment\Recapture::getName($status)) }}</option>
                             @endforeach
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

