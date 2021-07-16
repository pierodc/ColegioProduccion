<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable,provee,secreBach";
$SW_omite_trace = false;
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 
//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php'); 

$TituloPantalla = "Planillas Ministerio";


 
if(isset($_POST['NumeroTitulo'])){
	$NumeroTitulo = $_POST['NumeroTitulo'];
	$sql = "UPDATE AlumnoXCurso
			SET NumeroTitulo = '$NumeroTitulo'
			WHERE Codigo = '".$_POST['Codigo']."'";
	$mysqli->query($sql);
	
} 
 
 
 if(isset($_POST['NumeroTituloR'])){
	$NumeroTitulo = $_POST['NumeroTituloR'];
	$Codigo = $_POST['Codigo'];
	$sql = "UPDATE AlumnoXCurso
			SET NumeroTitulo = '$NumeroTitulo'
			WHERE Codigo = '".$Codigo."'";
	echo $sql;		
	$mysqli->query($sql);		
	
} 


//mysql_select_db($database_bd, $bd);
$query_RS_Tit = "SELECT * FROM AlumnoXCurso, Alumno WHERE 
					AlumnoXCurso.FechaGrado = 'Julio20".$Ano2."' AND 
					AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno AND
					AlumnoXCurso.Tipo_Inscripcion = 'Rg' 
					ORDER BY AlumnoXCurso.NumeroTitulo,  AlumnoXCurso.CodigoCurso ASC, Alumno.CedulaLetra DESC, Alumno.Cedula_int ASC";
//echo $query_RS_Tit;
$RS_Tit = $mysqli->query($query_RS_Tit); //
$row_RS_Tit = $RS_Tit->fetch_assoc();
$totalRows_RS_Tit = $RS_Tit->num_rows;



/*
$RS_Tit = mysql_query($query_RS_Tit, $bd) or die(mysql_error());
$row_RS_Tit = mysql_fetch_assoc($RS_Tit);
$totalRows_RS_Tit = mysql_num_rows($RS_Tit);*/

$query_RS_TitR = "SELECT * FROM AlumnoXCurso, Alumno WHERE 
					AlumnoXCurso.FechaGrado = 'Julio20".$Ano2."R' AND 
					AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno 
					ORDER BY AlumnoXCurso.CodigoCurso ASC, Alumno.CedulaLetra DESC, Alumno.Cedula_int ASC";
					
$query_RS_TitR = "SELECT * FROM AlumnoXCurso, Alumno WHERE 
					AlumnoXCurso.FechaGrado <> 'Julio20".$Ano2."' AND 
					AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno AND
					AlumnoXCurso.Ano = '$AnoEscolar' AND
					(AlumnoXCurso.CodigoCurso = '44' or AlumnoXCurso.CodigoCurso = '43' )
					GROUP BY Alumno.Cedula_int 
					ORDER BY AlumnoXCurso.CodigoCurso ASC, Alumno.CedulaLetra DESC, Alumno.Cedula_int ASC
					";
