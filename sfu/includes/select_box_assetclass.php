<!--select box for asset class -->

		<?php
			// 2. Perform database query
			$query  = "SELECT DISTINCT Security_Type ";
			$query .= "FROM holdings_2014 ";
			//$query .= "WHERE Manager='BEAM' ";
			$result = mysqli_query($connection, $query);
			// Test if there was a query error
			if (!$result) {
				die("Database query failed.");
			}
		?>
		<form action="holdings.php" method="post">
		<select id="assetclass" name='assetclass'>
			<option>-select-</option>
		<?php
			// 3. Use returned data (if any)
			while($row = mysqli_fetch_assoc($result)) {
		?>
			<option><?php echo $row['Security_Type']; ?></option>

		<?php
		}
		?>
		</select>

		</form>
		
		<?php
		  mysqli_free_result($result);
		?>