
<?php include("../includes/sql_connect.php");?>

<?php
	 
		require_once("../includes/included_functions.php");
		// form was submitted
		$username = $_POST["username"];
		$password = $_POST["password"];
		
		$userbame=stripcslashes($username);
		$password=stripcslashes($password);
		$userbame=mysqli_real_escape_string($connection, $username);
		$password=mysqli_real_escape_string($connection,$password);
		

		// 2. Perform database query
		$query  = "SELECT * ";
		$query .= "FROM users ";
		$query .= "WHERE username='$username' AND password='$password'";
		$result = mysqli_query($connection, $query);
		$row= mysqli_fetch_array($result);
		
		if($row['username']==$username && $row['password']==$password){
		   redirect_to("main_page.php");	
		} else {
			echo "Failed to login!";
			}
?>
