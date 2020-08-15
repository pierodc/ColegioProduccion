<?php 
$MM_authorizedUsers = "91,Contable";
require_once('../../../inc_login_ck.php'); 

require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php'); 
require_once('../../../inc/rutinas.php'); 

if(!TieneAcceso($Acceso_US,"Sueldo")){
	header("Location: ".$_SERVER['HTTP_REFERER']);
	}

if(isset($_POST['Descripcion'])){
	setcookie("Descripcion",$_POST['Descripcion'],time()+1200);
	setcookie("Tipo",$_POST['Tipo'],time()+1200);
	setcookie("Monto",$_POST['Monto'],time()+1200);
	}
$Descripcion = $_COOKIE["Descripcion"];
$Tipo  = $_COOKIE["Tipo"];
$Monto = $_COOKIE["Monto"];



$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if (isset($_POST["DiasInasistencia"]) and ($MM_UserGroup == 91)) {
	 $updateSQL = "UPDATE Empleado 
	 				SET DiasInasistencia= '".$_POST['DiasInasistencia']."', 
					BonifAdicCT= '".$_POST['BonifAdicCT']."'
					WHERE CodigoEmpleado = ".$_POST['CodigoEmpleado'];
	//echo $updateSQL;
	mysql_select_db($database_bd, $bd);
	mysql_query($updateSQL, $bd);
}

/*
if ((isset($_POST["MM_update"])) and ($_POST["MM_update"] == "form1") and ($MM_UserGroup == 91 or $MM_UserGroup == 99)) {

$SueldoBase = round($_POST['SueldoBase_1']+$_POST['SueldoBase_2']+$_POST['SueldoBase_3']+ (coma_punto($_POST['BsHrAcad'])*$_POST['HrAcad']*2) + (coma_punto($_POST['BsHrAdmi'])*$_POST['HrAdmi']*2) ,2) ;
	
	
  $updateSQL = sprintf("UPDATE Empleado SET SueldoBase=%s, Observaciones=%s, HrAcad=%s, BsHrAcad=%s, HrAdmi=%s, BsHrAdmi=%s, SueldoBase_1=%s, SueldoBase_2=%s, SueldoBase_3=%s, SW_ivss=%s, SW_lph=%s, SW_spf=%s WHERE CodigoEmpleado=%s",
                       GetSQLValueString($SueldoBase, "double"),
                       GetSQLValueString($_POST['Observaciones'], "text"),
                       GetSQLValueString(coma_punto($_POST['HrAcad']), "double"),
                       GetSQLValueString(coma_punto($_POST['BsHrAcad']), "double"),
                       GetSQLValueString(coma_punto($_POST['HrAdmi']), "double"),
                       GetSQLValueString(coma_punto($_POST['BsHrAdmi']), "double"),
                       GetSQLValueString(coma_punto($_POST['SueldoBase_1']), "double"),
                       GetSQLValueString(coma_punto($_POST['SueldoBase_2']), "double"),
                       GetSQLValueString(coma_punto($_POST['SueldoBase_3']), "double"),
                       GetSQLValueString(isset($_POST['SW_ivss']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['SW_lph']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['SW_spf']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['CodigoEmpleado'], "int"));

  mysql_select_db($database_bd, $bd);
  //$Result1 = mysql_query($updateSQL, $bd) or die(mysql_error());
}*/



if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2") and ($MM_UserGroup == 'Contable' or $MM_UserGroup == 91)) {
	
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

  $insertGoTo = "Empleado_PagoDeduc.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
 // header(sprintf("Location: %s", $insertGoTo));
}

if (isset($_GET['Elimina']) and ($MM_UserGroup == 'Contable' or $MM_UserGroup == 91)) {
  $Elimina = $_GET['Elimina'];
  $CodigoEmpleado = $_GET['CodigoEmpleado']+10000;
  $sql = 'UPDATE Empleado_Deducciones Set Codigo_Empleado='.$CodigoEmpleado.' WHERE Codigo = '.$Elimina ;
  //echo $sql;
  $Result = mysql_query($sql, $bd) or die(mysql_error());
  $GoTo = $php_self."?CodigoEmpleado=".$_GET['CodigoEmpleado'];
  header(sprintf("Location: %s", $GoTo));
}

