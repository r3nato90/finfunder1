@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="container-fluid p-0">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{__($setTitle)}}</h4>
                </div>

                <div class="card-body">
                    <form action="{{route('admin.withdraw.method.update', $withdrawMethod->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-wrapper">
                            <div class="row g-3">
                                <div class="mb-3 col-lg-6 col-md-12">
                                    <label for="name" class="form-label"> @lang('Gateway Name') <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{$withdrawMethod->name}}" required>
                                </div>

                                <div class="mb-3 col-lg-6 col-md-12">
                                    <label for="currency_name" class="form-label"> @lang('Currency Name') <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="currency_name" id="currency_name" value="{{$withdrawMethod->currency_name}}" required>
                                </div>

                                <div class="mb-3 col-lg-6 col-md-12">
                                    <label for="min_limit" class="form-label"> @lang('Minimum Limit') <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="min_limit" id="min_limit" value="{{getAmount($withdrawMethod->min_limit)}}" required>
                                </div>

                                <div class="mb-3 col-lg-6 col-md-12">
                                    <label for="max_limit" class="form-label"> @lang('Maximum Limit') <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="max_limit" id="max_limit" value="{{getAmount($withdrawMethod->max_limit)}}" required>
                                </div>

                                <div class="mb-3 col-lg-6 col-md-12">
                                    <label for="percent_charge" class="form-label">@lang('Percent Charge') <sup class="text-danger">*</sup></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="percent_charge"
                                            name="percent_charge"
                                            value="{{getAmount($withdrawMethod->percent_charge)}}"
                                            aria-describedby="basic-addon2">
                                        <span class="input-group-text" id="basic-addon2">%</span>
                                    </div>
                                </div>

                                <div class="mb-3 col-lg-6 col-md-12">
                                    <label for="fixed_charge" class="form-label"> @lang('Fixed Charge') <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="fixed_charge" id="fixed_charge" value="{{getAmount($withdrawMethod->fixed_charge)}}" required>
                                </div>

                                <div class="mb-3 col-lg-6 col-md-12">
                                    <label for="rate" class="form-label">@lang('Currency Rate') <sup class="text-danger">*</sup></label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">{{ getCurrencySymbol() }}1 = </span>
                                        <input type="text" id="rate" name="rate" placeholder="@lang('Enter Number')"
                                            value="{{getAmount($withdrawMethod->rate)}}"
                                            class="method-rate form-control"
                                            aria-label="Amount (to the nearest dollar)">
                                    </div>
                                </div>

                                <div class="form-group col-lg-6">
                                    <label for="status">@lang('Status') <sup class="text-danger">*</sup></label>
                                    <select class="form-select" name="status" id="status" required>
                                        @foreach(\App\Enums\Status::toArray() as $key =>  $status)
                                            <option value="{{ $status }}" @if($withdrawMethod->status == $status) selected @endif>{{ replaceInputTitle($key) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        @include('admin.partials.custom-field', [
                            'parameter' => $withdrawMethod->parameter,
                            'title' => "Withdraw Information",
                            'details' => "Add information to get back from your customer withdraw method, please click add a new button on the right side"
                        ])
                        <button class="w-100 btn btn-primary">@lang('Submit')</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
