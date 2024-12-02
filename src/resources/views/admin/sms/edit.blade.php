@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-start">{{__('Short Codes')}}</h4>
            </div>

            <form id="setting-form" action="{{route('admin.sms.gateway.update',$smsGateway->id)}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-wrapper">
                        <div class="row gy-4">
                            @foreach($smsGateway->credential as $key => $parameter)
                                <div class="col-12">
                                    <label for="{{$key}}" class="form-label">{{ucwords(str_replace('_', ' ', $key))}}</label>
                                    <input type="text" name="sms_method[{{$key}}]" id="{{$key}}" value="{{$parameter}}" class="form-control" placeholder="@lang('Enter Valid API Data')" required>
                                </div>
                            @endforeach

                            <div class="col-12">
                                <label for="status" class="form-label">@lang('Status')</label>
                                <select class="form-select" name="status" id="status" required>
                                    @foreach(\App\Enums\Status::toArray() as $key =>  $status)
                                        <option value="{{ $status }}" @if($status == $smsGateway->status) selected @endif>{{ replaceInputTitle($key) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="i-btn btn--primary btn--lg">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </section>
@endsection
