<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_bd = "localhost";
$database_bd = "colegio_db";
$username_bd = "colegio_colegio";
$password_bd = "kepler1971";


 
$bd = mysql_pconnect($hostname_bd, $username_bd, $password_bd) or die(mysql_error());

mysql_select_db($database_bd, $bd);

$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

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

//date_default_timezone_set('America/Caracas');
//$FechaRemision = date('30 / 07 / 2012');
//echo 'MM_Username '.$_SESSION['MM_Username'];
?>