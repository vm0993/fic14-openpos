(function () {
    "use strict";

    $(".full-calendar-draggable").each(function () {
        new Draggable(this, {
            itemSelector: ".event",
            eventData: function (eventEl) {
                return {
                    title: $(eventEl).find(".event__title").html(),
                    duration: {
                        days: parseInt($(eventEl).find(".event__days").text()),
                    },
                };
            },
        });
    });
})();
