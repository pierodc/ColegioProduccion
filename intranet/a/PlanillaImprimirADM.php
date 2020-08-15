<?php
$MM_authorizedUsers = "99,91,95,89,secre,secreAcad,AsistDireccion,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once('../../inc_login_ck.php'); 

require_once('../../Connections/bd.php'); 
require_once('../../inc/rutinas.php'); 
require_once('archivo/Variables.php'); 

$CodigoAlumno = $_GET['CodigoAlumno'];
$Alumno = new Alumno($CodigoAlumno);


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "alumno")) {
  $sql = sprintf("UPDATE Alumno SET Direccion=%s, Urbanizacion=%s, Ciudad=%s, CodPostal=%s, Email1=%s, Email2=%s, TelHab=%s, TelCel=%s, PerEmergencia=%s, PerEmerTel=%s, PerEmerNexo=%s, Datos_Planilla_Mod_Por=%s WHERE CodigoAlumno=%s",
                       GetSQLValueString($_POST['Direccion'], "text"),
                       GetSQLValueString($_POST['Urbanizacion'], "text"),
                       GetSQLValueString($_POST['Ciudad'], "text"),
                       GetSQLValueString($_POST['CodPostal'], "text"),
                       GetSQLValueString($_POST['Email1'], "text"),
                       GetSQLValueString($_POST['Email2'], "text"),
                       GetSQLValueString($_POST['TelHab'], "text"),
                       GetSQLValueString($_POST['TelCel'], "text"),
                       GetSQLValueString($_POST['PerEmergencia'], "text"),
                       GetSQLValueString($_POST['PerEmerTel'], "text"),
                       GetSQLValueString($_POST['PerEmerNexo'], "text"),
					   GetSQLValueString($_SESSION['MM_Username'], "text"), 
                       GetSQLValueString($_POST['CodigoAlumno'], "int"));

	$mysqli->query($sql);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "Padre")) {
  $sql = sprintf("UPDATE Representante SET TelHab=%s, TelCel=%s, TelTra=%s, Email1=%s, Email2=%s, Direccion=%s, Urbanizacion=%s, Ciudad=%s, CodPostal=%s, SWrepre=%s WHERE CodigoRepresentante=%s",
                       GetSQLValueString($_POST['TelHab'], "text"),
                       GetSQLValueString($_POST['TelCel'], "text"),
                       GetSQLValueString($_POST['TelTra'], "text"),
                       GetSQLValueString($_POST['Email1'], "text"),
                       GetSQLValueString($_POST['Email2'], "text"),
                       GetSQLValueString($_POST['Direccion'], "text"),
                       GetSQLValueString($_POST['Urbanizacion'], "text"),
                       GetSQLValueString($_POST['Ciudad'], "text"),
                       GetSQLValueString($_POST['CodPostal'], "text"),
                       GetSQLValueString($_POST['SWrepre'], "text"),
                       GetSQLValueString($_POST['CodigoRepresentante'], "int"));

	$mysqli->query($sql);

if(strpos('   '.strtolower(' ' . $_POST['SWrepre']) ,'s') >=1 )
	 $SWrepre='1';
else $SWrepre='0';
$sql_UPDATE = "UPDATE RepresentanteXAlumno 
				SET SW_Representante = '$SWrepre'
				WHERE CodigoRepresentante = '".$_POST['CodigoRepresentante']."'
				AND CodigoAlumno = '".$_POST['CodigoAlumno']."'";
$Result1 = mysql_query($sql_UPDATE, $bd) or die(mysql_error());
echo  $sql_UPDATE; 


}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "Madre")) {
  $sql = sprintf("UPDATE Representante SET TelHab=%s, TelCel=%s, TelTra=%s, Email1=%s, Email2=%s, Direccion=%s, Urbanizacion=%s, Ciudad=%s, CodPostal=%s, SWrepre=%s WHERE CodigoRepresentante=%s",
                       GetSQLValueString($_POST['TelHab'], "text"),
                       GetSQLValueString($_POST['TelCel'], "text"),
                       GetSQLValueString($_POST['TelTra'], "text"),
                       GetSQLValueString($_POST['Email1'], "text"),
                       GetSQLValueString($_POST['Email2'], "text"),
                       GetSQLValueString($_POST['Direccion'], "text"),
                       GetSQLValueString($_POST['Urbanizacion'], "text"),
                       GetSQLValueString($_POST['Ciudad'], "text"),
                       GetSQLValueString($_POST['CodPostal'], "text"),
                       GetSQLValueString($_POST['SWrepre'], "text"),
                       GetSQLValueString($_POST['CodigoRepresentante'], "int"));

	$mysqli->query($sql);

if(strpos('   '.strtolower(' ' . $_POST['SWrepre']) ,'s') >=1 )
	 $SWrepre='1';
else $SWrepre='0';
$sql_UPDATE = "UPDATE RepresentanteXAlumno 
				SET SW_Representante = '$SWrepre'
				WHERE CodigoRepresentante = '".$_POST['CodigoRepresentante']."'
				AND CodigoAlumno = '".$_POST['CodigoAlumno']."'";
				
$Result1 = mysql_query($sql_UPDATE, $bd) or die(mysql_error());
echo  $sql_UPDATE; 
}