/*
if (isset($_POST['AdelantoFC']) and $_POST['AdelantoFC']>0) {
	$Monto = coma_punto($_POST['AdelantoFC']);
		
	$sql = "INSERT INTO Empleado_Deducciones (Codigo_Empleado, Tipo, Mes, Ano, Monto) 
			VALUES ($colname_RS_Empleados, '55', '".date('m')."', '".date('Y')."', $Monto) ";
	
	echo mysql_query($sql, $bd) or die(mysql_error());
}
*/

$colname_RS_Empleados = "-1";
if (isset($_GET['CodigoEmpleado'])) {
  $colname_RS_Empleados = $_GET['CodigoEmpleado'];
}
$query_RS_Empleados = sprintf("SELECT * FROM Empleado 
										WHERE CodigoEmpleado = %s 
										ORDER BY Apellidos ASC", 
										GetSQLValueString($colname_RS_Empleados, "int"));
										
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
$RS_Empleados = mysql_query($query_RS_Empleados, $bd) or die(mysql_error());
$row_RS_Empleados = mysql_fetch_assoc($RS_Empleados);
$totalRows_RS_Empleados = mysql_num_rows($RS_Empleados);

$Monto = $row_RS_Empleados['SueldoBase_3']*3;

$colname_RS_Empleados = $row_RS_Empleados[CodigoEmpleado];

$query_RS_Empleados_Deduc = sprintf("SELECT * FROM Empleado_Deducciones 
											WHERE Codigo_Empleado = %s 
											AND (Tipo <> '50' AND Tipo <> '51') 
											ORDER BY Ano, Mes, Quincena", 
											GetSQLValueString($colname_RS_Empleados, "int"));
if(isset($_GET['Salario'])){
	$query_RS_Empleados_Deduc = "SELECT * FROM Empleado_Pago 
								WHERE Codigo_Empleado = '$colname_RS_Empleados' 
								AND Concepto = '+SueldoBase'
								ORDER BY Codigo_Quincena";
 //echo $query_RS_Empleados_Deduc;
}
	
if(isset($_GET['Pagos'])){
	$query_RS_Empleados_Deduc = "SELECT * FROM Empleado_Pago 
								WHERE Codigo_Empleado = '$colname_RS_Empleados' 
								AND Monto > 0
								ORDER BY Codigo_Quincena";
 //echo $query_RS_Empleados_Deduc;
}
		
											
$RS_Empleados_Deduc = mysql_query($query_RS_Empleados_Deduc, $bd) or die(mysql_error());
$row_RS_Empleados_Deduc = mysql_fetch_assoc($RS_Empleados_Deduc);
$totalRows_RS_Empleados_Deduc = mysql_num_rows($RS_Empleados_Deduc);

/*
$query_RS_Fidei = sprintf( "SELECT * FROM Empleado_Deducciones 
							WHERE (Tipo >= '50' AND Tipo < '60') 
							AND Codigo_Empleado = %s  
							ORDER BY  Ano, Mes", 
							GetSQLValueString($colname_RS_Empleados, "int"));
$RS_Fidei = mysql_query($query_RS_Fidei, $bd) or die(mysql_error());
$row_RS_Fidei = mysql_fetch_assoc($RS_Fidei);
$totalRows_RS_Fidei = mysql_num_rows($RS_Fidei);
  */

$ivss = $row_RS_Empleados['SueldoBase'] * $row_RS_Empleados['SW_ivss'] * 0.04 ;
$lph  = $row_RS_Empleados['SueldoBase'] * $row_RS_Empleados['SW_lph']  * 0.01 ; 
$spf  = $row_RS_Empleados['SueldoBase'] * $row_RS_Empleados['SW_spf']  * 0.005 ;
$SueltoNeto = round($row_RS_Empleados['SueldoBase'] - $ivss - $lph - $spf,2) ; 
$SueldoDiario = round($SueltoNeto/15 , 2 );	


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">

