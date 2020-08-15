<?php 
$MM_authorizedUsers = "91";
require_once('../../../inc_login_ck.php'); 

require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 



//$MM_UserGroup = $_SESSION['MM_UserGroup'];

$editFormAction = $_SERVER['PHP_SELF'];
//if (isset($_SERVER['QUERY_STRING'])) {
//  $editFormAction .= "?" . $_SERVER['QUERY_STRING']);
//}
  mysql_select_db($database_bd, $bd);

if ((isset($_POST["MM_update"])) and ($_POST["MM_update"] == "form1") and ($MM_UserGroup == 91 or $MM_UserGroup == 99) ) {
	
$SueldoBase = round($_POST['SueldoBase_1']+$_POST['SueldoBase_2']+$_POST['SueldoBase_3']+ (coma_punto($_POST['BsHrAcad'])*$_POST['HrAcad']*2) + (coma_punto($_POST['BsHrAdmi'])*$_POST['HrAdmi']*2) ,2) ;


$DiasSemana =  GetSQLValueString(isset($_POST['SW_Lun']) ? "true" : "", "defined","1","").
			   GetSQLValueString(isset($_POST['SW_Mar']) ? "true" : "", "defined","2","").
			   GetSQLValueString(isset($_POST['SW_Mie']) ? "true" : "", "defined","3","").
			   GetSQLValueString(isset($_POST['SW_Jue']) ? "true" : "", "defined","4","").
			   GetSQLValueString(isset($_POST['SW_Vie']) ? "true" : "", "defined","5","").
			   GetSQLValueString(isset($_POST['SW_Sab']) ? "true" : "", "defined","6","").
			   GetSQLValueString(isset($_POST['SW_Dom']) ? "true" : "", "defined","7","");
			   
	
  $updateSQL = sprintf("UPDATE Empleado SET SueldoBase=%s, SueldoBase_1=%s, SueldoBase_2=%s, SueldoBase_3=%s, SueldoBase_Extra=%s, BsHrAcad=%s, BsHrAdmi=%s, HrAcad=%s, HrAdmi=%s, SueldoBase_anterior=%s, Email=%s, SW_activo=%s, SW_Antiguedad=%s, SW_Lun=%s, SW_Mar=%s, SW_Mie=%s, SW_Jue=%s, SW_Vie=%s, SW_Sab=%s, SW_Dom=%s, DiasSemana='$DiasSemana', FormaDePago=%s, FechaIngreso=%s, FechaEgreso=%s, MensajeMarcaTarjeta=%s WHERE CodigoEmpleado=%s",
                       
                       GetSQLValueString($SueldoBase, "double"),
                       GetSQLValueString(coma_punto($_POST['SueldoBase_1']), "double"),
                       GetSQLValueString(coma_punto($_POST['SueldoBase_2']), "double"),
                       GetSQLValueString(coma_punto($_POST['SueldoBase_3']), "double"),
                       GetSQLValueString(coma_punto($_POST['SueldoBase_Extra']), "double"),
                       GetSQLValueString(coma_punto($_POST['BsHrAcad']), "double"),
                       GetSQLValueString(coma_punto($_POST['BsHrAdmi']), "double"),
                       GetSQLValueString(coma_punto($_POST['HrAcad']), "double"),
                       GetSQLValueString(coma_punto($_POST['HrAdmi']), "double"),
                       GetSQLValueString(coma_punto($_POST['SueldoBase_anterior']), "double"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString(isset($_POST['SW_activo']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['SW_Antiguedad']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['SW_Lun']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['SW_Mar']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['SW_Mie']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['SW_Jue']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['SW_Vie']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['SW_Sab']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['SW_Dom']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['FormaDePago'], "text"),
                       GetSQLValueString($_POST['FechaIngreso'], "text"),
                       GetSQLValueString($_POST['FechaEgreso'], "text"),
                       GetSQLValueString($_POST['MensajeMarcaTarjeta'], "text"),
                       GetSQLValueString($_POST['CodigoEmpleado'], "int"));

  //echo $updateSQL;
  //$Result1 = mysql_query($updateSQL, $bd) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $updateSQL = sprintf("INSERT INTO Empleado SET Cedula=%s, Apellidos=%s, Nombres=%s",
                       GetSQLValueString($_POST['Cedula'], "text"),
                       GetSQLValueString($_POST['Apellidos'], "text"),
                       GetSQLValueString($_POST['Nombres'], "text"));
  $Result1 = mysql_query($updateSQL, $bd) or die(mysql_error()); 
}


if(isset($_GET['Limit'])){
		$Limit=$_GET['Limit'];
		$addSQL =  " LIMIT $Limit , 25 ";}
	else{
		$addSQL =  " LIMIT 0 , 25 ";}
	
if(isset($_POST['Buscar'])){
	$Buscar = strtolower($_POST['Buscar']);
	$addSQL_1 =  " CONCAT_WS(' ', CodigoEmpleado, LOWER(Nombres), LOWER(Apellidos), LOWER(Nombre2), LOWER(Apellido2), LOWER(TipoEmpleado), LOWER(TipoDocente), LOWER(CargoCorto), LOWER(CargoLargo), Cedula ) LIKE '%".$Buscar."%'   ";
	if(isset($_POST['SW_activo']))
		$addSQL_1 .= " AND SW_activo = '1' ";
	}
else {	$addSQL_1 =  " SW_activo = '1' ";
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
		//if(($i==25 or $i==50 or $i==75 or $i==100) and $clave=='')
		//	$Grupo[$i] = $Emp[$i][Apellidos];
		//echo "$clave => $valor \n <br>";
	}
	$i=$i+1;	
} while ($row_RS_Empleados = mysql_fetch_assoc($RS_Empleados));


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Administraci&oacute;n SFDA</title>
<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
<script src="../../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script src="../../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />

