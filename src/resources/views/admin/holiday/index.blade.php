@extends('admin.layouts.main')
@section('panel')
    <section>
        @include('admin.partials.filter', [
           'is_filter' => false,
           'is_modal' => true,
           'urls' => [
               [
                   'type' => 'modal',
                   'id' => 'holidaySettingModal',
                   'name' => __('Add New'),
                   'icon' => "<i class='las la-plus'></i>"
               ],
               [
                   'type' => 'modal',
                   'id' => 'weeklySettingModal',
                   'name' => __('Weekly Holiday'),
                   'icon' => "<i class='las la-cog'></i>"
               ],
           ],
       ])
        @include('admin.partials.table', [
             'columns' => [
                 'name' => __('admin.table.name'),
                 'holiday_date' => __('Date'),
                 'action' => __('admin.table.action'),
             ],
             'rows' => $holidays,
             'page_identifier' => \App\Enums\PageIdentifier::HOLIDAY_SETTING->value,
        ])
    </section>

    <div class="modal fade" id="weeklySettingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Weekly Holiday Setting') }}</h5>
                </div>
                <form action="{{route('admin.binary.holiday-setting.setting')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="form-label">{{ __('Select weekly holidays') }}</label>
                                @foreach(['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'] as $value)
                                    <div class="form-check">
                                        <input class="form-check-input" @if(in_array($value, (array)$setting->holiday_setting)) checked @endif type="checkbox" id="{{ $value }}" name="holidays[]" value="{{ $value }}">
                                        <label class="form-check-label" for="{{ $value }}">{{ __(ucfirst($value)) }}</label>
                                    </div>
                                @endforeach
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

    <div class="modal fade" id="holidaySettingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Add Holiday') }}</h5>
                </div>
                <form action="{{route('admin.binary.holiday-setting.store')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="name">{{ __('admin.input.name') }}<sup class="text-danger">*</sup></label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('admin.placeholder.name') }}">
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="name">{{ __('Date') }}<sup class="text-danger">*</sup></label>
                                <input type="date" name="date" id="date" class="form-control">
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
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Update Holiday') }}</h5>
                </div>
                <form action="{{ route('admin.binary.holiday-setting.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="name">{{ __('admin.input.name') }}<sup class="text-danger">*</sup></label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('admin.placeholder.name') }}">
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="name">{{ __('Date') }}<sup class="text-danger">*</sup></label>
                                <input type="date" name="date" id="date" class="form-control">
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
                const name = $(this).data('name');
                const date = $(this).data('date');

                const modal = $('#updateModal');
                modal.find('input[name=id]').val(id);
                modal.find('input[name=name]').val(name);
                modal.find('input[name=date]').val(date);
                modal.modal('show');
            });
        });
    </script>
@endpush
