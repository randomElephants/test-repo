<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Part C - Inventory</title>
</head>
    <body>
    <p>Top of page</p>
    <?php
	  	require_once('MySQLDatabase.php');
		
 		$db = new MySQLDatabase("localhost", "cmodonoghue", "abc123", "claire_test");
		$db->searchInventoryByMake("Unicorn");
		$db->getAllFromInventory();	
		echo "<p>Bottom of page</p>";
	?>
    </body>
</html>