<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="en">
<head>
<?php include("../includes/script.php"); ?>
<?php include("../includes/css.php"); ?>
<style>
html, body { height: 100%; padding: 0; margin: 0; }

#TF{ width: 90%;}
#div1 { background: white;text-align: center;}
#div2 { background: white;text-align: center;}

label {
font-size: 20;
}


</style>

</head>
<body>
<?php include("../includes/dropdown.php"); ?>
	<div id="content">

			<div id="div1" class="one">
			
			
	
				<label for = "idOfCanvas" id="tabletitle">Fossil Fuel Exposure Percentage - By Asset Class</label>
				<canvas id="myChart" width="80%" height="150%"></canvas>

			<?php include("../includes/sql_connect.php");?>

				<?php
					// 2. Perform database query
					$query  = "SELECT * ";
					$query .= "FROM tobacco ";
					$result = mysqli_query($connection, $query);
					$datas=array();
					// Test if there was a query error
					if (mysqli_num_rows($result)>0) {
					while($row = mysqli_fetch_assoc($result)) {
					$datas[]=$row['manager'];
					$pv_2014[]=$row['tobacco_2014'];
					$pv_2015[]=$row['tobacco_2015'];
					$pv_2016[]=$row['tobacco_2016'];
					$data_2014[]=$row['percentage_2014'];
					$data_2015[]=$row['percentage_2015'];
					$data_2016[]=$row['percentage_2016'];
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
			
			<div id="div2" class="one">

			
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
					$query .= "FROM tobacco ";
					$result = mysqli_query($connection, $query);
					$datas=array();
					// 3. Use returned data (if any)
					while($row = mysqli_fetch_assoc($result)) {
				?>
				  <tr>
					<td><?php $manager[]=$row['manager'];
					echo $row['manager'];?></td>
					<td><?php 
					$formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT);
					echo $formatter->format($row['percentage_2014']);?></td>
					<td><?php 
					$formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT);
					echo $formatter->format($row['percentage_2015']);?></td>
					<td><?php 
					$formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT);
					echo $formatter->format($row['percentage_2016']);?></td>
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
		
<?php array_pop($manager);
		//print_r ($manager)?>
		
		<?php
			
			$loop_arr=array("2014","2015","2016");
			
			for ($i = 0; $i <= 2; $i++) { 
			
			
			foreach (${'pv_'.$loop_arr[$i]} as $value) {

			${'test_pv_'.$loop_arr[$i]}[] = $value/end(${'pv_'.$loop_arr[$i]});//change year
			
			};
			array_pop(${'test_pv_'.$loop_arr[$i]});
				//print_r (${'test_pv_'.$loop_arr[$i]});
				
			${'asso_pv_'.$loop_arr[$i]} = array_combine($manager, ${'test_pv_'.$loop_arr[$i]});
			//print_r (${'asso_pv_'.$loop_arr[$i]});
			
			${'test1_pv_'.$loop_arr[$i]} =array();//-change associate array name
			foreach(${'asso_pv_'.$loop_arr[$i]} as $label => $value)
			{array_push(${'test1_pv_'.$loop_arr[$i]}, array("y"=>$value,"label"=>$label));}	
			
			//print_r (${'test1_pv_'.$loop_arr[$i]});
			
			}
		?>

	<div id="div5" class="one-third"></div>
	<div id="div6" class="one-third"></div>
	<div id="div7" class="one-third"></div>		
	
	
	<script type="text/javascript">
	
	<?php
	
	
	
	$test = array(["test1_pv_2014", "div5","2014 Allocation of Military Exposure between Managers"],
	["test1_pv_2015", "div6","2015 Allocation of Military Exposure between Managers"],
	["test1_pv_2016", "div7","2016 Allocation of Military Exposure between Managers"]
	);
	for ($i = 0; $i <= 2; $i++) { ?>
	
	
//window.onload = function () {
	var chart<?php echo $i;?> = new CanvasJS.Chart("<?php echo $test[$i][1];?>",
	{
		title:{
			text: " <?php echo $test[$i][2];?>",
			fontSize: 20,
		},
		exportFileName: "Pie Chart",
		exportEnabled: true,
                animationEnabled: true,
		legend:{
			verticalAlign: "bottom",
			horizontalAlign: "center"
		},
		data: [
		{       
			type: "pie",
			showInLegend: false,
			toolTipContent: "{label}: <strong>{y}</strong>",
			indexLabel: "{label} {y}",
			dataPoints: 
			<?php echo json_encode($$test[$i][0], JSON_NUMERIC_CHECK); ?>
			
	}
	]
	
	});
	chart<?php echo $i;?>.render();
	chart<?php echo $i;?>={};
//};
	<?php };?>

</script>	

</div>	
</body>
</html>