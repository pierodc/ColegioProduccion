<?
/*
$Curso = new Curso();
$Curso->id = $_GET['CodigoCurso'];
*/

class Curso{
	public $id_Curso;
	public $Ano;
	public $Status = 'Inscrito';
	
	function __construct($CodigoCurso = 0){
		$this->con = new Conexion();
		if($CodigoCurso > 0){
			$this->id = $CodigoCurso;
			$this->NivelCurso = $this->NivelCurso();
			}
	}
	
	
	public function view_all(){
		$sql = "SELECT * FROM Curso 
				WHERE SW_activo = 1 
				
				ORDER BY NivelCurso, Seccion "; //AND NivelMencion = 2
		$datos = $this->con->consultaRetorno($sql);
		return $datos;
	}	
	
	
	public function Cuenta($AnoEscolar , $CodigoCurso, $Status){
		$sql = "SELECT COUNT(*) AS Cantidad FROM AlumnoXCurso 
				WHERE Ano = '$AnoEscolar' 
				AND CodigoCurso = '$CodigoCurso' 
				AND Status = '$Status' 
				
				
				
				";
		//echo $sql;
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos["Cantidad"];
	}	
	
	
	
	public function CodigoCursoProx(){
		$sql = "SELECT * FROM Curso WHERE CodigoCurso = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['CodigoCursoProxAno'];
		}	
	public function NivelCurso(){
		$sql = "SELECT * FROM Curso WHERE CodigoCurso = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['NivelCurso'];
		}	
	public function NombreCurso( $Codigo = "" ){
		if($Codigo > "")
			$sql = "SELECT * FROM Curso WHERE CodigoCurso = '$Codigo'";
		else	
			$sql = "SELECT * FROM Curso WHERE CodigoCurso = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['NombreCompleto'];
		}
	public function NombreCursoCorto( $Codigo = "" ){
		if($Codigo > "")
			$sql = "SELECT * FROM Curso WHERE CodigoCurso = '$Codigo'";
		else	
			$sql = "SELECT * FROM Curso WHERE CodigoCurso = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['Curso']." ".$datos['NombreNivel']." ".$datos['NombrePlanDeEstudio'];
		}
	public function MencionCurso( $Codigo = "" ){
		if($Codigo > "")
			$sql = "SELECT * FROM Curso WHERE CodigoCurso = '$Codigo'";
		else	
			$sql = "SELECT * FROM Curso WHERE CodigoCurso = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['NombrePlanDeEstudio'];
		}
		
	public function DocenteGuia(){
		$sql = "SELECT * FROM Curso WHERE CodigoCurso = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		//echo $datos['Cedula_Prof_Guia'];
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
		
		
		$sql = "SELECT AlumnoXCurso.*, Alumno.CodigoAlumno, Alumno.Apellidos, Alumno.Nombres
				FROM  Alumno INNER JOIN AlumnoXCurso
				ON Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno
				AND AlumnoXCurso.Status = '{$this->Status}'
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
	
	
/*	
	function view(){
	// view basic data
		$sql = "SELECT * FROM Usuario WHERE Email = '{$this->Email}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos;
	}
	
	function add($Forma){ 
	// add Worker to the local DB
		//  delete if exists 
		$sql = "DELETE FROM Worker WHERE userID = '{$this->id_Usuario}'";
		//$this->con->consultaSimple($sql); 
		// Insert it 
		if ($Forma['Clave'] != $Forma['Clave2']){
			return "Clave inválida";
		}
		else{
			
			extract($Forma);
			$this->Email = $Email;
			$this->Clave = $Clave;
			$this->Nombre = $Nombre;
			$this->Apellido = $Apellido;
			$this->Telefono = $Telefono;
			
			if ( $this->view_email() == $this->Email ){
				return "El usuario ya existe";
				}
			else{
				$sql = "INSERT INTO Usuario (Email, Clave, Nombre, Apellido, Telefono)
						values ('{$this->Email}',
								'{$this->Clave}',
								'{$this->Nombre}',
								'{$this->Apellido}',
								'{$this->Telefono}')";
				$this->con->consultaSimple($sql);
				return "Registrado exitosamente";
				}
			}
		/*
		echo "<pre>";
		var_dump($Forma);
		echo "</pre>";
		//$this->con->consultaSimple($sql);
		
	}*/
	
/*
	function view_email(){
		$sql = "SELECT * FROM Usuario WHERE Email = '{$this->Email}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['Email'];
		}

	function id_Usuario(){
		$sql = "SELECT * FROM Usuario WHERE Email = '{$this->Email}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['id_Usuario'];
		}


	
	

	function view_all(){
	// return all workers personal data
		$sql = "SELECT * FROM Partido WHERE Grupo = '{$this->Grupo}' AND Ronda = '1' ORDER BY Fecha,Hora ";
		$datos = $this->con->consultaRetorno($sql);
		return $datos;
	}
*/


}



?>