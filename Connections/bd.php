<?php
//require_once( $_SERVER['DOCUMENT_ROOT'] . "/Config/Autoload.php");
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"

$hostname_bd = "localhost";
$database_bd = "colegio_db";
$username_bd = "colegio_colegio";
$password_bd = "kepler1971";

//$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

$datos_localhost = array(
			"host" => "localhost",
			"user" => "root",
			"pass" => "",
			"db" => "copaquin_db"
			);

$datos_sfa = array(
			"host" => "localhost",
			"user" => "colegio_colegio",
			"pass" => "kepler1971",
			"db"   => "colegio_db"
			);

$datos_mypotedu = array(
			"host" => "localhost",
			"user" => "myspotedu_us",
			"pass" => "piero1971",
			"db"   => "myspotedu_db"
			);

if (strpos("   ".$_SERVER['HTTP_HOST'] ,"myspotedu.com") > 1)  {
			$datos_bd = $datos_mypotedu;
			}
		else{
			$datos_bd = $datos_sfa;
			}


if(false and strpos("   ".$_SERVER['HTTP_HOST'] ,"myspotedu.com") > 1) {
	echo "<pre>BD <br>";
	echo $_SERVER['HTTP_HOST']."<br>";
	var_dump( $datos_bd );
	echo "autoload FIN<br></pre>";
}

$mysqli = new mysqli($datos_bd['host'], $datos_bd['user'] , $datos_bd['pass'] , $datos_bd['db']);

$SWreinscripcion = true;

$DiasSemana = array('Lunes','Martes','Miércoles','Jueves','Viernes');

$NoDiasSemana = array('1','2','3','4','5');


$DirectorCI = "xxxxxV-6973243";
$DirectorNombre = "xxxxVita María Di Campo";

?>