<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />
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
<link href="../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" align="center">
  <tr>
    <td><?php   
	$TituloPantalla ="Empleados";
	require_once('../TitAdmin.php'); ?>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><table width="100%" border="0" cellpadding="2">
        <tr>
            <td colspan="2" class="NombreCampoTopeWin"><a href="index.php">Ver todos</a> |
             <a href="Update_all.php">Edita todos</a> | 
             <a href="../BK/Nomina_Transf.php" target="_blank">Nomina Tranf </a>| 
             <a href="PDF/Recibo_Pago.php?Quincena=<?php if(date('d')<=15) echo '1ra'; else echo '2da'; ?>&amp;AnoMes=<?php echo date('Y-m') ?>" target="_blank">Recibos de Pago</a> | 
             <a href="archivo/BonoAlim/Bono_<?php echo date('Y_m') ?>.csv">Archivo Bono Alim</a> | 
             <a href="../Empleado_Lista_pdf.php" target="_blank">Lista Empleados</a> | 
             <a href="../Empleado_Recibo_Utilidades.php" target="_blank">Recibos de Util/Agui</a> | 
             <a href="PDF/Nomina_Fideicomiso.php" target="_blank">Fideicomiso</a> | 
             <a href="PDF/Nomina_Fideicomiso_Anual.php?AnoMes=<?php echo date('Y') ?>" target="_blank">Fideicomiso anual</a> | 
             <a href="../BK/Fideicomiso_Adelanto.php">Adelantos Fidei</a> | <a href="../archivo">Archivos</a><br />
            <a href="PDF/Fotos.php">Lista Fotos</a> | 
            <a href="PDF/Ficha_Empleado.php">Lista Fichas</a> | 
            <a href="PDF/Asistencia_General.php?Inicio=<?php echo date('Y-m'); ?>" target="_blank"> Asistencia</a> | <a href="Asistencia_General.php?Inicio=<?php echo date('Y-m'); ?>" target="_blank">Asistencia pantalla</a><br />
            <a href="PDF/Ficha_Empleado2.php">Lista pdf</a> | <a href="PDF/Empleado_xls.php">Lista Excel</a> | 
          <a href="../Carnet_Empleado.php">Carnets Empleados</a></td>
        </tr>
        <tr>
          <td width="50%" nowrap="nowrap"><form id="form3" name="form3" method="post" action="<?php echo $_SERVER['../PHP_SELF']; ?>">
            
            <input name="Buscar" type="text" id="Buscar" value="<?php echo $_POST['Buscar'] ?>" />
            <input name="SW_activo" type="checkbox" id="checkbox2" checked="checked" /> activo
