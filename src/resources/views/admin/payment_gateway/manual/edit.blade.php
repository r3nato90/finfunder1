@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="container-fluid p-0">
            <div class="card">
                <div class="card-header">
                    <h4>{{__($setTitle)}}</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.manual.gateway.update', $traditionalGateway->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-wrapper">
                            <div class="row mb-3 g-3">
                                <div class="mb-3 col-lg-6">
                                    <label for="name" class="form-label"> {{ __('admin.input.name')}} <sup class="text--danger">*</sup></label>
                                    <input type="text" name="name" id="name" value="{{ $traditionalGateway->name }}" class="form-control" placeholder=" {{ __('Enter Name')}}" required="">
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="percent_charge" class="form-label"> {{ __('admin.input.percent_charge')}} <sup class="text--danger">*</sup></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="percent_charge" value="{{ getAmount($traditionalGateway->percent_charge) }}" name="percent_charge" placeholder="{{ __('Enter Number')}}" aria-describedby="basic-addon2">
                                        <span class="input-group-text" id="basic-addon2">%</span>
                                    </div>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="currency_name" class="form-label"> {{ __('admin.input.currency_name')}} <sup class="text--danger">*</sup></label>
                                    <input type="text" name="currency" value="{{ $traditionalGateway->currency }}" id="currency_name" class="form-control" placeholder="{{__('Enter Currency Name')}}">
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="rate" class="form-label"> {{ __('admin.input.rate')}} <sup class="text--danger">*</sup></label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">{{ getCurrencySymbol()}}1 = </span>
                                        <input type="text" name="rate" id="rate" value="{{ getAmount($traditionalGateway->rate) }}" class="method-rate form-control" aria-label="Amount (to the nearest dollar)">
                                    </div>
                                </div>


                                <div class="mb-3 col-lg-6">
                                    <label for="minimum" class="form-label"> {{ __('Minimum Amount')}} <sup class="text--danger">*</sup></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="minimum" name="minimum" value="{{getAmount($traditionalGateway->minimum)}}" placeholder="{{ __('Enter Number')}}" aria-describedby="basic-addon2">
                                        <span class="input-group-text" id="basic-addon2">{{  getCurrencyName() }}</span>
                                    </div>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="maximum" class="form-label"> {{ __('Maximum Amount')}} <sup class="text--danger">*</sup></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="maximum" name="maximum" value="{{getAmount($traditionalGateway->maximum)}}" placeholder="{{ __('Enter Number')}}" aria-describedby="basic-addon2">
                                        <span class="input-group-text" id="basic-addon2">{{  getCurrencyName() }}</span>
                                    </div>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="image" class="form-label"> {{ __('admin.input.image')}} <sup class="text--danger">*</sup></label>
                                    <input type="file" name="image" id="image" class="form-control">
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="status" class="form-label"> {{ __('admin.input.status')}} <sup class="text--danger">*</sup></label>
                                    <select class="form-select" name="status" id="status" required>
                                        @foreach(\App\Enums\Status::toArray() as $key =>  $status)
                                            <option value="{{ $status }}" @if($traditionalGateway->status == $status) selected @endif>{{ replaceInputTitle($key) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-12">
                                    <label for="details" class="form-label"> {{ __('Payment Details')}} <sup class="text--danger">*</sup></label>
                                    <textarea class="summernote" name="details" id="details">@php echo $traditionalGateway->details @endphp</textarea>
                                </div>
                            </div>
                        </div>
                        @include('admin.partials.custom-field', [
                            'parameter' => $traditionalGateway->parameter,
                            'title' => __('admin.content.gateway'),
                            'details' => __('admin.content.gateway_details')
                        ])
                        <button type="submit" class="i-btn btn--primary btn--md text--white"> {{ __('admin.button.update')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection


@push('script-push')
    <script>
        'use strict'
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 300,
                placeholder: 'Enter Payment Details',
                dialogsInBody: true,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert', ['picture', 'link', 'video']],
                ],
                callbacks: {
                    onInit: function() {
                    }
                }
            });
        });
    </script>
@endpush
