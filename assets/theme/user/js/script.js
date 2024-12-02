
(function () {
    "use strict";

    const planCardSlider = document.querySelector(".plan-card-slider");
    if (planCardSlider) {
        new Swiper(planCardSlider, {
            slidesPerView: 3,
            spaceBetween: 15,
            autoplay: {
                delay: 3000,
            },
            speed: 1000,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                576: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 2,
                },
                991: {
                    slidesPerView: 2,
                },
                1200: {
                    slidesPerView: 3,
                },
                1400: {
                    slidesPerView: 3,
                },
                1600: {
                    slidesPerView: 4,
                },
            }
        });
    }
}())
