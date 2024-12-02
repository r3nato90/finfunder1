@extends('admin.layouts.main')
@section('panel')
    <section>
        @include('admin.partials.filter', [
            'is_filter' => false,
            'is_modal' => false,
        ])
        <div class="card">
            <div class="card-body">
                <form id="setting-form" action="{{route('admin.general.update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="{{ \App\Enums\GeneralSetting::COMMISSION_CHARGE->value }}">
                    <div class="row g-3">
                            @foreach($setting->commissions_charge as $key => $value)
                                <div class="col-lg-6 mb-3">
                                    <label for="{{ $key }}" class="form-label">{{ __(replaceInputTitle($key)) }}</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="commissions_charge[{{ $key }}]" value="{{ $value  }}" id="{{ $key }}"  placeholder="{{ __('Enter ') . __(replaceInputTitle($key)) }}" aria-label="Recipient's username" aria-describedby="basic-addon2" required>
                                        <span class="input-group-text" id="basic-addon2">{{ $key == 'trade_practice_balance' ? getCurrencyName() : '%' }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    <button class="i-btn btn--primary btn--lg"> {{ __('Submit') }}</button>
                </form>
            </div>
        </div>
    </section>
@endsection