$query_RS_Alumno = sprintf("SELECT * FROM Alumno WHERE CodigoAlumno = '%s' ", $CodigoAlumno);
$RS_Alumno = $mysqli->query($query_RS_Alumno);
$row_RS_Alumno = $RS_Alumno->fetch_assoc();
$totalRows_RS_Alumno = $RS_Alumno->num_rows;


$Creador = $row_RS_Alumno['Creador'];


$query_RS_Autorizado = sprintf("SELECT * FROM Representante WHERE Creador = '%s' AND Nexo = 'Autorizado'", $Creador);
$RS_Autorizado = $mysqli->query($query_RS_Autorizado);
$row_RS_Autorizado = $RS_Autorizado->fetch_assoc();
$totalRows_RS_Autorizado = $RS_Autorizado->num_rows;

$query_RS_AbuelaPaterna = sprintf("SELECT * FROM Abuelos WHERE Creador = '%s' AND Nexo = 'Abuela Paterna'", $Creador);
$RS_AbuelaPaterna = $mysqli->query($query_RS_AbuelaPaterna);
$row_RS_AbuelaPaterna = $RS_AbuelaPaterna->fetch_assoc();
$totalRows_RS_AbuelaPaterna = $RS_AbuelaPaterna->num_rows;

$query_RS_AbueloPaterno = sprintf("SELECT * FROM Abuelos WHERE Creador = '%s' AND Nexo = 'Abuelo Paterno'", $Creador);
$RS_AbueloPaterno = $mysqli->query($query_RS_AbueloPaterno);
$row_RS_AbueloPaterno = $RS_AbueloPaterno->fetch_assoc();
$totalRows_RS_AbueloPaterno = $RS_AbueloPaterno->num_rows;

$query_RS_AbueloMaterno = sprintf("SELECT * FROM Abuelos WHERE Creador = '%s' AND Nexo = 'Abuelo Materno'", $Creador);
$RS_AbueloMaterno = $mysqli->query($query_RS_AbueloMaterno);
$row_RS_AbueloMaterno = $RS_AbueloMaterno->fetch_assoc();
$totalRows_RS_AbueloMaterno = $RS_AbueloMaterno->num_rows;

$query_RS_AbuelaMaterna = sprintf("SELECT * FROM Abuelos WHERE Creador = '%s' AND Nexo = 'Abuela Materna'", $Creador);
$RS_AbuelaMaterna = $mysqli->query($query_RS_AbuelaMaterna);
$row_RS_AbuelaMaterna = $RS_AbuelaMaterna->fetch_assoc();
$totalRows_RS_AbuelaMaterna = $RS_AbuelaMaterna->num_rows;

$query_RS_Curso = "SELECT * FROM AlumnoXCurso 
							WHERE CodigoAlumno = '$CodigoAlumno'
							ORDER BY Ano DESC";
$RS_Curso = $mysqli->query($query_RS_Curso);
$row_RS_Curso = $RS_Curso->fetch_assoc();
$totalRows_RS_Curso = $RS_Curso->num_rows;

$CodigoCurso = $row_RS_Curso['CodigoCurso'];
$AnoCurso = $row_RS_Curso['Ano'];
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Planilla de Inscripci&oacute;n: <?php echo $row_RS_Alumno['CodigoAlumno']; ?></title>
<link href="../../estilos2.css" rel="stylesheet" type="text/css">
<link href="../../estilos.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body onLoad="NOprint()">
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td >
      <table width="100%"  border="0">
        <tr>
          <td nowrap   class="RTitulo"><img src="../../img/NombreCol_az.jpg" width="232" height="52"><br></td>
          <td  class="RTitulo">&nbsp;</td>
        </tr>
      </table>    </td>
  </tr>
  <tr>
    <td valign="top"><table width="100%"  border="0" cellpadding="5" >
        <tr align="center" valign="middle">
          <td width="1%">
           <img src="<?php echo $Alumno->Foto("","h") ?>" width="150" height="150"  border="0" /></td>
           
           
     <?php      
$Familia = array('p','m','a1','a2','a3');
foreach($Familia as $id){ ?>
    <td align="center" valign="top">
    <img src="<?php echo $Alumno->Foto($id,"h") ?>" alt="" height="150" border="0" /></td>
<?php } ?>  
          
        </tr>
        <tr align="center" valign="middle">
          <td>Alumno</td>
          <td>Pap&aacute;Mam&aacute;Autorizado 1Autorizado 2Autorizado 3</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top"><?php 
	$Firma = '../Foto_Repre/'.$row_RS_Alumno ['CodigoAlumno'].'f.jpg';
