<?php 
$MM_authorizedUsers = "91,Contable";
require_once('../../../inc_login_ck.php'); 

require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 

// Elimina renglon EntradaSalida
if (isset($_GET['delete']) and $_GET['delete']=='Cal') {
	$Codigo = $_GET['Codigo'];
	$SQL = "DELETE FROM Empleado_EntradaSalida WHERE Codigo = '$Codigo'";
	$Result1 = mysql_query($SQL, $bd) or die(mysql_error());
	$DeleteGoTo = 'Empleado_Asist.php?CodigoEmpleado='.$_GET['CodigoEmpleado'];
	header(sprintf("Location: %s", $DeleteGoTo));
}

if (isset($_GET['SWasist']) and isset($_GET['CodigoEmpleado']) ) {
	if($_GET['SWasist']=='on')
		$SW_Asistencia = 1;
	else
		$SW_Asistencia = 0;
	$SQL = "UPDATE Empleado
			SET SW_Asistencia = '".$SW_Asistencia."'
			WHERE CodigoEmpleado = '".$_GET['CodigoEmpleado']."'";
	$Result1 = mysql_query($SQL, $bd) or die(mysql_error());
	$GoTo = 'Empleado_Asist.php?CodigoEmpleado='.$_GET['CodigoEmpleado'];
	header(sprintf("Location: %s", $GoTo));
}


$sql = "SELECT * FROM Empleado WHERE CodigoEmpleado = '".$_GET['CodigoEmpleado']."'";
$RS_Empleados = mysql_query($sql, $bd) or die(mysql_error());
$row_RS_Empleados = mysql_fetch_assoc($RS_Empleados);
extract($row_RS_Empleados);

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
    <td colspan="2" align="center"><table width="100%" border="0">
          <tr>
            <td colspan="8">
                       <table width="600" border="0" align="center">
  <tr>
    <td width="25%" nowrap="nowrap"><a href="Ficha_Datos.php?CodigoEmpleado=<?php echo $_GET['CodigoEmpleado'] ?>"> <img src="../../../i/client_account_template.png" width="32" height="32" border="0" align="absmiddle" /> Ficha</a></td>
    <td width="25%" nowrap="nowrap"><a href="Ficha_Asist.php?CodigoEmpleado=<?php echo $_GET['CodigoEmpleado'] ?>"><img src="../../../i/calendar_edit.png" width="32" height="32" border="0" align="absmiddle" />Asistencia</a></td>
    <td width="25%" nowrap="nowrap"><a href="Ficha_Fidei.php?CodigoEmpleado=<?php echo $_GET['CodigoEmpleado'] ?>"><img src="../../../i/sallary_deferrais.png" width="32" height="32" border="0" align="absmiddle" /> Fideicomiso</a></td>
    <td width="25%" nowrap="nowrap"><a href="Ficha_PagoDeduc.php?CodigoEmpleado=<?php echo $_GET['CodigoEmpleado'] ?>"><img src="../../../i/coins_in_hand.png" width="32" height="32" border="0" align="absmiddle" /> Pagos Deducciones</a></td>
  </tr>
</table>
<p>
  <?php 

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form4")) {
	
  $insertSQL = sprintf("INSERT INTO Empleado_EntradaSalida (Codigo_Empleado, Fecha, Hora, Obs, Registrado_Por) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['CodigoEmpleado'], "int"),
                       GetSQLValueString(F_hum_bd($_POST['Fecha']) , "text"),
                       GetSQLValueString($_POST['Hora'], "text"),
                       GetSQLValueString($_POST['Obs'], "text"),
                       GetSQLValueString($MM_Username, "text"));

  mysql_select_db($database_bd, $bd);
  $Result1 = mysql_query($insertSQL, $bd) or die(mysql_error());
}

$FechaInicio  = date('Y-m') . '-01';
$DDMMAAAA_Inicio = DiaN($FechaInicio).'-'.MesN($FechaInicio).'-'.AnoN($FechaInicio);
$Mes = Mes(date('m' , strtotime($DDMMAAAA_Inicio)));

