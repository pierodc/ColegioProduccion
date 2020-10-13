<?
/*
$AlumnoXCurso = new AlumnoXCurso();
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
		else{
			$sql_sort = " ORDER BY Alumno.Apellidos , Alumno.Apellidos2 , Alumno.Nombres , Alumno.Nombres2 ";
		}
		
		$sql = "SELECT * FROM AlumnoXCurso , Alumno
				WHERE AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno
				AND AlumnoXCurso.Ano = '{$this->AnoEscolar}' 
				AND AlumnoXCurso.CodigoAlumno < 100000
				AND AlumnoXCurso.Status = 'Inscrito'
				$sql_sort";
		
		
		//echo $sql;
		$datos = $this->con->consultaRetorno($sql);
		return $datos;
	}
	
	
	public function view($CodigoCurso = "xx", $Sort = ""){
		
		
		$sql_Curso = " AND AlumnoXCurso.CodigoCurso = '$CodigoCurso' ";
		
		if($Sort > ""){
			$sql_sort = " ORDER BY $Sort ";
		}
		else{
			$sql_sort = " ORDER BY Alumno.Apellidos , Alumno.Apellidos2 , Alumno.Nombres , Alumno.Nombres2 ";
		}


		$sql = "SELECT * FROM AlumnoXCurso , Alumno
				WHERE AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno
				AND AlumnoXCurso.Ano = '{$this->AnoEscolar}' 
				$sql_Curso 
				AND AlumnoXCurso.CodigoAlumno < 100000
				AND AlumnoXCurso.Status = 'Inscrito'
				$sql_sort";


		//echo $sql;
		$datos = $this->con->consultaRetorno($sql);
		return $datos;
		
		
	}
	
	
		
}
		
?>