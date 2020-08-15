<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] .'/Connections/bd.php');
require_once($_SERVER['DOCUMENT_ROOT'] .'/inc/rutinas.php');
//mysql_select_db($database_bd, $bd);

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
	

$NombreArchivo = $_SERVER['DOCUMENT_ROOT'] ."/FotoEmp/150".$Codigo.$Tipo.".jpg";


// Sube Archivo al servidor
if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
	copy($_FILES['userfile']['tmp_name'], $NombreArchivo );
	header("Location: Lista.php");
} else {
   // echo "Possible file upload attack. Filename: " . $_FILES['userfile']['name'];
}

//echo '$php_self'.$php_self;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Sube Archivo Foto</title>
<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />
<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>

<form enctype="multipart/form-data" action="http://www.colegiosanfrancisco.com<?= $php_self."?CodigoPropietario=".$_GET['CodigoPropietario']; ?>" method="post">
      <table width="800" border="0" align="center">

<?php if (isset($_GET['Tipo'])) { ?>
        <tr>
          <td colspan="2" class="subtitle">Enviar Foto </td>
        </tr>
        <tr>
          <td valign="top" class="NombreCampo">Archivo JPG</td>
          <td valign="top" class="FondoCampo"><input name="userfile" type="file" />
          <input name="Codigo" type="hidden" id="Codigo" value="<?php echo $Codigo; ?>" />
          <input name="Tipo" type="hidden" id="Tipo" value="<?php echo $_GET['Tipo']; ?>" /> 
          Solo archivos de imagen JPG</td>
        </tr>
        <tr>
          <td><input type="hidden" name="MAX_FILE_SIZE" value="300000" /></td>
          <td><input type="submit" value="Enviar" /></td>
        </tr>
        <?php } ?>
        <tr>
          <td colspan="2" align="center">

          <table width="100%%" border="0" cellspacing="5" cellpadding="3">
            <tr>
              <td width="50%" align="center" valign="top" class="NombreCampoBIG">Foto</td>
              <td align="center" valign="top" class="NombreCampoBIG">Cedula Alumno</td>
            </tr>
            <tr>
              <td width="50%" align="center" valign="middle" class="FondoCampo">
              <?php 
			  $Tipo = '';
			  $foto = "http://".$_SERVER['HTTP_HOST']. "/FotoEmp/150".$Codigo.$Tipo.".jpg";
			  if(file_exists($foto)){ ?>
              <img src="<?php echo $foto; ?>" width="100"  />
              <br />
              <a href="Sube_Foto.php?CodigoPropietario=<?= $_GET['CodigoPropietario'].'&Tipo='.$Tipo ?>"><img src="../../../i/arrow_refresh_small.png" width="32" height="32" alt=""/>Cambiar</a>
<?php }else{ ?>
              <a href="Sube_Foto.php?CodigoPropietario=<?= $_GET['CodigoPropietario'].'&Tipo='.$Tipo ?>">
              <img src="../../../i/Folder-Add32.png" width="32" height="32" alt=""/><br />
              Cargar</a><?php } ?></td>
              <td align="center" valign="middle" class="FondoCampo"><?php 
			  $Tipo = 'ci';
			  $foto = "http://".$_SERVER['HTTP_HOST']. "/intranet/a/archivo/ci/".$Cedula.".jpg";
			  if(file_exists($foto)){ ?>
                <img src="<?php echo $foto; ?>" width="100"  />
                <br />
                <a href="Sube_Foto.php?Cedula=<?= $_GET['Cedula'] ?>"><img src="../../../i/arrow_refresh_small.png" width="32" height="32" alt=""/>Cambiar</a>
                <?php }else{ ?>
                <a href="Sube_Foto.php?Cedula=<?= $_GET['Cedula'] ?>"> <img src="../../../i/Folder-Add32.png" width="32" height="32" alt=""/><br />
Cargar</a>
              <?php } ?></td>
            </tr>
          </table>
          <?php // } ?>
          
          </td>
        </tr>
        
      </table>
</form>
  


    
</body>
</html>