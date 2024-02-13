(function () {
    "use strict";

    // Chart
    if ($(".pie-chart").length) {
        const chartColors = () => [
            getColor("pending", 0.9),
            getColor("warning", 0.9),
            getColor("primary", 0.9),
        ];

        const ctx = $(".pie-chart")[0].getContext("2d");
        const pieChart = new Chart(ctx, {
            type: "pie",
            data: {
                labels: ["Html", "Vuejs", "Laravel"],
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
                        labels: {
                            color: getColor("slate.500", 0.8),
                        },
                    },
                },
            },
        });

        // Watch class name changes
        helper.watchClassNameChanges($("html")[0], (currentClassName) => {
            pieChart.update();
        });
    }
})();
