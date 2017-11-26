<!--select box for managers -->

		<?php
			// 2. Perform database query
			$query  = "SELECT DISTINCT Manager ";
			$query .= "FROM holdings_2014 ";
			//$query .= "WHERE Manager='BEAM' ";
			$result = mysqli_query($connection, $query);
			// Test if there was a query error
			if (!$result) {
				die("Database query failed.");
			}
		?>
		<form action="holdings.php" method="post">
		<label for="Manager">Manager</label>
		<select id="manager" name='Manager'>
		<option>-select-</option>
		
		<?php
			// 3. Use returned data (if any)
			while($row = mysqli_fetch_assoc($result)) {
		?>
			<option><?php echo $row['Manager']; ?></option>

		<?php
		}
		?>
		</select>
		
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
		<label for="assetclass">Asset Class</label>
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
		<label for="categories">Category</label>
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
		</form>
		
		<input type="submit" name="submit" value="Generate Report" />
		</form>

		
