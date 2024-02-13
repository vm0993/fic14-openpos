(function () {
    "use strict";

    const defaultConfig = {
        slideBy: "page",
        mouseDrag: true,
        autoplay: true,
        controls: false,
        nav: false,
        speed: 500,
    };

    const singleItemConfig = {
        slideBy: "page",
        mouseDrag: true,
        autoplay: false,
        controls: true,
        nav: false,
        speed: 500,
    };

    const multipleItemsConfig = {
        slideBy: "page",
        mouseDrag: true,
        autoplay: false,
        controls: true,
        items: 1,
        nav: false,
        speed: 500,
        responsive: {
            600: {
                items: 3,
            },
            480: {
                items: 2,
            },
        },
    };

    const responsiveConfig = {
        slideBy: "page",
        mouseDrag: true,
        autoplay: false,
        controls: true,
        items: 1,
        nav: true,
        speed: 500,
        responsive: {
            600: {
                items: 3,
            },
            480: {
                items: 2,
            },
        },
    };

    const centerModeConfig = {
        mouseDrag: true,
        autoplay: false,
        controls: true,
        center: true,
        items: 1,
        nav: false,
        speed: 500,
        responsive: {
            600: {
                items: 2,
            },
        },
    };

    const fadeConfig = {
        mode: "gallery",
        slideBy: "page",
        mouseDrag: true,
        autoplay: true,
        controls: true,
        nav: true,
        speed: 500,
    };

    const performanceInsightSliderConfig = {
        autoplay: false,
        controls: false,
        items: 1,
        responsive: {
            640: { items: 2 },
            768: { items: 3 },
            1024: { items: 4 },
            1320: {
                items: 5,
            },
        },
    };

    // Tiny Slider
    if ($(".tiny-slider").length) {
        $(".tiny-slider").each(function () {
            const config = $(this).data("config");
            this.tns = tns({
                container: this,
                ...(config === undefined || config === "" ? defaultConfig : {}),
                ...(config === "single-item" ? singleItemConfig : {}),
                ...(config === "multiple-items" ? multipleItemsConfig : {}),
                ...(config === "responsive" ? responsiveConfig : {}),
                ...(config === "center-mode" ? centerModeConfig : {}),
                ...(config === "fade" ? fadeConfig : {}),
                ...(config === "performance-insight-slider-config"
                    ? performanceInsightSliderConfig
                    : {}),
            });
        });
    }

    if ($(".tiny-slider-navigator").length) {
        $(".tiny-slider-navigator").each(function () {
            $(this).on("click", function () {
                if ($(this).data("target") == "prev") {
                    $("#" + $(this).data("carousel"))[0].tns.goTo("prev");
                } else {
                    $("#" + $(this).data("carousel"))[0].tns.goTo("next");
                }
            });
        });
    }
})();
