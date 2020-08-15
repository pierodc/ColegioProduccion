<?php 
require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php'); 
require_once('../../../inc/rutinas.php'); 

$MM_authorizedUsers = "91,Contable";
require_once('../../../inc_login_ck.php'); 

if(!TieneAcceso($Acceso_US,"Sueldo")){
	header("Location: ".$_SERVER['HTTP_REFERER']);
	}


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


$colname_RS_Empleados = "-1";
if (isset($_GET['CodigoEmpleado'])) {
  $CodigoEmpleado = $_GET['CodigoEmpleado'];
}
$query_RS_Empleados = sprintf("SELECT * FROM Empleado 
										WHERE CodigoEmpleado = %s 
										ORDER BY Apellidos ASC", 
										GetSQLValueString($CodigoEmpleado, "int"));
										
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


$query_RS_Empleado_Pago = "SELECT * FROM Empleado_Pago 
							WHERE Codigo_Empleado = '$CodigoEmpleado' 
							AND Concepto <> '+Cesta Ticket'
							ORDER BY Codigo_Quincena DESC, Concepto";
										
$RS_Empleado_Pago = mysql_query($query_RS_Empleado_Pago, $bd) or die(mysql_error());
$row_RS_Empleado_Pago = mysql_fetch_assoc($RS_Empleado_Pago);
$totalRows_RS_Empleado_Pago = mysql_num_rows($RS_Empleado_Pago);



?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">

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
    <td width="25%" nowrap="nowrap"><a href="Ficha_PagoDeduc.php?CodigoEmpleado=<?php echo $_GET['CodigoEmpleado'] ?>"><img src="../../../i/coins_in_hand.png" width="32" height="32" border="0" align="absmiddle" /> Pagos Deducciones</a></td>
  </tr>
</table>


                         <table width="100%" border="0" align="center">
                           
                           
                           <tr>
                             <td colspan="12" class="subtitle">Pagos Deducciones</td>
                           </tr>
                <tr>
                  <td align="center" class="NombreCampo">&nbsp;</td>
                  <td align="center" class="NombreCampo">Quincena  </td>
                  <td align="center" class="NombreCampo">Mes</td>
                  <td align="center" class="NombreCampo">A&ntilde;o</td>
                  <td align="center" class="NombreCampo">&nbsp;</td>
                  <td align="center"  class="NombreCampo">Descipci&oacute;n</td>
                  <td align="center" class="NombreCampo">&nbsp;</td>
                  <td align="center" class="NombreCampo">&nbsp;</td>
                  <td colspan="3" align="center" class="NombreCampo">Monto</td>
                  <td align="center" class="NombreCampo">&nbsp;</td>
                </tr>
                <tr class="FondoCampo">
                  <td align="center" class="FondoCampo">&nbsp;</td>
                  <td align="center" class="FondoCampo">&nbsp;</td>
                      <td align="center" class="FondoCampo">&nbsp;</td>
                      <td align="center" class="FondoCampo">&nbsp;</td>
                      <td class="FondoCampo">&nbsp;</td>
                      <td class="FondoCampo">&nbsp;</td>
                      <td align="right" class="FondoCampo">&nbsp;</td>
                      <td align="right" class="FondoCampo">&nbsp;</td>
                      <td align="right" class="FondoCampo">&nbsp;</td>
                      <td align="right" class="FondoCampo">&nbsp;</td>
                      <td align="right" class="FondoCampo">monto</td>
                      <td align="center" class="FondoCampo">&nbsp;</td>
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
					
					?>
                    <tr >
                  <td align="center" <?php ListaFondo($sw,$Verde); ?>><?php echo $row_RS_Empleado_Pago['RegistradoPor']; ?></td>
                  <td align="center" <?php ListaFondo($sw,$Verde); ?>><?php echo $row_RS_Empleado_Pago['Codigo_Quincena']; ?></td>
                  <td align="center" <?php ListaFondo($sw,$Verde); ?>><?php echo Mes($row_RS_Empleado_Pago['Mes']); ?></td>
                  <td align="center" <?php ListaFondo($sw,$Verde); ?>><?php echo $row_RS_Empleado_Pago['Ano']; ?></td>
                  <td align="left" <?php ListaFondo($sw,$Verde); ?>>&nbsp;</td>
                  <td <?php ListaFondo($sw,$Verde); ?>><?php 
				  
echo $row_RS_Empleado_Pago['Concepto'];

				  ?></td>
                  <td align="right" <?php ListaFondo($sw,$Verde); ?>>&nbsp;</td>
                  <td align="right" <?php ListaFondo($sw,$Verde); ?>>&nbsp;</td>
                  <td align="right" <?php ListaFondo($sw,$Verde); ?>>&nbsp;</td>
                  <td align="right" <?php ListaFondo($sw,$Verde); ?>>&nbsp;</td>
                  <td align="right" <?php ListaFondo($sw,$Verde); ?>>&nbsp;<?php echo Fnum($row_RS_Empleado_Pago['Monto']);   ?></td>
                  <td align="center" <?php $sw = ListaFondo($sw,$Verde); ?>>&nbsp;</td>
                </tr>
                <?php } while ($row_RS_Empleado_Pago = mysql_fetch_assoc($RS_Empleado_Pago)); ?>
                <tr>
                  <td align="center" class="FondoCampo">&nbsp;</td>
                      <td align="center" class="FondoCampo">&nbsp;</td>
                      <td align="center" class="FondoCampo">&nbsp;</td>
                      <td align="center" class="FondoCampo">&nbsp;</td>
                      <td class="FondoCampo">&nbsp;</td>
                      <td align="right" class="FondoCampo">&nbsp;</td>
                      <td colspan="4" align="right" class="FondoCampo">Pendiente Prestamo</td>
                      <td align="right" class="FondoCampo"><?php echo Fnum($Pendiente); ?></td>
                      <td align="center" class="FondoCampo">&nbsp;</td>
                    </tr>
				
            </table>
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
    </table></td>
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
