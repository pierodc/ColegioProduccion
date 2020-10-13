<?php 
//$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable,provee";
$TituloPagina   = "INTRANET"; // <title>
$TituloPantalla = "INTRANET"; // Titulo contenido

require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 
//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php');
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
echo "<br><br><br><br><pre>";

$id = $_GET[id];
$Banco = new Banco($id);
//$Alumno = new Alumno($CodigoAlumno);



$sql = "SELECT * FROM ContableMov 
		WHERE Codigo = '$id' ";
$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();
var_dump($row);
echo "<br><br>";

if($row['Referencia'] > ""){
	$sql = "SELECT * FROM Banco 
			WHERE Referencia LIKE '%". $row['Referencia'] ."%' ";
}


$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();
var_dump($row);





require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/BeforeHTML.php" );
?><!doctype html>
<html lang="es">
  <head>
	<? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Head.php");  ?>
    <title><?php echo $TituloPag; ?></title>
</head>
<body <? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Body_tag.php");  ?>>
<? //require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/NavBar.php");  ?>
<? //require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Header.php"); ?>

	
	
	
	
	
	
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer_info.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/AfterHTML.php"); ?>