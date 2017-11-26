<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html lang="en">
<head>

<link rel="stylesheet" type="text/css" href="http://tablefilter.free.fr/TableFilter/filtergrid.css">
</head>

<body>


<?php include("../includes/sql_connect.php");?>



<?php
//calculate total of Canadian Equity for endowment
$query_t  = " SELECT SUM(Market_Value) AS TotalMarketValue";
								$query_t .= " FROM holding";
								$query_t .= " WHERE Category = 'Endowment' ";
								$query_t .= " AND Asset_Class ='Canadian Equity'";
								$query_t .= " AND Year ='2016'";
								$report_t = mysqli_query($connection, $query_t);
								// Test if there was a query error
								if (!$report_t) {die("Database query failed.");};
								while($result = mysqli_fetch_assoc($report_t)){ $T_CE = $result['TotalMarketValue'];}
				echo $T_CE."<br>";
//calculate total of global equity for endowment
	$query_t  = " SELECT SUM(Market_Value) AS TotalMarketValue";
						$query_t .= " FROM holding ";
						$query_t .= " WHERE Category = 'Endowment'";
						$query_t .= " AND Asset_Class = 'Global Equity'";
						$query_t .= " AND Year ='2016'";
						$report_t = mysqli_query($connection, $query_t);
						// Test if there was a query error
						if (!$report_t) {die("Database query failed.");};
						while($result = mysqli_fetch_assoc($report_t)){ $T_GE = $result['TotalMarketValue'];}
				echo $T_GE."<br>";


						//calculate total equity
	$query_t  = " SELECT SUM(Market_Value) AS TotalMarketValue";
			$query_t .= " FROM holding ";
			$query_t .= " WHERE Category = 'Endowment'";
			$query_t .= " AND (Asset_Class = 'Global Equity' OR Asset_Class='Canadian Equity')";
			$query_t .= " AND Year ='2016'";
			$report_t = mysqli_query($connection, $query_t);
			// Test if there was a query error
			if (!$report_t) {die("Database query failed.");};
			while($result = mysqli_fetch_assoc($report_t)){ $T_TE = $result['TotalMarketValue'];}					
								
				echo $T_TE."<br>";				
	
								


// 2. Perform database query
		
		
		$query  = "SELECT Managers, MV_D_CE, MV_P_CE,MV_D_GE,MV_P_GE,MV_D_TE,MV_P_TE FROM";
		$query .= " (SELECT DISTINCT(Manager) as Managers FROM holding) AS N";
		$query .= " LEFT JOIN";
		$query .= " (SELECT Manager, SUM(Market_Value) as MV_D_CE, SUM(Market_Value)/$T_CE as MV_P_CE FROM holding WHERE Category='Endowment' AND Asset_Class ='Canadian Equity' AND Year = '2016' GROUP BY Manager) as CE";
		$query .= " ON N.Managers = CE. Manager";
		$query .= " LEFT JOIN";
		
		
		$query .= " (SELECT Manager,SUM(Market_Value) as MV_D_GE, SUM(Market_Value)/$T_GE as MV_P_GE FROM holding WHERE Category='Endowment' AND Asset_Class ='Global Equity' AND Year = '2016' GROUP BY Manager) AS GE";
		$query .= " ON N.Managers = GE. Manager";
		$query .= " LEFT JOIN";
		$query .= " (SELECT Manager,SUM(Market_Value) as MV_D_TE, SUM(Market_Value)/$T_TE as MV_P_TE FROM holding WHERE Category='Endowment' AND (Asset_Class='Canadian Equity' or Asset_Class='Global Equity') AND Year = '2016' GROUP BY Manager) AS TE";
		$query .= " ON N.Managers = TE. Manager";
		
		$report = mysqli_query($connection, $query);
		// Test if there was a query error
		echo ($query);
		echo "hello world";
		if (!$report) {die("Database query failed.");}
		echo ($query);
	?>
	
				<table id="table" class="TF" >
				  <tr id="tableheader">

					<th>Manager</th>
					<th>MV_D_CE</th>
					<th>MV_P_CE</th>
					<th>MV_D_GE</th>
					<th>MV_P_GE</th>
					<th>MV_D_TE</th>
					<th>MV_P_TE</th>
					

				  </tr>
				<?php
					// 3. Use returned data (if any)
					while($row = mysqli_fetch_assoc($report)) {
				?>
				  <tr>
					<td><?php echo $row['Managers']; ?></td>
					<td><?php echo $row['MV_D_CE']; ?></td>
					<td><?php
					$formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT);
					echo $formatter->format($row['MV_P_CE']);?></td>
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
				</table>
				<?php
				  // 4. Release returned data
				  mysqli_free_result($report);
				?>

</body>
</html>