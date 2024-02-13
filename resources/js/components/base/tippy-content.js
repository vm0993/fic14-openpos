(function () {
    "use strict";

    // Tooltips
    $(".tippy-content").each(function () {
        let options = {};

        if ($(this).data("trigger") !== undefined) {
            options.trigger = $(this).data("trigger");
        }

        if ($(this).data("placement") !== undefined) {
            options.placement = $(this).data("placement");
        }

        if ($(this).data("theme") !== undefined) {
            options.theme = $(this).data("theme");
        }

        const initTippyContent = () => {
            if (
                !$(this).find("canvas").hasClass("chart") ||
                ($(this).find("canvas").hasClass("chart") &&
                    $(this).find("canvas").attr("style") !== undefined)
            ) {
                tippy(`[data-tooltip="${$(this).attr("id")}"]`, {
                    plugins: [animateFillPlugin],
                    content: $(this)[0],
                    allowHTML: true,
                    arrow: roundArrow,
                    popperOptions: {
                        modifiers: [
                            {
                                name: "preventOverflow",
                                options: {
                                    rootBoundary: "viewport",
                                },
                            },
                        ],
                    },
                    animateFill: false,
                    animation: "shift-away",
                    theme: "light",
                    trigger: "click",
                    ...options,
                });
            } else {
                setTimeout(() => {
                    initTippyContent();
                }, 500);
            }
        };

        initTippyContent();
    });
})();
