<?
/*
$Consulta = new Consulta();
$Consulta->id = $_GET['Consulta'];
*/

class Consulta{
	
	function __construct($id_alumno = 0 , $id_pregunta = 0){
		$this->con = new Conexion();
		$this->id_alumno = $id_alumno;
		$this->id_pregunta = $id_pregunta;
		
	}
	
	/*
	public function view_all(){
		$sql = "SELECT * FROM Consulta 
				WHERE SW_activo = 1  "; 
		$datos = $this->con->consultaRetorno($sql);
		return $datos;
	}	
	*/

	
	
	public function Asistencia($id_alumno = 0 , $id_pregunta = 0, $Observaciones = ""){
		
		$sql = "SELECT * FROM Voto_Respuesta 
				WHERE id_alumno = '{$id_alumno}' 
				AND id_pregunta = '{$id_pregunta}'";
		$RS = $mysqli->query($sql);
		if($row = $RS->fetch_assoc()){
			$Respuesta = $row['Respuesta'];
			$id = $row['id'];
			}
		else{
			$sql = "INSERT INTO Voto_Respuesta 
					SET Respuesta = 'Asistio',
					id_alumno = '{$id_alumno}',
					id_pregunta = '1',
					Observaciones = '{$Observaciones}'";
			$mysqli->query($sql);
		}

		
		
	}	

	
	public function Respuesta($id_alumno = 0 , $id_pregunta = 0){
		$sql = "SELECT * FROM Voto_Respuesta 
				WHERE id_alumno = '{$id_alumno}' 
				AND id_pregunta = '{$id_pregunta}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['Respuesta'];
		}	



	
	public function Resultado($id_pregunta = 0){
		$sql = "SELECT COUNT(CodigoAlumno) as Contar
				FROM AlumnoXCurso 
				WHERE Status = 'Inscrito' 
				AND Ano = '2020-2021'
				AND CodigoAlumno < 999999";
		$datos = $this->con->consultaRetorno_row($sql);
		$Resultado["Poblacion"]["n"] = $datos['Contar'];
		$Resultado["Poblacion"]["porc"] = 100;
		
		$Resultado["Participaron"]["n"] = 0;
		
		$sql = "SELECT COUNT(id_pregunta) as Contar
				FROM Voto_Respuesta 
				WHERE id_pregunta = '{$id_pregunta}'
				AND Respuesta = 'Si'";
		$datos = $this->con->consultaRetorno_row($sql);
		$Resultado["Si"]["n"] = $datos['Contar'];
		
		$sql = "SELECT COUNT(id_pregunta) as Contar
				FROM Voto_Respuesta 
				WHERE id_pregunta = '{$id_pregunta}'
				AND Respuesta = 'No'";
		$datos = $this->con->consultaRetorno_row($sql);
		$Resultado["No"]["n"] = $datos['Contar'];
		
		$sql = "SELECT COUNT(id_pregunta) as Contar
				FROM Voto_Respuesta 
				WHERE id_pregunta = '{$id_pregunta}'
				AND Respuesta = 'Asistio'";
		$datos = $this->con->consultaRetorno_row($sql);
		$Resultado["NoResp"]["n"] = $datos['Contar'];
		
		
		
		
		$Resultado["Participaron"]["n"] = $Resultado["Si"]["n"]+$Resultado["No"]["n"]+$Resultado["NoResp"]["n"];
		$Resultado["Participaron"]["porc"] = round($Resultado["Participaron"]["n"]/$Resultado["Poblacion"]["n"]*100,2);
		$Resultado["Si"]["porc"] = round($Resultado["Si"]["n"]/$Resultado["Participaron"]["n"]*100,2);
		$Resultado["No"]["porc"] = round($Resultado["No"]["n"]/$Resultado["Participaron"]["n"]*100,2);
		$Resultado["NoResp"]["porc"] = round($Resultado["NoResp"]["n"]/$Resultado["Participaron"]["n"]*100,2);

		
		
		return $Resultado;
		}	


	
	
	
	
}



?>