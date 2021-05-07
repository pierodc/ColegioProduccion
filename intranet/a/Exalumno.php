<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,secreBach,admin";
require_once('../../inc_login_ck.php'); 
require_once('archivo/Variables.php');

require_once('../../Connections/bd.php'); 
require_once('../../inc/rutinas.php'); 

$TituloPantalla = "Exalumno";

/*
if(!TieneAcceso($Acceso_US,"")){
	header("Location: ".$_SERVER['HTTP_REFERER']);
	}

// Conectar
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

// Ejecuta $sql
$RS = $mysqli->query($query_RS_Alumno);

$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();
$Conteo = $RS->num_rows;

// Ejecuta $sql y While
$RS = $mysqli->query($sql);
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

$sw=ListaFondo($sw,$Verde); 

header("Location: ".$php_self."?CodigoPropietario=".$_GET['CodigoPropietario']);

if(Acceso($Acceso_US,$Reuqerido_Pag)){
	echo "$Acceso_US permitido en Reuqerido_Pag"; }


*/
 
if(isset($_POST['Buscar'])){
	$sql = "SELECT * FROM Alumno WHERE
			Cedula = '".$_POST['Cedula']."'";
	$RS = $mysqli->query($sql);
	$Conteo = $RS->num_rows;

	if($Conteo == 0){
		header("Location: Exalumno.php?Crear=1&Cedula=".$_POST['Cedula']);
	}
	else{
		header("Location: Exalumno.php?Crear=0&Cedula=".$_POST['Cedula']);
		}		
	}
 
 
 
if(isset($_POST['Accion'])){
	if($_POST['Accion'] == "INSERT"){
		extract($_POST);
		$sql = "INSERT INTO Alumno (CedulaLetra,Cedula,Nombres,Nombres2,Apellidos,Apellidos2,
									Sexo,FechaNac,Nacionalidad,Localidad,LocalidadPais,
									Entidad,EntidadCorta,TelCel,TelHab,Email1)
									VALUES
									('$CedulaLetra','$Cedula','$Nombres','$Nombres2','$Apellidos','$Apellidos2',
									'$Sexo','$FechaNac','$Nacionalidad','$Localidad','$LocalidadPais',
									'$Entidad','$EntidadCorta','$TelCel','$TelHab','$Email1')";
	}

	if($_POST['Accion'] == "UPDATE"){
		extract($_POST);
		$sql = "UPDATE Alumno SET 
				CedulaLetra = '$CedulaLetra',
				Nombres = '$Nombres',
				Nombres2 = '$Nombres2',
				Apellidos = '$Apellidos',
				Apellidos2 = '$Apellidos2',
				Sexo = '$Sexo',
				FechaNac = '$FechaNac',
				Nacionalidad = '$Nacionalidad',
				Localidad = '$Localidad',
				LocalidadPais = '$LocalidadPais',
				Entidad = '$Entidad',
				EntidadCorta = '$EntidadCorta',
				TelCel = '$TelCel',
				TelHab = '$TelHab',
				Email1 = '$Email1'
				WHERE 
				Cedula = '$Cedula'";
	}



		//echo $sql;	
		$mysqli->query($sql);	
		header("Location: Exalumno.php?Crear=0&Cedula=".$_GET['Cedula']);
					
}


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

</head>
<script language="javascript" type="text/javascript">
    //*** Este Codigo permite Validar que sea un campo Numerico
    function Solo_Numerico(variable){
        Numer=parseInt(variable);
        if (isNaN(Numer)){
            return "";
        }
        return Numer;
    }
    function ValNumero(Control){
        Control.value=Solo_Numerico(Control.value);
    }
    //*** Fin del Codigo para Validar que sea un campo Numerico
</script>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><?php require_once('TitAdmin.php'); ?></td>
  </tr>
  <tr>
    <td align="center" valign="top"><table width="80%" border="0" cellpadding="2">


<?php if(!isset($_GET['Crear'])) {?>
<tr>
  <td class="NombreCampo">Buscar Exalumno</td>
</tr>
<tr >
  <td><form id="form1" name="form1" method="post" action="">
    <label for="Cedula"></label>
    C&eacute;dula (solo n&uacute;meros):
    <input type="text" name="Cedula" id="Cedula"  onKeyUp="return ValNumero(this);" />
    <input type="submit" name="Buscar" id="Buscar" value="Buscar" />
  </form></td>
</tr>
<?php } ?>


