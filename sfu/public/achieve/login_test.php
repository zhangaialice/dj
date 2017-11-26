<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html lang="en">
<head>


<style>
#frm{
	border: solid grey 1px;
	width:40%;
	border-radius:5px;
	margin:200px auto;
	background:white;
	position: relative;
}

#btn{
	color:#fff;
	background:#337ab7;
	padding:10px;
	position: absolute;
}

.margin_left{
width : 15%;
height: 100%;
float: left;
background-color: red;
}

.margin_right{
width : 15%;
height: 100%;
right:0px;
background-color: red;
}

.margin_middle{
width : auto;
height: 100%;
background-color: white;
}



.header{
width : 100%;
height: 30%;
background-color: white;
}
.middle{
background-color : white;
height : 90%;
width : 100%;
}

.footer{
background-color : white;
position:relative;
bottom:350px;
height: 10%;
width : 100%;
}


</style>
</head>
<body>
	<div class="margin_left"></div>
	<div class="margin_right"></div>
	<div class="margin_middle">
	<div class="header">
		<img src="image/sfulogo.png" ></a>
		<h2 id="database">SFU Treasury Database</h2>
		<img src="image/divider.png" height="30" width="1600">
	</div>

	<div class="middle">
		<div id="frm">
			<form action="process.php" method="post">
				<p>
					<label>Username:</label>
					<input type="text" id="username" name="username"/>
				</p>
				<p>
					<label>Password:</label>
					<input type="text" id="password" name="password"/>
				</p>
				<p>
					<input type="submit" id="btn" value="Login"/>
				</p>
			</form>
		</div>
	</div>


	<div class="footer">
	<img src="image/divider.png" height="30" width="1600">
	</div>
	</div>
</body>
</html>