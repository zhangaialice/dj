
<html lang="en">
<head>
<?php include("../includes/script.php"); ?>
<?php include("../includes/css.php"); ?>

</head>


<script>
div.container {
        width: 80%;
    }
</script>
<body>
<?php include("../includes/dropdown.php"); ?>
<div class="tablefilter">
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


<script>
	$(document).ready(function() {

    table= $('#example').DataTable( {

	
     "ajax" : 'empdata.json',
	 "columns": [
    { "data": "Year" },
    { "data": "Name" },
    { "data": "Security_Type" },
    { "data": "Country" },
    { "data": "Currency" },
    { "data": "Sector" },
    { "data": "Sub_Industry" },
    { "data": "Industry_Sector" },
    { "data": "Industry_Group" },
    { "data": "Price" },
    { "data": "Coupon" },
    { "data": "Maturity" },
    { "data": "Duration" },
    { "data": "YTM" },
    { "data": "Market_Value" },
    { "data": "Minimum_Rating" },
    { "data": "DBRS_Rating" },
    { "data": "Manager" },
    { "data": "Category" },
    { "data": "ISIN" }
    ]
} );

});
</script>
<table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Year</th>
				<th>Name</th>
				<th>Security Type</th>
				<th>Country</th>
				<th>Currency</th>
				<th>Sector(GICS)</th>
				<th>Sub-Sector(GICS)</th>
				<th>Industry(BICS)</th>
				<th>Sub-Industry(BICS)</th>
				<th>Price</th>
				<th>Coupon(%)</th>
				<th>Maturity</th>
				<th>Duration</th>
				<th>YTM</th>
				<th>Market Value</th>
				<th>Minimum Rating</th>
				<th>DBRS Rating</th>
				<th>Manager</th>
				<th>Category</th>
				<th>ISIN</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
				<th>Year</th>
				<th>Name</th>
				<th>Security Type</th>
				<th>Country</th>
				<th>Currency</th>
				<th>Sector(GICS)</th>
				<th>Sub-Sector(GICS)</th>
				<th>Industry(BICS)</th>
				<th>Sub-Industry(BICS)</th>
				<th>Price</th>
				<th>Coupon(%)</th>
				<th>Maturity</th>
				<th>Duration</th>
				<th>YTM</th>
				<th>Market Value</th>
				<th>Minimum Rating</th>
				<th>DBRS Rating</th>
				<th>Manager</th>
				<th>Category</th>
				<th>ISIN</th>
            </tr>
        </tfoot>
    </table>
<script>
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#example').DataTable();
 
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
} );

</script>
</div>
</body>

</html>




