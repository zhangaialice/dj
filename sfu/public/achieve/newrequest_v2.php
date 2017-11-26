<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html lang="en">
<head>

<link rel="stylesheet" type="text/css" href="http://tablefilter.free.fr/TableFilter/filtergrid.css">
</head>

<body>


<?php include("../includes/sql_connect.php");?>



<?php

$arr = [
["Endowment","Canadian Equity"],["Non-Endowment","Canadian Equity"],["Endowment","Global Equity"],["Non-Endowment","Global Equity"]];

foreach($arr as $value)

{
					$query_t  = " SELECT SUM(Market_Value) AS TotalMarketValue";
								$query_t .= " FROM holding ";
								$query_t .= " WHERE Category ='" .$value[0]."'";
								$query_t .= " AND Asset_Class ='" .$value[1]."'";
								$query_t .= " AND Year ='2016'";
								$report_t = mysqli_query($connection, $query_t);
								// Test if there was a query error
								if (!$report_t) {die("Database query failed.");};
								while($result = mysqli_fetch_assoc($report_t)){ $totalnumber = $result['TotalMarketValue'];}
// 2. Perform database query
		$query  = "SELECT Managers, MarketValue FROM ";
		$query .= " (SELECT Manager,SUM(Market_Value)/$totalnumber as MarketValue FROM holding WHERE Category='" .$value[0]."' AND ";
		$query .= " Asset_Class ='". $value[1]."' AND Year = '2016' GROUP BY Manager) as P ";
		$query .= " RIGHT JOIN";
		$query .= " (SELECT DISTINCT(Manager) as Managers FROM holding) as A";
		$query .= " ON A.Managers = P. Manager";
		$report = mysqli_query($connection, $query);
		// Test if there was a query error
		echo ($query);
		echo "hello world";
		if (!$report) {die("Database query failed.");}
		echo ($query);
		echo "hello world";
	?>
	
				<table id="table" class="TF" >
				  <tr id="tableheader">

					<th>Manager</th>
					<th>Market Value (%)</th>
					

				  </tr>
				<?php
					// 3. Use returned data (if any)
					while($row = mysqli_fetch_assoc($report)) {
				?>
				  <tr>
					<td><?php echo $row['Managers']; ?></td>
					<td><?php
					$formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT);
					echo $formatter->format($row['MarketValue']);?></td>
				  </tr>
				<?php
				}
				?>
				</table>
<?php } ?>
				<?php
				  // 4. Release returned data
				  mysqli_free_result($report);
				?>

</body>
</html>