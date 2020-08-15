<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin";
require_once('../../../inc_login_ck.php'); 

require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php');
require_once('../../../inc/rutinas.php'); 

$TituloPantalla = "Contratos";

// Conectar
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

if(isset($_POST['Insert'])){
	$sql = "INSERT INTO Contrato SET
			Descripcion = '".$_POST['Descripcion']."',
			Firman = '".$_POST['Firman']."',
			Texto = '".$_POST['Texto']."'";
	//		echo $sql;
	$mysqli->query($sql);
}
if(isset($_POST['Update'])){
	$sql = "UPDATE Contrato SET
			Descripcion = '".$_POST['Descripcion']."',
			Firman = '".$_POST['Firman']."',
			Texto = '".$_POST['Texto']."'
			WHERE Codigo = '".$_GET['Codigo']."'";
	//		echo $sql;
	$mysqli->query($sql);
}
/*

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

if(Acceso($Acceso_US,$Reuqerido_Pag)){
	echo "$Acceso_US permitido en Reuqerido_Pag"; }


*/
 
 
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

</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><?php require_once('../TitAdmin.php'); ?></td>
  </tr>
  <tr>
    <td align="center" valign="top"><table width="100%" border="0" cellpadding="2">
        <tr>
          <td><form name="form" id="form">
            <select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)">
              <option value="Contrato.php">Ir a....</option>
  <?php 

$sql = "SELECT * FROM Contrato";
$RS = $mysqli->query($sql);  
while ($row = $RS->fetch_assoc()) {
	//extract($row);
	?>  
	<option value="Contrato.php?Codigo=<?php echo $row["Codigo"] ?>" <?php 
	if($row["Codigo"] == $_GET["Codigo"])
		echo 'selected="selected"'; ?>><?php echo $row["Descripcion"]; ?></option>
	<?php 
}

  ?>            
            </select>
          </form></td>
        </tr>
<tr <?php 

if(isset($_GET['Codigo'])){
	$sql = "SELECT * FROM Contrato
			WHERE Codigo = '".$_GET['Codigo']."'";
			echo $sql;
	$RS = $mysqli->query($sql);
	$row = $RS->fetch_assoc();
	extract($row);
}
 ?>>
  <td>    <form id="form1" name="form1" method="post" action="">
<table width="100%" border="0">
    <tr>
      <td class="NombreCampo">&nbsp;</td>
      <td class="FondoCampo"><a href="Contrato_pdf.php?Codigo=<?php echo $_GET['Codigo'] ?>">PDF</a></td>
    </tr>
    <tr>
      <td class="NombreCampo">Descripcion</td>
      <td class="FondoCampo">
        <input type="text" name="Descripcion" id="Descripcion" value="<?php echo $Descripcion; ?>" /></td>
    </tr>
    <tr>
      <td valign="top" class="NombreCampo">Texto</td>
      <td class="FondoCampo">
        <textarea name="Texto" cols="150" rows="20" id="Texto" class=""><?php echo $Texto; ?></textarea></td>
    </tr>
    <tr>
      <td valign="top" class="NombreCampo">Firman</td>
      <td class="FondoCampo"><label for="Firman"></label>
        <input name="Firman" type="text" id="Firman" value="<?php echo $Firman; ?>" size="80" /></td>
    </tr>
    <tr>
      <td><?php 
if(isset($_GET['Codigo'])){
	  ?><input type="hidden" name="Update" id="Update" /><?php }
else{	  
	  ?><input type="hidden" name="Insert" id="Insert" /><?php }?></td>
      <td><input type="submit" name="button" id="button" value="Submit" /></td>
    </tr>
  </table>
    </form></td>
</tr>

    </table>      &nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
</table>
</body>
</html>