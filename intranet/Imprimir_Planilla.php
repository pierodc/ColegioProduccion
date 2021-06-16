<?php 
$MM_authorizedUsers = "2,91";
$SW_omite_trace = false;
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 



if(isset($_POST['SMS_Academico']) and $_POST['CodigoAlumno'] > ''){
	$sql = "UPDATE Alumno SET
			SMS_Academico = '".$_POST['SMS_Academico']."',
			SMS_Caja = '".$_POST['SMS_Caja']."',
			SMS_Observaciones = '".$_POST['SMS_Observaciones']."',
			SMS_Fecha_Act = '".$_POST['SMS_Fecha_Act']."',
			SMS_Act_Por = '".$_POST['SMS_Act_Por']."'
			WHERE CodigoAlumno = '".$_POST['CodigoAlumno']."'";
			//echo $sql;
	$mysqli->query($sql);
	}


/*$Usuario_RS_Alumno = "0";
if (isset($_COOKIE['MM_Username'])) {
  $MM_Username = (get_magic_quotes_gpc()) ? $_COOKIE['MM_Username'] : addslashes($_COOKIE['MM_Username']);
}
$colname_RS_Alumno = "1";
if (isset($_GET['CodigoAlumno'])) {
  $CodigoAlumno = (get_magic_quotes_gpc()) ? $_GET['CodigoAlumno'] : addslashes($_GET['CodigoAlumno']);
}*/

$query_RS_Alumno = "SELECT * FROM Alumno WHERE CodigoAlumno = '$CodigoAlumno' AND Creador = '$MM_Username' ";
$RS_Alumno = $mysqli->query($query_RS_Alumno);
//echo $query_RS_Alumno;
$row_RS_Alumno = $RS_Alumno->fetch_assoc();

$SQLstatus = "SELECT * FROM AlumnoXCurso
				WHERE CodigoAlumno = '".$row_RS_Alumno['CodigoAlumno']."'
				
				AND 
				(Ano = '".$AnoEscolarProx."'
				AND (Status = 'Aceptado' OR Status = 'Inscrito'))
				
				OR (Ano = '".$AnoEscolar."' AND Status = 'Inscrito')
				
				";
$RS_Status = $mysqli->query($SQLstatus);
if($row_Status = $RS_Status->fetch_assoc()
	and $row_RS_Alumno['SMS_Academico'] > '' 
	and $row_RS_Alumno['SMS_Caja'] > ''
	and $row_RS_Alumno['SMS_Fecha_Act'] >= date('Y-m-d') ){
	$PlanillaActiva = true;	
	//extract($row_RS_Alumno);
	 }
else{
	$PlanillaActiva = false; }

//extract($row_RS_Alumno);

