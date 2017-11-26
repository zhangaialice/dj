<script>

var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["BEAM","BMO","Bissett","Greystone","PHN","Pyramis","SIAS","SPG","SPI","TD","NG","Total Portfolio"]
        datasets: [{
            label: '2014',
            data: {{ data }}
            backgroundColor: Array(12).fill('rgba(255, 99, 132, 0.2)'),
            borderColor: Array(12).fill('rgba(54, 162, 235, 1)'),
            borderWidth: 1
        },
{
            label: '2015',
            data: {{ data }}
            backgroundColor: Array(12).fill('rgba(255, 206, 86, 0.2)'),
            borderColor: Array(12).fill('rgba(54, 162, 235, 1)'),
            borderWidth: 1
        },
        {
            label: '2016',
            data: {{ data }}
            backgroundColor: Array(12).fill('rgba(75, 192, 192, 0.2)'),
            borderColor: Array(12).fill('rgba(54, 162, 235, 1)'),
            borderWidth: 1
        }

]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>

< script
src = "https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.js" > < / script >

< script
src = "//code.jquery.com/jquery-1.12.4.js" > < / script >