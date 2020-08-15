<?
/*
$Representante = new Representante($Codigo);
*/

class Representante{
	public $id;
	
	public function __construct($Codigo = 0){//
			$this->con = new Conexion();
			$this->id = $Codigo;
			$sql = "SELECT * FROM Representante WHERE CodigoRepresentante = '$Codigo'";
			if(!$datos = $this->con->consultaRetorno_row($sql))
				$this->id = 0;
							
		}
	
	public function view(){
		$sql = "SELECT * FROM Representante WHERE CodigoRepresentante = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos;
		}
		
}
		
?>