if(file_exists($Firma)){
	  ?><img src="<?= $Firma ?>" /><?php } ?></td>
  </tr>
  <tr>
    <td valign="top">    <table width="100%"  border="0" align="center" cellpadding="5" >
        <tr>
          <td align="left" class="subtitle" >Datos del Alumno </td>
        </tr>
        <tr>
          <td> <form action="<?php echo $editFormAction; ?>" method="POST" name="alumno">           <table width="100%" border="0" align="center" cellpadding="5" >
              <tr valign="baseline">
                <td colspan="2" align="right" width="50%">&nbsp;</td>
                <td colspan="2" align="right" width="50%">&nbsp;</td>
                </tr>
              <tr valign="baseline">
                <td align="right"  class="NombreCampo">&nbsp;</td>
                <td align="left"  class="FondoCampo"><?php echo $row_RS_Alumno['Creador']; ?></td>
                <td align="right"  class="NombreCampo">Codigo Alumno:</td>
                <td align="left"  class="FondoCampo"><input name="CodigoAlumno" type="hidden" id="hiddenField" value="<?php echo $row_RS_Alumno['CodigoAlumno']; ?>">
               <?php echo $row_RS_Alumno['CodigoAlumno']; ?></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top"  class="NombreCampo">C&eacute;dula</td>
                <td align="left" valign="top"  class="FondoCampo"><?php echo $row_RS_Alumno['CedulaLetra']; ?>- <?php echo $row_RS_Alumno['Cedula']; ?> </td>
                <td align="right" valign="top"  class="NombreCampo">Curso</td>
                <td align="left" valign="top"  class="FondoCampo"><strong><?php echo Curso($CodigoCurso); echo '  '.$AnoCurso; ?></strong></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top"  class="NombreCampo">Nombres</td>
                <td align="left" valign="top"  class="FondoCampo"><strong><?php echo $row_RS_Alumno['Nombres']; ?> - <?php echo $row_RS_Alumno['Nombres2']; ?></strong></td>
                <td align="right" valign="top"  class="NombreCampo">Fecha de Nacimiento</td>
                <td align="left" valign="top"  class="FondoCampo"><?php echo substr($row_RS_Alumno['FechaNac'], 8, 2).'-'.substr($row_RS_Alumno['FechaNac'], 5, 2).'-'.substr($row_RS_Alumno['FechaNac'],0,4) ; 
				echo "  (".Edad_Dif($row_RS_Alumno['FechaNac'],date(Y)."-09-16").")"; ?></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top"  class="NombreCampo">Apellidos</td>
                <td align="left" valign="top"  class="FondoCampo"><strong><?php echo $row_RS_Alumno['Apellidos']; ?> - <?php echo $row_RS_Alumno['Apellidos2']; ?></strong></td>
                <td align="right" valign="top"  class="NombreCampo">Clinica Donde Naci&oacute;</td>
                <td align="left" valign="top"  class="FondoCampo"><?php echo $row_RS_Alumno['ClinicaDeNac']; ?></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top"  class="NombreCampo">Nacionalidad</td>
                <td align="left" valign="top"  class="FondoCampo"><?php echo $row_RS_Alumno['Nacionalidad']; ?></td>
                <td align="right" valign="top"  class="NombreCampo">Localidad,<br>