$RS_TitR = $mysqli->query($query_RS_TitR); //
$row_RS_TitR = $RS_TitR->fetch_assoc();
$totalRows_RS_TitR = $RS_TitR->num_rows;
		/*			
$RS_TitR = mysql_query($query_RS_TitR, $bd) or die(mysql_error());
$row_RS_TitR = mysql_fetch_assoc($RS_TitR);
$totalRows_RS_TitR = mysql_num_rows($RS_TitR);
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
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<body onload="document.form<?php echo $_GET['FormN'] ?>.NumeroTitulo.focus() ">
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><?php require_once('../TitAdmin.php'); ?></td>
  </tr>
  <tr>
    <td align="center" valign="top"><table width="900" border="0" cellpadding="2">
        <tr>
          <td class="NombreCampo">Titulo</td>
        </tr>
        <tr <?php echo $sw=ListaFondo($sw,$Verde);  ?>>
          <td><p><a href="PDF/Resumen_Final_Bach.php?CodigoCurso=&AnoEscolar=<?php echo $AnoEscolar; ?>" target="_blank">Resumen Final Bachillerato (<?php echo $AnoEscolar; ?>)</a> / <a href="PDF/Resumen_Final_Bach.php?CodigoCurso=&amp;AnoEscolar=<?php echo $AnoEscolarAnte ?>" target="_blank">(<?php echo $AnoEscolarAnte; ?>)</a>  / <a href="PDF/Resumen_Final_Bach.php?CodigoCurso=&amp;AnoEscolar=2017-2018" target="_blank">(2017-2018)</a>(Colocar &quot;N&quot; en las materias que no cursan los repitientes en la pantalla &quot;Revision de Definitiva&quot; o &quot;RevDef&quot;)</p>
            <p><a href="PDF/Resumen_Final_Prim.php?CodigoCurso=&AnoEscolar=<?php echo $AnoEscolar ?>" target="_blank">Resumen Final Primaria (<?php echo $AnoEscolar; ?>)</a> / <a href="PDF/Resumen_Final_Prim.php?CodigoCurso=&AnoEscolar=<?php echo $AnoEscolarAnte ?>" target="_blank">(<?php echo $AnoEscolarAnte; ?>)</a></p>
            <p><a href="PDF/Resumen_Final_Pree.php?CodigoCurso=&AnoEscolar=<?php echo $AnoEscolar ?>" target="_blank">Resumen Final Preescolar (<?php echo $AnoEscolar; ?>)</a> / <a href="PDF/Resumen_Final_Pree.php?CodigoCurso=&AnoEscolar=<?php echo $AnoEscolarAnte ?>" target="_blank">(<?php echo $AnoEscolarAnte; ?>)</a></p>
            <p><a href="PDF/Resumen_Final_Bach.php?CodigoCurso=&AnoEscolar=<?php echo $AnoEscolar; ?>&TipoEvaluacion=Revision" target="_blank">Revision</a> / <a href="PDF/Resumen_Final_Bach.php?CodigoCurso=&AnoEscolar=<?php echo $AnoEscolarAnte ?>&TipoEvaluacion=Revision" target="_blank">(<?php echo $AnoEscolarAnte; ?>)</a> (Colocar las notas en la pantalla Notas-Revision)</p>
            <p><a href="PDF/Resumen_Final_Bach.php?CodigoCurso=&AnoEscolar=<?php echo $AnoEscolarAnte; ?>&TipoEvaluacion=MatPendiente&Momento=M01" target="_blank">Materia Pendiente Momento 1</a></p>
            <p><a href="PDF/Resumen_Final_Bach.php?CodigoCurso=&AnoEscolar=<?php echo $AnoEscolarAnte; ?>&TipoEvaluacion=MatPendiente&Momento=M02" target="_blank">Materia Pendiente Momento 2</a></p>
            <p><a href="PDF/Resumen_Final_Bach.php?CodigoCurso=&AnoEscolar=<?php echo $AnoEscolarAnte; ?>&TipoEvaluacion=MatPendiente&Momento=M03" target="_blank">Materia Pendiente Momento 3</a></p>
            <p><a href="PDF/Resumen_Final_Bach.php?CodigoCurso=&AnoEscolar=<?php echo $AnoEscolarAnte; ?>&TipoEvaluacion=MatPendiente&Momento=M04" target="_blank">Materia Pendiente Momento 4</a></p>
            <p><a href="PDF/Resumen_Final_Bach.php?CodigoCurso=&AnoEscolar=<?php echo $AnoEscolarAnte; ?>&TipoEvaluacion=Equivalencia" target="_blank">Equivalencia</a></p>
          <p><a href="Cursos_Mant_Prof.php">Profesores del curso</a></p></td>
        </tr>
        <tr <?php echo $sw=ListaFondo($sw,$Verde);  ?>>
          <td>&nbsp;</td>
        </tr>
        <tr <?php echo $sw=ListaFondo($sw,$Verde);  ?>>
          <td>&nbsp;</td>
        </tr>
        <tr <?php echo $sw=ListaFondo($sw,$Verde);  ?>>
          <td><table width="100%" border="1">
            <tr>
              <td width="25%" valign="top"><a href="PDF/Registro_Titulos.php?CodigoCurso=43" target="_blank">Registro de Titulos 5A</a></td>
              <td width="25%" valign="top"><a href="PDF/Registro_Titulos.php?CodigoCurso=44" target="_blank">Registro de Titulos 5B</a></td>
              <td width="25%" valign="top"><a href="PDF/Registro_Titulos.php?CodigoCurso=43&Revision=1" target="_blank">Registro de Titulos 5A</a></td>
              <td width="25%" valign="top"><a href="PDF/Registro_Titulos.php?CodigoCurso=44&Revision=1" target="_blank">Registro de Titulos 5B</a></td>
            </tr>
            <tr>
              <td colspan="2" valign="top"><a href="PDF/Titulo_Bachiller.php" target="_blank">T&iacute;tulos Bachiller</a></td>
              <td width="50%" colspan="2" valign="top"><a href="PDF/Titulo_Bachiller.php?Revision=1" target="_blank">T&iacute;tulos Bachiller - Revisi&oacute;n </a></td>
            </tr>
            <tr>
              <td colspan="2" valign="top">
                <table width="100%">
<?php do { ?>
                  <tr <?php echo $sw=ListaFondo($sw,$Verde);  ?>>
                    <td>
                <a href="PDF/Titulo_Bachiller.php?CodigoAlumno=<?php echo $row_RS_Tit['CodigoAlumno']; ?>" target="_blank"> <?php echo ++$No.') '.$row_RS_Tit['Apellidos'].' '.$row_RS_Tit['Apellidos2'].' '.$row_RS_Tit['Nombres'].' '.$row_RS_Tit['Nombres2']; ?></a>&nbsp;</td>
                    <td align="right"><form id="form<?php echo ++$FormN ?>" name="form<?php echo $FormN ?>" method="post" action="PlanilllasMinisterio.php?FormN=<?php echo $FormN ?>">
                      <input name="Codigo" type="hidden" id="Codigo" value="<?php echo $row_RS_Tit['Codigo'] ?>" />
                      <input name="NumeroTitulo" type="text" id="NumeroTitulo" size="10" value="<?php echo $row_RS_Tit['NumeroTitulo'] ?>" />
                      <input type="submit" name="button" id="button" value="G" />
                    </form></td>
                  </tr>
<?php } while ($row_RS_Tit = $RS_Tit->fetch_assoc()); ?>
                </table>
                </td>
              <td colspan="2" valign="top">
                <table width="100%">
  <?php do { ?>
    <tr <?php echo $sw=ListaFondo($sw,$Verde);  ?>>
      <td>
        <a href="PDF/Titulo_Bachiller.php?CodigoAlumno=<?php echo $row_RS_TitR['CodigoAlumno']; ?>&Revision=1" target="_blank"><?php echo $row_RS_TitR['Apellidos']; ?> <?php echo $row_RS_TitR['Apellidos2']; ?> <?php echo $row_RS_TitR['Nombres']; ?> <?php echo $row_RS_TitR['Nombres2']; ?></a>&nbsp;</td>
      <td align="right"><form id="form1" name="form1" method="post" action="">
                      <input name="Codigo" type="hidden" id="Codigo" value="<?php echo $row_RS_TitR['Codigo'] ?>" />
                      <input name="NumeroTituloR" type="text" id="NumeroTituloR" size="10" value="<?php echo $row_RS_TitR['NumeroTitulo'] ?>" />
                      <input type="submit" name="button" id="button" value="G" />
                    </form></td>
      </tr>
  <?php } while ($row_RS_TitR = $RS_TitR->fetch_assoc()  ); ?>
                  </table>
              </td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
              <td colspan="2">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
    </table>      &nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
</table>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>