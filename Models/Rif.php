<?

class Rif{
	public $id;
	
	public function __construct(array $arguments = array()) {
        $this->con = new Conexion();
		if (!empty($arguments)) {
            foreach ($arguments as $property => $argument) {
                $this->{$property} = $argument;
            }
        }
		if($this->id > 0){
			$sql = "SELECT * FROM Rif WHERE id = '{$this->id}'";
			$datos = $this->con->consultaRetorno_row($sql);
			if($datos)
			foreach ($datos as $property => $argument) {
                $this->{$property} = $argument;
            }
		}
	}
	
	
		
	

	
	
}



?>