<title>Pago <?php echo $row_RS_Empleados['Apellidos'].' '.$row_RS_Empleados['Nombres'] ?></title>
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
<table width="100%" border="0" align="center">
  <tr>
    <td><?php   
	$TituloPantalla ="Empleados";
	require_once('../TitAdmin.php'); ?></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><table width="100%" border="0">
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
            <td colspan="2">
            <table width="600" border="0" align="center">
  <tr>
    <td width="25%" nowrap="nowrap"><a href="Ficha_Datos.php?CodigoEmpleado=<?php echo $_GET['CodigoEmpleado'] ?>"> <img src="../../../i/client_account_template.png" width="32" height="32" border="0" align="absmiddle" /> Ficha</a></td>
    <td width="25%" nowrap="nowrap"><a href="Ficha_Asist.php?CodigoEmpleado=<?php echo $_GET['CodigoEmpleado'] ?>"><img src="../../../i/calendar_edit.png" width="32" height="32" border="0" align="absmiddle" />Asistencia</a></td>
    <td width="25%" nowrap="nowrap"><a href="Ficha_Fidei.php?CodigoEmpleado=<?php echo $_GET['CodigoEmpleado'] ?>"><img src="../../../i/sallary_deferrais.png" width="32" height="32" border="0" align="absmiddle" /> Fideicomiso</a></td>
    <td width="12%" nowrap="nowrap"><a href="Ficha_PagoDeduc.php?CodigoEmpleado=<?php echo $_GET['CodigoEmpleado'] ?>"><img src="../../../i/coins_in_hand.png" width="32" height="32" border="0" align="absmiddle" /> Pagos Deducciones</a></td>
   
   
    <td width="13%" nowrap="nowrap"><a href="Ficha_PagoDeduc.php?CodigoEmpleado=<?php echo $_GET['CodigoEmpleado'] ?>&Salario=1"><img src="../../../i/coins_in_hand.png" width="32" height="32" border="0" align="absmiddle" /> Salario</a></td>
    
    <td width="13%" nowrap="nowrap"><a href="Ficha_PagoDeduc.php?CodigoEmpleado=<?php echo $_GET['CodigoEmpleado'] ?>&Pagos=1"><img src="../../../i/coins_in_hand.png" width="32" height="32" border="0" align="absmiddle" /> Pagos</a></td>
    
    <td width="13%" nowrap="nowrap"><a href="Ficha_PagoDeduc.php?CodigoEmpleado=<?php echo $_GET['CodigoEmpleado'] ?>&BC=1"><img src="../../../i/coins_in_hand.png" width="32" height="32" border="0" align="absmiddle" /> BC</a></td>
    
    
    
  </tr>
</table>

<form id="form2" name="form2" method="POST" action="<?php echo $editFormAction; ?>">
<table width="100%" border="0" align="center">
                           <tr>
                  <td colspan="12">
                  <?php 
				  
				  $sql = "SELECT * FROM Empleado_EntradaSalida
							WHERE Codigo_Empleado = $colname_RS_Empleados
							AND Obs <> 'Asist'
							AND SW_Consolidado = 0
							AND Registrado_Por <> 'Ph'
							ORDER BY Obs, Fecha ";
		//echo $sql;
		$RS = $mysqli->query($sql);
		
