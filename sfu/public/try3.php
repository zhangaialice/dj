<!doctype html>
<html>

<head>
    <title>Stacked Bar Chart with Groups</title>
    <style>
    canvas {
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }
    </style>
    <script type="text/javascript" src="http://www.chartjs.org/dist/2.7.1/Chart.bundle.js"></script>
    <script type="text/javascript" src="http://www.chartjs.org/samples/latest/utils.js"></script>
</head>

<body>
    <div style="width: 75%">
        <canvas id="canvas"></canvas>
    </div>
    <button id="randomizeData">Randomize Data</button>
    <script>
        var barChartData = {
            labels: ["January", "February"],
            datasets: [
            {
                    label: 'Dataset 1',
                    backgroundColor: window.chartColors.red,
                    data: [
                      3.23730977531,
                      3.23730977531,
                    ]
            },
            {
                    label: 'Dataset 1',
                    backgroundColor: window.chartColors.blue,
                    data: [
                      0.336643898701,
                      0.0,
                    ]
                  },
             {
                    label: 'Dataset 1',
                    backgroundColor: window.chartColors.yellow,
                    data: [
                      4,
                      5,
                    ]
                  },
            {
                    label: 'Dataset 1',
                    backgroundColor: window.chartColors.green,
                    data: [
                      2,
                      3,
                    ]
                  },
            ]

        };
        window.onload = function() {
            var ctx = document.getElementById("canvas").getContext("2d");
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: barChartData,
                options: {
                    title:{
                        display:true,
                        text:"Chart.js Bar Chart - Stacked"
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false
                    },
                    responsive: true,
                    scales: {
                        xAxes: [{
                            stacked: true,
                        }],
                        yAxes: [{
                            stacked: true
                        }]
                    }
                }
            });
        myBar.data.datasets[0].backgroundColor = "yellow";
        myBar.update();
        };

        document.getElementById('randomizeData').addEventListener('click', function() {
            barChartData.datasets.forEach(function(dataset, i) {
                dataset.data = dataset.data.map(function() {
                    return randomScalingFactor();
                });
            });
            window.myBar.update();
        });
    </script>

</body>

</html>
