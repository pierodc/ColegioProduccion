<?
/*
ShopOrder = new ShopOrder($id = "");
*/


class ShopOrder{
	
	function __construct($id = ""){
		//echo $id;
		$this->con = new Conexion();
		if($id > ""){
			$this->id = $id;
		}
	}
	
	function view(){
	// view basic data
		$sql = "SELECT * FROM ShopOrder WHERE id = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos;
	}
	
	function add($id_user){
		$this->id_user = $id_user;
	// view basic data
		$sql = "INSERT INTO ShopOrder SET id_user = '{$this->id_user}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos;
	}
	
}

?>