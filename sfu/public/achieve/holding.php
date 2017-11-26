<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html lang="en">
<head>
<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
<script src="Chart.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="../includes/navigation.js"></script>
<link rel="stylesheet" type="text/css" href="../includes/main.css">
</head>

<body>
	<?php include("../includes/navigation.php");?>
		<div class="content">

			<div class="selectbar">
<!-- php code-->
					<?php include("../includes/sql_connect.php");?>
					<?php

						if (isset($_POST['submit_y'])) {
							// form was submitted
							$Year= $_POST["Year"];

						} else {
							$Year = "";
							$message1 = "Please select year.";
						}
					?>


					<?php
						require_once("../includes/included_functions.php");

						
						
						if (isset($_POST['submit'])) {
							// form was submitted
							$Year = $_POST["Year"];
							$Manager = $_POST["Manager"];
							$AssetClass = $_POST["AssetClass"];
							$Category = $_POST["Category"];

						} else {
							$Manager = "";
							$AssetClass = "";
							$Category = "";
							$message = "Please select.";
						}
					?>
<!-- first selection bar-->
				<form action="holding.php" method="post" id="selectYear">
				<label for="Year">Year</label>
				<select id="Year1" name='Year' <!--onchange="this.form.submit()"-->>
					<option>-select-</option>
					<option>holdings_2014</option>
					<option>holdings_2015</option>
					<option>holdings_2016</option>
				</select>
				<input type="submit" name="submit_y" value="Submit" /><br />
				</form>
				
				<form action="holding.php" method="post">
<!-- second selection bar-->
				<label for="Year">Year</label>
				<select id="Year" name='Year'>
						<option>-select-</option>
						<option>holdings_2014</option>
						<option>holdings_2015</option>
						<option>holdings_2016</option>
				</select>
		

				<?php
					// 2. Perform database query
					$query  = "SELECT DISTINCT Manager ";
					$query .= "FROM $Year ";
					//$query .= "WHERE Manager='BEAM' ";
					$result = mysqli_query($connection, $query);
					// Test if there was a query error
					//if (!$result) {die("Database query failed.");}
				?>
				<label for="Manager">Manager</label>
				<select id="Manager" name='Manager'>
				<option>-select-</option>
				
				<?php
					// 3. Use returned data (if any)
					while($row = mysqli_fetch_assoc($result)) {
				?>
					<option><?php echo $row['Manager']; ?></option>

					<?php
					}
					?>
					</select>

			<!--select box for asset class -->

				<?php
					// 2. Perform database query
					$query  = "SELECT DISTINCT Security_Type ";
					$query .= "FROM $Year ";
					//$query .= "WHERE Manager='BEAM' ";
					$result = mysqli_query($connection, $query);
					// Test if there was a query error
					//if (!$result) {die("Database query failed.");}
				?>
				<label for="AssetClass">Asset Class</label>
				<select id="AssetClass" name='AssetClass'>
					<option>-select-</option>
				<?php
					// 3. Use returned data (if any)
					while($row = mysqli_fetch_assoc($result)) {
				?>
					<option><?php echo $row['Security_Type']; ?></option>

				<?php
				}
				?>
				</select>

			<!--select box for Category -->	

				<?php
					// 2. Perform database query
					$query  = "SELECT DISTINCT Category ";
					$query .= "FROM $Year ";
					$result = mysqli_query($connection, $query);
					//if (!$result) {die("Database query failed.");}
				?>
				<label for="Category">Category</label>
				<select id="Category" name='Category'>
					<option>-select-</option>
				
				<?php
					// 3. Use returned data (if any)
					while($row = mysqli_fetch_assoc($result)) {
				?>
					<option><?php echo $row['Category']; ?></option>

				<?php
				}
				?>
				</select>
				<input type="submit" name="submit" value="Submit" />
				</form>
			</div>
			<div class="sresult">
				<!-- based on the select generate report -->
				<?php
		// 2. Perform database query
					$query  = "SELECT * ";
					$query .= "FROM $Year ";
					$query .= "WHERE Manager ='". $Manager. "'";
					$query .= "AND Category ='". $Category. "'";
					$query .= "AND Security_Type ='". $AssetClass. "'";
					$report = mysqli_query($connection, $query);
					// Test if there was a query error
					if (!$report) {die("Database query failed.");}
				?>
				
				<table id="table">
				  <tr id="tableheader">
					<th>Name</th>
					<th>Security Type</th>
					<th>Sector</th>
					<th>Manager</th>
					<th>Category</th>
					<th>Market Value</th>
					<th>ISIN</th>
				  </tr>
				<?php
					// 3. Use returned data (if any)
					while($row = mysqli_fetch_assoc($report)) {
				?>
				  <tr>
					<td><?php echo $row['Name']; ?></td>
					<td><?php echo $row['Security_Type']; ?></td>
					<td><?php echo $row['Sector']; ?></td>
					<td><?php echo $row['Manager']; ?></td>
					<td><?php echo $row['Category']; ?></td>
					<td><?php echo $row['Market_Value']; ?></td>
					<td><?php echo $row['ISIN']."<br />"; ?></td>
				  </tr>
				<?php
				}
				?>
				</table>
				<?php
				  // 4. Release returned data
				  mysqli_free_result($report);
				?>
             
	        </div>
		</div>
	</div>
	<div class="footer">
	<img src="image/divider.png" height="30" width="1600">
	</div>
</body>
</html>