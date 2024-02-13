(function () {
    "use strict";

    // Chart
    if ($(".simple-line-chart").length) {
        $(".simple-line-chart").each(function () {
            const el = $(this);
            const ctx = $(el)[0].getContext("2d");
            const simpleLineChart = new Chart(ctx, {
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
                            data: helper.randomNumbers(0, 5, 12),
                            borderWidth: 2,
                            borderColor: () =>
                                $(el).data("line-color") !== undefined
                                    ? $(el).data("line-color")
                                    : getColor("primary", 0.8),
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

            // Watch class name changes
            helper.watchClassNameChanges($("html")[0], (currentClassName) => {
                simpleLineChart.update();
            });
        });
    }
})();
