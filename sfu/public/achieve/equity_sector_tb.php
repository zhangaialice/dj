<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html lang="en">
<head>
<style>


html, body { height: 100%; padding: 0; margin: 0; }

.tbdiv { background: white;}

label {
font-size: 20;

}


#content {
    border: 2px solid;
    position: relative;   
    float:left;
    width:100%
  }

.tbdiv {
    float:left;
    width: 50%;
    height: 46%;
    background: transparent;
    display:inline-block;
	
  }




</style>
<link rel="stylesheet" type="text/css" href="../includes/header.css">

<link rel="stylesheet" type="text/css" href="http://tablefilter.free.fr/TableFilter/filtergrid.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	

</head>

<body>

<?php include("../includes/dropdown.php"); ?>


<div id="content">
<img  class="divider" src="image/divider.png" height="20" width="1600">
</div>


<?php include("../includes/sql_connect.php");?>

<?php
$arr = [
["Endowment","Manager","Sectors","2016"],
["Non_Endowment","Manager","Sectors","2016"],
["Total_Investment","Manager","Sectors","2016"],
["Endowment","Sector","Sectors","2016"],
["Non_Endowment","Sector","Sectors","2016"],
["Total_Investment","Sector","Sectors","2016"],
["Endowment","Manager","Sectors","2015"],
["Non_Endowment","Manager","Sectors","2015"],
["Total_Investment","Manager","Sectors","2015"],
["Endowment","Sector","Sectors","2015"],
["Non_Endowment","Sector","Sectors","2015"],
["Total_Investment","Sector","Sectors","2015"]];

foreach($arr as $value)
{

//calculate total of Canadian Equity for endowment
	$query_t  = " SELECT SUM(Market_Value) AS TotalMarketValue";
								$query_t .= " FROM holding";
								if ($value[0]=="Total_Investment") {
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
						if ($value[0]=="Total_Investment") {
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
			if ($value[0]=="Total_Investment") {
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
		
		
		if ($value[0]=="Total_Investment") {
		$query .= " (SELECT " .$value[1].", SUM(Market_Value) as MV_D_CE, SUM(Market_Value)/$T_CE as MV_P_CE FROM holding WHERE Asset_Class ='Canadian Equity' AND Year = '" .$value[3]."' GROUP BY " .$value[1].") as CE";
		} else {
		$query .= " (SELECT " .$value[1].", SUM(Market_Value) as MV_D_CE, SUM(Market_Value)/$T_CE as MV_P_CE FROM holding WHERE Category='" .$value[0]."' AND Asset_Class ='Canadian Equity' AND Year = '" .$value[3]."' GROUP BY " .$value[1].") as CE";}
		
		$query .= " ON N." .$value[2]." = CE. " .$value[1];
		$query .= " LEFT JOIN";
		
		
		if ($value[0]=="Total_Investment") {
		$query .= " (SELECT " .$value[1].",SUM(Market_Value) as MV_D_GE, SUM(Market_Value)/$T_GE as MV_P_GE FROM holding WHERE Asset_Class ='Global Equity' AND Year = '" .$value[3]."' GROUP BY " .$value[1].") AS GE";		
		} else {
		$query .= " (SELECT " .$value[1].",SUM(Market_Value) as MV_D_GE, SUM(Market_Value)/$T_GE as MV_P_GE FROM holding WHERE Category='" .$value[0]."' AND Asset_Class ='Global Equity' AND Year = '" .$value[3]."' GROUP BY " .$value[1].") AS GE";}
		
		
		$query .= " ON N." .$value[2]." = GE." .$value[1];
		$query .= " LEFT JOIN";
		
		
		
		if ($value[0]=="Total_Investment") {
		$query .= " (SELECT " .$value[1].",SUM(Market_Value) as MV_D_TE, SUM(Market_Value)/$T_TE as MV_P_TE FROM holding WHERE (Asset_Class='Canadian Equity' or Asset_Class='Global Equity') AND Year = '" .$value[3]."' GROUP BY " .$value[1].") AS TE";		
		} else {
		$query .= " (SELECT " .$value[1].",SUM(Market_Value) as MV_D_TE, SUM(Market_Value)/$T_TE as MV_P_TE FROM holding WHERE Category='" .$value[0]."' AND (Asset_Class='Canadian Equity' or Asset_Class='Global Equity') AND Year = '" .$value[3]."' GROUP BY " .$value[1].") AS TE";}
		
		
		$query .= " ON N." .$value[2]." = TE. " .$value[1];
		$query .= " ORDER BY " .$value[2]." ASC";
		

		
		$report = mysqli_query($connection, $query);

		if (!$report) {die("Database query failed.");}
	?>
			
			<br/>
			<div class="tbdiv">
			<label for = "idOfCanvas" id="tabletitle"><?php echo $value[3]." ".$value[0]." Fund (By ".$value[1].")" ?></label>
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
					     ${$value[0].'_'.$value[2].'_'.$value[3]}[]=$row[$value[2]];?></td>
					
					<td><?php  
					//change format
					$formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
					//show table
					echo $formatter->format($row['MV_D_CE']);
					//name array and call when graphing the chart
					${'CE_D_'.$value[0].'_'.$value[2].'_'.$value[3]}[] = $row['MV_D_CE'];
					
					
					?></td>
					
					
					<td><?php
					$formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT);
					echo $formatter->format($row['MV_P_CE']);
					//name array and call when graphing the chart
					${'CE_P_'.$value[0].'_'.$value[2].'_'.$value[3]}[] = $row['MV_P_CE'];
					?></td>
					
					<td><?php  
					//change format
					$formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
					//show table
					echo $formatter->format($row['MV_D_GE']);
					//name array and call when graphing the chart
					${'GE_D_'.$value[0].'_'.$value[2].'_'.$value[3]}[] = $row['MV_D_GE'];
					?></td>
					
					
					<td><?php
					$formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT);
					echo $formatter->format($row['MV_P_GE']);
					${'GE_P_'.$value[0].'_'.$value[2].'_'.$value[3]}[] = $row['MV_P_GE'];
					?></td>
					
					
					
					<td><?php  
					//change format
					$formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
					//show table
					echo $formatter->format($row['MV_D_TE']);
					//name array and call when graphing the chart
					${'TE_D_'.$value[0].'_'.$value[2].'_'.$value[3]}[] = $row['MV_D_TE'];
					?></td>
					
					
					<td><?php
					$formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT);
					echo $formatter->format($row['MV_P_TE']);
					${'TE_P_'.$value[0].'_'.$value[2].'_'.$value[3]}[] = $row['MV_P_TE'];?></td>
				  </tr>
				<?php
				}
				?>

				</table>
				</div>
		<?php } ?>
				
				<?php
				  // 4. Release returned data
				  mysqli_free_result($report);
				?>
				



</body>
</html>