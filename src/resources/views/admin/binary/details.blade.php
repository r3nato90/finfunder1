@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-header bg--primary">
                        <h4 class="card-title text-white">{{ __('Plan & Account Details') }}</h4>
                    </div>

                    <div class="card-body">
                        <ul class="list-group mb-4 detail-list">
                            <li class="list-group-item d-flex justify-content-between align-items-center text-dark">
                                {{ __('Plan Name') }}
                                <span>{{ __($investment->plan_name) }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center text-dark">
                                {{ __('Total Payable') }}
                                <span>{{ $investment->period }} {{ __('times') }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center text-dark">
                                {{ __('Name') }}
                                <span>{{ $investment->user->fullname }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center text-dark">
                                {{ __('Email') }}
                                <span>
                                    <a href="{{route('admin.user.details', $investment->user->id)}}">{{ $investment->user->email }}</a>
                                </span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center text-dark">
                                {{ __('Joined At') }}
                                <span>{{ showDateTime($investment->user->created_at) }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-header bg--primary">
                        <h4 class="card-title text-white">{{ __('Investment Information') }}</h4>
                    </div>

                    <div class="card-body">
                        <ul class="list-group mb-4 detail-list">
                            <li class="list-group-item d-flex justify-content-between align-items-center text-dark">
                                {{ __('Initiated At') }}
                                <span>{{ showDateTime($investment->created_at) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center text-dark">
                                {{ __('Invest') }}
                                <span>{{ getCurrencySymbol() }}{{ shortAmount($investment->amount) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center text-dark">
                                {{ __('Interest') }}
                                <span>{{ getCurrencySymbol() }}{{ shortAmount($investment->interest_rate) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center text-dark">
                                {{ __('Interest Timeframe') }}
                                <span>Every {{ $investment->time_table_name ?? 'Hour' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center text-dark">
                                {{ __('Status') }}
                                <span class="badge {{ \App\Enums\Status::getColor($investment->status) }}">{{ \App\Enums\Status::getName($investment->status) }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-header bg--primary">
                        <h4 class="card-title text-white">{{ __('Other Information') }}</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group mb-4 detail-list">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Total Paid') }}
                                <span class="fw-bold">{{ getCurrencySymbol() }}{{ shortAmount($investment->should_pay) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Should Pay') }}
                                <span class="fw-bold">
                                      @if ($investment->should_pay != -1)
                                            {{ getCurrencySymbol() }}{{ shortAmount($investment->interest) }}
                                      @else
                                         ****
                                      @endif
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Last Profit Time') }}
                                <span class="fw-bold">{{ showDateTime($investment->last_time) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Next Profit Time') }}
                                <span class="fw-bold">{{ showDateTime($investment->profit_time) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Capital Back') }}
                                <span class="badge {{ \App\Enums\Investment\Recapture::getColor($investment->recapture_type) }}">{{ \App\Enums\Investment\Recapture::getName($investment->recapture_type) }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @include('admin.partials.table', [
          'columns' => [
              'created_at' => __('admin.table.created_at'),
              'trx' => __('admin.table.trx'),
              'user_id' => __('admin.table.user'),
              'amount' => __('admin.table.amount'),
              'details' => __('admin.table.details'),
          ],
          'rows' => $commissions,
          'page_identifier' => \App\Enums\PageIdentifier::DAILY_COMMISSIONS->value,
      ])
@endsection