if( $RS->num_rows > 0){			  
				  ?>
                  <table width="300" border="1" align="center">
                      <tbody>
                        <tr>
                          <td>Ausencias </td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <?php 
						$Dias_Ausente = "";
						while ($row = $RS->fetch_assoc()) {
							extract($row);
							$Dias_Ausente[$N_Dias++] = substr(DDMMAAAA($Fecha) , 0 , 5);
							//echo substr(DDMMAAAA($Fecha) , 0 , 5);
									
						?>
                        <tr>
                          <td><?php echo $Obs; $DiasAus = $DiasAus . "  " . substr($Obs,0,2)." "; ?>&nbsp;</td>
                          <td><?php echo DDMMAAAA($Fecha); ?>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <?php } 
						if($Fecha > "0000-00-00")
						foreach($Dias_Ausente as $DiaMes){
							$Dias_Aus = $Dias_Aus. " / ".$DiaMes ;
							}
						//echo $Dias_Aus."<br>";	
						$Dias_Aus = substr($Dias_Aus , 3 , strlen($Dias_Aus));
						//$Dias_Aus = substr($Dias_Aus , 3 , strlen($Dias_Aus)+3);
						$Dias_Aus = $Dias_Aus . "-" .substr($Fecha,0,4);
						//echo $Dias_Aus."<br><br>";	
						
						?>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                      </tbody>
                    </table><?php } ?></td>
              </tr>
                           <tr>
                             <td colspan="12"><form id="formCT" name="formCT" method="POST" action="<?php echo $editFormAction; ?>"><table width="400" border="1" align="center">
  <tbody>
    <tr>
      <td colspan="2">&nbsp;</td>
      </tr>
    <tr>
      <td>Dias Ausencia </td>
      <td><input name="DiasInasistencia" type="text" id="DiasInasistencia" value="<?php echo $row_RS_Empleados['DiasInasistencia']; ?>" size="3" />
        <?php echo $row_RS_Empleados['SW_Lun'].$row_RS_Empleados['SW_Mar'].$row_RS_Empleados['SW_Mie'].$row_RS_Empleados['SW_Jue'].$row_RS_Empleados['SW_Vie']; ?></td>
      </tr>
    <tr>
      <td>BonifAdicCT</td>
      <td><input name="BonifAdicCT" type="text" id="BonifAdicCT" value="<?php echo $row_RS_Empleados['BonifAdicCT']; ?>" size="3" /></td>
      </tr>
    <tr>
      <td colspan="2">
      <input name="CodigoEmpleado" type="hidden" id="CodigoEmpleado" value="<?php echo $_GET['CodigoEmpleado']; ?>" />
      <input type="submit" name="submit2" id="submit2" value="Submit" /></td>
      </tr>
  </tbody>
</table>
</form>           
                             
            </td>
        </tr>
                           
</table>

<form id="form2" name="form2" method="POST" action="<?php echo $editFormAction; ?>">
                         <table width="95%" border="0" align="center">
                           
                           
                           <tr>
                             <td colspan="13" class="subtitle">Prestamos Devoluciones Deducciones</td>
                           </tr> 
                           <tr>
                             <td colspan="13"><?php 
echo $row_RS_Empleados['SueldoBase_1'].' + '.
	 $row_RS_Empleados['SueldoBase_2'].' + '.
	 $row_RS_Empleados['SueldoBase_3'].' + ('.
	 $row_RS_Empleados['HrAcad'].' x '.$row_RS_Empleados['BsHrAcad'].') + ('.
	 $row_RS_Empleados['HrAdmi'].' x '.$row_RS_Empleados['BsHrAdmi'].') = '.
	 $row_RS_Empleados['SueldoBase'].' | | | | '; 
	

?> / <?php echo $row_RS_Empleados['SW_Lun'].$row_RS_Empleados['SW_Mar'].$row_RS_Empleados['SW_Mie'].$row_RS_Empleados['SW_Jue'].$row_RS_Empleados['SW_Vie']. ' = '; 

$DiasTr = $row_RS_Empleados['SW_Lun']+
		  $row_RS_Empleados['SW_Mar']+
		  $row_RS_Empleados['SW_Mie']+
		  $row_RS_Empleados['SW_Jue']+
		  $row_RS_Empleados['SW_Vie'];

