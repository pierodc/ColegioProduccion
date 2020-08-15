<?php 
require_once('../../Connections/bd.php');
require_once('../../inc/rutinas.php');
mysql_select_db($database_bd, $bd);
$_AnoEscolar = str_replace('-','',$AnoEscolar);

// Sube Archivo al servidor
if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
	$NombreArchivo = $_POST['Curso'].$_POST['Seccion']."_".$_POST['Materia']."";
	$NombreArchivo = "../../Publicaciones/".$_AnoEscolar."/".$_POST['Lapso']."/".$NombreArchivo.".doc";
    copy($_FILES['userfile']['tmp_name'], $NombreArchivo );
} else {
   // echo "Possible file upload attack. Filename: " . $_FILES['userfile']['name'];
}



?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Sube Archivo</title>
<link href="../../estilos2.css" rel="stylesheet" type="text/css" />
<link href="../../estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form enctype="multipart/form-data" action="" method="post">
      <table width="600" border="0" align="center">
        <tr>
          <td colspan="2" class="subtitle">Enviar Archivo (Publicaciones)</td>
        </tr>
        <tr>
          <td valign="top" class="NombreCampo">Lapso</td>
          <td valign="top" class="FondoCampo"><label for="select2"></label>
            <select name="Lapso" id="Lapso">
              <option value="i" <?php if ($_POST['Lapso']=='i') echo 'selected="selected"'; ?>>1er Lapso</option>
              <option value="ii" <?php if ($_POST['Lapso']=='ii') echo 'selected="selected"'; ?>>2do Lapso</option>
              <option value="iii" <?php if ($_POST['Lapso']=='iii') echo 'selected="selected"'; ?>>3er Lapso</option>
          </select></td>
        </tr>
        <tr>
          <td valign="top" class="NombreCampo">Curso</td>
          <td valign="top" class="FondoCampo">
            <select name="Curso" id="Curso">
              <option value="0">Seleccione...</option>
              <option value="1a" <?php if ($_POST['Curso']=='1a') echo 'selected="selected"'; ?>>1</option>
              <option value="2a" <?php if ($_POST['Curso']=='2a') echo 'selected="selected"'; ?>>2</option>
              <option value="3a" <?php if ($_POST['Curso']=='3a') echo 'selected="selected"'; ?>>3</option>
              <option value="4a" <?php if ($_POST['Curso']=='4a') echo 'selected="selected"'; ?>>4</option>
              <option value="5a" <?php if ($_POST['Curso']=='5a') echo 'selected="selected"'; ?>>5</option>
          </select>
          <select name="Seccion" id="Seccion">
            <option value="u">A y B</option>
            <option value="A">A</option>
            <option value="B">B</option>
          </select></td>
        </tr>
        <tr>
          <td valign="top" class="NombreCampo">Materia</td>
          <td valign="top" class="FondoCampo"><select name="Materia" id="Materia" >
    <option value="0">Seleccione...</option>
<?php 
$sql = "SELECT * FROM Materias WHERE 
			CodigoMaterias = '7' OR 
			CodigoMaterias = '8' OR 
			CodigoMaterias = '9' OR 
			CodigoMaterias = 'V' OR 
			CodigoMaterias = 'IV' 
			GROUP BY Materia ORDER BY Materia ";
$RS = mysql_query($sql, $bd) or die(mysql_error());
$row = mysql_fetch_assoc($RS);
do {
	extract($row);
	$Cod_Materia = $Materia;
	$Cod_Materia = str_replace('.','_p_',$Cod_Materia);
	$Cod_Materia = str_replace('á','_a_',$Cod_Materia);
	$Cod_Materia = str_replace('é','_e_',$Cod_Materia);
	$Cod_Materia = str_replace('í','_i_',$Cod_Materia);
	$Cod_Materia = str_replace('ó','_o_',$Cod_Materia);
	$Cod_Materia = str_replace('ú','_u_',$Cod_Materia);
	$Cod_Materia = str_replace(' ','__',$Cod_Materia);
	
	echo "<option value=\"$Cod_Materia\">$Materia</option>\r\n";
} while($row = mysql_fetch_assoc($RS));


?>    
    
  </select>
</td>
        </tr>
        <tr>
          <td valign="top" class="NombreCampo">Archivo</td>
          <td valign="top" class="FondoCampo"><input name="userfile" type="file" /></td>
        </tr>
        <tr>
          <td><input type="hidden" name="MAX_FILE_SIZE" value="1000000" /></td>
          <td><input type="submit" value="Enviar" /></td>
        </tr>
      </table>
    </form>
    
<?php 

$dir = "../../Publicaciones/".$_AnoEscolar."/iii/";
 
// Abre un directorio conocido, y procede a leer el contenido
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
			if(filetype($dir . $file) <> 'dir'){
				
            $Curso 		= substr($file,0,1);	
			$Nivel 		= substr($file,1,1);	
			$Seccion	= substr($file,2,1);
			$Materia	= substr($file,4,40);
			
			$Materia = str_replace('_p_','.',$Materia);
			$Materia = str_replace('_a_','á',$Materia);
			$Materia = str_replace('_e_','é',$Materia);
			$Materia = str_replace('_i_','í',$Materia);
			$Materia = str_replace('_o_','ó',$Materia);
			$Materia = str_replace('_u_','ú',$Materia);
			$Materia = str_replace('__' ,' ',$Materia);
			$Materia = str_replace('.doc','',$Materia);

			$Archivo[$Nivel][$Curso][$Seccion] = $Materia;
			
			 
				echo "archivo: $file $Materia $Nivel $Curso $Seccion<br>";
			
			
			
			
			}
		}
        closedir($dh);
    }
}


?>    
    
</body>
</html>