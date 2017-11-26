<!DOCTYPE html>
<html>
<head>
<style>
.divider{
    position: fixed;
    top: 70px;
    right: 0;
  width:100%; /* Optional */
}

.left {
  float:left;
  width:400px;
}

.middle {
  float:left;
  min-width:600px;
}

.right {
  float:left;
  width:150px;
}

ul.levelone {
    list-style-type: none;
	float: right;
    margin: 20px;
    padding: 0;
    overflow: hidden;
    background-color: white;
}

ul.leveltwo {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #312F2F;
}

ul.levelthree {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #AFA5A5;
}



li.levelone {
    float: left;
	padding-left: 50px;
}

li a {
    display: block;
    color: black;
    text-align: center;
    padding: 16px;
    text-decoration: none;
}

li li a {
    display: block;
    color: white;
    text-align: center;
    padding: 16px;
    text-decoration: none;
}
	

li a:hover {
    background-color: #312F2F;
	color: white;
}


li li a:hover {
    background-color: #BF3F3F;
	color: white;
}


.test{float: right;
width:80%;}
</style>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	
	
<script>
	
		$(function () {
		$('nav li ul').hide().removeClass('fallback');
		$('nav li').click(function () {
			$('ul', this).slideDown("slow");
			$('nav li li ul').hide();
			$('nav li li.fossilfuel').hover(function(){$('nav li li.fossilfuel ul').slideToggle(400);});
		});
	});

</script>	

</head>
<body>

<div class="left" style="height:60px;background:white">
	<img src="image/sfulogo.png"  height="60" width="300">
	
</div>

<div class="middle" >
	<nav class="menu">
		<ul class="levelone">
			<li class="levelone"><a href="holding.php">Holding</a></li>
			<li class="levelone"><a>ESG</a>
				<ul class="leveltwo" id="test">
					<li class="fossilfuel"><a href="fossil_fuel.php">Fossil Fuel</a>
							<ul class="levelthree" id="test1">
								<li><a href="fossil_manager_chart.php">Manager</a></li>
								<li><a href="fossil_assetclass.php">Asset Class</a></li>
								<li><a href="fossil_category.php">Category</a></li>
							</ul>
					</li>
					<li class="military">
						<a href="military_manager.php",class="military">Military</a>

					</li>
					<li class="tobacco">
						<a href="tobacco_manager.php">Tobacco</a>

					</li>
				</ul>
			</li>
			<li class="levelone"><a href="#">Report Management</a>
					<ul class="leveltwo" id="test">
						<li><a href="#">TBD</a></li>
					</ul>
			</li>
			<li class="levelone"><a href="#">Admin</a>
					<ul class="leveltwo" id="test">
						<li><a href="#">TBD</a></li>
					</ul>
			</li>
		</ul>
	</nav>				
</div>
<div class="right"></div>
<img  class="divider" src="image/divider.png" height="20" width="1600" position="fixed">

</body>
</html>
