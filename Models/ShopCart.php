<?
/*
ShopCart = new ShopCart($id = "");
*/


class ShopCart{
	
	public $id_inventario = "";
	
	function __construct($id = ""){
		//echo $id;
		$this->con = new Conexion();
		if($id > ""){
			$this->id = $id;
		}
	}
	
	function view(){
	// view basic data
		$sql = "SELECT * FROM ShopCart WHERE id = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos;
	}
	
	function view_pedidos($SW_pagado = "" , $id_user = ""){ // Pedidos = 0 //// Pagados = 1
	// view basic data
		if($SW_pagado > ""){
			$add_sql .= "AND SW_pagado = '$SW_pagado' ";
		}
		
		if($id_user > ""){
			$add_sql .= "AND id_user = '$id_user' ";
		}
		
		if($this->id_inventario > ""){
			$add_sql .= "AND id_inventario = '{$this->id_inventario}' ";
		}
		
		
		$sql = "SELECT * FROM ShopCart WHERE $add_sql";
		$sql = str_replace("WHERE AND","WHERE",$sql);
		//echo $sql;
		$datos = $this->con->consultaRetorno($sql);
		return $datos;
	}
	
	
	
	
	
	
}

?>