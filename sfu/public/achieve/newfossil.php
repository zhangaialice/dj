
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html lang="en">
<head>


<?php include("../includes/script.php"); ?>
<?php include("../includes/css.php"); ?>

<style>
html, body { height: 100%; padding: 0; margin: 0; }

#TF{ width: 100%;}
#div1 { background: white; text-align: center;}
#div2 { background: white; text-align: center;}
#div3 { background: white; text-align: center;}
#div4 { background: white; text-align: center;}

label {
font-size: 20;
}


#content{position: fixed;
top:100px;

}

#content div {
    float:left;
    width:45%;
    height:400px;
    background: transparent;
    display:inline-block;
  }


</style>


</head>
<body>


<?php include("../includes/dropdown.php"); ?>



<div id="content">
<img  class="divider" src="image/divider.png" height="20" width="1600">



			<div id="div1">

			<label for = "idOfCanvas" id="tabletitle">Fossil Fuel Exposure Percentage - By Manager</label>
			</br>
				<canvas id="myChart" width="5" height="5"></canvas>

				<?php include("../includes/sql_connect.php");?>

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
						$data_2014[]=$row['Percentage_2014'];
						$data_2015[]=$row['Percentage_2015'];
						$data_2016[]=$row['Percentage_2016'];
						$num_2014[]=$row['Number_2014'];
						$num_2015[]=$row['Number_2015'];
						$num_2016[]=$row['Number_2016'];
						}}

						
					$a=json_encode($datas);
					$p_2014 = json_encode($data_2014);
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
					?>

					<script>
					/*var ctx = document.getElementById("myChart");
					var ctx = document.getElementById("myChart").getContext("2d");

					var ctx = $("#myChart");
					var ctx = "myChart";*/

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
	
			
			<div id="div2">

			<label for = "idOfCanvas" id="tabletitle"  style="align:center;">Fossil Fuel Number of Holdings - By Manager</label>
			</br>

				<canvas id="myChart_n" width="5" height="5"></canvas>
				
				<script>
					var ctx = document.getElementById("myChart_n");
					var myChart_n = new Chart(ctx, {
						type: 'bar',
						data: {
							labels: <?php print json_encode($datas);?>,
							datasets: [{
								label: '2014',
								data: <?php print str_replace(array("'", "\"", "&quot;"),"",json_encode($num_2014));?>,
								backgroundColor: Array(12).fill('rgba(255, 99, 132, 0.2)'),
								borderColor: Array(12).fill('rgba(54, 162, 235, 1)'),
								borderWidth: 1
							},
					{
								label: '2015',
								data: <?php print str_replace(array("'", "\"", "&quot;"),"",json_encode($num_2015));?>,
								backgroundColor: Array(12).fill('rgba(255, 206, 86, 0.2)'),
								borderColor: Array(12).fill('rgba(54, 162, 235, 1)'),
								borderWidth: 1
							},
							{
								label: '2016',
								data: <?php print str_replace(array("'", "\"", "&quot;"),"",json_encode($num_2016));?>,
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
			
	
			<div id="div3">
			<br/>


			<table  class="TF" style="width: 98%;font-size:90%">
				  <tr id="tableheader">
					<th>Manager</th>
					<th>2014</th>
					<th>2015</th>
					<th>2016</th>
				  </tr>
				<?php include("../includes/sql_connect.php");?>
				<?php
				
					// 2. Perform database query
					$query  = "SELECT * ";
					$query .= "FROM fossil_manager ";
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
					echo $formatter->format($row['Percentage_2015']);?>
					</td>
					<td><?php 
					$formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT);
					echo $formatter->format($row['Percentage_2016']);?>
					</td>
				  </tr>
				<?php
				}
				?>
			</table>
					
		    </div>	
				

			<div id="div4">
			<br/>

				<table  class="TF" style="width: 98%;font-size:90%">
				  <tr id="tableheader">
					<th>Manager</th>
					<th>2014</th>
					<th>2015</th>
					<th>2016</th>
				  </tr>
				<?php
				
					// 2. Perform database query
					$query  = "SELECT * ";
					$query .= "FROM fossil_manager ";
					$result = mysqli_query($connection, $query);
					$datas=array();
					// 3. Use returned data (if any)
					while($row = mysqli_fetch_assoc($result)) {
				?>
				  <tr>
					<td><?php 

					echo $row['Manager']; ?></td>
					<td><?php echo $row['Number_2014'];?></td>
					<td><?php echo $row['Number_2015']; ?></td>
					<td><?php echo $row['Number_2016']; ?></td>
				  </tr>
				<?php
				}
				?>
			</table>
			
			</div>
			
	</div>
	</body>		

			
			
			