<?php 
$MM_authorizedUsers = "99,91,95,90,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');
$CodigoAlumno = $_GET['CodigoAlumno'];

$Alumno = new Alumno($CodigoAlumno, $AnoEscolar);


if (isset($_POST["MM_insert"]) and $_POST['Observacion'] > "") {
	
	//if($_POST['Codigo_Padre'] > 0){
		$SW_Resuelto = 1;
	//}
	
	$insertSQL = sprintf("INSERT INTO Observaciones 
							(CodigoAlumno, Area, Observacion, Fecha, Hora, Codigo_Padre, Por, SW_Resuelto) 
							VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
					   GetSQLValueString($_POST['CodigoAlumno'], "int"),
					   GetSQLValueString($_POST['Area'], "text"),
					   GetSQLValueString($_POST['Observacion'], "text"),
					   GetSQLValueString($_POST['Fecha'], "date"),
					   GetSQLValueString($_POST['Hora'], "date"),
					   GetSQLValueString($_POST['Codigo_Padre'], "text"),
					   GetSQLValueString($_COOKIE['MM_Username'], "text"),
					   GetSQLValueString($SW_Resuelto, "text"));
	
	$Result1 = $mysqli->query($insertSQL); 
	//echo "insert ".$insertSQL;


	$sql="SELECT * FROM Alumno WHERE CodigoAlumno = '$CodigoAlumno'";
	$RS_Alumno = $mysqli->query($sql); 
	$row_Alumno = $RS_Alumno->fetch_assoc();

	$para .= 'piero@dicampo.com';
	$asunto = 'Obs. Caja - '.$MM_Username;
	$contenido = '
	<html>
	<head>
	  <title>Observacion Caja '.$MM_Username.'</title>
	</head>
	<body>
	<p>'. $MM_Username . ': ' . $Alumno->Codigo().'</p>
	
	  <p><a href=http://www.colegiosanfrancisco.com/intranet/a/Cobranza/Estado_de_Cuenta_Alumno.php?CodigoPropietario='.$row_Alumno['CodigoClave'].'>'.
	  
		
	 $Alumno->NombreApellidoCodigo()
	 
	  .' </a> <br>------'.
	  Curso($Alumno->CodigoCurso())
	 
	  .'</p>
	  
	  
	  <p>'.$_POST['Observacion'].'</p>
	  <p>------<br>'.$_COOKIE['MM_Username'].'</p>
	  
	</body>
	</html>';
	
	$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	// Cabeceras adicionales
	//$cabeceras .= 'To: María <maria@example.com>, Kelly <kelly@example.com>' . "\r\n";
	$cabeceras .= 'From:Caja - Colegio<caja@sanfrancisco.e12.ve>' . "\r\n";
	//$cabeceras .= 'Cc:colegiosanfrancisco.e12.ve' . "\r\n";
	//$cabeceras .= 'Bcc:colegio@sanfrancisco.e12.ve' . "\r\n";
	echo mail($para, $asunto, $contenido, $cabeceras); 
  
}


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
<link href="/estilos.css" rel="stylesheet" type="text/css" />
<link href="/css/estilosFinal.css" rel="stylesheet" type="text/css" />
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
  <table>
  <caption>Observaciones</caption>
<?php
//if($MM_Username != 'piero'){
	
	$addSQL = "";
	
	if($CodigoAlumno > "")	{
		$addSQL .= "CodigoAlumno = $CodigoAlumno AND "; 
	}
	else 
	{
		$addSQL .= "SW_Resuelto = '0' AND "; 
		}
	$addSQL .= "(Area = 'Estado de Cuenta' "; 
	$addSQL .= "OR Area = 'PagosRepre') "; 
	$addSQL .= "AND (Codigo_Padre < 1 OR Codigo_Padre IS NULL)"; 
	
	
//}

