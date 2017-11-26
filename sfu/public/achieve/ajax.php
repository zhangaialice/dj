
<html lang="en">
<head>
<?php include("../includes/script.php"); ?>
<?php include("../includes/css.php"); ?>
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
<script src="//code.jquery.com/jquery-1.12.4.js"></script> 
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
</head>

<body>



<script>
	$(document).ready(function() {
    $('#example').DataTable( {
     "ajax" : 'fossil.txt',
	 "columns": [
    { "data": "Manager" },
    { "data": "FossilFuel_2014" },
    { "data": "Total_2014" },
    { "data": "Percentage_2014" },
    { "data": "Number_2014" },
    { "data": "FossilFuel_2015" },
    { "data": "Total_2015" },
    { "data": "Percentage_2015" },
    { "data": "Number_2015" },
    { "data": "FossilFuel_2016" },
    { "data": "Total_2016" },
    { "data": "Percentage_2016" },
    { "data": "Number_2016" }
    ]
} );

});
</script>
<table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Extn.</th>
                <th>Start date</th>
                <th>Salary</th>
				<th>Name1</th>
                <th>Position1</th>
                <th>Office1</th>
                <th>Extn.1</th>
                <th>Start date1</th>
                <th>Salary1</th>
				<th>Salary2</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Extn.</th>
                <th>Start date</th>
                <th>Salary</th>
				<th>Name1</th>
                <th>Position1</th>
                <th>Office1</th>
                <th>Extn.1</th>
                <th>Start date1</th>
                <th>Salary1</th>
				<th>Salary2</th>
            </tr>
        </tfoot>
    </table>
</body>

</html>




