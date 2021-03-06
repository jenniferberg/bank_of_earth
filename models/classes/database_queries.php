<?php
require_once("database.php");
require_once("../models/functions/functions.php");

class DatabaseQueries{
	
	public function return_output($sql){
		global $db;
		
		$result = $db->db_query($sql);
		
		$output = [];
		while($row = $db->db_fetch_assoc($result)){
			$output[] = $row;
		}
		
		return $output;
	}
	
	public function select_all(){
		global $db;
		
		$sql = "SELECT * FROM ".static::$tableName;
		
		return $this->return_output($sql);
	}
	
	public function select_by_id($id){
		global $db;
		
		$sql  = "SELECT * FROM ".static::$tableName;
		$sql .= " WHERE id = '".$id."'";
		$sql .= " LIMIT 1";
		
		return $this->return_output($sql);
	}
	
	public function select_by_id_type($id){
		global $db;
		
		$sql  = "SELECT * FROM ".static::$tableName;
		$sql .= " WHERE ".static::$id_type." = '".$id."'";
		$sql .= " ORDER BY ".static::$orderBy." ASC";
		
		return $this->return_output($sql);
	}
	
	public function update($update_array, $id){
		global $db;
		
		$length = count($update_array);
		$i = 1;
		
		$sql = " UPDATE ".static::$tableName." SET ";		
		foreach($update_array as $key => $field){
			$sql .= $key." = '".$db->escape_string($field)."'";
			
			if($i < $length){
				$sql .= ", ";
				$i++;
			}
		}
		$sql .= " WHERE id = '".$id."'";
		
		return $db->db_query($sql);
	}

	public function insert($insert_array){
		global $db;
		
		$insertKeys = array_keys($insert_array);
		$count = count($insertKeys);
		
		$i = 1;
		$j = 1;
		$sql  = "INSERT INTO ".static::$tableName."(";
		foreach($insertKeys as $value){
			$sql .= $value;
			if($i < $count){
				$sql .= ", ";
			}
			$i++;
		}
		$sql .= ") ";
		$sql .= "VALUES(";
		foreach($insert_array as $key => $value){
			$sql .= "'".$db->escape_string($value)."'";
			if($j < $count){
				$sql .= ", ";
			}
			$j++;
		}
		$sql .= ")";
		
		return $db->db_query($sql);
		
	}
	

	public function select_with_pagination($id, $per_page, $current_page){
		global $db;
		
		$per_page = escape_string($per_page);
		$current_page = escape_string($current_page);
		
		$offset = offset($per_page, $current_page);
		
		$sql  = "SELECT * FROM ".static::$tableName;
		$sql .= " WHERE ".static::$id_type." = '".$id."'";
		$sql .= " LIMIT ".$per_page;
		$sql .= " OFFSET ".$offset;
		$sql .= " ORDER BY ".static::$orderBy." DESC";
		
		return $this->return_output($sql);
	}
}


?>