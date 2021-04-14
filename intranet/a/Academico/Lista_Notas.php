<?php
$MM_authorizedUsers = "91,95,secreAcad,AsistDireccion,ce";
//echo $MM_authorizedUsers;
require_once('../../../inc_login_ck.php'); 

require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 
require_once('../archivo/Variables.php'); 

require_once('../../../inc/notas.php'); 


$colname_RS_Curso = "0";
if (isset($_GET['CodigoCurso'])) {
  $colname_RS_Curso =  $_GET['CodigoCurso'] ;
}
//mysql_select_db($database_bd, $bd);
$query_RS_Curso = sprintf("SELECT * FROM Curso WHERE CodigoCurso = %s", $colname_RS_Curso);
$RS_Curso = $mysqli->query($query_RS_Curso); //
$row_RS_Curso = $RS_Curso->fetch_assoc();
$totalRows_RS_Curso = $RS_Curso->num_rows;


//$RS_Curso = mysql_query($query_RS_Curso, $bd) or die(mysql_error());
//$row_RS_Curso = mysql_fetch_assoc($RS_Curso);
//$totalRows_RS_Curso = mysql_num_rows($RS_Curso);



if (isset($_GET['AnoEscolar'])) {
  $AnoEscolar = $_GET['AnoEscolar'] ;
}


$CodigoCurso = "-1";
if (isset($_GET['CodigoCurso'])) {
  $CodigoCurso = $_GET['CodigoCurso'] ;
}