echo $DiasTr .' c/u = '.round($row_RS_Empleados['SueldoBase_3']/(($DiasTr*2)),2).' > ';
echo ' 15dias c/u = '.round($row_RS_Empleados['SueldoBase_3']/(15),2)
 ?>
                             </td>
                           </tr>
                <tr>
                  <td colspan="2" align="center" class="NombreCampo">&nbsp;</td>
                  <td colspan="3" align="center" class="NombreCampo">Quincena  </td>
                  <td align="center" class="NombreCampo">Tipo</td>
                  <td align="center"  class="NombreCampo">Descipci&oacute;n</td>
                  <td colspan="2" align="center" class="NombreCampo">D.Aus</td>
                  <td colspan="2" align="center" class="NombreCampo">D. Reposo</td>
                  <td align="center" class="NombreCampo">Monto</td>
                  <td align="center" class="NombreCampo">&nbsp;</td>
                </tr>
				<tr>
				  <td colspan="2" align="center" class="FondoCampo">&nbsp;</td>
                  <td colspan="3" align="center" class="FondoCampo"><select name="QuincenaCompleta" id="QuincenaCompleta">
                    <option value="0">Seleccione</option>
                    <?php 
					$Selected=false; 
					if(!isset($_POST['QuincenaCompleta'])) {
					$QuincenaHoy = date('Y-').date('m')*1 .'-';
						if (date('d')<=15) {
								$QuincenaHoy = $QuincenaHoy . '1';}
						else{
								$QuincenaHoy = $QuincenaHoy . '2';}	}				
					
					for ( $_Ano = $Ano1+2000; $_Ano <= $Ano2+2000; $_Ano++ ){
						for ( $_Mes = 1; $_Mes <= 13; $_Mes++ ){
							for ( $_Qui = 1; $_Qui <= 2; $_Qui++ ){
								$Mesde = Mes($_Mes);
						 		$_Quincena = $_Ano.'-'.$_Mes.'-'.$_Qui;
								echo '<option value="'.$_Quincena.'" ';
								if($Selected or $QuincenaHoy==$_Quincena){ echo ' selected="selected"'; $Selected=false; }
								echo '>'.$_Qui.'º '.$Mesde.' '.$_Ano.'</option>
								';
						 		if($_POST['QuincenaCompleta']==$_Quincena){ $Selected=true; }
						 
							}}}
					?>
                  </select></td>
                  <td class="FondoCampo"><select name="Tipo" id="Tipo">
<option value="0">Selecc..</option>
<option value="AQ"<?php if ($_POST['Tipo']=='AQ' or $Tipo == 'AQ') echo ' selected="selected"'; ?>  name=Adelanto onmouseup="this.form.Monto.value=100;"  >(-) Adelanto Quincena</option>
<option value="AU"<?php if ($_POST['Tipo']=='AU' or $_GET['Tipo']=="AU" or $Tipo == 'AU') echo ' selected="selected"'; ?>>(-) Ausencia</option>
<option value="DE"<?php if ($_POST['Tipo']=='DE' or $Tipo == 'DE') echo ' selected="selected"'; ?>>(-) Deducción</option>
<option value="PP"<?php if ($_POST['Tipo']=='PP' or $Tipo == 'PP') echo ' selected="selected"'; ?>>(-) Pago de prestamo</option>
<option value="BO"<?php if ($_POST['Tipo']=='BO' or $Tipo == 'BO') echo ' selected="selected"'; ?> >(+) Bonificación</option>
<option value="PR"<?php if ($_POST['Tipo']=='PR' or $Tipo == 'PR') echo ' selected="selected"'; ?>>(+) Prestamo</option>
<option value="RE"<?php if ($_POST['Tipo']=='RE' or $Tipo == 'RE') echo ' selected="selected"'; ?> >(+) Reintegro</option>
<option value="PA"<?php if ($_POST['Tipo']=='PA' or $Tipo == 'PA') echo ' selected="selected"'; ?> >(+) Pago</option>
                  </select></td>
                  <td align="center" class="FondoCampo"><label for="Tipo"></label>
                  <?php if($_GET['Tipo']=="AU"){$Descripcion = $Dias_Aus;}
				  		//else {$Descripcion = $_POST['Descripcion'];} 
						 ?>
                    <input name="Descripcion" type="text" id="Descripcion" value="<?php echo $Descripcion; ?>" size="25" onfocus="this.value='<?php echo $Descripcion; ?>'" /></td>
                  <td colspan="2" align="center" class="FondoCampo"><input name="Dias" type="text" id="Dias" size="5" 
                  onkeyup="this.form.Monto.value=this.form.Dias.value*<?php echo $SueldoDiario ?>"
                  onfocus="this.form.Monto.value=<?php echo $SueldoDiario*$N_Dias ?>;
                  			this.value=<?php echo $N_Dias; ?>"
                  <?php if($_GET['Tipo']=="AU") echo ' value="'.$N_Dias.'"'; ?>   /></td>
                  <td colspan="2" align="center" class="FondoCampo"><input name="DiasR" type="text" id="DiasR" size="5" onkeyup="this.form.Monto.value=this.form.DiasR.value*<?php echo round($SueldoDiario*.6666 , 2) ?>" /></td>
                  <td align="right" class="FondoCampo"><input name="Monto" type="text" id="Monto" value="<?php 
