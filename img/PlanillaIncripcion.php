<?php require_once('../Connections/bd.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "99,2";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../index.php?error=login";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
$colname_RS_Alumnos = "0";
if (isset($_SESSION['MM_Username'])) {
  $colname_RS_Alumnos = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_bd, $bd);
$query_RS_Alumnos = sprintf("SELECT * FROM Alumno WHERE Creador = '%s' ORDER BY Nombres ASC", $colname_RS_Alumnos);
$RS_Alumnos = mysql_query($query_RS_Alumnos, $bd) or die(mysql_error());
$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
$totalRows_RS_Alumnos = mysql_num_rows($RS_Alumnos);

$colname_RS_Representante = "0";
if (isset($_SESSION['MM_Username'])) {
  $colname_RS_Representante = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_bd, $bd);
$query_RS_Representante = sprintf("SELECT * FROM Representante WHERE Creador = '%s' ORDER BY Nexo ASC", $colname_RS_Representante);
$RS_Representante = mysql_query($query_RS_Representante, $bd) or die(mysql_error());
$row_RS_Representante = mysql_fetch_assoc($RS_Representante);
$totalRows_RS_Representante = mysql_num_rows($RS_Representante);

$colname_RS_Padre = "0";
if (isset($_SESSION['MM_Username'])) {
  $colname_RS_Padre = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_bd, $bd);
$query_RS_Padre = sprintf("SELECT * FROM Representante WHERE Creador = '%s' AND Nexo = 'Padre'", $colname_RS_Padre);
$RS_Padre = mysql_query($query_RS_Padre, $bd) or die(mysql_error());
$row_RS_Padre = mysql_fetch_assoc($RS_Padre);
$totalRows_RS_Padre = mysql_num_rows($RS_Padre);

$colname_RS_Madre = "0";
if (isset($_SESSION['MM_Username'])) {
  $colname_RS_Madre = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_bd, $bd);
$query_RS_Madre = sprintf("SELECT * FROM Representante WHERE Creador = '%s' AND Nexo = 'Madre'", $colname_RS_Madre);
$RS_Madre = mysql_query($query_RS_Madre, $bd) or die(mysql_error());
$row_RS_Madre = mysql_fetch_assoc($RS_Madre);
$totalRows_RS_Madre = mysql_num_rows($RS_Madre);

$colname_RS_Autorizado = "0";
if (isset($_SESSION['MM_Username'])) {
  $colname_RS_Autorizado = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_bd, $bd);
$query_RS_Autorizado = sprintf("SELECT * FROM Representante WHERE Creador = '%s' AND Nexo = 'Autorizado'", $colname_RS_Autorizado);
$RS_Autorizado = mysql_query($query_RS_Autorizado, $bd) or die(mysql_error());
$row_RS_Autorizado = mysql_fetch_assoc($RS_Autorizado);
$totalRows_RS_Autorizado = mysql_num_rows($RS_Autorizado);

$colname_RS_AbuelaPaterna = "1";
if (isset($_SESSION['MM_Username'])) {
  $colname_RS_AbuelaPaterna = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_bd, $bd);
$query_RS_AbuelaPaterna = sprintf("SELECT * FROM Abuelos WHERE Creador = '%s' AND Nexo = 'Abuela Paterna'", $colname_RS_AbuelaPaterna);
$RS_AbuelaPaterna = mysql_query($query_RS_AbuelaPaterna, $bd) or die(mysql_error());
$row_RS_AbuelaPaterna = mysql_fetch_assoc($RS_AbuelaPaterna);
$totalRows_RS_AbuelaPaterna = mysql_num_rows($RS_AbuelaPaterna);

$colname_RS_AbueloPaterno = "1";
if (isset($_SESSION['MM_Username'])) {
  $colname_RS_AbueloPaterno = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_bd, $bd);
$query_RS_AbueloPaterno = sprintf("SELECT * FROM Abuelos WHERE Creador = '%s' AND Nexo = 'Abuelo Paterno'", $colname_RS_AbueloPaterno);
$RS_AbueloPaterno = mysql_query($query_RS_AbueloPaterno, $bd) or die(mysql_error());
$row_RS_AbueloPaterno = mysql_fetch_assoc($RS_AbueloPaterno);
$totalRows_RS_AbueloPaterno = mysql_num_rows($RS_AbueloPaterno);

$colname_RS_AbueloMaterno = "1";
if (isset($_SESSION['MM_Username'])) {
  $colname_RS_AbueloMaterno = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_bd, $bd);
$query_RS_AbueloMaterno = sprintf("SELECT * FROM Abuelos WHERE Creador = '%s' AND Nexo = 'Abuelo Materno'", $colname_RS_AbueloMaterno);
$RS_AbueloMaterno = mysql_query($query_RS_AbueloMaterno, $bd) or die(mysql_error());
$row_RS_AbueloMaterno = mysql_fetch_assoc($RS_AbueloMaterno);
$totalRows_RS_AbueloMaterno = mysql_num_rows($RS_AbueloMaterno);

$colname_RS_AbuelaMaterna = "1";
if (isset($_SESSION['MM_Username'])) {
  $colname_RS_AbuelaMaterna = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_bd, $bd);
$query_RS_AbuelaMaterna = sprintf("SELECT * FROM Abuelos WHERE Creador = '%s' AND Nexo = 'Abuela Materna'", $colname_RS_AbuelaMaterna);
$RS_AbuelaMaterna = mysql_query($query_RS_AbuelaMaterna, $bd) or die(mysql_error());
$row_RS_AbuelaMaterna = mysql_fetch_assoc($RS_AbuelaMaterna);
$totalRows_RS_AbuelaMaterna = mysql_num_rows($RS_AbuelaMaterna);

$Usuario_RS_Alumno = "0";
if (isset($_SESSION['MM_Username'])) {
  $Usuario_RS_Alumno = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
$colname_RS_Alumno = "1";
if (isset($_GET['CodigoAlumno'])) {
  $colname_RS_Alumno = (get_magic_quotes_gpc()) ? $_GET['CodigoAlumno'] : addslashes($_GET['CodigoAlumno']);
}
mysql_select_db($database_bd, $bd);
$query_RS_Alumno = sprintf("SELECT * FROM Alumno WHERE CodigoAlumno = '%s' AND Creador = '%s' ", $colname_RS_Alumno,$Usuario_RS_Alumno);
$RS_Alumno = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumno = mysql_fetch_assoc($RS_Alumno);
$totalRows_RS_Alumno = mysql_num_rows($RS_Alumno);

$colname_RS_Curso = "0";
if (isset($row_RS_Alumno['CodigoCurso'])) {
  $colname_RS_Curso = (get_magic_quotes_gpc()) ? $row_RS_Alumno['CodigoCurso'] : addslashes($row_RS_Alumno['CodigoCurso']);
}
mysql_select_db($database_bd, $bd);
$query_RS_Curso = sprintf("SELECT * FROM Curso WHERE CodigoCurso = %s", $colname_RS_Curso);
$RS_Curso = mysql_query($query_RS_Curso, $bd) or die(mysql_error());
$row_RS_Curso = mysql_fetch_assoc($RS_Curso);
$totalRows_RS_Curso = mysql_num_rows($RS_Curso);

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Planilla de Inscripci&oacute;n: <?php echo $row_RS_Alumno['CodigoAlumno']; ?></title>
<link href="../estilos2.css" rel="stylesheet" type="text/css">
<link href="../estilos.css" rel="stylesheet" type="text/css">
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
<table width="620"  border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td width="620">
      <table width="100%"  border="0">
        <tr>
          <td valign="bottom" nowrap   class="RTitulo"><div align="left"><span class="title">Colegio San Francisco de As&iacute;s</span> <br>
              <span class="TextosSimples12">Los Palos Grandes</span>          <span class="legal"> - | - Dep Tran - | - Mer Pro VCre Vzla - | - Fecha ___________</span></div></td>
          <td valign="top" nowrap   class="RTitulo">&nbsp;</td>
          <td valign="bottom" nowrap  class="RTitulo">
          <div align="right">Planilla de Inscripci&oacute;n </div>          
          <span class="legal">Num ___________________________ Mto______________</span><br></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td valign="top"><table width="100%"  border="1" bordercolor="#000000">
        <tr align="center" valign="middle">
          <td width="1"><IMG border=0 width=5 height=120 id="_x0000_i1045" src="../img/b.gif"><br>
          </td>
          <td width="15%"><span class="TextosSimples">Foto<br>
Autorizado 3 </span></td>
          <td width="15%"><span class="TextosSimples">Foto<br>
Autorizado 2 </span></td>
          <td width="15%" class="TextosSimples">Foto<br>
            Autorizado 1 </td>
          <td width="15%" align="center" class="TextosSimples">Foto mam&aacute; </td>
          <td width="15%" class="TextosSimples">Foto pap&aacute; </td>
          <td width="15%" class="TextosSimples">Foto 
            Alumno 
          </td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top"><table width="620"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="RTitulo"><div align="left">C&oacute;digo:<?php echo $row_RS_Alumno['CodigoAlumno']; ?></div></td>
          <td nowrap class="RTitulo"><div align="right">Datos del Alumno</div></td>
        </tr>
        <tr>
          <td colspan="2">            <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
              <tr valign="baseline">
                <td align="right"  class="FondoCampoPRINT"><?php echo $_SESSION['MM_Username']; ?></td>
                <td align="right"  class="FondoCampoPRINT">
                  Cs:<?php echo $row_RS_Alumno['CodigoFMP']; ?></td>
                <td align="right"  class="FondoCampoPRINT">&nbsp;</td>
                <td align="right"  class="FondoCampoPRINT"><div align="right"></div></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top"  class="NombreCampoPRINT">C&eacute;dula</td>
                <td align="right" valign="top"  class="FondoCampoPRINT"><?php echo $row_RS_Alumno['CedulaLetra']; ?>- <?php echo $row_RS_Alumno['Cedula']; ?> </td>
                <td align="right" valign="top"  class="NombreCampoPRINT">Curso</td>
                <td align="right" valign="top"  class="FondoCampoPRINT"><strong><?php echo $row_RS_Curso['NombreCompleto']?></strong></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top"  class="NombreCampoPRINT">Nombres</td>
                <td align="right" valign="top"  class="FondoCampoPRINT"><strong><?php echo $row_RS_Alumno['Nombres']; ?> - <?php echo $row_RS_Alumno['Nombres2']; ?>,</strong></td>
                <td align="right" valign="top"  class="NombreCampoPRINT">Fecha de Nac.</td>
                <td align="right" valign="top"  class="FondoCampoPRINT"><?php echo substr($row_RS_Alumno['FechaNac'], 8, 2).'-'.substr($row_RS_Alumno['FechaNac'], 5, 2).'-'.substr($row_RS_Alumno['FechaNac'],0,4) ; ?></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top"  class="NombreCampoPRINT">Apellidos</td>
                <td align="right" valign="top"  class="FondoCampoPRINT"><strong><?php echo $row_RS_Alumno['Apellidos']; ?> -  <?php echo $row_RS_Alumno['Apellidos2']; ?></strong></td>
                <td align="right" valign="top"  class="NombreCampoPRINT">Clinica Donde Naci&oacute;</td>
                <td align="right" valign="top"  class="FondoCampoPRINT"><?php echo $row_RS_Alumno['ClinicaDeNac']; ?></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top"  class="NombreCampoPRINT">Nacionalidad</td>
                <td align="right" valign="top"  class="FondoCampoPRINT"><?php echo $row_RS_Alumno['Nacionalidad']; ?></td>
                <td align="right" valign="top"  class="NombreCampoPRINT">Localidad,<br>
Ciudad o Municipio</td>
                <td align="right" valign="top"  class="FondoCampoPRINT"><?php echo $row_RS_Alumno['Localidad']; ?></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top"  class="NombreCampoPRINT">Entidad o Estado</td>
                <td align="right" valign="top"  class="FondoCampoPRINT"><?php echo $row_RS_Alumno['Entidad']; ?></td>
                <td align="right" valign="top"  class="NombreCampoPRINT">Sexo</td>
                <td align="right" valign="top"  class="FondoCampoPRINT"><?php echo $row_RS_Alumno['Sexo']; ?></td>
              </tr>
              <tr valign="baseline">
                <td colspan="4" align="right" valign="top"  class="subtitle"><div align="left" class="promo">Informaci&oacute;n de contacto </div></td>
              </tr>
              <tr valign="baseline">
                <td rowspan="3" align="right" valign="top"  class="NombreCampoPRINT"><div align="right">Direcci&oacute;n:</div></td>
                <td rowspan="3" align="right" valign="top" class="FondoCampoPRINT"><div align="left"><?php echo $row_RS_Alumno['Direccion']; ?>
                </div></td>
                <td align="right" valign="top"  class="NombreCampoPRINT">Urbanizacion</td>
                <td align="right" valign="top"  class="FondoCampoPRINT"><?php echo $row_RS_Alumno['Urbanizacion']; ?></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top"  class="NombreCampoPRINT">Ciudad</td>
                <td align="right" valign="top"  class="FondoCampoPRINT"><?php echo $row_RS_Alumno['Ciudad']; ?></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top"  class="NombreCampoPRINT">Codigo Postal</td>
                <td align="right" valign="top"  class="FondoCampoPRINT"><?php echo $row_RS_Alumno['CodPostal']; ?></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" class="NombreCampoPRINT"><div align="right">Email alumno</div></td>
                <td align="right" class="FondoCampoPRINT"><div align="left"><?php echo $row_RS_Alumno['Email1']; ?>
                </div></td>
                <td align="right" valign="top" class="NombreCampoPRINT">Email secundario</td>
                <td class="FondoCampoPRINT"><?php echo $row_RS_Alumno['Email2']; ?></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top"  class="NombreCampoPRINT"><div align="right">Tel&eacute;fono Hab</div></td>
                <td align="right" class="FondoCampoPRINT"><div align="left"><?php echo $row_RS_Alumno['TelHab']; ?>
                </div></td>
                <td align="right" valign="top"  class="NombreCampoPRINT">Tel&eacute;fono Cel</td>
                <td class="FondoCampoPRINT"><?php echo $row_RS_Alumno['TelCel']; ?></td>
              </tr>
              <tr valign="baseline" >
                <td colspan="4" align="right" valign="top"  class="subtitle"><div align="left" class="promo">En caso de emergencia llamar a: </div></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top"  class="NombreCampoPRINT">Nombre</td>
                <td align="right"  class="FondoCampoPRINT"><?php echo $row_RS_Alumno['PerEmergencia']; ?></td>
                <td align="right" valign="top"  class="NombreCampoPRINT">&nbsp;</td>
                <td align="right" valign="top"  class="FondoCampoPRINT">&nbsp;</td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top"  class="NombreCampoPRINT"><div align="right">Tel&eacute;fonos</div></td>
                <td align="right"  class="FondoCampoPRINT"><div align="left"><?php echo $row_RS_Alumno['PerEmerTel']; ?></div></td>
                <td align="right" valign="top"  class="NombreCampoPRINT"> Nexo</td>
                <td align="right" valign="top"  class="FondoCampoPRINT"><?php echo $row_RS_Alumno['PerEmerNexo']; ?></td>
              </tr>
              <tr valign="baseline">
                <td colspan="4" align="right" valign="top"  class="subtitle"><div align="left" class="promo">Informaci&oacute;n M&eacute;dica </div></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top"  class="NombreCampoPRINT"><div align="right">Peso</div></td>
                <td align="right" class="FondoCampoPRINT"><div align="left"><?php echo $row_RS_Alumno['Peso']; ?>
                </div></td>
                <td align="right" valign="top"  class="NombreCampoPRINT">Vacunas</td>
                <td class="FondoCampoPRINT"><?php echo $row_RS_Alumno['Vacunas']; ?></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top"  class="NombreCampoPRINT"><div align="right">Enfermedades</div></td>
                <td align="right" class="FondoCampoPRINT"><div align="left"><?php echo $row_RS_Alumno['Enfermedades']; ?>
                </div></td>
                <td align="right" valign="top" class="NombreCampoPRINT">Tratamiento M&eacute;dico</td>
                <td class="FondoCampoPRINT"><?php echo $row_RS_Alumno['TratamientoMed']; ?></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top"  class="NombreCampoPRINT"><div align="right">Alergico a</div></td>
                <td align="right" class="FondoCampoPRINT"><div align="left"><?php echo $row_RS_Alumno['AlergicoA']; ?>
                </div></td>
                <td align="right" valign="top"  class="NombreCampoPRINT">&nbsp;</td>
                <td class="FondoCampoPRINT">&nbsp;</td>
              </tr>
              <tr valign="baseline">
                <td colspan="4" align="right" valign="top"  class="subtitle"><div align="left" class="promo">Otra informaci&oacute;n</div></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" class="NombreCampoPRINT"><div align="right">Colegio de <br>
        Procedencia</div></td>
                <td align="right" class="FondoCampoPRINT"><div align="left"><?php echo $row_RS_Alumno['ColegioProcedencia']; ?>
                </div></td>
                <td align="right" valign="top"  class="NombreCampoPRINT">Ciudad</td>
                <td class="FondoCampoPRINT"><?php echo $row_RS_Alumno['CiudadColProc']; ?></td>
              </tr>
              <tr valign="baseline">
                <td align="right"  class="NombreCampoPRINT">Observaciones</td>
                <td colspan="3" align="right" class="FondoCampoPRINT"><?php echo $row_RS_Alumno['Observaciones']; ?></td>
              </tr>
                        
            
        <tr>
          <td class="TextosSimples12" colspan="2"><?php echo $row_RS_Padre['CodigoRepresentante']; ?></td>
          <td class="RTitulo" colspan="2"><div align="right">Datos Del Padre</div></td>
        </tr>
            
            <tr>
              <td class="NombreCampoPRINT">      Nexo</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Padre['Nexo']; ?></td>
              <td class="NombreCampoPRINT">Representante</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Padre['SWrepre']; ?> </td>
            </tr>
            <tr>
              <td class="NombreCampoPRINT">Apellidos</td>
              <td  class="FondoCampoPRINT"><?php echo $row_RS_Padre['Apellidos']; ?></td>
              <td class="NombreCampoPRINT">C&eacute;dula</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Padre['Cedula']; ?> </td>
            </tr>
            <tr>
              <td class="NombreCampoPRINT">Nombres</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Padre['Nombres']; ?></td>
              <td class="NombreCampoPRINT">Edo Civil</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Padre['EdoCivil']; ?></td>
            </tr>
            <tr>
              <td  class="NombreCampoPRINT">Lugar de Nacimiento</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Padre['LugarNac']; ?></td>
              <td class="NombreCampoPRINT">Nacionalidad</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Padre['Nacionalidad']; ?></td>
            </tr>
            <tr>
              <td colspan="4" class="promo">Informaci&oacute;n de Contacto</td>
            </tr>
            <tr>
              <td  class="NombreCampoPRINT">Tel&eacute;fono Habitaci&oacute;n</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Padre['TelHab']; ?></td>
              <td class="NombreCampoPRINT">Email principal </td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Padre['Email1']; ?></td>
            </tr>
            <tr>
              <td  class="NombreCampoPRINT">Tel&eacute;fono Celular</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Padre['TelCel']; ?></td>
              <td  class="NombreCampoPRINT">Email secundario </td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Padre['Email2']; ?></td>
            </tr>
            <tr>
              <td  class="NombreCampoPRINT">Tel&eacute;fono Trabajo</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Padre['TelTra']; ?></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td rowspan="3" class="NombreCampoPRINT">Direcci&oacute;n</td>
              <td rowspan="3" class="FondoCampoPRINT"><?php echo $row_RS_Padre['Direccion']; ?></td>
              <td class="NombreCampoPRINT">Urbanizaci&oacute;n</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Padre['Urbanizacion']; ?></td>
            </tr>
            <tr>
              <td class="NombreCampoPRINT">Ciudad</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Padre['Ciudad']; ?></td>
            </tr>
            <tr>
              <td class="NombreCampoPRINT">Cod Postal</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Padre['CodPostal']; ?></td>
            </tr>
            <tr>
              <td colspan="4" class="promo">Informaci&oacute;n del Trabajo </td>
            </tr>
            <tr>
              <td class="NombreCampoPRINT">Ocupaci&oacute;n</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Padre['Ocupacion']; ?></td>
              <td class="NombreCampoPRINT">Profesi&oacute;n</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Padre['Profesion']; ?></td>
            </tr>
            <tr>
              <td class="NombreCampoPRINT">Empresa</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Padre['Empresa']; ?></td>
              <td class="NombreCampoPRINT">Actividad Empresa</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Padre['ActividadEmpresa']; ?></td>
            </tr>
            <tr>
              <td class="NombreCampoPRINT">Direcci&oacute;n del Trabajo </td>
              <td valign="top" class="FondoCampoPRINT"><?php echo $row_RS_Padre['DireccionTrabajo']; ?></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            
            
        <tr>
          <td class="TextosSimples12" colspan="2"><?php echo $row_RS_Madre['CodigoRepresentante']; ?></td>
          <td class="RTitulo" colspan="2"><div align="right">Datos de la Madre</div></td>
        </tr>
            
            <tr>
              <td class="NombreCampoPRINT"> Nexo</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Madre['Nexo']; ?></td>
              <td class="NombreCampoPRINT">Representante</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Madre['SWrepre']; ?> </td>
            </tr>
            <tr>
              <td class="NombreCampoPRINT">Apellidos</td>
              <td  class="FondoCampoPRINT"><?php echo $row_RS_Madre['Apellidos']; ?></td>
              <td class="NombreCampoPRINT">C&eacute;dula</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Madre['Cedula']; ?> </td>
            </tr>
            <tr>
              <td class="NombreCampoPRINT">Nombres</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Madre['Nombres']; ?></td>
              <td class="NombreCampoPRINT">Edo Civil</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Madre['EdoCivil']; ?></td>
            </tr>
            <tr>
              <td  class="NombreCampoPRINT">Lugar de Nacimiento</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Madre['LugarNac']; ?></td>
              <td class="NombreCampoPRINT">Nacionalidad</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Madre['Nacionalidad']; ?></td>
            </tr>
            <tr>
              <td colspan="4" class="promo">Informaci&oacute;n de Contacto</td>
            </tr>
            <tr>
              <td  class="NombreCampoPRINT">Tel&eacute;fono Habitaci&oacute;n</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Madre['TelHab']; ?></td>
              <td class="NombreCampoPRINT">Email principal </td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Madre['Email1']; ?></td>
            </tr>
            <tr>
              <td  class="NombreCampoPRINT">Tel&eacute;fono Celular</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Madre['TelCel']; ?></td>
              <td  class="NombreCampoPRINT">Email secundario </td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Madre['Email2']; ?></td>
            </tr>
            <tr>
              <td  class="NombreCampoPRINT">Tel&eacute;fono Trabajo</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Madre['TelTra']; ?></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td rowspan="3" class="NombreCampoPRINT">Direcci&oacute;n</td>
              <td rowspan="3" valign="top" class="FondoCampoPRINT"><?php echo $row_RS_Madre['Direccion']; ?><?php echo $row_RS_AbueloPaterno['Nombres']; ?></td>
              <td class="NombreCampoPRINT">Urbanizaci&oacute;n</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Madre['Urbanizacion']; ?></td>
            </tr>
            <tr>
              <td class="NombreCampoPRINT">Ciudad</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Madre['Ciudad']; ?></td>
            </tr>
            <tr>
              <td class="NombreCampoPRINT">Cod Postal</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Madre['CodPostal']; ?></td>
            </tr>
            <tr>
              <td colspan="4" class="promo">Informaci&oacute;n del Trabajo </td>
            </tr>
            <tr>
              <td class="NombreCampoPRINT">Ocupaci&oacute;n</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Madre['Ocupacion']; ?></td>
              <td class="NombreCampoPRINT">Profesi&oacute;n</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Madre['Profesion']; ?></td>
            </tr>
            <tr>
              <td class="NombreCampoPRINT">Empresa</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Madre['Empresa']; ?></td>
              <td class="NombreCampoPRINT">Actividad Empresa</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_Madre['ActividadEmpresa']; ?></td>
            </tr>
            <tr>
              <td class="NombreCampoPRINT">Direcci&oacute;n del Trabajo </td>
              <td valign="top" class="FondoCampoPRINT"><?php echo $row_RS_Madre['DireccionTrabajo']; ?></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            
            
        <tr>
          <td colspan="4" class="RTitulo"><div align="right">Datos Abuelos</div></td>
        </tr>
 
 <tr class="NombreCampoPRINT">
              <td class="NombreCampoPRINT">&nbsp;</td>
              <td class="NombreCampoPRINT"><div align="left">Apellidos y Nombres</div></td>
              <td class="NombreCampoPRINT"><div align="left">Lugar de Nac.</div></td>
              <td colspan="2" class="NombreCampoPRINT"><div align="left">Pais | Vive</div></td>
              </tr>
            <tr>
              <td class="NombreCampoPRINT">Abuelo Paterno</td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_AbueloPaterno['Apellidos']; ?>, <?php echo $row_RS_AbueloPaterno['Nombres']; ?></td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_AbueloPaterno['LugarDeNacimiento']; ?></td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_AbueloPaterno['PaisDeNacimiento']; ?> Vive: <?php echo $row_RS_AbueloPaterno['Vive']; ?></td>
              </tr>
            <tr>
              <td class="NombreCampoPRINT">Abuela Paterna </td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_AbuelaPaterna['Apellidos']; ?>, <?php echo $row_RS_AbuelaPaterna['Nombres']; ?></td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_AbuelaPaterna['LugarDeNacimiento']; ?></td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_AbuelaPaterna['PaisDeNacimiento']; ?> Vive: <?php echo $row_RS_AbuelaPaterna['Vive']; ?></td>
              </tr>
            <tr>
              <td class="NombreCampoPRINT">Abuelo Materno </td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_AbueloMaterno['Apellidos']; ?>, <?php echo $row_RS_AbueloMaterno['Nombres']; ?></td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_AbueloMaterno['LugarDeNacimiento']; ?></td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_AbueloMaterno['PaisDeNacimiento']; ?> Vive: <?php echo $row_RS_AbueloMaterno['Vive']; ?></td>
              </tr>
            <tr>
              <td class="NombreCampoPRINT">Abuela Materna </td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_AbuelaMaterna['Apellidos']; ?>, <?php echo $row_RS_AbuelaMaterna['Nombres']; ?></td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_AbuelaMaterna['LugarDeNacimiento']; ?></td>
              <td class="FondoCampoPRINT"><?php echo $row_RS_AbuelaMaterna['PaisDeNacimiento']; ?> Vive: <?php echo $row_RS_AbuelaMaterna['Vive']; ?></td>
              </tr>
            
            
  <?php if ($totalRows_RS_Autorizado != 0 ) { ?>
  <tr>
    <td class="RTitulo" colspan="4"><div align="right">Personas Autorizadas</div></td>
  </tr>
            
       <tr>
        <td class="NombreCampoPRINT"><div align="left">Autorizado </div></td>
        <td class="NombreCampoPRINT"><div align="left">Apellidos y Nombres </div></td>
        <td class="NombreCampoPRINT"><div align="left">C&eacute;dula</div></td>
        <td class="NombreCampoPRINT"><div align="left">Tel&eacute;fonos</div></td>
      </tr>
           
      <?php do { ?><tr>
          <td class="FondoCampoPRINT"><?php echo $row_RS_Autorizado['Ocupacion']; ?></td>
          <td class="FondoCampoPRINT"><?php echo $row_RS_Autorizado['Apellidos']; ?>, <?php echo $row_RS_Autorizado['Nombres']; ?> </td>
          <td class="FondoCampoPRINT"><?php echo $row_RS_Autorizado['Cedula']; ?></td>
          <td class="FondoCampoPRINT">H:<?php echo $row_RS_Autorizado['TelHab']; ?> Cel:<?php echo $row_RS_Autorizado['TelCel']; ?> <?php echo $row_RS_Autorizado['TelTra']; ?></td>
      </tr><?php } while ($row_RS_Autorizado = mysql_fetch_assoc($RS_Autorizado)); ?>
            
  <?php }?>  
  
          
            </table>          </td>
        </tr>
    </table>      
    </td>
  </tr>
  
  <tr>
    <td></td>
  </tr>
  <tr><td>
    <p align="center" class="RTitulo"><strong>Contrato de Prestaci&oacute;n de Servicios Educativos </strong></p>
    <p align="left"> <span class="TextosSimples12">Entre <strong>________________________</strong>, venezolano, mayor de edad, de este domicilio, identificado con la c&eacute;dula de identidad N&deg; V-<strong>________________</strong>, en su car&aacute;cter de representante de la Unidad Educativa COLEGIO SAN FRANCISCO DE AS&Iacute;S, inscrito ante el Ministerio de Educaci&oacute;n y Deportes bajo el N&deg; S0934D1507, ubicado en la calle 7 entre 4ta. Y 5ta. Av. de la Urbanizaci&oacute;n Los Palos Grandes, Caracas, en lo adelante y a los efectos de este contrato LA INSTITUCI&Oacute;N, por una parte; y, por la otra, <strong><?php echo $row_RS_Padre['Apellidos']; ?> <?php echo $row_RS_Padre['Nombres']; ?> / <?php echo $row_RS_Madre['Apellidos']; ?>  <?php echo $row_RS_Madre['Nombres']; ?></strong>, <?php echo $row_RS_Padre['Nacionalidad']; ?> / <?php echo $row_RS_Madre['Nacionalidad']; ?>, mayor de edad, de este domicilio, identificado con la c&eacute;dula de identidad N&deg; <strong><?php echo $row_RS_Padre['Cedula']; ?> / <?php echo $row_RS_Madre['Cedula']; ?></strong>, en lo adelante EL REPRESENTANTE LEGAL, actuando en su car&aacute;cter de ______________ del menor <strong><?php echo $row_RS_Alumno['Apellidos']; ?> <?php echo $row_RS_Alumno['Nombres']; ?> </strong>, <strong><?php echo $row_RS_Alumno['Nacionalidad']; ?></strong>, nacido en <strong><?php echo $row_RS_Alumno['Localidad']; ?></strong>, el d&iacute;a <strong><?php echo substr($row_RS_Alumno['FechaNac'], 8, 2).'-'.substr($row_RS_Alumno['FechaNac'], 5, 2).'-'.substr($row_RS_Alumno['FechaNac'],0,4) ; ?></strong>, en lo adelante EL ESTUDIANTE, se ha convenido en celebrar como en efecto se celebra el presente CONTRATO DE PRESTACI&Oacute;N DE SERVICIOS EDUCATIVOS, el cual se regir&aacute; por las siguientes cl&aacute;usulas: </span></p>
    <p class="TextosSimples12"><strong> Cl&aacute;usula Primera</strong> : LA INSTITUCION es una empresa de car&aacute;cter privado no subsidiada por un ente oficial, ni de la administraci&oacute;n p&uacute;blica central ni descentralizada, que presta servicios de instrucci&oacute;n, atenci&oacute;n, educaci&oacute;n y cuidado en general a estudiantes que as&iacute; lo soliciten, presta ndo sus servicios durante los d&iacute;as h&aacute;biles en el calendario educativo que a tal efecto decrete el Ministerio de Educaci&oacute;n, Cultura y Deportes, en el turno indicado y en las condiciones del presente contrato. En virtud a lo anterior, LA INSTITUCION se compromete a brindar a EL ESTUDIANTE una educaci&oacute;n de calidad, garantizar el adecuado mantenimiento de su planta f&iacute;sica, garantizar la dotaci&oacute;n de los insumos necesarios para su buen funcionamiento, as&iacute; como garantizar la contrataci&oacute;n de personal capacitado, poseedor de valores &eacute;ticos y morales. </p>
    <p class="TextosSimples12"><strong> Cl&aacute;usula Segunda</strong> : Forman parte integrante del presente contrato las estipulaciones contenidas en el mismo, el Reglamento Interno de LA INSTITUCION, el cual se encuentra publicado en la p&aacute;gina web www.sanfrancisco.e12.ve, el cual declaran conocer y aceptar y, las declaraciones e informaciones contenidas en las solicitudes firmadas por EL REPRESENTANTE LEGAL de EL ESTUDIANTE y los anexos incorporados en el expediente correspondiente; todo lo cual EL REPRESENTANTELEGAL declara expresamente conocer y estar conforme con los mismos. </p>
    <p class="TextosSimples12"><strong> Cl&aacute;usula Tercera:</strong> La vigencia del presente contrato es por el t&eacute;rmino de un a&ntilde;o fijo escolar, entendiendo por tal el que se inicia el 15 de septiembre de 2008 y culmina el 31 de julio de 2009 . </p>
    <p class="TextosSimples12"><strong> Cl&aacute;usula Cuarta:</strong> El presente contrato se perfecciona una vez que EL REPRESENTANTE LEGAL suscriba el registro de EL ESTUDIANTE y cancele total o parcialmente el monto correspondiente de la matr&iacute;cula o inscripci&oacute;n, &uacute;tiles escolares o materiales, Seguro Escolar, Rescarvencito, cuota anual de la Sociedad de Padres-Representantes y mensualidades. </p>
    <p class="TextosSimples12"><strong> Cl&aacute;usula Quinta:</strong> LA INSTITUCION se compromete a prestar sus servicios a EL ESTUDIANTE, empleando para ello todos sus conocimientos y dedicaci&oacute;n para el mayor &eacute;xito de las funciones que le son encomendadas; y, por su parte, EL REPRESENTANTE LEGAL se obliga a cumplir y hacer cumplir a EL ESTUDIANTE, todas y cada una de las estipulaciones del presente contrato, as&iacute; como del Reglamento Interno de LA INSTITUCI&Oacute;N. Asimismo, EL REPRESENTANTE LEGAL como contraprestaci&oacute;n al servicio que se obliga impartir LA INSTITUCI&Oacute;N, pagar&aacute; a &eacute;sta los derechos de matr&iacute;cula y escolaridad correspondientes al a&ntilde;o escolar anteriormente definido, que incluyen el pago de doce (12) cuotas mensuales y consecutivas, las cuales deber&aacute;n ser canceladas durante los primeros cinco (5) d&iacute;as de cada mes. </p>
    <p class="TextosSimples12"><strong> Cl&aacute;usula Sexta:</strong> EL REPRESENTANTE LEGAL declara expresamente aceptar los montos fijados como derechos de escolaridad para el a&ntilde;o escolar, los cuales podr&aacute;n ser objeto de ajustes por variaci&oacute;n de los costos, tales como incremento en la remuneraci&oacute;n del personal, aumentos de los servicios p&uacute;blicos, bonos, cualquier otro tipo de beneficio, aumentos de equipos, insumos, y/ o acuerdo s de Contrataci&oacute;n Magisterial , siempre y cuando sean permitidos legalmente. Queda entendido que en caso de ajustes de los derechos de la escolaridad, LA INSTITUCION deber&aacute; notificar por escrito a EL REPRESENTANTE LEGAL con por lo menos treinta (30) d&iacute;as de anticipaci&oacute;n, la cual se har&aacute; mediante circular enviada a trav&eacute;s de EL ESTUDIANTE. En caso de operar aumentos y EL REPRESENTANTE LEGAL hubiere cancelado mensualidades por adelantado o aquellas correspondientes al per&iacute;odo vacacional, una vez se practique la debida notificaci&oacute;n se deber&aacute; pagar la diferencia respectiva. </p>
    <p class="TextosSimples12"><strong> Cl&aacute;usula S&eacute;ptima:</strong> La falta de pago de una o m&aacute;s mensualidad es o cuotas por parte de EL REPRESENTANTE LEGAL, se considerar&aacute; como imposibilidad en sustentar la educaci&oacute;n privada de su representado o EL ESTUDIANTE, por lo que LA INSTITUCION coadyuvar&aacute; en la b&uacute;squeda y consecuci&oacute;n de un cupo en una instituci&oacute;n de car&aacute;cter p&uacute;blico para &eacute;ste. </p>
    <p class="TextosSimples12"><strong> Cl&aacute;usula Octava:</strong> En caso de resoluci&oacute;n anticipada del presente contrato o en el caso de que EL ESTUDIANTE sea retirado, EL REPRESENTANTE LEGAL estar&aacute; obligado a cancelar hasta la mensualidad correspondiente a la fecha del retiro , y no tendr&aacute; derecho al reembolso o reintegro bajo ning&uacute;n concepto ni por ninguna causa de lo pagado por concepto de matr&iacute;cula, inscripci&oacute;n, escolaridad, renovaci&oacute;n de inscripci&oacute;n, seguro escolar, mensualidades y material. EL REPRESENTANTE LEGAL libera a LA INSTITUCI&Oacute;N de cualquier responsabilidad legal relacionada con el retiro de EL ESTUDIANTE, motivado por el incumplimiento de este contrato tanto de EL REPRESENTANTE LEGAL como de EL ESTUDIANTE. </p>
    <p class="TextosSimples12"><strong> Cl&aacute;usula Novena:</strong> EL REPRESENTANTE LEGAL podr&aacute; reservar la inscripci&oacute;n de EL ESTUDIANTE antes de la finalizaci&oacute;n del a&ntilde;o escolar, llenando a tal efecto la planilla correspondiente y cancelando una parte de la misma. El pago que resultare pendiente ser&aacute; cancelado por EL REPRESENTANTE LEGAL en el transcurso del mes de julio. En caso que quedar e pendiente parte del pago del a&ntilde;o escolar inmediato anterior, la misma deber&aacute; ser pagada antes del primero (1 &deg; ) de septiembre del a&ntilde;o escolar. </p>
    <p class="TextosSimples12"><strong> Cl&aacute;usula D&eacute;cima:</strong> La L ey Org&aacute;nica para la Protecci&oacute;n del Ni&ntilde;o y del Adolescente establece: </p>
    <p class="TextosSimples12"> Art&iacute;culo 54.- Los padres, representantes o responsables tienen la obligaci&oacute;n inmediata de garantizar la educaci&oacute;n de los ni&ntilde;os y adolescentes . </p>
    <p class="TextosSimples12"> Art &iacute;culo 53 .- Todos los ni&ntilde;os y adolescentes tienen derecho a la educaci&oacute;n. Asimismo, tienen derecho a ser inscritos y recibir educaci&oacute;n en una escuela, plantel o instituto oficial de car&aacute;cter gratuito y cercano a su residencia. </p>
    <p class="TextosSimples12"> Art&iacute;culo 365. - La obligaci&oacute;n alimentar&iacute;a comprende todo lo relativo al sustento, vestido, habitaci&oacute;n, educaci&oacute;n, cultura, asistencia y atenci&oacute;n m&eacute;dica, medicinas, recreaci&oacute;n y deportes, requeridos por el ni&ntilde;o y el adolescente. </p>
    <p class="TextosSimples12"> Art&iacute;culo 366 .- La obligaci&oacute;n alimentaria es un efecto de la filiaci&oacute;n legal o judicialmente establecida, que corresponde al padre y a la madre respecto a sus hijos que no hayan alcanzado la mayoridad. Esta obligaci&oacute;n subsiste aun cuando exista privaci&oacute;n o extinci&oacute;n de la patria potestad, o no se tenga la guarda del hijo, a cuyo efecto se fijar&aacute; expresamente por el juez el monto que debe pagarse por tal concepto, en la oportunidad que se dicte la sentencia de privaci&oacute;n o extinci&oacute;n de la patria potestad, o se dicte alguna de las medidas contempladas en el art&iacute;culo 360 de esta Ley. </p>
    <p class="TextosSimples12"> Art&iacute;culo 223 .- El obligado alimentario que incumpla injustificadamente, ser&aacute; sancionado con multa de uno (1) a diez (10) meses de ingreso. </p>
    <p class="TextosSimples12"> Por su parte, la Constituci&oacute;n de la Rep&uacute;blica Bolivariana de Venezuela, en su art&iacute;culo 103 consagra: Toda persona tiene derecho a una educaci&oacute;n integral, de calidad, permanente, en igualdad de condiciones y oportunidades, sin m&aacute;s limitaciones que las derivadas de sus aptitudes, vocaci&oacute;n y aspiraciones. La educaci&oacute;n es obligatoria en todos sus niveles, desde el maternal, hasta el nivel medio diversificado. La impartida por el Estado es gratuita hasta el pregrado universitario. </p>
    <p class="TextosSimples12"> En virtud a lo antes expuesto, queda expresamente establecido que EL REPRESENTANTE LEGAL por voluntad propia inscribe a EL ESTUDIANTE en LA INSTITUCI&Oacute;N , la cual como se estableci&oacute; anteriormente, es una instituci&oacute;n privada y no gratuita, por lo que se compromete a cancelar puntualmente las cuotas establecidas. </p>
    <p class="TextosSimples12"><strong> Cl&aacute;usula D&eacute;cimoprimera:</strong> Queda expresamente convenido que LA INSTITUCION no es responsable por da&ntilde;os sufridos por los alumnos durante su permanencia en sus instalaciones, ocasionados por terremotos, explosiones, inundaciones y/ o cualquier otra circunstancia de fuerza mayor o caso fortuito. </p>
    <p class="TextosSimples12"><strong> Cl&aacute;usula D&eacute;cimosegunda:</strong> LA INSTITUCION se obliga a mantener vigente una p&oacute;liza de seguro de accidentes personales, por lo que, en caso de ocurrir alg&uacute;n siniestro , EL REPRESENTANTE LEGAL aceptar&aacute; y estar&aacute; conforme con el monto de la cobertura y condiciones de la p&oacute;liza suscrita, as&iacute; como la indemnizaci&oacute;n que acuerde la compa&ntilde;&iacute;a de seguro y en consecuencia, libera de toda responsabilidad a LA INSTITUCION por cualquier excedente del monto cubierto, as&iacute; como de otro da&ntilde;o que hubiere podido sufrir, ni por lucro cesante o da&ntilde;os emergentes. </p>
    <p class="TextosSimples12"><strong> Cl&aacute;usula D&eacute;cimotercera:</strong> Si en el momento de la inscripci&oacute;n EL REPRESENTANTE LEGAL no solicit&oacute; la inscripci&oacute;n en cualquiera de las asignaciones o servicios prestados en el colegio, &eacute;sta no podr&aacute; realizarla hasta despu&eacute;s de iniciarse el mes de enero del a&ntilde;o escolar en curso. </p>
    <p class="TextosSimples12"><strong> Cl&aacute;usula D&eacute;cimocuarta:</strong> Queda expresamente convenido que en caso de que EL ESTUDIANTE llegare a contraer una enfermedad contagiosa, EL REPRESENTANTE LEGAL deber&aacute; abstenerse de enviarlo a LA INSTITUCI&Oacute;N, debiendo en t odo caso, enviar una comunicaci&oacute;n escrita con la constancia m&eacute;dica correspondiente. </p>
    <p class="TextosSimples12"><strong> Cl&aacute;usula D&eacute;cimoquinta:</strong> Toda solicitud de constancia de estudios y/o alg&uacute;n otro documento, de ser procedente, ser&aacute; tramitada en un lapso m&iacute;nimo de tres (3) d&iacute;as h&aacute;biles contados a partir de la fecha efectiva de su solicitud. </p>
    <p class="TextosSimples12"><strong> Cl&aacute;usula D&eacute;cimosexta:</strong> EL REPRESENTANTE LEGAL no podr&aacute; enviar para retirar de LA INSTITUCI&Oacute;N a EL ESTUDIANTE, a una persona que no haya sido autorizada previamente por EL REPRESENTANTE LEGAL por escrito. </p>
    <p class="TextosSimples12"><strong> Cl&aacute;usula D&eacute;cimos&eacute;ptima:</strong> En caso de ocurrir hechos que menoscaben la integridad material de LA INSTITUCI&Oacute;N, EL REPRESENTANTE LEGAL se compromete a cubrir los gastos de reposici&oacute;n de aquellos bienes que hayan sufrido da&ntilde;os, causados por EL ESTUDIANTE. </p>
    <p class="TextosSimples12"><strong> Cl&aacute;usula D&eacute;cimoctava:</strong> Queda expresamente convenido que LA INSTITUCI&Oacute;N presta como servicios complementarios y/o actividades extracurriculares, servicio de comedor, clases de danza, computaci&oacute;n, karate, futbolito, pintura, ajedrez, por lo que en caso de ser contratados por EL REPRESENTANTE LEGAL para EL ESTUDIANTE, los mismos deber&aacute;n ser cancelados aparte y de forma adicional a las mensualidades. </p>
    <p class="TextosSimples12"><strong> Cl&aacute;usula D&eacute;cimo novena:</strong> Queda expresamente convenido que LA INSTITUCI&Oacute;N no presta servicio de transporte escolar, por lo que no se hace responsable por la forma en que EL ESTUDIANTE llega y/o se retira de LA INSTITUCI&Oacute;N. </p>
    <p class="TextosSimples12"><strong> Cl&aacute;usula Vig&eacute;sima: </strong> Por medio del presente documento EL REPRESENTANTE LEGAL declara Si ____ / No ____ autorizar a EL ESTUDIANTE para que al finalizar las actividades escolares salga de LA INSTITUCION por sus propios medios. </p>
    <p class="TextosSimples12"> Se hacen dos ejemplares de un mismo tenor y a un solo efecto, en Caracas a los <strong><?php echo date ('d') ; ?></strong> d&iacute;as del mes de <strong><?php echo date ('m') ; ?></strong> de <strong><?php echo date ('Y') ; ?></strong>. </p>
    <p class="TextosSimples12">&nbsp;</p>
    <p class="TextosSimples12">&nbsp;</p>
    <table width="95%"  border="0" align="center">
      <tr>
        <td><div align="center">_______________________________</div></td>
        <td><div align="center">_______________________________</div></td>
        <td><div align="center">_______________________________</div></td>
      </tr>
      <tr>
        <td><div align="center">Nombre y Apellido del Representante </div></td>
        <td><div align="center">Cedula de Identidad </div></td>
        <td><div align="center">Firma</div></td>
      </tr>
    </table>    
    </td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($RS_Alumnos);

mysql_free_result($RS_Representante);

mysql_free_result($RS_Padre);

mysql_free_result($RS_Madre);

mysql_free_result($RS_Autorizado);

mysql_free_result($RS_AbuelaPaterna);

mysql_free_result($RS_AbueloPaterno);

mysql_free_result($RS_AbueloMaterno);

mysql_free_result($RS_AbuelaMaterna);

mysql_free_result($RS_Alumno);

mysql_free_result($RS_Curso);
?>