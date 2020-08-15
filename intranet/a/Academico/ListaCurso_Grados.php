<?php
$MM_authorizedUsers = "91,95,secreAcad,AsistDireccion";

require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');

  mysql_select_db($database_bd, $bd);


$editFormAction = $_SERVER['PHP_SELF'];
if(isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?CodigoCurso=" . $_GET['CodigoCurso'];
if(isset($_GET['AnoEscolar']))
  $editFormAction .= "&AnoEscolar=" . $_GET['AnoEscolar'];
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {

$LocalidadPais = ucwords(strtolower(trim($_POST['LocalidadPais'])));

$Localidad = ucwords(strtolower(trim($_POST['Localidad'])));
$Entidad = ucwords(strtolower(trim($_POST['Entidad'])));
$EntidadCorta = ucwords(strtolower(trim($_POST['EntidadCorta'])));	

if($EntidadCorta == 'Dc' or $EntidadCorta == 'Df')
	$EntidadCorta = strtoupper($EntidadCorta);	

switch ($Localidad) {
   case "Chacao":
         $Entidad = "Miranda";
		 $EntidadCorta = "Mi";
         break;
   case "Baruta":
         $Entidad = "Miranda";
		 $EntidadCorta = "Mi";
         break;
   case "Sucre":
         $Entidad = "Miranda";
		 $EntidadCorta = "Mi";
         break;
   case "Libertador":
         $Entidad = "Distrito Capital";
		 $EntidadCorta = "DC";
         break;
   //case "Caracas":
   //      $Entidad = "Distrito Capital";
	//	 $EntidadCorta = "DC";
     //    break;
}
	
	
  $updateSQL = sprintf("UPDATE Alumno SET Actualizado_el=%s, Actualizado_por=%s, Cedula=%s, Cedula_int=%s, CedulaLetra=%s, Nombres=%s, Nombres2=%s, Apellidos=%s, Apellidos2=%s, Sexo=%s, FechaNac=%s, Nacionalidad=%s, ClinicaDeNac=%s, Localidad=%s, LocalidadPais=%s, Entidad=%s, EntidadCorta=%s , Datos_Revisado_por=%s, Datos_Revisado_Fecha=NOW(), Datos_Observaciones=%s, EscolaridadObserv=%s WHERE CodigoAlumno=%s",
                       GetSQLValueString($_POST['Actualizado_el'], "date"),
                       GetSQLValueString($_POST['Actualizado_por'], "text"),
                       GetSQLValueString(trim($_POST['Cedula']), "text"),
                       GetSQLValueString($_POST['Cedula']*1, "text"),
                       GetSQLValueString(ucwords(strtoupper(trim($_POST['CedulaLetra']))), "text"),
                       GetSQLValueString(ucwords(strtolower(trim($_POST['Nombres']))), "text"),
                       GetSQLValueString(ucwords(strtolower(trim($_POST['Nombres2']))), "text"),
                       GetSQLValueString(ucwords(strtolower(trim($_POST['Apellidos']))), "text"),
                       GetSQLValueString(ucwords(strtolower(trim($_POST['Apellidos2']))), "text"),
                       GetSQLValueString(ucwords(strtoupper(trim($_POST['Sexo']))), "text"),
                       GetSQLValueString($_POST['FechaNac'], "date"),
                       GetSQLValueString(ucwords(strtolower(trim($_POST['Nacionalidad']))), "text"),
                       GetSQLValueString(ucwords(strtolower(trim($_POST['ClinicaDeNac']))), "text"),
                       GetSQLValueString($Localidad, "text"),
                       GetSQLValueString($LocalidadPais, "text"),
                       GetSQLValueString($Entidad, "text"),
                       GetSQLValueString($EntidadCorta , "text"),
                       GetSQLValueString(ucwords(strtolower(trim($MM_Username))) , "text"),
                       GetSQLValueString(trim($_POST['Datos_Observaciones']), "text"),
                       GetSQLValueString(trim($_POST['EscolaridadObserv']), "text"),
                       GetSQLValueString($_POST['CodigoAlumno'], "int"));

  $Result1 = mysql_query($updateSQL, $bd) or die(mysql_error());
}

$colname_RS_Curso = "0";
if (isset($_GET['CodigoCurso'])) {
  $colname_RS_Curso = (get_magic_quotes_gpc()) ? $_GET['CodigoCurso'] : addslashes($_GET['CodigoCurso']);
}
$query_RS_Curso = sprintf("SELECT * FROM Curso WHERE CodigoCurso = %s", $colname_RS_Curso);
$RS_Curso = mysql_query($query_RS_Curso, $bd) or die(mysql_error());
$row_RS_Curso = mysql_fetch_assoc($RS_Curso);
$totalRows_RS_Curso = mysql_num_rows($RS_Curso);



$colname_RS_Alumno = "-1";
if (isset($_GET['CodigoCurso'])) {
  $colname_RS_Alumno = (get_magic_quotes_gpc()) ? $_GET['CodigoCurso'] : addslashes($_GET['CodigoCurso']);
}

$RS_Alumno = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumno = mysql_fetch_assoc($RS_Alumno);
$totalRows_RS_Alumno = mysql_num_rows($RS_Alumno);


$query_RS_Cursos = "SELECT * FROM Curso ORDER BY NivelMencion ASC, Curso.Curso, Curso.Seccion";
$RS_Cursos = mysql_query($query_RS_Cursos, $bd) or die(mysql_error());
$row_RS_Cursos = mysql_fetch_assoc($RS_Cursos);
$totalRows_RS_Cursos = mysql_num_rows($RS_Cursos);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Administraci&oacute;n SFDA</title>
<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
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
<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
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
<link href="../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1500" border="0" align="center">
  <tr>
    <td><?php 
	$TituloPantalla = $row_RS_Curso['NombreCompleto'];
	require_once('../TitAdmin.php'); ?></td>
  </tr>
  <tr>
  <tr>
    <td colspan="2" align="center"><table width="100%"  border="0" align="center" cellpadding="2">
        <tr>
          <td colspan="3" class="NombreCampoBIG"><?php 
		  
		  $extraOpcion = $_SERVER['PHP_SELF'] ."?";
		  if(isset($_GET['AnoEscolar']))
			  $extraOpcion.= "AnoEscolar=".$_GET['AnoEscolar']."&";
		  $extraOpcion.= "CodigoCurso=";	
				  
		  Ir_a_Curso($_GET['CodigoCurso'],$extraOpcion);
		  
		  
		  ?>          </td>
        </tr>
        <tr>
          <td colspan="2" class="NombreCampo"><p> <a href="../ListaCurso_Datos_Min_Print.php?CodigoCurso=<?php echo $_GET['CodigoCurso'] ?>" target="_blank">Imprimir</a> | <a href="../Lista/Datos_Seguro_xls.php?CodigoCurso=<?php echo $_GET['CodigoCurso'] ?>"> Download Curso</a> | <a href="../Lista/Datos_Seguro_xls.php?Orden=Cedula">Download Seguro</a></p>          </td>
        </tr>
                <tr>
          <td width="5" nowrap="nowrap" class="FondoCampo"><strong>No.</strong> </td>
          <td align="left"  nowrap="nowrap" class="FondoCampo">00000 
              <input name="CedulaLetra" type="text" id="CedulaLetra" value="V/E" size="1" />
              <input name="Cedula" type="text" id="Cedula" value="Cedula" size="14" />
              <input name="Apellidos" type="text" id="Apellidos" value="Apellido 1" size="9" />
              <input name="Apellidos2" type="text" id="Apellidos2" value="Apellido 2" size="9" />
              <input name="Nombres" type="text" id="Nombres" value="Nombre 1" size="9" />
              <input name="Nombres2" type="text" id="Nombres2" value="Nombre 2" size="9" />
               <input name="Sexo" type="text" id="Sexo" value="Sexo" size="1" />
              <input name="Fecha Nacimiento" type="text" id="FechaNac" value="Fecha Nacimiento" size="20" />
              <input name="Nacionalidad" type="text" id="Nacionalidad" value="Nacionalidad" size="2" />
              <input name="Clinica De Nac" type="text" id="ClinicaDeNac" value="Clinica De Nac" size="15" />
              <input name="Localidad" type="text" id="Localidad" value="Localidad" size="15" />
              <input name="Entidad" type="text" id="Entidad" value="Entidad" size="25" />
            <input name="LocalidadPais" type="text" id="LocalidadPais" value="Pais" size="10" />
            <input name="Datos_Revisado_por" type="text" id="Datos_Revisado_por" value="Obser" size="5" /></td>
        </tr>

        <?php do { ?>
        <?php if ($totalRows_RS_Alumno > 0) { // Show if recordset not empty 		?>
            <tr>
              <td colspan="2" nowrap="nowrap" <?php ListaFondo($sw , $Verde) ;?>><iframe src="iFr/Grados_Alumno.php?No=<?php echo ++$No; ?>&CodigoAlumno=<?php echo $row_RS_Alumno['CodigoAlumno'] ?>" seamless="seamless" frameborder="0" width="100%" height="27" scrolling="no"></iframe></td>
            </tr>
            <?php if (false){ ?>
            <tr>
          <td width="5" nowrap="nowrap" <?php ListaFondo($sw , $Verde) ;?>><strong><?php echo ++$i; echo ") "; ?></strong> </td>
          <td  nowrap="nowrap"  <?php $sw = ListaFondo($sw , $Verde) ;?>>
          <form id="form2" name="form2" method="POST" action="<?php echo $editFormAction; ?>&Linea=<?php echo $i-1; ?>#<?php echo $i; ?>">
          
<?php  

$query_RS_Repre = "SELECT * FROM Representante WHERE Creador='".$row_RS_Alumno['Creador']."' AND Nexo LIKE '%%Ma%%'";//echo $query_RS_Repre;
$RS_Repre = mysql_query($query_RS_Repre, $bd) or die(mysql_error());
$row_RS_Repre = mysql_fetch_assoc($RS_Repre);
$totalRows_RS_Repre = mysql_num_rows($RS_Repre);



 ?><a href="../PlanillaImprimirADM.php?CodigoAlumno=<?php echo  $row_RS_Alumno['CodigoAlumno'] ?>" target="_blank"><?php echo  $row_RS_Alumno['CodigoAlumno'] ?></a><a name="lista" id="<?php if($i > 15 ) {echo $i-1;} ?>"></a> 
              <input name="CodigoAlumno" type="hidden" id="hiddenField" value="<?php echo  $row_RS_Alumno['CodigoAlumno'] ?>" />
              <input name="Actualizar_FMP" type="hidden" id="hiddenField" value="1" />
              <input name="Actualizado_el" type="hidden" id="hiddenField" value="<?php echo  date('Y-m-d'); ?>" />
              <input name="Actualizado_por" type="hidden" id="hiddenField" value="<?php echo  $MM_Username ?>" />
              <input name="CedulaLetra" type="text" id="CedulaLetra" value="<?php if($row_RS_Alumno['CedulaLetra']=='') echo "V"; else echo  $row_RS_Alumno['CedulaLetra'] ?>" size="1" /><?php if($row_RS_Alumno['CedulaLetra']=='') echo "*"; ?>
              <input name="Cedula" type="text" id="Cedula" value="<?php 
			  
			  if($row_RS_Alumno['Cedula']=='')  {
			  
			  $ciMama = str_replace('.','', $row_RS_Repre['Cedula']);
			  $ciMama = str_replace('-','', $ciMama);
			  $ciMama = str_replace('v','', $ciMama);
			  $ciMama = str_replace('V','', $ciMama);
			  $ciMama = str_replace('e','', $ciMama);
			  $ciMama = str_replace('E','', $ciMama);
			  $ciMama = substr("000000000".$ciMama, -8);
			  
			  echo '1'.substr($row_RS_Alumno['FechaNac'],2,2).$ciMama;} else echo  $row_RS_Alumno['Cedula']; 
			  
			  
			  ?>" size="14" />
              <?php if($row_RS_Alumno['Cedula']=='')  {  echo '*';} ?>
              <input name="Apellidos" type="text" id="Apellidos" value="<?php echo  $row_RS_Alumno['Apellidos'] ?>" size="9" />
              <input name="Apellidos2" type="text" id="Apellidos2" value="<?php echo  $row_RS_Alumno['Apellidos2'] ?>" size="9" />
              <input name="Nombres" type="text" id="Nombres" value="<?php echo  $row_RS_Alumno['Nombres'] ?>" size="9" />
              <input name="Nombres2" type="text" id="Nombres2" value="<?php echo  $row_RS_Alumno['Nombres2'] ?>" size="9" />
              <input name="Sexo" type="text" id="Sexo" value="<?php echo  $row_RS_Alumno['Sexo'] ?>" size="1" />
              <input name="FechaNac" type="date" id="FechaNac" value="<?php echo  $row_RS_Alumno['FechaNac'] ?>" size="10" />
              <input name="Nacionalidad" type="text" id="Nacionalidad" value="<?php echo  $row_RS_Alumno['Nacionalidad'] ?>" size="2" />
              <input name="ClinicaDeNac" type="text" id="ClinicaDeNac" value="<?php echo  $row_RS_Alumno['ClinicaDeNac'] ?>" size="15" />
              <input name="Localidad" type="text" id="Localidad" value="<?php echo  $row_RS_Alumno['Localidad'] ?>" size="15" />
              <input name="Entidad" type="text" id="Entidad" value="<?php echo  $row_RS_Alumno['Entidad'] ?>" size="15" />
              <input name="EntidadCorta" type="text" id="EntidadCorta" value="<?php echo  $row_RS_Alumno['EntidadCorta'] ?>" size="2" />
              <input name="LocalidadPais" type="text" id="LocalidadPais" value="<?php echo  $row_RS_Alumno['LocalidadPais'] ?>" size="2" />
              
              <input name="Datos_Observaciones" type="text" id="Datos_Observaciones" value="<?php echo  $row_RS_Alumno['Datos_Observaciones'] ?>" size="5" />
              <input name="EscolaridadObserv" type="hidden" id="EscolaridadObserv" value="<?php echo  $row_RS_Alumno['EscolaridadObserv'] ?>" size="10" />
              <label>
              <input name="Datos_Revisado_por" type="hidden" id="Datos_Revisado_por" value="<?php echo  $row_RS_Alumno['Datos_Revisado_por'] ?>" size="2" />
              <?php echo  $row_RS_Alumno['Datos_Revisado_por'] ?>&nbsp;
			  <?php echo $row_RS_Alumno['Datos_Revisado_Fecha'] ?>
              <input type="submit" name="Guardar" id="Guardar" value="G" />
              </label>

 <?php if ( $MM_UserGroup == 91 or $MM_UserGroup == 95 or $MM_UserGroup == "secreAcad" ){ ?>
          <input type="hidden" name="MM_update" value="form2" />
		  <?php } ?>
              
              <?php if ($row_RS_Alumno['Datos_Observaciones'] > " " and false) { ?><br /><b><?php echo $row_RS_Alumno['Datos_Observaciones']; } ?></b>
          </form></td>
          </tr>
          <?php }?>
        <?php } // Show if recordset not empty ?>
        <?php } while ($row_RS_Alumno = mysql_fetch_assoc($RS_Alumno)); ?>
    </table></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var MenuBar2 = new Spry.Widget.MenuBar("MenuBar2", {imgDown:"../SpryAssets/SpryMenuBarDownHover.gif", imgRight:"../SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>


</body>
</html>
