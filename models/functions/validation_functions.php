<?php
//Validation Functions

//Function to create a readable name from form variable name
function readable_name($variable){
	$variable = ucfirst($variable);
	$variable = str_replace('_',' ',$variable);
	$variable = preg_replace('/[0-9]+/','',$variable);
	return $variable;
}

//Function to evaluate field name
function evaluate_name($name){
	$name = strtolower($name);
	$name = str_replace(" ","",$name);
	
	return $name;
}

//Function to determine if two values are the same
function match($value1, $value2){
	if($value1 == $value2){
		return true;
	}else{
		return false;
	}
}

//Required Fields
function required($array){
	$message = [];
	foreach($array as $field){
		$value = trim($_POST[$field]);
		if(!isset($value) || $value === ""){
			$message[$field] =  readable_name($field)." is a required field. ";
		}
	}
	return $message;
}

//Fields with minimum lengths
function min_length($array){
	$message = [];
	foreach($array as $field=>$limit){
		$length = strlen(trim($_POST[$field]));
		if($length < $limit){
			$message[$field] =  readable_name($field)." must be at least ".$limit." characters. ";
		}
	}
	
	return $message;
}

//Fields with maximum lengths
function max_length($array){
	$message = [];
	foreach($array as $field=>$limit){
		$length = strlen(trim($_POST[$field]));
		if($length > $limit){
			$message[$field] =  readable_name($field)." cannot exceed ".$limit." characters. ";
		}
	}
	
	return $message;
}

//Fields that must be numbers
function check_number($array){
	$message = [];
	
	foreach($array as $field){
		if(!is_numeric($_POST[$field])){
			$message[$field] = readable_name($field). " must be a number.";
		}
	}
	
	return $message;
}

//Validate all information
function validate_info($required=[], $minimum=[], $maximum=[], $numbers=[]){
	$message = [];

	//Check that all required fields have been completed
	$req = required($required);
	if(isset($req)){
		foreach($req as $key => $value){		
			if(isset($message[$key])){
				$message[$key] .= $req[$key];
			}else{
				$message[$key] = $req[$key];
			}
		}
	}
	
	//Check that fields have minimum required character lengths
	$min = min_length($minimum);
	if(isset($min)){
		foreach($min as $key => $value){
			if(isset($message[$key])){
				$message[$key] .= $min[$key];
			}else{
				$message[$key] = $min[$key];
			}
		}
	}
	
	//Check that fields do not exceed maximum character lengths
	$max = max_length($maximum);
	if(isset($max)){
		foreach($max as $key => $value){
			if(isset($message[$key])){
				$message[$key] .= $max[$key];
			}else{
				$message[$key] = $max[$key];
			}
		}
	}
	
	//Check that fields that must be numbers are formatted correctly
	$ints = check_number($numbers);
	if(isset($ints)){
		foreach($ints as $key => $value){
			if(isset($message[$key])){
				$message[$key] .= $ints[$key];
			}else{
				$message[$key] = $ints[$key];
			}
		}
	}

	return $message;
}

?>