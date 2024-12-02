@extends(getActiveTheme().'.layouts.main')
@section('content')
    @include(getActiveTheme().'.partials.breadcrumb')
    <section class="contact-section pt-120">
        <div class="container">
            <div class="row g-0 align-items-stretch">
                <div class="col-lg-6">
                    <div class="address-wrapper" style="background: linear-gradient(90deg,rgba(0,0,0,.9),rgba(0,0,0,0.8)) ,url('assets/images/bg/contact-image.jpg');">
                        <div class="address-item">
                            <div class="icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div class="content">
                                <h5>{{ __('Email') }}</h5>
                                <a href="mailto:{{ __(getArrayValue($fixedContent?->meta, 'email')) }}">{{ __(getArrayValue($fixedContent?->meta, 'email')) }}</a>
                            </div>
                        </div>
                        <div class="address-item">
                            <div class="icon">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <div class="content">
                                <h5>{{ __('Phone') }}</h5>
                                <a href="tel:{{ getArrayValue($fixedContent?->meta, 'phone') }}">{{ getArrayValue($fixedContent?->meta, 'phone') }}</a>
                            </div>
                        </div>
                        <div class="address-item">
                            <div class="icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div class="content">
                                <h5>{{ __('Location') }}</h5>
                                <p>{{ __(getArrayValue($fixedContent?->meta, 'address')) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-wrapper contact-form">
                        <div class="subtitle mb-4">
                            <h3>{{ __(getArrayValue($fixedContent?->meta, 'heading')) }}</h3>
                        </div>
                        <form method="POST" action="{{ route('contact.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-inner">
                                        <label for="email">{{ __('Email') }}</label>
                                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="{{ __('Enter email') }}">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-inner">
                                        <label for="subject">{{ __('Subject') }}</label>
                                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" placeholder="{{ __('Enter subject') }}">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-inner">
                                        <label for="message">{{ __('Message') }}</label>
                                        <textarea rows="5" id="message" name="message" placeholder="{{ __('Write Your Message') }}" required> {{ old('message') }} </textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="i-btn btn--lg btn--primary w-100" type="submit">{{ __('Submit') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
