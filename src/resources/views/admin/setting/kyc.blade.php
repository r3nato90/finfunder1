@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{__($setTitle)}}</h4>
                <button id="add-kyc-setting-option" class="i-btn btn--primary btn--md">
                    <i class="las la-plus me-1"></i>{{ __('Add More') }}
                </button>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.general.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="{{ \App\Enums\GeneralSetting::KYC_CONFIGURATION->value }}">
                    <div class="table-container verification-table">
                        <table class="align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('Labels') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Required') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody id="ticketField">
                            @foreach($setting->kyc_configuration as $key => $value)
                                @include('admin.partials.kyc_option_row', ['key' => $key, 'value' => $value])
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <button class="i-btn btn--primary btn--lg mt-4">{{ __('Submit') }}</button>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('script-push')
    <script>
        "use strict";
        $(document).ready(function () {
            let count = {{ count($setting->kyc_configuration) - 1 }};

            function createKycOptionRow(count) {
                return `@include('admin.partials.kyc_option_row', ['key' => '${count}', 'value' => null])`;
            }

            $(document).on('click', '#add-kyc-setting-option', function (e) {
                count++;
                const html = createKycOptionRow(count);
                $('#ticketField').append(html);
                e.preventDefault();
            });

            $(document).on('click', '.delete-key-setting-option', function (e) {
                $(this).closest("tr").remove();
                count--;
                e.preventDefault();
            });

            // Handle dropdown type change
            $(document).on('change', '.type-dropdown', function () {
                const selectedType = $(this).val();
                const isButtonRequired = ['select', 'checkbox', 'radio'].includes(selectedType);
                const optionsHtml = isButtonRequired ? '<button class="add-dropdown-options btn btn--primary btn--sm mb-3">{{ __("Add") }}</button>' : '';
                $(this).closest('td').find('.add-options').html(optionsHtml);
            });

            // Add options for dropdown type
            $(document).on('click', '.add-options', function (e) {
                const html = addDropdownOptions(count);
                $(this).siblings('.optionsFiled').append(html);
                e.preventDefault();
            });

            function addDropdownOptions(count) {
                return '<div class="dropdown-option d-flex justify-content-end mb-2">' +
                    '<input type="text" class="form-control rounded-end-0" name="kyc_configuration[' + count + '][options][]" value="">' +
                    '<a href="#" class="remove-dropdown-option btn btn--danger btn--sm rounded-end rounded-start-0"><i class="bi bi-x-lg"></i></a>' +
                    '</div>';
            }

            // Remove dropdown option
            $(document).on('click', '.remove-dropdown-option', function (e) {
                $(this).closest('.dropdown-option').remove();
                e.preventDefault();
            });
        });
    </script>

@endpush


