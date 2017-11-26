<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="blended_layout.css">
<title>Page Title</title>
<meta name="description" content="Write some words to describe your html page">
<style type="text/css">

*{
padding : 0;
margin : 0;
border : 0;
}
body{
background-image : url(' bi-background-frame.png ');
background-attachment : fixed;
background-size : 100% auto;
}
.blended_grid{
display : block;
width : 100%;
height:100%;
overflow : auto;
margin : 0px auto 0 auto;
}
.pageHeader{
background-color : rgba(255, 99, 132, 0.2);
float : left;
clear : none;
height : 200px;
width : 100%;
}
.pageLeftMenu{
background-color : rgba(54, 162, 235, 0.2);

float : left;
clear : none;
height : 600px;
width : 300px;
}
.pageContentPanel{
background-color : grey;
float : left;
clear : none;
height : 70px;
width : 1000px;

}
.pageContent{
background-color : rgba(255, 206, 86, 0.2);
float : left;
clear : none;
height : 530px;
width : 1200px;
}
.pageFooter{
background-color : blue;
float : left;
clear : none;
height : 100px;
width : 1515px;
}

input
{
  font-family: verdana;
  font-size: 11px;
  border: solid 1px #999999;
  padding: 2px;
}
label
{
  font-family: verdana;
  font-size: 15px; 
}
select
{
  font-family: Verdana;
  padding: 2px 2px 2px 2px;
  width:100px;
  font-size: 15px;
  border: solid 1px #999999;
}



* {padding:0;margin:0;}
body{font-family:sans-serif;}
a{text-decoration: none;}
li{list-style-type: none;}
nav{width:100%; text-align: center;}
nav a {
display:block ;
padding:15px 0;
border-bottom: 5px solid white;
color: white;
}
nav a:hover{background: #808080; color: yellow;}
nav li:last-child a{border-bottom:none;}
.menu{
	width:240px;
	height:100%
	position:absolute;
	background:#a6a6a6;}
h3 {margin: 10px 10px 10px 70px; font-size: 30}
h2 {margin: 10px 10px;font-size: 45}

</style>

<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>

</head>
<body>
<div class="blended_grid">
	<div class="pageHeader">
		<img src="image/sfulogo.png" ></a>
		<h2>SFU Treasury Database</h2>
		<img src="image/divider.png" height="30" width="1600">
	</div>
	

	<div class="pageLeftMenu">
		<h3 id="menu">Menu</h3>
		<hr align ="left" width=240px size="10" noshade/>

		<nav class="menu">
		<ul>
			<li><a href="#">Profit and Loss</a></li>
			<li><a href="#">Holdings</a></li>
			<li><a href="#">Fossil Fuel</a></li>
			<li><a href="#">Report Management</a></li>
			<li><a href="#">Admin</a></li>
		</ul>
		</nav>
	</div>
	

	<div class="pageContentPanel">
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

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">


<!-- choose year first -->
<html lang="en">
	<head>
		<title>Form</title>
	</head>
	<body>
		
		<form action="frame.php" method="post" id="selectYear">
			<label for="Year">Year</label>
				<select id="Year1" name='Year' <!--onchange="this.form.submit()"-->>
					<option>-select-</option>
					<option>holdings_2014</option>
					<option>holdings_2015</option>
					<option>holdings_2016</option>
				</select>
		 <input type="submit" name="submit_y" value="Submit" /><br />
		</form>

<!-- based on the year, generate select box for manager, asset class and category -->
		<form action="frame.php" method="post">

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
	<div class="pageContent">
	
		


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
		
		<table>
		  <tr>
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
	</body>

	</div>
	<div class="pageFooter">
	</div>
</div>

<!--<script>
	$("#Year1").change(function () {
		$("#selectYear").submit();
	});
</script>-->
</body>
</html>


