<?php 
$MM_authorizedUsers = "99,91,95,90";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 

$Tabla  = $_GET['Tabla'];
$Codigo = $_GET['Codigo'];
$Campo  = $_GET['Campo'];


$SQL = "SELECT CodigoEmpleado , $Campo 
		FROM $Tabla 
		WHERE 
		CodigoEmpleado = $Codigo";
//echo $SQL;

$RS = $mysqli->query($SQL);
if( $row = $RS->fetch_assoc())
	$Valor = $row[$Campo];
else
	$Valor = "";

?>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.FondoCampoVerde {
	background-color: #33FF66;
	padding: 3px;
	font-size: 10px;
	color: #000000;
}
</style>
<form action="<? $php_self ?>?Tabla=<?= $Tabla ?>&Codigo=<?= $Codigo ?>&Campo=<?= $Campo ?>" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="left" nowrap <?php if (isset($_POST['Campo'])) { ?> class="FondoCampoVerde"<?php } ?>  >
<?php 

if (isset($_POST['G'])) {
	$Valor = coma_punto($_POST['Campo']);
	
	$SQL = "UPDATE $Tabla SET 
			$Campo = $Valor WHERE 
			CodigoEmpleado = $Codigo ";
	//echo $SQL."<br>";
	$mysqli->query($SQL);

	$SQL = "SELECT CodigoEmpleado , $Campo FROM $Tabla WHERE 
				CodigoEmpleado = $Codigo";
		
	//echo $SQL."<br>";
	$RS = $mysqli->query($SQL);
	$row = $RS->fetch_assoc();

	//echo $SQL."<br>";
	
	echo Fnum($row[$Campo]);
	


}
else{
		 ?>	
       	<input name="Campo" type="text" value="<?= $Valor; ?>" size="8">
        <input type="submit" name="G" id="button" value="G" onClick="this.value='..'" />
        <?php 
	}

?>
        </td>
		
    </tr>
</table>
</form>