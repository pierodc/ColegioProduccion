<?

class ContableAlumno{
	public $id;
	public $id_Alumno;
	public $id_Recibo;
	
	function __construct(){
		$this->con = new Conexion();
	}
	
	
	public function view_Recibo(){
		$sql = "SELECT * FROM ContableMov WHERE CodigoRecibo = '{$this->id_Recibo}' ";
		$datos = $this->con->consultaRetorno($sql);
		return $datos;
	}	
	
	
	
		
	


}



?>