(function () {
    "use strict";

    // Chart
    if ($(".simple-line-chart-2").length) {
        $(".simple-line-chart-2").each(function () {
            const ctx = $(this)[0].getContext("2d");
            new Chart(ctx, {
                type: "line",
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
                            label: "# of Votes",
                            data:
                                $(this).data("random") !== undefined
                                    ? helper.randomNumbers(0, 5, 12)
                                    : [
                                          0, 300, 400, 560, 320, 600, 720, 850,
                                          690, 805, 1200, 1010,
                                      ],
                            borderWidth: 2,
                            borderDash: [2, 2],
                            borderColor:
                                $(this).data("line-color") !== undefined
                                    ? $(this).data("line-color")
                                    : getColor("slate.300"),
                            backgroundColor: "transparent",
                            pointBorderColor: "transparent",
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
                                display: false,
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
                                display: false,
                            },
                            border: {
                                display: false,
                            },
                        },
                    },
                },
            });
        });
    }
})();
