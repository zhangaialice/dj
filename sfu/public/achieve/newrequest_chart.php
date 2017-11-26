<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html lang="en">
<head>

<link rel="stylesheet" type="text/css" href="http://tablefilter.free.fr/TableFilter/filtergrid.css">
<script src="Chart.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

</head>

<body>

  <div id="chartContainer" style="height: 300px; width: 30%;">
  </div>



<?php include("../includes/sql_connect.php");?>

<?php
$arr = [
["Endowment","Manager","Managers","2016"]];

foreach($arr as $value)
{

//calculate total of Canadian Equity for endowment
$query_t  = " SELECT SUM(Market_Value) AS TotalMarketValue";
								$query_t .= " FROM holding";
								$query_t .= " WHERE Category = '" .$value[0]."' ";
								$query_t .= " AND Asset_Class ='Canadian Equity'";
								$query_t .= " AND Year ='" .$value[3]."'";
								$report_t = mysqli_query($connection, $query_t);
								
								// Test if there was a query error
								if (!$report_t) {die("Database query failed.");};
								while($result = mysqli_fetch_assoc($report_t)){ $T_CE = $result['TotalMarketValue'];}
				//echo $T_CE."<br>";
//calculate total of global equity for endowment
	$query_t  = " SELECT SUM(Market_Value) AS TotalMarketValue";
						$query_t .= " FROM holding ";
						$query_t .= " WHERE Category = '" .$value[0]."'";
						$query_t .= " AND Asset_Class = 'Global Equity'";
						$query_t .= " AND Year ='" .$value[3]."'";
						$report_t = mysqli_query($connection, $query_t);
						// Test if there was a query error
						if (!$report_t) {die("Database query failed.");};
						while($result = mysqli_fetch_assoc($report_t)){ $T_GE = $result['TotalMarketValue'];}
				//echo $T_GE."<br>";


						//calculate total equity
	$query_t  = " SELECT SUM(Market_Value) AS TotalMarketValue";
			$query_t .= " FROM holding ";
			$query_t .= " WHERE Category = '" .$value[0]."'";
			$query_t .= " AND (Asset_Class = 'Global Equity' OR Asset_Class='Canadian Equity')";
			$query_t .= " AND Year ='" .$value[3]."'";
			$report_t = mysqli_query($connection, $query_t);
			// Test if there was a query error
			if (!$report_t) {die("Database query failed.");};
			while($result = mysqli_fetch_assoc($report_t)){ $T_TE = $result['TotalMarketValue'];}					
								
				//echo $T_TE."<br>";				
	
// 2. Perform database query
		
		
		$query  = "SELECT " .$value[2].", MV_D_CE, MV_P_CE,MV_D_GE,MV_P_GE,MV_D_TE,MV_P_TE FROM";
		$query .= " (SELECT DISTINCT(" .$value[1].") as " .$value[2]." FROM holding WHERE " .$value[1]." IS NOT NULL) AS N";
		$query .= " LEFT JOIN";
		$query .= " (SELECT " .$value[1].", SUM(Market_Value) as MV_D_CE, SUM(Market_Value)/$T_CE as MV_P_CE FROM holding WHERE Category='" .$value[0]."' AND Asset_Class ='Canadian Equity' AND Year = '" .$value[3]."' GROUP BY " .$value[1].") as CE";
		$query .= " ON N." .$value[2]." = CE. " .$value[1];
		$query .= " LEFT JOIN";
		
		
		$query .= " (SELECT " .$value[1].",SUM(Market_Value) as MV_D_GE, SUM(Market_Value)/$T_GE as MV_P_GE FROM holding WHERE Category='" .$value[0]."' AND Asset_Class ='Global Equity' AND Year = '" .$value[3]."' GROUP BY " .$value[1].") AS GE";
		$query .= " ON N." .$value[2]." = GE." .$value[1];
		$query .= " LEFT JOIN";
		
		
		$query .= " (SELECT " .$value[1].",SUM(Market_Value) as MV_D_TE, SUM(Market_Value)/$T_TE as MV_P_TE FROM holding WHERE Category='" .$value[0]."' AND (Asset_Class='Canadian Equity' or Asset_Class='Global Equity') AND Year = '" .$value[3]."' GROUP BY " .$value[1].") AS TE";
		$query .= " ON N." .$value[2]." = TE. " .$value[1];
		
		$report = mysqli_query($connection, $query);
		// Test if there was a query error
		//echo ($query)."<br>";
		if (!$report) {die("Database query failed.");}
	?>
	
				<table id="table" class="TF" >
				  <tr id="tableheader">
					<th>Manager</th>
					<th>Canadian Equity($)</th>
					<th>Canadian Equity(%)</th>
					<th>Global Equity($)</th>
					<th>Global Equity(%)<//th>
					<th>Total Equity($)</th>
					<th>Total Equity(%)</th>
					

				  </tr>
				<?php
					// 3. Use returned data (if any)
					while($row = mysqli_fetch_assoc($report)) {
				?>
				  <tr>
					<td><?php echo $row[$value[2]]; 
							$manager[]=$row[$value[2]];
					?></td>
					
					<td><?php echo $row['MV_D_CE']; 
					$formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
					echo $formatter->format($row['MV_D_CE']);
						$data_P_2014[]=$row['MV_P_CE'];
					
					?></td>
					
					<td><?php
					$formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT);
					echo $formatter->format($row['MV_P_CE']);
						$data_2014[]=$row['MV_P_CE'];
					?></td>
					<td><?php echo $row['MV_D_GE']; ?></td>
					<td><?php
					$formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT);
					echo $formatter->format($row['MV_P_TE']);?></td>
					<td><?php echo $row['MV_D_TE']; ?></td>	
					<td><?php
					$formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT);
					echo $formatter->format($row['MV_P_TE']);?></td>
				  </tr>

				<?php
				}
				?>
<?php } ?>
				</table>
				<?php
				  // 4. Release returned data
				  mysqli_free_result($report);
				?>
<!--draw new chart-->
		<!--load into two column and convert to jquery form(two array to array of associate array)-->
		
	<?php

	$ai = array_combine($manager,$data_2014);

	$datapoints =array();
	foreach($ai as $label => $value)
	{$datapoints[]= array("y"=>$value,"label"=>$label);}


			
	?>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
	<script type="text/javascript">
  window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer",
    {
      title:{
        text: "Olympic Medals of all Times (till 2012 Olympics)"
      },
      animationEnabled: true,
      legend: {
        cursor:"pointer",
        itemclick : function(e) {
          if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
              e.dataSeries.visible = false;
          }
          else {
              e.dataSeries.visible = true;
          }
          chart.render();
        }
      },
      axisY: {
        title: "Medals"
      },
      toolTip: {
        shared: true,  
        content: function(e){
          var str = '';
          var total = 0 ;
          var str3;
          var str2 ;
          for (var i = 0; i < e.entries.length; i++){
            var  str1 = "<span style= 'color:"+e.entries[i].dataSeries.color + "'> " + e.entries[i].dataSeries.name + "</span>: <strong>"+  e.entries[i].dataPoint.y + "</strong> <br/>" ; 
            total = e.entries[i].dataPoint.y + total;
            str = str.concat(str1);
          }
          str2 = "<span style = 'color:DodgerBlue; '><strong>"+e.entries[0].dataPoint.label + "</strong></span><br/>";
          str3 = "<span style = 'color:Tomato '>Total: </span><strong>" + total + "</strong><br/>";
          
          return (str2.concat(str)).concat(str3);
        }

      },
      data: [
      {        
        type: "bar",
        showInLegend: true,
        name: "Gold",
        color: "gold",
        dataPoints: 
		<?php echo json_encode($datapoints, JSON_NUMERIC_CHECK); ?>


      }]
	  
	  });
		chart.render();
}
</script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

		
<!--2. draw old chart-->
				<div id="testchart" style="height: 300px; width: 30%;">
				<label for = "idOfCanvas" id="tabletitle">Fossil Fuel Exposure Percentage - By Manager</label>
				<canvas id="myChart" >


					<script>

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
							}]
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
				
<?php print str_replace(array("'", "\"", "&quot;"),"",json_encode($data_2014));?>)
<?php print $datas[0] ;?>
<pre>
<?php
$a = array('green', 'red', 'yellow');
$b = array('avocado', 'apple', 'banana');
$c = array_combine($a, $b);

print_r($c);
?>
</pre>

<pre>
<?php
print_r($datas)
?>
</pre>

<pre>
<?php
print_r($data_2014)
?>
</pre>

<pre>
<?php

$datas=["Italy","China","France","Great Britain","Soviet Union","USA"];
$data_2014=[198,201,202,236,395,957];
$c = array_combine($datas,$data_2014);

print_r($c);
?>
</pre>
<pre>
<?php echo json_encode($c) ?>
</pre>
<script>

var test = <?php echo json_encode($c) ?>;// don't use quotes
$.each(test, function(key, value) {
    console.log('y:' + value + ", label: " + key);
});

</script>

</body>
</html>