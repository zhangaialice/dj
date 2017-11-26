<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html lang="en">
<head>
<style type="text/css">
<!--div-->
.header{
width : 100%;
height: 30%;
background-color: rgba(54, 162, 235, 0.2);
}
.middle{
background-color : rgba(255, 99, 132, 0.2);
height : 90%;
width : 100%;
}

.footer{
background-color : white;
height: 10%;
width : 100%;
}

.leftpanel{
background-color : white;
left:0px;
float: left;
height: 100%;
width : 17%;
}
.content{
background-color : white;
overflow:auto;
height:100%
}

.selectbar{
background-color : rgba(255, 99, 132, 0.2);
top:0px;
height:14%;
width:100%;
}

.sresult{
background-color :white	 ;
overflow:auto;
width:100%;
}

input
{
  font-family: sans-serif;
  font-size: 15px;
  border: solid 1px #999999;
  padding: 2px;
  margin-left:30px;
}
label
{
  font-family: sans-serif;
  margin-left:20px;
  font-size: 15px; 
}
select
{
  font-family: sans-serif;
  margin-left:10px;
  margin-top:10px;
  padding: 2px 2px 2px 2px;
  width:100px;
  font-size: 15px;
  border: solid 1px #999999;
}


* {padding:0;margin:0;}

body{font-family:sans-serif;}

a{text-decoration: none;}
li{list-style-type: none;}
nav{width:100%; text-align: center; position: relative; top:5px;}
nav a {display:block ; padding:15px 0; border-bottom: 4px solid white; color: white;}
nav a:hover{background: #808080; color: yellow;}
nav li:last-child a{border-bottom:none;}

.menu{
	width:240px;
	height:100%
	position:absolute;
	background:#a6a6a6;}
h3 {position: relative; left:35%; font-size: 22}
#database {margin: 10px 10px;font-size: 35}


#table {
		display: table;
	 	
	 	width: 100%; 
	 	background: #fff;
	 	margin: 0;
		font-size: 15px;
	 	box-sizing: border-box;
		border:1px solid black;

	 }
#tableheader {
	 	background: #8b8b8b;
	 	color: #fff;}
/* three chart for fossil fuel report*/
#top_by_manager 
{
background-color : white;
height : 50%;
width : 100%;
}

/*#bot
{
background-color : yellow;
width: 100%;
height : 100%;
}*/


#by_class
{
background-color : red;
height : 30%;
width : 100%;
}

#by_category
{
background-color : blue;
height : 30%;
width : 100%;
}
canvas{

  width:100% !important;
  height:70% !important;

}


</style>

<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
<script src="Chart.js"></script>

</head>
<body>
	<div class="header">
		<img src="image/sfulogo.png" ></a>
		<h2 id="database">SFU Treasury Database</h2>
		<img src="image/divider.png" height="30" width="1600">
	</div>

	<div class="middle">
		<div class="leftpanel">
			<h3 id="menu">Menu</h3>
			<hr align ="left" width=238px size="8" noshade />

			<nav class="menu">
			<ul>
				<li><a href="#">Profit and Loss</a></li>
				<li><a href="holding.php">Holdings</a></li>
				<li><a href="#">Fossil Fuel</a></li>
				<li><a href="#">Report Management</a></li>
				<li><a href="#">Admin</a></li>
			</ul>
			</nav>
		</div>
		<div class="content">
			<div id="top_by_manager"></div>
				<canvas id="myChart" width="5" height="5"></canvas>
			<?php include("../includes/sql_connect.php");?>
				<?php
					// 2. Perform database query
					$query  = "SELECT DISTINCT Security_Type ";
					$query .= "FROM f_class_2014 ";
					$result = mysqli_query($connection, $query);
					$datas=array();
					// Test if there was a query error
					if (mysqli_num_rows($result)>0) {
					while($row = mysqli_fetch_assoc($result)) {
					$datasa[]=$row['Security_Type'];
					}}
				//print_r($datas);
				//foreach ($datas as $data){ echo $data['Security_Type'];}
				//foreach($datas as $data){ echo $data['text'];}
				$a=json_encode($datasa);
				
				?>

				<?php
					// 2. Perform database query
					$query  = "SELECT Security_Type, Percentage ";
					$query .= "FROM f_class_2014 ";
					$result = mysqli_query($connection, $query);
					$datas=array();
					// Test if there was a query error
					if (mysqli_num_rows($result)>0) {
					while($row = mysqli_fetch_assoc($result)) {
					
					$datas[]=$row['Percentage'];
					}}
				//print_r($datas);
				//foreach ($datas as $data){ echo $data['Security_Type'];}
				//foreach($datas as $data){ echo $data['text'];}
				
				$b = json_encode($datas);
			    $c=str_replace(array("'", "\"", "&quot;"),"",$b);
				//print b

				?>

				<script>
				var ctx = document.getElementById("myChart");
				var ctx = document.getElementById("myChart").getContext("2d");

				var ctx = $("#myChart");
				var ctx = "myChart";

				var ctx = document.getElementById("myChart");
				var myChart = new Chart(ctx, {
					type: 'bar',
					data: {
						labels: <?php print json_encode($datasa);?>,
						datasets: [{
							label: '# of Votes',
							data: <?php print str_replace(array("'", "\"", "&quot;"),"",json_encode($datas));?>,
							backgroundColor: [
								'rgba(255, 99, 132, 0.2)',
								'rgba(54, 162, 235, 0.2)',
								'rgba(255, 206, 86, 0.2)',
								'rgba(75, 192, 192, 0.2)',
								'rgba(153, 102, 255, 0.2)',
								'rgba(255, 159, 64, 0.2)'
							],
							borderColor: [
								'rgba(255,99,132,1)',
								'rgba(54, 162, 235, 1)',
								'rgba(255, 206, 86, 1)',
								'rgba(75, 192, 192, 1)',
								'rgba(153, 102, 255, 1)',
								'rgba(255, 159, 64, 1)'
							],
							borderWidth: 1
						},
				{
							label: '# of Votes',
							data: [30, 40, 5, 8],
							backgroundColor: [
								'rgba(255, 99, 132, 0.2)',
								'rgba(54, 162, 235, 0.2)',
								'rgba(255, 206, 86, 0.2)',
								'rgba(75, 192, 192, 0.2)',
								'rgba(153, 102, 255, 0.2)',
								'rgba(255, 159, 64, 0.2)'
							],
							borderColor: [
								'rgba(255,99,132,1)',
								'rgba(54, 162, 235, 1)',
								'rgba(255, 206, 86, 1)',
								'rgba(75, 192, 192, 1)',
								'rgba(153, 102, 255, 1)',
								'rgba(255, 159, 64, 1)'
							],
							borderWidth: 1
						}

				]
					},
					options: {
						responsive: true,
						maintainAspectRatio: false,							
						scales: {
							yAxes: [{
								ticks: {
									beginAtZero:true
								}
							}]
						}
					}
				});
				</script>
			
			
			<div id="by_class"></div>
			<div id="by_category"></div>

		</div>
	</div>
	

	<div class="footer">
	<img src="image/divider.png" height="30" width="1600">
	</div>
</body>
</html>