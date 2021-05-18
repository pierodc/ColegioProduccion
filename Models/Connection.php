<?

class Conexion{
	private $sql;
	private $datos_localhost = array(
				"host" => "localhost",
				"user" => "root",
				"pass" => "",
				"db" => "copaquin_db"
				);
	
	//private $_SERVER['SERVER_NAME'];
	
	private $datos = array(
				"host" => "localhost",
				"user" => "colegio_colegio",
				"pass" => "kepler1971",
				"db"   => "colegio_db"
				);

	
	
	
	private $con;
		
	function __construct(){
		
		echo "<pre>__construct DB ".$_SERVER['HTTP_HOST'] ;
		//var_dump($datos_bd);
		echo "__construct DB FIN</pre><br>";
		
		if ($_SERVER['HTTP_HOST'] == "localhost" ) {
				$this->con = new mysqli( $this->datos_localhost['host'],
										$this->datos_localhost['user'],
							   			$this->datos_localhost['pass'],
										$this->datos_localhost['db']);
			echo "localhost db";
			}
		elseif ($_SERVER['HTTP_HOST'] == "myspotedu.com" ) {
				$this->con = new mysqli( $this->datos_mypotedu['host'],
										$this->datos_mypotedu['user'],
							   			$this->datos_mypotedu['pass'],
										$this->datos_mypotedu['db']);
			echo "myspot db";
			}
		else{
				$this->con = new mysqli($this->datos['host'],
										$this->datos['user'],
							   			$this->datos['pass'],
										$this->datos['db']);
			echo "colegio db";
			}
	
		
		
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