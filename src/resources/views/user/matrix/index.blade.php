@extends('layouts.user')
@section('content')
    <div class="main-content" data-simplebar>
        <div class="row">
            <div class="col-lg-12">
                @if($matrixLog)
                    <div class="i-card-sm mb-4">
                        <h4 class="title">{{ __('Matrix Enrolled Information') }}</h4>
                        <div class="row g-3 row-cols-xl-4 row-cols-lg-4 row-cols-md-4 row-cols-sm-2 row-cols-1">
                            <div class="col">
                                <div class="i-card-sm p-3 primary--light shadow-none p-3">
                                    <p class="fs-15">{{ __('Initiated At') }}</p>
                                    <h5 class="title-sm mb-0">{{ showDateTime($matrixLog->created_at) }}</h5>
                                </div>
                            </div>
                            <div class="col">
                                <div class="i-card-sm p-3 primary--light shadow-none p-3">
                                    <p class="fs-15">{{ __('Trx') }}</p>
                                    <h5 class="title-sm mb-0">{{ $matrixLog->trx }}</h5>
                                </div>
                            </div>
                            <div class="col">
                                <div class="i-card-sm p-3 primary--light shadow-none p-3">
                                    <p class="fs-15">{{ __('Schema Name') }}</p>
                                    <h5 class="title-sm mb-0">{{ $matrixLog->name }}</h5>
                                </div>
                            </div>
                            <div class="col">
                                <div class="i-card-sm p-3 primary--light shadow-none p-3">
                                    <p class="fs-15">{{ __('Invest Amount') }}</p>
                                    <h5 class="title-sm mb-0">{{ getCurrencySymbol() }}{{shortAmount($matrixLog->price)}}</h5>
                                </div>
                            </div>
                            <div class="col">
                                <div class="i-card-sm p-3 primary--light shadow-none p-3">
                                    <p class="fs-15">{{ __('User-Based Referral Bonus') }}</p>
                                    <h5 class="title-sm mb-0">{{ getCurrencySymbol() }}{{shortAmount($matrixLog->referral_reward)}}</h5>
                                </div>
                            </div>
                            <div class="col">
                                <div class="i-card-sm p-3 primary--light shadow-none p-3">
                                    <p class="fs-15">{{ __('Referral Commission') }}</p>
                                    <h5 class="title-sm mb-0">{{ getCurrencySymbol() }}{{shortAmount($matrixLog->referral_commissions)}}</h5>
                                </div>
                            </div>
                            <div class="col">
                                <div class="i-card-sm p-3 primary--light shadow-none p-3">
                                    <p class="fs-15">{{ __('Level Commission') }}</p>
                                    <h5 class="title-sm mb-0">{{ getCurrencySymbol() }}{{shortAmount($matrixLog->level_commissions)}}</h5>
                                </div>
                            </div>

                            <div class="col">
                                <div class="i-card-sm p-3 primary--light shadow-none p-3">
                                    <p class="fs-15">{{ __('Status') }}</p>
                                    <h5 class="title-sm mb-0">{{ \App\Enums\Matrix\InvestmentStatus::getName($matrixLog->status) }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="i-card-sm">
                    <div class="card-body">
                        <div class="row align-items-center gy-4">
                            @include('user.partials.matrix.plan')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="enrollMatrixModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="matrixTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('user.matrix.store') }}">
                    @csrf
                    <input type="hidden" name="uid" value="">
                    <div class="modal-body">
                        <p class="text-white">{{ __("Are you sure you want to enroll in this matrix scheme?") }}</p>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="i-btn btn--primary btn--sm">{{ __('Submit') }}</button>
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
            $('.enroll-matrix-process').click(function () {
                const uid = $(this).data('uid');
                const name = $(this).data('name');

                $('input[name="uid"]').val(uid);
                const title = " Join " + name + " Matrix Scheme";
                $('#matrixTitle').text(title);
            });
        });
    </script>
@endpush
