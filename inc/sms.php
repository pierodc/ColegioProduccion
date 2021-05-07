<?php 
//$MM_authorizedUsers = "99,91,95,90";
//require_once('../inc_login_ck.php'); 
require_once('../Connections/bd.php'); 
require_once('../intranet/a/archivo/Variables.php'); 
require_once('rutinas.php'); 
/*
if(isset($_POST['SMS_Caja'])){
	$sql = "UPDATE Alumno 
			SET SMS_Caja = '".$_POST['SMS_Caja']."',
			SMS_Academico = '".$_POST['SMS_Academico']."'
			WHERE CodigoAlumno = '".$_POST['CodigoAlumno']."'";
	$mysqli->query($sql);
	}


$texto = "COL-SFA Estimado Sr. Representante agradecemos su pago puntual. Su saldo actual es de Bs. ".Fnum($row_RS_Alumno['Deuda_Actual']); 

if(isset($_GET['Saldo'])){ 
	$ResumenTexto = "Caja ".Fnum($row_RS_Alumno['Deuda_Actual']);
	$sql = "INSERT INTO SMS (CodigoAlumno, Mensaje, Telefono, FechaHora, EnviadoPor) 
			VALUES ('".$row_RS_Alumno['CodigoAlumno']."', '$ResumenTexto', '".$row_RS_Alumno['Urge_Celular']."', CURRENT_TIMESTAMP, '$MM_Username');";
	$mysqli->query($sql);
}
*/


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link href="../estilos2.css" rel="stylesheet" type="text/css" />
<link href="../estilos.css" rel="stylesheet" type="text/css" />
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
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center" class="ReciboRenglon"><?php 
		if($_GET['Saldo']>'0'){ 
			echo "OK";
			if($_GET['Empleado']){
				$mysqli->query("UPDATE Empleado 
								SET Fecha_Ultimo_SMS = '".date('Y-m-d')."'
								WHERE TelefonoCel = '".$_GET['destino']."'");
				}
			} 
		elseif($_GET['destino']!="") { 
		?><a href="http://qt.net.ve/sistema/send_beta.php?Empleado=1&usuario=colegiosfda&password=sfda1965&destino=<?php echo $_GET['destino'] ; ?>&texto=<?php echo $_GET['texto'] ; ?>"><img src="../i/transmit.png" width="32" height="32" /></a><?php 
		}
		else {
			echo "T?";} ?>&nbsp;</td>
        </tr>
      </table></body>
</html>