<?
/*
$Usuario = new Usuario($Usuario = "");
*/


class Usuario{
	public $id_Usuario;
	public $Email;
	public $Clave;
	public $Nombre;
	public $Apellido;
	public $Telefono;
	
	
	function __construct($Usuario = ""){
		$this->con = new Conexion();
		if($Usuario > ""){
			$this->Email = $Usuario;
			$this->id = $this->id_Usuario();
		}
	}
	
	function view(){
	// view basic data
		if($this->id > "")
		  $sql = "SELECT * FROM Usuario WHERE Codigo = '{$this->id}' ";
		else
		  $sql = "SELECT * FROM Usuario WHERE Email = '{$this->Email}' ";
		$datos = $this->con->consultaRetorno_row($sql);
		//echo "$sql";
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
		*/
	}
	
	
	function view_email(){
		$sql = "SELECT * FROM Usuario WHERE Email = '{$this->Email}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['Email'];
		}

	function id_Usuario(){
		$sql = "SELECT * FROM Usuario WHERE Email = '{$this->Email}' or Usuario = '{$this->Email}'";
		//echo $sql;
		$datos = $this->con->consultaRetorno_row($sql);
		//return $datos['id_Usuario'];
		return $datos['Codigo'];
		}

/*
	
	

	function view_all(){
	// return all workers personal data
		$sql = "SELECT * FROM Partido WHERE Grupo = '{$this->Grupo}' AND Ronda = '1' ORDER BY Fecha,Hora ";
		$datos = $this->con->consultaRetorno($sql);
		return $datos;
	}
*/

	function Alumnos(){	
			$sql = "SELECT * FROM Alumno, AlumnoXCurso 
					WHERE Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno
					AND Alumno.Creador = '{$this->Email}'
					GROUP BY AlumnoXCurso.CodigoAlumno
					
					";  
					//AND AlumnoXCurso.Status = 'Inscrito'
					//AND AlumnoXCurso.Ano LIKE '%".date("Y")."%'
			$RS = $this->con->consultaRetorno($sql);
			$i = 0;
			if($RS->num_rows > 0){
				while($row = $RS->fetch_assoc()){
					$datos[$i++] = $row["CodigoAlumno"];
				}
				return $datos;
			}
			else{
				return array();	
				}
			//return $datos;
		}
	
	
	

}

?>