<?php 
$MM_authorizedUsers = "91,95";
require_once('../../inc_login_ck.php'); 

require_once('../../Connections/bd.php'); 
require_once('../../inc/rutinas.php'); 


if($_POST){
	foreach ($_POST as $id => $Variable) {
		if(substr($id,0,4) == 'Var_'){
			$id = str_replace('Var_','',$id);
			$txt .= '$'.$id.' = "'.$Variable.'";
';		
			//echo $id.' = '.$Variable.'<br>';
			}
		elseif(substr($id,0,7) == 'Coment_'){
			//$id = str_replace('Var_','',$id);
			$txt .= '// '.$Variable.'
';		
			
			}
		}
	//$archivo = fopen('archivo/Variables.txt','r+');	
$txt = '<?php
'.$txt.'
?>';
	file_put_contents('archivo/Variables.php',$txt);
	
	}
echo $txt;
$líneas = file('archivo/Variables.php', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Variables del Sietema</title>
<link href="../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../estilos2.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>

<script src="../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />

<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />

<script src="../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><?php $TituloPantalla ="Variables del Sistema";
	require_once('TitAdmin.php'); ?>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top"><form id="form1" name="form1" method="post" action="">
<table width="600" align="center">
<?php 
foreach ($líneas as $num_línea => $línea) {
	if(substr($línea,0,3) == "// "){

?>
  <tr>
    <td colspan="2" class="subtitle"><?php echo str_replace('// ','',$línea); ?><input name="Coment_<?php echo ++$k ?>" type="hidden" value="<?php echo str_replace('// ','',$línea); ?>" /></td>
  </tr>
<?php 
	}
	if(substr($línea,0,1)=='$'){
		$Var = explode(" = ",$línea);
	
		$Valor = $Var[1];
		$Valor = str_replace('"','',$Valor);
		$Valor = str_replace(';','',$Valor);
		
		$Nombre = $Var[0];
		$Nombre = str_replace('$','',$Nombre);

?>
  <tr>
    <td class="NombreCampo"><?php echo $Nombre; ?>&nbsp;</td>
    <td class="FondoCampo"><input name="Var_<?php echo $Nombre; ?>" type="text" value="<?php echo $Valor; ?>" size="50" /></td>
  </tr>
<?php }} ?>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="button" id="button" value="Submit" /></td>
  </tr>
</table>
</form>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
</table>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>