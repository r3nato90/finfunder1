@extends('admin.layouts.main')
@section('panel')
    <section>
        @include('admin.partials.filter', [
           'is_filter' => false,
           'is_modal' => true,
           'urls' => [
               [
                   'type' => 'modal',
                   'id' => 'timeTableModal',
                   'name' => __('Add New'),
                   'icon' => "<i class='las la-plus'></i>"
               ],
            ],
       ])

        @include('admin.partials.table', [
             'columns' => [
                 'created_at' => __('admin.table.created_at'),
                 'name' => __('admin.table.name'),
                 'time_table' => __('Time'),
                 'status' => __('Status'),
                 'action' => __('admin.table.action'),
             ],
             'rows' => $timeTables,
             'page_identifier' => \App\Enums\PageIdentifier::TIME_TABLE->value,
        ])
    </section>

    <div class="modal fade" id="timeTableModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Add Timetable') }}</h5>
                </div>
                <form action="{{route('admin.binary.timetable.store')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="name">{{ __('admin.input.name') }}<sup class="text-danger">*</sup></label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('admin.placeholder.name') }}">
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="time">{{ __('admin.input.time') }}<sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="number" name="time" id="time" class="form-control" placeholder="{{ __('admin.placeholder.time') }}" aria-describedby="basic-addon1">
                                    <span class="input-group-text" id="basic-addon1">{{ __('Hours') }}</span>
                                </div>
                                <small>{{ __("Interest will be accrued after the time you've indicated above") }}</small>
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
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Update Timetable') }}</h5>
                </div>
                <form action="{{route('admin.binary.timetable.update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="name">{{ __('admin.input.name') }}<sup class="text-danger">*</sup></label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('admin.placeholder.name') }}">
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="time">{{ __('admin.input.time') }}<sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="number" name="time" id="time" class="form-control" placeholder="{{ __('admin.placeholder.time') }}" aria-describedby="basic-addon1">
                                    <span class="input-group-text" id="basic-addon1">{{ __('Hours') }}</span>
                                </div>
                                <small>{{ __("Interest will be accrued after the time you've indicated above") }}</small>
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
                const name = $(this).data('name');
                const status = $(this).data('status');

                const modal = $('#updateModal');
                modal.find('input[name=id]').val(id);
                modal.find('input[name=time]').val(time);
                modal.find('input[name=name]').val(name);
                modal.find('select[name=status]').val(status);
                modal.modal('show');
            });
        });
    </script>
@endpush
