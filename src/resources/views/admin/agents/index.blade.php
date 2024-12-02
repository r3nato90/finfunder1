@extends('admin.layouts.main')
@section('panel')
    <section>
        @include('admin.partials.filter', [
            'is_filter' => false,
            'is_modal' => true,
            'urls' => [
                [
                    'type' => 'modal',
                    'id' => 'investmentCommissionModal',
                    'name' => 'Investment Commission Setting',
                    'icon' => "<i class='las la-cog'></i>"
                ],
                [
                   'type' => 'modal',
                   'id' => 'addAgentModal',
                   'name' => __('Add New'),
                   'icon' => "<i class='las la-plus'></i>"
               ],
            ]
        ])
        @include('admin.partials.table', [
            'columns' => [
                'created_at' => __('admin.table.joined'),
                'name' => __('admin.table.name'),
                'email' => __('admin.table.email'),
                'agent_primary_balance' => 'Balance',
                'user_add_subtract' => __('admin.table.add_subtract'),
                'status' => __('admin.table.status'),
                'agent_action' => __('admin.table.action'),
            ],
            'rows' => $agents,
            'page_identifier' => \App\Enums\PageIdentifier::AGENT->value,
       ])
    </section>

    <div class="modal fade" id="investmentCommissionModal" tabindex="-1" aria-labelledby="credit-add-return" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Agent Investment Commission Setting')}}</h5>
                </div>
                <form action="{{route('admin.agent.investment.setting')}}" method="POST">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="id" value="">
                    <div class="modal-body">
                        <div class="row">
                            <h5 class="mt-4 my-3">{{ __('Fixed & Percentage Commission Settings') }}</h5>

                            <!-- Fixed Commission Status -->
                            <div class="col-lg-6 mb-3">
                                <label for="fixed-status" class="form-label">{{ __('Fixed Commission Status') }} <sup class="text--danger">*</sup></label>
                                <select class="form-select shadow-sm" name="agent_investment_commission[fixed_commission][status]" id="fixed-status" required>
                                    @foreach(\App\Enums\Status::toArray() as $status)
                                        <option value="{{ $status }}" {{ getArrayValue($setting->agent_investment_commission,'fixed_commission.status') == $status ? 'selected' : '' }}>
                                            {{ \App\Enums\Status::getName($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Fixed Amount -->
                            <div class="col-lg-6 mb-3">
                                <label for="fixed-amount" class="form-label">{{ __('Fixed Amount') }} <sup class="text--danger">*</sup></label>
                                <div class="input-group shadow-sm">
                                    <input type="number" class="form-control" id="fixed-amount" name="agent_investment_commission[fixed_commission][bonus]" placeholder="{{ __('admin.placeholder.number') }}" aria-label="Fixed Amount" aria-describedby="fixed-amount-addon" value="{{ getArrayValue($setting->agent_investment_commission,'fixed_commission.bonus') }}">
                                    <span class="input-group-text" id="fixed-amount-addon">{{ getCurrencyName() }}</span>
                                </div>
                            </div>

                            <!-- Percentage Commission Status -->
                            <div class="col-lg-6 mb-3">
                                <label for="percentage-status" class="form-label">{{ __('Percentage Commission Status') }} <sup class="text--danger">*</sup></label>
                                <select class="form-select shadow-sm" name="agent_investment_commission[percentage_commission][status]" id="percentage-status" required>
                                    @foreach(\App\Enums\Status::toArray() as $status)
                                        <option value="{{ $status }}" {{ getArrayValue($setting->agent_investment_commission,'percentage_commission.status') == $status ? 'selected' : '' }}>
                                            {{ \App\Enums\Status::getName($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Percentage Commission -->
                            <div class="col-lg-6 mb-3">
                                <label for="percentage-commission" class="form-label">{{ __('Percentage Commission') }} <sup class="text--danger">*</sup></label>
                                <div class="input-group shadow-sm">
                                    <input type="number" class="form-control" id="percentage-commission" name="agent_investment_commission[percentage_commission][bonus]" placeholder="{{ __('admin.placeholder.number') }}" aria-label="Percentage" aria-describedby="percentage-commission-addon" step="0.01" min="0" max="100" value="{{ getArrayValue($setting->agent_investment_commission,'percentage_commission.bonus') }}">
                                    <span class="input-group-text" id="percentage-commission-addon">%</span>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <!-- Performance-Based Commission Settings -->
                        <div class="row">
                            <h5 class="mt-4 my-3">{{ __('Performance-Based Commission Settings') }}</h5>

                            <!-- Performance Threshold Status -->
                            <div class="col-lg-4 mb-3">
                                <label for="performance-status" class="form-label">{{ __('Performance Threshold Status') }} <sup class="text--danger">*</sup></label>
                                <select class="form-select shadow-sm" name="agent_investment_commission[performance_based_commission][status]" id="performance-status" required>
                                    @foreach(\App\Enums\Status::toArray() as $status)
                                        <option value="{{ $status }}" {{ getArrayValue($setting->agent_investment_commission,'performance_based_commission.status') == $status ? 'selected' : '' }}>
                                            {{ \App\Enums\Status::getName($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Performance Threshold Amount -->
                            <div class="col-lg-4 mb-3">
                                <label for="performance-threshold" class="form-label">{{ __('Performance Threshold Amount') }} <sup class="text--danger">*</sup></label>
                                <div class="input-group shadow-sm">
                                    <input type="number" class="form-control" id="performance-threshold" name="agent_investment_commission[performance_based_commission][threshold]" placeholder="{{ __('admin.placeholder.number') }}" aria-label="Performance Threshold Amount" aria-describedby="performance-threshold-addon" value="{{ getArrayValue($setting->agent_investment_commission,'performance_based_commission.threshold') }}">
                                    <span class="input-group-text" id="performance-threshold-addon">{{ getCurrencyName() }}</span>
                                </div>
                            </div>

                            <!-- Performance Bonus -->
                            <div class="col-lg-4 mb-3">
                                <label for="performance-bonus" class="form-label">{{ __('Performance Bonus') }} <sup class="text--danger">*</sup></label>
                                <div class="input-group shadow-sm">
                                    <input type="number" class="form-control" id="performance-bonus" name="agent_investment_commission[performance_based_commission][bonus]" placeholder="{{ __('admin.placeholder.number') }}" aria-label="Performance Bonus" aria-describedby="performance-bonus-addon" value="{{ getArrayValue($setting->agent_investment_commission,'performance_based_commission.bonus') }}">
                                    <span class="input-group-text" id="performance-bonus-addon">{{ getCurrencyName() }}</span>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <!-- Monthly-Team Commission Settings -->
                        <div class="row">
                            <h5 class="mt-4 my-3">{{ __('Monthly Team Investment Commission Settings') }}</h5>

                            <!-- Monthly Team Investment Status -->
                            <div class="col-lg-4 mb-3">
                                <label for="monthly-status" class="form-label">{{ __('Monthly Commission Status') }} <sup class="text--danger">*</sup></label>
                                <select class="form-select shadow-sm" name="agent_investment_commission[monthly_team_investment_commission][status]" id="monthly-status" required>
                                    @foreach(\App\Enums\Status::toArray() as $status)
                                        <option value="{{ $status }}" {{ getArrayValue($setting->agent_investment_commission,'monthly_team_investment_commission.status') == $status ? 'selected' : '' }}>
                                            {{ \App\Enums\Status::getName($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Monthly Team Investment Amount -->
                            <div class="col-lg-4 mb-3">
                                <label for="monthly-team-investment" class="form-label">{{ __('Monthly Team Investment Amount') }} <sup class="text--danger">*</sup></label>
                                <div class="input-group shadow-sm">
                                    <input type="number" class="form-control" id="monthly-team-investment" name="agent_investment_commission[monthly_team_investment_commission][monthly_team_investment]" placeholder="{{ __('admin.placeholder.number') }}" aria-label="Monthly Team Investment Amount" aria-describedby="monthly-team-investment-addon" value="{{ getArrayValue($setting->agent_investment_commission,'monthly_team_investment_commission.monthly_team_investment') }}">
                                    <span class="input-group-text" id="monthly-team-investment-addon">{{ getCurrencyName() }}</span>
                                </div>
                            </div>

                            <!-- Monthly Team Investment Bonus -->
                            <div class="col-lg-4 mb-3">
                                <label for="monthly-bonus" class="form-label">{{ __('Monthly Bonus') }} <sup class="text--danger">*</sup></label>
                                <div class="input-group shadow-sm">
                                    <input type="number" class="form-control" id="monthly-bonus" name="agent_investment_commission[monthly_team_investment_commission][bonus]" placeholder="{{ __('admin.placeholder.number') }}" aria-label="Monthly Bonus" aria-describedby="monthly-bonus-addon" value="{{ getArrayValue($setting->agent_investment_commission,'monthly_team_investment_commission.bonus') }}">
                                    <span class="input-group-text" id="monthly-bonus-addon">{{ getCurrencyName() }}</span>
                                </div>
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

    <div class="modal fade" id="credit-add-return" tabindex="-1" aria-labelledby="credit-add-return" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('admin.user.content.add_subtract')}}</h5>
                </div>
                <form action="{{route('admin.agent.add-subtract.balance')}}" method="POST">
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

    <div class="modal fade" id="addAgentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Add Agent') }}</h5>
                </div>
                <form action="{{route('admin.agent.store')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="name">{{ __('Name') }}<sup class="text-danger">*</sup></label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('admin.placeholder.name') }}">
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="level">{{ __('Username') }}<sup class="text-danger">*</sup></label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="{{ __('Enter Username') }}">
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="email">{{ __('Email') }}<sup class="text-danger">*</sup></label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="{{ __('Enter email Name') }}">
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="phone">{{ __('Phone') }}<sup class="text-danger">*</sup></label>
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="{{ __('Enter Phone Number') }}">
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="password">{{ __('Password') }}<sup class="text-danger">*</sup></label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Enter Password') }}">
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="password_confirmation">{{ __('Confirm Password') }}<sup class="text-danger">*</sup></label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('Enter Confirm Password') }}">
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

    <div class="modal fade" id="agentUpdateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Update Agent') }}</h5>
                </div>
                <form action="{{route('admin.agent.update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="email">{{ __('Email') }}</label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="{{ __('Enter email Name') }}">
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label for="status" class="form-label"> {{ __('admin.input.status')}} <sup class="text--danger">*</sup></label>
                                <select class="form-select" name="status" id="status" required>
                                    @foreach(\App\Enums\Status::toArray() as $status)
                                        <option value="{{ $status }}">{{ \App\Enums\Status::getName($status) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="password">{{ __('Password') }}</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Enter Password') }}">
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="password_confirmation">{{ __('Confirm Password') }}</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('Enter Confirm Password') }}">
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
            $('.created-update').on('click', function () {
                const modal = $('#credit-add-return');
                const id = $(this).data('id');
                modal.find('input[name=id]').val(id);
                modal.modal('show');
            });


            $('.agentUpdate').on('click', function(event) {
                event.preventDefault();
                const id = $(this).data('id');
                const email = $(this).data('email');
                const status = $(this).data('status');

                const modal = $('#agentUpdateModal');
                modal.find('input[name=id]').val(id);
                modal.find('input[name=email]').val(email);
                modal.find('select[name=status]').val(status);
                modal.modal('show');
            });
        });
    </script>
@endpush
