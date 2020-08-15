<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin";
require_once('../../../inc_login_ck.php'); 

require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php');
require_once('../../../inc/rutinas.php'); 

$TituloPantalla = "Buscar en Banco";

$colname_RS_Mov_Banco = "-1";
if (isset($_POST['MontoHaber'])) {
  $colname_RS_Mov_Banco = $_POST['MontoHaber'];
}
if (isset($_POST['Banco']) and $_POST['Banco']>0) {
  $addSQL = " AND CodigoCuenta = '".$_POST['Banco']."' ";
}

$query_RS_Mov_Banco = sprintf("SELECT * FROM Contable_Imp_Todo 
								WHERE Contable_Imp_Todo.MontoHaber = %s 
								$addSQL 
								ORDER BY Fecha ASC", GetSQLValueString($colname_RS_Mov_Banco, "double"));
//echo $query_RS_Mov_Banco ;
$RS_Mov_Banco = mysql_query($query_RS_Mov_Banco, $bd) or die(mysql_error());
$row_RS_Mov_Banco = mysql_fetch_assoc($RS_Mov_Banco);
$totalRows_RS_Mov_Banco = mysql_num_rows($RS_Mov_Banco);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title><?php echo $TituloPantalla; ?></title>
<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>

<script src="../../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />

<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />

<script src="../../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<body>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><?php require_once('../TitAdmin.php'); ?>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">
<form id="form1" name="form1" method="post" action="">
  <table width="400" border="0" align="center">
    <tr>
      <td colspan="2" class="subtitle">Buscar</td>
    </tr>
    <tr>
      <td class="NombreCampo">Banco</td>
      <td class="FondoCampo"><p>
        <label>
          <input type="radio" name="Banco" value="1" id="Banco_0" />
          Mercantil</label>
        <br />
        <label>
          <input type="radio" name="Banco" value="2" id="Banco_1" />
          Provincial</label>
        <br />
      </p></td>
    </tr>
    <tr>
      <td class="NombreCampo">&nbsp;Monto</td>
      <td class="FondoCampo"><input type="text" name="MontoHaber" id="MontoHaber" /></td>
    </tr>
    <tr>
      <td align="right" nowrap="nowrap"><a href="Banco_Consulta.php">Busca Rango</a></td>
      <td align="right"><input type="submit" name="button" id="button" value="Buscar" /></td>
    </tr>
  </table>

</form>

<?php if ($totalRows_RS_Mov_Banco>0){ ?>
  <table width="800" border="0" align="center" cellpadding="2">
    <tr>
      <td class="NombreCampo">Fecha</td>
      <td class="NombreCampo">Referencia Banco</td>
      <td class="NombreCampo">Banco</td>
      <td class="NombreCampo">Tipo</td>
      <td class="NombreCampo">Descripcion</td>
      <td class="NombreCampo">Alumno</td>
      <td class="NombreCampo">Recibo</td>
      <td class="NombreCampo">Monto</td>
    </tr>
    <?php do { ?>
    <?php if($AnoMesAnte != substr($row_RS_Mov_Banco['Fecha'],0,7)) {?>
      <tr>
      <td colspan="8" class="NombreCampoTITULO">&nbsp;<?php echo Mes(substr($row_RS_Mov_Banco['Fecha'],5,2)) .' '.substr($row_RS_Mov_Banco['Fecha'],0,4) ?></td>
    </tr>
    <?php } ?>
    <tr>
        <td class="Listado<?php echo $In; ?>Par12"><?php echo DDMMAAAA($row_RS_Mov_Banco['Fecha']); ?></td>
        <td class="Listado<?php echo $In; ?>Par12"><?php echo $row_RS_Mov_Banco['Referencia'];?></td>
        <td align="center" class="Listado<?php echo $In; ?>Par12"><?php  echo $row_RS_Mov_Banco['CodigoCuenta']==1?"Merc":"Prov"; ?></td>
        <td align="center" class="Listado<?php echo $In; ?>Par12"><?php echo $row_RS_Mov_Banco['Tipo']; ?></td>
        <td class="Listado<?php echo $In; ?>Par12"><?php echo $row_RS_Mov_Banco['Descripcion']; ?></td><?php 
		
$Referencia = $row_RS_Mov_Banco['Referencia'];		
$query_RS_Mov_Alumno = "SELECT * FROM ContableMov WHERE Referencia = '$Referencia' AND (Tipo = 1 OR Tipo = 2)";
$RS_Mov_Alumno = mysql_query($query_RS_Mov_Alumno, $bd) or die(mysql_error());
$row_RS_Mov_Alumno = mysql_fetch_assoc($RS_Mov_Alumno);
$totalRows_RS_Mov_Alumno = mysql_num_rows($RS_Mov_Alumno);

		?>
        <td class="Listado<?php echo $In; ?>Par12"><?php echo $row_RS_Mov_Alumno['CodigoPropietario']; ?></td>
        <td class="Listado<?php echo $In; ?>Par12"><?php echo $row_RS_Mov_Alumno['CodigoRecibo']; ?></td>
        <td align="right" class="Listado<?php echo $In; ?>Par12"><?php echo $row_RS_Mov_Banco['MontoHaber']; ?></td>
      </tr><?php if($In == '') $In = 'In'; else $In = ''; 
	  
	  $AnoMesAnte = substr($row_RS_Mov_Banco['Fecha'],0,7);
	  
	  ?>
      <?php } while ($row_RS_Mov_Banco = mysql_fetch_assoc($RS_Mov_Banco)); ?>
    
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
  </table><?php } ?>
  </td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
</table>
</body>
</html>