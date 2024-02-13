(function () {
    "use strict";

    // Chart
    if ($("#report-line-chart").length) {
        const ctx = $("#report-line-chart")[0].getContext("2d");
        const reportLineChart = new Chart(ctx, {
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
                        data: [
                            0, 200, 250, 200, 700, 550, 650, 1050, 950, 1100,
                            900, 1200,
                        ],
                        borderWidth: 2,
                        borderColor: () => getColor("primary", 0.8),
                        backgroundColor: "transparent",
                        pointBorderColor: "transparent",
                        tension: 0.4,
                    },
                    {
                        label: "# of Votes",
                        data: [
                            0, 300, 400, 560, 320, 600, 720, 850, 690, 805,
                            1200, 1010,
                        ],
                        borderWidth: 2,
                        borderDash: [2, 2],
                        borderColor: () =>
                            $("html").hasClass("dark")
                                ? getColor("slate.400", 0.6)
                                : getColor("slate.400"),
                        backgroundColor: "transparent",
                        pointBorderColor: "transparent",
                        tension: 0.4,
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
                                size: 12,
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
                            font: {
                                size: 12,
                            },
                            color: getColor("slate.500", 0.8),
                            callback: function (value, index, values) {
                                return "$" + value;
                            },
                        },
                        grid: {
                            color: () =>
                                $("html").hasClass("dark")
                                    ? getColor("slate.500", 0.3)
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
            reportLineChart.update();
        });
    }
})();
