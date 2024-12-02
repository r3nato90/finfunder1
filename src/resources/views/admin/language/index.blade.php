@extends('admin.layouts.main')
@section('panel')
    <section>
        @include('admin.partials.filter', [
             'is_filter' => false,
             'is_modal' => true,
             'urls' => [
                [
                    'type' => 'modal',
                    'id' => 'languageModel',
                    'name' => 'Add New',
                    'icon' => "<i class='las la-plus'></i>"
                ],
            ],
        ])
        @include('admin.partials.table', [
            'columns' => [
                'created_at' => __('Initiated At'),
                'name' => __('Name'),
                'code' => __('Code'),
                'language_is_default' => __('Default'),
                'language_action' => __('Action'),
            ],
            'rows' => $languages,
            'page_identifier' => \App\Enums\PageIdentifier::LANGUAGE->value,
       ])
    </section>

    <div class="modal fade" id="languageModel" tabindex="-1" role="dialog" aria-labelledby="languageModal" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >@lang('Add New Language')</h5>
                </div>
                <form action="{{route('admin.language.store')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="name">@lang('Name') <sup class="text-danger">*</sup></label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="@lang('Enter Name')">
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="code">@lang('Code') <sup class="text-danger">*</sup></label>
                                <input type="text" name="code" id="code" class="form-control" placeholder="@lang('Enter Code')">
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="is_default">@lang('Default')</label>
                                <select class="form-select" id="is_default" name="is_default">
                                    <option value="" selected disabled>@lang('Select One')</option>
                                    <option value="{{\App\Enums\Status::ACTIVE->value}}">@lang('Yes')</option>
                                    <option value="{{\App\Enums\Status::INACTIVE->value}}">@lang('No')</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn--outline btn--sm" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary btn--sm">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="languageUpdateModal" tabindex="-1" role="dialog" aria-labelledby="languageUpdateModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Update Language')</h5>
                </div>
                <form action="{{route('admin.language.update')}}" method="POST">
                    @csrf

                    <input type="hidden" name="id" value="">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="name">@lang('Name') <sup class="text-danger">*</sup></label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="@lang('Enter Name')">
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="is_default">@lang('Default')</label>
                                <select class="form-select" id="is_default" name="is_default">
                                    <option value="" selected disabled>@lang('Select One')</option>
                                    <option value="{{\App\Enums\Status::ACTIVE->value}}">@lang('Yes')</option>
                                    <option value="{{\App\Enums\Status::INACTIVE->value}}">@lang('No')</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn--outline btn--sm" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary btn--sm">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="languageDeleteModal" tabindex="-1" role="dialog" aria-labelledby="languageDeleteModal" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Confirm Language Deletion')</h5>
                </div>
                <form action="{{route('admin.language.delete')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <p>@lang('Are you sure you want to delete this Language?')</p>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn--outline btn--sm" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary btn--sm">@lang('Delete')</button>
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
            $(".languageUpdateBtn").on('click', function(event) {
                event.preventDefault();
                const id = $(this).data('id');
                const name = $(this).data('name');
                const isDefault = $(this).data('is_default');

                const modal = $('#languageUpdateModal');
                modal.find('input[name=id]').val(id);
                modal.find('input[name=name]').val(name);
                modal.find('select[name=is_default]').val(isDefault);
                modal.modal('show');
            });

            $('.languageDeleteBtn').on('click', function(event) {
                event.preventDefault();
                const id = $(this).data('id');
                const modal = $('#languageDeleteModal');
                modal.find('input[name=id]').val(id);
                modal.modal('show');
            });
        });
    </script>
@endpush
