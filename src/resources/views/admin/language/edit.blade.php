@extends('admin.layouts.main')
@section('panel')
    <section>
        @include('admin.partials.filter', [
             'is_filter' => false,
             'is_modal' => true,
             'urls' => [
                [
                    'type' => 'modal',
                    'id' => 'keyAddModal',
                    'name' => 'Add New',
                    'icon' => "<i class='las la-plus'></i>"
                ],
                 [
                    'type' => 'modal',
                    'id' => 'keyImportModal',
                    'name' => 'Import Keywords',
                    'icon' => "<i class='las la-plus'></i>"
                ]
            ],
        ])
        <div class="card">
            <div class="responsive-table">
                <table>
                    <thead>
                        <tr>
                            <th>{{ __('Key') }}</th>
                            <th>{{__($language->name)}}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($json as $key => $jsonLanguage)
                        <tr>
                            <td data-label="Key">
                                {{ $key }}
                            </td>
                            <td data-label="{{__($language->name)}}">
                                {{ $jsonLanguage }}
                            </td>
                            <td data-label="Action">
                                <div class="d-flex align-items-center justify-content-md-start justify-content-end gap-1">
                                    <a href="javascript:void(0)" class="badge badge--primary-transparent keyUpdateBtn"
                                       data-toggle="modal"
                                       data-target="#keyUpdateModal"
                                       data-key="{{$key}}"
                                       data-value="{{$jsonLanguage}}"
                                    >{{ __('Edit') }}</a>

                                    <a href="javascript:void(0)" class="badge badge--danger-transparent keyDeleteBtn"
                                       data-toggle="modal"
                                       data-target="#keyDeleteModal"
                                       data-key="{{$key}}"
                                       data-value="{{$jsonLanguage}}"
                                        >{{ __('Delete') }}</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-muted text-center" colspan="100%">{{ __('No Data Found')}}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <div class="modal fade" id="keyAddModal" tabindex="-1" role="dialog" aria-labelledby="keyAddModal" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >@lang('Add Language Value')</h5>
                </div>
                <form action="{{route('admin.language.store.key', $language->id)}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="key">@lang('Key') <sup class="text-danger">*</sup></label>
                                <input type="text" name="key" id="key" class="form-control" placeholder="@lang('Enter key')">
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="value">@lang('Value') <sup class="text-danger">*</sup></label>
                                <input type="text" name="value" id="value" class="form-control" placeholder="@lang('Enter value')">
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

    <div class="modal fade" id="keyUpdateModal" tabindex="-1" role="dialog" aria-labelledby="keyUpdateModal" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >@lang('Update Language Value')</h5>
                </div>
                <form action="{{route('admin.language.update.key', $language->id)}}" method="POST">
                    @csrf
                    <input type="hidden" name="key" value="">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="value">@lang('Value') <sup class="text-danger">*</sup></label>
                                <input type="text" name="value" id="value" class="form-control" placeholder="@lang('Enter value')">
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

    <div class="modal fade" id="keyDeleteModal" tabindex="-1" role="dialog" aria-labelledby="keyDeleteModal" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Confirm Language Value Deletion')</h5>
                </div>
                <form action="{{route('admin.language.delete.key', $language->id)}}" method="POST">
                    @csrf
                    <input type="hidden" name="key">
                    <input type="hidden" name="value">

                    <div class="modal-body">
                        <div class="row">
                            <p>@lang('Are you sure you want to delete this Language value?')</p>
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


    <div class="modal fade" id="keyImportModal" tabindex="-1" role="dialog" aria-labelledby="keyImportModal" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Import Language')</h5>
                </div>
                <form action="{{route('admin.language.import', $language->id)}}" method="POST">
                    @csrf


                    <div class="modal-body">
                        <div class="row">
                            <p>@lang('When importing keywords, your existing ones will be removed and substituted with the imported ones')</p>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <label class="form-label" for="from_language">@lang('Language')</label>
                            <select class="form-select" id="from_language" name="from_language">
                                <option value="" selected disabled>@lang('Select One')</option>
                                @foreach($languages as $data)
                                    @unless($data->id == $language->id)
                                        <option value="{{$data->id}}">{{__($data->name)}}</option>
                                    @endunless
                                @endforeach
                            </select>
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
@endsection

@push('script-push')
    <script>
        "use strict";
        $(document).ready(function () {
            $(".keyUpdateBtn").on('click', function(event) {
                event.preventDefault();
                const key = $(this).data('key');
                const value = $(this).data('value');

                const modal = $('#keyUpdateModal');
                modal.find('input[name=key]').val(key);
                modal.find('input[name=value]').val(value);
                modal.modal('show');
            });

            $('.keyDeleteBtn').on('click', function(event) {
                event.preventDefault();
                const key = $(this).data('key');
                const value = $(this).data('value')

                const modal = $('#keyDeleteModal');
                modal.find('input[name=key]').val(key);
                modal.find('input[name=value]').val(value);
                modal.modal('show');
            });
        });
    </script>
@endpush