$mes_siguiente  = 	mktime(0, 0, 0, 
					date("m", strtotime($DDMMAAAA_Inicio)) +1, 
					date("d", strtotime($DDMMAAAA_Inicio))   ,   
					date("Y", strtotime($DDMMAAAA_Inicio)))  ;

$FechaFin     = date('Y-m-d' , $mes_siguiente);

$CodigoEmpleado = $_GET['CodigoEmpleado'];
$sql = "SELECT * FROM Empleado_EntradaSalida WHERE 
		Codigo_Empleado = '$CodigoEmpleado' AND 
		Fecha >= '$FechaInicio' AND
		Fecha < '$FechaFin'
		ORDER BY Fecha DESC, Hora";
$RS = mysql_query($sql, $bd) or die(mysql_error());
$row = mysql_fetch_assoc($RS);


?>
</p>
<p>&nbsp;</p>
  <table width="700" align="center">
  <tr class="subtitle">
    <td colspan="4">Asistencia</td>
    <td align="right"><?php 
	if($SW_Asistencia){ ?>
      <a href="Ficha_Asist.php?CodigoEmpleado=<?php echo $_GET['CodigoEmpleado'] ?>&amp;SWasist=off">on</a><?php }else{?>
      <a href="Ficha_Asist.php?CodigoEmpleado=<?php echo $_GET['CodigoEmpleado'] ?>&amp;SWasist=on">off</a><?php } ?></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;
<form id="form4" name="form4" method="post" action="<?php echo $editFormAction; ?>">
<input name="Fecha" type="text" value="<?php 
if(isset($_POST['Fecha'])) 
	echo $_POST['Fecha'];
else 
	echo date('d-m-Y'); ?>" size="12" />
<input type="hidden" name="CodigoEmpleado" value="<?php echo $_GET['CodigoEmpleado']; ?>" />
<input name="Hora" type="text" value="12:00:00" size="12" />
<label for="select"></label>
<select name="Obs" id="select">
  <option value="Asist">Asisti&oacute;</option>
  <option value="Rep" <?php if($_POST['Obs']=='Rep') echo 'selected="selected"'; ?> >Reposo</option>
  <option value="Aus" <?php if($_POST['Obs']=='Aus') echo 'selected="selected"'; ?> >Ausente</option>
</select>
<input type="hidden" name="MM_insert" value="form4" />
<input type="submit" name="button3" id="button3" value="Submit" /></form>
    </td>
    </tr>
  <tr class="NombreCampo">
    <td colspan="2">&nbsp;Fecha</td>
    <td align="center">&nbsp;Hora</td>
    <td>Obs</td>
    <td>&nbsp;</td>
  </tr>
<?php do{ ?><tr <?php $sw = ListaFondo($sw,''); ?>>
    <td>&nbsp;<?php 
	if($FechaAnterior != $row['Fecha']){
		echo DDMMAAAA($row['Fecha']);}	 ?>
</td>
    <td align="<?php if($FechaAnterior == $row['Fecha']) echo "left"; else echo "right"; ?>"><?php 
	if($FechaAnterior != $row['Fecha']){
		echo "Entrada &gt;&gt;&gt;";}
		else{
		echo "&lt;&lt;&lt; Salida";}
	$FechaAnterior = $row['Fecha'];	 ?></td>
    <td align="center">&nbsp;<?php echo substr($row['Hora'],0,5); ?></td>
    <td><?php echo $row['Obs'].' '.$row['Registrado_Por'] ?></td>
    <td><a href="Ficha_Asist.php?CodigoEmpleado=<?php echo $_GET['CodigoEmpleado'] ?>&amp;delete=Cal&amp;Codigo=<?php echo $row['Codigo'] ?>"><img src="../../../i/bullet_delete.png" alt="" width="16" height="16" border="0" /></a></td>
</tr>
<?php }while($row = mysql_fetch_assoc($RS)); ?>
</table></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
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