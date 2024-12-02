@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ucfirst($paymentGateway->name)}} {{ $setTitle }}</h4>
            </div>
            <div class="card-body">
                <form action="{{route('admin.payment.gateway.update', $paymentGateway->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-lg-6">
                            <label for="currency_name" class="form-label"> {{ __('admin.input.currency_name')}} <sup class="text--danger">*</sup></label>
                            <input type="text" name="currency" value="{{$paymentGateway->currency}}" id="currency_name" class="form-control">
                        </div>

                        <div class="mb-3 col-lg-6">
                            <label for="image" class="form-label"> {{ __('admin.input.image')}} <sup class="text--danger">*</sup></label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>

                        <div class="mb-3 col-lg-6">
                            <label for="minimum" class="form-label"> {{ __('Minimum Amount')}} <sup class="text--danger">*</sup></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="minimum" name="minimum" value="{{getAmount($paymentGateway->minimum)}}" placeholder="{{ __('Enter Number')}}" aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2">{{  getCurrencyName() }}</span>
                            </div>
                        </div>

                        <div class="mb-3 col-lg-6">
                            <label for="maximum" class="form-label"> {{ __('Maximum Amount')}} <sup class="text--danger">*</sup></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="maximum" name="maximum" value="{{getAmount($paymentGateway->maximum)}}" placeholder="{{ __('Enter Number')}}" aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2">{{  getCurrencyName() }}</span>
                            </div>
                        </div>

                        <div class="mb-3 col-lg-6">
                            <label for="percent_charge" class="form-label"> {{ __('admin.input.percent_charge')}} <sup class="text--danger">*</sup></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="percent_charge" name="percent_charge" value="{{getAmount($paymentGateway->percent_charge)}}" placeholder="{{ __('Enter Number')}}" aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2">%</span>
                            </div>
                        </div>

                        <div class="mb-3 col-lg-6">
                            <label for="rate" class="form-label"> {{ __('admin.input.rate')}} <sup class="text--danger">*</sup></label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">{{ getCurrencySymbol() }}1 = </span>
                                <input type="text" name="rate" id="rate" value="{{getAmount($paymentGateway->rate)}}" class="method-rate form-control" aria-label="Amount (to the nearest dollar)">
                                <span class="input-group-text limit-text"></span>
                            </div>
                        </div>


                        @foreach($paymentGateway->parameter as $key => $parameter)
                            <div class="mb-3 col-lg-12">
                                <label for="{{$key}}" class="form-label">{{ __(replaceInputTitle($key)) }} <sup class="text--danger">*</sup></label>
                                <input type="text" name="method[{{$key}}]" id="{{$key}}" value="{{$parameter}}" class="form-control" placeholder=" {{ __('Give Valid Data')}}" required>
                            </div>
                        @endforeach

                        <div class="mb-3 col-lg-12">
                            <label for="status" class="form-label"> {{ __('admin.input.status')}} <sup class="text--danger">*</sup></label>
                            <select class="form-select" name="status" id="status" required>
                                @foreach(\App\Enums\Status::toArray() as $key => $status)
                                    <option value="{{ $status }}" @if($status == $paymentGateway->status) selected @endif>{{ replaceInputTitle($key) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="i-btn btn--primary btn--md mt-3"> {{ __('admin.button.save')}}</button>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('script-push')
    <script>
        "use strict";
        $(document).ready(function () {
            $("#currency_id").on('change', function(){
                const value = $(this).find("option:selected").text();
                $(".limit-text").text(value);
                $(".method-rate").val($('select[name=currency_id] :selected').data('rate_value'));
            }).change();
        });
    </script>
@endpush
