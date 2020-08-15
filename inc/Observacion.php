<?php 
$MM_authorizedUsers = "2,99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable,provee";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

//echo $MM_UserGroup;

header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

$Codigo = $_GET['Codigo'];
$Area = $_GET['Area'];

if(isset($_GET['Elimina']) and $_GET['Elimina'] > 0){
	
  $Elimina = $_GET['Elimina'];
  $Codigo_Propietario = $Codigo+100000;
  $sql = 'UPDATE Observaciones Set Codigo_Propietario='.$Codigo_Propietario.' WHERE Codigo_Observ = '.$Elimina ;
  //echo "<br><br><br>" . $sql;
 	$mysqli->query($sql); 
	$sql = 'UPDATE Observaciones Set Codigo_Propietario = '.$Codigo_Propietario.' WHERE Codigo_Padre = '.$Elimina ;
  //echo "<br><br><br>" . $sql;
  $mysqli->query($sql); 
	
	
  $GoTo = $php_self."?Area=".$Area."&Codigo=".$Codigo;
  header(sprintf("Location: %s", $GoTo));
	
	
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form8") and $_POST['Observacion'] > "") {
	//echo "INSERTAR";
	
	if($_POST['Codigo_Padre'] > 0)
		$SW_Resuelto = 1;
	
	$insertSQL = sprintf("INSERT INTO Observaciones (Area, Codigo_Propietario, Codigo_Padre, Observacion, Por, SW_Resuelto) VALUES (%s, %s, %s, %s, %s, %s)",
					   GetSQLValueString($_GET['Area'], "text"),
					   GetSQLValueString($_GET['Codigo'], "int"),
					   GetSQLValueString($_POST['Codigo_Padre'], "int"),
					   GetSQLValueString($_POST['Observacion'], "text"),
					   GetSQLValueString($_COOKIE['MM_Username'], "text"),
					   GetSQLValueString($SW_Resuelto, "text"));
	
	$Result1 = $mysqli->query($insertSQL); 
	//echo $insertSQL;
	
  
}


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
<link href="/estilos.css" rel="stylesheet" type="text/css" />
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
	 
	$addSQL .= "AND (Codigo_Padre < 1 OR Codigo_Padre IS NULL)"; 
	
	
//}

$query_Observaciones = "SELECT * FROM Observaciones 
						WHERE Codigo_Propietario = $Codigo 
						AND Area = '$Area'
						AND (Codigo_Padre < 1 OR Codigo_Padre IS NULL)
						ORDER BY Fecha_Creacion DESC
						";

	  //echo $query_Observaciones;						
						
$Observaciones = $mysqli->query($query_Observaciones);

$totalRows_Observaciones = $Observaciones->num_rows;

?>
<tr valign="baseline">
  <td colspan="5" align="right" valign="middle" nowrap="nowrap" class="NombreCampo">Observaci&oacute;n:</td>
  <td colspan="3" rowspan="2" valign="middle" class="FondoCampo">
  <form action="<?php echo $editFormAction; ?>" method="post" name="form8" id="form8">
 		<input name="Observacion" type="text" value="" size="60" required="required" />
   		<input type="hidden" name="MM_insert" value="form8" />
   		<input type="submit" value="Guardar"  onclick="this.disabled=true;this.form.submit();" />
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
      <td colspan="8" align="left" valign="top" nowrap="nowrap" class="NombreCampoTitMes"><img src="../../../i/b.png" width="1" height="1" alt=""/></td>
      </tr>
  <tr valign="baseline">
    <td align="center" valign="top" nowrap="nowrap" class="FondoCampo"><?php echo DDMMAAAA($row_Observaciones['Fecha_Creacion']) ?></td>
    <td align="left" valign="top" nowrap="nowrap" class="FondoCampo"><?php echo substr($row_Observaciones['Por'],0,4) ?></td>
    <td align="left" valign="top" nowrap="nowrap" class="FondoCampo">&nbsp;</td>
    <td align="center" valign="top" nowrap="nowrap" class="FondoCampo"><? 
  if ($MM_UserGroup == 91){
  		Frame_SW ("Codigo_Observ",$row_Observaciones['Codigo_Observ'],"Observaciones",'SW_Resuelto',$row_Observaciones['SW_Resuelto']); 
  }
		?></td>
    
    
    <td align="center" valign="top" nowrap="nowrap" class="FondoCampo"><?= $totalRows_Observaciones-- ?>&ordm;</td>
    
    
    <td colspan="2" align="left" valign="top" class="FondoCampo"><?php echo $row_Observaciones['Observacion'] ?>
        <? if (!$row_Observaciones['SW_Resuelto'] and $MM_UserGroup == 91 ){ ?>
        <form action="<?php echo $editFormAction; ?>" method="post" name="form8" id="form8">
            <input name="Observacion" type="text" value="" size="80" required="required" />
            <input type="hidden" name="Codigo_Padre" value="<?php echo $row_Observaciones['Codigo_Observ'] ?>" />
            <input type="hidden" name="MM_insert" value="form8" />
            <input type="submit" value="Responder1"  onclick="this.disabled=true;this.form.submit();" />
        </form> <? } ?>   </td>
    <td align="rigth" valign="top" class="FondoCampo">
    <? //echo $MM_UserGroup;
	 if($MM_UserGroup == 91){ ?>
    <a href="/inc/Observacion.php?Area=<?php echo $_GET['Area'] ?>&Codigo=<?php echo $_GET['Codigo'] ?>&Elimina=<?php echo $row_Observaciones['Codigo_Observ'] ?>"><img src="/i/bullet_delete.png" width="26" height="16" border="0" /></a>
    <? } ?>
    </td>
    </tr>
