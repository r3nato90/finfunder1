@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="row align-items-start g-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __($setTitle) }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.theme.update') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="theme" class="form-label">{{ __('Select Active Theme') }}</label>
                                <select class="form-select" id="theme" name="theme">
                                    @foreach(getArrayValue($setting->theme_template_setting, 'themes') as $key => $theme)
                                        <option value="{{ $key }}" {{ $key == getArrayValue($setting->theme_template_setting, 'currently_active') ? 'selected' : '' }}>
                                            {{ $theme['title'] ?? 'Default Theme' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="i-btn btn--primary btn--lg"> {{ __('Update Theme') }}</button>
                        </form>

                        <div class="mt-5">
                            <h5 class="text-secondary">Available Themes:</h5>
                            <div class="row">
                                @foreach(getArrayValue($setting->theme_template_setting, 'themes') as $key => $theme)
                                    <div class="col-md-6">
                                        <div class="card mb-3 shadow-sm {{ $key == getArrayValue($setting->theme_template_setting, 'currently_active') ? 'border-primary' : '' }}">
                                            <div class="card-body">
                                                <h5 class="card-title text-dark">{{ $theme['title'] }}</h5>
                                                <p class="card-text text-muted">{{ $theme['details'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
