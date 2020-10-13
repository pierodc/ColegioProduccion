<?
/*
$Observaciones = new Observaciones();

$Matriz = $Observaciones->view($Usuario->id , "Proveeduria");
foreach($Matriz as $row){
	extract($row);	
}


*/
class Observaciones{
	
	public function __construct(){//
			$this->con = new Conexion();
			//$this->AnoEscolar = $AnoEscolar;
					
		}
	
	public function view($id_Propietario = "", $_Area = ""){
		
		$sql = " SELECT * FROM Observaciones 
						WHERE (Codigo_Propietario = '$id_Propietario' OR CodigoAlumno = '$id_Propietario')
						AND Area = '$_Area'
						AND (Codigo_Padre < 1 OR Codigo_Padre IS NULL)
						ORDER BY Fecha_Creacion DESC ";
		//echo $sql."<br>";
		$Observaciones = $this->con->consultaRetorno($sql);
		if($Observaciones->num_rows){
			$i = 0;
			while ($row = $Observaciones->fetch_assoc()){
				extract($row);
				$Matriz[$i]["Codigo_Padre"] = $Codigo_Padre;
				$Matriz[$i]["Codigo_Propietario"] = $Codigo_Propietario;
				$Matriz[$i]["Observacion"] = $Observacion;
				$Matriz[$i]["Area"] = $Area;
				$Matriz[$i]["Fecha_Creacion"] = $Fecha_Creacion;
				$Matriz[$i]["Por"] = $Por;
				$Matriz[$i]["SW_Resuelto"] = $SW_Resuelto;
				$i++;


				$sql = " SELECT * FROM Observaciones 
							WHERE (Codigo_Propietario = '$id_Propietario' OR CodigoAlumno = '$id_Propietario')
							AND Codigo_Padre = '$Codigo_Observ'
							ORDER BY Fecha_Creacion DESC ";
				//echo $sql."<br>";
				$Observaciones_Hij = $this->con->consultaRetorno($sql);	
				if($Observaciones_Hij->num_rows > 0){
					while ($row = $Observaciones_Hij->fetch_assoc()){
						extract($row);
						$Matriz[$i]["Codigo_Padre"] = $Codigo_Padre;
						$Matriz[$i]["Codigo_Propietario"] = $Codigo_Propietario;
						$Matriz[$i]["Observacion"] = $Observacion;
						$Matriz[$i]["Area"] = $Area;
						$Matriz[$i]["Fecha_Creacion"] = $Fecha_Creacion;
						$Matriz[$i]["Por"] = $Por;
						$Matriz[$i]["SW_Resuelto"] = $SW_Resuelto;
						$i++;
					}
				}	
				$i++;
			}
		}
	return $Matriz;
	}
}
		
?>