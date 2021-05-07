<?
/*
$Alumno = new Alumno($CodigoAlumno, $AnoEscolar);
*/

class Alumno{
	public $id;
	public $AnoEscolar = "2020-2021";
	public $AnoEscolarProx = "2020-2021";
	public $Inscrito;
	public $id_Curso;
	
	
	
	public function __construct($CodigoAlumno = 0, $AnoEscolar = NULL){//
			$this->con = new Conexion();
			$this->id = $CodigoAlumno;
			$this->AnoEscolar = $AnoEscolar;
			if(strlen($CodigoAlumno) > 10){
				$sql = "SELECT * FROM Alumno WHERE CodigoClave = '$CodigoAlumno'";
				$datos = $this->con->consultaRetorno_row($sql);
				$this->id = $datos['CodigoAlumno'];
				}
			
		 	
		}
	
	public function view_all(){
		$sql = "SELECT * FROM Alumno WHERE CodigoAlumno = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos;
		}
	
	
	
	public function Codigo(){
		return $this->id;
		}	
		
	
	public function CodigoCurso(){
		$sql = "SELECT * FROM AlumnoXCurso WHERE CodigoAlumno = '{$this->id}' and Ano = '{$this->AnoEscolar}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['CodigoCurso'];
		}	
		
	public function NombreApellido(){
		$sql = "SELECT * FROM Alumno WHERE CodigoAlumno = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['Nombres'].' '.substr($datos['Nombres2'],0,1).' '.$datos['Apellidos'].' '.substr($datos['Apellidos2'],0,1);
		}
	
	
	
	public function NombreApellidoCodigo(){
		$sql = "SELECT * FROM Alumno WHERE CodigoAlumno = '{$this->id}'";
		//echo $sql;
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['Nombres'].' '.substr($datos['Nombres2'],0,1).' '.$datos['Apellidos'].' '.substr($datos['Apellidos2'],0,1)." (".$datos['CodigoAlumno'].")";
		}
	public function CodigoNombreApellido(){
		$sql = "SELECT * FROM Alumno WHERE CodigoAlumno = '{$this->id}'";
		//echo $sql;
		$datos = $this->con->consultaRetorno_row($sql);
		return " (".$datos['CodigoAlumno'].") ". $datos['Nombres'].' '.substr($datos['Nombres2'],0,1).' '.$datos['Apellidos'].' '.substr($datos['Apellidos2'],0,1);
		}
		
	public function NombresApellidos(){
		$sql = "SELECT * FROM Alumno WHERE CodigoAlumno = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['Nombres'].' '.$datos['Nombres2'].' '.$datos['Apellidos'].' '.$datos['Apellidos2'];
		}
	
	public function ApellidosNombres(){
		$sql = "SELECT * FROM Alumno WHERE CodigoAlumno = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['Apellidos'].' '.$datos['Apellidos2'].' '.$datos['Nombres'].' '.$datos['Nombres2'];
		}
	
	public function Nombres(){
		$sql = "SELECT * FROM Alumno WHERE CodigoAlumno = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['Nombres'].' '.$datos['Nombres2'];
		}
	public function Nombre(){
		$sql = "SELECT * FROM Alumno WHERE CodigoAlumno = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['Nombres'];
		}
		
	public function Apellidos(){
		$sql = "SELECT * FROM Alumno WHERE CodigoAlumno = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['Apellidos'].' '.$datos['Apellidos2'];
		}
	public function Apellido(){
		$sql = "SELECT * FROM Alumno WHERE CodigoAlumno = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['Apellidos'];
		}
		
	public function FechaNac(){
		$sql = "SELECT * FROM Alumno WHERE CodigoAlumno = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['FechaNac'];
		}
	public function Email(){
		$sql = "SELECT * FROM Alumno WHERE CodigoAlumno = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		if($datos['Email'] > "")
			return $datos['Email'];
		else{
			
			$Usuario = noAcentos($this->Nombre()).noAcentos($this->Apellido());
			$Usuario = str_replace(" ","",$Usuario);
			return $Usuario."@colegiosanfrancisco.com" ."";
			
		}
		
		}
	public function Nacionalidad(){
		$sql = "SELECT * FROM Alumno WHERE CodigoAlumno = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['Nacionalidad'];
		}
	public function Entidad(){
		$sql = "SELECT * FROM Alumno WHERE CodigoAlumno = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['Entidad'];
		}
	public function Localidad(){
		$sql = "SELECT * FROM Alumno WHERE CodigoAlumno = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['Localidad'];
		}
		
