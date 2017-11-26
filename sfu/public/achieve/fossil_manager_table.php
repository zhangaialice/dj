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
			<a href="fossil_manager_chart.php" id="table_button">Convert to Chart</a>


			<div class="top_section">
			<label for = "idOfCanvas" id="tabletitle">Fossil Fuel Exposure Percentage - By Manager</label>

			<table id="table">
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
					<td><?php echo $row['Percentage_2014']; ?></td>
					<td><?php echo $row['Percentage_2015']; ?></td>
					<td><?php echo $row['Percentage_2016']; ?></td>
				  </tr>
				<?php
				}
				?>
			</table>
			<label for = "idOfCanvas" id="tabletitle">Fossil Fuel Number of Holdings - By Manager</label>
			<table id="table">
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
					<td><?php echo $row['Manager']; ?></td>
					<td><?php echo $row['Number_2014']; ?></td>
					<td><?php echo $row['Number_2015']; ?></td>
					<td><?php echo $row['Number_2016']; ?></td>
				  </tr>
				<?php
				}
				?>
			</table>
             
	        </div>
		</div>
	</div>
	<div class="footer">
	<img src="image/divider.png" height="30" width="1600">
	</div>
</body>
</html>