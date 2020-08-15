<?php 
$MM_authorizedUsers = "91";
require_once('../../inc_login_ck.php'); 

require_once('../../Connections/bd.php'); 
require_once('archivo/Variables.php');
require_once('../../inc/rutinas.php'); 

$TituloPantalla = "Acceso por Grupo";

if(isset($_POST['Codigo'])){
	$sql = "UPDATE Usuario_Grupo SET
			Acceso = '";
	
	for ($i = 1; $i <= 100; $i++) {
		if($_POST[$i]>"")
			$sql .= $_POST[$i].";";		
	}
	
	$sql .= "' WHERE Codigo = '".$_POST['Codigo']."'";
			
			
	echo $sql;
	$mysqli->query($sql);
	}
echo '<pre>';
print_r($_POST);
echo '</pre>';
/*
// Conectar
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

// Ejecuta $sql
$RS = $mysqli->query($query_RS_Alumno);

$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();


// Ejecuta $sql y While
while ($row = $RS->fetch_assoc()) {
	extract($row);
    echo "<br>";
}

$RS->data_seek(0);

if(isset($_POST['button'])){
	$sql = "INSERT INTO Table (Codigo) VALUES
			('".$_POST['Codigo']."')";
	$mysqli->query($sql);
}

echo $sw=ListaFondo($sw,$Verde); 

header("Location: ".$php_self."?CodigoPropietario=".$_GET['CodigoPropietario']);


*/
 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title><?php echo $TituloPantalla; ?></title>
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
    <td align="center"><?php require_once('TitAdmin.php'); ?>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top"><table width="900" border="0" cellpadding="2">
        <tr>
          <td class="NombreCampo">Clave</td>
          <td colspan="2" class="NombreCampo">Acceso</td>
        </tr>
<?php 
$sql = "SELECT * FROM Usuario_Grupo";
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	extract($row);
?>
        <tr <?php echo $sw=ListaFondo($sw,$Verde);  ?>>
          <td valign="top"><?php echo $Clave ?>&nbsp;</td>
          <td><form id="form1" name="form1" method="post" action="">
              <?php echo $Acceso ?>
              <table width="100%">
                <tr>
                  <td><label>
                    <input type="checkbox" name="1" value="all"  />
                    TODO<?php if(Acceso("all",$Clave)) echo ' checked="checked" '; ?>
                  </label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="2" value="Academico"  />
                    Academico 
                    <input name="21" type="checkbox" id="21" value="Status"  />
                    Status
                  </label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="3" value="Cobranza"  />
                    Cobranza</label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="4" value="Contabilidad"  />
                    Contabilidad</label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="5" value="Nomina"   />
                    N&oacute;mina </label>
                    
                      <label><input type="checkbox" name="52" value="Sueldo"   />
                      Sueldo </label>

                    <label><input type="checkbox" name="53" value="CestaTicket"   />
                    CestaTicket</label>
                    
                    <label><input type="checkbox" name="54" value="EditaEmpleado"   />
                    EditaEmpleado</label>

                    <label><input type="checkbox" name="55" value="Fideicomiso"   />
                    Fideicomiso</label>
                    
                    
                    </td>
                </tr>
              </table>
<input type="submit" name="button" id="button" value="Submit" />
              <input name="Codigo" type="hidden" id="hiddenField" value="<?php echo $Codigo ?>" />
          </form></td>
          <td valign="top"><?php 
		  echo $NombrePrivilegios . "<br>";
		  $sql_US = "SELECT * FROM Usuario WHERE Privilegios = '$NombrePrivilegios'";
		  $RS_US = $mysqli->query($sql_US);
			while ($row_US = $RS_US->fetch_assoc()) {
				echo $row_US['Usuario'].'<br>';
				}

		  ?>&nbsp;</td>
        </tr>
<?php } ?>
    </table>      &nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top"><?php  if(Acceso($Acceso_US,$Reuqerido_Pag)){
			  	echo ' checked="checked" '; } ?></td>
  </tr>
</table>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>