if($_GET['Lapso']=='Revision'){
	$query_RS_Alumnos = "SELECT * FROM Alumno, AlumnoXCurso 
						 WHERE Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno
						 AND AlumnoXCurso.Ano = '$AnoEscolar' 
						 AND AlumnoXCurso.Status = 'Inscrito' 
						 AND AlumnoXCurso.CodigoCurso = $CodigoCurso 
						 AND AlumnoXCurso.Tipo_Inscripcion = 'Rv'
						 ORDER BY Alumno.Cedula";}
elseif(strrpos(' '.$_GET['Lapso'] , "mp") > 0){
	$Planilla = 'MatPendienteM0'.substr($_GET['Lapso'],0,1);
	
	$query_RS_Alumnos = "SELECT * FROM Alumno, AlumnoXCurso 
						 WHERE Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno
						 AND AlumnoXCurso.Ano = '$AnoEscolar' 
						 AND AlumnoXCurso.Status = 'Inscrito' 
						 AND AlumnoXCurso.CodigoCurso = $CodigoCurso 
						 AND AlumnoXCurso.Planilla = '$Planilla'
						 ORDER BY Alumno.Cedula";}
else {
	$query_RS_Alumnos = "SELECT * FROM Alumno, AlumnoXCurso 
						 WHERE Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno
						 AND AlumnoXCurso.Ano = '$AnoEscolar' 
						 AND AlumnoXCurso.Status = 'Inscrito' 
						 AND AlumnoXCurso.CodigoCurso = $CodigoCurso 
						 AND AlumnoXCurso.Tipo_Inscripcion <> 'Mp'
						 ORDER BY Alumno.Apellidos, Alumno.Apellidos2, Alumno.Nombres, Alumno.Nombres2";}

if($_GET['Lapso']=='Equivalencia'){
	$query_RS_Alumnos = "SELECT * FROM Alumno, AlumnoXCurso 
						 WHERE Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno
						 AND AlumnoXCurso.Ano = '$AnoEscolar' 
						 AND AlumnoXCurso.Status = 'Inscrito' 
						 AND AlumnoXCurso.CodigoCurso = $CodigoCurso 
						 AND AlumnoXCurso.Tipo_Inscripcion = 'Eq'
						 ORDER BY Alumno.Cedula";}
	

$RS_Alumnos = $mysqli->query($query_RS_Alumnos); //
$totalRows_RS_Alumnos = $RS_Alumnos->num_rows;

//echo $query_RS_Alumnos;	
//$query_RS_Alumnos = $query_RS_Alumno;	
//$RS_Alumnos = mysql_query($query_RS_Alumnos, $bd) or die(mysql_error());
//$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
//$totalRows_RS_Alumnos = mysql_num_rows($RS_Alumnos);
//echo $query_RS_Alumnos;

$query_RS_Cursos = "SELECT * FROM Curso
					ORDER BY NivelMencion ASC, Curso.Curso, Curso.Seccion";
$RS_Cursos = $mysqli->query($query_RS_Cursos); //
$row_RS_Cursos = $RS_Cursos->fetch_assoc();
$totalRows_RS_Cursos = $RS_Cursos->num_rows;

/*
$RS_Cursos = mysql_query($query_RS_Cursos, $bd) or die(mysql_error());
$row_RS_Cursos = mysql_fetch_assoc($RS_Cursos);
$totalRows_RS_Cursos = mysql_num_rows($RS_Cursos);
*/
if((strrpos($_GET['Lapso'], "mp") != 0) or (strrpos($_GET['Lapso'], "MatP") != 0))
	{$CodigoMaterias = $row_RS_Curso['CodigoMateriasPendiente']; }
else 
	{$CodigoMaterias = $row_RS_Curso['CodigoMaterias']; }

$query_RS_Materias = "SELECT * FROM CursoMaterias WHERE CodigoMaterias = '".$CodigoMaterias."'"; //echo $query_RS_Materias;
$RS_Materias = $mysqli->query($query_RS_Materias); //
$row_RS_Materias = $RS_Materias->fetch_assoc();
$totalRows_RS_Materias = $RS_Materias->num_rows;

/*
$RS_Materias = mysql_query($query_RS_Materias, $bd) or die(mysql_error());
$row_RS_Materias = mysql_fetch_assoc($RS_Materias);
$totalRows_RS_Materias = mysql_num_rows($RS_Materias);
*/
function echoNota ($nota){
	if ($nota > '00'){ echo $nota; }
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title><?php echo $TituloPantalla ="Lista Notas"; ?></title>
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

<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />

<script src="../../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<body <?php 
$auxl=$_GET['Linea']+1;
echo 'OnLoad="document.form'. $auxl .'.n01.focus();"'; ?>>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><?php require_once('../TitAdmin.php'); ?>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">

<table width="100%" border="0" align="center" cellpadding="3"  >
  <tr class="NombreCampoBIG">
    <td colspan="5" align="left" valign="top"><?php 
   $actual = $_GET['CodigoCurso'];
   $extraOpcion = $_SERVER['PHP_SELF'] .'?AnoEscolar='.$AnoEscolar.'&Lapso='. $_GET['Lapso'].'&CodigoCurso=';
   Ir_a_Curso($actual,$extraOpcion); ?>
      </td>
    <td align="center" valign="middle" class="RTitulo">
      <?php if (substr( $_GET['Lapso'] , 0 , 1)=="1")   echo "1er Lapso";?>
      <?php if (substr( $_GET['Lapso'] , 0 , 1)=="2")   echo "2do Lapso";?>
      <?php if (substr( $_GET['Lapso'] , 0 , 1)=="3")   echo "3er Lapso";?>
      <?php if (substr( $_GET['Lapso'] , 2 , 2)=="30")   echo " 30%";?>
      <?php if (substr( $_GET['Lapso'] , 2 , 2)=="70")   echo " 70%";?>
      <?php if (substr( $_GET['Lapso'] , 2 , 2)=="De")   echo " Definitiva";?>
      <?php if ( $_GET['Lapso']>'')   echo " <br />";?>
      
      <select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)">
        <option value="<?php echo $_SERVER['../PHP_SELF'] ?>?CodigoCurso=<?php echo $_GET['CodigoCurso']."&AnoEscolar=".$AnoEscolar; ?>">Selecc..</option>
        <?php 
foreach($Lapsos as $Lapso){
	$Lapso = explode(';' , $Lapso);
	
	echo '<option value="'.$_SERVER['PHP_SELF'].'?CodigoCurso='.$_GET['CodigoCurso']."&AnoEscolar=".$AnoEscolar.'&Lapso='.$Lapso[0].'"';
	
	if($_GET['Lapso']==$Lapso[0]) echo ' selected="selected" ';
		echo '>'.$Lapso[1].'</option>
	';
}
?>
        </select> 
      <?php echo $AnoEscolar; ?></td>
  </tr>
  <tr class="NombreCampoBIG">
    <td colspan="5" valign="top"><a href="../Lista/Notas_Consejo_pdf.php?CodigoCurso=<?php echo $_GET['CodigoCurso']."&AnoEscolar=".$AnoEscolar; ?>" target="_blank">Lista Consejo</a> | <a href="PDF/Boleta.php?CodigoCurso=<?php echo $_GET['CodigoCurso']."&AnoEscolar=".$AnoEscolar; ?>" target="_blank">Boletas</a></td>
    <td valign="top" ><a href="../Sube_notas.php" target="_blank">Upload</a></td>
  </tr>
  <tr bgcolor="#FFFFFF" class="NombreCampo">
    <td width="10" class="NombreCampo">No</td>
    <td width="10" align="center" class="NombreCampo">C&oacute;d</td>
    <td width="10" colspan="2" align="center" class="NombreCampo">&nbsp;</td>
    <td width="300" class="NombreCampo"><strong>Apellidos, </strong>Nombres</td>
    <td valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="2" align="center" class="ReciboRenglon"><input name="n01" type="text" id="n01" value="<?php echo $row_RS_Materias['Ma01']; ?>" size="2" class="ReciboRenglonMini"/></td>
        <td width="2" align="center" class="ReciboRenglon"><input name="n02" type="text" id="n02" value="<?php echo $row_RS_Materias['Ma02']; ?>" size="2" class="ReciboRenglonMini"/></td>
        <td width="2" align="center" class="ReciboRenglon"><input name="n03" type="text" id="n03" value="<?php echo $row_RS_Materias['Ma03']; ?>" size="2" class="ReciboRenglonMini"/></td>
        <td width="2" align="center" class="ReciboRenglon"><input name="n04" type="text" id="n04" value="<?php echo $row_RS_Materias['Ma04']; ?>" size="2" class="ReciboRenglonMini"/></td>
        <td width="2" align="center" class="ReciboRenglon"><input name="n05" type="text" id="n05" value="<?php echo $row_RS_Materias['Ma05']; ?>" size="2" class="ReciboRenglonMini"/></td>
        <td width="2" align="center" class="ReciboRenglon"><input name="n06" type="text" id="n06" value="<?php echo $row_RS_Materias['Ma06']; ?>" size="2" class="ReciboRenglonMini"/></td>
        <td width="2" align="center" class="ReciboRenglon"><input name="n07" type="text" id="n07" value="<?php echo $row_RS_Materias['Ma07']; ?>" size="2" class="ReciboRenglonMini"/></td>
        <td width="2" align="center" class="ReciboRenglon"><input name="n08" type="text" id="n08" value="<?php echo $row_RS_Materias['Ma08']; ?>" size="2" class="ReciboRenglonMini"/></td>
        <td width="2" align="center" class="ReciboRenglon"><input name="n09" type="text" id="n09" value="<?php echo $row_RS_Materias['Ma09']; ?>" size="2" class="ReciboRenglonMini"/></td>
        <td width="2" align="center" class="ReciboRenglon"><input name="n10" type="text" id="n10" value="<?php echo $row_RS_Materias['Ma10']; ?>" size="2" class="ReciboRenglonMini"/></td>
        <td width="2" align="center" class="ReciboRenglon"><input name="n11" type="text" id="n11" value="<?php echo $row_RS_Materias['Ma11']; ?>" size="2" class="ReciboRenglonMini"/></td>
        <td width="2" align="center" class="ReciboRenglon"><input name="n12" type="text" id="n12" value="<?php echo $row_RS_Materias['Ma12']; ?>" size="2" class="ReciboRenglonMini"/></td>
        <td width="2" align="center" class="ReciboRenglon"><input name="n13" type="text" id="n13" value="<?php echo $row_RS_Materias['Ma13']; ?>" size="2" class="ReciboRenglonMini"/></td>
        <td width="2" align="center" class="ReciboRenglon"><input name="pro" type="text" id="n13" value="Pr" size="2" class="ReciboRenglonMini"/></td>
        <td width="2" align="center" class="ReciboRenglon"><?php 
		  $Lapso = substr($_GET['Lapso'] , 0 , 4);
		  if ($Lapso!='11-De'and $Lapso!='22-De'and $Lapso!='3-De' and $Lapso!='Def'){ ?>
          <input type="submit" name="G" id="G" value="G" /><?php } ?></td>
      </tr>
    </table></td>
  </tr><?php $Linea=0; 
   while ($row_RS_Alumnos = $RS_Alumnos->fetch_assoc()) { 
   //$i = $i+1;
   //$Linea = $Linea + 1;
   //if (  (isset($_GET['Linea']) and $i>=$_GET['Linea']-1)  or !isset($_GET['Linea'])) {
		 
/*
mysql_select_db($database_bd, $bd);
$query_RS_Nota_Al = "SELECT * FROM Nota 
						WHERE CodigoAlumno = ". $row_RS_Alumnos['CodigoAlumno']." 
						AND Lapso= '".$_GET['Lapso']."' 
						AND Ano_Escolar='$AnoEscolar'";
$RS_Nota_Al = mysql_query($query_RS_Nota_Al, $bd) or die(mysql_error());
$row_RS_Nota_Al = mysql_fetch_assoc($RS_Nota_Al);
$totalRows_RS_Nota_Al = mysql_num_rows($RS_Nota_Al);
//echo $query_RS_Nota_Al.'<br>';
*/
	//	 if($i==$_GET['Linea'])  $Verde = true; else $Verde = false; ?>
  <tr>
    <td align="right" nowrap="nowrap"  <?php ListaFondo($sw,$Verde); ?>><?php echo ++$i; ?><a name="<?php echo $Linea ?>" id="Linea"></a></td>
    <td align="center" nowrap="nowrap"  <?php ListaFondo($sw,$Verde); ?>><?php echo $row_RS_Alumnos['CodigoAlumno']; ?></td>
    <td align="center" nowrap="nowrap"  <?php ListaFondo($sw,$Verde); ?>><a href="PDF/Boleta.php?CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>&AnoEscolar=<?= $_GET['AnoEscolar'] ?>" target="_blank">Boleta</a></td>
    <td align="center" nowrap="nowrap"  <?php ListaFondo($sw,$Verde); ?>><a href="PDF/Boleta_Consejo.php?CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>" target="_blank">Ficha</a></td>
    <td nowrap="nowrap"  <?php ListaFondo($sw,$Verde); ?>><span class="ListadoNotas"><b><?php Titulo( $row_RS_Alumnos['Apellidos']. " " .$row_RS_Alumnos['Apellidos2']); ?>,</b> <em><?php Titulo( $row_RS_Alumnos['Nombres']. " " .$row_RS_Alumnos['Nombres2']) ?></em></span></td>
    <td valign="middle" nowrap="nowrap"  <?php $sw = ListaFondo($sw,$Verde); ?>><iframe src="iFr/NotaAlumno.php?<?php echo "CodigoAlumno=".$row_RS_Alumnos['CodigoAlumno']."&CodigoCurso=$CodigoCurso&Lapso=".$_GET['Lapso']."&AnoEscolar=$AnoEscolar"; ?>" width="600
" height="27" frameborder="0" scrolling="no" ></iframe></td>
  </tr>
<?php }  ?>
 
</table></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
</table>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>