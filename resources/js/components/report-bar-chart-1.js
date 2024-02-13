(function () {
    "use strict";

    // Chart
    if ($(".report-bar-chart-1").length) {
        const ctx = $(".report-bar-chart-1")[0].getContext("2d");
        const reportBarChart1 = new Chart(ctx, {
            type: "bar",
            data: {
                labels: [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dec",
                ],
                datasets: [
                    {
                        label: "Html Template",
                        barThickness: 8,
                        maxBarThickness: 6,
                        data: [
                            60, 150, 30, 200, 180, 50, 180, 120, 230, 180, 250,
                            270,
                        ],
                        backgroundColor: () => getColor("primary", 0.9),
                    },
                    {
                        label: "VueJs Template",
                        barThickness: 8,
                        maxBarThickness: 6,
                        data: [
                            50, 135, 40, 180, 190, 60, 150, 90, 250, 170, 240,
                            250,
                        ],
                        backgroundColor: () =>
                            $("html").hasClass("dark")
                                ? getColor("darkmode.400")
                                : getColor("slate.300"),
                    },
                ],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    x: {
                        ticks: {
                            font: {
                                size: 11,
                            },
                            color: getColor("slate.500", 0.8),
                        },
                        grid: {
                            display: false,
                        },
                        border: {
                            display: false,
                        },
                    },
                    y: {
                        ticks: {
                            display: false,
                        },
                        grid: {
                            color: () =>
                                $("html").hasClass("dark")
                                    ? getColor("darkmode.300", 0.8)
                                    : getColor("slate.300"),
                        },
                        border: {
                            dash: [2, 2],
                            display: false,
                        },
                    },
                },
            },
        });

        // Watch class name changes
        helper.watchClassNameChanges($("html")[0], (currentClassName) => {
            reportBarChart1.update();
        });
    }
})();
