@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __($setTitle)  }}</h4>
                </div>

                <div class="card-body text-center d-flex flex-column align-items-center">
                    <p>{{ __('Current Version') }} : {{ config('app.app_version') }}</p>
                    <p>{{ __('New Version') }} : {{ config('app.migrate_version') }}</p>

                    @if(version_compare(config('app.migrate_version'), config('app.app_version'), '>'))
                        <form class="mt-2" action="{{ route('admin.setting.migrate') }}" method="POST">
                            @csrf
                            <button class="i-btn btn btn-primary btn--md">{{ __('Update System') }}</button>
                        </form>
                    @endif
                </div>

            </div>
        </div>
    </section>
@endsection
