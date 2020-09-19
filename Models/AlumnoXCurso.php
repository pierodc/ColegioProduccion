<?
/*
$AlumnoXCurso = new $AlumnoXCurso();
*/

class AlumnoXCurso{
	public $AnoEscolar = "2020-2021";
	public $AnoEscolarProx = "2020-2021";
	
	
	public function __construct(){//
			$this->con = new Conexion();
			//$this->AnoEscolar = $AnoEscolar;
					
		}
	
	public function all($Sort = ""){
		
		if($Sort > ""){
			$sql_sort = " ORDER BY $Sort ";
		}
		
		$sql = "SELECT * FROM AlumnoXCurso 
				WHERE Ano = '{$this->AnoEscolar}' 
				AND CodigoAlumno < 100000
				AND Status = 'Inscrito'
				$sql_sort";
		
		
		//echo $sql;
		$datos = $this->con->consultaRetorno($sql);
		return $datos;
		}
	
	
		
}
		
?>