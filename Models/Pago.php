<?

class Recibo{
	public $id;
	public $id_Alumno;
	
	function __construct($id){
		$this->con = new Conexion();
		$this->id = $id;
	}
	
	
	public function view(){
		$sql = "SELECT * FROM Recibo WHERE Codigo = '{$this->id}' ";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos;
	}	
	
	
		
	


}



?>