Ciudad o Municipio</td>
                <td align="left" valign="top"  class="FondoCampo"><?php echo $row_RS_Alumno['Localidad']; ?></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top"  class="NombreCampo">Entidad o Estado</td>
                <td align="left" valign="top"  class="FondoCampo"><?php echo $row_RS_Alumno['Entidad']; ?></td>
                <td align="right" valign="top"  class="NombreCampo">Sexo</td>
                <td align="left" valign="top"  class="FondoCampo"><?php echo $row_RS_Alumno['Sexo']; ?></td>
              </tr>
              <tr valign="baseline">
                <td colspan="4" align="left" valign="top"  class="NombreCampoTITULO">Informaci&oacute;n de contacto </td>
              </tr>
              <tr valign="baseline">
                <td rowspan="3" align="right" valign="top"  class="NombreCampo">Direcci&oacute;n:</td>
                <td rowspan="3" align="left" valign="top" class="FondoCampo"><label>
                  <textarea name="Direccion" id="Direccion" cols="40" rows="4"><?php echo $row_RS_Alumno['Direccion']; ?></textarea>
                  </label></td>
                <td align="right" valign="top"  class="NombreCampo">Urbanizacion</td>
                <td align="left" valign="top"  class="FondoCampo">
                  <label>
                  <input name="Urbanizacion" type="text" id="Urbanizacion" value="<?php echo $row_RS_Alumno['Urbanizacion']; ?>" size="20">
                  </label></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top"  class="NombreCampo">Ciudad</td>
                <td align="left" valign="top"  class="FondoCampo">
                  <label>
                  <input name="Ciudad" type="text" id="Ciudad" value="<?php echo $row_RS_Alumno['Ciudad']; ?>" size="20">
                  </label></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top"  class="NombreCampo">Codigo Postal</td>
                <td align="left" valign="top"  class="FondoCampo">
                  <label>
                  <input name="CodPostal" type="text" id="CodPostal" value="<?php echo $row_RS_Alumno['CodPostal']; ?>" size="20">
                  </label></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" class="NombreCampo">Email alumno</td>
                <td align="left" class="FondoCampo">
                  <label>
                  <input name="Email1" type="text" id="Email1" value="<?php echo $row_RS_Alumno['Email1']; ?>" size="20">
                  </label>
                </td>
                <td align="right" valign="top" class="NombreCampo">Email secundario</td>
                <td align="left" class="FondoCampo">
                  <label>
                  <input name="Email2" type="text" id="Email2" value="<?php echo $row_RS_Alumno['Email2']; ?>" size="20">
                  </label></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top"  class="NombreCampo">Tel&eacute;fono Hab</td>
                <td align="left" class="FondoCampo">
                    <label>
                    <input name="TelHab" type="text" id="TelHab" value="<?php echo $row_RS_Alumno['TelHab']; ?>" size="20">
                    </label>
                </td>
                <td align="right" valign="top"  class="NombreCampo">Tel&eacute;fono Cel</td>
                <td align="left" class="FondoCampo">
                  <label>
                  <input name="TelCel" type="text" id="TelCel" value="<?php echo $row_RS_Alumno['TelCel']; ?>" size="20">
                  </label></td>
              </tr>
              <tr valign="baseline" >
                <td colspan="4" align="left" valign="top"  class="NombreCampoTITULO">En caso de emergencia llamar a: </td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top"  class="NombreCampo">Nombre</td>
                <td align="left"  class="FondoCampo">
                  <label>
                  <input name="PerEmergencia" type="text" id="PerEmergencia" value="<?php echo $row_RS_Alumno['PerEmergencia']; ?>" size="20">
                  </label></td>
                <td align="right" valign="top"  class="NombreCampo">&nbsp;</td>
                <td align="left" valign="top"  class="FondoCampo">&nbsp;</td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top"  class="NombreCampo">Tel&eacute;fonos</td>
                <td align="left"  class="FondoCampo">
                  <input name="PerEmerTel" type="text" id="PerEmerTel" value="<?php echo $row_RS_Alumno['PerEmerTel']; ?>" size="20">
                  </label>
                </td>
                <td align="right" valign="top"  class="NombreCampo"> Nexo</td>
                <td align="left" valign="top"  class="FondoCampo">
                  <label>
                  <input name="PerEmerNexo" type="text" id="PerEmerNexo" value="<?php echo $row_RS_Alumno['PerEmerNexo']; ?>" size="20">
                  </label></td>
              </tr>
              <tr valign="baseline">
                <td colspan="4" align="left" valign="top"  class="NombreCampoTITULO">Informaci&oacute;n M&eacute;dica </td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top"  class="NombreCampo">Peso</td>
                <td align="left" class="FondoCampo"><?php echo $row_RS_Alumno['Peso']; ?>
                </td>
                <td align="right" valign="top"  class="NombreCampo">Vacunas</td>
                <td class="FondoCampo"><?php echo $row_RS_Alumno['Vacunas']; ?></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top"  class="NombreCampo">Enfermedades</td>
                <td align="left" class="FondoCampo"><?php echo $row_RS_Alumno['Enfermedades']; ?>
                </td>
                <td align="right" valign="top" class="NombreCampo">Tratamiento M&eacute;dico</td>
                <td class="FondoCampo"><?php echo $row_RS_Alumno['TratamientoMed']; ?></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top"  class="NombreCampo">Alergico a</td>
                <td align="left" class="FondoCampo"><?php echo $row_RS_Alumno['AlergicoA']; ?>
                </td>
                <td align="right" valign="top"  class="NombreCampo">&nbsp;</td>
                <td class="FondoCampo">&nbsp;</td>
              </tr>
              <tr valign="baseline">
                <td colspan="4" align="left" valign="top"  class="NombreCampoTITULO">Otra informaci&oacute;n</td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap="nowrap" class="NombreCampo">Colegio de Procedencia</td>
                <td align="left" class="FondoCampo"><?php echo $row_RS_Alumno['ColegioProcedencia']; ?>
                (<?php echo $row_RS_Alumno['ColegioProcedenciaTelefono']; ?>)
                </td>
                <td align="right" valign="top"  class="NombreCampo">Ciudad</td>
                <td class="FondoCampo"><?php echo $row_RS_Alumno['CiudadColProc']; ?></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap="nowrap" class="NombreCampo">Motivo Retiro Col Proced</td>
                <td align="left" class="FondoCampo"><?php echo $row_RS_Alumno['MotivoRetiroColProced']; ?></td>
                <td align="right" valign="top"  class="NombreCampo">&nbsp;</td>
                <td class="FondoCampo">&nbsp;</td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap="nowrap" class="NombreCampo">Observaciones</td>
                <td align="left" class="FondoCampo"><?php echo $row_RS_Alumno['Observaciones']; ?></td>
                <td align="right" valign="top"  class="NombreCampo">&nbsp;</td>
                <td class="FondoCampo">&nbsp;</td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap="nowrap" class="NombreCampo">Ha Solicitado antes</td>
                <td align="left" class="FondoCampo"><?php echo $row_RS_Alumno['HaSolicitado']; ?> <?php echo $row_RS_Alumno['HaSolicitadoObs']; ?></td>
                <td align="right" valign="top"  class="NombreCampo">&nbsp;</td>
                <td class="FondoCampo">&nbsp;</td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap="nowrap" class="NombreCampo">Tiene Psicologo</td>
                <td align="left" class="FondoCampo"><?php echo $row_RS_Alumno['TienePsicologo']; ?> <?php echo $row_RS_Alumno['TienePsicologoObs']; ?></td>
                <td align="right" valign="top"  class="NombreCampo">&nbsp;</td>
                <td class="FondoCampo">&nbsp;</td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap="nowrap" class="NombreCampo">Representante Administrativo</td>
                <td align="left" class="FondoCampo"><?php echo $row_RS_Alumno['RepresentanteAdministrativo']; ?> <?php echo $row_RS_Alumno['RepresentanteAdministrativoObs']; ?></td>
                <td align="right" valign="top"  class="NombreCampo">&nbsp;</td>
                <td class="FondoCampo">&nbsp;</td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap="nowrap" class="NombreCampo">Hermano Solicitando</td>
                <td align="left" class="FondoCampo"><?php echo $row_RS_Alumno['HermanoSolicitando']; ?></td>
                <td align="right" valign="top"  class="NombreCampo">&nbsp;</td>
                <td class="FondoCampo">&nbsp;</td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap="nowrap" class="NombreCampo">Hermano Cursando</td>
                <td align="left" class="FondoCampo"><?php echo $row_RS_Alumno['HermanoCursando']; ?> <?php echo $row_RS_Alumno['HermanoCursandoObs']; ?></td>
                <td align="right" valign="top"  class="NombreCampo">&nbsp;</td>
                <td class="FondoCampo">&nbsp;</td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap="nowrap" class="NombreCampo">Hijo De Exalumno</td>
                <td align="left" class="FondoCampo"><?php echo $row_RS_Alumno['HijoDeExalumno']; ?> <?php echo $row_RS_Alumno['HijoDeExalumnoObs']; ?></td>
                <td align="right" valign="top"  class="NombreCampo">&nbsp;</td>
                <td class="FondoCampo">&nbsp;</td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap="nowrap" class="NombreCampo">Referencias Personales</td>
                <td align="left" class="FondoCampo"><?php echo $row_RS_Alumno['ReferenciasPersonales']; ?></td>
                <td align="right" valign="top"  class="NombreCampo">&nbsp;</td>
                <td class="FondoCampo">&nbsp;</td>
              </tr>
              <tr valign="baseline">
                <td colspan="4" align="center"><label>
                  <input type="submit" name="Guardar" id="Guardar" value="Guardar">
                </label></td>
                </tr>
            </table>  
              <input type="hidden" name="MM_update" value="alumno">
          </form>          </td>
        </tr>
        
        
        
        
        
        
        <tr>
          <td>




