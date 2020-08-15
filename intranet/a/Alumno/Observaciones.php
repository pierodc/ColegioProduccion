<?php 
//$MM_authorizedUsers = "99,91,95,90,Contable";
//require_once('../../../inc_login_ck.php'); 
require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php'); 
require_once('../../../inc/rutinas.php'); 
$CodigoAlumno = $_GET['CodigoAlumno'];

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form8") and $_POST["Observacion"] > "") {
	$insertSQL = sprintf("INSERT INTO Observaciones (CodigoAlumno, Area, Observacion, Fecha, Hora, Por) VALUES (%s, %s, %s, %s, %s, %s)",
					   GetSQLValueString($_POST['CodigoAlumno'], "int"),
					   GetSQLValueString($_GET['Area'], "text"),
					   GetSQLValueString($_POST['Observacion'], "text"),
					   GetSQLValueString($_POST['Fecha'], "date"),
					   GetSQLValueString($_POST['Hora'], "date"),
					   GetSQLValueString($_COOKIE['MM_Username'], "text"));
	
	$Result1 = $mysqli->query($insertSQL); 

	$sql="SELECT * FROM Alumno WHERE CodigoAlumno = '$CodigoAlumno'";
	$RS_Alumno = $mysqli->query($sql); 
	$row_Alumno = $RS_Alumno->fetch_assoc();

	$para .= 'piero@dicampo.com';
	$asunto = 'Observacion Caja';
	$contenido = '
	<html>
	<head>
	  <title>Observacion Caja</title>
	</head>
	<body>
	  <p><a href=http://www.colegiosanfrancisco.com/intranet/a/Estado_de_Cuenta_Alumno.php?CodigoPropietario='.$row_Alumno['CodigoClave'].'>'.$row_Alumno['CodigoAlumno'].'</a></p>
	  <p>'.$_POST['Observacion'].'</p>
	</body>
	</html>
	';
	
	$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	// Cabeceras adicionales
	//$cabeceras .= 'To: María <maria@example.com>, Kelly <kelly@example.com>' . "\r\n";
	$cabeceras .= 'From:Caja - Colegio<caja@sanfrancisco.e12.ve>' . "\r\n";
	//$cabeceras .= 'Cc:colegiosanfrancisco.e12.ve' . "\r\n";
	//$cabeceras .= 'Bcc:colegio@sanfrancisco.e12.ve' . "\r\n";
	//mail($para, $asunto, $contenido, $cabeceras); 
  
}


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />
<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>

<body><form action="<?php echo $editFormAction; ?>" method="post" name="form8" id="form8">
  <table width="100%" align="center">
<?php
if($MM_Username != 'piero'){
	$addSQL = "AND Area = '".$_GET['Area']."'"; }
$query_Observaciones = "SELECT * FROM Observaciones 
						WHERE CodigoAlumno = $CodigoAlumno 
						$addSQL
						ORDER BY Fecha DESC, Hora DESC";
$Observaciones = $mysqli->query($query_Observaciones);
$row_Observaciones = $Observaciones->fetch_assoc();
$totalRows_Observaciones = $Observaciones->num_rows;

?>
<tr valign="baseline">
  <td colspan="2" align="right" valign="middle" nowrap="nowrap" class="NombreCampo">Observaci&oacute;n:</td>
  <td valign="middle" class="FondoCampo"><input name="Observacion" type="text" value="" size="80" />
    <input type="hidden" name="Codigo_Observ" value="" />
    <input type="hidden" name="CodigoAlumno" value="<?php echo $_GET['CodigoAlumno']; ?>" />
    <input type="hidden" name="Area" value="Estado de Cuenta" />
    <input type="hidden" name="Fecha" value="<?php echo date('Y-m-d') ?>" />
    <input type="hidden" name="Hora" value="<?php echo date('H:i:s') ?>" />
    <input type="hidden" name="MM_insert" value="form8" /><input type="submit" value="Guardar" /></td>
</tr>
<?php
if ($totalRows_Observaciones > 0)
 do { ?>
  <tr valign="baseline">
    <td align="left" nowrap="nowrap" class="FondoCampo"><?php echo DDMMAAAA($row_Observaciones['Fecha']) ?> - 
      <?php echo $row_Observaciones['Hora'] ?></td>
    <td align="left" nowrap="nowrap" class="FondoCampo"><?php echo $row_Observaciones['Por'] ?></td>
    <td align="left" class="FondoCampo"><?php echo $row_Observaciones['Observacion'] ?></td>
  </tr>
<?php } while ($row_Observaciones = $Observaciones->fetch_assoc()); ?>
  </table>
</form></body>
</html>