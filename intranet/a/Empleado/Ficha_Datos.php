<?php 
$MM_authorizedUsers = "91,Contable";
require_once('../../../inc_login_ck.php'); 

require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php'); 
require_once('../../../inc/rutinas.php'); 

// Conectar
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) and ($_POST["MM_update"] == "form1") ) {  //and ($MM_UserGroup == 91 or $MM_UserGroup == 99)
	
	if($_POST['CodigoBarras']=='0000' or $_POST['CodigoBarras']=='000000000000' or $_POST['CodigoBarras']==''){
		$CodigoBarras = substr('0000'.$_POST['CodigoEmpleado'],-4).substr('000000000000'.$_POST['Cedula'],-8);
		}
	else
		$CodigoBarras = $_POST['CodigoBarras'];

if($_POST['TipoDocenteNEW']>'')	$TipoDocente = $_POST['TipoDocenteNEW'];
				else			$TipoDocente = $_POST['TipoDocente'];
	
if($_POST['TipoEmpleadoNEW']>'')	$TipoEmpleado = $_POST['TipoEmpleadoNEW'];
				else				$TipoEmpleado = $_POST['TipoEmpleado'];
	
  $updateSQL = sprintf("UPDATE Empleado SET Cedula=%s, CedulaLetra=%s, Rif=%s, Apellidos=%s, Nombres=%s, Apellido2=%s, Nombre2=%s, FechaNac=%s, FechaIngreso=%s, EdoCivil=%s, Dir1=%s, Dir2=%s, Dir3=%s, Dir4=%s, TelefonoHab=%s, TelefonoCel=%s, TelefonoOtro=%s, Email=%s, NumCuentaA=%s, NumCuenta=%s, Pagina=%s, PaginaCT=%s, Titulo=%s, TipoEmpleado=%s, TipoDocente=%s, CargoCorto=%s, Horas=%s, CargoLargo=%s, Observaciones=%s, Observaciones_admin=%s, Sexo=%s, BonifAdicCT=%s, NumHijos=%s, CodigoBarras=%s WHERE CodigoEmpleado=%s",
                       GetSQLValueString($_POST['Cedula'], "text"),
                       GetSQLValueString($_POST['CedulaLetra'], "text"),
                       GetSQLValueString($_POST['Rif'], "text"),
                       GetSQLValueString($_POST['Apellidos'], "text"),
                       GetSQLValueString($_POST['Nombres'], "text"),
                       GetSQLValueString($_POST['Apellido2'], "text"),
                       GetSQLValueString($_POST['Nombre2'], "text"),
                       GetSQLValueString(F_hum_bd($_POST['FechaNac']), "date"),
                       GetSQLValueString(F_hum_bd($_POST['FechaIngreso']), "date"),
                       GetSQLValueString($_POST['EdoCivil'], "text"),
                       GetSQLValueString($_POST['Dir1'], "text"),
                       GetSQLValueString($_POST['Dir2'], "text"),
                       GetSQLValueString($_POST['Dir3'], "text"),
                       GetSQLValueString($_POST['Dir4'], "text"),
                       GetSQLValueString($_POST['TelefonoHab'], "text"),
                       GetSQLValueString($_POST['TelefonoCel'], "text"),
                       GetSQLValueString($_POST['TelefonoOtro'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['NumCuentaA'], "text"),
                       GetSQLValueString($_POST['NumCuenta'], "text"),
                       GetSQLValueString($_POST['Pagina'], "int"),
                       GetSQLValueString($_POST['PaginaCT'], "int"),
                       GetSQLValueString($_POST['Titulo'], "text"),
                       GetSQLValueString($TipoEmpleado, "text"),
                       GetSQLValueString($TipoDocente, "text"),
                       GetSQLValueString($_POST['CargoCorto'], "text"),
                       GetSQLValueString($_POST['Horas'], "text"),
                       GetSQLValueString($_POST['CargoLargo'], "text"),
                       GetSQLValueString($_POST['Observaciones'], "text"),
                       GetSQLValueString($_POST['Observaciones_admin'], "text"),
                       GetSQLValueString($_POST['Sexo'], "text"),
					   GetSQLValueString(coma_punto($_POST['BonifAdicCT']), "double"),
                       GetSQLValueString($_POST['NumHijos'], "int"),
					   GetSQLValueString($CodigoBarras, "text"),
                       GetSQLValueString($_POST['CodigoEmpleado'], "int"));

  mysql_select_db($database_bd, $bd);
  $Result1 = mysql_query($updateSQL, $bd) or die(mysql_error());
}


/*
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2") and ($MM_UserGroup == 91 or $MM_UserGroup == 99)) {
	
	$QuincenaCompleta = explode ('-' , $_POST['QuincenaCompleta']);
	$Ano      = $QuincenaCompleta[0];
	$Mes      = substr('0'.$QuincenaCompleta[1],-2);
	$Quincena = $QuincenaCompleta[2];
	
  $insertSQL = sprintf("INSERT INTO Empleado_Deducciones (Codigo_Empleado, Tipo, Quincena, Mes, Ano, Descripcion, Monto, RegistradoPor, Fecha_Registro) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Codigo_Empleado'], "int"),
                       GetSQLValueString($_POST['Tipo'], "text"),
                       GetSQLValueString($Quincena, "text"),
                       GetSQLValueString($Mes, "text"),
                       GetSQLValueString($Ano, "text"),
                       GetSQLValueString($_POST['Descripcion'], "text"),
                       GetSQLValueString(coma_punto($_POST['Monto']), "double"),
                       GetSQLValueString($MM_Username, "text"),
					   GetSQLValueString(date('Y-m-d'), "text"));

  mysql_select_db($database_bd, $bd);
  $Result1 = mysql_query($insertSQL, $bd) or die(mysql_error());

  $insertGoTo = "Empleado_Edita.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
 // header(sprintf("Location: %s", $insertGoTo));
}
*/
/*
if (isset($_GET['Elimina']) and ($MM_UserGroup == 91 or $MM_UserGroup == 99)) {
  $Elimina = $_GET['Elimina'];
  $CodigoEmpleado = $_GET['CodigoEmpleado']+10000;
  $sql = 'UPDATE Empleado_Deducciones Set Codigo_Empleado='.$CodigoEmpleado.' WHERE Codigo = '.$Elimina ;
  //echo $sql;
  $Result = mysql_query($sql, $bd) or die(mysql_error());
  $GoTo = "Empleado_Edita.php?CodigoEmpleado=".$_GET['CodigoEmpleado'];
  header(sprintf("Location: %s", $GoTo));
}
*/


/*
if (isset($_POST['AdelantoFC']) and $_POST['AdelantoFC']>0) {
$Monto = coma_punto($_POST['AdelantoFC']);
	
$sql = "INSERT INTO Empleado_Deducciones (Codigo_Empleado, Tipo, Mes, Ano, Monto) 
VALUES ($colname_RS_Empleados, '55', '".date('m')."', '".date('Y')."', $Monto) ";

//echo $sql.'<br>';
echo mysql_query($sql, $bd) or die(mysql_error());
	
	}
*/

$colname_RS_Empleados = "-1";
if (isset($_GET['CodigoEmpleado'])) {
  $colname_RS_Empleados = $_GET['CodigoEmpleado'];
}
$query_RS_Empleados = sprintf("SELECT * FROM Empleado WHERE CodigoEmpleado = %s ORDER BY Apellidos ASC", GetSQLValueString($colname_RS_Empleados, "int"));
$RS_Empleados = mysql_query($query_RS_Empleados, $bd) or die(mysql_error());
$row_RS_Empleados = mysql_fetch_assoc($RS_Empleados);
$totalRows_RS_Empleados = mysql_num_rows($RS_Empleados);

/*
$query_RS_Empleados_Deduc = sprintf("SELECT * FROM Empleado_Deducciones 
									WHERE Codigo_Empleado = %s 
									AND (Tipo <> '50' AND Tipo <> '51') 
									ORDER BY Ano, Mes, Quincena", GetSQLValueString($colname_RS_Empleados, "int"));
$RS_Empleados_Deduc = mysql_query($query_RS_Empleados_Deduc, $bd) or die(mysql_error());
$row_RS_Empleados_Deduc = mysql_fetch_assoc($RS_Empleados_Deduc);
$totalRows_RS_Empleados_Deduc = mysql_num_rows($RS_Empleados_Deduc);
*/
/*
$query_RS_Fidei = sprintf( "SELECT * FROM Empleado_Deducciones 
							WHERE (Tipo >= '50' AND Tipo < '60') 
							AND Codigo_Empleado = %s  
							ORDER BY  Ano, Mes", GetSQLValueString($colname_RS_Empleados, "int"));
$RS_Fidei = mysql_query($query_RS_Fidei, $bd) or die(mysql_error());
$row_RS_Fidei = mysql_fetch_assoc($RS_Fidei);
$totalRows_RS_Fidei = mysql_num_rows($RS_Fidei);
  */
  
$ivss = round($row_RS_Empleados['SueldoBase'] * $row_RS_Empleados['SW_ivss'] * 0.04 ,2);
$lph  = round($row_RS_Empleados['SueldoBase'] * $row_RS_Empleados['SW_lph']  * 0.01 ,2); 
$spf  = round($row_RS_Empleados['SueldoBase'] * $row_RS_Empleados['SW_spf']  * 0.005 ,2);

$Sueldo = round($row_RS_Empleados['SueldoBase']*1-$ivss-$lph-$spf ,2); 
 

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
  <form action="<?php echo $editFormAction; ?>#<?php echo $i; ?>" method="post" name="form1" id="form1">
                         <table width="700" align="center">
                  <tr valign="baseline">
                    <td colspan="8" align="right" nowrap="nowrap" class="subtitle"><span class="FondoCampo">
                      <input type="hidden" name="CodigoFMP" value="<?php echo $row_RS_Empleados['CodigoFMP']; ?>" size="5" />
                    </span><a name="lista" id="<?php echo $i++; ?>"></a>
                      <input type="submit" value="Guardar" /></td>
                    </tr>
                  <tr valign="baseline">
                    <td align="right" valign="top" nowrap="nowrap" class="NombreCampo">Observaciones:<br />
                      <?php 
					  $foto = '../../FotoEmp/150/'.$row_RS_Empleados['CodigoEmpleado'].'.jpg';
					  if(file_exists($foto))
					  echo '<img src="'.$foto.'" width="150" height="150"/>';
					  //echo $foto;		
						?></td>
                    <td colspan="7" class="FondoCampo"><textarea name="Observaciones" cols="70" rows="8"><?php echo $row_RS_Empleados['Observaciones']; ?></textarea></td>
                	</tr>
                  
<?php if($MM_Username == 'piero'){ ?>                  
                  <tr valign="baseline">
                    <td align="right" valign="top" nowrap="nowrap" class="NombreCampo">Observaciones:<?php echo $MM_Username ?></td>
                    <td colspan="7" class="FondoCampo"><textarea name="Observaciones_admin" cols="70" rows="8"><?php echo $row_RS_Empleados['Observaciones_admin']; ?></textarea></td>
                  </tr>
                  <?php }else{ ?>
                  <input type="hidden" name="Observaciones_admin" value="<?php echo $row_RS_Empleados['Observaciones_admin']; ?>" />
                  <?php } ?>
<?php $Cedula = $row_RS_Empleados['Cedula'] ;
$CedulaLetra = $row_RS_Empleados['CedulaLetra'] ; ?>
                  <tr valign="baseline">
                    <td colspan="8" nowrap="nowrap" class="subtitle">Datos Personales</td>
                    </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="NombreCampo">Cedula:</td>
                    <td class="FondoCampo"><input type="text" name="CedulaLetra" value="<?php echo $row_RS_Empleados['CedulaLetra']; ?>" size="3" />
                      <input type="text" name="Cedula" value="<?php echo $row_RS_Empleados['Cedula']; ?>" size="10" />
                      <input name="Rif" type="text" id="Rif" value="<?php echo $row_RS_Empleados['Rif']; ?>" size="3" /></td>
                    <td align="right" class="NombreCampo">Fecha Ingreso:</td>
                    <td colspan="3" class="FondoCampo"><?php 
					//if($row_RS_Empleados['FechaIngreso']<'1900-01-01')
					Campo("FechaIngreso",'t',DDMMAAAA($row_RS_Empleados['FechaIngreso']),20,''); 
					//else
					//{	Campo("FechaIngreso",'h',DDMMAAAA($row_RS_Empleados['FechaIngreso']),20,''); 
					//	echo DDMMAAAA($row_RS_Empleados['FechaIngreso']);
					//}
					?></td>
                    <td align="right" nowrap="nowrap" class="NombreCampo">Sexo:</td>
                    <td class="FondoCampo"><select name="Sexo">
                      <option value="M" <?php if ("M"== $row_RS_Empleados['Sexo']) {echo "SELECTED";} ?>>M</option>
                      <option value="F" <?php if ("F"== $row_RS_Empleados['Sexo']) {echo "SELECTED";} ?>>F</option>
                      </select></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="NombreCampo">Apellidos:</td>
                    <td class="FondoCampo"><input type="text" name="Apellidos" value="<?php echo $row_RS_Empleados['Apellidos']; ?>" size="15" />
                    <input type="text" name="Apellido2" value="<?php echo $row_RS_Empleados['Apellido2']; ?>" size="15" /></td>
                    <td align="right" class="NombreCampo">FechaNac:</td>
                    <td colspan="3" class="FondoCampo"><input type="text" name="FechaNac" value="<?php echo F_bd_hum($row_RS_Empleados['FechaNac']); ?>" size="20" /></td>
                    <td align="right" nowrap="nowrap" class="NombreCampo">Edo Civil:</td>
                    <td class="FondoCampo"><select name="EdoCivil">
                      <option value="S" <?php if ("S"== $row_RS_Empleados['EdoCivil']) {echo "SELECTED";} ?>>S</option>
                      <option value="C" <?php if ("C"== $row_RS_Empleados['EdoCivil']) {echo "SELECTED";} ?>>C</option>
                      <option value="D" <?php if ("D"== $row_RS_Empleados['EdoCivil']) {echo "SELECTED";} ?>>D</option>
                    </select></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="NombreCampo">Nombres:</td>
                    <td class="FondoCampo"><input type="text" name="Nombres" value="<?php echo $row_RS_Empleados['Nombres']; ?>" size="15" />
                    <input type="text" name="Nombre2" value="<?php echo $row_RS_Empleados['Nombre2']; ?>" size="15" /></td>
                    <td align="right" class="NombreCampo">Email:</td>
                    <td colspan="3" class="FondoCampo"><input name="Email" type="text" id="Email" value="<?php echo $row_RS_Empleados['Email']; ?>" size="20" /></td>
                    <td align="right" class="NombreCampo">No. Hijos</td>
                    <td class="FondoCampo"><input type="text" name="NumHijos" value="<?php echo $row_RS_Empleados['NumHijos']; ?>" size="5" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td colspan="8" nowrap="nowrap" class="subtitle">Datos Laborales</td>
                    </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="NombreCampo">TipoEmpleado:</td>
                    <td class="FondoCampo">
<select name="TipoEmpleado" id="TipoEmpleado">
<option value="0">Seleccione...</option>
<?php 
// Ejecuta $sql
$sql = "SELECT * FROM Empleado
		WHERE SW_activo = '1'
		GROUP BY TipoEmpleado
		ORDER BY TipoEmpleado";

// Ejecuta $sql y While
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	extract($row);
	echo '<option value="'.$TipoEmpleado.'"';
	if($row_RS_Empleados['TipoEmpleado'] == $TipoEmpleado)
		echo ' selected="selected"';
	echo '>'.$TipoEmpleado.'</option>'."\r\n";
}
?>                        
</select>
<?php if($MM_Username == 'piero'){ ?>
<input name="TipoEmpleadoNEW" type="text" value="" size="15" />
<?php } ?>
                      </td>
                    <td align="right" class="NombreCampo">CargoLargo:</td>
                    <td colspan="3" class="FondoCampo">
