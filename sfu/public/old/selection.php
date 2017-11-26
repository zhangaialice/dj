<form action="frame.php" method="post">

		<label for="Year">Year</label>
		<select id="Year" name='Year'>
				<option>-select-</option>
				<option>holdings_2014</option>
				<option>holdings_2015</option>
				<option>holdings_2016</option>
		</select>
		

		<?php
			// 2. Perform database query
			$query  = "SELECT DISTINCT Manager ";
			$query .= "FROM $Year ";
			//$query .= "WHERE Manager='BEAM' ";
			$result = mysqli_query($connection, $query);
			// Test if there was a query error
			//if (!$result) {die("Database query failed.");}
		?>
		<label for="Manager">Manager</label>
		<select id="Manager" name='Manager'>
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
			$query .= "FROM $Year ";
			//$query .= "WHERE Manager='BEAM' ";
			$result = mysqli_query($connection, $query);
			// Test if there was a query error
			//if (!$result) {die("Database query failed.");}
		?>
		<label for="AssetClass">Asset Class</label>
		<select id="AssetClass" name='AssetClass'>
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

	<!--select box for Category -->	

		<?php
			// 2. Perform database query
			$query  = "SELECT DISTINCT Category ";
			$query .= "FROM $Year ";
			$result = mysqli_query($connection, $query);
			//if (!$result) {die("Database query failed.");}
		?>
		<label for="Category">Category</label>
		<select id="Category" name='Category'>
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

		
		<input type="submit" name="submit" value="Submit" />
		</form>
	
	</div>
	<div class="pageContent">