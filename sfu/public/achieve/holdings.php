
<?php include("../includes/sql_connect.php");?>
		<?php
		
		$selected_Manager = "SIAS";		// Storing Selected Value In Variable
		$selected_assetclass = "Canadian Equity";
		$selected_Category= "Endowment";
		
		//echo $selected_Manager,str_repeat('&nbsp;', 5),$selected_assetclass,str_repeat('&nbsp;', 5),$selected_Category;
	   
			
			// 2. Perform database query
			$query  = "SELECT * ";
			$query .= "FROM holdings_2014 ";
			$query .= "WHERE Manager ='". $selected_Manager. "'";
			$query .= "AND Category ='". $selected_Category. "'";
			$query .= "AND Security_Type ='". $selected_assetclass. "'";
			$result = mysqli_query($connection, $query);
			// Test if there was a query error
			if (!$result) {
				die("Database query failed.");
			}
		?>
		
		<table>
		  <tr>
			<th>Name</th>
			<th>Security_Type</th>
			<th>Sector</th>
			<th>Manager</th>
			<th>Category</th>
			<th>Market_Value</th>
			<th>ISIN</th>
		  </tr>
		<?php
			// 3. Use returned data (if any)
			while($row = mysqli_fetch_assoc($result)) {
		?>
		  <tr>
			<td><?php echo $row['Name']; ?></td>
			<td><?php echo $row['Security_Type']; ?></td>
			<td><?php echo $row['Sector']; ?></td>
			<td><?php echo $row['Manager']; ?></td>
			<td><?php echo $row['Category']; ?></td>
			<td><?php echo $row['Market_Value']; ?></td>
			<td><?php echo $row['ISIN']."<br />"; ?></td>
		  </tr>
		<?php
		}
		?>
		</table>
		<?php
		  // 4. Release returned data
		  mysqli_free_result($result);
		?>
	</body>
</html>

<?php include("../includes/sql_disconnect.php")
?>