<input type="text" name="CargoLargo" value="<?php echo $row_RS_Empleados['CargoLargo']; ?>" size="20" />
                    
                    </td>
                    <td align="right" class="NombreCampo">Pag Nom:</td>
                    <td class="FondoCampo">
                    
                    
<select name="Pagina" id="select">
<option>Seleccione</option>
<option value="1" <?php if($row_RS_Empleados['Pagina'] == 1) echo 'selected="selected"';  ?>>Profesor</option>
<option value="21" <?php if($row_RS_Empleados['Pagina'] == 21) echo 'selected="selected"';  ?>>Inicial Maestra</option>
<option value="22" <?php if($row_RS_Empleados['Pagina'] == 22) echo 'selected="selected"';  ?>>Inicial Auxiliar</option>
<option value="23" <?php if($row_RS_Empleados['Pagina'] == 23) echo 'selected="selected"';  ?>>Primaria Maestra</option>
<option value="3" <?php if($row_RS_Empleados['Pagina'] == 3) echo 'selected="selected"';  ?>>Admin</option>
<option value="4" <?php if($row_RS_Empleados['Pagina'] == 4) echo 'selected="selected"';  ?>>Mant</option>
<option value="5" <?php if($row_RS_Empleados['Pagina'] == 5) echo 'selected="selected"';  ?>>Ita y Otros</option>
<option value="6" <?php if($row_RS_Empleados['Pagina'] == 6) echo 'selected="selected"';  ?>>Directivo</option>
<option value="7" <?php if($row_RS_Empleados['Pagina'] == 7) echo 'selected="selected"';  ?>>TD</option>
</select></td>


                  </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="NombreCampo">TipoDocente:</td>
                    <td class="FondoCampo">
                    
