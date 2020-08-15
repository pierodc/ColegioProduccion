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
	
	public function Existe($Tr){
		//echo "<br><br><br><br><br>objeto: ";
		
		/*
		
		$query_RS_Busca_Mov = "SELECT * FROM Contable_Imp_Todo 
						WHERE Referencia = '$Referencia'
						AND CodigoCuenta = '$Banco'
						AND Fecha = '$Fecha'
						AND MontoHaber = '$MontoHaber' 
						AND MontoDebe = '$MontoDebe'";
		//echo $query_RS_Busca_Mov;					
		$RS_Busca_Mov = mysql_query($query_RS_Busca_Mov, $bd) or die(mysql_error());
		$row_RS_Busca_Mov = mysql_fetch_assoc($RS_Busca_Mov);
		$totalRows_RS_Busca_Mov = mysql_num_rows($RS_Busca_Mov);

		if($totalRows_RS_Busca_Mov == 0){
			$query = "INSERT INTO Contable_Imp_Todo 
						(CodigoCuenta, Fecha, Tipo, Lote, Referencia, Descripcion, MontoDebe, MontoHaber, ChNum, Retencion, Comision) 
						VALUES 
						('$Banco','$Fecha','$Tipo','$Lote','$Referencia','$Descripcion','$MontoDebe','$MontoHaber','$ChNum','$Retencion','$Comision')";
			//$RS_query = mysql_query($query, $bd) or die(mysql_error());
			//echo " <br> $query ";
			$RS = $mysqli->query($query);
			$Codigo = $mysqli->insert_id;
		}
		
		
		*/
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
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