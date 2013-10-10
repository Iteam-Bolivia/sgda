<?php
/**
 * tab_sol_transferencia.class.php Class
 *
 * @package
 * @author Dev. Diego Calderon Ramirez
 * @copyright ITEAM
 * @version $Id$ 2010
 * @access public
 */
class tab_sol_transferencia extends db
{
	var $str_id;
	var $str_fecha;
        var $str_nrocajas;
        var $uni_id;
        var $unid_id;
        var $str_estado;
	
	function __construct() {
		parent::__construct();
	}

	function getStr_id()
	{
		return $this->str_id;
	}
	function setStr_id($str_id)
	{
		$this->str_id = $str_id;
	}
	
        function getStr_fecha()
	{
		return $this->str_fecha;
	}
	function setStr_fecha($str_fecha)
	{
		$this->str_fecha = $str_fecha;
	}
        
        function getStr_nrocajas()
	{
		return $this->str_nrocajas;
	}
	function setStr_nrocajas($str_nrocajas)
	{
		$this->str_nrocajas = $str_nrocajas;
	}
        
        function getUni_id()
	{
		return $this->uni_id;
	}
	function setUni_id($uni_id)
	{
		$this->uni_id = $uni_id;
	}
        
        function getUnid_id()
	{
		return $this->unid_id;
	}
	function setUnid_id($unid_id)
	{
		$this->unid_id = $unid_id;
	}
	
	function getStr_estado()
	{  
		return $this->str_estado;
	}
	function setStr_estado($str_estado)
	{   
	   $this->str_estado = $str_estado;
	}	
 }
 ?>