@extends(getActiveTheme().'.layouts.main')
@section('content')
    @include(getActiveTheme().'.partials.breadcrumb')
    <section class="contact-section position-relative pt-110 pb-110">
        <div class="linear-left"></div>
        <div class="linear-right"></div>
        <div class="container">
            <div class="row g-0 align-items-stretch">
                <div class="col-lg-9">
                    <div class="urgent-call">
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 473.806 473.806"  xml:space="preserve" class=""><g><path d="M374.456 293.506c-9.7-10.1-21.4-15.5-33.8-15.5-12.3 0-24.1 5.3-34.2 15.4l-31.6 31.5c-2.6-1.4-5.2-2.7-7.7-4-3.6-1.8-7-3.5-9.9-5.3-29.6-18.8-56.5-43.3-82.3-75-12.5-15.8-20.9-29.1-27-42.6 8.2-7.5 15.8-15.3 23.2-22.8 2.8-2.8 5.6-5.7 8.4-8.5 21-21 21-48.2 0-69.2l-27.3-27.3c-3.1-3.1-6.3-6.3-9.3-9.5-6-6.2-12.3-12.6-18.8-18.6-9.7-9.6-21.3-14.7-33.5-14.7s-24 5.1-34 14.7l-.2.2-34 34.3c-12.8 12.8-20.1 28.4-21.7 46.5-2.4 29.2 6.2 56.4 12.8 74.2 16.2 43.7 40.4 84.2 76.5 127.6 43.8 52.3 96.5 93.6 156.7 122.7 23 10.9 53.7 23.8 88 26 2.1.1 4.3.2 6.3.2 23.1 0 42.5-8.3 57.7-24.8.1-.2.3-.3.4-.5 5.2-6.3 11.2-12 17.5-18.1 4.3-4.1 8.7-8.4 13-12.9 9.9-10.3 15.1-22.3 15.1-34.6 0-12.4-5.3-24.3-15.4-34.3l-54.9-55.1zm35.8 105.3c-.1 0-.1.1 0 0-3.9 4.2-7.9 8-12.2 12.2-6.5 6.2-13.1 12.7-19.3 20-10.1 10.8-22 15.9-37.6 15.9-1.5 0-3.1 0-4.6-.1-29.7-1.9-57.3-13.5-78-23.4-56.6-27.4-106.3-66.3-147.6-115.6-34.1-41.1-56.9-79.1-72-119.9-9.3-24.9-12.7-44.3-11.2-62.6 1-11.7 5.5-21.4 13.8-29.7l34.1-34.1c4.9-4.6 10.1-7.1 15.2-7.1 6.3 0 11.4 3.8 14.6 7l.3.3c6.1 5.7 11.9 11.6 18 17.9 3.1 3.2 6.3 6.4 9.5 9.7l27.3 27.3c10.6 10.6 10.6 20.4 0 31-2.9 2.9-5.7 5.8-8.6 8.6-8.4 8.6-16.4 16.6-25.1 24.4-.2.2-.4.3-.5.5-8.6 8.6-7 17-5.2 22.7l.3.9c7.1 17.2 17.1 33.4 32.3 52.7l.1.1c27.6 34 56.7 60.5 88.8 80.8 4.1 2.6 8.3 4.7 12.3 6.7 3.6 1.8 7 3.5 9.9 5.3.4.2.8.5 1.2.7 3.4 1.7 6.6 2.5 9.9 2.5 8.3 0 13.5-5.2 15.2-6.9l34.2-34.2c3.4-3.4 8.8-7.5 15.1-7.5 6.2 0 11.3 3.9 14.4 7.3l.2.2 55.1 55.1c10.3 10.2 10.3 20.7.1 31.3zM256.056 112.706c26.2 4.4 50 16.8 69 35.8s31.3 42.8 35.8 69c1.1 6.6 6.8 11.2 13.3 11.2.8 0 1.5-.1 2.3-.2 7.4-1.2 12.3-8.2 11.1-15.6-5.4-31.7-20.4-60.6-43.3-83.5s-51.8-37.9-83.5-43.3c-7.4-1.2-14.3 3.7-15.6 11s3.5 14.4 10.9 15.6zM473.256 209.006c-8.9-52.2-33.5-99.7-71.3-137.5s-85.3-62.4-137.5-71.3c-7.3-1.3-14.2 3.7-15.5 11-1.2 7.4 3.7 14.3 11.1 15.6 46.6 7.9 89.1 30 122.9 63.7 33.8 33.8 55.8 76.3 63.7 122.9 1.1 6.6 6.8 11.2 13.3 11.2.8 0 1.5-.1 2.3-.2 7.3-1.1 12.3-8.1 11-15.4z" opacity="1" data-original="#000000" class=""></path></g></svg>
                        </div>
                        <div class="text">
                            <h3>{{ __(getArrayValue($fixedContent?->meta, 'heading')) }}</h3>
                            <p>{{ __(getArrayValue($fixedContent?->meta, 'sub_heading')) }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="address-wrapper" style="background: linear-gradient(90deg,rgba(0,0,0,.9),rgba(0,0,0,0.8)) ,url({{ displayImage(getArrayValue($fixedContent?->meta, 'background_image')) }});">
                        <div class="address-item">
                            <div class="icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div class="content">
                                <h5>{{ __('Email') }}</h5>
                                <a href="mailto:{{ getArrayValue($fixedContent?->meta, 'phone') }}">{{ __(getArrayValue($fixedContent?->meta, 'email')) }}</a>
                            </div>
                        </div>
                        <div class="address-item">
                            <div class="icon">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <div class="content">
                                <h5>{{ __('Phone') }}</h5>
                                <a href="tel:{{ getArrayValue($fixedContent?->meta, 'phone') }}">{{ __(getArrayValue($fixedContent?->meta, 'phone')) }}</a>
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
                        <div class="subtitle">
                            <h3>{{ __(getArrayValue($fixedContent?->meta, 'title')) }}</h3>
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
