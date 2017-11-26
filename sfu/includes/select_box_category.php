<!--select box for category -->	

		<?php
			// 2. Perform database query
			$query  = "SELECT DISTINCT Category ";
			$query .= "FROM holdings_2014 ";
			$result = mysqli_query($connection, $query);
			if (!$result) {
				die("Database query failed.");
			}
		?>
		
		<form action="holdings.php" method="post">
		<select id="categories" name='categories'>
			<option>-select-</option>
		
		<?php
			// 3. Use returned data (if any)
			while($row = mysqli_fetch_assoc($result)) {
		?>
			<option><?php echo $row['Category']; ?></option>

		<?php
		}
		?>
		</select>
		<input type="submit" name="submit" value="Generate Report" />
		</form>
		
		<?php
		  mysqli_free_result($result);
		?>