	public function Cedula(){
		$sql = "SELECT * FROM Alumno WHERE CodigoAlumno = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['Cedula'];
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
		
	
	public function DireccionCompleta(){
		$sql = "SELECT * FROM Alumno WHERE CodigoAlumno = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['Direccion']."-".$datos['Urbanizacion']."-".$datos['Ciudad'];
		}
	public function Telefonos(){
		$sql = "SELECT * FROM Alumno WHERE CodigoAlumno = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return "H:".$datos['TelHab']." C:".$datos['TelCel'];
		}
	public function Emergencia(){
		$sql = "SELECT * FROM Alumno WHERE CodigoAlumno = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return "".$datos['PerEmergencia']." (".$datos['PerEmerNexo'].") t:".$datos['PerEmerTel'];
		}
	
	public function Todo(){
		$sql = "SELECT * FROM Alumno WHERE CodigoAlumno = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos;
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
	
	public function Status($AnoEscolar){
		$sql = "SELECT * FROM AlumnoXCurso 
				WHERE CodigoAlumno = '{$this->id}'
				AND Ano = '$AnoEscolar'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['Status'];
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
		
		
		
		
		function Foto ($nexo = "" , $Tipo = ""){
			$Ano = date('Y');
			$AnoRango = $Ano - 10;
			if ($Tipo == ""){
				$raiz = $_SERVER['DOCUMENT_ROOT'];}
			else{
				$raiz = "http://".$_SERVER['SERVER_NAME']."";}	
				
			$Ruta = $_SERVER['DOCUMENT_ROOT'].'/f/solicitando/'.$this->id . $nexo.'.jpg';
			if ( file_exists($Ruta) ){
				$Ruta = '/f/solicitando/'.$this->id.$nexo.'.jpg';
				}
			else
			for ($Ano_i = $Ano ; $Ano_i >= $AnoRango; $Ano_i--){
				$Ruta = $_SERVER['DOCUMENT_ROOT'].'/f/'.$Ano_i.'/'.$this->id . $nexo.'.jpg';
				if ( file_exists($Ruta) ){
					$Ruta = '/f/'.$Ano_i.'/'.$this->id.$nexo.'.jpg';
					break;
					}
				else{	
					$Ruta = $_SERVER['DOCUMENT_ROOT'].'/f/'.$Ano_i.'/'.$this->id . strtoupper($nexo).'.JPG';
					if ( file_exists($Ruta) ){
						$Ruta = '/f/'.$Ano_i.'/'.$this->id.strtoupper($nexo).'.JPG';
						break;
						}
					}
				
					
					
				}
			if (!file_exists($_SERVER['DOCUMENT_ROOT'].$Ruta))
				$Ruta = '/i/b.jpg';
				
				
			return $raiz.$Ruta;
			}
		
		
		
		public function RepreNombres($Nexo = ""){	
			if ($Nexo == "p"){
				$Nexo = "Padre";}
			elseif ($Nexo == "m"){
				$Nexo = "Madre";}
			elseif ($Nexo == "a"){
				$Nexo = "Autorizado";}
			
			$sql = "SELECT * FROM RepresentanteXAlumno, Representante 
					WHERE RepresentanteXAlumno.CodigoRepresentante = Representante.CodigoRepresentante
					AND RepresentanteXAlumno.Nexo = '$Nexo'
					AND RepresentanteXAlumno.CodigoAlumno = '{$this->id}'";
			$datos = $this->con->consultaRetorno_row($sql);
			return $datos['Nombres']." ".$datos['Apellidos'];
		}
	
		public function RepreCedula($Nexo = ""){	
			if ($Nexo == "p"){
				$Nexo = "Padre";}
			elseif ($Nexo == "m"){
				$Nexo = "Madre";}
			elseif ($Nexo == "a"){
				$Nexo = "Autorizado";}
			
			$sql = "SELECT * FROM RepresentanteXAlumno, Representante 
					WHERE RepresentanteXAlumno.CodigoRepresentante = Representante.CodigoRepresentante
					AND RepresentanteXAlumno.Nexo = '$Nexo'
					AND RepresentanteXAlumno.CodigoAlumno = '{$this->id}'";
			$datos = $this->con->consultaRetorno_row($sql);
			return $datos['Cedula'];
		}
	
		
		public function Representante_id($Nexo = ""){	
			if ($Nexo == "p"){
				$Nexo = "Padre";}
			elseif ($Nexo == "m"){
				$Nexo = "Madre";}
			elseif ($Nexo == "a"){
				$Nexo = "Autorizado";}
			
			$sql = "SELECT * FROM RepresentanteXAlumno 
					WHERE Nexo = '$Nexo'
					AND CodigoAlumno = '{$this->id}'";
			$datos = $this->con->consultaRetorno_row($sql);
			return $datos['CodigoRepresentante'];
		}
	
	
		
		
		
}
		
?>