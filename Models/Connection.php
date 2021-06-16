<?

class Conexion{
	private $sql;
	/*
	private $datos_localhost = array(
				"host" => "localhost",
				"user" => "root",
				"pass" => "",
				"db" => "copaquin_db"
				);
	private $datos = array(
				"host" => "localhost",
				"user" => "colegio_colegio",
				"pass" => "kepler1971",
				"db" => "colegio_db"
				);
	*/
	
	private $con;
		
	function __construct(){
		global $datos_bd;
		$this->con = new mysqli($datos_bd['host'], $datos_bd['user'] , $datos_bd['pass'] , $datos_bd['db']);
		}

	function consultaSimple($sql){
		$datos = $this->con->query($sql);
		return $datos;
		}

	function consultaRetorno_row($sql){
		$datos = $this->con->query($sql);
		//echo $sql;
		$row = $datos->fetch_assoc();
		return $row;
		}
	function consultaRetorno($sql){
		//echo $sql;
		$datos = $this->con->query($sql);
		return $datos;
		}		

	function Maximo($Tabla,$Campo){
		//echo $sql;
		$sql = "SELECT MAX '$Campo' IN '$tabla";
		$datos = $this->con->query($sql);
		return $datos;
		}		

	}
	
?>