$query_Observaciones = "SELECT * FROM Observaciones 
						WHERE  
						$addSQL
						AND Area <> 'Boleta'
					
						ORDER BY Fecha DESC, Hora DESC";
//echo $query_Observaciones;						
						
$Observaciones = $mysqli->query($query_Observaciones);

$totalRows_Observaciones = $Observaciones->num_rows;

?>
<tr valign="baseline">
  <td colspan="5" align="right" valign="middle" nowrap="nowrap" class="NombreCampo">Observaci&oacute;n:</td>
  <td colspan="2" rowspan="2" valign="middle" class="FondoCampo">
  <form action="<?php echo $editFormAction; ?>" method="post" name="form8" id="form8">
  <input name="Observacion" type="text" value="" size="80" required="required" />
    <input type="hidden" name="Codigo_Observ" value="" />
    <input type="hidden" name="CodigoAlumno" value="<?php echo $_GET['CodigoAlumno']; ?>" />
    <input type="hidden" name="Area" value="Estado de Cuenta" />
    <input type="hidden" name="Fecha" value="<?php echo date('Y-m-d') ?>" />
    <input type="hidden" name="Hora" value="<?php echo date('H:i:s') ?>" />
    <input type="hidden" name="MM_insert" value="form8" /><input type="submit" value="Agregar"  onclick="this.disabled=true;this.form.submit();" />
    </form></td>
</tr>
<tr valign="baseline">
    <td align="center" valign="middle" nowrap="nowrap" class="NombreCampo">Fecha Hora</td>
    <td align="center" valign="middle" nowrap="nowrap" class="NombreCampo">Por</td>
    <td align="center" valign="middle" nowrap="nowrap" class="NombreCampo">&nbsp;</td>
    <td align="center" valign="middle" nowrap="nowrap" class="NombreCampo">Res</td>
    <td align="center" valign="middle" nowrap="nowrap" class="NombreCampo">n = <?= $totalRows_Observaciones ?></td>
</tr>



