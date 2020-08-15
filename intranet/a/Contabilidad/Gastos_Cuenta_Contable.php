<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin";
require_once('../../../inc_login_ck.php'); 

require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php');
require_once('../../../inc/rutinas.php'); 

$TituloPantalla = "Cuentas Contables";

if(isset($_POST['CampoModif'])){
	$CampoModif = $_POST['CampoModif']; 
	$NombreOld = $_POST['NombreOld']; 
	$NombreNew = $_POST['NombreNew']; 
	$NombreNew = str_replace(' ','_',$NombreNew);
	$sql = "UPDATE Contabilidad SET $CampoModif = '$NombreNew' WHERE
			$CampoModif = '$NombreOld' 			";
	echo $sql;
	$mysqli->query($sql);
}

if(isset($_POST['Cuenta123']) and $_POST['Cuenta123']>''){
	extract($_POST);
	if($Cuenta123 > ""){
		$Cuenta123 = explode("::",$Cuenta123);
		if($Cuenta123[0] > ' ')
			$Cuenta1   = $Cuenta123[0];
		if($Cuenta123[1] > ' ')
			$Cuenta11  = $Cuenta123[1];
		if($Cuenta123[2] > ' ')
			$Cuenta111 = $Cuenta123[2];	}

	if($Cuenta1Modif > ""){
		$addSET .= " Cuenta1 = '$Cuenta1Modif' ,";	}
	if($Cuenta11Modif > ""){
		$addSET .= " Cuenta11 = '$Cuenta11Modif' ,";	}
	if($Cuenta111Modif > ""){
		$addSET .= " Cuenta111 = '$Cuenta111Modif' ,";	}
		
	$addSET = substr($addSET,0,strlen($addSET)-1);
		
	
		$addWHERE = " WHERE Cuenta1 = '".$Cuenta123[0]."' AND
					  Cuenta11 = '".$Cuenta123[1]."' AND
					  Cuenta111 = '".$Cuenta123[2]."' ";
		
		$sql = "UPDATE Contabilidad SET ".$addSET.$addWHERE;
		echo $sql;
		$mysqli->query($sql);

							

}

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
<tr >
  <td align="center">&nbsp;</td>
</tr>
<tr >
  <td align="center"><table width="900" border="1">
    <tr>
      <td colspan="2">Modificaci&oacute;n de cuentas</td>
    </tr>
    <tr>
      <td>Cuenta 1</td>
      <td><form id="form2" name="form2" method="post" action="">
        <select name="NombreOld" id="NombreOld">
          <option value="">Seleccione</option>
          <?php 
$sql = "SELECT * FROM Contabilidad GROUP BY Cuenta1 ORDER BY Cuenta1";
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	extract($row);
	echo '<option value="'.$Cuenta1.'">'.$Cuenta1.'</option>
'; } ?>
        </select>
        -&gt;&gt;
        <input name="NombreNew" type="text" id="NombreNew" size="20" />
        <input type="submit" name="button2" id="button2" value="Cambiar" />
        <input name="CampoModif" type="hidden" id="CampoModif" value="Cuenta1" />
      </form></td>
    </tr>
    <tr>
      <td>Cuenta 11</td>
      <td><form id="form2" name="form2" method="post" action="">
        <select name="NombreOld" id="NombreOld">
          <option value="">Seleccione</option>
          <?php 
$sql = "SELECT * FROM Contabilidad GROUP BY Cuenta11 ORDER BY Cuenta11";
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	extract($row);
	echo '<option value="'.$Cuenta11.'">'.$Cuenta11.'</option>
'; } ?>
        </select>
        -&gt;&gt;
        <input name="NombreNew" type="text" id="NombreNew" size="20" />
        <input type="submit" name="button2" id="button2" value="Cambiar" />
        <input name="CampoModif" type="hidden" id="CampoModif" value="Cuenta11" />
      </form></td>
    </tr>
    <tr>
      <td>Cuenta 111</td>
      <td><form id="form2" name="form2" method="post" action="">
        <select name="NombreOld" id="NombreOld">
          <option value="">Seleccione</option>
          <?php 
$sql = "SELECT * FROM Contabilidad GROUP BY Cuenta111 ORDER BY Cuenta111";
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	extract($row);
	echo '<option value="'.$Cuenta111.'">'.$Cuenta111.'</option>
'; } ?>
        </select>
        -&gt;&gt;
        <input name="NombreNew" type="text" id="NombreNew" size="20" />
        <input type="submit" name="button2" id="button2" value="Cambiar" />
        <input name="CampoModif" type="hidden" id="CampoModif" value="Cuenta111" />
      </form></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><form id="form3" name="form3" method="post" action="">
        <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><select name="Cuenta123" id="Cuenta123" >
              <option value="" selected="selected">Seleccione...</option>
              <?php 

$sql = "SELECT * FROM Contabilidad GROUP BY Cuenta1 ORDER BY Cuenta1";
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	extract($row);
	
	$sql_Cuenta1 = "SELECT * FROM Contabilidad 
					WHERE Cuenta1 = '$Cuenta1'
					GROUP BY Cuenta11 
					ORDER BY Cuenta11";
	$RS_Cuenta1 = $mysqli->query($sql_Cuenta1);
	
	while($row_Cuenta1 = $RS_Cuenta1->fetch_assoc()){
	
		$sql_Cuenta11 = "SELECT * FROM Contabilidad 
						WHERE Cuenta11 = '".$row_Cuenta1['Cuenta11']."'
						GROUP BY Cuenta111 
						ORDER BY Cuenta111";
		$RS_Cuenta11 = $mysqli->query($sql_Cuenta11);
		while($row_Cuenta11 = $RS_Cuenta11->fetch_assoc()){
			if($Cuenta1Anterior <> $Cuenta1){
				echo "<option value=\"\"></option>";
				echo "<option value=\"$Cuenta1::\">-- $Cuenta1</option>";}
			echo '<option value="'.
					$Cuenta1.'::'.$row_Cuenta1['Cuenta11'].'::'.$row_Cuenta11['Cuenta111'].'::'.'" ';
					echo ' onchange="this.Cuenta1Modif.value()=\'111\'" >'.
					'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-> '.$row_Cuenta1['Cuenta11'].' -->> '.$row_Cuenta11['Cuenta111'].
					"</option>\r\n"; 
			$Cuenta1Anterior = $Cuenta1;		
		}
	}
 } 
 ?>
            </select></td>
            <td rowspan="2"><input type="submit" name="button2" id="button2" value="Cambiar" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input name="Cuenta1Modif" id="Cuenta1Modif" type="text" size="12" />
              <input name="Cuenta11Modif" type="text" size="12" />
              <input name="Cuenta111Modif" type="text" size="12" /></td>
            </tr>
        </table>
      </form></td>
    </tr>
  </table></td>
</tr>
    </table>      &nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
</table>
</body>
</html>