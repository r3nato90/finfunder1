@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ $setTitle }}</h4>
            </div>

            <div class="card-body">
                <div class="col-lg-12">
                    @if(blank($matrixLog))
                        <h5>There are no enrolled available</h5>
                    @else
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Initiated At') }}
                                <span>{{ showDateTime($matrixLog->created_at) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Trx') }}
                                <span>{{ $matrixLog->trx }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Schema Name') }}
                                <span>{{ $matrixLog->name }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Invest Amount') }}
                                <span>{{ getCurrencySymbol() }}{{shortAmount($matrixLog->price)}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('User-Based Referral Bonus') }}
                                <span>{{ getCurrencySymbol() }}{{shortAmount($matrixLog->referral_reward)}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Referral Users') }}
                                <span>{{ $matrixLog?->user?->referredUsers->count() }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Referral Commissions') }}
                                <span>{{ getCurrencySymbol() }}{{shortAmount($matrixLog->referral_commissions)}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Level Commissions') }}
                                <span>{{ getCurrencySymbol() }}{{shortAmount($matrixLog->level_commissions)}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Total Profit') }}
                                <span>{{ getCurrencySymbol() }}{{shortAmount($matrixLog->referral_commissions + $matrixLog->level_commissions)}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Status') }}
                                <span class="badge {{ \App\Enums\Matrix\InvestmentStatus::getColor($matrixLog->status) }}">{{ \App\Enums\Matrix\InvestmentStatus::getName($matrixLog->status) }}</span>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

