@extends('admin.layouts.main')
@section('panel')
    <section>
        @include('admin.partials.table', [
            'columns' => [
                'full_name' => __('admin.table.name'),
                'email' => __('admin.table.email'),
                'user_kyc_status' => __('KYC Status'),
                'user_identity_information' => __('identity Information'),
                'action' => __('admin.table.action'),
            ],
            'rows' => $users,
            'page_identifier' => \App\Enums\PageIdentifier::KYC_IDENTITY->value,
       ])
    </section>

    <div class="modal fade" id="kycIdentityModal" tabindex="-1" aria-labelledby="credit-add-return" aria-hidden="true">
        <div class="modal-dialog modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Identity Verification Update')}}</h5>
                </div>
                <form action="{{route('admin.user.identity.update')}}" method="POST">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="id" value="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="kyc_status" class="form-label"> {{ __('KYC Status')}} <sup class="text--danger">*</sup></label>
                            <select class="form-select" name="kyc_status" id="kyc_status" required>
                                @foreach(\App\Enums\User\KycStatus::cases() as $status)
                                    @unless(in_array($status->value, [\App\Enums\User\KycStatus::REQUESTED->value]))
                                        <option value="{{ $status->value }}">{{ \App\Enums\User\KycStatus::getName($status->value) }}</option>
                                    @endunless
                                @endforeach
                            </select>
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

    <div class="modal fade" id="identity-information" tabindex="-1" aria-labelledby="list-wallet" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('KYC Identity Information') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="modal-identity-list modal-pay-list"></ul>
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
            $('.kyc_identity').on('click', function () {
                const modal = $('#kycIdentityModal');
                const id = $(this).data('id');
                modal.find('input[name=id]').val(id);
                modal.modal('show');
            });

            $('.identity-info').on('click', function () {
                $('.modal-identity-list').empty();
                const modal = $('#identity-information');
                const meta = $(this).data('meta');

                if (typeof meta === 'object' && Object.keys(meta).length !== 0) {
                    Object.keys(meta).forEach(key => {
                        const propertyName = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                        const propertyValue = meta[key];
                        const listItem = `<li>
                                <span>${propertyName}</span>
                                <span>${propertyValue}</span>
                              </li>`;
                        modal.find('.modal-identity-list').append(listItem);
                    });
                }

                modal.modal('show');
            });


        });
    </script>
@endpush
