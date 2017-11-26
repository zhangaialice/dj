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


				<!-- based on the select generate report -->
				<?php
						require_once("../includes/included_functions.php");

						
						
						if (isset($_POST['submit'])) {
							// form was submitted
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
				
				
				
				
				<form action="holdingv2.php" method="post">	
				
<!-- loop get list of Security Type-->	


				<?php
					// 2. Perform database query
					$query  = "SELECT DISTINCT Security_Type ";
					$query .= "FROM holdings_2014 ";
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
<!-- loop get list of Currency-->					
				<?php
					// 2. Perform database query
					$query  = "SELECT DISTINCT Currency ";
					$query .= "FROM holdings_2014 ";
					$result = mysqli_query($connection, $query);
				?>
				<label for="Currency">Currency</label>
				<select id="Currency" name='Currency'>
				<option>-select-</option>
				
				<?php
					// 3. Use returned data (if any)
					while($row = mysqli_fetch_assoc($result)) {
				?>
					<option><?php echo $row['Currency']; ?></option>

					<?php
					}
					?>
					</select>
<!-- loop get list of Sector-->				
				<?php
					// 2. Perform database query
					$query  = "SELECT DISTINCT Sector ";
					$query .= "FROM holdings_2014 ";
					$result = mysqli_query($connection, $query);
				?>
				<label for="Sector">Sector</label>
				<select id="Sector" name='Sector'>
				<option>-select-</option>
				
				<?php
					// 3. Use returned data (if any)
					while($row = mysqli_fetch_assoc($result)) {
				?>
					<option><?php echo $row['Sector']; ?></option>

					<?php
					}
					?>
					</select>
<!-- loop get list of Sub-Sector-->				
				<?php
					// 2. Perform database query
					$query  = "SELECT DISTINCT Sub_Sector ";
					$query .= "FROM holdings_2014 ";
					$result = mysqli_query($connection, $query);
				?>
				<label for="Sub_Sector">Sub-Sector</label>
				<select id="Sub_Sector" name='Sub_Sector'>
				<option>-select-</option>
				
				<?php
					// 3. Use returned data (if any)
					while($row = mysqli_fetch_assoc($result)) {
				?>
					<option><?php echo $row['Sub_Sector']; ?></option>

					<?php
					}
					?>
					</select>
<!-- loop get list of Industry-->				
				<?php
					// 2. Perform database query
					$query  = "SELECT DISTINCT Industry ";
					$query .= "FROM holdings_2014 ";
					$result = mysqli_query($connection, $query);
				?>
				<label for="Industry">Industry</label>
				<select id="Industry" name='Industry'>
				<option>-select-</option>
				
				<?php
					// 3. Use returned data (if any)
					while($row = mysqli_fetch_assoc($result)) {
				?>
					<option><?php echo $row['Industry']; ?></option>

					<?php
					}
					?>
					</select>
<!-- loop get list of Sub_Industry-->				
				<?php
					// 2. Perform database query
					$query  = "SELECT DISTINCT Sub_Industry ";
					$query .= "FROM holdings_2014 ";
					$result = mysqli_query($connection, $query);
				?>
				<label for="Sub_Industry">Sub-Industry</label>
				<select id="Sub_Industry" name='Sub_Industry'>
				<option>-select-</option>
				
				<?php
					// 3. Use returned data (if any)
					while($row = mysqli_fetch_assoc($result)) {
				?>
					<option><?php echo $row['Sub_Industry']; ?></option>

					<?php
					}
					?>
					</select>
<!-- loop get list of Manager-->				
				<?php
					// 2. Perform database query
					$query  = "SELECT DISTINCT Manager ";
					$query .= "FROM holdings_2014 ";
					$result = mysqli_query($connection, $query);
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



			<!--select box for Category -->	

				<?php
					// 2. Perform database query
					$query  = "SELECT DISTINCT Category ";
					$query .= "FROM holdings_2014 ";
					$result = mysqli_query($connection, $query);
					//if (!$result) {die("Database query failed.");}
				?>
				<label for="Category">Category</label>
				<select id="Category" name='Category'>
					<option>-select-</option>
					<option>All</option>
				
				<?php
					// 3. Use returned data (if any)
					while($row = mysqli_fetch_assoc($result)) {
				?>
					<option><?php echo $row['Category']; ?></option>

				<?php
				}
				?>
				</select>
				
				Market Value Range: <input type="number" name="mini" id="mini"> - <input type="number" name="maxi" id="maxi">
				
				<input type="submit" name="submit" value="Submit" />
				</form>
			</div>
			<div class="sresult">
			
			<?php 
			//define variable at the begining and then pass the input box value into the variable
			$mini = "";
			$maxi = "";
			

			if ( isset($_POST['submit'])){
						$mini = $_POST['mini'];} 
 
			if ( isset($_POST['submit'])){
						$maxi = $_POST['maxi'];} 


		//2. Perform database query
					$query  = "SELECT * ";
					$query .= "FROM test1 ";
					if($Category ="All") {$query .= "WHERE Category IS NOT NULL ";} else{$query .= "WHERE Category ='". $Category. "'";};
					//$query .= "WHERE Category = 'Endowment'";
					//$query .= "WHERE Manager ='". $Manager. "'";
					//$query .= "WHERE Category ='". $Category. "'";
					//$query .= "AND Security_Type ='". $AssetClass. "'";
					//$query .= "AND Market_Value > '". $mini. "'";
					//$query .= "AND Market_Value < '". $maxi. "'";
					//$query .= "WHERE Category IS NOT NULL";
					$report = mysqli_query($connection, $query);
					// Test if there was a query error
					if (!$report) {die("Database query failed.");}
				?>
				
				<table id="table">
				  <tr id="tableheader">
					<th>Name</th>
					<th>Security Type</th>
					<th>Currency</th>
					<th>Sector</th>
					<th>Sub-Sector</th>
					<th>Industry</th>
					<th>Sub-Industry</th>
					<th>Manager</th>
					<th>Category</th>
					<th>Market Value</th>
				  </tr>
				<?php
					// 3. Use returned data (if any)
					while($row = mysqli_fetch_assoc($report)) {
				?>
				  <tr>
					<td><?php echo $row['Name']; ?></td>
					<td><?php echo $row['Security_Type']; ?></td>
					<td><?php echo $row['Currency']; ?></td>
					<td><?php echo $row['Sector']; ?></td>
					<td><?php echo $row['Sub_Industry']; ?></td>
					<td><?php echo $row['Industry_Sector']; ?></td>
					<td><?php echo $row['Industry_Group']; ?></td>
					<td><?php echo $row['Manager']; ?></td>
					<td><?php echo $row['Category']; ?></td>
					<td><?php echo $row['Market_Value']; ?></td>
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