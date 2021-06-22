<?php 
//$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable,provee";
$SW_omite_trace = false;
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

$CodigoAlumno = $_GET['CodigoAlumno'];

if (isset($_POST["MM_insert"]) and $_POST["Observacion"] > "") {
	
	if(isset($_POST['Codigo_Padre'])){
		$Codigo_Padre = $_POST['Codigo_Padre'];
	}
	else{
		$Codigo_Padre = 0;
	}
	
	$insertSQL = sprintf("INSERT INTO Observaciones
	(CodigoAlumno, Area, Observacion, Fecha, Hora, Codigo_Padre, Por, SW_Resuelto) 
	VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
					   GetSQLValueString($_POST['CodigoAlumno'], "int"),
					   GetSQLValueString($_GET['Area'], "text"),
					   GetSQLValueString($_POST['Observacion'], "text"),
					   GetSQLValueString(date('Y-m-d') , "text"),
					   GetSQLValueString(date('H:i:s') , "text"),
					   GetSQLValueString($Codigo_Padre, "text"),
					   GetSQLValueString($_COOKIE['MM_Username'], "text"),
					   GetSQLValueString("0", "text"));
	//echo $insertSQL;
	$Result1 = $mysqli->query($insertSQL); 
}

$query_Observaciones = "SELECT * FROM Observaciones 
						WHERE Area = '".$_GET['Area']."'
						AND (Codigo_Padre < 1 or Codigo_Padre = NULL)
						ORDER BY Fecha DESC, Hora DESC";
$Observaciones = $mysqli->query($query_Observaciones);
if($Observaciones->num_rows)	  
	$row_Observaciones = $Observaciones->fetch_assoc();
$totalRows_Observaciones = $Observaciones->num_rows;

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
<link href="../estilos2.css" rel="stylesheet" type="text/css" />
<link href="../estilos.css" rel="stylesheet" type="text/css" />
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
  <table width="100%" align="center">
  
 <tr valign="baseline">
  <td colspan="5" align="right" valign="middle" nowrap="nowrap" class="NombreCampo">Observaci&oacute;n:</td>
  <td colspan="2" rowspan="2" valign="middle" class="FondoCampo">
  <form action="<?php echo $editFormAction; ?>" method="post" name="form8" id="form8">
  <input name="Observacion" type="text" value="" size="80" required="required" />
    <input type="hidden" name="Codigo_Observ" value="" />
    <input type="hidden" name="Codigo_Padre" value="0" />
    <input type="hidden" name="CodigoAlumno" value="<?php echo $_GET['CodigoAlumno']; ?>" />
    <input type="hidden" name="Area" value="<?php echo $_GET['Area']; ?>" />
    <input type="hidden" name="Fecha" value="<?php echo date('Y-m-d') ?>" />
    <input type="hidden" name="Hora" value="<?php echo date('H:i:s') ?>" />
    <input type="hidden" name="MM_insert" value="form<?php echo time(); ?>" />
    <input type="submit" value="Agregar"  onclick="this.disabled=true;this.form.submit();" />
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


if ($totalRows_Observaciones > 0)
 do { ?>
 
   <tr valign="baseline">
    <td align="center" valign="top" nowrap="nowrap" class="FondoCampo"><?php echo DDMMAAAA($row_Observaciones['Fecha']) ?> - 
      <?php echo substr($row_Observaciones['Hora'],0,5) ?></td>
    <td align="left" valign="top" nowrap="nowrap" class="FondoCampo"><?php echo substr($row_Observaciones['Por'],0,4) ?></td>
    <td align="left" valign="top" nowrap="nowrap" class="FondoCampo">&nbsp;</td>
    <td align="center" valign="top" nowrap="nowrap" class="FondoCampo">
    <? Frame_SW ('Codigo_Observ',$row_Observaciones['Codigo_Observ'],'Observaciones','SW_Resuelto',$row_Observaciones['SW_Resuelto']);  ?></td>
    
    
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
 
 


<?
		
		$query_Observaciones_HIJAS = "SELECT * FROM Observaciones 
										WHERE Codigo_Padre = '". $row_Observaciones['Codigo_Observ'] ."'
										ORDER BY Fecha DESC, Hora DESC";
		$Observaciones_HIJAS = $mysqli->query($query_Observaciones_HIJAS);
		$totalRows_Observaciones_HIJAS = $Observaciones_HIJAS->num_rows;
	 	
	 	if($totalRows_Observaciones_HIJAS > 0) {
		
			while ($row_Observaciones_HIJAS = $Observaciones_HIJAS->fetch_assoc()){ 
			
			  ?>
		 	 <tr valign="baseline">
			<td align="center" valign="top" nowrap="nowrap" class="FondoCampo"><?php echo DDMMAAAA($row_Observaciones_HIJAS['Fecha']) ?> - 
			  <?php echo substr($row_Observaciones['Hora'],0,5) ?></td>
			<td align="left" valign="top" nowrap="nowrap" class="FondoCampo"><?php echo substr($row_Observaciones_HIJAS['Por'],0,4) ?></td>
			<td align="left" valign="top" nowrap="nowrap" class="FondoCampo">&nbsp;</td>
			<td align="center" valign="top" nowrap="nowrap" class="FondoCampo"><? 
				  
				  Frame_SW ("Codigo_Observ",$row_Observaciones['Codigo_Observ'],"Observaciones",'SW_Resuelto',$row_Observaciones_HIJAS['SW_Resuelto']); ?></td>


			<td align="left" valign="top" nowrap="nowrap" class="FondoCampo">&nbsp;</td>

			<td width="10" align="left" valign="top" nowrap="nowrap" class="FondoCampo"><img src="/i/arrow_right.png" width="32" height="32" alt=""/></td>
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
		
		
		
		
			  
	  ?>



  
  
  
  
  
  
<?php } while ($row_Observaciones = $Observaciones->fetch_assoc()); ?>
  </table>
</body>
</html>