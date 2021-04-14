<?php 
$SW_omite_trace = true;
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
header("Pragma: no-cache"); //HTTP 1.0  
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado

if(isset($_GET['Tabla']) and isset($_GET['Campo']) and isset($_GET['Valor'])){
	$Tabla = $_GET['Tabla'];
	$Campo = $_GET['Campo'];
	$Valor = $_GET['Valor'];
	
	$ClaveCampo = $_GET['ClaveCampo'];
	$ClaveValor = $_GET['ClaveValor'];
	
	if(isset($_GET['SW']))	{
		$newSW = $_GET['SW'];
		$sql = "UPDATE $Tabla
				SET $Campo = '$newSW'
				WHERE $ClaveCampo = '$ClaveValor'";
		$mysqli->query($sql);}
	
	if($Valor == "1"){
		$ValorInverso = 0;
		$SW = true;}
	else{
		$ValorInverso = 1;
		$SW = false;}
}
?>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
<?php //echo $Campo ?>
<a href="/inc/onoff.php?<?php 
echo "ClaveCampo=$ClaveCampo&ClaveValor=$ClaveValor&SW=$ValorInverso";
echo "&Tabla=$Tabla&Campo=$Campo&Valor=$ValorInverso"; 
?>" ><img src="/i/accept_<?php echo $Valor; ?>.png" width="16" height="16" /></a>
