<?php
//////////////////////////////////////////////////// 
// Mysql to Date 
//////////////////////////////////////////////////// 
function changeDateNormal($fecha){ 
   	ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha); 
   	$lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1]; 
   	return $lafecha; 
} 

//////////////////////////////////////////////////// 
// Date to Mysql 
//////////////////////////////////////////////////// 
function changeDateMysql($fecha){ 
   	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha); 
   	$lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1]; 
   	return $lafecha; 
}
	
//////////////////////////////////////////////////// 
// Date to PostgreSQL
//////////////////////////////////////////////////// 
function changeDatePostgreSQL($fecha){ 
   	//preg_match("/([0-9]{1,2})-([0-9]{1,2})-([0-9]{2,4})/", $fecha, $mifecha); 
        $fechaOnly = explode ("/",$fecha);
   	//$lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1]; 
        $lafecha=date("Y-m-d", mktime(0, 0, 0, $fechaOnly[1], $fechaOnly[0], $fechaOnly[2])); 
   	return $lafecha; 	
}

//////////////////////////////////////////////////// 
// Date to PostgreSQL plus time
//////////////////////////////////////////////////// 
function changeDatePostgreSQLTime($fecha){ 
   	//preg_match("/([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})/", $fecha, $mifecha); 
        $fechaT = explode (" ",trim($fecha));
        $fechaOnly = explode ("/",$fechaT[0]);
        $timeOnly = explode (":",$fechaT[1]);
    
   	$lafecha=date("Y-m-d H:i:s", mktime($timeOnly[0], $timeOnly[1], $timeOnly[2], $fechaOnly[1], $fechaOnly[0], $fechaOnly[2])); 
   	return $lafecha; 	
}

//////////////////////////////////////////////////// 
// Date to View
//////////////////////////////////////////////////// 
function changeDateView($fecha){ 
   	 $lafecha=date("d/m/Y", strtotime($fecha)); 
   	return $lafecha; 	
}

//////////////////////////////////////////////////// 
// Date to View
//////////////////////////////////////////////////// 
function changeDateViewTime($fecha){ 
   	 $lafecha=date("d/m/Y H:i:s", strtotime($fecha)); 
   	return $lafecha; 	
}
?>