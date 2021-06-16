<?php 
//$MM_authorizedUsers = "99,91,95,90";
$SW_omite_trace = true;
require_once( $_SERVER['DOCUMENT_ROOT'] . "/Config/Autoload.php");

if(isset($_POST['SMS_Caja'])){
	$sql = "UPDATE Alumno 
			SET SMS_Caja = '".$_POST['SMS_Caja']."',
			SMS_Academico = '".$_POST['SMS_Academico']."'
			WHERE CodigoAlumno = '".$_POST['CodigoAlumno']."'";
	$mysqli->query($sql);
	}

	$query_RS_Alumno = "SELECT * FROM Alumno WHERE CodigoAlumno = '".$_GET['CodigoAlumno']."'";
	$RS_Alumno = $mysqli->query($query_RS_Alumno);
	$row_RS_Alumno = $RS_Alumno->fetch_assoc();

$texto = "COL-SFA Estimado Sr. Representante agradecemos su pago puntual. Su saldo actual es de Bs. ".Fnum($row_RS_Alumno['Deuda_Actual']); 

if(isset($_GET['Saldo'])){ 
	$ResumenTexto = "Caja ".Fnum($row_RS_Alumno['Deuda_Actual']);
	$sql = "INSERT INTO SMS (CodigoAlumno, Mensaje, Telefono, FechaHora, EnviadoPor) 
			VALUES ('".$row_RS_Alumno['CodigoAlumno']."', '$ResumenTexto', '".$row_RS_Alumno['SMS_Caja']."',
			CURRENT_TIMESTAMP, '$MM_Username');";
	$mysqli->query($sql);
}

if(isset($_GET['SoloBot'])){
	$SoloBot = true;}
else{
	$SoloBot = false;}


$telef = str_replace(" ",",",$row_RS_Alumno['SMS_Caja']);
$telef = str_replace(".","",$row_RS_Alumno['SMS_Caja']);
$telef = str_replace("-",",",$row_RS_Alumno['SMS_Caja']);
$telef = str_replace("/",",",$telef);



?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link href="../../estilos2.css" rel="stylesheet" type="text/css" />
<link href="../../estilos.css" rel="stylesheet" type="text/css" />
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
<body><?php if(!$SoloBot){ ?><form id="form1" name="form1Urge" method="post" action="<?php echo $php_self."?CodigoAlumno=".$_GET['CodigoAlumno']; ?>">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
         <td align="center" class="ReciboRenglon"><table border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td rowspan="2" valign="top" nowrap="nowrap"><?php 
				}
			  
			  if($_GET['Saldo']>'0'){ ?>
                <img src="../../i/accept.png" width="24" height="24" alt=""/><? } else {
					
					if($row_RS_Alumno['Deuda_Actual'] > 500 ){
					
					 ?>
                <a href="http://qt.net.ve/sistema/send.php?usuario=colegiosfda&password=sfda1965&destino=<?php echo  $telef; ?>&texto=<?php echo $texto ?>"><img src="../../i/phone_sound.png" width="32" height="32" alt=""/></a>
              <?php }} ?>
			  
			  <?php if(!$SoloBot){ ?></td>
              <td>Caja</td>
              <td><input name="SMS_Caja" type="text" id="SMS_Caja" value="<?php echo $row_RS_Alumno['SMS_Caja'] ; ?>" size="50" /></td>
              <td rowspan="2" valign="bottom"><input type="submit" name="button" id="button" value="G" onclick="this.value='...'" />                <input name="CodigoAlumno" type="hidden" id="CodigoAlumno" value="<?php echo $_GET['CodigoAlumno'] ?>" /></td>
            </tr>
            <tr>
              <td>Acad</td>
              <td><input name="SMS_Academico" type="text" id="SMS_Academico" value="<?php echo $row_RS_Alumno['SMS_Academico'] ; ?>" size="50" /></td>
            </tr>
          </table></td>
        </tr>
      </table>
  
</form><?php } ?></body>
</html>