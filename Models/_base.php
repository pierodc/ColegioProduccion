<?
/*
$base = new base();
$base->id = $_GET['$id_base'];
*/

class base{
	
	function __construct( $id_base = 0 ){
		$this->con = new Conexion();
		$this->id_base = $id_base;
		
	}
	
	/*
	public function view_all(){
		$sql = "SELECT * FROM base 
				WHERE SW_activo = 1  "; 
		$datos = $this->con->consultaRetorno($sql);
		return $datos;
	}	
	*/


	public function Respuesta_base($id_base = 0 ){
		$sql = "SELECT * FROM base WHERE id_base = '{$id_base}' ";
		if($datos = $this->con->consultaRetorno_row($sql))
			return $datos['Respuesta'];
		else
			return "n/e"; // no existe
		}	


}



?>