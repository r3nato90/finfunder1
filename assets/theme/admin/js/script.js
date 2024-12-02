
(function () {
    "use strict";


    const toggleChevron = function () {
        if ($(this).hasClass('bi')) {
            $(this).toggleClass('bi-chevron-down bi-chevron-up');
        } else {
            $(this).siblings('.bi').toggleClass('bi-chevron-down bi-chevron-up');
        }

        $(this).siblings('.sub-menu').slideToggle().toggleClass('animate').css("height", "auto !important");
    };


    $(".main-nav .li-has-children a, .main-nav .li-has-children .bi").on('click', toggleChevron);

    const socialCount = document.querySelectorAll('.social_count');
    const currencyElements = document.querySelectorAll('.currency');
    const timeInterval = 300;

    socialCount.forEach(eachSocial => {
        const updateSocial = () => {
            const target = +eachSocial.getAttribute('data-target');
            let count = +eachSocial.innerText;
            const increment = target / timeInterval;

            if (count < target) {
                count = Math.ceil(count + increment);
                eachSocial.innerText = count > target ? target : count;
                setTimeout(updateSocial, 100);
            }
        };

        updateSocial();
    });

    currencyElements.forEach(eachCurrency => {
        const updateCurrency = () => {
            const target = +eachCurrency.getAttribute('data-target');
            let count = +eachCurrency.innerText;
            const increment = target / timeInterval;

            if (count < target) {
                count = Math.ceil(count + increment);
                eachCurrency.innerText = count > target ? target : count;
                setTimeout(updateCurrency, 1);
            }
        };

        updateCurrency();
    });

    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

    function sleep(time) {
        return new Promise(resolve => setTimeout(resolve, time));
    }


    // Coin Slider
    const allCoinsSlider = document.querySelector(".all-coins-slider")
    if (allCoinsSlider) {
        new Swiper(allCoinsSlider, {
            slidesPerView: 1,
            spaceBetween: 5,
            autoplay: {
                delay: 2000,
            },
            speed: 800,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                576: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 1,
                },
                991: {
                    slidesPerView: 1,
                },
                1200: {
                    slidesPerView: 1,
                },
                1400: {
                    slidesPerView: 1,
                },
                1600: {
                    slidesPerView: 1,
                },
            }
        });
    }

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

    // investment-slider
    const investmentSlider = document.querySelector(".investment-slider");
    if (investmentSlider) {
        new Swiper(investmentSlider, {
            slidesPerView: 2,
            spaceBetween: 15,
            autoplay: {
                delay: 2000,
            },
            speed: 800,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                480: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 2,
                },
                991: {
                    slidesPerView: 2,
                },
                1200: {
                    slidesPerView: 2,
                },
                1400: {
                    slidesPerView: 3,
                },
            }
        });
    }

    const tradeCardSlider = document.querySelector(".trade-card-slider");
    if (tradeCardSlider) {
        new Swiper(tradeCardSlider, {
            slidesPerView: 2,
            spaceBetween: 15,
            autoplay: {
                delay: 2000,
            },
            speed: 800,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                480: {
                    slidesPerView: 1,
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
                    slidesPerView: 4,
                },
            }
        });
    }

    $(document).ready(function () {
        $('.js-example-basic-single').select2();
    });
}())
