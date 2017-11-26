<?php

// $data = array('as', 'df', 'gh');

// // Execute the python script with the JSON data
// $result = shell_exec('python /path/to/myScript.py ' . escapeshellarg(json_encode($data)));

// // Decode the result
// $resultData = json_decode($result, true);

// // This will contain: array('status' => 'Yes!')
// var_dump($resultData);

// $result = shell_exec('C:\Users\a.zhang\Desktop\SFU\testmysql.py');

// $resultData = json_decode($result, true);

// var_dump($result);


// $command = escapeshellcmd('C:\Users\a.zhang\Desktop\SFU\testmysql.py');
// $output = shell_exec('C:\Users\a.zhang\Desktop\SFU\testmysql.py');
// echo($output);

// $output = shell_exec('python testmysql.py');
// $out=explode("\n", $output);
// echo "<pre>$output</pre>";
// var_dump($out) ;

// echo gettype($output);
// echo gettype($out);

// new

// $output = shell_exec('python testmysql.py');
// echo "<pre>$output</pre>";
// echo gettype($output);

// $resultData = json_encode($output);

// echo($resultData);

// var_dump($out) ;

// echo gettype($output);
// echo gettype($out);
?>


<!-- <?php include("../includes/sql_connect.php");?>

	<?php
		// 2. Perform database query
		$query  = "SELECT * ";
		$query .= "FROM fossil_manager ";
		$result = mysqli_query($connection, $query);
		print gettype($result);

		// $datas=array();
		// // Test if there was a query error
		// if (mysqli_num_rows($result)>0) {
		// while($row = mysqli_fetch_assoc($result)) {
		// $datas[]=$row['Manager'];
		// $pv_2014[]=$row['FossilFuel_2014'];
		// $pv_2015[]=$row['FossilFuel_2015'];
		// $pv_2016[]=$row['FossilFuel_2016'];
		// $data_2014[]=$row['Percentage_2014'];
		// $data_2015[]=$row['Percentage_2015'];
		// $data_2016[]=$row['Percentage_2016'];
		// $num_2014[]=$row['Number_2014'];
		// $num_2015[]=$row['Number_2015'];
		// $num_2016[]=$row['Number_2016'];
		// }}
	?> -->




<!-- <!-- <?php

  $json_payload = json_decode($_GET['json_payload']);
  $temp_value   = $json_payload['temp_value'];
?> -->

<!-- <?php
$firstname = htmlspecialchars($_GET['one']);
// $test = $_POST['one'];
echo $firstname

// echo $_POST['two'];
?> -->
<p>
	<label>Firstname:</label></br>
	<input type="text" id="firstname" name="firstname"/></br>
</p>
<p>
	<label></label></br>
	<input type="text" id="lastname" name="lastname"/></br>
</p>

<?php
$firstname = htmlspecialchars($_GET["firstname"]);
$lastname = htmlspecialchars($_GET["lastname"]);
$password = htmlspecialchars($_GET["password"]);
echo "firstname: $firstname lastname: $lastname password: $password"; ?> -->