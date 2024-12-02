@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="container-fluid p-0">
            <form action="{{ route('admin.investment.setting.update') }}" method="POST">
                @csrf
                <div class="row">
                    @foreach(\App\Enums\InvestmentType::cases() as $commissionType)
                        <div class="col-lg-4 mb-4">
                            <div class="card">
                                <div class="card-header bg--primary">
                                    <h4 class="card-title text-white">{{ replaceInputTitle($commissionType->name) }}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <select class="form-select" name="type[{{ getInputName($commissionType->name) }}]">
                                            <option value="1" @if(getArrayValue($setting->investment_setting, getInputName($commissionType->name)) == 1) selected @endif>{{ __('ON') }}</option>
                                            <option value="0" @if(getArrayValue($setting->investment_setting, getInputName($commissionType->name)) == 0) selected @endif>{{ __('OFF') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="i-btn btn--primary btn--md">{{ __('admin.button.save') }}</button>
            </form>
        </div>
    </section>
@endsection
