<?php 
require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php'); 
require_once('../../../inc/rutinas.php'); 

$MM_authorizedUsers = "91,Contable";
require_once('../../../inc_login_ck.php'); 

if(!TieneAcceso($Acceso_US,"Fideicomiso")){
	header("Location: ".$_SERVER['HTTP_REFERER']);
	}

if (isset($_POST['Buscar'])) {
	$aux = explode(" ",strtolower( $_POST['Buscar']));
	$query_RS_Empleados = "SELECT * FROM Empleado 
								WHERE SW_Activo = 1 ";
	$query_RS_Empleados .= "AND LOWER(CONCAT_WS(' ',Apellidos,Apellido2,Nombres,Nombre2)) LIKE '%$aux[0]%'";
	if($aux[1]!=""){
		$query_RS_Empleados .= " AND LOWER(CONCAT_WS(' ',Apellidos,Apellido2,Nombres,Nombre2)) LIKE '%$aux[1]%'";
		}
	if($aux[2]!=""){
		$query_RS_Empleados .= " AND LOWER(CONCAT_WS(' ',Apellidos,Apellido2,Nombres,Nombre2)) LIKE '%$aux[2]%'";
		}

$RS_Empleados = mysql_query($query_RS_Empleados, $bd) or die(mysql_error());
$row_RS_Empleados = mysql_fetch_assoc($RS_Empleados);
$totalRows_RS_Empleados = mysql_num_rows($RS_Empleados);
header("Location: ".$php_self."?CodigoEmpleado=".$row_RS_Empleados[CodigoEmpleado]);

	
	}	



// FIDEICOMISO
// Guarda monto 
if (isset($_POST['G'])) {
	$Monto = coma_punto($_POST['Monto']);
	$Codigo = $_POST['Codigo'];
	$SQL = "UPDATE Empleado_Pago SET Monto = '$Monto' WHERE Codigo = '$Codigo'";
	mysql_select_db($database_bd, $bd);
	$Result1 = mysql_query($SQL, $bd) or die(mysql_error());
}

// Elimina renglon Fid
if (isset($_GET['delete']) and $_GET['delete']=='Fid') {
	$Codigo = $_GET['Codigo'];
	$SQL = "DELETE FROM Empleado_Pago WHERE Codigo = '$Codigo'";
	mysql_select_db($database_bd, $bd);
	$Result1 = mysql_query($SQL, $bd) or die(mysql_error());
	$DeleteGoTo = 'Ficha_Fidei.php?CodigoEmpleado='.$_GET['CodigoEmpleado'];
	header(sprintf("Location: %s", $DeleteGoTo));
}



// FIDEICOMISO
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form5")) {
	
	$CodQuincena = $_POST['Fecha'];
	$CodQuincena = substr($CodQuincena,0,4).' '.substr($CodQuincena,5,2).' 3';
	
  $insertSQL = sprintf("INSERT INTO Empleado_Pago 
  						(Codigo_Empleado, Codigo_Quincena, Codigo_Fecha_Ejecutado, Concepto, Monto, Obs, Status, Fecha_Registro, Registro_por) VALUES
						(%s, %s, %s, '-Fideicomiso', %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['CodigoEmpleado'], "int"),
                       GetSQLValueString($CodQuincena , "text"),
                       GetSQLValueString($_POST['Fecha'] , "text"),
                       GetSQLValueString(coma_punto($_POST['Monto']), "double"),
                       GetSQLValueString($_POST['Motivo'].' / '.$_POST['Autorizado'].' / '.$MM_Username , "text"),
					   GetSQLValueString($_POST['Status'] , "text"),
					   GetSQLValueString(date('Y-m-d') , "text"),
					   GetSQLValueString($_POST['MM_Username'] , "text"));
					   
 
 if($_POST['Monto2'] > 0){
	 $AnoMes_corte = $_POST['QuincenaCompleta'];
	 
	 if($AnoMes_corte == "1990 01"){
		 $Desc = "Saldo Inicial Fideicomiso";}
	  else{
		 $Desc = "Corte Saldo Fideicomiso";
		 }
	 
	 
	 $insertSQL = sprintf("INSERT INTO Empleado_Pago 
		(Codigo_Empleado, Codigo_Quincena, Codigo_Fecha_Ejecutado, Concepto, Monto, Obs, Status, Fecha_Registro, Registro_por) VALUES
		(%s, %s, %s, '$Desc', %s, %s, %s, %s, %s)",
	   GetSQLValueString($_POST['CodigoEmpleado'], "int"),
	   GetSQLValueString($AnoMes_corte , "text"),
	   GetSQLValueString($_POST['Fecha'] , "text"),
	   GetSQLValueString(coma_punto($_POST['Monto2']), "double"),
	   GetSQLValueString($Desc, "text"),
	   GetSQLValueString("Eje" , "text"),
	   GetSQLValueString(date('Y-m-d') , "text"),
	   GetSQLValueString($_POST['MM_Username'] , "text"));
 }//
					   

  mysql_select_db($database_bd, $bd);
  $Result1 = mysql_query($insertSQL, $bd) or die(mysql_error());
}


