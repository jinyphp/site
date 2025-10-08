<div class="chart">
    <div class="chartjs-size-monitor">
        <div class="chartjs-size-monitor-expand">
            <div class=""></div>
        </div>
        <div class="chartjs-size-monitor-shrink">
            <div class=""></div>
        </div>
    </div>
    <canvas id="chartjs-line" style="display: block; width: 667px; height: 300px;" width="667" height="300"
        class="chartjs-render-monitor">
    </canvas>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Line chart
        new Chart(document.getElementById("chartjs-line"), {
            type: "line",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Sales ($)",
                    fill: true,
                    backgroundColor: "transparent",
                    borderColor: window.theme.primary,
                    data: [2115, 1562, 1584, 1892, 1487, 2223, 2966, 2448, 2905, 3838, 2917, 3327]
                }, {
                    label: "Orders",
                    fill: true,
                    backgroundColor: "transparent",
                    borderColor: "#adb5bd",
                    borderDash: [4, 4],
                    data: [958, 724, 629, 883, 915, 1214, 1476, 1212, 1554, 2128, 1466, 1827]
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                tooltips: {
                    intersect: false
                },
                hover: {
                    intersect: true
                },
                plugins: {
                    filler: {
                        propagate: false
                    }
                },
                scales: {
                    xAxes: [{
                        reverse: true,
                        gridLines: {
                            color: "rgba(0,0,0,0.05)"
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            stepSize: 500
                        },
                        display: true,
                        borderDash: [5, 5],
                        gridLines: {
                            color: "rgba(0,0,0,0)",
                            fontColor: "#fff"
                        }
                    }]
                }
            }
        });
    });
</script>