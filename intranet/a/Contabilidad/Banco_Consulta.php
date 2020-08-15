<?php
$MM_authorizedUsers = "99,91,95,90";
require_once('../../../inc_login_ck.php'); 

require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 



if(isset($_POST['Banco'])) {

	if($_POST['Banco']==1 or $_POST['Banco']==2){
		$sql = " AND CodigoCuenta = ".$_POST['Banco'];}
	
	if($_POST['Tipo']==1){
		$sql .= " AND MontoHaber > 0 ";}
	
	if($_POST['Tipo']==2){
		$sql .= " AND MontoDebe > 0 ";}
	
	
	$query_RS_Movimientos_Banco = "SELECT * FROM Contable_Imp_Todo 
									WHERE Fecha >= '".$_POST['Fecha0']."' 
									AND Fecha <= '".$_POST['Fecha1']."' 
									$sql 
									ORDER BY Fecha, Referencia ASC";
	$RS_Movimientos_Banco = mysql_query($query_RS_Movimientos_Banco, $bd) or die(mysql_error());
	$row_RS_Movimientos_Banco = mysql_fetch_assoc($RS_Movimientos_Banco);
	$totalRows_RS_Movimientos_Banco = mysql_num_rows($RS_Movimientos_Banco);

}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Administraci&oacute;n SFDA</title>
<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
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
<script src="../../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" align="center">
  <tr>
    <td><?php   
	$TituloPantalla ="Consulta de Banco";
	require_once('../TitAdmin.php'); ?></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><form id="form1" name="form1" method="post" action="">
  <table width="500" border="0">
    <tr>
      <td colspan="2" class="subtitle">Consultar Movimientos</td>
      </tr>
    <tr>
      <td class="NombreCampo">Fecha Inicial</td>
      <td class="FondoCampo"><span class="FondoCampo">
        <input name="Fecha0" type="date" id="Fecha0" value="<?php echo date('Y-m-d'); ?>" />
        <?php //FechaFutura('Fecha0', date('Y-m-d')) ?>
        </span></td>
      </tr>
    <tr>
      <td class="NombreCampo">Fecha Final</td>
      <td class="FondoCampo"><span class="FondoCampo">
        <input name="Fecha1" type="date" id="Fecha1" value="<?php echo date('Y-m-d') ?>" />
        <?php //FechaFutura('Fecha1', date('Y-m-d')) ?>
        </span></td>
      </tr>
    <tr>
      <td class="NombreCampo">Banco</td>
      <td class="FondoCampo"><p>
        <label>
          <input name="Banco" type="radio" id="Banco_0" value="0" checked="checked" />
          Todos</label>
        <br />
        <label>
          <input type="radio" name="Banco" value="1" id="Banco_1" />
          Mercantil</label>
        <br />
        <label>
          <input type="radio" name="Banco" value="2" id="Banco_2" />
          Provincial</label>
        <br />
        </p></td>
      </tr>
    <tr>
      <td class="NombreCampo">Movimientos</td>
      <td class="FondoCampo"><p>
        <label>
          <input name="Tipo" type="radio" id="Tipo_0" value="1" checked="checked" />
          Depositos / Transferencias</label>
        <br />
        <label>
          <input type="radio" name="Tipo" value="2" id="Tipo_1" />
          Cheques / Debitos</label>
        <br />
        </p></td>
      </tr>
    <tr>
      <td><a href="Banco_Busca.php">Busca Por monto</a></td>
      <td>
        <label>
          <input type="submit" name="button" id="button" value="Buscar" />
          </label>
        </td>
      </tr>
    </table>
      <?php if ($totalRows_RS_Movimientos_Banco > 0) { // Show if recordset not empty ?>
        <table border="0">
          <tr>
            <td class="NombreCampoTopeWin">Fehca</td>
            <td class="NombreCampoTopeWin"><div align="center">Tipo</div></td>
            <td class="NombreCampoTopeWin"><div align="center">Referencia</div></td>
            <td class="NombreCampoTopeWin">Descripci&oacute;n</td>
            <td class="NombreCampoTopeWin"><div align="center">Debe</div></td>
            <td class="NombreCampoTopeWin"><div align="center">Haber</div></td>
            <td class="NombreCampoTopeWin">&nbsp;</td>
            </tr>
          
          <?php do { ?>
            <tr>
              <td class="FondoCampo"><?php echo DDMMAAAA($row_RS_Movimientos_Banco['Fecha']); ?></td>
              <td align="right" class="FondoCampo"><div align="center"><?php echo $row_RS_Movimientos_Banco['Tipo']; ?></div></td>
              <td align="right" class="FondoCampo"><div align="right"><?php echo $row_RS_Movimientos_Banco['Referencia']; ?></div></td>
              <td align="right" class="FondoCampo"><div align="right"><?php echo $row_RS_Movimientos_Banco['Descripicion']; ?></div></td>
              <td align="right" class="FondoCampo"><div align="right"><?php echo $row_RS_Movimientos_Banco['MontoDebe']; ?></div></td>
              <td align="right" class="FondoCampo"><div align="right"><?php echo $row_RS_Movimientos_Banco['MontoHaber']; ?></div></td>
              <td class="FondoCampo">&nbsp;</td>
              </tr>
            <?php } while ($row_RS_Movimientos_Banco = mysql_fetch_assoc($RS_Movimientos_Banco)); ?>
          
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          </table>
        <?php } // Show if recordset not empty ?>
  <p>&nbsp;</p>
</form>    </td>
  </tr>
</table>
</body>
</html>
<?php
//mysql_free_result($RS_Movimientos_Banco);
?>
