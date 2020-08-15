<?
/*
$Variable = new Variable();
*/

class Variable{
	public $Nombre;
	public $Valor;
	
	function __construct(){
		$this->con = new Conexion();
	}
	
	function view($Nombre = ""){
	// view basic data
		$sql = "SELECT * FROM Var WHERE Variable = '{$Nombre}' ";
		//echo $sql;
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos['Valor'];
	}
	
	function view_row($Nombre = ""){
	// view basic data
		$sql = "SELECT * FROM Var WHERE Variable = '{$Nombre}' ";
		//echo $sql;
		$datos = $this->con->consultaRetorno_row($sql);
		return $datos;
	}
	
	function edit($Nombre, $Valor , $Descripcion = ""){
		$Fecha_Modificacion = date("Y-m-d H:i:s");
		$sql = "UPDATE Var SET 
				Valor = '{$Valor}' ,
				Fecha_Modificacion = '$Fecha_Modificacion',
				Descripcion = '$Descripcion'
				WHERE Variable = '{$Nombre}' ";
		//echo $sql;
		$datos = $this->con->consultaSimple($sql);
		return $datos;
	}
	
	function form_edit($Nombre){
		echo '<iframe src="http://' . $_SERVER['SERVER_NAME'] . '/inc/Var_Edit.php?Var_Name='. $Nombre .'" height="22" width="200" seamless scrolling="no" frameborder="0" align="right"></iframe>';
	}
	
}

?>