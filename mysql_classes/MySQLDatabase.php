<?php
class MySQLDatabase {
	
	private $mysqli;
	
	private $dbHost;
	private $username;
	private $password;
	private $dbName;
	
	public function __construct($host, $username, $password, $dbName) {
		
		$this->dbHost = $host;
		$this->username = $username;
		$this->password = $password;
		$this->dbName = $dbName;
		
		$this->connect();
	}
	
	private function connect() {
		if (empty($this->dbHost)) {
			throw new Exception('No host set.');
		}
		
		$this->mysqli = new mysqli($this->dbHost, $this->username, $this->password, $this->dbName);
		
		if ($this->mysqli->connect_error) {
			echo "Connect error:" . $this->_mysqli->connect_errno . ": " . $this->_mysqli->connect_error;
			throw new Exception("Connect Error " . $this->_mysqli->connect_errno . ": " . $this->_mysqli->connect_error);
		}
	}
	
	
	public function testQuery($query) {
		$result = $this->mysqli->query($query);
		return $result;
	}
	
	//Will fail if "Inventory" table doesn't exist yet
	public function searchInventoryByMake($make) {
		$stmt = $this->mysqli->prepare("SELECT make, model, price, quantity FROM inventory where make=?");
		$stmt->bind_param("s", $make);
		return $this->getResult($stmt);
	}	
	
	public function getAllFromInventory() {
		$stmt = $this->mysqli->prepare("SELECT make, model, price, quantity FROM inventory");
		return $this->getResult($stmt);
	}
	
	//TODO: make work! Don't forget to return something. Result class??
	private function getResult($stmt) {
		$stmt->execute();
		
		$num_fields = $stmt->field_count;
		$field_names = array();
		$meta = $stmt->result_metadata();
		
		for ($i=0; $i<$num_fields; $i++) {
			$fieldName = $meta->fetch_field()->name;
			$field_names[] = $fieldName;
		}
		
		foreach ($field_names as $name) {
			echo "<p>$name</p>";
		}
		
		$stmt->bind_result($make, $model, $price, $quantity);
		
		while ($stmt->fetch()) {
			echo "<p>$make, $model, $price, $quantity</p>";
		}
	}
//Bracket to close class
}