<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">			
<html>
	<head>
	</head>
		<body>
		<?php include("../includes/sql_connect.php");?>				
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
				
				$a = json_encode($datas);
			    $b=str_replace(array("'", "\"", "&quot;"),"",$a);
				print $b

				?>

			</body>
</html>

["Red", "Blue", "Yellow", "Green", "Purple", "Orange"]