<input type="submit" name="button" id="button" value="Buscar" />
          </form></td>
          <td width="50%" align="right" nowrap="nowrap">
          <a href="index.php?Limit=<?php echo '0'; ?>">Primero</a> | 
          <a href="index.php?Limit=<?php if($_GET['Limit']>25) echo $_GET['Limit']-25; else echo '0'; ?>">Anterior</a> |
          
          <?php do{ 
		  if($_GET['Limit'] == $k*25) echo '<b>'.$k*25 .' </b>| ';
		  else{
		  ?>
          
          <a href="index.php?Limit=<?php echo $k*25;  ?>"><?php 
		  	$kj = $k*25; 
			echo $kj; 
			//echo $Emp[$kj][Apellidos];
			?></a> |  
          
          <?php }
		  $k++;
		  }while($k*25 <= 100); ?>
          
          <a href="index.php?Limit=<?php  echo $_GET['Limit']+25; ?>">Siguiente</a> | 
          <a href="index.php?Limit=<?php  echo $totalRows_RS_Empleados-25; ?>">Ultimo</a></td>
        </tr>
        <?php $Limit = $_GET['Limit'];  ?>
        <?php 
		$i=0;

		do { 
		//extract ($row_RS_Empleados);
		 $class = ' class="';
		 if($_GET['Linea']== $i+1) {
			 $class .= "FondoCampoVerde"; }
		 elseif($par){
			 $class .= "ListadoInPar12"; 
			 $par = false;}
			 	else {
					$class .= "ListadoPar12"; 
					$par=true; } 
					$class .= '" ';
		 
		 ?>

        
          
          <tr><?php $Limit = $Limit+1; ?>
            <td colspan="2" align="left" nowrap bgcolor="#FFFFFF" >



<form action="<?php echo $editFormAction; ?>?Limit=<?php echo $Limit-1; ?>&Linea=1" method="post" name="form1" id="form1">

<table width="100%" border="0" >
<tr>
      <td colspan="3" align="left"  nowrap  class="NombreCampoBIG"><a href="Ficha_Datos.php?CodigoEmpleado=<?php echo $Emp[$i][CodigoEmpleado]; ?>" target="_blank" ><img src="../../../i/client_account_template.png" width="32" height="32" border="0" align="middle" /> <?php echo $Emp[$i][Apellidos]; ?>, <?php echo $Emp[$i][Nombres]; ?></a></td>
      <td colspan="2" align="right"  nowrap  class="NombreCampoBIG"><b>
        <label for="Email">Email</label>
        <input name="Email" type="text" id="Email" value="<?php echo $Emp[$i][Email] ?>" size="50" />
      </b></td>
      </tr>
<tr><td width="100" rowspan="5" align="center" valign="top" <?php echo $class ?>><a name="<?php echo $i ?>" id="Linea2"></a>&nbsp;<a href="../Sube_Foto.php?Tipo=Empleado&amp;Codigo=<?php echo $Emp[$i][CodigoEmpleado] ?>" target="_blank"><img src="../../../FotoEmp/150/<?php echo $Emp[$i][CodigoEmpleado]; ?>.jpg"height="150" border="0" /> </a></td>
  <td width="95" nowrap="nowrap" <?php echo $class ?>>Activo:</td>
  <td colspan="2" nowrap="nowrap" <?php echo $class ?>><strong>
    <input type="checkbox" name="SW_activo" value=""  <?php if (!(strcmp($Emp[$i][SW_activo],"1"))) {echo "checked=\"checked\"";} ?> />
  </strong>Cargo: <?php echo $Emp[$i][TipoEmpleado].' / '.$Emp[$i][TipoDocente].' /'.$Emp[$i][CargoLargo].' / '.$Emp[$i][CargoCorto].' / '.$Emp[$i][HorarioTrab] ; ?><a href="../Horario_Adm_Prof.php?Cedula_Prof=<?php echo $Emp[$i][Cedula] ?>" target="_blank"> (Horario)</a></td>
<td width="131" rowspan="6" align="left" valign="top" nowrap="nowrap" <?php echo $class ?>><p><a href="PDF/Recibo_Pago.php?CodigoEmpleado=<?php echo $Emp[$i][CodigoEmpleado]; ?>&amp;Quincena=<?php if(date('d')<=15) echo '1ra'; else echo '2da'; ?>" target="_blank">Recibo N&oacute;m<br />
  </a><a href="PDF/Recibo_Utilidades.php?CodigoEmpleado=<?php echo $Emp[$i][CodigoEmpleado] ?>" target="_blank">
    Recibo Utilid/Aguin<br />
    </a><a href="PDF/Carnet.php?CodigoEmpleado=<?php echo $Emp[$i][CodigoEmpleado] ?>" target="_blank">Carnet</a></p>
  <p>&nbsp;</p>
  <p>
    <input type="hidden" name="MM_update" value="form1" />
    <?php 
  
  //if($Emp[$i][SueldoBase]>0 and $Emp[$i][SueldoBase_anterior]>0) 
  	//	echo round(($Emp[$i][SueldoBase]/$Emp[$i][SueldoBase_anterior])*100-100 , 2).'%'; 


		Campo('CodigoEmpleado' , 'h' , $Emp[$i][CodigoEmpleado] , 6,''); 
		Campo('SueldoBase' , 'h' , $Emp[$i][SueldoBase] , 6,''); 
		Campo('MontoDeducciones' , 'h' , $Emp[$i][MontoDeducciones] , 6,''); 
		Campo('HorarioTrab' , 'h' , $Emp[$i][HorarioTrab] , 6,''); 
		Campo('TipoEmpleado' , 'h' , $Emp[$i][TipoEmpleado] , 6,''); 
		Campo('TipoDocente' , 'h' , $Emp[$i][TipoDocente] , 6,''); 
		Campo('Pagina' , 'h' , $Emp[$i][Pagina] , 6,''); 
		Campo('PagoDesde' , 'h' , $Emp[$i][PagoDesde] , 6,''); 
		
		
		
		
?>
    <strong><a href="Ficha_Datos.php?CodigoEmpleado=<?php echo $Emp[$i][CodigoEmpleado]; ?>" target="_blank">
      <?php 
  Campo('SW_activoBK' , 'h' , $Emp[$i][SW_activoBK] , 6,'');
?>
      </a></strong>
    <input type="submit" value="Guardar" />
    <br />
  </p></td></tr>
  <tr>
    <td align="left" <?php echo $class ?>>Sueldo: </td>
    <td align="left" <?php echo $class ?>><?php 
	  	echo $Emp[$i][SueldoBase_anterior].' -> ';
		Campo('SueldoBase_anterior' , 'h' , $Emp[$i][SueldoBase_anterior] , 6,''); 
		echo 'S1:';
		$SueldoConAumento = round($Emp[$i][SueldoBase_anterior] * 1.36 , 2);
		Campo('SueldoBase_1' , 't' , $Emp[$i][SueldoBase_1] , 6, $Emp[$i][SueldoBase_1]==0?'onfocus="this.value='.$SueldoConAumento.'"':'' ); 
	  	
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
				$sql = "SELECT * FROM Horario 
						WHERE Cedula_Prof = '".$Emp[$i][Cedula]."' 
						AND Dia_Semana ='".$j."'";
				$RS_sql = mysql_query($sql, $bd) or die(mysql_error());
				$HrDia[$j] = mysql_num_rows($RS_sql)*1; }
			}
		else 
			$HrDia = '';
		
		if ($HrAcadHorario>0 or $HrAdmiHorario>0 or true){
		echo ' + S2:';
		Campo('SueldoBase_2' , 't' , $Emp[$i][SueldoBase_2] , 6,''); 
        echo ' + S3';
		Campo('SueldoBase_3' , 't' , $Emp[$i][SueldoBase_3] , 6,''); 
		echo ' + (';
		Campo('HrAcad' , 't' , $Emp[$i][HrAcad] , 3,''); 
		if($HrAcadHorario<>$Emp[$i][HrAcad]) echo '<b>'.$HrAcadHorario.'</b>';
		echo 'x';
		Campo('BsHrAcad' , 't' , $Emp[$i][BsHrAcad] , 3,''); 
		echo ') + (';
		Campo('HrAdmi' , 't' , $Emp[$i][HrAdmi] , 3,''); 
	    if($HrAdmiHorario<>$Emp[$i][HrAdmi]) echo '<b>'.$HrAdmiHorario.'</b>';
		echo 'x';
		Campo('BsHrAdmi' , 't' , $Emp[$i][BsHrAdmi] , 3,''); 
		echo ') = ';
		Campo('SueldoBase_Extra' , 'h' , $Emp[$i][SueldoBase_Extra] , 6,''); 
		 } ?>
      <?php if($Emp[$i][SueldoBase]>0) echo Fnum($Emp[$i][SueldoBase]); ?>  (<?php 
	  if ($Emp[$i][SW_ivss]=="1") {echo " IVSS ";} 
	  if ($Emp[$i][SW_lph]=="1") {echo " LPH ";} 
	  if ($Emp[$i][SW_spf]=="1") {echo " SPF ";} 
	  ?>) </td>
    <td align="right" <?php echo $class ?>>&nbsp;<b><?php //echo round((($Emp[$i][SueldoBase]/$Emp[$i][SueldoBase_anterior])-1)*100 , 2); ?>
        <label for="FormaDePago"></label>
        <select name="FormaDePago" id="FormaDePago">
          <option value="">Forma de Pago</option>
          <option value="E" <?php if ($Emp[$i][FormaDePago]=="E") {echo ' selected="selected" ';}?>>Efectivo</option>
          <option value="C" <?php if ($Emp[$i][FormaDePago]=="C") {echo ' selected="selected" ';}?>>Cheque</option>
          <option value="T" <?php if ($Emp[$i][FormaDePago]=="T") {echo ' selected="selected" ';}?>>Transferencia</option>
        </select>
    </b></td>
    </tr>
  <tr>
    <td align="left" <?php echo $class ?>>Fecha Ingreso:<br /></td>
    <td align="left" <?php echo $class ?>><?php Campo('FechaIngreso' , 'd' , $Emp[$i][FechaIngreso] , 12,'');  ?> Egreso: <?php Campo('FechaEgreso' , 'd' , $Emp[$i][FechaEgreso] , 12,'');  ?></td>
    <td align="left" <?php echo $class ?>><input type="checkbox" name="SW_Antiguedad"  <?php if ($Emp[$i][SW_Antiguedad]=="1") {echo "checked=\"checked\"";} ?> />
      Fideicomiso</td>
    </tr>
  <tr>
    <td align="left" <?php echo $class ?>>Horario:</td>
    <td align="left" <?php echo $class ?>><?php