<select name="TipoDocente" id="TipoDocente">
<option value=""<?php 
	if($row_RS_Empleados['TipoDocente'] == '')
		echo ' selected="selected"';
?>>Seleccione...</option>
<?php 
// Ejecuta $sql
$sql = "SELECT * FROM Empleado
		WHERE SW_activo = '1'
		AND TipoEmpleado = '$row_RS_Empleados[TipoEmpleado]'
		GROUP BY TipoDocente
		ORDER BY TipoDocente";

// Ejecuta $sql y While
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	extract($row);
	echo '<option value="'.$TipoDocente.'"';
	if($row_RS_Empleados['TipoDocente'] == $TipoDocente)
		echo ' selected="selected"';
	echo '>'.$TipoDocente.'</option>'."\r\n";
}
?>                        
</select>
<?php if($MM_Username == 'piero'){ ?>
<input name="TipoDocenteNEW" type="text" value="" size="15" /><?php } ?></td>
                    <td align="right" class="NombreCampo">CargoCorto:</td>
                    <td colspan="3" class="FondoCampo"><input type="text" name="CargoCorto" value="<?php echo $row_RS_Empleados['CargoCorto']; ?>" size="20" /></td>
                    <td align="right" class="NombreCampo">Pag CT:</td>
                    <td class="FondoCampo">
