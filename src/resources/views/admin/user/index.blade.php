@extends('admin.layouts.main')
@section('panel')
    <section>
        @include('admin.partials.filter', [
            'is_filter' => true,
            'is_modal' => false,
            'route' => route('admin.user.index'),
            'btn_name' => __('admin.filter.search'),
            'filters' => [
                [
                    'type' => \App\Enums\FilterType::SELECT_OPTIONS->value,
                    'value' => \App\Enums\User\Status::toArrayByKey(),
                    'name' => 'status',
                ],
                [
                    'type' => \App\Enums\FilterType::TEXT->value,
                    'name' => 'search',
                    'placeholder' => __('admin.filter.placeholder.user')
                ],
                [
                    'type' => \App\Enums\FilterType::DATE_RANGE->value,
                    'name' => 'date',
                    'placeholder' => __('admin.filter.placeholder.date')
                ]
            ],
        ])
        @include('admin.partials.table', [
            'columns' => [
                'created_at' => __('admin.table.joined'),
                'full_name' => __('admin.table.name'),
                'email' => __('admin.table.email'),
                'user_wallet' => __('admin.table.wallet'),
                'user_kyc_status' => __('KYC Status'),
                'user_add_subtract' => __('admin.table.add_subtract'),
                'status' => __('admin.table.status'),
                'action' => __('admin.table.action'),
            ],
            'rows' => $users,
            'page_identifier' => \App\Enums\PageIdentifier::USER->value,
       ])
    </section>

    <div class="modal fade" id="credit-add-return" tabindex="-1" aria-labelledby="credit-add-return" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('admin.user.content.add_subtract')}}</h5>
                </div>
                <form action="{{route('admin.user.add-subtract.balance')}}" method="POST">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="id" value="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="type" class="form-label"> {{ __('admin.input.type')}} <sup class="text--danger">*</sup></label>
                            <select class="form-select" name="type" id="type" required>
                                @foreach(\App\Enums\Transaction\Type::toArray() as  $status)
                                    <option value="{{ $status }}">{{ \App\Enums\Transaction\Type::getName($status) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="wallet_type" class="form-label"> {{ __('admin.input.select_wallet')}} <sup class="text--danger">*</sup></label>
                            <select class="form-select" name="wallet_type" id="wallet_type" required>
                                @foreach(\App\Enums\Transaction\WalletType::toArray() as  $status)
                                    <option value="{{ $status }}">{{ \App\Enums\Transaction\WalletType::getName($status) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label"> {{ __('admin.input.amount')}} <sup class="text--danger">*</sup></label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="amount" name="amount"
                                    placeholder="{{__('admin.placeholder.number')}}" aria-label="Recipient's username"
                                    aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2">{{getCurrencyName()}}</span>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="d-flex align-items-center gap-3">
                            <button type="button" class="btn btn--outline btn--sm" data-bs-dismiss="modal"> {{ __('admin.button.cancel')}}</button>
                            <button type="submit" class="btn btn--primary btn--sm"> {{ __('admin.button.save')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="list-wallet" tabindex="-1" aria-labelledby="list-wallet" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('admin.user.content.wallet') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="modal-pay-list"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--danger btn--sm" data-bs-dismiss="modal">{{ __('admin.button.closed') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-push')
    <script>
        "use strict";
        $(document).ready(function () {
            $('.created-update').on('click', function () {
                const modal = $('#credit-add-return');
                const id = $(this).data('id');
                modal.find('input[name=id]').val(id);
                modal.modal('show');
            });

            $('.wallets').on('click', function () {
                $('.modal-pay-list').empty();
                const modal = $('#list-wallet');
                const walletData = $(this).data('id');
                const currency = "{{ getCurrencySymbol() }}";
                const walletProperties = ['primary_balance', 'investment_balance', 'trade_balance', 'practice_balance'];
                walletProperties.forEach(property => {
                    const propertyName = property.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                    const balanceValue = currency + parseFloat(walletData[property]).toFixed(2);
                    const listItem = `<li>
                            <span>${propertyName}</span>
                            <span>${balanceValue}</span>
                          </li>`;

                    modal.find('.modal-pay-list').append(listItem);
                });

                modal.modal('show');
            });
        });
    </script>
@endpush