//echo $Emp[$i][DiasSemana];
Campo('DiasSemana' , 'h' , $Emp[$i][DiasSemana] , 6,''); 

	
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
        
          <td width="40" align="center"<?php 
		  if($HrDia[1]>0 and !$Emp[$i][SW_Lun]) 
		  	echo ' bgcolor="#FF0000"'; ?>>
            <input name="SW_Lun" type="checkbox" id="checkbox" <?php echo $Emp[$i][SW_Lun]?'checked="checked"':''; ?> /><br>Lu
			<?php echo '<br>'.$HrDia[1]; ?></td>
            
          <td width="40" align="center"<?php 
		  if($HrDia[2]>0 and !$Emp[$i][SW_Mar]) 
		  	echo ' bgcolor="#FF0000"'; ?>>
            <input name="SW_Mar" type="checkbox" id="checkbox" <?php echo $Emp[$i][SW_Mar]?'checked="checked"':''; ?> /><br>Ma
			<?php echo '<br>'.$HrDia[2]; ?></td>
            
          <td width="40" align="center"<?php 
		  if($HrDia[3]>0 and !$Emp[$i][SW_Mie])
		  	echo ' bgcolor="#FF0000"'; ?>>
            <input name="SW_Mie" type="checkbox" id="checkbox" <?php echo $Emp[$i][SW_Mie]?'checked="checked"':''; ?> /><br>Mi
			<?php echo '<br>'.$HrDia[3]; ?></td>
            
          <td width="40" align="center"<?php 
		  if($HrDia[4]>0 and !$Emp[$i][SW_Jue])
		  	echo ' bgcolor="#FF0000"'; ?>>
            <input name="SW_Jue" type="checkbox" id="checkbox" <?php echo $Emp[$i][SW_Jue]?'checked="checked"':''; ?> /><br>Ju
			<?php echo '<br>'.$HrDia[4]; ?></td>
            
          <td width="40" align="center"<?php 
		  if($HrDia[5]>0 and !$Emp[$i][SW_Vie])
		  	echo ' bgcolor="#FF0000"'; ?>>
            <input name="SW_Vie" type="checkbox" id="checkbox" <?php echo $Emp[$i][SW_Vie]?'checked="checked"':''; ?> /><br>Vi
			<?php echo '<br>'.$HrDia[5]; ?></td>
            
          <td width="40" align="center"<?php 
		  if($HrDia[6]>0 and !$Emp[$i][SW_Sab])
		  	echo ' bgcolor="#FF0000"'; ?>>
            <input name="SW_Sab" type="checkbox" id="checkbox" <?php echo $Emp[$i][SW_Sab]?'checked="checked"':''; ?> /><br>Sa
			<?php echo '<br>'.$HrDia[6]; ?></td>
            
          <td width="40" align="center"<?php 
		  if($HrDia[7]>0 and !$Emp[$i][SW_Dom])
		  	echo ' bgcolor="#FF0000"'; ?>>
            <input name="SW_Dom" type="checkbox" id="checkbox" <?php echo $Emp[$i][SW_Dom]?'checked="checked"':''; ?> /><br>Do
			<?php echo '<br>'.$HrDia[7]; ?></td>
            
          <td>&nbsp;
            <?php 
