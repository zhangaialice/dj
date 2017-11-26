<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html lang="en">
<head>
<?php include("../includes/script.php"); ?>
<?php include("../includes/css.php"); ?>	

<style>



#content {
    position: relative;   
    float:left;
    width:100%
  }

</style>
</head>

<body>

<?php include("../includes/dropdown.php"); ?>


<div id="content">

	<div id="div1" class="one-third">
	</div>
	<div id="div2" class="one-third">
	</div>
	<div id="div3" class="one-third">
	</div>
	<div id="div4" class="one-third">
	</div>
	<div id="div5" class="one-third">
	</div>
	<div id="div6" class="one-third">
	</div>
	<div id="div7" class="one-third">
	</div>
	<div id="div8" class="one-third">
	</div>
	<div id="div9" class="one-third">
	</div>
</div>


<?php include("../includes/sql_connect.php");?>

<?php
$arr = [
["Endowment","Manager","Managers","2016"],
["Non_Endowment","Manager","Managers","2016"],
["All","Manager","Managers","2016"],
["Endowment","Sector","Sectors","2016"],
["Non_Endowment","Sector","Sectors","2016"],
["All","Sector","Sectors","2016"],
["Endowment","Manager","Managers","2015"],
["Non_Endowment","Manager","Managers","2015"],
["All","Manager","Managers","2015"],
["Endowment","Sector","Sectors","2015"],
["Non_Endowment","Sector","Sectors","2015"],
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
		

		
		$report = mysqli_query($connection, $query);

		if (!$report) {die("Database query failed.");}
	?>
	
				<!--<table id="table" class="TF" >
				  <tr id="tableheader">
					<th>Manager</th>
					<th>Canadian Equity($)</th>
					<th>Canadian Equity(%)</th>
					<th>Global Equity($)</th>
					<th>Global Equity(%)<//th>
					<th>Total Equity($)</th>
					<th>Total Equity(%)</th>
				  </tr>-->
				<?php
					// 3. Use returned data (if any)
					while($row = mysqli_fetch_assoc($report)) {
				?>
				  <tr>
					<td><?php //echo $row[$value[2]];
					     ${$value[0].'_'.$value[2].'_'.$value[3]}[]=$row[$value[2]];?></td>
					
					<td><?php  
					//change format
					$formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
					//show table
					$formatter->format($row['MV_D_CE']);
					//name array and call when graphing the chart
					${'CE_D_'.$value[0].'_'.$value[2].'_'.$value[3]}[] = $row['MV_D_CE'];
					
					
					?></td>
					
					
					<td><?php
					$formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT);
					$formatter->format($row['MV_P_CE']);
					//name array and call when graphing the chart
					${'CE_P_'.$value[0].'_'.$value[2].'_'.$value[3]}[] = $row['MV_P_CE'];
					?></td>
					
					<td><?php  
					//change format
					$formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
					//show table
					$formatter->format($row['MV_D_GE']);
					//name array and call when graphing the chart
					${'GE_D_'.$value[0].'_'.$value[2].'_'.$value[3]}[] = $row['MV_D_GE'];
					?></td>
					
					
					<td><?php
					$formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT);
					$formatter->format($row['MV_P_GE']);
					${'GE_P_'.$value[0].'_'.$value[2].'_'.$value[3]}[] = $row['MV_P_GE'];
					?></td>
					
					
					
					<td><?php  
					//change format
					$formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
					//show table
					$formatter->format($row['MV_D_TE']);
					//name array and call when graphing the chart
					${'TE_D_'.$value[0].'_'.$value[2].'_'.$value[3]}[] = $row['MV_D_TE'];
					?></td>
					
					
					<td><?php
					$formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT);
					$formatter->format($row['MV_P_TE']);
					${'TE_P_'.$value[0].'_'.$value[2].'_'.$value[3]}[] = $row['MV_P_TE'];?></td>
				  </tr>
				<?php
				}
				?>