if($_GET['Tipo']=="AU") { echo $SueldoDiario*$N_Dias;}
elseif($Monto > 0){echo $Monto;}
else{
echo $_POST['Monto'];} ?>" size="8" onfocus="this.form.Monto.value=<?php //echo $row_RS_Empleados['Pago_extra']*0.055;//fif(this.form.Tipo.value=='AQ')  orm2.SueldoNeto.value() ?>;" /></td>
                  <td align="center" class="FondoCampo"><input type="submit" name="button" id="button" value="G" />
                    <input name="Codigo_Empleado" type="hidden" id="Codigo_Empleado" value="<?php echo $row_RS_Empleados['CodigoEmpleado']; ?>" /></td>
                </tr><?php if ($totalRows_RS_Empleados_Deduc>0){ ?>
                <tr  >
                  <td colspan="2" align="center">&nbsp;</td>
                  <td align="center">&nbsp;</td>
                  <td align="center">&nbsp;</td>
                  <td align="center">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="center">&nbsp;</td>
                </tr>
                <tr  class="NombreCampo">
                  <td colspan="2" align="center" class="NombreCampo">&nbsp;</td>
                  <td align="center" class="NombreCampo">Quincena</td>
                      <td align="center" class="NombreCampo">Mes</td>
                      <td align="center" class="NombreCampo">A&ntilde;o</td>
                      <td class="NombreCampo">&nbsp;</td>
                      <td class="NombreCampo">&nbsp;</td>
                      <td align="right" class="NombreCampo">Deduc</td>
                      <td align="right" class="NombreCampo">Pago</td>
                      <td align="right" class="NombreCampo">Prest</td>
                      <td align="right" class="NombreCampo">Pago</td>
                      <td align="right" class="NombreCampo">Saldo</td>
                      <td align="center" class="NombreCampo">&nbsp;</td>
                    </tr>
                    
                    
				<?php do { ?>
                    <?php 
					
					if (date('d')<=15) {
								$QuincenaHoy = '1';}
						else{
								$QuincenaHoy = '2';}
					
					if($row_RS_Empleados_Deduc['Mes'] == date('m') 
							and $row_RS_Empleados_Deduc['Ano'] == date('Y')
							and $row_RS_Empleados_Deduc['Quincena'] == $QuincenaHoy)
						$Verde = true; 
					else 
						$Verde = false;
					
					
				
					
					if($AnoAnte != $row_RS_Empleados_Deduc['Ano']){
					?>
                    <tr>
                      <td colspan="13" align="left" class="NombreCampoBIG" ><?php 
					  echo $row_RS_Empleados_Deduc['Ano']; ?></td>
                    </tr><?php } ?>
                    
                    
                    <tr  <?php 
				  if($QuincenaAnte != $row_RS_Empleados_Deduc['Quincena'].$row_RS_Empleados_Deduc['Mes'])
				  		$sw = ListaFondo($sw,$Verde); 
				  
				  ?>>
                  <td align="center" <?php ListaFondo($sw,$Verde); ?>><?php echo substr($row_RS_Empleados_Deduc['RegistradoPor'],0,5); ?></td>
                  <td align="center" nowrap="nowrap" <?php ListaFondo($sw,$Verde); ?>><?php echo DDMM($row_RS_Empleados_Deduc['Fecha_Registro']); ?></td>
                  <td align="center" <?php ListaFondo($sw,$Verde); ?>><?php 
				  if($QuincenaAnte != $row_RS_Empleados_Deduc['Quincena'].$row_RS_Empleados_Deduc['Mes']){
					  echo $row_RS_Empleados_Deduc['Quincena'].'&ordm;'; }
					  
					  echo $row_RS_Empleados_Deduc['Codigo_Quincena']
					  
					  
					  ?></td>
                  <td colspan="2" align="center" <?php ListaFondo($sw,$Verde); ?>><?php 
				  if($QuincenaAnte != $row_RS_Empleados_Deduc['Quincena'].$row_RS_Empleados_Deduc['Mes']){
				  echo substr(Mes($row_RS_Empleados_Deduc['Mes']),0,3); 
				  echo"-"; 
				  echo substr($row_RS_Empleados_Deduc['Ano'],2,2); }?></td>
                  <td align="left" <?php ListaFondo($sw,$Verde); ?>><?php 
				  
switch ($row_RS_Empleados_Deduc['Tipo']) {
	case 'PR':
		echo "Prestamo"; break;
	case 'PP':
		echo "Pago de prestamo"; break;
	case 'AU':
		echo "Ausencia"; break;
	case 'DE':
		echo "Otra Deducción"; break;
	case 'AQ':
		echo "Adelanto Quincena"; break;
	case 'BO':
		echo "Bonificación"; break;
	case 'PA':
		echo "Pago"; break;
	case 'RE':
		echo "Reintegro"; break;

}
				  ?></td>
                  <td <?php ListaFondo($sw,$Verde); ?>><?php 
				  echo $row_RS_Empleados_Deduc['Descripcion']; 
				  echo $row_RS_Empleados_Deduc['Concepto']; 
				  
				  ?></td>
                  <td colspan="2" align="right" <?php ListaFondo($sw,$Verde); ?>><?php 
				  if(isset($_GET['Salario']) or isset($_GET['Pagos']))
					  echo Fnum($row_RS_Empleados_Deduc['Monto']);
				  
				  if ( $row_RS_Empleados_Deduc['Tipo']=='AU' or 
				  	   $row_RS_Empleados_Deduc['Tipo']=='DE' or 
					   $row_RS_Empleados_Deduc['Tipo']=='AQ') { 
				  echo '<span class="Rojo">'; 
				  echo "-".Fnum($row_RS_Empleados_Deduc['Monto']); 
				  echo '</span>'; }
				  
				  if ( $row_RS_Empleados_Deduc['Tipo']=='BO' or 
				  	   $row_RS_Empleados_Deduc['Tipo']=='PA' or 
					   $row_RS_Empleados_Deduc['Tipo']=='RE') { 
				  echo '<span class="Azul">'; 
				  echo Fnum($row_RS_Empleados_Deduc['Monto']); 
				  echo '</span>'; } ?></td>
                  <td colspan="2" align="right" <?php ListaFondo($sw,$Verde); ?>><?php 
				  if ( $row_RS_Empleados_Deduc['Tipo']=='PR') {
				  echo '<span class="Azul">'; 
				  echo Fnum($row_RS_Empleados_Deduc['Monto']);
				  $Pendiente +=$row_RS_Empleados_Deduc['Monto']; 
				  $Saldo  	 +=$row_RS_Empleados_Deduc['Monto'];
				  echo '</span>'; } 
				  
				  if ( $row_RS_Empleados_Deduc['Tipo']=='PP') { 
				  echo '<span class="Rojo">'; 
				  echo "-".Fnum($row_RS_Empleados_Deduc['Monto']); 
				  $Pendiente -=$row_RS_Empleados_Deduc['Monto']; 
				  $Saldo  	 -=$row_RS_Empleados_Deduc['Monto'];
				  echo '</span>'; } ?></td>
                  <td align="right" <?php ListaFondo($sw,$Verde); ?>>&nbsp;<?php echo Fnum($Saldo); 
				  
				  if( $row_RS_Empleados_Deduc['Tipo'] == 'PP' ){
				  	$sql = "UPDATE Empleado_Deducciones 
							SET Descripcion = 'Resta: ".Fnum($Saldo)."'
							WHERE Codigo = '".$row_RS_Empleados_Deduc['Codigo']."'";
					mysql_query($sql, $bd);
					//echo $sql;
					}
				  
				  
				  
				  ?></td>
                  <td align="center" <?php ListaFondo($sw,$Verde); ?>><?php if ($row_RS_Empleados_Deduc['Fecha_Registro']==date('Y-m-d') or $MM_Username=='piero'  or $MM_Username=='luciaf' ){ ?><a href="<?php echo $php_self ?>?CodigoEmpleado=<?php echo $row_RS_Empleados['CodigoEmpleado']; ?>&amp;Elimina=<?php echo $row_RS_Empleados_Deduc['Codigo']; ?>"><img src="../../../i/bullet_delete.png" width="16" height="16" border="0" /></a><?php } ?>&nbsp;</td>
                </tr><?php 
				
				$AnoAnte = $row_RS_Empleados_Deduc['Ano'];
				
				
				
				$QuincenaAnte = $row_RS_Empleados_Deduc['Quincena'].$row_RS_Empleados_Deduc['Mes'];
				
				?>
                <?php } while ($row_RS_Empleados_Deduc = mysql_fetch_assoc($RS_Empleados_Deduc)); ?>
              
              
                <tr>
                  <td colspan="2" align="center" class="FondoCampo">&nbsp;</td>
                      <td align="center" class="FondoCampo">&nbsp;</td>
                      <td align="center" class="FondoCampo">&nbsp;</td>
                      <td align="center" class="FondoCampo">&nbsp;</td>
                      <td class="FondoCampo">&nbsp;</td>
                      <td align="right" class="FondoCampo">&nbsp;</td>
                      <td colspan="4" align="right" class="FondoCampo">Pendiente Prestamo</td>
                      <td align="right" class="FondoCampo"><?php echo Fnum($Pendiente); ?></td>
                      <td align="center" class="FondoCampo">&nbsp;</td>
                    </tr>
				
               <?php } ?>
            </table>
                <p>
                  <input type="hidden" name="MM_insert" value="form2" />
              </p>
      </form>
  <form action="<?php echo $editFormAction; ?>#<?php echo $i; ?>" method="post" name="form1" id="form1">
                         <table width="100%" align="center" cellpadding="5">
                  <tr valign="baseline">
                    <td colspan="4" align="right" nowrap="nowrap" class="subtitle"><span class="FondoCampo">
                      <input type="hidden" name="CodigoFMP" value="<?php echo $row_RS_Empleados['CodigoFMP']; ?>" size="5" />
                    </span><a name="lista" id="<?php echo $i++; ?>"></a>
                      <input type="submit" value="Guardar" /></td>
                    </tr>
                  <tr valign="baseline">
                    <td align="right" valign="top" nowrap="nowrap" class="NombreCampo">Empleado</td>
                    <td colspan="3" class="FondoCampo"><?php echo $row_RS_Empleados['Nombres'].' '.$row_RS_Empleados['Apellidos'] ?></td>
                  </tr>
                  <tr valign="baseline">
                    <td width="15%" align="right" valign="top" nowrap="nowrap" class="NombreCampo">Observaciones:<br />
                      <?php 
					  $foto = '../../FotoEmp/150/'.$row_RS_Empleados['CodigoEmpleado'].'.jpg';
					  if(file_exists($foto))
					  echo '<img src="'.$foto.'" width="150" height="150"/>';
					  //echo $foto;		
						?></td>
                    <td width="75%" colspan="3" class="FondoCampo"><textarea name="Observaciones" cols="70" rows="8"><?php echo $row_RS_Empleados['Observaciones']; ?></textarea></td>
                  </tr>
<?php $Cedula = $row_RS_Empleados['Cedula'] ;
$CedulaLetra = $row_RS_Empleados['CedulaLetra'] ; ?>
                  <tr valign="baseline" >
                    <td align="right" nowrap="nowrap" class="NombreCampoBIG">Sueldo Neto:</td>
                    <td align="right" class="FondoCampo"><?php 
					echo Fnum($SueltoNeto); ?></td>
                    <td align="right" class="NombreCampoBIG">Diario:</td>
                    <td align="right"  class="FondoCampo"><?php 
					echo Fnum($SueldoDiario); ?></td>
                    </tr>


                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap">&nbsp;</td>
                    <td colspan="3"><div align="right">
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
          <td colspan="2">&nbsp;</td>
        </tr>
    </table>




<p align="center">&nbsp;</p>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>
<?php
mysql_free_result($RS_Fidei);

mysql_free_result($RS_Empleados);
?>
