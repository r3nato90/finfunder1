<div class="card">
    <div class="card-header">
        <p>{{__("Clear your browser cache if the logo and favicon don't update after changes on this page. If the issue persists, consider clearing server and network-level caches too.")}}</p>
    </div>
    <div class="card-body">
        <form action="{{route('admin.general.logo.update')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row align-items-center g-lg-3 g-2">
                <div class="col-lg-4 col-md-6 mb-3">
                    <label for="dark" class="form-label">{{ __('Dark Background Logo') }}</label>
                    <input type="file" name="dark" class="form-control" id="dark">
                    <small>{{__('File formats supported: jpeg, jpg, png.')}}
                        <a href="{{displayImage(getArrayValue($setting->logo, 'dark'))}}" target="__blank">{{__('view logo')}}</a>
                    </small>
                </div>

                <div class="col-lg-4 col-md-6 mb-3">
                    <label for="white" class="form-label">{{ __('White Background Logo') }}</label>
                    <input type="file" name="white" class="form-control" id="white">
                    <small>{{__('File formats supported: jpeg, jpg, png.')}}
                        <a href="{{ displayImage(getArrayValue($setting->logo, 'white')) }}" target="__blank">{{__('view logo')}}</a>
                    </small>
                </div>

                <div class="col-lg-4 col-md-6 mb-3">
                    <label for="favicon" class="form-label">{{ __('Favicon') }}</label>
                    <input type="file" name="favicon" class="form-control" id="favicon">
                    <small>{{__('File formats supported: jpeg, jpg, png.')}}
                        <a href="{{ displayImage(getArrayValue($setting->logo, 'favicon')) }}" target="__blank">{{__('view favicon')}}</a>
                    </small>
                </div>
            </div>

            <button class="i-btn btn--primary btn--lg"> {{ __('admin.button.save') }}</button>
        </form>
    </div>
</div>
