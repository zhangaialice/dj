<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html lang="en">
<head>
<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
<script src="Chart.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="../includes/navigation.js"></script>
<link rel="stylesheet" type="text/css" href="../includes/main.css">
</head>

<body>
	<?php include("../includes/navigation.php");?>
		<div class="content">
			<div id="top_by_category">
				<label  for = "idOfCanvas" id ="tabletitle" >Fossil Fuel Exposure Percentage - By Asset Class</label>
				<canvas id="myChart" width="5" height="5"></canvas>

			<?php include("../includes/sql_connect.php");?>

				<?php
					// 2. Perform database query
					$query  = "SELECT * ";
					$query .= "FROM fossil_category ";
					$result = mysqli_query($connection, $query);
					$datas=array();
					// Test if there was a query error
					if (mysqli_num_rows($result)>0) {
					while($row = mysqli_fetch_assoc($result)) {
					$datas[]=$row['Category'];
					$data_2014[]=$row['Percentage_2014'];
					$data_2015[]=$row['Percentage_2015'];
					$data_2016[]=$row['Percentage_2016'];
					}}

				$a=json_encode($datas);
				$p_2014 = json_encode($data_2014);
				$p_2015 = json_encode($data_2015);
				$p_2016 = json_encode($data_2016);
			    $fp_2014=str_replace(array("'", "\"", "&quot;"),"",$p_2014);
				$fp_2015=str_replace(array("'", "\"", "&quot;"),"",$p_2015);
				$fp_2016=str_replace(array("'", "\"", "&quot;"),"",$p_2016);
				//print b

				?>

				<script>
				var ctx = document.getElementById("myChart");
				var myChart = new Chart(ctx, {
					type: 'bar',
					data: {
						labels: <?php print json_encode($datas);?>,
						datasets: [{
							label: '2014',
							data: <?php print str_replace(array("'", "\"", "&quot;"),"",json_encode($data_2014));?>,
							backgroundColor: [
								'rgba(255, 99, 132, 0.2)',
								'rgba(255, 99, 132, 0.2)',
								'rgba(255, 99, 132, 0.2)'
							],
							borderColor: [
								'rgba(54, 162, 235, 1)',
								'rgba(54, 162, 235, 1)',
								'rgba(54, 162, 235, 1)'
							],
							borderWidth: 1
						},
				{
							label: '2015',
							data: <?php print str_replace(array("'", "\"", "&quot;"),"",json_encode($data_2015));?>,
							backgroundColor: [
								'rgba(255, 206, 86, 0.2)',
								'rgba(255, 206, 86, 0.2)',
								'rgba(255, 206, 86, 0.2)'
							],
							borderColor: [
								'rgba(54, 162, 235, 1)',
								'rgba(54, 162, 235, 1)',
								'rgba(54, 162, 235, 1)'
							],
							borderWidth: 1
						},
						{
									label: '2016',
									data: <?php print str_replace(array("'", "\"", "&quot;"),"",json_encode($data_2016));?>,
									backgroundColor: [
										'rgba(75, 192, 192, 0.2)',
										'rgba(75, 192, 192, 0.2)',
										'rgba(75, 192, 192, 0.2)'
									],
									borderColor: [
								'rgba(54, 162, 235, 1)',
								'rgba(54, 162, 235, 1)',
								'rgba(54, 162, 235, 1)'
									],
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
				<table id="table">
				  <tr id="tableheader">
					<th>Category</th>
					<th>2014</th>
					<th>2015</th>
					<th>2016</th>
				  </tr>
				<?php
				
					// 2. Perform database query
					$query  = "SELECT * ";
					$query .= "FROM fossil_category ";
					$result = mysqli_query($connection, $query);
					$datas=array();
					// 3. Use returned data (if any)
					while($row = mysqli_fetch_assoc($result)) {
				?>
				  <tr>
					<td><?php echo $row['Category']; ?></td>
					<td><?php echo $row['Percentage_2014']; ?></td>
					<td><?php echo $row['Percentage_2015']; ?></td>
					<td><?php echo $row['Percentage_2016']; ?></td>
				  </tr>
				<?php
				}
				?>
			</table>
				<?php
				  // 4. Release returned data
				  mysqli_free_result($result);
				?>
			</div>
		</div>
	</div>
	

	<div class="footer">
	<img src="image/divider.png" height="30" width="1600">
	</div>
</body>
</html>