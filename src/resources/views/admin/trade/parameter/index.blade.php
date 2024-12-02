@extends('admin.layouts.main')
@section('panel')
    <section>
        @include('admin.partials.filter', [
            'is_filter' => false,
            'is_modal' => true,
            'urls' => [
                [
                    'type' => 'modal',
                    'id' => 'exampleModal',
                    'name' => __('admin.filter.add_parameter'),
                    'icon' => "<i class='fas fa-plus'></i>"
                ]
            ],
        ])

        @include('admin.partials.table', [
            'columns' => [
                'created_at' => __('admin.table.created_at'),
                'parameter' => __('admin.table.parameter'),
                'status' => __('admin.table.status'),
                'action' => __('admin.table.action'),
            ],
            'rows' => $tradeParameters,
            'page_identifier' => \App\Enums\PageIdentifier::TRADE_PARAMETER->value,
        ])
    </section>


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('admin.trade_parameter.content.add_title') }}</h5>
                </div>
                <form action="{{route('admin.trade.parameter.store')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="time">{{ __('admin.input.time') }}<sup class="text-danger">*</sup></label>
                                <input type="number" name="time" id="time" class="form-control" placeholder="{{ __('admin.placeholder.time') }}">
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="unit">{{ __('admin.input.unit') }} <sup class="text-danger">*</sup></label>
                                <select class="form-select" id="unit" name="unit">
                                    <option value="" selected>{{ __('admin.filter.placeholder.select') }}</option>
                                    @foreach(\App\Enums\Trade\TradeParameterUnit::toArray() as $key =>  $status)
                                        <option value="{{ $status }}">{{ replaceInputTitle($key) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="status">{{ __('admin.input.status') }} <sup class="text-danger">*</sup></label>
                                <select class="form-select" id="status" name="status">
                                    <option value="" selected>{{ __('admin.filter.placeholder.select') }}</option>
                                    @foreach(\App\Enums\Trade\TradeParameterStatus::toArray() as $key =>  $status)
                                        <option value="{{ $status }}">{{ replaceInputTitle($key) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn--outline btn--sm" data-bs-dismiss="modal">{{ __('admin.button.close') }}</button>
                        <button type="submit" class="btn btn--primary btn--sm">{{ __('admin.button.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('admin.trade_parameter.content.update_title') }}</h5>
                </div>
                <form action="{{route('admin.trade.parameter.update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="time">{{ __('admin.input.time') }} <sup class="text-danger">*</sup></label>
                                <input type="number" name="time" id="time" class="form-control">
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="unit">{{ __('admin.input.unit') }} <sup class="text-danger">*</sup></label>
                                <select class="form-select" id="unit" name="unit">
                                    <option value="" selected>{{ __('admin.filter.placeholder.select') }}</option>
                                    @foreach(\App\Enums\Trade\TradeParameterUnit::toArray() as $key =>  $status)
                                        <option value="{{ $status }}">{{ replaceInputTitle($key) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="status">{{ __('admin.input.status') }} <sup class="text-danger">*</sup></label>
                                <select class="form-select" id="status" name="status">
                                    <option value="" selected>{{ __('admin.filter.placeholder.select') }}</option>
                                    @foreach(\App\Enums\Trade\TradeParameterStatus::toArray() as $status_key =>  $status_value)
                                        <option value="{{ $status_value }}">{{ replaceInputTitle($status_key) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn--outline btn--sm" data-bs-dismiss="modal">{{ __('admin.button.close') }}</button>
                        <button type="submit" class="btn btn--primary btn--sm">{{ __('admin.button.update') }}</button>
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
            $('.updateBtn').on('click', function(event) {
                event.preventDefault();
                const id = $(this).data('id');
                const time = $(this).data('time');
                const unit = $(this).data('unit');
                const status = $(this).data('status');

                const modal = $('#updateModal');
                modal.find('input[name=id]').val(id);
                modal.find('input[name=time]').val(time);
                modal.find('select[name=unit]').val(unit);
                modal.find('select[name=status]').val(status);
                modal.modal('show');
            });
        });
    </script>
@endpush



