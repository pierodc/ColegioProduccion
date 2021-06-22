<?
/*
$ContableMov = new ContableMov($CodigoAlumno=0);
*/

class ContableMov{
	public $id;
	public $id_Alumno;
	public $id_Recibo;
	
	function __construct(){
		$this->con = new Conexion();
	}
	
	
	public function view(){
		$sql = "SELECT * FROM ContableMov WHERE Codigo = '{$this->id}'";
		$datos = $this->con->consultaRetorno($sql);
		return $datos;
	}	
	
	
	
	public function PendienteXX(){
		
		$sql = "SELECT * FROM ContableMov
					WHERE CodigoPropietario = '{$this->id_Alumno}'
					AND SWCancelado = '0'
					AND ( MontoDebe > 0 OR MontoDebe_Dolares > 0 )
					GROUP BY ReferenciaMesAno
					ORDER BY Fecha";
			//echo $sql;
			$datos = $this->con->consultaRetorno($sql);
			$resultado = array();
			while ($row = $datos->fetch_assoc()) {
				extract($row);
				$resultado[] = $ReferenciaMesAno;
			}
		return $resultado;
	}
	
	
	public function Pendiente(){
		$sql = "SELECT * FROM ContableMov
				WHERE CodigoPropietario = '{$this->id_Alumno}'
				AND SWCancelado = '0'
				AND ( MontoDebe > 0 OR MontoDebe_Dolares > 0 )
				ORDER BY ReferenciaMesAno, Fecha";
			//echo $sql;
			$datos = $this->con->consultaRetorno($sql);
			$resultado = array();
			while ($row = $datos->fetch_assoc()) {
				extract($row);
				$resultado["resumen"]["Conteo"]++;
				$resultado["resumen"]["MontoDebe"] += $MontoDebe;
				$resultado["resumen"]["MontoDebe_Dolares"] += round($MontoDebe_Dolares , 2);
				$resultado["resumen"]["MesAno"][$ReferenciaMesAno] = $ReferenciaMesAno;
				
				
				$resultado[$ReferenciaMesAno][$Descripcion] = $Descripcion;
				$resultado[$ReferenciaMesAno]["MontoDebe"] += $MontoDebe;
				$resultado[$ReferenciaMesAno]["MontoDebe_Dolares"] += $MontoDebe_Dolares;
				
			}
		return $resultado;
	}
	
		
	
	public function view_all(){ /// NO SE SI ESTA EN USO
		$sql = "SELECT * FROM ContableMov WHERE CodigoRecibo = '{$this->id_Recibo}' 
				ORDER BY MontoHaber DESC, FechaValor, Codigo";
		$datos = $this->con->consultaRetorno($sql);
		return $datos;
	}	
	

	
	public function Diario($fecha){
		$sql = "SELECT * FROM ContableMov
				WHERE FechaCancelacion = '{$fecha}'
				AND ( MontoHaber > 0 OR MontoHaber_Dolares > 0 )
				AND SWCancelado = '1'
				ORDER BY Fecha, ProcesadoPor, CodigoRecibo";
		$datos = $this->con->consultaRetorno($sql);
		$resultado = array();
		return $datos;
	}
	
	

}



?>