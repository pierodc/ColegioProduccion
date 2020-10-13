<?
/*
$Banco = new Banco($id);
*/

class Banco{
	public $id;
	
	public function __construct($id = 0){//
			$this->con = new Conexion();
			//$this->id = $id;
			if($id > 0){
				$sql = "SELECT * FROM Banco WHERE id = '$id'";
				$datos = $this->con->consultaRetorno_row($sql);
				$this->p = (object)$datos;
				$this->id = $datos['id'];
				}
				
		}
	
	public function view_all(){
		$sql = "SELECT * FROM Banco WHERE Cuenta_id = '{$this->id}'";
		$datos = $this->con->consultaRetorno($sql);
		return $datos;
		}
	public function view_all_Haber(){
		$sql = "SELECT * FROM Banco WHERE Cuenta_id = '{$this->id}' and Haber > 0";
		$datos = $this->con->consultaRetorno($sql);
		return $datos;
		}
	
	public function Status(){
		$sql = "SELECT * FROM Banco WHERE id = '{$this->id}'";
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['Status'];
		}
	
	public function Busca($Referencia = "" , $Monto = ""){
		$sql = "SELECT * FROM Banco 
				WHERE Referencia LIKE '%$Referencia%'";
		$datos = $this->con->consultaRetorno($sql);
		return $datos;
		}
	
	public function Existe($Tr){
				
		$sql = "SELECT * FROM Banco 
				WHERE Cuenta_id = '".$Tr['Cuenta_id']."'
				AND Fecha = '".$Tr['Fecha']."'
				AND Tipo = '".$Tr['Tipo']."'
				AND Referencia = '".$Tr['Referencia']."'
				AND Debe = '".$Tr['Debe']."'
				AND Haber = '".$Tr['Haber']."'
				";
		//echo $sql."<br>";
		$datos = $this->con->consultaRetorno_row($sql);
		
		if($datos['id'] > 0)
			return $datos['id'];
		else{
			$sql = "INSERT INTO Banco 
						(Cuenta_id, Fecha, Tipo, Referencia, Descripcion, Debe, Haber) 
						VALUES 
						('$Tr[Cuenta_id]','$Tr[Fecha]','$Tr[Tipo]','$Tr[Referencia]','$Tr[Descripcion]','$Tr[Debe]','$Tr[Haber]')";
			$datos = $this->con->consultaSimple($sql);
			//echo  $sql . "<br>";
			//echo "id: " . $datos->insert_id . "<br>";
			return $this->Existe($Tr);
		}
			
		}
	
	
		

		
}
		
?>