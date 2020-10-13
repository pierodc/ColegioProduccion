<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 
header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
header("Pragma: no-cache"); //HTTP 1.0  
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado

$Nombre = $_GET['Nombre'];

$Variable = new Variable();

if (isset($_GET['Cambia'])){
	if ($Variable->view($Nombre) == 1) {
		$Valor = 0;
	}
	else{
		$Valor = 1;	
	}
	$Variable->edit($Nombre,$Valor);
	}

$Valor = $Variable->view($Nombre);


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="expires" content="0" />
<title>Untitled Document</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>
<body>
<?php //echo $Campo ?>
<a href="<?php
echo $_SERVER['PHP_SELF'] . "?";
echo "Nombre=".$_GET['Nombre'];
echo "&Valor=".$Variable->view($_GET['Nombre']); 
echo "&Cambia=1"; 
?>" >
<img src="/i/accept_<?php echo $Valor; ?>.png" width="16" height="16" />
</a>
</body>
</html>