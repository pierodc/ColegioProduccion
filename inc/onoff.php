<?php 
require_once('../Connections/bd.php'); 

header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

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
<a href="http://www.colegiosanfrancisco.com/inc/onoff.php?<?php 
echo "ClaveCampo=$ClaveCampo&ClaveValor=$ClaveValor&SW=$ValorInverso";
echo "&Tabla=$Tabla&Campo=$Campo&Valor=$ValorInverso"; 
?>" ><img src="http://www.colegiosanfrancisco.com/i/accept_<?php echo $Valor; ?>.png" width="16" height="16" /></a>
