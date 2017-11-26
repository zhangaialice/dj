<!DOCTYPE HTML5 PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html lang="en">

<head>

<script src ="http://tablefilter.free.fr/TableFilter/tablefilter_all_min.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="http://tablefilter.free.fr/TableFilter/filtergrid.css">


</head>
<body>

<?php include("../includes/sql_connect.php");?>

<?php 

		$query  = "SELECT * ";
		$query .= "FROM holding ";
		$report = mysqli_query($connection, $query);
		// Test if there was a query error
		if (!$report) {die("Database query failed.");}
	?>
	
	<table id="table3" class="TF">
	  <tr id="tableheader">
		<th>Year</th>
		<th>ISIN</th>
		<th>Name</th>
		<th>Security Type</th>
		<th>Country</th>
		<th>Currency</th>
		<th>Sector(GICS)</th>
		<th>Sub-Sector(GICS)</th>
		<th>Industry(BICS)</th>
		<th>Sub-Industry(BICS)</th>
		<th>Holdings</th>
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

	  </tr>
	<?php
		// 3. Use returned data (if any)
		while($row = mysqli_fetch_assoc($report)) {
	?>
	  <tr>
		<td><?php echo $row['Year']; ?></td>
		<td><?php echo $row['ISIN']; ?></td>
		<td><?php echo $row['Name']; ?></td>
		<td><?php echo $row['Security_Type']; ?></td>
		<td><?php echo $row['Country']; ?></td>
		<td><?php echo $row['Currency']; ?></td>
		<td><?php echo $row['Sector']; ?></td>
		<td><?php echo $row['Sub_Industry']; ?></td>
		<td><?php echo $row['Industry_Sector']; ?></td>
		<td><?php echo $row['Industry_Group']; ?></td>
		<td><?php echo $row['Holdings']; ?></td>
		<td><?php 
		$formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
					echo $formatter->format($row['Price']); ?></td>
		<td><?php echo $row['Coupon']; ?></td>
		<td><?php echo $row['Maturity']; ?></td>
		<td><?php echo $row['Duration']; ?></td>
		<td><?php echo $row['YTM']; ?></td>
		
	
		<td><?php 
		$formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
					echo $formatter->format($row['Market_Value']);?></td>
		<td><?php echo $row['Minimum_Rating']; ?></td>
		<td><?php echo $row['DBRS_Rating']; ?></td>
		<td><?php echo $row['Manager']; ?></td>
		<td><?php echo $row['Category']; ?></td>
	  </tr>
	<?php
	}
	?>
	</table>
	<?php
	  // 4. Release returned data
	  mysqli_free_result($report);
	?>

<script type="text/javascript">
var totRowIndex = tf_Tag(tf_Id('table3'),"tr").length;  
var table3_Props = {
    col_0: 'select', 
    col_3: 'select', 
    col_4: 'select',
	col_5: 'select',
    col_6: 'select',  
    col_7: 'select', 
    col_8: 'select', 
    col_9:'select', 
	col_19: 'select', 
    col_20:'select',
    display_all_text: " [ Show all ] ",
    sort_select: true,
    exact_match: true,  
    alternate_rows: true,  
    col_width: ["120px","170px",null,null,null],//prevents column width variations  
    rows_counter: true,  
    rows_counter_text: "Total rows: ",  
    btn_reset: true,
    paging: true,  
    paging_length: 10,  
    rows_counter: true,  
    rows_counter_text: "Rows:",  
    btn_reset: true,  
    loader: true,  
    loader_text: "Filtering data...",
    btn_next_page_html: '<a href="javascript:;" style="margin:3px;">Next ></a>',  
    btn_prev_page_html: '<a href="javascript:;" style="margin:3px;">< Previous</a>',  
    btn_last_page_html: '<a href="javascript:;" style="margin:3px;"> Last >|</a>',  
    btn_first_page_html: '<a href="javascript:;" style="margin:3px;"><| First</a>',
    loader_html: '<h4 style="color:red;">Loading, please wait...</h4>',
    sort_num_desc: [9],
    refresh_filters: true,
};

 var tf3 = setFilterGrid("table3", table3_Props,1);
 
</script>

</body>
</html>