<?php } ?>
				</table>
				<!--<?php print_r($CE_P_Non_Endowment_Managers_2016); ?><br/>
				<?php print_r($Non_Endowment_Managers_2016); ?><br/>
				<?php print_r($GE_P_Non_Endowment_Managers_2016); ?><br/>
				<?php print_r($Non_Endowment_Managers_2016); ?><br/>
				<?php print_r($TE_P_Non_Endowment_Managers_2016); ?><br/>
				<?php print_r($Non_Endowment_Managers_2016); ?><br/>-->
				<?php
				  // 4. Release returned data
				  mysqli_free_result($report);
				?>

<!-- The above the generate all 12 tables(endowment*3,manager*2,year*2 and all 36 array(endowment*3,manager*2, year*2, CanadianEquity*3), below is to generate jchart using the table above-->

<pre>
<?php
	$tl = array("Endowment_Managers_2016","Non_Endowment_Managers_2016","All_Managers_2016","Endowment_Sectors_2016","Non_Endowment_Sectors_2016","All_Sectors_2016",
	"Endowment_Managers_2015","Non_Endowment_Managers_2015","All_Managers_2015","Endowment_Sectors_2015","Non_Endowment_Sectors_2015","All_Sectors_2015");
	$ar = array("CE_P_","GE_P_","TE_P_");
	
	foreach ($tl as $table) { 
	
			foreach ($ar as $value) {
	
										$var = $value.$table;
										$var1= $value.$table.'_combine';
										$var2= $value.$table.'_ass';
										//print_r($$var)."<br/>";
										$$var1 = array_combine($$table,$$var);
										//print_r($$var1)."<br/>";
										$$var2 =array();
										foreach($$var1 as $label => $value)
											{array_push($$var2, array("y"=>$value,"label"=>$label));};
											
										//echo json_encode($$var2, JSON_NUMERIC_CHECK); 
											//print_r($$var2)."<br/>";
										}
	
	
	}

	
?>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	
	<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
	
	<script type="text/javascript">
	
	<?php
	
	
	
	$test = array(["CE_P_Endowment_Managers_2016_ass", "CE_P_Endowment_Managers_2015_ass","div1","Canadian Equity (Endowment Fund)"],
	["GE_P_Endowment_Managers_2016_ass", "GE_P_Endowment_Managers_2015_ass","div2","Global Equity (Endowment Fund)"],
	["TE_P_Endowment_Managers_2016_ass", "TE_P_Endowment_Managers_2015_ass","div3","Total Equity (Endowment Fund)"],
	["CE_P_Non_Endowment_Managers_2016_ass", "CE_P_Non_Endowment_Managers_2015_ass","div4","Canadian Equity (Non Endowment Fund)"],
	["GE_P_Non_Endowment_Managers_2016_ass", "GE_P_Non_Endowment_Managers_2015_ass","div5","Global Equity (Non Endowment Fund)"],
	["TE_P_Non_Endowment_Managers_2016_ass", "TE_P_Non_Endowment_Managers_2015_ass","div6","Total Equity (Non Endowment Fund)"],
	["CE_P_All_Managers_2016_ass", "CE_P_All_Managers_2015_ass","div7","Canadian Equity (Total Investment)"],
	["GE_P_All_Managers_2016_ass", "GE_P_All_Managers_2015_ass","div8","Global Equity (Total Investment)"],
	["TE_P_All_Managers_2016_ass", "TE_P_All_Managers_2015_ass","div9","Total Equity (Total Investment)"]
	);
	for ($i = 0; $i <= 8; $i++) { ?>
	

	
	//window.onload = function () {
    var chart<?php echo $i;?> = new CanvasJS.Chart("<?php echo $test[$i][2];?>",
    {
      title:{
        text:"<?php echo $test[$i][3];?>",//-name change
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
				labelFontFamily: "Lucida Sans Unicode",
				beginAtZero:true
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

		<?php echo json_encode($$test[$i][0], JSON_NUMERIC_CHECK); ?>// data change


      },
	  {        
        type: "bar",
        showInLegend: true,
        name: "2015-12-31",
        color: "silver",
        dataPoints: 
		<?php echo json_encode($$test[$i][1], JSON_NUMERIC_CHECK); ?>//data change


      },
	  ]
	  
	  });

		chart<?php echo $i;?>.render();
		chart<?php echo $i;?>={};
	//};
<?php }?>	  

	
</script>

</body>
</html>