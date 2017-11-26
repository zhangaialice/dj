<html lang="en">
<head>
	<?php include("../includes/script.php"); ?>

</head>
<body>

<!-- <?php include("../includes/sql_connect.php");?>

<?php
	// 2. Perform database query
	$query  = "SELECT * ";
	$query .= "FROM fossil_manager ";
	$result = mysqli_query($connection, $query);
	$datas=array();
	// Test if there was a query error
	if (mysqli_num_rows($result)>0) {
	while($row = mysqli_fetch_assoc($result)) {
	$datas[]=$row['Manager'];
	$pv_2014[]=$row['FossilFuel_2014'];
	$pv_2015[]=$row['FossilFuel_2015'];
	$pv_2016[]=$row['FossilFuel_2016'];
	$data_2014[]=$row['Percentage_2014'];
	$data_2015[]=$row['Percentage_2015'];
	$data_2016[]=$row['Percentage_2016'];
	$num_2014[]=$row['Number_2014'];
	$num_2015[]=$row['Number_2015'];
	$num_2016[]=$row['Number_2016'];
	}}

//the following code is used for testing the json data format conversion	
$a=json_encode($datas);
// echo $a;
// print  json_encode($datas);
$p_2014 = json_encode($data_2014);

print gettype($p_2014);
$p_2015 = json_encode($data_2015);
$p_2016 = json_encode($data_2016);
$n_2014 = json_encode($num_2014);
$n_2015 = json_encode($num_2015);
$n_2016 = json_encode($num_2016);
$fp_2014=str_replace(array("'", "\"", "&quot;"),"",$p_2014);
$fp_2015=str_replace(array("'", "\"", "&quot;"),"",$p_2015);
$fp_2016=str_replace(array("'", "\"", "&quot;"),"",$p_2016);
$fp_2014=str_replace(array("'", "\"", "&quot;"),"",$n_2014);
$fp_2015=str_replace(array("'", "\"", "&quot;"),"",$n_2015);
$fp_2016=str_replace(array("'", "\"", "&quot;"),"",$n_2016);

?> -->

<?php

$string = file_get_contents("test.json");
$json_a = json_decode($string, true);



print_r (json_encode($json_a['2015']['by manager']['Percentage_2015']));
print_r (json_encode($json_a['2015']['by manager']['Manager']));


?>
 <?php print json_encode($datas);?>

<?php print str_replace(array("'", "\"", "&quot;"),"",json_encode($data_2016));?>


<canvas id="myChart" width="5" height="5"></canvas>
<script>
					/*var ctx = document.getElementById("myChart");
					var ctx = document.getElementById("myChart").getContext("2d");

					var ctx = $("#myChart");
					var ctx = "myChart";*/

					var ctx = document.getElementById("myChart");
					var myChart = new Chart(ctx, {
						type: 'bar',
						data: {
							labels: <?php print_r (json_encode($json_a['2015']['by manager']['Manager']));?>,
							datasets: [{
								label: '2015',
								data: <?php print_r (json_encode($json_a['2015']['by manager']['Percentage_2015']));?>,
								backgroundColor: Array(12).fill('rgba(255, 99, 132, 0.2)'),
								borderColor: Array(12).fill('rgba(54, 162, 235, 1)'),
								borderWidth: 1
							},
							{
								label: '2016',
								data: <?php print_r (json_encode($json_a['2016']['by manager']['Percentage_2016']));?>,
								backgroundColor: Array(12).fill('rgba(255, 206, 86, 0.2)'),
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