<?php
 while ($row_Observaciones = $Observaciones->fetch_assoc()) { 
	  
	//if($row_Observaciones['Codigo_Padre'] < 1) { 
	  
	  ?>
  <tr valign="baseline">
      <td colspan="7" align="left" valign="top" nowrap="nowrap" class="NombreCampoTitMes"><img src="../../../i/b.png" width="1" height="1" alt=""/></td>
      </tr>
  <tr valign="baseline">
    <td align="center" valign="top" nowrap="nowrap" class="FondoCampo"><?php echo DDMMAAAA($row_Observaciones['Fecha']) ?> - 
      <?php echo substr($row_Observaciones['Hora'],0,5) ?></td>
    <td align="left" valign="top" nowrap="nowrap" class="FondoCampo"><?php echo substr($row_Observaciones['Por'],0,4) ?></td>
    <td align="left" valign="top" nowrap="nowrap" class="FondoCampo">&nbsp;</td>
    <td align="center" valign="top" nowrap="nowrap" class="FondoCampo"><? Frame_SW ("Codigo_Observ",$row_Observaciones['Codigo_Observ'],"Observaciones",'SW_Resuelto',$row_Observaciones['SW_Resuelto']); ?></td>
    
    
    <td align="center" valign="top" nowrap="nowrap" class="FondoCampo"><?= $totalRows_Observaciones-- ?>&ordm;</td>
    
    
    <td colspan="2" align="left" valign="top" class="FondoCampo"><?php echo $row_Observaciones['Observacion'] ?>
      <? if (!$row_Observaciones['SW_Resuelto']){ ?>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form8" id="form8">
        <input name="Observacion" type="text" value="" size="80" required="required" />
        <input type="hidden" name="Codigo_Padre" value="<?php echo $row_Observaciones['Codigo_Observ'] ?>" />
        <input type="hidden" name="CodigoAlumno" value="<?php echo $_GET['CodigoAlumno']; ?>" />
        <input type="hidden" name="Area" value="<?php echo $row_Observaciones['Area'] ?>" />
        <input type="hidden" name="Fecha" value="<?php echo date('Y-m-d') ?>" />
        <input type="hidden" name="Hora" value="<?php echo date('H:i:s') ?>" />
        <input type="hidden" name="MM_insert" value="form<?php echo time(); ?>" />
        <input type="submit" value="Responder"  onclick="this.disabled=true;this.form.submit();" />
      </form> <? } ?>   </td>
    </tr>
<?php
		
		
		$query_Observaciones_HIJAS = "SELECT * FROM Observaciones 
						WHERE Codigo_Padre = '". $row_Observaciones['Codigo_Observ'] ."'
						ORDER BY Fecha DESC, Hora DESC";
		
		//echo $query_Observaciones_HIJAS;
		
		
		$Observaciones_HIJAS = $mysqli->query($query_Observaciones_HIJAS);
		//$row_Observaciones_HIJAS = $Observaciones_HIJAS->fetch_assoc();
		$totalRows_Observaciones_HIJAS = $Observaciones_HIJAS->num_rows;

		//echo $totalRows_Observaciones_HIJAS;
		if($totalRows_Observaciones_HIJAS > 0) {
		
			while ($row_Observaciones_HIJAS = $Observaciones_HIJAS->fetch_assoc()){ 
			
			  ?>
		 	 <tr valign="baseline">
			<td align="center" valign="top" nowrap="nowrap" class="FondoCampo"><?php echo DDMMAAAA($row_Observaciones_HIJAS['Fecha']) ?> - 
			  <?php echo substr($row_Observaciones['Hora'],0,5) ?></td>
			<td align="left" valign="top" nowrap="nowrap" class="FondoCampo"><?php echo substr($row_Observaciones_HIJAS['Por'],0,4) ?></td>
			<td align="left" valign="top" nowrap="nowrap" class="FondoCampo">&nbsp;</td>
			<td align="center" valign="top" nowrap="nowrap" class="FondoCampo"><? Frame_SW ("Codigo_Observ",$row_Observaciones['Codigo_Observ'],"Observaciones",'SW_Resuelto',$row_Observaciones_HIJAS['SW_Resuelto']); ?></td>


			<td align="left" valign="top" nowrap="nowrap" class="FondoCampo">&nbsp;</td>

			<td width="10" align="left" valign="top" nowrap="nowrap" class="FondoCampo"><img src="../../../i/arrow_right.png" width="32" height="32" alt=""/></td>
			<td align="left" valign="top" class="FondoCampo"><?php echo $row_Observaciones_HIJAS['Observacion'] ?>
			  <? if (!$row_Observaciones_HIJAS['SW_Resuelto']){ ?>
			  <form action="<?php echo $editFormAction; ?>" method="post" name="form8" id="form8">
				<input name="Observacion" type="text" value="" size="80" required="required" />
				<input type="hidden" name="Codigo_Padre" value="<?php echo $row_Observaciones_HIJAS['Codigo_Observ'] ?>" />
				<input type="hidden" name="CodigoAlumno" value="<?php echo $_GET['CodigoAlumno']; ?>" />
				<input type="hidden" name="Area" value="<?php echo $row_Observaciones_HIJAS['Area'] ?>" />
				<input type="hidden" name="Fecha" value="<?php echo date('Y-m-d') ?>" />
				<input type="hidden" name="Hora" value="<?php echo date('H:i:s') ?>" />
				<input type="hidden" name="MM_insert" value="form<?php echo time(); ?>" />
				<input type="submit" value="Responder"  onclick="this.disabled=true;this.form.submit();" />
			  </form> <? } ?>   </td>
			
      </tr>
			<?php

		 	}
		 }
		
		
		
		
		
	
	 
	
 
 } while ($row_Observaciones = $Observaciones->fetch_assoc()); ?>
 
 
 
 
  </table>
</body>
</html>