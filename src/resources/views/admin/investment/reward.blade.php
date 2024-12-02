@extends('admin.layouts.main')
@section('panel')
    <section>
        @include('admin.partials.filter', [
           'is_filter' => false,
           'is_modal' => true,
           'urls' => [
               [
                   'type' => 'modal',
                   'id' => 'rankModal',
                   'name' => __('Add New'),
                   'icon' => "<i class='las la-plus'></i>"
               ],
            ],
       ])

        @include('admin.partials.table', [
             'columns' => [
                 'created_at' => __('admin.table.created_at'),
                 'name' => __('admin.table.name'),
                 'level' => __('Level'),
                 'invest' => __('Invest'),
                 'team_invest' => __('Team Invest'),
                 'deposit' => __('Deposit'),
                 'referral_count' => __('Referral Count'),
                 'reward' => __('Reward'),
                 'status' => __('Status'),
                 'action' => __('admin.table.action'),
             ],
             'rows' => $rewards,
             'page_identifier' => \App\Enums\PageIdentifier::REWARD->value,
        ])
    </section>

    <div class="modal fade" id="rankModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Add User Reward Setting') }}</h5>
                </div>
                <form action="{{route('admin.binary.reward.store')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="name">{{ __('admin.input.name') }}<sup class="text-danger">*</sup></label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('admin.placeholder.name') }}">
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="level">{{ __('Level') }}<sup class="text-danger">*</sup></label>
                                <input type="text" name="level" id="level" class="form-control" placeholder="{{ __('Enter Level Name') }}">
                            </div>


                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="invest">{{ __('Invest') }}<sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="number" name="invest" id="invest" class="form-control" placeholder="{{ __('Minimum Invest') }}" aria-describedby="basic-addon1">
                                    <span class="input-group-text" id="basic-addon1">{{ getCurrencyName() }}</span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="team_invest">{{ __('Team Invest') }}<sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="number" name="team_invest" id="team_invest" class="form-control" placeholder="{{ __('Minimum Team Invest') }}" aria-describedby="basic-addon1">
                                    <span class="input-group-text" id="basic-addon1">{{ getCurrencyName() }}</span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="deposit">{{ __('Deposit') }}<sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="number" name="deposit" id="deposit" class="form-control" placeholder="{{ __('Minimum Deposit') }}" aria-describedby="basic-addon1">
                                    <span class="input-group-text" id="basic-addon1">{{ getCurrencyName() }}</span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="referral_count">{{ __('Referral Count') }}<sup class="text-danger">*</sup></label>
                                <input type="number" name="referral_count" id="referral_count" class="form-control" placeholder="{{ __('Minimum Referral Count') }}">
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="reward">{{ __('Reward') }}<sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="number" name="reward" id="reward" class="form-control" placeholder="{{ __('Enter Reward Amount') }}" aria-describedby="basic-addon1">
                                    <span class="input-group-text" id="basic-addon1">{{ getCurrencyName() }}</span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="status">{{ __('admin.input.status') }} <sup class="text-danger">*</sup></label>
                                <select class="form-select" id="status" name="status">
                                    <option value="" selected>{{ __('admin.filter.placeholder.select') }}</option>
                                    @foreach(\App\Enums\Trade\TradeParameterStatus::toArray() as $key =>  $status)
                                        <option value="{{ $status }}">{{ replaceInputTitle($key) }}</option>
                                    @endforeach
                                </select>
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

    <div class="modal fade" id="rewardUpdateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Update Timetable') }}</h5>
                </div>
                <form action="{{route('admin.binary.reward.update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="name">{{ __('admin.input.name') }}<sup class="text-danger">*</sup></label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('admin.placeholder.name') }}">
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="level">{{ __('Level') }}<sup class="text-danger">*</sup></label>
                                <input type="text" name="level" id="level" class="form-control" placeholder="{{ __('Enter Level Name') }}">
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="invest">{{ __('Invest') }}<sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="number" name="invest" id="invest" class="form-control" placeholder="{{ __('Minimum Invest') }}" aria-describedby="basic-addon1">
                                    <span class="input-group-text" id="basic-addon1">{{ getCurrencyName() }}</span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="team_invest">{{ __('Team Invest') }}<sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="number" name="team_invest" id="team_invest" class="form-control" placeholder="{{ __('Minimum Team Invest') }}" aria-describedby="basic-addon1">
                                    <span class="input-group-text" id="basic-addon1">{{ getCurrencyName() }}</span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="deposit">{{ __('Deposit') }}<sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="number" name="deposit" id="deposit" class="form-control" placeholder="{{ __('Minimum Deposit') }}" aria-describedby="basic-addon1">
                                    <span class="input-group-text" id="basic-addon1">{{ getCurrencyName() }}</span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="referral_count">{{ __('Referral Count') }}<sup class="text-danger">*</sup></label>
                                <input type="number" name="referral_count" id="referral_count" class="form-control" placeholder="{{ __('Minimum Referral Count') }}">
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="reward">{{ __('Reward') }}<sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="number" name="reward" id="reward" class="form-control" placeholder="{{ __('Enter Reward Amount') }}" aria-describedby="basic-addon1">
                                    <span class="input-group-text" id="basic-addon1">{{ getCurrencyName() }}</span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="status">{{ __('admin.input.status') }} <sup class="text-danger">*</sup></label>
                                <select class="form-select" id="status" name="status">
                                    <option value="" selected>{{ __('admin.filter.placeholder.select') }}</option>
                                    @foreach(\App\Enums\Trade\TradeParameterStatus::toArray() as $key =>  $status)
                                        <option value="{{ $status }}">{{ replaceInputTitle($key) }}</option>
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
                const name = $(this).data('name');
                const level = $(this).data('level');
                const invest = $(this).data('invest');
                const team_invest = $(this).data('team_invest');
                const deposit = $(this).data('deposit');
                const referral_count = $(this).data('referral_count');
                const reward = $(this).data('reward');
                const status = $(this).data('status');

                const modal = $('#rewardUpdateModal');
                modal.find('input[name=id]').val(id);
                modal.find('input[name=name]').val(name);
                modal.find('input[name=level]').val(level);
                modal.find('input[name=invest]').val(invest);
                modal.find('input[name=team_invest]').val(team_invest);
                modal.find('input[name=deposit]').val(deposit);
                modal.find('input[name=referral_count]').val(referral_count);
                modal.find('input[name=reward]').val(reward);
                modal.find('select[name=status]').val(status);
                modal.modal('show');
            });
        });
    </script>
@endpush
