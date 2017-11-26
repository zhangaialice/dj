<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html lang="en">
<head>

<link rel="stylesheet" type="text/css" href="http://tablefilter.free.fr/TableFilter/filtergrid.css">
</head>

<body>

<?php
$f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
echo $f->format(123456);

?>

<?php include("../includes/sql_connect.php");?>

<?php
		// 2. Perform database query
					$query_t  = " SELECT SUM(Market_Value) AS TotalMarketValue";
					$query_t .= " FROM holding ";
					$query_t .= " WHERE Category ='Endowment'";
					$query_t .= " AND Security_Type ='Canadian Equity'";
					$query_t .= " AND Year ='2016'";
					$report_t = mysqli_query($connection, $query_t);
					// Test if there was a query error
					echo ($query_t); 
					if (!$report_t) {die("Database query failed.");};
					while($result = mysqli_fetch_assoc($report_t)){ $totalnumber = $result['TotalMarketValue'];} ?>


<?php
		// 2. Perform database query
					$query  = "SELECT Manager , SUM(Market_Value)/$totalnumber AS Calculated";
					$query .= " FROM holding ";
					$query .= " WHERE Category ='Endowment'";
					$query .= " AND Security_Type ='Canadian Equity'";
					$query .= " AND Year ='2016'";
					$query .= " GROUP BY Manager";
					$report = mysqli_query($connection, $query);
					// Test if there was a query error
					echo ($query);
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
					<td><?php echo $row['Manager']; ?></td>
					<!--<td><?php echo $row['Calculated']; ?></td>-->
					<td><?php
					$formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT);
					echo $formatter->format($row['Calculated']);?></td>
			
					
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