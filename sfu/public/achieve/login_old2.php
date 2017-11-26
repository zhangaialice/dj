<?php
	require_once("../includes/included_functions.php");
	
	if (isset($_POST['submit'])) {
		// form was submitted
		$username = $_POST["username"];
		$password = $_POST["password"];

		if ($username == "root" && $password == "ai") {
			// successful login
			redirect_to("main_page.php");
		} else {
			$message = "There were some errors.";
		}
	} else {
		$username = "";
		$message = "Please log in.";
	}
?>


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


.login
{background-color : white;
position:relative;
left:40%;
top:15%;
height: 50%;
width : 30%;
}



.footer{
background-color : white;
position:relative;
bottom:30px;
height: 10%;
width : 100%;
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


</style>
</head>
<body>
	<div class="header">
		<img src="image/sfulogo.png" ></a>
		<h2 id="database">SFU Treasury Database</h2>
		<img src="image/divider.png" height="30" width="1600">
	</div>

	<div class="login">
	<?php echo $message; ?><br />
		
		<form action="main_page.php" method="post">
		  Username: <input id="username" type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" /><br />
		  Password: <input id="password" type="password" name="password" value="" /><br />
			<br />
		  <input type="submit" name="submit" value="Submit" />
		</form>
	</div>

	<div class="footer">
	<img src="image/divider.png" height="30" width="1600">
	</div>
</body>
</html>