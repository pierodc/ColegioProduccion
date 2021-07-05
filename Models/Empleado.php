<?
/*
$Empleado = new Empleado($CodigoEmpleado);
*/

class Empleado{
	public $id;
	
	public function __construct($CodigoEmpleado = 0){//
			$this->con = new Conexion();
			$this->id = $CodigoEmpleado;
			
		 	
		}
	
	public function view(){
		$sql = "SELECT * FROM Empleado WHERE CodigoEmpleado = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos;
		}
	
	public function Buscar($Buscando){
		$sql  = "SELECT * FROM Empleado WHERE  ";
			
		if( is_numeric($Buscando) ){
			$sql  .= " CodigoEmpleado = '$Buscando' ";
		}
		else{
			$aux = explode(" ", $Buscando); 
			$CamposBuscar = " CONCAT_WS(' ',CodigoEmpleado,Cedula,Nombres,Nombre2,Apellidos,Apellido2 )  ";
			$sql .= "$CamposBuscar LIKE '%%$aux[0]%%'";
			if($aux[1]!=""){
				$sql .= "and $CamposBuscar LIKE '%%$aux[1]%%' ";}
			if($aux[2]!=""){
				$sql .= "and $CamposBuscar LIKE '%%$aux[2]%%' ";}
			if($aux[3]!=""){
				$sql .= "and $CamposBuscar LIKE '%%$aux[3]%%' ";}
		}
		
		$sql .= " ORDER BY Apellidos, Apellido2, Nombres, Nombre2 ";
		//echo $sql;
		$datos = $this->con->consultaRetorno($sql);
		return $datos;
		}
	
	public function ApellidosNombres(){
		$sql = "SELECT * FROM Empleado WHERE CodigoEmpleado = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['Apellidos'].' '.$datos['Apellido2'].' '.$datos['Nombres'].' '.$datos['Nombre2'];
		}
	public function ApellidoNombre(){
		$sql = "SELECT * FROM Empleado WHERE CodigoEmpleado = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['Apellidos'].' '.$datos['Nombres'];
		}
	
	public function Status(){
		$sql = "SELECT * FROM Empleado WHERE CodigoEmpleado = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		if ($datos['SW_activo'] == "1")
			return true;
		else
			return false;
		}
		
		
		
}
		
?>