<?php
class MySQLResult {
	
	private $numFields;
	private $rowCount;
	private $fieldNames = array();
	private $rows;
	
	//Takes a mysqli_stmt class, turns into readable result set
	public function __construct($stmt) {
		$this->numFields = $stmt->field_count;
		$meta = $stmt->result_metadata();
		$params = array();
		
		while($field = $meta->fetch_field()) {
			$params[] = &$row[$field->name];
			$this->fieldNames[] = $field->name;
		}
		
		call_user_func_array(array($stmt, 'bind_result'), $params);

		while ($stmt->fetch()) {
			$tempRow = array();
			for ($i=0;$i<($this->numFields);$i++) {
				$name = $this->fieldNames[$i];
				$tempRow[$name] = $params[$i]; 
			}
			$this->rows[]=$tempRow;
		}
	}
	
	public function getFieldNames() {
		return $this->fieldNames;
	}
	
	public function getRows() {
		return $this->rows;		
	}
	
	public function getFieldCount() {
		return $numFields;
	}
}