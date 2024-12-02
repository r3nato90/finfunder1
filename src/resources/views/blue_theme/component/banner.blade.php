@php
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::BANNER, \App\Enums\Frontend\Content::FIXED);
    $enhancementContents = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::BANNER, \App\Enums\Frontend\Content::ENHANCEMENT);
@endphp

<section class="banner">
    <div class="banner-blur"></div>
    <div class="banner-blur-2"></div>
    <div class="container-fluid">
        <div class="row gy-5 align-items-stretch">
            <div class="col-xl-6 col-lg-6">
                <div class="banner-content" data-aos="fade-right">
                    <div class="banner-vector">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0"
                             y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g>
                                <path d="M462.316 215.316c-20.045 0-36.739 14.576-40.068 33.684H375.29c-1.607-27.687-12.683-52.87-30.03-72.36l33.257-33.257c6.619 4.663 14.678 7.413 23.371 7.413 22.433 0 40.684-18.251 40.684-40.684s-18.251-40.684-40.684-40.684-40.684 18.25-40.684 40.684c0 8.693 2.75 16.752 7.413 23.371l-33.258 33.257c-19.489-17.347-44.673-28.422-72.359-30.029V89.753c19.108-3.329 33.685-20.023 33.685-40.068C296.685 27.251 278.434 9 256 9c-22.433 0-40.684 18.251-40.684 40.684 0 20.045 14.577 36.739 33.684 40.068v46.958c-27.687 1.607-52.87 12.682-72.359 30.029l-33.257-33.257c4.664-6.619 7.414-14.677 7.414-23.371 0-22.433-18.251-40.684-40.685-40.684-22.433 0-40.684 18.25-40.684 40.684s18.251 40.684 40.684 40.684c8.694 0 16.752-2.75 23.371-7.413l33.257 33.257c-17.348 19.49-28.423 44.673-30.03 72.36H89.753c-3.329-19.107-20.023-33.684-40.069-33.684C27.251 215.316 9 233.567 9 256s18.251 40.684 40.684 40.684c20.046 0 36.74-14.576 40.069-33.684h46.958c1.607 27.687 12.682 52.87 30.029 72.36l-33.256 33.257c-6.619-4.663-14.677-7.413-23.371-7.413-22.433 0-40.684 18.251-40.684 40.684s18.251 40.684 40.684 40.684c22.434 0 40.685-18.25 40.685-40.684 0-8.694-2.75-16.753-7.414-23.371l33.256-33.256c19.489 17.347 44.674 28.423 72.36 30.03v46.957c-19.107 3.329-33.684 20.024-33.684 40.069C215.316 484.75 233.567 503 256 503c22.434 0 40.685-18.25 40.685-40.684 0-20.045-14.577-36.74-33.685-40.069V375.29c27.687-1.607 52.871-12.683 72.36-30.03l33.257 33.257c-4.663 6.619-7.413 14.677-7.413 23.371 0 22.433 18.251 40.684 40.684 40.684s40.684-18.25 40.684-40.684-18.251-40.684-40.684-40.684c-8.693 0-16.752 2.75-23.371 7.413L345.26 335.36c17.347-19.49 28.422-44.673 30.029-72.36h46.958c3.329 19.107 20.023 33.684 40.068 33.684 22.433 0 40.684-18.25 40.684-40.684s-18.25-40.684-40.683-40.684zM49.684 282.684C34.97 282.684 23 270.713 23 256s11.97-26.684 26.684-26.684S76.368 241.287 76.368 256s-11.971 26.684-26.684 26.684zM401.888 83.429c14.713 0 26.684 11.97 26.684 26.684s-11.971 26.684-26.684 26.684c-14.714 0-26.684-11.97-26.684-26.684s11.97-26.684 26.684-26.684zM229.316 49.684C229.316 34.97 241.287 23 256 23c14.714 0 26.685 11.97 26.685 26.684 0 14.713-11.971 26.684-26.685 26.684-14.713 0-26.684-11.971-26.684-26.684zm-119.204 87.112c-14.713 0-26.684-11.97-26.684-26.684 0-14.713 11.971-26.684 26.684-26.684 14.714 0 26.685 11.97 26.685 26.684s-11.971 26.684-26.685 26.684zm0 291.775c-14.713 0-26.684-11.97-26.684-26.684s11.971-26.684 26.684-26.684c14.714 0 26.685 11.97 26.685 26.684s-11.971 26.684-26.685 26.684zm172.573 33.745C282.685 477.03 270.714 489 256 489c-14.713 0-26.684-11.97-26.684-26.684s11.971-26.684 26.684-26.684c14.714 0 26.685 11.971 26.685 26.684zm119.203-87.112c14.713 0 26.684 11.97 26.684 26.684 0 14.713-11.971 26.684-26.684 26.684-14.714 0-26.684-11.97-26.684-26.684s11.97-26.684 26.684-26.684zM256 361.5c-58.173 0-105.5-47.327-105.5-105.5S197.827 150.5 256 150.5 361.5 197.828 361.5 256 314.173 361.5 256 361.5zm206.316-78.816c-14.714 0-26.684-11.97-26.684-26.684s11.97-26.684 26.684-26.684S489 241.287 489 256s-11.97 26.684-26.684 26.684zM256 164.201c-50.618 0-91.8 41.181-91.8 91.8 0 50.618 41.182 91.799 91.8 91.799s91.8-41.181 91.8-91.799c0-50.619-41.182-91.8-91.8-91.8zm0 169.599c-42.899 0-77.8-34.9-77.8-77.799s34.9-77.8 77.8-77.8 77.8 34.901 77.8 77.8S298.899 333.8 256 333.8zm33.637-80.499a26.45 26.45 0 0 0 6.058-16.864c0-12.415-8.562-22.865-20.091-25.763v-11.918a7 7 0 1 0-14 0v11.117h-13.476v-11.117a7 7 0 1 0-14 0v11.117h-17.052a7 7 0 1 0 0 14h6.146v64.256h-6.146a7 7 0 1 0 0 14h17.052v11.117a7 7 0 1 0 14 0v-11.117h13.476v11.117a7 7 0 1 0 14 0v-11.123c14.535-.133 26.319-11.992 26.319-26.557.001-9.687-4.621-17.64-12.286-22.265zm-20.505-29.429c6.928 0 12.563 5.636 12.563 12.564 0 6.926-5.643 12.572-12.578 12.586h-31.894v-25.15zm6.227 64.256h-38.136v-25.106h37.792c4.065.383 12.908 2.384 12.908 12.542.001 6.929-5.636 12.564-12.564 12.564z"
                                  opacity="1" data-original="#000000" class=""></path>
                            </g>
                        </svg>
                    </div>
                    <span class="banner-subtitle"> {{ __(getArrayValue($fixedContent?->meta, 'blue_theme_title')) }}</span>
                    <h1 class="banner-title">
                        {{ __(getArrayValue($fixedContent?->meta, 'heading')) }}
                    </h1>
                    <p class="banner-description">{{ __(getArrayValue($fixedContent?->meta, 'sub_heading')) }}</p>
                    <div class="banner-actions">
                        <a href="{{ __(getArrayValue($fixedContent?->meta, 'btn_url')) }}" class="i-btn btn--primary btn--xl pill">{{ __(getArrayValue($fixedContent?->meta, 'btn_name')) }}</a>
                        <div class="d-flex align-items-center gap-2">
                            <span class="world-icon"><i class="bi bi-globe2"></i></span>
                            <div class="text">
                                <p class="fs-16 fw-semibold">{{ __(getArrayValue($fixedContent?->meta, 'first_text')) }}</p>
                                <p class="fs-12 opacity-75">{{ __(getArrayValue($fixedContent?->meta, 'second_text')) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-5 offset-xl-1 col-lg-6">
                <div class="banner-img" data-aos="fade-left">
                    <button class="banner-arrow">
                        <a data-fancybox href="{{ getArrayValue($fixedContent?->meta, 'video_link') }}"><i class="bi bi-play-fill"></i></a>
                    </button>
                    <img src="{{ displayImage(getArrayValue($fixedContent?->meta, 'main_image'), '593x586') }}" alt="mockup" />
                    <div class="banner-features">
                        <ul>
                            <li><span>@php echo getArrayValue($fixedContent?->meta, 'first_icon') @endphp</span>{{ __(getArrayValue($fixedContent?->meta, 'first_title')) }}</li>
                            <li><span>@php echo getArrayValue($fixedContent?->meta, 'second_icon') @endphp</span>{{ __(getArrayValue($fixedContent?->meta, 'second_title')) }}</li>
                            <li><span>@php echo getArrayValue($fixedContent?->meta, 'third_icon') @endphp</span>{{ __(getArrayValue($fixedContent?->meta, 'third_title')) }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12 text-center">
                <div class="providers">
                    <div class="swiper providers-slider">
                        <div class="swiper-wrapper">
                            @foreach($enhancementContents as $enhancementContent)
                                <div class="swiper-slide">
                                    <img src="{{ displayImage(getArrayValue($enhancementContent->meta, 'blue_theme_image'), "800x160") }}" alt="{{ __('banner-coin3') }}"/>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
