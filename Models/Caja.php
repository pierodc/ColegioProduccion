<?
/*
Caja = new Caja();
*/

class Caja{
	
	function __construct(){
		$this->con = new Conexion();
	}
	
	public function view($Fecha, $FormaDePago = "" ){ //Usuario (Ingreso Egreso)
		$sql = "SELECT * FROM Caja 
				WHERE Fecha = '{$Fecha}'";
		if($FormaDePago > "")
			$sql .= " AND FormaDePago = '{$FormaDePago}'";
		$sql .= " AND Observaciones > ' '";
		$sql .= " ORDER BY id";
		//echo "<br><br><br><br>$sql";
		$datos = $this->con->consultaRetorno($sql);
		return $datos;
	}
	
	public function delete($id){ 
		$sql = "DELETE FROM Caja 
				WHERE id = '{$id}'";
		//echo "<br><br><br><br>" . $sql;
		$datos = $this->con->consultaRetorno($sql);
		return $datos;
	}
	
	
	public function add($Fecha, $FormaDePago = "" , $Monto = "", $Usuario = "", $Observaciones = "", $add = false ){
		$sql = "SELECT * FROM Caja 
				WHERE Fecha = '{$Fecha}'";
		if($FormaDePago > "")
			$sql .= " AND FormaDePago = '{$FormaDePago}'";
		if($Usuario > "")
			$sql .= " AND Usuario = '{$Usuario}'";
		$datos = $this->con->consultaRetorno_row($sql);
		//var_dump($datos);
		//echo "<br>$datos<br>$sql";
		
		
		
		if( ($add and $Monto <> "" ) or $datos == NULL ){
			$sql = "INSERT INTO Caja 
					SET Fecha = '{$Fecha}'";
			if($FormaDePago > "")
				$sql .= " , FormaDePago = '{$FormaDePago}'";
			
			if($Monto > 0)
				$sql .= " , Haber = '{$Monto}'";
			if($Monto < 0)
				$sql .= " , Debe = '{$Monto}'";
			
			if($Usuario > "")
				$sql .= " , Usuario = '{$Usuario}'";
			if($Observaciones > "")
				$sql .= " , Observaciones = '{$Observaciones}'";
			//echo "<br>$sql CREAR<br>";
			
		}
		elseif($datos['id'] > 0 ){
			$sql = "UPDATE Caja 
					SET Haber = '{$Monto}'
					WHERE Fecha = '{$Fecha}'
					AND FormaDePago = '{$FormaDePago}'
					AND Usuario = '{$Usuario}' ";
			//echo "<br>$sql existe<br>";
		}
		
		
		//echo "<br><br>$sql";
		
		$this->con->consultaRetorno($sql);
		
		return $datos;
	}	
	

	

}



?>