?>
<html>
<head>
<title>Colegio San Francisco de As&iacute;s</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<meta name="google-site-verification" content="uCJ89hMiFA3PQcDx27Y2aAfIrDaon9rzD_jNGEEmc3w" />
<link rel="shortcut icon" href="../img/favicon.ico">
<link href="../n/CSS/Level2_Arial_Text.css" rel="stylesheet" type="text/css">
<style type="text/css">
.style1 {color: #0000FF}
</style>
<script src="../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<link href="../estilos2.css" rel="stylesheet" type="text/css">
<link href="../estilos.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
</head>
<body bgcolor="e7e7e9" leftmargin="0" topmargin="20" marginwidth="0" marginheight="0"  >
<table width="1025" border="0" align="center" cellpadding="0" cellspacing="0" id="Table_01">
<tr>
		<td bgcolor="#FFF8E8">
			<img src="../img/index_01.jpg" width="31" height="191" alt=""></td>
		<td bgcolor="#FFFFFF">
			<img src="../img/TitSol.jpg" width="197" height="191" alt=""></td>
		<td bgcolor="#0A1B69">
			<img src="../img/TituloAzul.jpg" width="766" height="191" alt="Colegio San Francisco de Asis"></td>
		<td bgcolor="#FFF8E8">
			<img src="../img/index_04.jpg" width="31" height="191" alt=""></td>
  </tr>
	<tr>
		<td colspan="4">
			<img src="../img/index_05.jpg" width="1025" height="7" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="../img/index_06.jpg" width="31" height="68" alt=""></td>
		<td bgcolor="#F3F3F3">&nbsp;</td>
		<td>&nbsp;</td>
  <td bgcolor="#FFF8E8">
			<img src="../img/index_09.jpg" width="31" height="68" alt=""></td>
	</tr>
	<tr>
		<td colspan="4">
			<img src="../img/index_10.jpg" width="1025" height="6" alt=""></td>
	</tr>
	<tr>
		<td colspan="4" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="31" bgcolor="#FFF8E8">&nbsp;</td>
            <td colspan="2"><?php include('../inc_login.php'); ?></td>
            <td width="31" bgcolor="#FFF8E8">&nbsp;</td>
          </tr>
          <tr>
            <td width="31" bgcolor="#D1D0B4">&nbsp;</td>
            <td width="197" valign="top" bgcolor="#EBE4C8">
<?php $subDir = '../'; ?><?php include('../inc_menu.php'); ?></td>
            <td rowspan="3" align="center" valign="top" class="box1">
            
<img src="../img/b.gif" width="740" height="1"><br>
<?php if ($PlanillaActiva){ ?>           
<p class="Tit_Pagina">Imprimir Planilla</p>
<?php }else{ ?>
<h1 class="MensajeDeError">Antes de imprimir la planilla debe actualizar los datos siguientes:</h1>
<?php } ?><form name="form2" method="post" action="">
  <table width="90%" border="0">
    <tr>
      <td colspan="2" class="subtitle">Telefonos de contacto por mensajer&iacute;a de texto SMS</td>
    </tr>
    <tr>
      <td align="right" nowrap="nowrap" class="NombreCampoBIG"> Celular para mensajes Acad&eacute;micos</td>
      <td nowrap class="FondoCampo"><label for="SMS_Academico"></label>
        <span id="sprytextfield1">
        <input name="SMS_Academico" type="text" id="SMS_Academico" value="<?php echo $row_RS_Alumno['SMS_Academico'] ?>" size="30">
        <span class="textfieldRequiredMsg">Requerido</span><span class="textfieldMinCharsMsg">Muy Corto</span><span class="textfieldMaxCharsMsg">Muy Largo</span></span><strong>*(solo n&uacute;m)</strong></td>
    </tr>
    <tr>
      <td align="right" nowrap="nowrap" class="NombreCampoBIG">Celular para mensajes de Caja</td>
      <td class="FondoCampo"><label for="SMS_Caja"></label>
        <span id="sprytextfield2">
        <input name="SMS_Caja" type="text" id="SMS_Caja" value="<?php echo $row_RS_Alumno['SMS_Caja']   ?>" size="30">
        <span class="textfieldRequiredMsg">Requerido</span><span class="textfieldInvalidFormatMsg">Invalido</span><span class="textfieldMinCharsMsg">Muy Corto</span><span class="textfieldMaxCharsMsg">Muy Largo</span></span><strong>*(solo n&uacute;m)</strong></td>
    </tr>
    <tr>
      <td align="right" nowrap="nowrap" class="NombreCampoBIG">Observaciones</td>
      <td class="FondoCampo"><label for="SMS_Observaciones"></label>
        <input name="SMS_Observaciones" type="text" id="SMS_Observaciones" value="<?php echo $row_RS_Alumno['SMS_Observaciones'] ?>" size="30"></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input name="SMS_Fecha_Act" type="hidden" id="SMS_Fecha_Act" value="<?php echo date('Y-m-d') ?>">
        <input name="SMS_Act_Por" type="hidden" id="SMS_Act_Por" value="<?php echo $MM_Username ?>">
        <input name="CodigoAlumno" type="hidden" id="CodigoAlumno" value="<?php echo $row_RS_Alumno['CodigoAlumno']; ?>">        <input type="submit" name="button2" id="button2" value="Actualizar"></td>
      </tr>
    <tr>
      <td colspan="2" align="center" class="FondoCampoInput">* Si desea agregar m&aacute;s tel&eacute;fonos separe por ( , )</td>
    </tr>
<?php if ($PlanillaActiva) { ?>
    <tr>
      <td colspan="2" align="center" class="FondoCampoVerdeGde"><a href="PlanillaInscripcion_pdf.php?CodigoAlumno=<?php echo $row_RS_Alumno['CodigoClave']; ?>" target="_blank"><img src="../i/printer.png" alt="" width="32" height="32" border="0" align="absmiddle">&nbsp; <span><strong>Imprimir Planilla de INSCRIPCI&Oacute;N</strong> (
      <?php  echo $row_RS_Alumno['Nombres']; ?>
      <?php  echo $row_RS_Alumno['Nombres2']; ?>
) </span></a></td>
    </tr>
<?php } ?>
  </table>
</form>

 </td>
            <td width="31" bgcolor="#FFF8E8">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#DBBE96">&nbsp;</td>
            <td valign="top" bgcolor="#EECCA6" class="medium">&nbsp;</td>
            <td bgcolor="#FFF8E8">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#FFF8E8">&nbsp;</td>
            <td valign="top">&nbsp;</td>
            <td bgcolor="#FFF8E8">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#FFF8E8">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td width="31" bgcolor="#FFF8E8">&nbsp;</td>
          </tr>
        </table>
		  <p>&nbsp;</p>
	    <p>&nbsp;</p></td>
  </tr>
	<tr>
		<td colspan="4" bgcolor="#FFFFFF">
			<img src="../img/Pie1.jpg" width="1025" height="9" alt=""></td>
	</tr>
	<tr>
		<td bgcolor="#0A1B69">
			<img src="../img/PieA.jpg" width="31" height="58" alt=""></td>
		<td colspan="2" align="center" bgcolor="#0A1B69"><strong class="medium"><font color="#FFFFFF">Todos los derechos reservados Colegio San Francisco de As&iacute;s &copy; 2010</font></strong></td>
<td bgcolor="#0A1B69">
			<img src="../img/PieB.jpg" width="31" height="58" alt=""></td>
	</tr>
</table>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["change"]});
</script>
</body>
</html>