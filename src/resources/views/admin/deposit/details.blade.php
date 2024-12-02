@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ $setTitle }}</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group mb-4 detail-list">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Initiated At') }}
                                <span class="fw-bold">{{ showDateTime($deposit->created_at) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Gateway') }}
                                <span class="fw-bold"> {{ $deposit->gateway->name ?? 'N/A' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Rate') }}
                                <span class="fw-bold">{{ getCurrencySymbol() }}1 =  {{shortAmount($deposit->rate)}} {{ $deposit->gateway->currency ??  getCurrencyName() }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Trx') }}
                                <span class="fw-bold">{{$deposit->trx}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Deposit Amount') }}
                                <span class="fw-bold">{{ getCurrencySymbol() }}{{shortAmount($deposit->amount)}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Charge') }}
                                <span class="fw-bold">{{ getCurrencySymbol() }}{{shortAmount($deposit->charge)}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Final Amount') }}
                                <span class="fw-bold">{{ getCurrencySymbol() }}{{shortAmount($deposit->final_amount)}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Status') }}
                                <span class="badge {{ \App\Enums\Payment\Deposit\Status::getColor($deposit->status) }}">{{ \App\Enums\Payment\Deposit\Status::getName($deposit->status) }}</span>
                            </li>
                        </ul>

                        <div class="row gy-4 mt-3">
                            @if ($deposit->gateway->parameter && $deposit->meta)
                                <div class="col-12">
                                    <h6 class="fs-15 mb-2">{{ __('Payment Information') }}</h6>
                                    <ul class="list-group">
                                        @foreach ($deposit->gateway->parameter as $parameter)
                                            @if(\Illuminate\Support\Arr::get($parameter, 'field_type', 'text') == 'file')
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    {{ \Illuminate\Support\Arr::get($parameter, 'field_label','') }}
                                                    <a href="{{ route('admin.deposit.download', base64_encode( \Illuminate\Support\Arr::get($deposit->meta, \Illuminate\Support\Arr::get($parameter, 'field_name','')) ?? 'N/A')) }}" class="btn btn-sm btn--primary" ><i class="las la-download"></i></a>
                                                </li>
                                            @else
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    {{ \Illuminate\Support\Arr::get($parameter, 'field_label','') }}
                                                    <span>{{ \Illuminate\Support\Arr::get($deposit->meta, \Illuminate\Support\Arr::get($parameter, 'field_name','')) ?? 'N/A' }}</span>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                           @if($deposit->status == \App\Enums\Payment\Deposit\Status::PENDING->value)
                               <div class="col-12 text-center">
                                   <h6 class="fs-15 mb-2">{{ __('Check the deposit details and update its status.') }}</h6>
                                   <button type="button" class="btn btn-md btn--primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Payment Actions</button>
                               </div>
                           @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($deposit->status == \App\Enums\Payment\Deposit\Status::PENDING->value)
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Deposit Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.deposit.update', $deposit->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="status" class="form-label">{{ __('Status') }}<sup class="text-danger">*</sup></label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="{{ \App\Enums\Payment\Deposit\Status::SUCCESS->value }}">{{ __('Approved') }}</option>
                                    <option value="{{ \App\Enums\Payment\Deposit\Status::CANCEL->value }}">{{ __('Cancel') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn--outline btn--sm" data-bs-dismiss="modal">{{ __('Close') }}</button>
                            <button type="submit" class="btn btn--primary btn--sm">{{ __('Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection
