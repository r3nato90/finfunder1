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
                    'name' => 'Add New',
                    'icon' => "<i class='las la-plus'></i>"
                ],
            ],
        ])
        @include('admin.partials.table', [
            'columns' => [
                'created_at' => __('Initiated At'),
                'name' => __('Name'),
                'url' => __('Url'),
                'menu_parent_id' => __('Parent'),
                'menu_action' => __('Action'),
            ],
            'rows' => $paginateByMenus,
            'page_identifier' => \App\Enums\PageIdentifier::MENU->value,
       ])
    </section>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Add New Menu')</h5>
                </div>
                <form action="{{route('admin.pages.store')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="name">@lang('Name') <sup class="text-danger">*</sup></label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="@lang('Enter Name')">
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="url">@lang('Url') <sup class="text-danger">*</sup></label>
                                <input type="text" name="url" id="url" class="form-control" placeholder="@lang('Enter Url')">
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="parent_id">@lang('Parent')</label>
                                <select class="form-select" id="parent_id" name="parent_id">
                                    <option value="" selected>@lang('None')</option>
                                    @foreach($menus as $menu)
                                        <option value="{{$menu->id}}">{{__($menu->name)}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="status">@lang('Status')</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="" selected disabled>@lang('Select Status')</option>
                                    <option value="{{\App\Enums\MenuStatus::ENABLE->value}}">@lang('Enable')</option>
                                    <option value="{{\App\Enums\MenuStatus::DISABLE->value}}">@lang('Disable')</option>
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

    <div class="modal fade" id="menuUpdateModal" tabindex="-1" role="dialog" aria-labelledby="menuUpdateModal" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >@lang('Update Menu')</h5>
                </div>
                <form action="{{route('admin.pages.update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="editName">@lang('Name') <sup class="text-danger">*</sup></label>
                                <input type="text" name="name" id="editName" class="form-control" placeholder="@lang('Enter Name')">
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="editUrl">@lang('Url') <sup class="text-danger">*</sup></label>
                                <input type="text" name="url" id="editUrl" class="form-control" placeholder="@lang('Enter Url')">
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="editParent_id">@lang('Parent')</label>
                                <select class="form-select" id="editParent_id" name="parent_id">
                                    <option value="" selected>@lang('None')</option>
                                    @foreach($menus as $menu)
                                        <option value="{{$menu->id}}">{{__($menu->name)}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="editStatus">@lang('Status')</label>
                                <select class="form-select" id="editStatus" name="status">
                                    <option value="" selected disabled>@lang('Select Status')</option>
                                    <option value="{{\App\Enums\MenuStatus::ENABLE->value}}">@lang('Enable')</option>
                                    <option value="{{\App\Enums\MenuStatus::DISABLE->value}}">@lang('Disable')</option>
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

    <div class="modal fade" id="menuDeleteModal" tabindex="-1" role="dialog" aria-labelledby="menuDeleteModal" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Confirm Menu Deletion')</h5>
                </div>
                <form action="{{route('admin.pages.delete')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <p>@lang('Are you sure you want to delete this menu?')</p>
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
            $(".menuUpdateBtn").on('click', function(event) {
                event.preventDefault();
                const id = $(this).data('id');
                const name = $(this).data('name');
                const url = $(this).data('url');
                const status = $(this).data('status');
                const parentId = $(this).data('parent_id');

                const modal = $('#menuUpdateModal');
                modal.find('input[name=id]').val(id);
                modal.find('input[name=name]').val(name);
                modal.find('input[name=url]').val(url);
                modal.find('select[name=parent_id]').val(parentId);
                modal.find('select[name=status]').val(status);
                modal.modal('show');
            });

            $(document).on('click', '.menuDeleteBtn', function(event) {
                event.preventDefault();
                const id = $(this).data('id');
                const modal = $('#menuDeleteModal');
                modal.find('input[name=id]').val(id);
                modal.modal('show');
            });

            $('.select2').select2({
                tags: true,
                tokenSeparators: [',']
            });
        });
    </script>
@endpush
