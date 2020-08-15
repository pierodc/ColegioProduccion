<?php 
require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php');
require_once('../../../inc/rutinas.php'); 

if ((isset($_POST["Codigo"]))) {
  $updateSQL = sprintf("UPDATE Solicitud 
  						SET Descripcion = %s , Tipo = %s
						WHERE Codigo = %s",
                       GetSQLValueString($_POST['Descripcion'], "text"),
                       GetSQLValueString($_POST['Tipo'], "text"),
                       GetSQLValueString($_POST['Codigo'], "int"));

	$RS = $mysqli->query($updateSQL);
  header("Location: ".$php_self."?Saved=1&Codigo=".$_GET['Codigo']);
}


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />
<title>Untitled Document</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>
<body><?php 

$sql = "SELECT * 
		FROM  Solicitud 
		WHERE Codigo =  '".$_GET['Codigo']."'";
$RS_ = $mysqli->query($sql);
$row_ = $RS_->fetch_assoc();
extract($row_);

?><form id="form1" name="form1" method="post" action=""><table border="0" cellpadding="0" width="100%">
<tr <?php if($_GET['Saved']=='1') echo ' bgcolor="#FFFFCC"'; ?> >
  <td align="left" nowrap="nowrap"  ><input name="Tipo" type="text" id="Tipo" value="<?php echo $Tipo ?>" size="5" /></td>
  <td align="left" nowrap="nowrap"  ><input name="Descripcion" type="text" id="Descripcion" value="<?php echo $Descripcion ?>" size="80" /></td>
  <td align="left" nowrap="nowrap"  >&nbsp;</td>
  <td align="left" nowrap="nowrap"  >&nbsp;</td>
  <td width="70" align="right"  nowrap="nowrap" ><input name="Monto" type="text" id="Monto" value="<?php echo $Monto ?>" /></td>
    <td align="right"  nowrap="nowrap" >&nbsp;</td>
    <td width="10" align="right"  nowrap="nowrap"><input name="Codigo" type="hidden" value="<?php echo $Codigo  ?>" size="8" />
      <input type="submit" name="button" id="button" onclick="this.disabled=true;this.value='...';this.form.submit();"  value="G" /></td>
</tr>
</table>
</form></body>
</html>