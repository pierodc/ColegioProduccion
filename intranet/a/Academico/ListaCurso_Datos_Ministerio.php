<?php
$MM_authorizedUsers = "91,95,AsistDireccion,secreAcad,secreBach";
$SW_omite_trace = false;
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 
$TituloPagina   = "Datos Ministerio"; // <title>
$TituloPantalla = "Datos Ministerio"; // Titulo contenido

//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php');
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

//  mysql_select_db($database_bd, $bd);


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

  $Result1 = $mysqli->query($updateSQL); // mysql_query($updateSQL, $bd) or die(mysql_error());
}

$colname_RS_Curso = "0";
if (isset($_GET['CodigoCurso'])) {
  $colname_RS_Curso = addslashes($_GET['CodigoCurso']);
}
$query_RS_Curso = sprintf("SELECT * FROM Curso WHERE CodigoCurso = %s", $colname_RS_Curso);
$RS_Curso = $mysqli->query($query_RS_Curso); //
$row_RS_Curso = $RS_Curso->fetch_assoc();
$totalRows_RS_Curso = $RS_Curso->num_rows;
/*
$RS_Curso = mysql_query($query_RS_Curso, $bd) or die(mysql_error());
$row_RS_Curso = mysql_fetch_assoc($RS_Curso);
$totalRows_RS_Curso = mysql_num_rows($RS_Curso);
*/


$RS_Alumno = $mysqli->query($query_RS_Alumno); //
$row_RS_Alumno = $RS_Alumno->fetch_assoc();
$totalRows_RS_Alumno = $RS_Alumno->num_rows;
/*
$RS_Alumno = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumno = mysql_fetch_assoc($RS_Alumno);
$totalRows_RS_Alumno = mysql_num_rows($RS_Alumno);
*/

$query_RS_Cursos = "SELECT * FROM Curso ORDER BY NivelMencion ASC, Curso.Curso, Curso.Seccion";
$RS_Cursos = $mysqli->query($query_RS_Cursos); //
$row_RS_Cursos = $RS_Cursos->fetch_assoc();
$totalRows_RS_Cursos = $RS_Cursos->num_rows;
/*
$RS_Cursos = mysql_query($query_RS_Cursos, $bd) or die(mysql_error());
$row_RS_Cursos = mysql_fetch_assoc($RS_Cursos);
$totalRows_RS_Cursos = mysql_num_rows($RS_Cursos);
*/



require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/BeforeHTML.php" );
?><!doctype html>
<html lang="es">
  <head>
	<? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Head.php");  ?>
    <title><?php echo $TituloPag; ?></title>
  <meta charset="ISO-8859-1">
</head>
<body <? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Body_tag.php");  ?>>
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/NavBar.php");  ?>
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Header.php"); ?>
 <div class="container-fluid">
    <div class="row">
		<div class="col-md-12">
			<div>

 <?php 
		  
		  $extraOpcion = $_SERVER['PHP_SELF'] ."?";
		  if(isset($_GET['AnoEscolar']))
			  $extraOpcion.= "AnoEscolar=".$_GET['AnoEscolar']."&";
		  $extraOpcion.= "CodigoCurso=";	
				  
		  Ir_a_Curso($_GET['CodigoCurso'],$extraOpcion);
		  
		  
		  ?>    
            </div>
		</div>
	</div>
</div>
 
  <div class="container-fluid">
    <div class="row">
		<div class="col-md-12">
			<div>


<table width="100%" border="0" align="center">
  
  <tr>
  <tr>
    <td colspan="2" align="center"><table width="100%"  border="0" align="center" cellpadding="2">
        <tr>
          <td colspan="3" class="NombreCampoBIG">      </td>
        </tr>
        <tr>
          <td colspan="2" class="NombreCampo"><p> 
          <a href="../ListaCurso_Datos_Min_Print.php?CodigoCurso=<?php echo $_GET['CodigoCurso'] ?>" target="_blank">Imprimir</a> |
           <a href="../Lista/Datos_Seguro_xls.php?CodigoCurso=<?php echo $_GET['CodigoCurso'] ?>"> Download Curso</a> |
           <a href="../Lista/Datos_Seguro_xls.php?Orden=Cedula">Download Seguro</a> |
           <a href="../Lista/Datos_Seguro_xls.php?Orden=Cedula&Asegura_hoy=1">Asegura_hoy</a>
           
           </p>  
           
                   </td>
        </tr>
                <tr>
          <td width="5" nowrap="nowrap" class="FondoCampo"><strong>No.</strong> </td>
          <td align="left"  nowrap="nowrap" class="FondoCampo">000000 
              <input name="CedulaLetra" type="text" id="CedulaLetra" value="V/E" size="1" /> &nbsp;
              <input name="Cedula" type="text" id="Cedula" value="Cedula" size="14" />
              <input name="Apellidos" type="text" id="Apellidos" value="Apellido 1" size="9" />
              <input name="Apellidos2" type="text" id="Apellidos2" value="Apellido 2" size="9" />
              <input name="Nombres" type="text" id="Nombres" value="Nombre 1" size="9" />
              <input name="Nombres2" type="text" id="Nombres2" value="Nombre 2" size="9" />
               <input name="Sexo" type="text" id="Sexo" value="Sexo" size="1" />
              <input name="Fecha Nacimiento" type="text" id="FechaNac" value="Fecha Nacimiento" size="20" />
              <input name="Nacionalidad" type="text" id="Nacionalidad" value="Nacionalidad" size="2" />
              <input name="Clinica De Nac" type="text" id="ClinicaDeNac" value="Clinica De Nac" size="15" />
              <input name="Localidad" type="text" id="Localidad" value="Localidad/Municipio" size="15" />
              <input name="Entidad" type="text" id="Entidad" value="Entidad" size="25" />
            <input name="LocalidadPais" type="text" id="LocalidadPais" value="Pais" size="10" />
            <input name="Datos_Revisado_por" type="text" id="Datos_Revisado_por" value="Observ Planilla" size="15" />
            <input name="Datos_Revisado_por" type="text" id="Datos_Revisado_por" value="Obser" size="5" /></td>
        </tr>

        <?php do { ?>
        <?php if ($totalRows_RS_Alumno > 0) { // Show if recordset not empty 		?>
            <tr>
              <td colspan="2" nowrap="nowrap" <?php ListaFondo($sw , $Verde) ;?>><iframe src="iFr/Datos_Ministerio.php?No=<?php echo ++$No; ?>&CodigoAlumno=<?php echo $row_RS_Alumno['CodigoAlumno'] ?>" seamless="seamless" frameborder="0" width="100%" height="27" scrolling="no"></iframe></td>
            </tr>
            
          
        <?php } // Show if recordset not empty ?>
        <?php } while ($row_RS_Alumno = $RS_Alumno->fetch_assoc()); ?>
    </table></td>
  </tr>
</table>

				
				

            </div>
		</div>
	</div>
</div>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer_info.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/AfterHTML.php"); ?>				
				
