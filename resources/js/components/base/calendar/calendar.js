(function () {
    "use strict";

    $(".full-calendar").each(function () {
        let calendar = new Calendar($(this).children()[0], {
            plugins: [
                interactionPlugin,
                dayGridPlugin,
                timeGridPlugin,
                listPlugin,
            ],
            droppable: true,
            headerToolbar: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek",
            },
            initialDate: "2045-01-01",
            navLinks: true,
            editable: true,
            dayMaxEvents: true,
            events: [
                {
                    title: "Vue Vixens Day",
                    start: "2045-01-05",
                    end: "2045-01-08",
                },
                {
                    title: "VueConfUS",
                    start: "2045-01-11",
                    end: "2045-01-15",
                },
                {
                    title: "VueJS Amsterdam",
                    start: "2045-01-17",
                    end: "2045-01-21",
                },
                {
                    title: "Vue Fes Japan 2045",
                    start: "2045-01-21",
                    end: "2045-01-24",
                },
                {
                    title: "Laracon 2045",
                    start: "2045-01-24",
                    end: "2045-01-27",
                },
            ],
            drop: function (info) {
                if (
                    $("#checkbox-events").length &&
                    $("#checkbox-events")[0].checked
                ) {
                    $(info.draggedEl).parent().remove();

                    if ($("#calendar-events").children().length == 1) {
                        $("#calendar-no-events").removeClass("hidden");
                    }
                }
            },
        });

        calendar.render();
    });
})();
