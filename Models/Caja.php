<?
/*
Caja = new Caja();
*/

class Caja{
	
	function __construct(){
		$this->con = new Conexion();
	}
	
	
	public function view($Fecha, $FormaDePago = "" , $Monto = "", $Usuario = "" ){
		$sql = "SELECT * FROM Caja 
				WHERE Fecha = '{$Fecha}'";
		if($FormaDePago > "")
			$sql .= " AND FormaDePago = '{$FormaDePago}'";
		if($Usuario > "")
			$sql .= " AND Usuario = '{$Usuario}'";
		$datos = $this->con->consultaRetorno_row($sql);
		 
		if($datos['id'] > 0){
			$sql = "UPDATE Caja 
					SET Monto = '{$Monto}'
					WHERE Fecha = '{$Fecha}'
					AND FormaDePago = '{$FormaDePago}'
					AND Usuario = '{$Usuario}' ";
			//echo "$sql existe<br>";
		}
		else{
			$sql = "INSERT INTO Caja 
					SET Fecha = '{$Fecha}'";
			if($FormaDePago > "")
				$sql .= " , FormaDePago = '{$FormaDePago}'";
			if($Monto > "")
				$sql .= " , Monto = '{$Monto}'";
			if($Usuario > "")
				$sql .= " , Usuario = '{$Usuario}'";
			//echo "$sql CREAR<br>";
			
		}
		$this->con->consultaRetorno($sql);
		
		return $datos;
	}	
	

	

}



?>