$CodigoEmpleado = $_GET['CodigoEmpleado'];
$sql = "SELECT * FROM Empleado WHERE 
		CodigoEmpleado = '$CodigoEmpleado'";
$RS = mysql_query($sql, $bd) or die(mysql_error());
$row_RS_Empleados = mysql_fetch_assoc($RS);
$Cedula = $row_RS_Empleados['Cedula'];


$CodigoEmpleado = $_GET['CodigoEmpleado'];
$sql = "SELECT * FROM Empleado_Pago WHERE 
		Codigo_Empleado = '$CodigoEmpleado' AND 
		Concepto Like '%Fideicomiso%' 
		ORDER BY Codigo_Quincena";
$RS = mysql_query($sql, $bd) or die(mysql_error());
$row = mysql_fetch_assoc($RS);


?>   
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Administraci&oacute;n SFDA</title>
<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />
<script src="../../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script src="../../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />

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

.Azul { color: #00F; }

.Rojo { color: #F00; }
-->
</style>
<link href="../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" align="center">
  <tr>
    <td><?php   
	$TituloPantalla ="Empleados";
	require_once('../TitAdmin.php'); ?></td>
  </tr>
  
  
  <tr>
          <td colspan="2" nowrap="nowrap"><form id="form3" name="form3" method="post" action="<?php $php_self; ?>">
            <input type="text" name="Buscar" id="Buscar" />
            <input type="submit" name="submit" id="submit" value="Buscar" />
          </form></td>
        </tr>
        <tr>
          <td nowrap="nowrap" class="NombreCampoTITULO"><?php echo $row_RS_Empleados['Nombres'].' '.$row_RS_Empleados['Apellidos'] ?></td>
          <td align="right" nowrap="nowrap" class="NombreCampoTITULO">&nbsp;</td>
        </tr>
  
  
  
  
  
  <tr>
    <td colspan="2" align="center"><table width="100%" border="0">
          <tr>
            <td>
                       <table width="600" border="0" align="center">
  <tr>
    <td width="25%" nowrap="nowrap"><a href="Ficha_Datos.php?CodigoEmpleado=<?php echo $_GET['CodigoEmpleado'] ?>"> <img src="../../../i/client_account_template.png" width="32" height="32" border="0" align="absmiddle" /> Ficha</a></td>
    <td width="25%" nowrap="nowrap"><a href="Ficha_Asist.php?CodigoEmpleado=<?php echo $_GET['CodigoEmpleado'] ?>"><img src="../../../i/calendar_edit.png" width="32" height="32" border="0" align="absmiddle" />Asistencia</a></td>
    <td width="25%" nowrap="nowrap"><a href="Ficha_Fidei.php?CodigoEmpleado=<?php echo $_GET['CodigoEmpleado'] ?>"><img src="../../../i/sallary_deferrais.png" width="32" height="32" border="0" align="absmiddle" /> Fideicomiso</a></td>
    <td width="25%" nowrap="nowrap"><a href="Ficha_PagoDeduc.php?CodigoEmpleado=<?php echo $_GET['CodigoEmpleado'] ?>"><img src="../../../i/coins_in_hand.png" width="32" height="32" border="0" align="absmiddle" /> Pagos Deducciones</a></td>
  </tr>
</table>
            
<form id="form5" name="form5" method="post" action="">
<table width="700" border="0" align="center">
  <tr>
    <td colspan="6" class="subtitle">Fideicomiso</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap" class="NombreCampo">Motivo:</td>
    <td colspan="3" nowrap="nowrap" class="FondoCampo"><label for="Motivo"></label>
      <select name="Motivo" id="Motivo">
        <option value="No Especifico">Seleccione</option>
        <option value="Gastos Medicos">Gastos Medicos</option>
        <option value="Remodelacion">Remodelacion</option>
        <option value="Estudios">Estudios</option>
      </select></td>
    <td align="right" nowrap="nowrap" class="NombreCampo">Status:</td>
    <td nowrap="nowrap" class="FondoCampo"><table width="200">
      <tr>
        <td><label>
          <input name="Status" type="radio" id="Status_1" value="PP" checked="checked" />
          Por Procesar</label></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap" class="NombreCampo">Autoriz por:</td>
    <td colspan="3" nowrap="nowrap" class="FondoCampo"><input name="Autorizado" type="text" value="" size="20" /></td>
    <td align="right" nowrap="nowrap" class="NombreCampo">Ingresado por:
        <input type="hidden" name="Ejecutado" value="<?php echo $MM_Username ?>" />
    </td>
    <td nowrap="nowrap" class="FondoCampo"><strong><?php echo $MM_Username ?></strong></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap" class="NombreCampo">Monto:</td>
    <td colspan="3" nowrap="nowrap" class="FondoCampo"><span class="NombreCampo">
      <input name="Monto" type="text" value="" size="20" id="Monto" />
    </span></td>
    <td align="right" nowrap="nowrap" class="NombreCampo">Fecha:</td>
    <td nowrap="nowrap" class="FondoCampo"><span class="NombreCampo">
      <input name="Fecha" type="date" value="<?php echo date('Y-m-d'); ?>" size="12" />
    </span>
      <input type="hidden" name="CodigoEmpleado" value="<?php echo $_GET['CodigoEmpleado']; ?>" />
      <input type="hidden" name="MM_Username" value="<?php echo $MM_Username; ?>" />
      <input type="hidden" name="MM_insert" value="form5" /></td>
  </tr>
  
  <tr>
    <td colspan="6" align="left" nowrap="nowrap" class="subtitle">Corte de saldo</td>
    </tr>
<tr>
    <td align="right" nowrap="nowrap" class="NombreCampo">&nbsp;</td>
    <td colspan="3" nowrap="nowrap" class="FondoCampo">&nbsp;</td>
    <td align="right" nowrap="nowrap" class="NombreCampo">Haberes May 2016</td>
    <td nowrap="nowrap" class="FondoCampo">
    <?php 
/*	
	$sql2 = "SELECT * FROM Fideicomiso_SegunBanco WHERE 
		Cedula = '$Cedula'";
		//echo $sql;
$RS2 = mysql_query($sql2, $bd) or die(mysql_error());
if($row2 = mysql_fetch_assoc($RS2))
	extract($row2);   
echo $Haberes;
	$Haberes_2016_05 = $Haberes;*/
	?>
    </td>
  </tr>
    <tr>
    <td align="right" nowrap="nowrap" class="NombreCampo">Mes</td>
    <td colspan="3" nowrap="nowrap" class="FondoCampo">
    
    <select name="QuincenaCompleta" id="QuincenaCompleta">
                    <option value="1990 01">Seleccione</option>
                    <?php 			
					
					for ( $_Ano = $Ano1+2000; $_Ano <= $Ano2+2000; $_Ano++ ){
						for ( $_Mes = 1; $_Mes <= 12; $_Mes++ ){
								if($AnoAnte != $_Ano)
									echo'<option>------</option>';
						 		$Mesde = Mes($_Mes);
								$_Mes = substr("0".$_Mes,-2);
						 		$_Quincena = $_Ano.' '.$_Mes.'';
								echo '<option value="'.$_Quincena.'" ';
								
								echo '>'.$Mesde.' '.$_Ano.'</option>
								';
						 		if($_POST['QuincenaCompleta']==$_Quincena){ $Selected=true; }
						 		
						 		$AnoAnte = $_Ano; 
							}}
					?>
                  </select>
    
    </td>
    <td align="right" nowrap="nowrap" class="NombreCampo">Corte Saldo</td>
    <td nowrap="nowrap" class="FondoCampo"><span class="NombreCampo">
      <input name="Monto2" type="text" value="" size="20" id="Monto2" />
    </span></td>
  </tr>
  <tr>
    <td colspan="6" align="center" nowrap="nowrap" ><input type="submit" name="button3" id="button3" value="Guardar" />    </td>
    </tr>
</table>  
</form>
<table width="700" border="0" align="center">
  <tr>
    <td colspan="7" class="subtitle">Movimientos</td>
    </tr>
  <tr>
    <td width="80" align="center" class="NombreCampo">Quincena</td>
    <td class="NombreCampo">Motivo / Aut / Ope / (Status)</td>
    <td width="10" align="center" class="NombreCampo">&nbsp;</td>
    <td width="80" align="center" class="NombreCampo">Aporte</td>
    <td width="80" align="center" class="NombreCampo">Adelanto</td>
    <td width="80" align="center" class="NombreCampo">Saldo</td>
    <td align="center" class="NombreCampo">&nbsp;</td>
  </tr>
<?php do{ 
extract($row)
?>
<tr>
    <td nowrap="nowrap" <?php ListaFondo($sw,''); ?>>&nbsp;<?php echo $Codigo_Quincena; ?></td>
    <td nowrap="nowrap" <?php ListaFondo($sw,''); ?>><?php 
	if($Concepto != "+Fideicomiso" and $Concepto != "-Fideicomiso")
		echo $Concepto;
	else	
	if($Obs > '')
		echo $Obs.' ('.$Status.')'; ?></td>
    <td align="center" nowrap="nowrap" <?php ListaFondo($sw,''); ?>>&nbsp;
      <?php 
	if(substr($Concepto,0,1)=='-'){
		echo '-';
		$Adelanto = $Monto; $Aporte = 0;
	}else{
		echo '+';
		$Adelanto = 0; $Aporte = $Monto;}
	 ?>&nbsp;</td>
    <td align="right" nowrap="nowrap" <?php ListaFondo($sw,''); ?>>&nbsp;<?php echo Fnum($Aporte); $tot_Aportes += $Aporte; ?></td>
    <td align="right" nowrap="nowrap" <?php ListaFondo($sw,''); ?>>&nbsp;<?php echo Fnum($Adelanto); $tot_Adelantos += $Adelanto; ?>
    </td>
    <td align="right" nowrap="nowrap" <?php ListaFondo($sw,''); ?>>&nbsp;
      <?php 
	  
	if(substr($Concepto,0,1)=='-')
		$Monto = $Monto*-1;
	$SubTotal += $Monto; 
	if ($Obs == "Corte Saldo Fideicomiso")
		$SubTotal = $Monto;
	echo Fnum($SubTotal); ?>
    </td>
    
    <td align="right" nowrap="nowrap" <?php $sw = ListaFondo($sw,''); ?>><?php if ($Codigo_Fecha_Ejecutado==date('Y-m-d') or $MM_Username=='piero'){ ?><a href="Ficha_Fidei.php?CodigoEmpleado=<?php echo $_GET['CodigoEmpleado'] ?>&amp;delete=Fid&amp;Codigo=<?php echo $Codigo ?>">(-)</a><?php } ?>&nbsp;</td>
</tr>
<?php }while($row = mysql_fetch_assoc($RS)); ?>
<tr>
  <td align="right" class="NombreCampoBIG">&nbsp;</td>
  <td align="right" class="NombreCampoBIG">totales</td>
  <td align="right" class="NombreCampoBIG">&nbsp;</td>
  <td align="right" class="NombreCampoBIG"><?php echo $tot_Aportes; ?></td>
  <td align="right" class="NombreCampoBIG"><?php echo $tot_Adelantos; ?></td>
  <td align="right" class="NombreCampoBIG">&nbsp;</td>
  <td class="NombreCampoBIG">&nbsp;</td>
</tr>
<tr>
  <td align="right" class="NombreCampoBIG">&nbsp;</td>
  <td align="right" class="NombreCampoBIG">dif</td>
  <td align="right" class="NombreCampoBIG">&nbsp;</td>
  <td align="right" class="NombreCampoBIG"><?php if($Haberes_2016_05-$tot_Aportes > 1) echo $Haberes_2016_05-$tot_Aportes; ?></td>
  <td align="right" class="NombreCampoBIG">&nbsp;</td>
  <td align="right" class="NombreCampoBIG">&nbsp;</td>
  <td class="NombreCampoBIG">&nbsp;</td>
</tr>
<tr>
  <td colspan="5" align="right" class="NombreCampoBIG">&nbsp;<br>Disponible<br /> 
    &nbsp;</td>
  <td align="right" class="NombreCampoBIG">&nbsp;<br><?php 
	echo Fnum($SubTotal); ?>
    <br />
    &nbsp;</td>
  <td class="NombreCampoBIG">&nbsp;</td>
  </tr>
</table>  </td>
          </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
    </table></td>
  </tr>
</table>





<p align="center">&nbsp;</p>
<p align="center">&nbsp;</p>
<p align="center">&nbsp;</p>
<p align="center">&nbsp;</p>
<p align="center">&nbsp;</p>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>