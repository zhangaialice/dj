
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html lang="en">
<head>

 <?php include("../includes/script.php"); ?>
 <?php include("../includes/css.php"); ?>

 <style>
html, body { height: 100%; padding: 0; margin: 0; }

#TF{ width: 90%;}
#diva { background: white;text-align: center;}
#divb { background: white;text-align: center;}

label {
font-size: 20;
}


#content div {
    float:left;
    width:90%;
    height:400px;
    background: transparent;
    display:inline-block;
  }
</style>
</head>
<body>
<?php include("../includes/dropdown.php"); ?>


<div id="content">

			<div id="diva">

				<label for = "idOfCanvas" id="tabletitle">Military Exposure Percentage - By Manager</label>
				<canvas id="myChart" width="5" height="5"></canvas>

			<?php include("../includes/sql_connect.php");?>

				<?php
					// 2. Perform database query
					$query  = "SELECT * ";
					$query .= "FROM military ";
					$result = mysqli_query($connection, $query);
					$datas=array();
					// Test if there was a query error
					if (mysqli_num_rows($result)>0) {
					while($row = mysqli_fetch_assoc($result)) {
					$datas[]=$row['Manager'];
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


				?>

				<script>
				var ctx = document.getElementById("myChart");
				var ctx = document.getElementById("myChart").getContext("2d");

				var ctx = $("#myChart");
				var ctx = "myChart";

				var ctx = document.getElementById("myChart");
				var myChart = new Chart(ctx, {
					type: 'bar',
					data: {
						labels: <?php print json_encode($datas);?>,
						datasets: [{
							label: '2014',
							data: <?php print str_replace(array("'", "\"", "&quot;"),"",json_encode($data_2014));?>,
							backgroundColor: Array(12).fill('rgba(255, 99, 132, 0.2)'),
							borderColor: Array(12).fill('rgba(54, 162, 235, 1)'),
							borderWidth: 1
						},
				{
							label: '2015',
							data: <?php print str_replace(array("'", "\"", "&quot;"),"",json_encode($data_2015));?>,
							backgroundColor: Array(12).fill('rgba(255, 206, 86, 0.2)'),
							borderColor: Array(12).fill('rgba(54, 162, 235, 1)'), 
							borderWidth: 1
						},
						{
									label: '2016',
									data: <?php print str_replace(array("'", "\"", "&quot;"),"",json_encode($data_2016));?>,
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
	
			</div>
	
			
			<div id="divb">
			</br>
			</br>	
			<table class="TF" style="width: 100%;font-size:90%">
				  <tr id="tableheader">
					<th>Security Type</th>
					<th>2014</th>
					<th>2015</th>
					<th>2016</th>
				  </tr>
				<?php
				
					// 2. Perform database query
					$query  = "SELECT * ";
					$query .= "FROM military ";
					$result = mysqli_query($connection, $query);
					$datas=array();
					// 3. Use returned data (if any)
					while($row = mysqli_fetch_assoc($result)) {
				?>
				  <tr>
					<td><?php echo $row['Manager']; ?></td>
					<td><?php 
					$formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT);
					echo $formatter->format($row['Percentage_2014']);?></td>
					<td><?php 
					$formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT);
					echo $formatter->format($row['Percentage_2015']);?></td>
					<td><?php 
					$formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT);
					echo $formatter->format($row['Percentage_2016']);?></td>
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
	</body>		

			
			
			