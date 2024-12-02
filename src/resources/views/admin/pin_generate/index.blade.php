@extends('admin.layouts.main')
@section('panel')
    <section>
        @include('admin.partials.filter', [
           'is_filter' => true,
           'is_modal' => true,
           'route' => route('admin.pin.index'),
           'btn_name' => __('admin.filter.search'),
           'filters' => [
               [
                   'type' => \App\Enums\FilterType::SELECT_OPTIONS->value,
                   'value' => [
                       'all' => __('All Pins').' '.($total_pin),
                       'unused' => __('Unused Pins').' '.($total_unused_pin),
                       'used' => __('Used Pins').' '.($total_utilized_pin),
                       'users' => __('User Pins').' '.($total_users_pin),
                       'admins' => __('Administrator Pins').' '.($total_admins_pin),
                   ],
                   'name' => 'status',
               ],
               [
                   'type' => \App\Enums\FilterType::TEXT->value,
                   'name' => 'search',
                   'placeholder' => __('admin.filter.placeholder.pin_number')
               ],
               [
                   'type' => \App\Enums\FilterType::DATE_RANGE->value,
                   'name' => 'date',
                   'placeholder' => __('admin.filter.placeholder.date')
               ]
           ],
           'urls' => [
               [
                   'type' => 'modal',
                   'id' => 'exampleModal',
                   'name' => __('admin.filter.generate_pin'),
                   'icon' => "<i class='las la-plus'></i>"
               ],
            ],
       ])
        @include('admin.partials.table', [
             'columns' => [
                 'created_at' => __('admin.table.created_at'),
                 'set_user_id' => __('admin.table.name'),
                 'amount' => __('admin.table.amount'),
                 'pin_number' => __('admin.table.pin_number'),
                 'status' => __('admin.table.status'),
                 'details' => __('admin.table.details')
             ],
             'rows' => $pins,
             'page_identifier' => \App\Enums\PageIdentifier::PIN_GENERATE->value,
        ])
    </section>


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('admin.pin.content.generated') }}</h5>
                </div>
                <form action="{{route('admin.pin.store')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="amount">{{ __('admin.input.amount') }} <sup class="text-danger">*</sup></label>
                                <input type="text" name="amount" id="amount" class="form-control" placeholder="{{ __('admin.placeholder.amount') }}">
                            </div>

                            <div class="col-lg-12">
                                <label class="form-label" for="number">{{ __('admin.input.number') }} <sup class="text-danger">*</sup></label>
                                <input type="text" name="number" id="number" class="form-control" placeholder="{{ __('admin.placeholder.number') }}">
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
@endsection

@push('script-push')
    <script>
        "use strict";
        $(document).ready(function () {
            $('.reference-copy').click(function() {
                const copyText = $(this).data('pin');
                const textArea = document.createElement('textarea');
                textArea.value = copyText;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                notify('success', 'Copied to clipboard!');
            });
        });
    </script>
@endpush
