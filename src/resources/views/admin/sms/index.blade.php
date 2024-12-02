@extends('admin.layouts.main')
@section('panel')
    <section>
        <h3 class="page-title mb-4">{{ $setTitle }}</h3>
        <div class="filter-wrapper">
            <div class="card-filter">
                <form action="{{route('admin.sms.gateway.send')}}" method="POST" id="smsgateway">
                    @csrf
                    @method("PUT")
                    <select name="sms_gateway_id" class="form-select gateway">
                        @foreach($smsGateways as $smsGateway)
                            <option value="{{$smsGateway->id}}" @if($smsGateway->id == $setting->sms_gateway_id) selected @endif>{{__(ucfirst($smsGateway->name))}}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        @include('admin.partials.table', [
            'columns' => [
                'created_at' => __('admin.table.created_at'),
                'sms_gateway_name' => __('admin.table.gateway_name'),
                'status' => __('admin.table.status'),
                'action' => __('admin.table.action'),
            ],
            'rows' => $smsGateways,
            'page_identifier' => \App\Enums\PageIdentifier::SMS_GATEWAYS->value,
        ])
    </section>
@endsection

@push('script-push')
    <script>
        "use strict";
        $(document).ready(function () {
            $(".gateway").on('change', function () {
                $("#smsgateway").submit();
            });
        });
    </script>
@endpush



