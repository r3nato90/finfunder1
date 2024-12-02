@extends('admin.layouts.main')
@section('panel')
    <section>
        @include('admin.partials.filter', [
            'is_filter' => true,
            'is_modal' => false,
            'route' => route('admin.crypto.currencies.index'),
            'btn_name' => __('admin.filter.search'),
            'filters' => [
                [
                    'type' => \App\Enums\FilterType::SELECT_OPTIONS->value,
                    'value' => \App\Enums\Status::toArrayByKey(),
                    'name' => 'status',
                ],
                [
                    'type' => \App\Enums\FilterType::TEXT->value,
                    'name' => 'search',
                    'placeholder' => __('admin.filter.placeholder.crypto')
                ],
            ],
        ])
        @include('admin.partials.table', [
            'columns' => [
                'pair' => __('admin.table.pair'),
                'name' => __('admin.table.name'),
                'symbol' => __('admin.table.symbol'),
                'crypto_current_price' => __('admin.table.price'),
                'crypto_price_change_24h' => __('admin.table.daily_change'),
                'crypto_high_24h' => __('admin.table.daily_high'),
                'crypto_low_24h' => __('admin.table.daily_low'),
                'crypto_market_cap' => __('admin.table.market_cap'),
                'status' => __('admin.table.status'),
                'action' => __('admin.table.action'),
            ],
            'rows' => $cryptoCurrencies,
            'page_identifier' => \App\Enums\PageIdentifier::CRYPTO_CURRENCY->value,
       ])
    </section>

    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Update Status') }}</h5>
                </div>
                <form action="{{route('admin.crypto.currencies.update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="status">{{ __('admin.input.status') }} <sup class="text-danger">*</sup></label>
                                <select class="form-select" id="status" name="status">
                                    <option value="" selected>{{ __('admin.filter.placeholder.select') }}</option>
                                    @foreach(\App\Enums\Status::toArray() as $status_key =>  $status_value)
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
                const status = $(this).data('status');

                const modal = $('#updateModal');
                modal.find('input[name=id]').val(id);
                modal.find('select[name=status]').val(status);
                modal.modal('show');
            });
        });
    </script>
@endpush