<?php if(isset($_GET['Crear'])) { 

	if($_GET['Crear'] == 0){
		$sql = "SELECT * FROM Alumno WHERE
				Cedula = '".$_GET['Cedula']."'";
		$RS = $mysqli->query($sql);
		$row = $RS->fetch_assoc();
		extract($row);
	}

?>
<tr>
  <td class="NombreCampo">Crear Exalumno</td>
</tr>
<tr >
  <td><form id="form1" name="form1" method="post" action="">
    <table width="100%%">
      <tr>
        <td align="right" class="NombreCampo">C&oacute;digo:</td>
        <td class="FondoCampo"><?php echo $CodigoAlumno ?></td>
      </tr>
      <tr>
        <td width="50%" align="right" class="NombreCampo">C&eacute;dula:</td>
        <td width="50%" class="FondoCampo"><label for="CedulaLetra"></label>
          <input name="CedulaLetra" type="text" id="CedulaLetra" value="<?php echo $CedulaLetra ?>" size="5" />
          -
          <input name="Cedula" type="hidden" id="Cedula"  value="<?php echo $_GET['Cedula'] ?>" />
          <?php echo $_GET['Cedula'] ?></td>
      </tr>
      <tr>
        <td align="right" class="NombreCampo">Nombres:</td>
        <td class="FondoCampo"><label for="Nombres"></label>
          <input name="Nombres" type="text" id="Nombres" value="<?php echo $Nombres ?>" size="20" /> <input name="Nombres2" type="text" id="Nombres2" value="<?php echo $Nombres2 ?>" size="20" /></td>
      </tr>
      <tr>
        <td align="right" class="NombreCampo">Apellidos:</td>
        <td class="FondoCampo"><input name="Apellidos" type="text" id="Apellidos" value="<?php echo $Apellidos ?>" size="20" />
          <input name="Apellidos2" type="text" id="Apellidos2" value="<?php echo $Apellidos2 ?>" size="20" /></td>
      </tr>
      <tr>
        <td align="right" class="NombreCampo">Sexo:</td>
        <td class="FondoCampo"><input name="Sexo" type="text" id="Sexo" value="<?php echo $Sexo ?>" size="5" /></td>
      </tr>
      <tr>
        <td align="right" class="NombreCampo">Fecha Nacimiento:</td>
        <td class="FondoCampo"><input name="FechaNac" type="date" id="FechaNac" value="<?php echo $FechaNac ?>" size="20" /></td>
      </tr>
      <tr>
        <td align="right" class="NombreCampo">Nacionalidad:</td>
        <td class="FondoCampo"><input name="Nacionalidad" type="text" id="Nacionalidad" value="<?php echo $Nacionalidad ?>" size="20" /></td>
      </tr>
      <tr>
        <td align="right" class="NombreCampo">Localidad:</td>
        <td class="FondoCampo"><input name="Localidad" type="text" id="Localidad" value="<?php echo $Localidad ?>" size="20" /></td>
      </tr>
      <tr>
        <td align="right" class="NombreCampo">Pais:</td>
        <td class="FondoCampo"><input name="LocalidadPais" type="text" id="LocalidadPais" value="<?php echo $LocalidadPais ?>" size="20" /></td>
      </tr>
      <tr>
        <td align="right" class="NombreCampo">Entidad:</td>
        <td class="FondoCampo"><input name="Entidad" type="text" id="Entidad" value="<?php echo $Entidad ?>" size="20" /></td>
      </tr>
      <tr>
        <td align="right" class="NombreCampo">EntidadCorta:</td>
        <td class="FondoCampo"><input name="EntidadCorta" type="text" id="EntidadCorta" value="<?php echo $EntidadCorta ?>" size="5" /></td>
      </tr>
      <tr>
        <td align="right" class="NombreCampo">Tel:</td>
        <td class="FondoCampo"><input name="TelHab" type="text" id="TelHab" value="<?php echo $TelHab ?>" size="20" /></td>
      </tr>
      <tr>
        <td align="right" class="NombreCampo">Cel:</td>
        <td class="FondoCampo"><input name="TelCel" type="text" id="TelCel" value="<?php echo $TelCel ?>" size="20" /></td>
      </tr>
      <tr>
        <td align="right" class="NombreCampo">Email1:</td>
        <td class="FondoCampo"><input name="Email1" type="text" id="Email1" value="<?php echo $Email1 ?>" size="40" /></td>
      </tr>
      <tr>
        <td align="right" class="NombreCampo">&nbsp;</td>
        <td class="FondoCampo">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="submit" name="Actualizar" id="Actualizar" value="Actualizar" /></td>
      </tr>
  </table>
  
  <input name="Accion" type="hidden" value="<?php if($_GET['Crear'] == 1) { echo "INSERT";} else { echo "UPDATE";}  ?>" />
  </form></td>
</tr>
<?php } ?>


    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
</table>
</body>
</html>