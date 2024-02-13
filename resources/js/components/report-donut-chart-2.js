(function () {
    "use strict";

    // Chart
    if ($(".report-donut-chart-2").length) {
        const chartColors = () => [
            getColor("pending", 0.9),
            getColor("warning", 0.9),
            getColor("primary", 0.9),
        ];

        const ctx = $(".report-donut-chart-2")[0].getContext("2d");
        const reportDonutChart2 = new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: ["Yellow", "Dark"],
                datasets: [
                    {
                        data: [15, 10, 65],
                        backgroundColor: chartColors,
                        hoverBackgroundColor: chartColors,
                        borderWidth: 2,
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
                cutout: "83%",
            },
        });

        // Watch class name changes
        helper.watchClassNameChanges($("html")[0], (currentClassName) => {
            reportDonutChart2.update();
        });
    }
})();