<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
        <?php 
$arr = array('Padre','Madre');
foreach ($arr as $value) {
    //$value = $value * 2;
		

//$query_RS_Repre = sprintf("SELECT * FROM Representante WHERE Creador = '%s' AND Nexo = '$value'", $Creador);
$query_RS_Repre = "SELECT * FROM RepresentanteXAlumno, Representante 
					WHERE RepresentanteXAlumno.CodigoRepresentante = Representante.CodigoRepresentante
					AND RepresentanteXAlumno.Nexo = '$value'
					AND RepresentanteXAlumno.CodigoAlumno = '".$CodigoAlumno."'";

$RS_Repre = $mysqli->query($query_RS_Repre);
$row_RS_Repre = $RS_Repre->fetch_assoc();
		 ?>

    <td width="50%"><form action="<?php echo $editFormAction; ?>" method="POST" name="Repre"><table width="95%"  border="0" align="center" cellpadding="5" >
            <tr>
              <td colspan="3" align="left" class="subtitle"><img src="../../i/<?php echo $value=='Madre'?'user_female':'user_suit'; ?>.png" width="32" height="32">Datos Del <?php echo $value; ?></td>
              </tr>
            <tr>
              <td align="right" class="NombreCampo"><input name="CodigoRepresentante" type="hidden" id="CodigoRepresentante" value="<?php echo $row_RS_Repre['CodigoRepresentante']; ?>">
Nexo</td>
              <td class="FondoCampo"><?php echo $row_RS_Repre['Nexo']; ?></td>
              <td rowspan="8" align="right" class="FondoCampo"><img src="../Foto_Repre/<?php 
		  echo $row_RS_Alumno ['CodigoAlumno'];
		  echo strtolower( substr($value,0,1)); ?>.jpg" alt=""    height="150" /></td>
            </tr>
            <tr>
              <td align="right" class="NombreCampo">Repr</td>
              <td class="FondoCampo"><strong>
                <input name="SWrepre" type="text" id="SWrepre" value="<?php echo $row_RS_Repre['SW_Representante']; ?>" size="5">
              </strong></td>
              </tr>
            <tr>
              <td align="right" class="NombreCampo">Apellidos</td>
              <td  class="FondoCampo"><strong><?php echo $row_RS_Repre['Apellidos']; ?></strong></td>
              </tr>
            <tr>
              <td align="right" class="NombreCampo">Nombres</td>
              <td class="FondoCampo"><strong><?php echo $row_RS_Repre['Nombres']; ?></strong></td>
              </tr>
            <tr>
              <td align="right"  class="NombreCampo">C&eacute;dula</td>
              <td class="FondoCampo"><?php echo $row_RS_Repre['Cedula']; $cedula_aseg = $row_RS_Repre['Cedula'];?></td>
              </tr>
            <tr>
              <td align="right"  class="NombreCampo">Nacionalidad</td>
              <td class="FondoCampo"><?php echo $row_RS_Repre['Nacionalidad']; ?></td>
              </tr>
            <tr>
              <td align="right"  class="NombreCampo">Lugar de Nacimiento</td>
              <td class="FondoCampo"><?php echo $row_RS_Repre['LugarNac']; ?></td>
              </tr>
            <tr>
          <td align="right"  class="NombreCampo">Fecha de Nac</td>
          <td class="FondoCampo"><?php echo DDMMAAAA($row_RS_Repre['FechaNac']).' ('. Edad($row_RS_Repre['FechaNac']).')'; 
		  
		  $Dia_Asegurado = substr($row_RS_Repre['FechaNac'] , 8 , 2);
		  $Mes_Asegurado = substr($row_RS_Repre['FechaNac'] , 5 , 2);
		  $Ano_Asegurado = substr($row_RS_Repre['FechaNac'] , 0 , 4);
		  ?></td>
          </tr>
         <tr>
              <td colspan="3" class="NombreCampoTITULO">Informaci&oacute;n de Contacto</td>
              </tr>
            <tr>
              <td align="right"  class="NombreCampo">Tel&eacute;fono Habitaci&oacute;n</td>
              <td colspan="2" class="FondoCampo"><strong>
                <label>
                  <input name="TelHab" type="text" id="TelHab" value="<?php echo $row_RS_Repre['TelHab']; ?>" size="20">
                  </label>
              </strong></td>
              </tr>
            <tr>
              <td align="right"  class="NombreCampo">Tel&eacute;fono Celular</td>
              <td colspan="2" class="FondoCampo"><strong>
                <input name="TelCel" type="text" id="TelCel" value="<?php echo $row_RS_Repre['TelCel']; ?>" size="20">
              </strong></td>
              </tr>
            <tr>
              <td align="right"  class="NombreCampo">Tel&eacute;fono Trabajo</td>
              <td colspan="2" class="FondoCampo"><strong>
                <input name="TelTra" type="text" id="TelTra" value="<?php echo $row_RS_Repre['TelTra']; ?>" size="20">
              </strong></td>
              </tr>
            <tr>
              <td align="right" valign="top" class="NombreCampo">Direcci&oacute;n</td>
              <td colspan="2" valign="top" class="FondoCampo">
                <label>
                  <textarea name="Direccion" id="textarea" cols="50" rows="4"><?php echo $row_RS_Repre['Direccion']; ?></textarea>
                </label></td>
              </tr>
            <tr>
              <td align="right" class="NombreCampo">Urbanizaci&oacute;n</td>
              <td colspan="2" valign="top" class="FondoCampo"><strong>
                <input name="Urbanizacion" type="text" id="Urbanizacion" value="<?php echo $row_RS_Repre['Urbanizacion']; ?>" size="20">
              </strong></td>
            </tr>
            <tr>
              <td align="right" class="NombreCampo">Ciudad</td>
              <td colspan="2" valign="top" class="FondoCampo"><strong>
                <input name="Ciudad" type="text" id="Ciudad" value="<?php echo $row_RS_Repre['Ciudad']; ?>" size="20">
              </strong></td>
            </tr>
            <tr>
              <td align="right" class="NombreCampo">Cod Postal</td>
              <td colspan="2" valign="top" class="FondoCampo"><strong>
                <input name="CodPostal" type="text" id="CodPostal" value="<?php echo $row_RS_Repre['CodPostal']; ?>" size="20">
              </strong></td>
            </tr>
            <tr>
              <td align="right" class="NombreCampo">Email principal </td>
              <td colspan="2" valign="top" class="FondoCampo"><strong>
                <input name="Email1" type="text" id="Email1" value="<?php echo $row_RS_Repre['Email1']; ?>" size="20">
                <?php if($row_RS_Alumno['Creador'] == $row_RS_Repre['Email1']) echo "*"; ?>
                </strong></td>
            </tr>
            <tr>
              <td align="right" class="NombreCampo">Email secundario</td>
              <td colspan="2" valign="top" class="FondoCampo"><strong>
                <input name="Email2" type="text" id="Email2" value="<?php echo $row_RS_Repre['Email2']; ?>" size="20">
               <?php if($row_RS_Alumno['Creador'] == $row_RS_Repre['Email2']) echo "*"; ?>
               </strong></td>
            </tr>
            <tr>
              <td colspan="3" class="NombreCampoTITULO">Informaci&oacute;n del Trabajo </td>
            </tr>
            <tr>
              <td align="right" class="NombreCampo">Ocupaci&oacute;n</td>
              <td colspan="2" class="FondoCampo"><?php echo $row_RS_Repre['Ocupacion']; ?></td>
              </tr>
            <tr>
              <td align="right" class="NombreCampo">Profesi&oacute;n</td>
              <td colspan="2" class="FondoCampo"><?php echo $row_RS_Repre['Profesion']; ?></td>
            </tr>
            <tr>
              <td align="right" class="NombreCampo">Empresa</td>
              <td colspan="2" class="FondoCampo"><?php echo $row_RS_Repre['Empresa']; ?> - <?php echo $row_RS_Repre['CargoEmpresa']; ?></td>
              </tr>
            <tr>
              <td align="right" class="NombreCampo">Actividad Empresa</td>
              <td colspan="2" class="FondoCampo"><?php echo $row_RS_Repre['ActividadEmpresa'] ?></td>
              </tr>
            <tr>
              <td align="right" class="NombreCampo">Grado Instruccion</td>
              <td colspan="2" class="FondoCampo"><?php echo $row_RS_Repre['GradoInstruccion'].' '.$row_RS_Repre['Remuneracion']; ?></td>
            </tr>
            <tr>
              <td align="right" class="NombreCampo">FechaIngresoEmpresa</td>
              <td colspan="2" class="FondoCampo"><?php echo $row_RS_Repre['TiempoEmpresa']; ?></td>
              </tr>
            <tr>
              <td align="right" class="NombreCampo">Direcci&oacute;n del Trabajo </td>
              <td colspan="2" valign="top" class="FondoCampo"><?php echo $row_RS_Repre['DireccionTra']; ?></td>
              </tr>
            <tr>
              <td align="right" class="NombreCampo">&nbsp;Fecha_Actualizacion</td>
              <td colspan="2" valign="top" class="FondoCampo"><?php echo $row_RS_Repre['Fecha_Actualizacion']; ?></td>
            </tr>
            <tr>
              <td colspan="3" align="center"><input type="hidden" name="MM_update" value="<?php echo $value; ?>">
                <input name="CodigoAlumno" type="hidden" id="CodigoAlumno" value="<?php echo $CodigoAlumno; ?>">
                <input type="submit" name="button" id="button" value="Guardar"></td>
              </tr>
            <tr>
              <td colspan="3" align="center"><a href="http://www.ivss.gob.ve:28083/CuentaIndividualIntranet/CtaIndividual_PortalCTRL?cedula_aseg=<?= $cedula_aseg ?>&d=<?= $Dia_Asegurado; ?>&m=<?= $Mes_Asegurado ?>&nacionalidad_aseg=V&y=<?= $Ano_Asegurado ?>" target="_blank">ivss</a></td>
            </tr>
            <tr>
              <td colspan="3" align="center"><iframe src="http://www.ivss.gob.ve:28083/CuentaIndividualIntranet/CtaIndividual_PortalCTRL?cedula_aseg=<?= $cedula_aseg ?>&d=<?= $Dia_Asegurado; ?>&m=<?= $Mes_Asegurado ?>&nacionalidad_aseg=V&y=<?= $Ano_Asegurado ?>" width="500" height="50"><a href="menu_intranet_a.php"></a></iframe></td>
            </tr>
          </table>
</form></td>
  
 <?php } ?>
 </tr>
 </table>



          </td>
        </tr>
        
        
        <tr>
          <td class="subtitle">Datos Abuelos</td>
        </tr>
        <tr>
          <td><table width="100%"  border="0" cellpadding="5">
            <tr class="NombreCampo">
              <td class="NombreCampo">&nbsp;</td>
              <td class="NombreCampo">Apellidos y Nombres</td>
              <td class="NombreCampo">Lugar de Nac.</td>
              <td class="NombreCampo">Pais</td>
              <td class="NombreCampo">Vive</td>
            </tr>
            <tr>
              <td class="NombreCampo">Abuelo Paterno</td>
              <td class="FondoCampo"><?php echo $row_RS_AbueloPaterno['Apellidos']; ?>, <?php echo $row_RS_AbueloPaterno['Nombres']; ?></td>
              <td class="FondoCampo"><?php echo $row_RS_AbueloPaterno['LugarDeNacimiento']; ?></td>
              <td class="FondoCampo"><?php echo $row_RS_AbueloPaterno['PaisDeNacimiento']; ?></td>
              <td class="FondoCampo"><?php echo $row_RS_AbueloPaterno['Vive']; ?></td>
            </tr>
            <tr>
              <td class="NombreCampo">Abuela Paterna </td>
              <td class="FondoCampo"><?php echo $row_RS_AbuelaPaterna['Apellidos']; ?>, <?php echo $row_RS_AbuelaPaterna['Nombres']; ?></td>
              <td class="FondoCampo"><?php echo $row_RS_AbuelaPaterna['LugarDeNacimiento']; ?></td>
              <td class="FondoCampo"><?php echo $row_RS_AbuelaPaterna['PaisDeNacimiento']; ?></td>
              <td class="FondoCampo"><?php echo $row_RS_AbuelaPaterna['Vive']; ?></td>
            </tr>
            <tr>
              <td class="NombreCampo">Abuelo Materno </td>
              <td class="FondoCampo"><?php echo $row_RS_AbueloMaterno['Apellidos']; ?>, <?php echo $row_RS_AbueloMaterno['Nombres']; ?></td>
              <td class="FondoCampo"><?php echo $row_RS_AbueloMaterno['LugarDeNacimiento']; ?></td>
              <td class="FondoCampo"><?php echo $row_RS_AbueloMaterno['PaisDeNacimiento']; ?></td>
              <td class="FondoCampo"><?php echo $row_RS_AbueloMaterno['Vive']; ?></td>
            </tr>
            <tr>
              <td class="NombreCampo">Abuela Materna </td>
              <td class="FondoCampo"><?php echo $row_RS_AbuelaMaterna['Apellidos']; ?>, <?php echo $row_RS_AbuelaMaterna['Nombres']; ?></td>
              <td class="FondoCampo"><?php echo $row_RS_AbuelaMaterna['LugarDeNacimiento']; ?></td>
              <td class="FondoCampo"><?php echo $row_RS_AbuelaMaterna['PaisDeNacimiento']; ?></td>
              <td class="FondoCampo"><?php echo $row_RS_AbuelaMaterna['Vive']; ?></td>
            </tr>
          </table></td>
        </tr>
    </table>    </td>
  </tr><?php if ($totalRows_RS_Autorizado != 0 ) { ?>
  <tr>
    <td class="subtitle">Personas Autorizadas</td>
  </tr>
  <tr>
    <td><table width="100%"  border="0" cellpadding="5">
      <tr>
        <td class="NombreCampo">Nexo </td>
        <td class="NombreCampo">Apellidos y Nombres </td>
        <td class="NombreCampo">C&eacute;dula</td>
        <td class="NombreCampo">Tel&eacute;fonos</td>
      </tr>
      <?php $n=0; do { ?><tr>
          <td align="left" class="NombreCampo"><?php echo $row_RS_Autorizado['Ocupacion']; ?></td>
          <td class="FondoCampo"><?php echo $row_RS_Autorizado['Apellidos']; ?>, <?php echo $row_RS_Autorizado['Nombres']; ?> </td>
          <td class="FondoCampo"><?php echo $row_RS_Autorizado['Cedula']; ?></td>
          <td class="FondoCampo">H:<?php echo $row_RS_Autorizado['TelHab']; ?> Cel:<?php echo $row_RS_Autorizado['TelCel']; ?> <?php echo $row_RS_Autorizado['TelTra']; ?></td>
      </tr>
          
          <?php } while ($row_RS_Autorizado = $RS_Autorizado->fetch_assoc()); ?>
    </table></td>
  </tr><?php }?>
  <tr><td class="subtitle">
    Observaciones
    </td>
  </tr><tr><td>
    <iframe src="Alumno/Observaciones.php?Area=Planilla&CodigoAlumno=<?php echo $CodigoAlumno ?>" width="100%"></iframe>
    </td>
  </tr>
</table>
<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>