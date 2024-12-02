@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Withdraw Details') }}</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group detail-list">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Initiated At') }}
                                <span class="fw-bold fs-14">{{ showDateTime($withdraw->created_at) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Gateway') }}
                                <span class="fw-bold fs-14"> {{ $withdraw->withdrawMethod->name ?? 'N/A' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Rate') }}
                                <span class="fw-bold fs-14">{{ getCurrencySymbol() }}1 =  {{shortAmount($withdraw->rate)}} {{ $withdraw->withdrawMethod->currency ?? getCurrencyName() }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Trx') }}
                                <span class="fw-bold fs-14">{{$withdraw->trx}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Withdraw Amount') }}
                                <span class="fw-bold fs-14">{{ getCurrencySymbol() }}{{shortAmount($withdraw->amount)}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Charge') }}
                                <span class="fw-bold fs-14">{{ getCurrencySymbol() }}{{shortAmount($withdraw->charge)}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Final Amount') }}
                                <span class="fw-bold fs-14">{{ getCurrencySymbol() }}{{shortAmount($withdraw->final_amount)}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('After Charge') }}
                                <span class="fw-bold fs-14">{{ getCurrencySymbol() }}{{shortAmount($withdraw->after_charge)}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Status') }}
                                <span class="badge {{ \App\Enums\Payment\Withdraw\Status::getColor($withdraw->status) }}">{{ \App\Enums\Payment\Withdraw\Status::getName($withdraw->status) }}</span>
                            </li>
                        </ul>

                        <div class="row gy-4 mt-3">
                            @if($withdraw->meta)
                                <div class="col-12">
                                    <h6 class="mb-2">{{ __('Payment Information') }}</h6>

                                    <ul class="list-group">
                                        @foreach($withdraw->meta as $key => $meta)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ __(replaceInputTitle($key)) }}
                                                <span>{{ $meta }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if($withdraw->status == \App\Enums\Payment\Withdraw\Status::PENDING->value)
                                <div class="col-12">
                                    <h6 class="mb-2">{{ __('Check the withdraw details and update its status.') }}</h6>
                                    <button type="button" class="btn btn-md btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Withdraw Actions</button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($withdraw->status == \App\Enums\Payment\Withdraw\Status::PENDING->value)
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Withdraw Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.agent.withdraw.update', $withdraw->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="status" class="form-label">{{ __('Status') }}<sup class="text-danger">*</sup></label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="{{ \App\Enums\Payment\Withdraw\Status::SUCCESS->value }}">{{ __('Approved') }}</option>
                                    <option value="{{ \App\Enums\Payment\Withdraw\Status::CANCEL->value }}">{{ __('Cancel') }}</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="details" class="form-label">{{ __('Reason Withdraw Update') }}<sup class="text-danger">*</sup></label>
                                <textarea class="form-control" id="details" name="details" rows="4" placeholder="{{ __('Enter Details') }}" required>{{ old('details') }}</textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn--outline btn--sm" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn--primary btn--sm">{{ __('Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection
