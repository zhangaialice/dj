<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html lang="en">
<head>

<link rel="stylesheet" type="text/css" href="http://tablefilter.free.fr/TableFilter/filtergrid.css">
</head>

<body>


<div id="CE_EN_M" style="height: 500px; width: 40%;"></div>


<?php include("../includes/sql_connect.php");?>

<?php
$arr = [
["Endowment","Manager","Managers","2016"],
["Non-Endowment","Manager","Managers","2016"],
["All","Manager","Managers","2016"],
["Endowment","Sector","Sectors","2016"],
["Non-Endowment","Sector","Sectors","2016"],
["All","Sector","Sectors","2016"],
["Endowment","Manager","Managers","2015"],
["Non-Endowment","Manager","Managers","2015"],
["All","Manager","Managers","2015"],
["Endowment","Sector","Sectors","2015"],
["Non-Endowment","Sector","Sectors","2015"],
["All","Sector","Sectors","2015"]];

foreach($arr as $value)
{

//calculate total of Canadian Equity for endowment
	$query_t  = " SELECT SUM(Market_Value) AS TotalMarketValue";
								$query_t .= " FROM holding";
								if ($value[0]=="All") {
									$query_t .= " WHERE Category IS NOT NULL";
								} else {
								$query_t .= " WHERE Category = '" .$value[0]."' ";}
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
						if ($value[0]=="All") {
					    $query_t .= " WHERE Category IS NOT NULL";
						} else {
						$query_t .= " WHERE Category = '" .$value[0]."'";}
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
			if ($value[0]=="All") {
			$query_t .= " WHERE Category IS NOT NULL";
			} else {
			$query_t .= " WHERE Category = '" .$value[0]."'";}
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
		
		
		if ($value[0]=="All") {
		$query .= " (SELECT " .$value[1].", SUM(Market_Value) as MV_D_CE, SUM(Market_Value)/$T_CE as MV_P_CE FROM holding WHERE Asset_Class ='Canadian Equity' AND Year = '" .$value[3]."' GROUP BY " .$value[1].") as CE";
		} else {
		$query .= " (SELECT " .$value[1].", SUM(Market_Value) as MV_D_CE, SUM(Market_Value)/$T_CE as MV_P_CE FROM holding WHERE Category='" .$value[0]."' AND Asset_Class ='Canadian Equity' AND Year = '" .$value[3]."' GROUP BY " .$value[1].") as CE";}
		
		$query .= " ON N." .$value[2]." = CE. " .$value[1];
		$query .= " LEFT JOIN";
		
		
		if ($value[0]=="All") {
		$query .= " (SELECT " .$value[1].",SUM(Market_Value) as MV_D_GE, SUM(Market_Value)/$T_GE as MV_P_GE FROM holding WHERE Asset_Class ='Global Equity' AND Year = '" .$value[3]."' GROUP BY " .$value[1].") AS GE";		
		} else {
		$query .= " (SELECT " .$value[1].",SUM(Market_Value) as MV_D_GE, SUM(Market_Value)/$T_GE as MV_P_GE FROM holding WHERE Category='" .$value[0]."' AND Asset_Class ='Global Equity' AND Year = '" .$value[3]."' GROUP BY " .$value[1].") AS GE";}
		
		
		$query .= " ON N." .$value[2]." = GE." .$value[1];
		$query .= " LEFT JOIN";
		
		
		
		if ($value[0]=="All") {
		$query .= " (SELECT " .$value[1].",SUM(Market_Value) as MV_D_TE, SUM(Market_Value)/$T_TE as MV_P_TE FROM holding WHERE (Asset_Class='Canadian Equity' or Asset_Class='Global Equity') AND Year = '" .$value[3]."' GROUP BY " .$value[1].") AS TE";		
		} else {
		$query .= " (SELECT " .$value[1].",SUM(Market_Value) as MV_D_TE, SUM(Market_Value)/$T_TE as MV_P_TE FROM holding WHERE Category='" .$value[0]."' AND (Asset_Class='Canadian Equity' or Asset_Class='Global Equity') AND Year = '" .$value[3]."' GROUP BY " .$value[1].") AS TE";}
		
		
		$query .= " ON N." .$value[2]." = TE. " .$value[1];
		$query .= " ORDER BY " .$value[2]." ASC";
		
		//echo $query."<br>";
		
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
					     ${$value[2].'_'.$value[0].'_'.$value[3]}[]=$row[$value[2]];?></td>
					
					<td><?php  
					//change format
					$formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
					//show table
					echo $formatter->format($row['MV_D_CE']);
					//name array and call when graphing the chart
					${'CE_D_'.$value[0].'_'.$value[3].'_'.$value[2]}[] = $row['MV_D_CE'];
					
					
					?></td>
					
					
					<td><?php
					$formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT);
					echo $formatter->format($row['MV_P_CE']);
					//name array and call when graphing the chart
					${'CE_P_'.$value[0].'_'.$value[3].'_'.$value[2]}[] = $row['MV_P_CE'];
					?></td>
					
					<<td><?php  
					//change format
					$formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
					//show table
					echo $formatter->format($row['MV_D_GE']);
					//name array and call when graphing the chart
					${'GE_D_'.$value[0].'_'.$value[3].'_'.$value[2]}[] = $row['MV_D_GE'];
					?></td>
					
					
					<td><?php
					$formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT);
					echo $formatter->format($row['MV_P_GE']);
					${'GE_P_'.$value[0].'_'.$value[3].'_'.$value[2]}[] = $row['MV_P_GE'];
					?></td>
					
					
					
					<td><?php  
					//change format
					$formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
					//show table
					echo $formatter->format($row['MV_D_TE']);
					//name array and call when graphing the chart
					${'TE_D_'.$value[0].'_'.$value[3].'_'.$value[2]}[] = $row['MV_D_TE'];
					?></td>
					
					
					<td><?php
					$formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT);
					echo $formatter->format($row['MV_P_TE']);
					${'TE_P_'.$value[0].'_'.$value[3].'_'.$value[2]}[] = $row['MV_P_TE'];?></td>
				  </tr>
				<?php
				}
				?>
<?php } ?>
				</table>
				<?php print_r($CE_P_Endowment_2016_Managers); ?><br/>
				<?php print_r($Managers_Endowment_2016); ?><br/>
				<?php
				  // 4. Release returned data
				  mysqli_free_result($report);
				?>

<!-- The above the generate all 12 tables(endowment*3,manager*2,year*2 and all 36 array(endowment*3,manager*2, year*2, CanadianEquity*3), below is to generate jchart using the table above-->

<?php
	
	
	$Ass_2016 = array_combine($Managers_Endowment_2016,$CE_P_Endowment_2016_Managers);
	$Ass_2015 = array_combine($Managers_Endowment_2015,$CE_P_Endowment_2015_Managers);

	$datapoints_2016 =array();
	foreach($Ass_2016 as $label => $value)
	{$datapoints_2016[]= array("y"=>$value,"label"=>$label);}
	echo print_r($datapoints_2016);
	$datapoints_2015 =array();
	foreach($Ass_2015 as $label => $value)
	{$datapoints_2015[]= array("y"=>$value,"label"=>$label);}


			
	?>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
	<script type="text/javascript">
	
	window.onload = function () {
    var chart = new CanvasJS.Chart("CE_EN_M",//-div name change
    {
      title:{
        text: "Canadian Equity - Endowment Fund",//-name change
		fontSize: 20,
		fontFamily: "Lucida Sans Unicode"
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
	  axisX:{
				interval: 1,
				gridThickness: 0,
				labelFontSize: 10,
				labelFontStyle: "normal",
				labelFontWeight: "normal",
				labelFontFamily: "Lucida Sans Unicode"
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
        name: "2016-12-31",
        color: "gold",
        dataPoints: 
		<?php echo json_encode($datapoints_2016, JSON_NUMERIC_CHECK); ?>// data change


      },
	  {        
        type: "bar",
        showInLegend: true,
        name: "2015-12-31",
        color: "silver",
        dataPoints: 
		<?php echo json_encode($datapoints_2015, JSON_NUMERIC_CHECK); ?>//data change


      },
	  ]
	  
	  });
		chart.render();
		
	};

</script>


		
				
</body>
</html>