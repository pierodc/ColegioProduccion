<?

class Recibo{
	public $id;
	public $id_Alumno;
	
	function __construct($id_Alumno){
		$this->con = new Conexion();
		$this->id_Alumno = $id_Alumno;
	}
	
	
	public function view_all(){
		$sql = "SELECT * FROM Recibo WHERE CodigoPropietario = '{$this->id_Alumno}'
				ORDER BY CodigoRecibo DESC ";
		$datos = $this->con->consultaRetorno($sql);
		return $datos;
	}	
	
	
		
	


}



?>