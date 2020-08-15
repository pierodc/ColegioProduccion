<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');

//mysql_select_db($database_bd, $bd);
$_AnoEscolar = str_replace('-','',$AnoEscolar);

// FALTA 
// CREAR DIRECTORIO SI NO EXISTE


if(isset($_POST['Tipo'])){
	$Tipo = $_POST['Tipo'];
	$Cedula = $_POST['Cedula'];
	$Codigo = $_POST['Codigo'];
	}
else{	
	$Tipo = $_GET['Tipo'];
	$Cedula = $_GET['Cedula'];
	$Codigo = $_GET['Codigo'];
	}



if($Tipo == 'Empleado')					$NombreArchivo =  $_SERVER['DOCUMENT_ROOT'] . "/f/" . "FotoEmp/";
elseif($Tipo == 'Empleado300')			$NombreArchivo =  $_SERVER['DOCUMENT_ROOT'] . "/f/" . "FotoEmp/300/";
elseif($Tipo == 'Empleado150')			$NombreArchivo =  $_SERVER['DOCUMENT_ROOT'] . "/f/" . "FotoEmp/150/";
elseif($Tipo == 'EmpleadoCedula600')	$NombreArchivo = "Archivo/ci/";

elseif($Tipo == 'EmpleadoCedula100')	$NombreArchivo = "Archivo/ci/100/";
elseif($Tipo == 'Alumno150')			$NombreArchivo = $_SERVER['DOCUMENT_ROOT'] . "/f/".date('Y')."/150/";
elseif($Tipo == 'Alumno300')			$NombreArchivo = $_SERVER['DOCUMENT_ROOT'] . "/f/".date('Y')."/300/";

else								$NombreArchivo = $_SERVER['DOCUMENT_ROOT'] . "/f/".date('Y')."/600/";

if($Tipo == 'EmpleadoCedula600')		$NombreArchivo = "archivo/ci/".$Cedula.'.jpg';
elseif($Tipo == 'EmpleadoCedula100')	$NombreArchivo = "archivo/ci/100/".$Cedula.'.jpg';
else									$NombreArchivo .= $Codigo.'.jpg';


// Sube Archivo al servidor
if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
	
	copy($_FILES['userfile']['tmp_name'], $NombreArchivo );

} else {
   // echo "Possible file upload attack. Filename: " . $_FILES['userfile']['name'];
}


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Sube Archivo Foto</title>
<link href="../../estilos2.css" rel="stylesheet" type="text/css" />
<link href="../../estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form enctype="multipart/form-data" action="" method="post">
      <table width="600" border="0" align="center">
        <tr>
          <td colspan="2" class="subtitle">Enviar Foto </td>
        </tr>
        <tr>
          <td valign="top" class="NombreCampo">Tipo</td>
          <td valign="top" class="FondoCampo"><select name="Tipo" id="Tipo" >
    <option value="0">Seleccione...</option>
    <option value="Empleado" <?php if ($Tipo=='Empleado') echo 'selected="selected"'; ?> >Empleado 600x600</option>
    <option value="Empleado300" <?php if ($Tipo=='Empleado300') echo 'selected="selected"'; ?> >Empleado 300x300</option>
    <option value="Empleado150" <?php if ($Tipo=='Empleado150') echo 'selected="selected"'; ?> >Empleado 150x150</option>
    <option value="EmpleadoCedula600" <?php if ($Tipo=='EmpleadoCedula600') echo 'selected="selected"'; ?> >Empleado Cedula 600</option>
    <option value="EmpleadoCedula100" <?php if ($Tipo=='EmpleadoCedula100') echo 'selected="selected"'; ?> >Empleado Cedula 100</option>
    <option value="Alumno" <?php if ($Tipo=='Alumno') echo 'selected="selected"'; ?>>Alumno</option>
    <option value="Alumno150" <?php if ($Tipo=='Alumno150') echo 'selected="selected"'; ?>>Alumno 150</option>
    <option value="Alumno300" <?php if ($Tipo=='Alumno300') echo 'selected="selected"'; ?>>Alumno 300</option>
    
  </select>
</td>
        </tr>
        <tr>
          <td valign="top" class="NombreCampo">Codigo</td>
          <td valign="top" class="FondoCampo">
          <input name="Codigo" type="text" id="Codigo" value="<?php echo $_GET['Codigo']; ?>" /></td>
        </tr>
        <tr>
          <td valign="top" class="NombreCampo">Cedula</td>
          <td valign="top" class="FondoCampo"><input name="Cedula" type="text" id="Cedula" value="<?php echo $_GET['Cedula']; ?>" /></td>
        </tr>
        <tr>
          <td valign="top" class="NombreCampo">Archivo</td>
          <td valign="top" class="FondoCampo"><input name="userfile" type="file" /></td>
        </tr>
        <tr>
          <td><input type="hidden" name="MAX_FILE_SIZE" value="1000000" /></td>
          <td><input type="submit" value="Enviar" /></td>
        </tr>
        <tr>
          <td colspan="2" align="center"><table width="100%%" border="0" cellspacing="5" cellpadding="3">
            <tr>
              <td align="center" valign="top" class="FondoCampo">&nbsp;</td>
              <td align="center" valign="top" class="FondoCampo">300 x 300</td>
              <td align="center" valign="top" class="FondoCampo">600 x 600</td>
            </tr>
            <tr>
              <td align="center" valign="top" class="FondoCampo">&nbsp;</td>
              <td align="center" valign="top" class="FondoCampo"><img src="../../<?php echo $AnoEscolar ?>/300/<?php echo $Codigo.'.jpg'; ?>" alt=""  /></td>
              <td align="center" valign="top" class="FondoCampo"><img src="../../<?php echo $AnoEscolar ?>/<?php echo $Codigo.'.jpg'; ?>" alt=""  /></td>
            </tr>
            <tr>
              <td align="center" valign="top" class="FondoCampo">150 x 150</td>
              <td align="center" valign="top" class="FondoCampo">300 x 300</td>
              <td align="center" valign="top" class="FondoCampo">600 x 600</td>
            </tr>
            <tr>
              <td align="center" valign="top" class="FondoCampo"><span class="FondoCampo"><img src="../../FotoEmp/150/<?php echo $Codigo.'.jpg'; ?>"  /></span></td>
              <td align="center" valign="top" class="FondoCampo"><span class="FondoCampo"><img src="../../FotoEmp/300/<?php echo $Codigo.'.jpg'; ?>"  /></span></td>
              <td align="center" valign="top" class="FondoCampo"><span class="FondoCampo"><img src="../../FotoEmp/<?php echo $Codigo.'.jpg'; ?>"  /></span></td>
            </tr>
            <tr>
              <td align="center" valign="top" class="FondoCampo">100 x ...</td>
              <td colspan="2" align="center" valign="top" class="FondoCampo">600 x ...</td>
            </tr>
            <tr>
              <td align="center" valign="top" class="FondoCampo"><span class="FondoCampo"><img src="archivo/ci/100/<?php echo $Cedula.'.jpg'; ?>"  /></span></td>
              <td colspan="2" align="center" valign="top" class="FondoCampo"><span class="FondoCampo"><img src="archivo/ci/<?php echo $Cedula.'.jpg'; ?>"  /></span></td>
            </tr>
          </table>
          <br></td>
        </tr>
      </table>
</form>
  

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

    
</body>
</html>