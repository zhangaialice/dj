<!DOCTYPE html>
<html>
<head>
<style>
.divider{

    top: 0px;
    right: 0;

  width:100%; /* Optional */
}

.left {
  float:left;
  width:400px;
}

.menu {
  float:left;
  min-width:600px;
  position: relative;
  z-index:3;
  opacity:0.5;
}

.right {
  float:left;
  width:150px;
}

.tablefilter
{ 	position: fixed;	
    top: 100px;
	z-index:0;
	background-color: white;}

ul.levelone {

    list-style-type: none;
	float: right;
    margin: 20px;
    padding: 0;
    overflow: hidden;
    background-color: white;
}

ul.leveltwo {

    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #312F2F;
}

ul.levelthree {

    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #AFA5A5;
	opacity:1;

}



li.levelone {
	position: relative;
    float: left;
	padding-left: 50px;
	z-index:3;
}

li a {

    display: block;
    color: black;
    text-align: center;
    padding: 16px;
    text-decoration: none;

}

li li a {

    display: block;
    color: white;
    text-align: center;
    padding: 16px;
    text-decoration: none;

}
	

li a:hover {

    background-color: #312F2F;
	color: white;

}


li li a:hover {
    background-color: #BF3F3F;
	color: white;

}


.test{float: right;
width:80%;}
</style>

<script src ="http://tablefilter.free.fr/TableFilter/tablefilter_all_min.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="http://tablefilter.free.fr/TableFilter/filtergrid.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	
	
<script>
	
		$(function () {
		$('nav li ul').hide().removeClass('fallback');
		$('nav li').click(function () {
			$('ul', this).slideDown("slow");
			$('nav li li ul').hide();
			$('nav li li.fossilfuel').hover(function(){$('nav li li.fossilfuel ul').slideToggle(400);});
		});
	});

</script>	

</head>
<body>

<div class="left" style="height:60px;background:white">
	<img src="image/sfulogo.png"  height="60" width="300">
	
</div>



		<ul>
			<li> <a class="levelone" href="holding.php">Holding</a></li>
		</ul>
		<ul >
			<li><a class="levelone">ESG</a>
				<ul class="leveltwo" id="test">
					<li class="fossilfuel"><a href="fossil_fuel.php">Fossil Fuel</a>
							<ul class="levelthree" id="test1">
								<li><a href="fossil_manager_chart.php">Manager</a></li>
								<li><a href="fossil_assetclass.php">Asset Class</a></li>
								<li><a href="fossil_category.php">Category</a></li>
							</ul>
					</li>
					<li class="military">
						<a href="military_manager.php",class="military">Military</a>

					</li>
					<li class="tobacco">
						<a href="tobacco_manager.php">Tobacco</a>

					</li>
				</ul>
			</li>
		</ul>
		<ul>
			<li class="levelone"><a href="#">Report Management</a>
					<ul class="leveltwo" id="test">
						<li><a href="#">TBD</a></li>
					</ul>
			</li>
		</ul>
		<ul>
			<li class="levelone"><a href="#">Admin</a>
					<ul class="leveltwo" id="test">
						<li><a href="#">TBD</a></li>
					</ul>
			</li>
		</ul>
			

<div class="right"></div>

<div class="tablefilter">
<img  class="divider" src="image/divider.png" height="20" width="1600">
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
	<?php
		// 3. Use returned data (if any)
		while($row = mysqli_fetch_assoc($report)) {
	?>
	   <tr>
		<td><?php echo $row['Year']; ?></td>
		<td><?php echo $row['Name']; ?></td>
		<td><?php echo $row['Security_Type']; ?></td>
		<td><?php echo $row['Country']; ?></td>
		<td><?php echo $row['Currency']; ?></td>
		<td><?php echo $row['Sector']; ?></td>
		<td><?php echo $row['Sub_Industry']; ?></td>
		<td><?php echo $row['Industry_Sector']; ?></td>
		<td><?php echo $row['Industry_Group']; ?></td>
		<td><?php 
		$formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
					echo $formatter->format($row['Price']); ?></td>
		<td><?php 
		
		$formatter = new NumberFormatter('en_US', NumberFormatter::DECIMAL);
					echo $formatter->format($row['Coupon']); 
		?></td>
		<td><?php echo $row['Maturity']; ?></td>
		<td><?php 
		$formatter = new NumberFormatter('en_US', NumberFormatter::DECIMAL);
					echo $formatter->format($row['Duration']);

		?></td>
		<td><?php 
				$formatter = new NumberFormatter('en_US', NumberFormatter::DECIMAL);
					echo $formatter->format($row['YTM']);
		?></td>
		
	
		<td><?php 
		$formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
					echo $formatter->format($row['Market_Value']);?></td>
		<td><?php echo $row['Minimum_Rating']; ?></td>
		<td><?php echo $row['DBRS_Rating']; ?></td>
		<td><?php echo $row['Manager']; ?></td>
		<td><?php echo $row['Category']; ?></td>
		<td><?php echo $row['ISIN']; ?></td>
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
    col_2:'select', 	
    col_3: 'select', 
    col_4: 'select',
	col_5: 'select',
    col_6: 'select',  
    col_7: 'select', 
    col_8: 'select', 
	col_17: 'select', 
    col_18:'select',
    display_all_text: " [ Show all ] ",
    sort_select: true,
    exact_match: true,  
    alternate_rows: true,  
    col_width: ["120px","170px",null,null,null],//prevents column width variations  
    rows_counter: true,  
    rows_counter_text: "Total rows: ",  
    btn_reset: true,
    paging: true,  
    paging_length: 15,  
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
</div>

</body>
</html>
