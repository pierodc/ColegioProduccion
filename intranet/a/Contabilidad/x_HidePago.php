<?php 
require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 

$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

$sql = "UPDATE ContableMov SET SW_Postergado = 1
		WHERE Codigo = '".$_GET['Codigo']."'";

//echo $sql;		

$RS = $mysqli->query($sql);


echo "ok";
?>