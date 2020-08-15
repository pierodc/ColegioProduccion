<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,admin";
require_once('../../inc_login_ck.php'); 

require_once('../../Connections/bd.php'); 
require_once('../../inc/rutinas.php'); 


$MM_UserGroup = $_SESSION['MM_UserGroup'];

$editFormAction = $_SERVER['PHP_SELF'];
//if (isset($_SERVER['QUERY_STRING'])) {
//  $editFormAction .= "?" . $_SERVER['QUERY_STRING']);
//}
  mysql_select_db($database_bd, $bd);

if ((isset($_POST["MM_update"])) and ($_POST["MM_update"] == "form1")) {
	

$DiasSemana =  GetSQLValueString(isset($_POST['SW_Lun']) ? "true" : "", "defined","1","").
			   GetSQLValueString(isset($_POST['SW_Mar']) ? "true" : "", "defined","2","").
			   GetSQLValueString(isset($_POST['SW_Mie']) ? "true" : "", "defined","3","").
			   GetSQLValueString(isset($_POST['SW_Jue']) ? "true" : "", "defined","4","").
			   GetSQLValueString(isset($_POST['SW_Vie']) ? "true" : "", "defined","5","").
			   GetSQLValueString(isset($_POST['SW_Sab']) ? "true" : "", "defined","6","").
			   GetSQLValueString(isset($_POST['SW_Dom']) ? "true" : "", "defined","7","");
			   
	
  $updateSQL = sprintf("UPDATE Empleado SET SW_cestaT=%s, DiasSemana=%s, BonifAdicCT=%s, MontoCestaT=%s, DiasInasistencia=%s, ObservacionesCestaT=%s, SW_Lun=%s, SW_Mar=%s, SW_Mie=%s, SW_Jue=%s, SW_Vie=%s, SW_Sab=%s, SW_Dom=%s, DiasSemana='$DiasSemana' WHERE CodigoEmpleado=%s",
                       
                       GetSQLValueString(isset($_POST['SW_cestaT']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['DiasSemana'], "text"),
                       GetSQLValueString(coma_punto($_POST['BonifAdicCT']), "double"),
                       GetSQLValueString(coma_punto($_POST['MontoCestaT']), "double"),
                       GetSQLValueString($_POST['DiasInasistencia'], "text"),
                       GetSQLValueString($_POST['ObservacionesCestaT'], "text"),
                       GetSQLValueString(isset($_POST['SW_Lun']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['SW_Mar']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['SW_Mie']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['SW_Jue']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['SW_Vie']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['SW_Sab']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['SW_Dom']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['CodigoEmpleado'], "int"));

  //echo $updateSQL;
  $Result1 = mysql_query($updateSQL, $bd) or die(mysql_error());
}



if(isset($_GET['Limit'])){
	$Limit=$_GET['Limit'];
	$addSQL =  " LIMIT $Limit , 25 ";}
	else{
	$addSQL =  " LIMIT 0 , 25 ";}
	
if(isset($_POST['Buscar'])){
	$addSQL_1 =  " CONCAT_WS(' ', CodigoEmpleado, LOWER(Nombres), LOWER(Apellidos), LOWER(TipoEmpleado), LOWER(TipoDocente), LOWER(CargoCorto), LOWER(CargoLargo) ) LIKE '%".$_POST['Buscar']."%'   ";
	if(isset($_POST['SW_activo']))
		$addSQL_1 .= " AND SW_activo = '1' ";
	}
else {	$addSQL_1 =  " SW_activo=1 ";
	}
	
$query_RS_Empleados = "SELECT * FROM Empleado WHERE $addSQL_1 ORDER BY Apellidos, Nombres $addSQL";
//echo $query_RS_Empleados;
$RS_Empleados = mysql_query($query_RS_Empleados, $bd) or die(mysql_error());
$row_RS_Empleados = mysql_fetch_assoc($RS_Empleados);
$totalRows_RS_Empleados = mysql_num_rows($RS_Empleados);

$i=0;
do{
while (list($clave, $valor) = each($row_RS_Empleados)) {
	$Emp[$i][$clave] = 	$valor;
//	echo "$clave => $valor \n <br>";
}
$i=$i+1;	
} while ($row_RS_Empleados = mysql_fetch_assoc($RS_Empleados));

//$RS_Empleados = mysql_query($query_RS_Empleados, $bd) or die(mysql_error());
//$row_RS_Empleados = mysql_fetch_assoc($RS_Empleados);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Administraci&oacute;n SFDA</title>

<script src="../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />

<link href="../../estilos.css" rel="stylesheet" type="text/css" />
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script src="../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />

<link href="../../estilos2.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
a:link {
	color: #0000FF;
	text-decoration: none;
}
-->
</style>

<style type="text/css">
<!--
.style1 {
	font-size: 18px;
	font-family: "Times New Roman", Times, serif;
	color: #000066;
}
.style3 {font-size: 12px}
a:visited {
	color: #0000FF;
	text-decoration: none;
}
a:hover {
	color: #CCCC00;
	text-decoration: underline;
}
a:active {
	color: #FF0000;
	text-decoration: none;
}
-->
</style>
<link href="../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" align="center">
  <tr>
    <td><?php 
	$TituloPantalla = 'Empleados';
	require_once('TitAdmin.php'); ?>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><table width="100%" border="0" cellpadding="2">
        <tr>
          <td colspan="2" nowrap="nowrap" class="NombreCampoTopeWin"><a href="Empleado_BonoAlim_Lista.php">Ver todos</a> | <a href="Lista/Empleado_Nomina_BonoAlim.php?AnoMes=<?php echo date('Y-m') ?>" target="_blank">N&oacute;mina Bono Alim</a> | <a href="archivo/BonoAlim/Bono_<?php echo date('Y_m') ?>.csv">Archivo Bono Alim</a>| <a href="Lista/Empleado_Asistencia.php?Inicio=2012-<?php echo date('m'); ?>">Asistencia
          </a><br />
          <a href="Lista/Empleado_pdf.php">Lista pdf</a></td>
        </tr>
        <tr>
          <td width="50%" nowrap="nowrap"><form id="form3" name="form3" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            
            <input name="Buscar" type="text" id="Buscar" value="<?php echo $_POST['Buscar'] ?>" />
            <input name="SW_activo" type="checkbox" id="checkbox2" checked="checked" />
activo
<input type="submit" name="button" id="button" value="Buscar" />
          </form></td>
          <td width="50%" align="right" nowrap="nowrap">
          <a href="Empleado_BonoAlim_Lista.php?Limit=<?php echo '0'; ?>">Primero</a> | 
          <a href="Empleado_BonoAlim_Lista.php?Limit=<?php if($_GET['Limit']>10) echo $_GET['Limit']-10; else echo '0'; ?>">Anterior</a> |
          
          <?php do{ 
		  if($_GET['Limit'] == $k*25) echo '<b>'.$k*25 .' </b>| ';
		  else{
		  ?>
          
          <a href="Empleado_BonoAlim_Lista.php?Limit=<?php echo $k*25;  ?>"><?php echo $k*25; ?></a> |  
          
          <?php }
		  $k++;
		  }while($k*25 <= 100); ?>
          
          <a href="Empleado_BonoAlim_Lista.php?Limit=<?php  echo $_GET['Limit']+25; ?>">Siguiente</a> | 
          <a href="Empleado_BonoAlim_Lista.php?Limit=<?php  echo $totalRows_RS_Empleados-25; ?>">Ultimo</a></td>
        </tr>
        <tr>
            <td colspan="2" align="left" nowrap class="FondoCampo<?php if($_GET['Linea']== $i) {echo "Verde"; }  ?>"></td>
          </tr><?php $Limit = $_GET['Limit'];  ?>
        <?php 
		$i=0;

		do { 
		//extract ($row_RS_Empleados);
		?>

        
          <tr><?php $Limit = $Limit+1; ?>
            <td colspan="2" align="left" nowrap class="<?php 
			
			if($_GET['Linea']== $i+1) {
				echo "FondoCampoVerde"; }
				elseif($par){
					echo "ListadoPar"; 
					$par=false;}
				else{
					echo "ListadoInPar"; 
					$par=true;}  ?>">



<form action="<?php echo $editFormAction; ?>?Limit=<?php echo $Limit-1; ?>&Linea=1" method="post" name="form1" id="form1">

<table width="100%" border="1" cellpadding="1" cellspacing="0">
<tr>
  <td width="5" rowspan="3" align="center" valign="top"><img src="../../FotoEmp/<?php echo $Emp[$i][CodigoEmpleado]; ?>.jpg" alt="" width="83" height="124" /></td>
  <td width="59" nowrap="nowrap" >Activo:</td>
  <td width="59" nowrap="nowrap" bgcolor="<?php if (!(strcmp($Emp[$i][SW_activo],"1"))) {echo "#33CC00";} else {echo "#CC3300";} ?>" ><strong><a href="Empleado_Edita.php?CodigoEmpleado=<?php echo $Emp[$i][CodigoEmpleado]; ?>" target="_blank">
    <input type="checkbox" name="SW_activo" value=""  <?php if (!(strcmp($Emp[$i][SW_activo],"1"))) {echo "checked=\"checked\"";} ?> />
  </a></strong></td>
<td nowrap="nowrap" ><strong>
  <a href="Empleado_Edita.php?CodigoEmpleado=<?php echo $Emp[$i][CodigoEmpleado]; ?>" target="_blank">
    <input type="hidden" name="Cedula" value="<?php echo $Emp[$i][Cedula]; ?>" size="10" />
    <input type="hidden" name="Apellidos" value="<?php echo $Emp[$i][Apellidos]; ?>" size="10" /><?php echo $Emp[$i][Apellidos]; ?>, 
    <input type="hidden" name="Nombres" value="<?php echo $Emp[$i][Nombres]; ?>" size="10" /><?php echo $Emp[$i][Nombres]; ?></a></strong>&nbsp;<br />
  Cargo: <?php echo ' <a href="Horario_Adm_Prof.php?Cedula_Prof='.$Emp[$i][Cedula].'" target="_blank">'.$Emp[$i][CargoCorto].' / '.$Emp[$i][TipoEmpleado].' / '.$Emp[$i][TipoDocente].' /'.$Emp[$i][HorarioTrab].'</a>' ; ?>&nbsp;</td>
<td width="80" rowspan="5" align="left" valign="bottom" nowrap="nowrap"><br />
  <input type="hidden" name="MM_update" value="form1" />      
  <?php 
  
  //if($Emp[$i][SueldoBase]>0 and $Emp[$i][SueldoBase_anterior]>0) 
  	//	echo round(($Emp[$i][SueldoBase]/$Emp[$i][SueldoBase_anterior])*100-100 , 2).'%'; 


		Campo('CodigoEmpleado' , 'h' , $Emp[$i][CodigoEmpleado] , 6,''); 
		Campo('HorarioTrab' , 'h' , $Emp[$i][HorarioTrab] , 6,''); 
		
		
		
		
Campo('SueldoBaseBK' , 'h' , $Emp[$i][SueldoBaseBK] , 6,'');
?>      <strong><a href="Empleado_Edita.php?CodigoEmpleado=<?php echo $Emp[$i][CodigoEmpleado]; ?>" target="_blank">
      <?php 
  Campo('SW_activoBK' , 'h' , $Emp[$i][SW_activoBK] , 6,'');
?>
      </a></strong>      <input type="submit" value="Guardar" /></td></tr>
  <tr>
    <td align="left" nowrap="nowrap">Bono Alim: </td>
    <td align="left" nowrap="nowrap"><input type="checkbox" name="SW_cestaT" value=""  <?php if (!(strcmp($Emp[$i][SW_cestaT],"1"))) {echo "checked=\"checked\"";} ?> /></td>
    <td align="left" nowrap="nowrap">por d&iacute;a: 
      <input name="MontoCestaT" type="text" id="MontoCestaT" value="<?php echo $Emp[$i][MontoCestaT]; ?>" size="4" />
      Inas:      
      <input name="DiasInasistencia" type="text" id="DiasInasistencia" value="<?php echo $Emp[$i][DiasInasistencia]; ?>" size="1" />
      Obser.:      
      <input name="ObservacionesCestaT" type="text" id="ObservacionesCestaT" value="<?php echo $Emp[$i][ObservacionesCestaT]; ?>" size="3" />
      Adic: 
      <input name="BonifAdicCT" type="text" id="BonifAdicCT" value="<?php echo $Emp[$i][BonifAdicCT]; ?>" size="4" />
      
      <input type="hidden" name="CargoCorto" value="<?php echo $Emp[$i][CargoCorto]; ?>" size="5" />
      <input type="hidden" name="Horas" value="<?php echo $Emp[$i][Horas]; ?>" size="2" />
      <input type="hidden" name="MesesLaborados" value="<?php echo $Emp[$i][MesesLaborados]; ?>" size="4" /></td>
    </tr>

  <tr>
    <td align="left">Horario:</td>
    <td colspan="2" align="left"><?php
//echo $Emp[$i][DiasSemana];
Campo('DiasSemana' , 'h' , $Emp[$i][DiasSemana] , 6,''); 


		$sql = "SELECT * FROM Horario WHERE Cedula_Prof = '".$Emp[$i][Cedula]."' AND Descripcion <> '200'";
		$RS_sql = mysql_query($sql, $bd) or die(mysql_error());
		$row_RS_sql = mysql_fetch_assoc($RS_sql);
		$HrAcadHorario = mysql_num_rows($RS_sql);
		
		$sql = "SELECT * FROM Horario WHERE Cedula_Prof = '".$Emp[$i][Cedula]."' AND Descripcion = '200'";
		$RS_sql = mysql_query($sql, $bd) or die(mysql_error());
		$row_RS_sql = mysql_fetch_assoc($RS_sql);
		$HrAdmiHorario = mysql_num_rows($RS_sql);
		
		if($HrAcadHorario>0 or $HrAdmiHorario>0){
			for($j = 1; $j <= 5; $j++){
		$sql = "SELECT * FROM Horario WHERE Cedula_Prof = '".$Emp[$i][Cedula]."' AND Dia_Semana ='".$j."'";
		$RS_sql = mysql_query($sql, $bd) or die(mysql_error());
		$HrDia[$j] = mysql_num_rows($RS_sql);
		}}else $HrDia = '';



	
  $DiasSemana = ceil($HrDia[1]/1000)+ceil($HrDia[2]/1000)+ceil($HrDia[3]/1000)+ceil($HrDia[4]/1000)+ceil($HrDia[5]/1000);
  $DiasSemana='';
  for($j = 1; $j <= 5; $j++)
  if(ceil($HrDia[$j]/1000) > 0) $DiasSemana .= $j;
  //echo $DiasSemana;

  
  $tot_Semanal = $HrDia[1]+$HrDia[2]+$HrDia[3]+$HrDia[4]+$HrDia[5]; 
  
  $CantDias=0;
  for($j = 1; $j <= 5; $j++)
  	$CantDias += $HrDia[$j]>0?1:0;
 
  ?>
      <table border="1" cellspacing="0">
        <tr>
          <td width="40" align="center">
            <input name="SW_Lun" type="checkbox" id="checkbox" <?php echo $Emp[$i][SW_Lun]?'checked="checked"':''; ?> /><br>Lu</td>
          <td width="40" align="center">
            <input name="SW_Mar" type="checkbox" id="checkbox" <?php echo $Emp[$i][SW_Mar]?'checked="checked"':''; ?> /><br>Ma</td>
          <td width="40" align="center">
            <input name="SW_Mie" type="checkbox" id="checkbox" <?php echo $Emp[$i][SW_Mie]?'checked="checked"':''; ?> /><br>Mi</td>
          <td width="40" align="center">
            <input name="SW_Jue" type="checkbox" id="checkbox" <?php echo $Emp[$i][SW_Jue]?'checked="checked"':''; ?> /><br>Ju</td>
          <td width="40" align="center">
            <input name="SW_Vie" type="checkbox" id="checkbox" <?php echo $Emp[$i][SW_Vie]?'checked="checked"':''; ?> /><br>Vi</td>
          <td width="40" align="center">
            <input name="SW_Sab" type="checkbox" id="checkbox" <?php echo $Emp[$i][SW_Sab]?'checked="checked"':''; ?> /><br>Sa</td>
          <td width="40" align="center">
            <input name="SW_Dom" type="checkbox" id="checkbox" <?php echo $Emp[$i][SW_Dom]?'checked="checked"':''; ?> /><br>Do</td>
          <td>&nbsp;
            <?php //echo $Emp[$i][DiasSemana] ?></td>
          </tr>
        <?php if($tot_Semanal>0 and $Emp[$i][HrAcad]>0){ 
  $PromDiario = round( $tot_Semanal / $CantDias , 2);

?>          
        <tr>
          <td align="center"<?php 
		  if(($HrDia[1]>0 and !$Emp[$i][SW_Lun]) or ($HrDia[1]==0 and $Emp[$i][SW_Lun])) 
		  	echo ' bgcolor="#FF0000"'; ?>>
            <?php echo $HrDia[1]; ?></td>
          <td align="center"<?php 
		  if(($HrDia[2]>0 and !$Emp[$i][SW_Mar]) or ($HrDia[2]==0 and $Emp[$i][SW_Mar])) 
		  	echo ' bgcolor="#FF0000"'; ?>>
            <?php echo $HrDia[2]; ?></td>
          <td align="center"<?php 
		  if(($HrDia[3]>0 and !$Emp[$i][SW_Mie]) or ($HrDia[3]==0 and $Emp[$i][SW_Mie])) 
		  	echo ' bgcolor="#FF0000"'; ?>>
            <?php echo $HrDia[3]; ?></td>
          <td align="center"<?php 
		  if(($HrDia[4]>0 and !$Emp[$i][SW_Jue]) or ($HrDia[4]==0 and $Emp[$i][SW_Jue])) 
		  	echo ' bgcolor="#FF0000"'; ?>>
            <?php echo $HrDia[4]; ?></td>
          <td align="center"<?php 
		  if(($HrDia[5]>0 and !$Emp[$i][SW_Vie]) or ($HrDia[5]==0 and $Emp[$i][SW_Vie])) 
		  	echo ' bgcolor="#FF0000"'; ?>>
            <?php echo $HrDia[5]; ?></td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td>&nbsp;<?php echo $tot_Semanal.'/sem'; echo ' (prom/dia: '. $PromDiario .')'; ?></td>
          </tr>
        <?php  } ?>
      </table></td>
    </tr>

</table>

</form>


               </td>
          </tr>
            
          <?php 
		  $i=$i+1;
		  } while ($Emp[$i][CodigoEmpleado] > 0); ?>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2" align="left" nowrap class="FondoCampo">
<form action="<?php echo $editFormAction; ?>?Linea=<?php echo ++$i ?>#<?php echo $i ?>" method="post" name="form2" id="form2">
</form>       </td>
          </tr>
    </table></td>
  </tr>
</table>


</body>
</html>
<?php
mysql_free_result($RS_Empleados);
?>
