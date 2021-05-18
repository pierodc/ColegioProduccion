<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . "/Config/Autoload.php");
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
			"user" => "mypotedu_colegio",
			"pass" => "piero1971",
			"db"   => "mypotedu_db"
			);

if ($_SERVER['HTTP_HOST'] == "localhost" ) {
			$datos_bd = $datos_localhost;
			}
		elseif ($_SERVER['HTTP_HOST'] == "myspotedu.com" ) {
			$datos_bd = $datos_mypotedu;
			}
		else{
			$datos_bd = $datos_sfa;
			}

if($_SERVER['HTTP_HOST'] == "myspotedu.com"){
	echo "<pre>autoload <br>";
	echo $_SERVER['HTTP_HOST']."<br>";
	var_dump( $datos_bd );
	echo "autoload FIN<br></pre>";
}

$mysqli = new mysqli($datos_bd['host'], $datos_bd['user'] , $datos_bd['pass'] , $datos_bd['db']);
/*
$sql = "SELECT * FROM Alumno";
$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();
var_dump($row);
*/
/*
// Conectar

// Ejecuta $sql
$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();

// Ejecuta $sql y While
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	extract($row);
    echo "<br>";
}

$RS->data_seek(0);

$AnoEscolarAnteAnte = "2010-2011";
$AnoEscolarAnte = "2011-2012";

$Ano1 = "12";
$Ano2 = "13";
$AnoEscolar = "2012-2013";

$Ano1prox = "2012";
$Ano2prox = "2013";
$AnoEscolarProx = "2012-2013";

$Ano1prox = "2013";
$Ano2prox = "2014";
$AnoEscolarProx = "2013-2014";

*/

$SWreinscripcion = true;

$DiasSemana = array('Lunes','Martes','Miércoles','Jueves','Viernes');

$NoDiasSemana = array('1','2','3','4','5');


$DirectorCI = "xxxxxV-6973243";
$DirectorNombre = "xxxxVita María Di Campo";

?>