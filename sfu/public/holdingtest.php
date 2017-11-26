
<html lang="en">
<head>

</head>
<body>

<?php include("../includes/css.php"); ?>
<?php include("../includes/script.php"); ?>

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
    $('#example').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "phptest.php"
    } );
} );
   </script>
</body>
</html>
