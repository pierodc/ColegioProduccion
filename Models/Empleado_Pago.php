<?
/*
$Empleado_Pago = new Empleado_Pago($CodigoEmpleado = 0);
*/

class Empleado_Pago{
	public $id;
	
	public function __construct(){//
			$this->con = new Conexion();
			$this->id = $CodigoEmpleado;
			
		}
	
	public function view_date($fecha,$FormaDePago){
		$sql = "SELECT * FROM Empleado_Pago WHERE Fecha_Registro LIKE '{$fecha}%'";
		if($FormaDePago > "" and $FormaDePago != "all")
			$sql .= " AND FormaDePago = '{$FormaDePago}'";
		//echo $sql;
		$datos = $this->con->consultaRetorno($sql);
		return $datos;
		}
	
	
		
		
}
		
?>