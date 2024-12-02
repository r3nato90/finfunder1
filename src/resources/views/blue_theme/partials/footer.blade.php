@php
    $pages = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::PAGE, \App\Enums\Frontend\Content::ENHANCEMENT);
    $contact = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::CONTACT, \App\Enums\Frontend\Content::FIXED);
    $fixedSocialContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::SOCIAL, \App\Enums\Frontend\Content::FIXED);
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::FOOTER, \App\Enums\Frontend\Content::FIXED);
    $enhancementContents = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::FOOTER, \App\Enums\Frontend\Content::ENHANCEMENT);
@endphp

<footer class="footer">
    <div class="container-fluid container-footer">
        <div class="footer-content">
            <div class="row g-0">
                <div class="col-lg-8 order-lg-1 order-2">
                    <div class="footer-left">
                        <div class="row g-4">
                            <div class="col-md-4 col-sm-6">
                                <div class="footer-nav">
                                    <h6>{{ __('Important Link') }}</h6>
                                    <ul>
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
                            </div>

                            <div class="col-md-4 col-sm-6">
                                <div class="footer-nav">
                                    <h6>{{ __('Quick Link') }}</h6>
                                    <ul>
                                        @foreach($pages as $page)
                                            <li><a href="{{ route('policy', ['slug' => slug(getArrayValue($page->meta, 'name')), 'id' => $page->id]) }}">{{ __(getArrayValue($page->meta, 'name')) }}</a></li>
                                        @endforeach
                                        <li><a href="{{ route('contact') }}">{{ __('Contact') }}</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6">
                                <div class="footer-nav">
                                    <h6>{{ __('Contact & social') }}</h6>
                                    <div class="contact-info">
                                        <a href="mailto:{{ getArrayValue($contact?->meta, 'email') }}" class="contact-info-item">
                                            <i class="bi bi-envelope"></i> {{ getArrayValue($contact?->meta, 'email') }}
                                        </a>

                                        <a href="tel:{{ getArrayValue($contact?->meta, 'phone') }}" class="contact-info-item">
                                            <i class="bi bi-telephone"></i> {{ getArrayValue($contact?->meta, 'phone') }}
                                        </a>

                                        <span class="contact-info-item">
                                            <i class="bi bi-geo-alt"></i> {{ getArrayValue($contact?->meta, 'address') }}
                                        </span>

                                        <ul class="footer-social">
                                            <li><a href="{{ getArrayValue($fixedSocialContent?->meta, 'facebook_url') }}">@php echo  getArrayValue($fixedSocialContent?->meta, 'facebook_icon') @endphp</a></li>
                                            <li><a href="{{ getArrayValue($fixedSocialContent?->meta, 'twitter_url') }}">@php echo  getArrayValue($fixedSocialContent?->meta, 'twitter_icon') @endphp</a></li>
                                            <li><a href="{{ getArrayValue($fixedSocialContent?->meta, 'instagram_url') }}">@php echo  getArrayValue($fixedSocialContent?->meta, 'instagram_icon') @endphp</a></li>
                                            <li><a href="{{ getArrayValue($fixedSocialContent?->meta, 'tiktok_url') }}">@php echo  getArrayValue($fixedSocialContent?->meta, 'tiktok_icon') @endphp</a></li>
                                            <li><a href="{{ getArrayValue($fixedSocialContent?->meta, 'telegram_url') }}">@php echo  getArrayValue($fixedSocialContent?->meta, 'telegram_icon') @endphp</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 order-lg-2 order-1">
                    <div class="footer-right">
                        <a href="{{ route('home') }}" class="logo-wrapper">
                            <img src="{{ displayImage(getArrayValue($setting?->logo, 'white'), "592x89") }}" alt="footer-logo">
                        </a>
                        <p>{{ getArrayValue($fixedContent?->meta, 'news_letter_title') }}</p>
                        <form class="subscribe-form newsletter-form">
                            <div class="input-wrapper">
                                <input type="email" id="email_subscribe" placeholder="{{ __('Your Email Address') }}" required>
                                <button type="submit" class="news-button i-btn btn--dark">
                                    <span class="d-md-block d-none">Submit</span>
                                    <span class="d-md-none"><i class="bi bi-send-fill"></i></span>
                                </button>
                            </div>
                        </form>

                        <div class="payment-logos mt-30">
                            <img src="{{ displayImage(getArrayValue($fixedContent?->meta, 'payment'), "583x83") }}" alt="{{ __('payment logo') }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container-fluid container-wrapper">
            <div class="text-center fs-14 fw-light">
                <p>{{ getArrayValue($fixedContent?->meta, 'copy_right_text') }}</p>
            </div>
        </div>
    </div>
</footer>
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

