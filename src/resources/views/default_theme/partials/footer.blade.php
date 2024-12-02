@php
    $pages = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::PAGE, \App\Enums\Frontend\Content::ENHANCEMENT);
    $contact = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::CONTACT, \App\Enums\Frontend\Content::FIXED);
    $fixedSocialContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::SOCIAL, \App\Enums\Frontend\Content::FIXED);
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::FOOTER, \App\Enums\Frontend\Content::FIXED);
    $enhancementContents = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::FOOTER, \App\Enums\Frontend\Content::ENHANCEMENT);
@endphp

<footer class="pt-80 position-relative">
    <div class="footer-vector">
        <img src="{{ displayImage(getArrayValue($fixedContent?->meta, 'footer_vector'), "481x481") }}" alt="{{ __('Vector Image') }}">
    </div>
    <div class="container">
        <div class="row align-items-end mb-60 gy-4">
            <div class="col-lg-7 pe-lg-5">
                <div class="footer-logo mb-4">
                    <img src="{{ displayImage(getArrayValue($setting?->logo, 'white'), "592x89") }}" alt="{{ __('white logo') }}">
                </div>
                <h5 class="footer-title mb-0">{{ getArrayValue($fixedContent?->meta, 'news_letter_title') }}</h5>
            </div>

            <div class="col-lg-5">
                <div class="newsletter-box row align-items-center g-4">
                    <form class="subscribe-form" method="POST">
                        <div class="input-wrapper">
                            <input type="email" id="email_subscribe" placeholder="{{ __('Your Email Address') }}" required>
                            <button><i class="bi bi-arrow-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row gy-5">
            <div class="col-lg-5 col-md-12 pe-lg-5">
                <p class="mb-5">{{ getArrayValue($fixedContent?->meta, 'details') }}</p>
                <div class="payment-logos">
                    <img src="{{ displayImage(getArrayValue($fixedContent?->meta, 'payment'), "583x83") }}" alt="image">
                </div>
            </div>

            <div class="col-lg-2 col-md-6 col-6">
                <h5 class="footer-title">{{ __('Important Link') }}</h5>
                <ul class="footer-menu">
                    @foreach($menus as $menu)
                        @if($menu->name == 'Home')
                            <li><a href="{{ route('home') }}">{{$menu->name}}</a></li>
                        @elseif($menu->name == 'Trade')
                            <li><a href="{{ route('trade') }}">{{$menu->name}}</a></li>
                        @elseif($menu->children->isEmpty())
                            <li><a href="{{route('dynamic.page', $menu->url)}}">{{$menu->name}}</a></li>
                        @endif
                    @endforeach
                </ul>
            </div>

            <div class="col-lg-2 col-md-6 col-6">
                <h5 class="footer-title">{{ __('Quick Link') }}</h5>
                <ul class="footer-menu">
                    @foreach($pages as $page)
                        <li><a href="{{ route('policy', ['slug' => slug(getArrayValue($page->meta, 'name')), 'id' => $page->id]) }}">{{ __(getArrayValue($page->meta, 'name')) }}</a></li>
                    @endforeach
                    <li><a href="{{ route('contact') }}">{{ __('Contact') }}</a></li>
                </ul>
            </div>

            <div class="col-lg-3">
                <div class="footer-address-wrapper">
                    <div class="address-item d-flex gap-2">
                        <i class="bi bi-envelope text-white"></i>
                        <a class="address" href="mailto:{{ getArrayValue($contact?->meta, 'email') }}">{{ getArrayValue($contact?->meta, 'email') }}</a>
                    </div>
                    <div class="address-item d-flex gap-2">
                        <i class="bi bi-telephone text-white"></i>
                        <a class="address" href="tel:{{ getArrayValue($contact?->meta, 'phone') }}">{{ getArrayValue($contact?->meta, 'phone') }}</a>
                    </div>
                    <div class="address-item d-flex gap-2">
                        <i class="bi bi-geo-alt text-white"></i>
                        <div class="address">{{ getArrayValue($contact?->meta, 'address') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-lg-6 text-lg-start text-center">
                    <ul class="footer-social">
                        <li><a href="{{ getArrayValue($fixedSocialContent?->meta, 'facebook_url') }}">@php echo  getArrayValue($fixedSocialContent?->meta, 'facebook_icon') @endphp</a></li>
                        <li><a href="{{ getArrayValue($fixedSocialContent?->meta, 'twitter_url') }}">@php echo  getArrayValue($fixedSocialContent?->meta, 'twitter_icon') @endphp</a></li>
                        <li><a href="{{ getArrayValue($fixedSocialContent?->meta, 'instagram_url') }}">@php echo  getArrayValue($fixedSocialContent?->meta, 'instagram_icon') @endphp</a></li>
                        <li><a href="{{ getArrayValue($fixedSocialContent?->meta, 'tiktok_url') }}">@php echo  getArrayValue($fixedSocialContent?->meta, 'tiktok_icon') @endphp</a></li>
                        <li><a href="{{ getArrayValue($fixedSocialContent?->meta, 'telegram_url') }}">@php echo  getArrayValue($fixedSocialContent?->meta, 'telegram_icon') @endphp</a></li>
                    </ul>
                </div>
                <div class="col-lg-6 col-lg-6 text-lg-end text-center">
                    <p>{{ getArrayValue($fixedContent?->meta, 'copy_right_text') }}</p>
                </div>
            </div>
        </div>
    </div>
</footer>

@if (getArrayValue($setting?->system_configuration, 'cookie_activation.value') == \App\Enums\Status::ACTIVE->value)
    @include(getActiveTheme().'.partials.cookie')
@endif

@push('script-push')
    <script>
        'use strict';
        $(document).on('submit', '.subscribe-form', function(e) {
            e.preventDefault();
            const email = $("#email_subscribe").val();
            if (email) {
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    url: "{{ route('subscribe') }}",
                    method: "POST",
                    data: {
                        email: email
                    },
                    success: function(response) {
                        notify('success', response.success);
                        $("#email_subscribe").val('');
                    },
                    error: function(response) {
                        const errorMessage = response.responseJSON ? response.responseJSON.error : "An error occurred.";
                        notify('error', errorMessage);
                    }
                });
            } else {
                notify('error', "Please Input Your Email");
            }
        });
    </script>
@endpush

