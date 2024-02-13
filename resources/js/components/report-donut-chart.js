(function () {
    "use stirct";

    // Chart
    if ($("#report-donut-chart").length) {
        const chartColors = () => [
            getColor("pending", 0.9),
            getColor("warning", 0.9),
            getColor("primary", 0.9),
        ];

        const ctx = $("#report-donut-chart")[0].getContext("2d");
        const reportDonutChart = new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: [
                    "31 - 50 Years old",
                    ">= 50 Years old",
                    "17 - 30 Years old",
                ],
                datasets: [
                    {
                        data: [15, 10, 65],
                        backgroundColor: chartColors,
                        hoverBackgroundColor: chartColors,
                        borderWidth: 5,
                        borderColor: () =>
                            $("html").hasClass("dark")
                                ? getColor("darkmode.700")
                                : getColor("white"),
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
                cutout: "80%",
            },
        });

        // Watch class name changes
        helper.watchClassNameChanges($("html")[0], (currentClassName) => {
            reportDonutChart.update();
        });
    }
})();
