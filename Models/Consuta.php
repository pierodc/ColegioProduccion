<?
/*
$Consulta = new Consulta();
$Consulta->id = $_GET['Consulta'];
*/

class Consulta{
	
	function __construct($id_alumno = 0 , $id_pregunta = 0){
		$this->con = new Conexion();
		$this->id_alumno = $id_alumno;
		$this->id_pregunta = $id_pregunta;
		
	}
	
	/*
	public function view_all(){
		$sql = "SELECT * FROM Consulta 
				WHERE SW_activo = 1  "; 
		$datos = $this->con->consultaRetorno($sql);
		return $datos;
	}	
	*/


	public function Respuesta($id_alumno = 0 , $id_pregunta = 0){
		$sql = "SELECT * FROM Consulta WHERE id_alumno = '{$id_Alumno}' AND id_pregunta = '{$id_pregunta}'";
		if($datos = $this->con->consultaRetorno_row($sql))
			return $datos['Respuesta'];
		else
			return "n/e"; // no existe
		}	


}



?>