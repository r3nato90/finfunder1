@extends('layouts.user')
@section('content')
    <div class="main-content" data-simplebar>
        <h3 class="page-title">{{ __($setTitle) }}</h3>
        <div class="i-card-sm">
            <div class="row">
                <div class="user-form">
                    <div class="col-lg-12 mb-4">
                        <form method="POST" action="{{ route('user.store.identity') }}">
                            @csrf
                            @if (!is_null($kycConfigurations))
                                <div class="row">
                                    @foreach ($kycConfigurations as $kycConfiguration)
                                        @php
                                            $fieldType = getArrayValue($kycConfiguration, 'field_type');
                                            $fieldLabel = getArrayValue($kycConfiguration, 'field_label');
                                            $isRequired = getArrayValue($kycConfiguration, 'is_required') == \App\Enums\Frontend\RequiredStatus::YES->value ? 'required' : '';
                                            $inputName = getInputName($fieldLabel);
                                        @endphp
                                        <div class="col-lg-12">
                                            <div class="form-inner">
                                                <label for="{{ $fieldLabel }}">{{ __($fieldLabel) }}</label>
                                                @switch($fieldType)
                                                    @case(\App\Enums\Frontend\InputField::TEXT->value)
                                                        <input type="text" id="{{ $fieldLabel }}" name="{{ $inputName }}" placeholder="{{ __("Enter $fieldLabel") }}" {{ $isRequired }}>
                                                        @break

                                                    @case(\App\Enums\Frontend\InputField::FILE->value)
                                                        <input type="file" id="{{ $fieldLabel }}" name="{{ $inputName }}" placeholder="{{ __("Enter $fieldLabel") }}" {{ $isRequired }}>
                                                        @break

                                                    @case(\App\Enums\Frontend\InputField::TEXTAREA->value)
                                                        <textarea id="{{ $fieldLabel }}" name="{{ $inputName }}" {{ $isRequired }}></textarea>
                                                        @break

                                                    @case(\App\Enums\Frontend\InputField::SELECT->value)
                                                        <select id="{{ $fieldLabel }}" name="{{ $inputName }}" {{ $isRequired }}>
                                                            @foreach (getArrayValue($kycConfiguration, 'options') as $option)
                                                                <option value="{{ $option }}">{{ $option }}</option>
                                                            @endforeach
                                                        </select>
                                                        @break
                                                @endswitch
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            <div class="col-12">
                                <button type="submit" class="i-btn btn--primary btn--lg">{{ __('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