if($tot_Semanal>0 and $Emp[$i][HrAcad]>0){ 
	$PromDiario = round( $tot_Semanal / $CantDias , 2);
	echo $tot_Semanal.'/sem'; echo ' (prom/dia: '. $PromDiario .')'; 
} ?></td>
          </tr>
            
        <?php  // ?>
      </table>    </td>
    <td align="right" <?php echo $class ?>><a href="../archivo/ci/<?= $Emp[$i][Cedula] ?>.jpg" target="_blank"><img src="../archivo/ci/100/<?= $Emp[$i][Cedula] ?>.jpg" width="100"  /></a></td>
    </tr>
  <tr>
    <td align="left" <?php echo $class ?>>Mensaje</td>
    <td colspan="2" align="left" <?php echo $class ?>><label for="MensajeMarcaTarjeta"></label>
      <input name="MensajeMarcaTarjeta" type="text" value="<?= $Emp[$i][MensajeMarcaTarjeta] ?>" size="150" /></td>
    </tr>
</table>

</form>
            </td>
          </tr>
             
          <?php 
		  $i=$i+1;
		  } while ($Emp[$i][CodigoEmpleado] > 0); ?>
        <tr>
            <td colspan="2" align="left" nowrap class="FondoCampo">
<form action="<?php echo $editFormAction; ?>?Linea=<?php echo ++$i ?>#<?php echo $i ?>" method="post" name="form2" id="form2">

                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td><input type="hidden" name="SW_activo" value="1"   />
                                      Crear Empleado</td>
                                    <td nowrap="nowrap">
                                    C.I.
                                      <input type="text" name="Cedula" value="" size="10" />
                                      Apellidos
                                      <input type="text" name="Apellidos" value="" size="10" />
                                      Nombres:
                                      <input type="text" name="Nombres" value="" size="10" />
                                    <input type="submit" value="Crear" /></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td nowrap="nowrap"><input type="hidden" name="CodigoEmpleado" value="" />
                                      <input type="hidden" name="MM_insert" value="form2" /></td>
                                    <td>&nbsp;</td>
                                  </tr>
                                </table>
          </form>       </td>
          </tr>
    </table></td>
  </tr>
</table>


<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>


</body>
</html>
<?php
mysql_free_result($RS_Empleados);
?>
