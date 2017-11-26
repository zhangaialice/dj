<?php
  // 1. Create a database connection
  $dbhost = "localhost";
  $dbuser = "root";
  $dbpass = "ai";
  $dbname = "sfu_treasury";
  $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  // Test if connection succeeded
  if(mysqli_connect_errno()) {
    die("Database connection failed: " . 
         mysqli_connect_error() . 
         " (" . mysqli_connect_errno() . ")"
    );
  }


 //fetch table rows from mysql db
    $sql = "select * from holding";
    $result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));

    //create an array
    $emparray = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $emparray[] = $row;
    }
    //echo json_encode($emparray);
    //write to json file

    $fp = fopen('empdata.json', 'w');
    fwrite($fp, "{\"data\":".json_encode($emparray)."}");
    fclose($fp);

    //close the db connection
    mysqli_close($connection);
?>
