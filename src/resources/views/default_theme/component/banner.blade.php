@php
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::BANNER, \App\Enums\Frontend\Content::FIXED);
@endphp
<div class="banner-section">
    <div class="banner-bg">
        <img src="{{ displayImage(getArrayValue($fixedContent->meta, 'background_image'), '2470x1529') }}" alt="{{ __('Background Image') }}">
    </div>
    <div class="linear-big"></div>
    <div class="container">
        <div class="row align-items-center gy-5">
            <div class="col-lg-7">
                <div class="banner-content">
                    <h1>{{ __(getArrayValue($fixedContent?->meta, 'heading')) }}</h1>
                    <p>{{ __(getArrayValue($fixedContent?->meta, 'sub_heading')) }}</p>
                    <div class="d-flex justify-content-between align-items-end gap-lg-4 gap-2">
                        <div class="d-flex justify-content-start align-items-center flex-lg-nowrap flex-wrap-reverse gap-4">
                            <a href="{{ __(getArrayValue($fixedContent?->meta, 'btn_url')) }} " class="i-btn banner-btn">{{ __(getArrayValue($fixedContent?->meta, 'btn_name')) }} <i class="bi bi-arrow-right-short"></i></a>
                            <div class="video-pluse">
                                <span></span>
                                <span></span>
                                <span></span>
                                <a data-fancybox href="{{ getArrayValue($fixedContent?->meta, 'video_link') }}"><i class="bi bi-play-fill"></i></a>
                            </div>
                        </div>
                        <div class="global-users">
                            <div class="shape-left">
                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.709717 22.0001H21.9998V0.710938C19.2491 11.0829 11.0818 19.2498 0.709717 22.0001Z"/>
                                </svg>
                            </div>
                            <div class="shape-right">
                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.709717 22.0001H21.9998V0.710938C19.2491 11.0829 11.0818 19.2498 0.709717 22.0001Z"/>
                                </svg>
                            </div>
                            <div class="icon">
                                <svg version="1.1" x="0" y="0" viewBox="0 0 512 512" xml:space="preserve" class=""><g><path d="M256 512c-68.38 0-132.667-26.629-181.02-74.98C26.629 388.667 0 324.38 0 256S26.629 123.333 74.98 74.98C123.333 26.629 187.62 0 256 0s132.667 26.629 181.02 74.98C485.371 123.333 512 187.62 512 256s-26.629 132.667-74.98 181.02C388.667 485.371 324.38 512 256 512zm0-490.667C126.604 21.333 21.333 126.604 21.333 256S126.604 490.666 256 490.666 490.666 385.396 490.666 256 385.396 21.333 256 21.333z"  opacity="1" data-original="#000000" class=""></path><path d="M256 512c-40.12 0-77.334-27.481-104.789-77.381-26.345-47.886-40.854-111.321-40.854-178.619s14.509-130.733 40.854-178.619C178.666 27.481 215.88 0 256 0s77.334 27.481 104.788 77.381c26.346 47.886 40.854 111.321 40.854 178.619s-14.509 130.733-40.854 178.619C333.334 484.519 296.12 512 256 512zm0-490.667c-31.987 0-62.563 23.557-86.097 66.332C145.261 132.454 131.69 192.236 131.69 256s13.571 123.546 38.212 168.335c23.534 42.774 54.11 66.331 86.097 66.331s62.563-23.557 86.097-66.331c24.642-44.789 38.212-104.571 38.212-168.335s-13.57-123.546-38.212-168.335C318.563 44.89 287.986 21.333 256 21.333z"  opacity="1" data-original="#000000" class=""></path><path d="M256 510.443c-5.891 0-10.667-4.776-10.667-10.667V12.224c0-5.891 4.775-10.667 10.667-10.667 5.891 0 10.667 4.776 10.667 10.667v487.552c0 5.891-4.776 10.667-10.667 10.667z"  opacity="1" data-original="#000000" class=""></path><path d="M499.776 266.667H12.224c-5.891 0-10.667-4.776-10.667-10.667s4.776-10.667 10.667-10.667h487.552c5.891 0 10.667 4.775 10.667 10.667 0 5.891-4.776 10.667-10.667 10.667zM464.522 139.413H47.478c-5.891 0-10.667-4.775-10.667-10.667s4.775-10.667 10.667-10.667h417.045c5.891 0 10.667 4.775 10.667 10.667s-4.777 10.667-10.668 10.667zM464.522 393.92H47.478c-5.891 0-10.667-4.776-10.667-10.667s4.775-10.667 10.667-10.667h417.045c5.891 0 10.667 4.776 10.667 10.667s-4.777 10.667-10.668 10.667z"  opacity="1" data-original="#000000" class=""></path></g></svg>
                            </div>
                            <div class="text">
                                <p>{{ __(getArrayValue($fixedContent?->meta, 'first_text')) }}</p>
                                <p>{{ __(getArrayValue($fixedContent?->meta, 'second_text')) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="banner-features mb-60">
                    <li><span>@php echo getArrayValue($fixedContent?->meta, 'first_icon') @endphp</span>{{ __(getArrayValue($fixedContent?->meta, 'first_title')) }}</li>
                    <li><span>@php echo getArrayValue($fixedContent?->meta, 'second_icon') @endphp</span>{{ __(getArrayValue($fixedContent?->meta, 'second_title')) }}</li>
                    <li><span>@php echo getArrayValue($fixedContent?->meta, 'third_icon') @endphp</span>{{ __(getArrayValue($fixedContent?->meta, 'third_title')) }}</li>
                </ul>

                <div class="providers">
                    <div class="row row-cols-lg-4 row-cols-md-4 row-cols-sm-4 row-cols-2 justify-content-lg-start justify-content-center align-items-center g-4">
                        <div class="col">
                            <img src="{{ displayImage(getArrayValue($fixedContent?->meta, 'first_provider_image'), '106x22') }}" alt="{{ __('banner-coin1') }}">
                        </div>
                        <div class="col">
                            <img src="{{ displayImage(getArrayValue($fixedContent?->meta, 'second_provider_image'), '106x22') }}" alt="{{ __('banner-coin2') }}">
                        </div>
                        <div class="col">
                            <img src="{{ displayImage(getArrayValue($fixedContent?->meta, 'third_provider_image'), '106x22') }}" alt="{{ __('banner-coin3') }}">
                        </div>
                        <div class="col">
                            <img src="{{ displayImage(getArrayValue($fixedContent?->meta, 'fourth_provider_image'), '106x22') }}" alt="{{ __('banner-coin4') }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="offset-lg-1 col-lg-4">
                <img src="{{ displayImage(getArrayValue($fixedContent?->meta, 'main_image'), '593x586') }}" alt="{{ __('Main Image') }}">
            </div>
        </div>
    </div>
</div>