<select name="PaginaCT" id="select">
<option>Seleccione</option>
<option value="1" <?php if($row_RS_Empleados['PaginaCT'] == 1) echo 'selected="selected"';  ?>>Todos</option>
<option value="2" <?php if($row_RS_Empleados['PaginaCT'] == 2) echo 'selected="selected"';  ?>>Mant</option>
<option value="3" <?php if($row_RS_Empleados['PaginaCT'] == 3) echo 'selected="selected"';  ?>>TD</option>
</select>                    
                    </td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="NombreCampo">Titulo:</td>
                    <td class="FondoCampo"><input type="text" name="Titulo" value="<?php echo $row_RS_Empleados['Titulo']; ?>" size="30" /></td>
                    <td align="right" class="NombreCampo">&nbsp;</td>
                    <td class="FondoCampo">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="NombreCampo">&nbsp;</td>
                    <td class="FondoCampo">&nbsp;</td>
                    <td align="right" class="NombreCampo">&nbsp;</td>
                    <td class="FondoCampo">&nbsp;</td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="NombreCampo">SueldoBase:</td>
                    <td class="FondoCampo"><input type="hidden" name="SueldoBase" value="<?php echo $row_RS_Empleados['SueldoBase']; ?>" size="10" /> 
                      Neto: <?php //echo Fnum($Sueldo); ?></td>
                    <td align="right" class="NombreCampo">&nbsp;</td>
                    <td class="FondoCampo">&nbsp;</td>
                    <td align="right" class="NombreCampo">&nbsp;</td>
                    <td class="FondoCampo">&nbsp;</td>
                    <td align="right" class="NombreCampo">&nbsp;</td>
                    <td class="FondoCampo"><input name="Horas" type="hidden" id="Horas" value="<?php echo $row_RS_Empleados['Horas']; ?>" size="5" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="NombreCampo">NumCuenta:</td>
                    <td colspan="5" class="FondoCampo"><input type="text" name="NumCuentaA" value="<?php echo $row_RS_Empleados['NumCuentaA']; ?>" size="15" />
                      <input type="text" name="NumCuenta" value="<?php echo $row_RS_Empleados['NumCuenta']; ?>" size="15" /></td>
                    <td align="right" class="NombreCampo">&nbsp;</td>
                    <td class="FondoCampo">&nbsp;</td>
                  </tr>
                  <tr valign="baseline">
                    <td colspan="8" nowrap="nowrap" class="subtitle">Inf. Contacto</td>
                    </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="NombreCampo">Calle o Av.:</td>
                    <td class="FondoCampo"><input type="text" name="Dir1" value="<?php echo $row_RS_Empleados['Dir1']; ?>" size="30" /></td>
                    <td align="right" class="NombreCampo">TelefonoHab:</td>
                    <td colspan="3" class="FondoCampo"><input type="text" name="TelefonoHab" value="<?php echo $row_RS_Empleados['TelefonoHab']; ?>" size="20" /></td>
                    <td class="NombreCampo">&nbsp;</td>
                    <td class="FondoCampo">&nbsp;</td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="NombreCampo">Qta., Casa o Edif.:</td>
                    <td class="FondoCampo"><input type="text" name="Dir2" value="<?php echo $row_RS_Empleados['Dir2']; ?>" size="30" /></td>
                    <td align="right" class="NombreCampo">TelefonoCel:</td>
                    <td colspan="3" class="FondoCampo"><input type="text" name="TelefonoCel" value="<?php echo $row_RS_Empleados['TelefonoCel']; ?>" size="20" /></td>
                    <td class="NombreCampo">&nbsp;</td>
                    <td class="FondoCampo">&nbsp;</td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="NombreCampo">Urbanizaci&oacute;n:</td>
                    <td class="FondoCampo"><input type="text" name="Dir3" value="<?php echo $row_RS_Empleados['Dir3']; ?>" size="30" /></td>
                    <td align="right" class="NombreCampo">TelefonoOtro:</td>
                    <td colspan="3" class="FondoCampo"><input type="text" name="TelefonoOtro" value="<?php echo $row_RS_Empleados['TelefonoOtro']; ?>" size="20" /></td>
                    <td class="NombreCampo">&nbsp;</td>
                    <td class="FondoCampo">&nbsp;</td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="NombreCampo">Cod Postal:</td>
                    <td class="FondoCampo"><input type="text" name="Dir4" value="<?php echo $row_RS_Empleados['Dir4']; ?>" size="30" /></td>
                    <td align="right" class="NombreCampo">Cod Barras:</td>
                    <td colspan="3" class="FondoCampo"><input type="text" name="CodigoBarras" value="<?php echo $row_RS_Empleados['CodigoBarras']; ?>" size="20" /></td>
                    <td class="NombreCampo">&nbsp;</td>
                    <td class="FondoCampo">&nbsp;</td>
                  </tr>


                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td colspan="7"><div align="right">
                      <input type="submit" value="Guardar" />
                    </div></td>
                  </tr>
                </table>
                <input type="hidden" name="MM_update" value="form1" />
                <input type="hidden" name="CodigoEmpleado" value="<?php echo $row_RS_Empleados['CodigoEmpleado']; ?>" />
            </form>
            </div>
     </td>
          </tr>
          <tr>
            <td colspan="8" valign="top"></td>
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
<?php
//mysql_free_result($RS_Fidei);

mysql_free_result($RS_Empleados);
?>