<?php
		
		
		$query_Observaciones_HIJAS = "SELECT * FROM Observaciones 
									WHERE Codigo_Padre = '". $row_Observaciones['Codigo_Observ'] ."'
									AND Codigo_Propietario = $Codigo 
									ORDER BY Fecha_Creacion DESC";
		
		//echo $query_Observaciones_HIJAS;
		
		
		$Observaciones_HIJAS = $mysqli->query($query_Observaciones_HIJAS);
		//$row_Observaciones_HIJAS = $Observaciones_HIJAS->fetch_assoc();
		$totalRows_Observaciones_HIJAS = $Observaciones_HIJAS->num_rows;

		//echo $totalRows_Observaciones_HIJAS;
		if($totalRows_Observaciones_HIJAS > 0) {
		
			while ($row_Observaciones_HIJAS = $Observaciones_HIJAS->fetch_assoc()){ 
			
			  ?>
		 	 <tr valign="baseline">
			<td align="center" valign="top" nowrap="nowrap" class="FondoCampo"><?php echo DDMMAAAA($row_Observaciones_HIJAS['Fecha_Creacion']) ?></td>
			<td align="left" valign="top" nowrap="nowrap" class="FondoCampo"><?php echo substr($row_Observaciones_HIJAS['Por'],0,4) ?></td>
			<td align="left" valign="top" nowrap="nowrap" class="FondoCampo">&nbsp;</td>
			<td align="center" valign="top" nowrap="nowrap" class="FondoCampo">&nbsp;<? 
			//Frame_SW ("Codigo_Observ",$row_Observaciones_HIJAS['Codigo_Observ'],"Observaciones",'SW_Resuelto',$row_Observaciones_HIJAS['SW_Resuelto']);  ?> </td>


			<td align="left" valign="top" nowrap="nowrap" class="FondoCampo">&nbsp;</td>

			<td width="10" align="left" valign="top" nowrap="nowrap" class="FondoCampo"><img src="/i/arrow_right.png" width="16" height="16" alt=""/></td>
			<td align="left" valign="top" class="FondoCampo"><?php echo $row_Observaciones_HIJAS['Observacion'] ?>
			  </td>
			<td align="rigth" valign="top" class="FondoCampo">
			 <? //echo $MM_UserGroup;
				if($MM_UserGroup == 91){ ?>
			<a href="/inc/Observacion.php?Area=<?php echo $_GET['Area'] ?>&Codigo=<?php echo $_GET['Codigo'] ?>&Elimina=<?php echo $row_Observaciones_HIJAS['Codigo_Observ'] ?>"><img src="/i/bullet_delete.png" width="16" height="16" border="0" /></a>
			<? } ?>
			</td>
			
      </tr>
			<?php

		 	}
		 }
		
		
		
		
		
	
	 
	
 
 } while ($row_Observaciones = $Observaciones->fetch_assoc()); ?>
 
 
 
 
  </table>
</body>	
	
	
	
</html>