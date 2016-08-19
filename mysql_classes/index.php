<?php 
//Move to dependency injection?
require_once('MySQLDatabase.php');
require_once('MySQLResult.php');

$db = new MySQLDatabase("localhost", "cmodonoghue", "abc123", "claire_test");
?>
<!DOCTYPE HTML PUBLIC>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Part C - Inventory</title>
</head>
    <body>
    <h1>Search or Add to Inventory</h1>
    
    <h2>Search</h2>
    <form>
    	<p>
	    	<label for="search">Please select a make:</label>
	    	<select id="search" name="searchMake" required="required">
	    		<option value="">Select one</option>
	    		<option value="all">All makes</option>
	    		<?php 
	    			$makes = $db->getMakes();
	    			foreach ($makes->getRows() as $row) {
	    				$m = $row['make'];
	    				echo "<option value='$m'>$m</option>";
	    			}
	    		?>
    		</select>
    	</p>
    	<p>
    		<input type="submit" value="Search"/>
    	</p>
    </form>
    <h2>Add new row</h2>
    <form>
    
    	<p>
    		<label for="addMake">Make:</label>
    		<input type="text" id="addMake" name="addMake" required="required"/>
    	</p>
    	<p>
    		<label for="addModel">Model:</label>
    		<input type="text" name="addModel" id="addModel" required="required"/>
    	</p>
    	<p>
    		<label for="addPrice">Price:</label>
    		<input type="number" id="addPrice" name="addPrice" required="required" pattern="{d}" min="0" value="0" step="1000"/>
    	</p>
    	<p>
    		<label for="addQuantity">Quantity:</label>
    		<input type="number" id="addQuantity" name="addQuantity" required="required" pattern="{d}" min="0" value="0"/>
    	</p>
    	<p>
    		<input type="submit" value="add"/>
    	</p>
    </form>
    <?php
    	if (isset($_GET['searchMake'])) {
    		$searchMake = $_GET['searchMake'];			
    		echo "<p>Searching</p>";
    		
    		if ($searchMake === 'all') {
    			$result = $db->getAllFromInventory();
    		} else {
    			$result = $db->searchInventoryByMake($searchMake);
    		}
    		
    		if (!(is_null($result))) {
    			print_result_table($result);
    		}
    	} else {
    		if (isset($_GET['addMake'])) {
    			$make=$_GET['addMake'];
    			$model=$_GET['addModel'];
    			$price=$_GET['addPrice'];
    			$quantity=$_GET['addQuantity'];
    			$result = $db->insertInventoryEntry($make, $model, $price, $quantity);
    			
    			if ($result) {
    				echo "<p>New entry added!</p>";
    				$result = $db->getAllFromInventory();
    				print_result_table($result);
    			} else {
    				echo "<p>Something went wrong!</p>";
    			}
    		}
    	}
    

	?>
    </body>
</html>
<?php

function print_result_table(MySQLResult $result) {
	echo "<table border='1'>";
	echo "<thead><tr>";
	foreach ($result->getFieldNames() as $field) {
		echo "<th>$field</th>";
	}
	echo "</tr></thead>";
	echo "<tbody>";
	foreach ($result->getRows() as $row) {
		echo "<tr>";
		foreach ($row as $field) {
			echo "<td>$field</td>";
		}
		echo "</tr>";
	}
	echo "</tbody>";
	echo "</table>";
}