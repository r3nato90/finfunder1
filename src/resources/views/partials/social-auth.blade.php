@php
    $googleLoginActive = getArrayValue($setting?->social_login, 'google.status') == \App\Enums\Status::ACTIVE->value;
    $facebookLoginActive = getArrayValue($setting?->social_login, 'facebook.status') == \App\Enums\Status::ACTIVE->value;
@endphp

@if($googleLoginActive || $facebookLoginActive)
    <div class="another-singup">
        <div class="or">{{ __('OR') }}</div>
        <h6>{{ __('Sign Up with') }}</h6>
        
        <div class="form-social-two">
            @foreach($setting?->social_login as $key => $social)
                @if($key == "google")
                    @if($googleLoginActive)
                        <a href="{{route('google.login')}}" class="{{ $key }}"><i class="bi bi-{{$key}}"></i>{{ __(ucfirst($key)) }}</a>
                    @endif
                @else
                    @if($facebookLoginActive)
                        <a href="{{route('facebook.login')}}" class="{{ $key }}"><i class="bi bi-{{$key}}"></i>{{ __(ucfirst($key)) }}</a>
                    @endif
                @endif
            @endforeach
        </div>
       
    </div>
@endif


