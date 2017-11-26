<html>
	<head></head>
		<style type="text/css">
.left_margin{
width : 15%;
height: 100%;
background-color: rgb(120, 27, 27);
float:left;
}
.right_margin{
width : 15%;
height: 100%;
background-color: rgb(120, 27, 27);
float:right;
}
.middle_margin{
width : 70%;
height: 100%;
background-color: white;
margin-left:15%;
}
.banner{
width : 100%;
height: 20%;
background-color: white;
float:top;
}

.content{
width : 100%;
height: 45%;
background-color: white ;
position: relative;
}

.footer{
width : 100%;
height: 35%;
background-color: white;
}	

.login{
background-color: rgba(215, 215, 212, 0.44);
width:40%;
height:100%;
margin-left:30%;
position: relative;
}

.login_left{
background-color: rgba(215, 215, 212, 0.44);
width:30%;
height:100%;
float: left;
}

.login_right{
background-color: rgba(215, 215, 212, 0.44);
width:30%;
height:100%;
float:right;
}
#btn{background-color:rgba(156, 1, 1, 0.85);color: white; width:80px; height:30px;}
#username{background-color: rgba(232, 241, 48, 0.44);width:90%;height:30px;}
#password{background-color: rgba(232, 241, 48, 0.44);width:90%;height:30px;}
		</style>
			<body>
				<div class="left_margin"></div>
				<div class="right_margin"></div>
				<div class="middle_margin">
						<div class="banner">
							<img src="image/sfulogo.png" ></a>
							<h2 id="database">SFU Treasury Database</h2>
							<img src="image/divider.png" height=30px width= 100%>
						</div>
						<div class="content">
							<div class="login_left"></div>
							<div class="login_right"></div>
							<div class="login">
							<p></p></br> 
							<h3>Sign In</h3>
							<p>Read the complete SFU Treasury Database Privacy Protection Notice. By using SFU Treasury Database you confirm that you have read, understand and agree to this notice.</p>
							<form action="process.php" method="post">
								<p>
									<label>Username:</label></br>
									<input type="text" id="username" name="username"/></br>
								</p>
								<p>
									<label>Password:</label></br>
									<input type="text" id="password" name="password"/></br>
								</p>
								<p>Warn me before logging me into other sites.</p>
								<p>
									<input type="submit" id="btn" value="Sign In"/>
								</p>
							</form>
							</div>
						</div>
						<div class="footer">
						<p>Forget your password or computing ID?</p>
						<p>Change your password</p>
						<p>Need help?</p>
						<h4>PROTECT YOUR PASSWORD</h4>
						<p> SFU Treasury Database will never request our users provide or confirm their Username or password via email or by going to any web site. SFU Treasury Database users should ignore all messages requesting Username and/or password information, no matter how authentic they may appear. More information on phishing.</p>
						<p>If you're not sure, do not enter your password</p>
						</div>
				</div>
			</body>
</html>