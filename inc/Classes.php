<?php 
/*
class Conexion{
	private $datos = array(
			"host" => "localhost",
			"user" => "colegio_colegio",
			"pass" => "kepler1971",
			"db" => "colegio_db"
			);
		private $con;
		
		function __construct(){
			$this->con = new mysqli($this->datos['host'],$this->datos['user'],
								   $this->datos['pass'],$this->datos['db']);
			}
		function consultaSimple($sql){
			$this->con->query($sql);
			}
		function consultaRetorno_row($sql){
			$datos = $this->con->query($sql);
			$row = $datos->fetch_assoc();
			return $row;
			}
		function consultaRetorno($sql){
			$datos = $this->con->query($sql);
			return $datos;
			}		
	}
*/
	
class Cursobk{
	public $id;
	public $con;
	public $Ano;
	public $Nombres;
	public function __construct(){
			$this->con = new Conexion();
		}
	public function NivelCurso(){
		$sql = "SELECT * FROM Curso WHERE CodigoCurso = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['NivelCurso'];
		}	
	public function NombreCurso(){
		$sql = "SELECT * FROM Curso WHERE CodigoCurso = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['NombreCompleto'];
		}
		
	public function DocenteGuia(){
		$sql = "SELECT * FROM Curso WHERE CodigoCurso = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['Cedula_Prof_Guia'];
		}
	public function DocenteEspecialista(){
		$sql = "SELECT * FROM Curso WHERE CodigoCurso = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		$Cedula_Prof_Esp = explode(";",$datos['Cedula_Prof_Esp']);
		foreach($Cedula_Prof_Esp as $CedMat){
			$CedMat_array = explode(",",$CedMat);
			$CedMat_Return[$CedMat_array[0]] = $CedMat_array[1];
			}
		return $CedMat_Return;
		}
	
		
	public function ListaCurso(){
		$sql = "SELECT Alumno.CodigoAlumno, Alumno.Nombres,
				AlumnoXCurso.CodigoAlumno, AlumnoXCurso.CodigoCurso, AlumnoXCurso.Status, AlumnoXCurso.Ano, AlumnoXCurso.Tipo_Inscripcion 
				FROM  Alumno INNER JOIN AlumnoXCurso
				ON Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno
				AND AlumnoXCurso.Status = 'Inscrito'
				AND AlumnoXCurso.Tipo_Inscripcion <> 'Mp'
				AND AlumnoXCurso.Ano = '{$this->Ano}'
				AND AlumnoXCurso.CodigoCurso = '{$this->id}'
				ORDER BY Alumno.Apellidos,Alumno.Apellidos2,Alumno.Nombres,Alumno.Nombres2";
		//echo $sql;		
	 	$datos = $this->con->consultaRetorno($sql);
		while($row = $datos->fetch_assoc()){
			$Listado[] = $row;
			}
		return $Listado;
		}
	}


class AlumnoBK{
	public $id;
	public $AnoEscolar;
	public $Inscrito;
	public function __construct($CodigoAlumno, $AnoEscolar=NULL){
			$this->con = new Conexion();
			$this->id = $CodigoAlumno;
			$this->AnoEscolar = $AnoEscolar;
		}
	
	public function Codigo(){
		return $this->id;
		}	
	public function NombreApellido(){
		$sql = "SELECT * FROM Alumno WHERE CodigoAlumno = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['Nombres'].' '.substr($datos['Nombres2'],0,1).' '.$datos['Apellidos'].' '.substr($datos['Apellidos2'],0,1);
		}
	public function NombreApellidoCodigo(){
		$sql = "SELECT * FROM Alumno WHERE CodigoAlumno = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['Nombres'].' '.substr($datos['Nombres2'],0,1).' '.$datos['Apellidos'].' '.substr($datos['Apellidos2'],0,1)." (".$datos['CodigoAlumno'].")";
		}
	public function NombresApellidos(){
		$sql = "SELECT * FROM Alumno WHERE CodigoAlumno = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['Nombres'].' '.$datos['Nombres2'].' '.$datos['Apellidos'].' '.$datos['Apellidos2'];
		}
	public function Creador(){
		$sql = "SELECT * FROM Alumno WHERE CodigoAlumno = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['Creador'];
		}
	public function CodigoClave(){
		$sql = "SELECT * FROM Alumno WHERE CodigoAlumno = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['CodigoClave'];
		}
	public function Inscrito(){
		$sql = "SELECT * FROM AlumnoXCurso 
				WHERE CodigoAlumno = '{$this->id}'
				AND Ano = '{$this->AnoEscolar}'";
		$datos = $this->con->consultaRetorno_row($sql);
		if ($datos['Status'] == "Inscrito")
			return true;
		else
			return false;
		}
	public function HistStatus(){
		$AnoPrev1 = substr($this->AnoEscolar , 0, 4)-1;
		$AnoPrev2 = substr($this->AnoEscolar , 0, 4);
		$AnoSig1  = $AnoPrev2 + 1;
		$AnoSig2  = $AnoSig1 + 1;
		
		
		$sql = "SELECT * FROM AlumnoXCurso 
				WHERE CodigoAlumno = '{$this->id}'
				AND Ano >= '$AnoPrev1-$AnoPrev2'
				AND Ano <= '$AnoSig1-$AnoSig2'";
		$datos = $this->con->consultaRetorno($sql);
		while($row = $datos->fetch_assoc()){
			$Listado[] = $row;
			}
		return $Listado;
		}
		
		
		
	
	}

?>