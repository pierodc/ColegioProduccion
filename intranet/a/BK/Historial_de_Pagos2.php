<?php 
$MM_authorizedUsers = "99,91,95,Contable";
require_once( $_SERVER['DOCUMENT_ROOT'] . "/Config/Autoload.php");
//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 

//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 

$Alumno = new Alumno($_GET['CodigoPropietario']);
$Recibos = new Recibo($Alumno->Codigo());
	
 
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title><?php echo "H: " . $Alumno->NombreApellidoCodigo(); ?></title>
<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />
</head>

<body>

<?
$Recibo = $Recibos->view_all();
//var_dump($Recibo);
while($row = $Recibo->fetch_assoc()){
	//var_dump($row);
	//$Recibo = new Recibo($Recibos['CodigoRecibo']);
	echo $row['CodigoRecibo']."<br>";
	
	$ContableMov = new ContableMov();
	$ContableMov->id_Recibo = $row['CodigoRecibo'];
	
	
	$ContableMovs = $ContableMov->view_all();
	while($rowContable = $ContableMovs->fetch_assoc()){
		echo " >> ".$rowContable['Codigo']."<br>";
	
	
	
	}
	
	
	
	}

?>


<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>
</body>
</html>
