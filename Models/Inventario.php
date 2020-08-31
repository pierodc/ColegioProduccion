<?
/*
Inventario = new Inventario($id = "");
*/


class Inventario{
	
	function __construct($id = ""){
		//echo $id;
		$this->con = new Conexion();
		if($id > ""){
			$this->id = $id;
		}
	}
	
	function view(){
	// view basic data
		$sql = "SELECT * FROM Inventario WHERE id = '{$this->id}'";
		//echo $sql;
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos;
	}
	
	function view_all($where = "" , $order = ""){
	// view basic data
		if($order > ""){
			$add_sql .= "  $where ";
		}
		
		if($order > ""){
			$add_sql .= " ORDER BY $order ";
		}
		
		$sql = "SELECT * FROM Inventario 
				$add_sql ";
		//echo $sql;
		$datos = $this->con->consultaRetorno($sql);
		return $datos;
	}
	
	
	
	
	
	
}

?>