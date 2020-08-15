<?php
$MM_authorizedUsers = "99,91,95,secreAcad";
require_once('../../../inc_login_ck.php'); 

require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 
require_once('../archivo/Variables.php'); 

require_once('../../../inc/notas.php'); 


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"]))) {
  $insertSQL = sprintf("INSERT INTO Nota (CodigoAlumno, CodigoCurso, Ano_Escolar, Lapso, n01, n02, n03, n04, n05, n06, n07, n08, n09, n10, n11, n12, n13) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['CodigoAlumno'], "int"),
                       GetSQLValueString($_POST['CodigoCurso'], "int"),
                       GetSQLValueString($_POST['Ano_Escolar'], "text"),
                       GetSQLValueString($_POST['Lapso'], "text"),
                       GetSQLValueString($_POST['n01'], "text"),
                       GetSQLValueString($_POST['n02'], "text"),
                       GetSQLValueString($_POST['n03'], "text"),
                       GetSQLValueString($_POST['n04'], "text"),
                       GetSQLValueString($_POST['n05'], "text"),
                       GetSQLValueString($_POST['n06'], "text"),
                       GetSQLValueString($_POST['n07'], "text"),
                       GetSQLValueString($_POST['n08'], "text"),
                       GetSQLValueString($_POST['n09'], "text"),
                       GetSQLValueString($_POST['n10'], "text"),
                       GetSQLValueString($_POST['n11'], "text"),
                       GetSQLValueString($_POST['n12'], "text"),
                       GetSQLValueString($_POST['n13'], "text"));

  mysql_select_db($database_bd, $bd);
  $Result1 = mysql_query($insertSQL, $bd) or die(mysql_error());
  CalcDefinitivaLapso($_POST['CodigoAlumno'], substr($_POST['Lapso'],0,1) , $_POST['CodigoCurso'], $AnoEscolar, $database_bd, $bd);
}

if ((isset($_POST["MM_update"]))) {
  $updateSQL = sprintf("UPDATE Nota SET CodigoAlumno=%s, CodigoCurso=%s, Ano_Escolar=%s, Lapso=%s, n01=%s, n02=%s, n03=%s, n04=%s, n05=%s, n06=%s, n07=%s, n08=%s, n09=%s, n10=%s, n11=%s, n12=%s, n13=%s WHERE Codigo=%s",
                       GetSQLValueString($_POST['CodigoAlumno'], "int"),
                       GetSQLValueString($_POST['CodigoCurso'], "int"),
                       GetSQLValueString($_POST['Ano_Escolar'], "text"),
                       GetSQLValueString($_POST['Lapso'], "text"),
                       GetSQLValueString($_POST['n01'], "text"),
                       GetSQLValueString($_POST['n02'], "text"),
                       GetSQLValueString($_POST['n03'], "text"),
                       GetSQLValueString($_POST['n04'], "text"),
                       GetSQLValueString($_POST['n05'], "text"),
                       GetSQLValueString($_POST['n06'], "text"),
                       GetSQLValueString($_POST['n07'], "text"),
                       GetSQLValueString($_POST['n08'], "text"),
                       GetSQLValueString($_POST['n09'], "text"),
                       GetSQLValueString($_POST['n10'], "text"),
                       GetSQLValueString($_POST['n11'], "text"),
                       GetSQLValueString($_POST['n12'], "text"),
                       GetSQLValueString($_POST['n13'], "text"),
                       GetSQLValueString($_POST['Codigo'], "int"));

  mysql_select_db($database_bd, $bd);
  $Result1 = mysql_query($updateSQL, $bd) or die(mysql_error());
  //echo $updateSQL;
  CalcDefinitivaLapso($_POST['CodigoAlumno'], substr($_POST['Lapso'],0,1) , $_POST['CodigoCurso'], $AnoEscolar, $database_bd, $bd);
}

$colname_RS_Curso = "0";
if (isset($_GET['CodigoCurso'])) {
  $colname_RS_Curso = (get_magic_quotes_gpc()) ? $_GET['CodigoCurso'] : addslashes($_GET['CodigoCurso']);
}
mysql_select_db($database_bd, $bd);
$query_RS_Curso = sprintf("SELECT * FROM Curso WHERE CodigoCurso = %s", $colname_RS_Curso);
$RS_Curso = mysql_query($query_RS_Curso, $bd) or die(mysql_error());
$row_RS_Curso = mysql_fetch_assoc($RS_Curso);
$totalRows_RS_Curso = mysql_num_rows($RS_Curso);



if (isset($_GET['AnoEscolar'])) {
  $AnoEscolar = (get_magic_quotes_gpc()) ? $_GET['AnoEscolar'] : addslashes($_GET['AnoEscolar']);
}


$CodigoCurso = "-1";
if (isset($_GET['CodigoCurso'])) {
  $CodigoCurso = (get_magic_quotes_gpc()) ? $_GET['CodigoCurso'] : addslashes($_GET['CodigoCurso']);
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
						 AND AlumnoXCurso.Tipo_Inscripcion = 'Rg'
						 ORDER BY Alumno.Apellidos, Alumno.Apellidos2, Alumno.Nombres, Alumno.Nombres2";}

if($_GET['Lapso']=='Equivalencia'){
	$query_RS_Alumnos = "SELECT * FROM Alumno, AlumnoXCurso 
						 WHERE Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno
						 AND AlumnoXCurso.Ano = '$AnoEscolar' 
						 AND AlumnoXCurso.Status = 'Inscrito' 
						 AND AlumnoXCurso.CodigoCurso = $CodigoCurso 
						 AND AlumnoXCurso.Tipo_Inscripcion = 'Eq'
						 ORDER BY Alumno.Cedula";}
	
//echo $query_RS_Alumnos;	
//$query_RS_Alumnos = $query_RS_Alumno;	
$RS_Alumnos = mysql_query($query_RS_Alumnos, $bd) or die(mysql_error());
$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
$totalRows_RS_Alumnos = mysql_num_rows($RS_Alumnos);
//echo $query_RS_Alumnos;

$query_RS_Cursos = "SELECT * FROM Curso
					ORDER BY NivelMencion ASC, Curso.Curso, Curso.Seccion";
$RS_Cursos = mysql_query($query_RS_Cursos, $bd) or die(mysql_error());
$row_RS_Cursos = mysql_fetch_assoc($RS_Cursos);
$totalRows_RS_Cursos = mysql_num_rows($RS_Cursos);

if((strrpos($_GET['Lapso'], "mp") != 0) or (strrpos($_GET['Lapso'], "MatP") != 0))
	{$CodigoMaterias = $row_RS_Curso['CodigoMateriasPendiente']; }
else 
	{$CodigoMaterias = $row_RS_Curso['CodigoMaterias']; }

$query_RS_Materias = "SELECT * FROM CursoMaterias WHERE CodigoMaterias = '".$CodigoMaterias."'"; //echo $query_RS_Materias;
$RS_Materias = mysql_query($query_RS_Materias, $bd) or die(mysql_error());
$row_RS_Materias = mysql_fetch_assoc($RS_Materias);
$totalRows_RS_Materias = mysql_num_rows($RS_Materias);

function echoNota ($nota){
	if ($nota > '00'){ echo $nota; }
}

?><?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,admin";
require_once('../../../inc_login_ck.php'); 

require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 
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

<table width="950" border="0" align="center" cellpadding="3"  >
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
';}
?>
        </select></td>
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
    <td valign="bottom"><table width="530" border="0" cellspacing="0" cellpadding="0">
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
   do { 
   $i = $i+1;
   $Linea = $Linea + 1;
   if (  (isset($_GET['Linea']) and $i>=$_GET['Linea']-1)  or !isset($_GET['Linea'])) {
		 if ($totalRows_RS_Alumnos > 0) { // Show if recordset not empty 
		 

mysql_select_db($database_bd, $bd);
$query_RS_Nota_Al = "SELECT * FROM Nota WHERE CodigoAlumno = ". $row_RS_Alumnos['CodigoAlumno']." AND Lapso= '".$_GET['Lapso']."' AND Ano_Escolar='$AnoEscolar'";
$RS_Nota_Al = mysql_query($query_RS_Nota_Al, $bd) or die(mysql_error());
$row_RS_Nota_Al = mysql_fetch_assoc($RS_Nota_Al);
$totalRows_RS_Nota_Al = mysql_num_rows($RS_Nota_Al);
//echo $query_RS_Nota_Al.'<br>';
		 if($i==$_GET['Linea'])  $Verde = true; else $Verde = false; ?>
  <tr>
    <td align="right" nowrap="nowrap"  <?php ListaFondo($sw,$Verde); ?>><?php echo $i; ?><a name="<?php echo $Linea ?>" id="Linea"></a></td>
    <td align="center" nowrap="nowrap"  <?php ListaFondo($sw,$Verde); ?>><?php echo $row_RS_Alumnos['CodigoAlumno']; ?></td>
    <td align="center" nowrap="nowrap"  <?php ListaFondo($sw,$Verde); ?>><a href="PDF/Boleta.php?CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>" target="_blank">Boleta</a></td>
    <td align="center" nowrap="nowrap"  <?php ListaFondo($sw,$Verde); ?>><a href="PDF/Boleta_Consejo.php?CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>" target="_blank">Ficha</a></td>
    <td nowrap="nowrap"  <?php ListaFondo($sw,$Verde); ?>><span class="ListadoNotas"><b><?php Titulo( $row_RS_Alumnos['Apellidos']. " " .$row_RS_Alumnos['Apellidos2']); ?>,</b> <em><?php Titulo( $row_RS_Alumnos['Nombres']. " " .$row_RS_Alumnos['Nombres2']) ?></em></span></td>
    <td valign="middle" nowrap="nowrap"  <?php $sw = ListaFondo($sw,$Verde); ?>><?php 
	
	if(  true or  strrpos($_GET['Lapso'], "mp") == 0 or
	     ( $row_RS_Alumnos['Tipo_Inscripcion'] == "Mp" and strrpos($_GET['Lapso'], "mp") > 0)){

	
	?>
    <form id="form<?php echo $i+1; ?>" name="form<?php echo $i+1; ?>" method="POST" action="<?php echo $editFormAction; 
	
	$Linea_aux = $Linea+1;
	
	echo "?CodigoCurso=".$_GET['CodigoCurso']."&Lapso=".$_GET['Lapso']."&AnoEscolar=".$AnoEscolar; 
	if( strrpos($_GET['Lapso'], "mp") == 0 ){
	echo "&Linea=".$Linea_aux ; 
	}
	echo "#";//.$Linea_aux
	?>"><?php if ($_GET['Lapso']>" ") { 
	
	if ($_GET['Lapso']=="Revision"){
		$Materias_Cursa = explode(';',$row_RS_Alumnos['Materias_Cursa']);
		for ($i = 1; $i <= 13; $i++) 
			if( strpos(' '.$row_RS_Alumnos['Materias_Cursa'] , ';'.$i.';') > 0 )
				$_Desac[$i] = ' class="FondoCampoVerde"   ';
			else 
				$_Desac[$i] = ' class="ReciboRenglonMini" disabled="true" ';
		$_clave=0;
	}
	?>
    <input name="Codigo" type="hidden" value="<?php echo $row_RS_Nota_Al['Codigo']; ?>" />
    <input name="CodigoAlumno" type="hidden" value="<?php echo $row_RS_Alumnos['CodigoAlumno']; ?>" />
    <input name="CodigoCurso" type="hidden" value="<?php echo $_GET['CodigoCurso']; ?>" />
    <input name="Ano_Escolar" type="hidden" value="<?php echo $AnoEscolar; ?>" />
    <input name="Lapso" type="hidden" value="<?php echo $_GET['Lapso']; ?>" />
      <table width="530" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="2" align="center" class="ReciboRenglon">
            <input name="n01" type="text" id="n01" value="<?php $n01 = $row_RS_Nota_Al['n01']; echoNota($n01); ?>" size="2"  <?php echo $_Desac[++$_clave] ?> onfocus="n01.value()=1;" /></td>
          <td width="2" align="center" class="ReciboRenglon">
            <input name="n02" type="text" id="n02" value="<?php $n02 = $row_RS_Nota_Al['n02']; echoNota($n02); ?>" size="2" <?php echo $_Desac[++$_clave] ?>/></td>
          <td width="2" align="center" class="ReciboRenglon">
            <input name="n03" type="text" id="n03" value="<?php $n03 = $row_RS_Nota_Al['n03']; echoNota($n03); ?>" size="2"  <?php echo $_Desac[++$_clave] ?>/></td>
          <td width="2" align="center" class="ReciboRenglon">
            <input name="n04" type="text" id="n04" value="<?php $n04 = $row_RS_Nota_Al['n04']; echoNota($n04); ?>" size="2"  <?php echo $_Desac[++$_clave] ?>/></td>
          <td width="2" align="center" class="ReciboRenglon">
            <input name="n05" type="text" id="n05" value="<?php $n05 = $row_RS_Nota_Al['n05']; echoNota($n05); ?>" size="2"  <?php echo $_Desac[++$_clave] ?>/></td>
          <td width="2" align="center" class="ReciboRenglon">
            <input name="n06" type="text" id="n06" value="<?php $n06 = $row_RS_Nota_Al['n06']; echoNota($n06); ?>" size="2"  <?php echo $_Desac[++$_clave] ?>/></td>
          <td width="2" align="center" class="ReciboRenglon">
            <input name="n07" type="text" id="n07" value="<?php $n07 = $row_RS_Nota_Al['n07']; echoNota($n07); ?>" size="2"  <?php echo $_Desac[++$_clave] ?>/></td>
          <td width="2" align="center" class="ReciboRenglon">
            <input name="n08" type="text" id="n08" value="<?php $n08 = $row_RS_Nota_Al['n08']; echoNota($n08); ?>" size="2"  <?php echo $_Desac[++$_clave] ?>/></td>
          <td width="2" align="center" class="ReciboRenglon">
            <input name="n09" type="text" id="n09" value="<?php $n09 = $row_RS_Nota_Al['n09']; echoNota($n09); ?>" size="2"  <?php echo $_Desac[++$_clave] ?>/></td>
          <td width="2" align="center" class="ReciboRenglon">
            <input name="n10" type="text" id="n10" value="<?php $n10 = $row_RS_Nota_Al['n10']; echoNota($n10); ?>" size="2"  <?php echo $_Desac[++$_clave] ?>/></td>
          <td width="2" align="center" class="ReciboRenglon">
            <input name="n11" type="text" id="n11" value="<?php $n11 = $row_RS_Nota_Al['n11']; echoNota($n11); ?>" size="2"  <?php echo $_Desac[++$_clave] ?>/></td>
          <td width="2" align="center" class="ReciboRenglon">
            <input name="n12" type="text" id="n12" value="<?php $n12 = $row_RS_Nota_Al['n12']; echoNota($n12); ?>" size="2"  <?php echo $_Desac[++$_clave] ?>/></td>
          <td width="2" align="center" class="ReciboRenglon">
            <input name="n13" type="text" id="n13" value="<?php $n13 = $row_RS_Nota_Al['n13']; echoNota($n13); ?>" size="2"  <?php echo $_Desac[++$_clave] ?>/></td>
          <td width="2" align="center" class="ReciboRenglon"><?php  
		  unset( $_Desac );
		  
		    $Pr = ($n01+$n02+$n03+$n04+$n05+$n06+$n07+$n08+$n09+$n10+$n11+$n12+$n13);
		   if( $Pr != 0 ){ 
		   $Cuenta = ($n01>0?1:0)+($n02>0?1:0)+($n03>0?1:0)+($n04>0?1:0)+($n05>0?1:0)+($n06>0?1:0)+($n07>0?1:0)+($n08>0?1:0)+($n09>0?1:0)+($n10>0?1:0);
		   $Cuenta += ($n11>0?1:0)+($n12>0?1:0)+($n13>0?1:0);
		   //echo $Pr/$Cuenta;
		   $Pr = round($Pr/$Cuenta,0);
		   }
		   ?>
           <input name="pro" type="text" id="n13" value="<?php echo $Pr; ?>" size="2" class="ReciboRenglonMini" disabled="disabled"/></td>
          <td width="2" align="center" class="ReciboRenglon"><?php 
		  $Lapso = substr($_GET['Lapso'] , 0 , 4); //echo $row_RS_Curso['NivelMencion'];
		  if (($Lapso!='1-De'and $Lapso!='2-De'and $Lapso!='3-De' and $Lapso!='Def') or $row_RS_Curso['NivelMencion']==2 ){ ?><input type="submit" name="G" id="G" value="G" /><?php } ?></td>
        </tr>
        <?php if(strrpos(' '.$_GET['Lapso'] , "1mp") > 0){ ?>
        <tr><td colspan="12"><?php 
	 echo $row_RS_Alumnos['Materias_Cursa'];
	?></td>
        </tr>
        <?php } ?>
      </table>
      <?php if ($totalRows_RS_Nota_Al==0) { ?><input type="hidden" name="MM_insert" value="form1" /><?php } else { ?><input type="hidden" name="MM_update" value="form1" /><?php } ?>
	  <?php } else { ?>Seleccione Lapso <?php } ?></form><?php } ?></td>
  </tr>
        <?php } // Show if recordset not empty ?>
<?php
}

if(true){
?><tr><td colspan="6"><iframe src="iFr/NotaAlumno.php?<?php echo "CodigoAlumno=".$row_RS_Alumnos['CodigoAlumno']."&Lapso=$Lapso&AnoEscolar=$AnoEscolar"; ?>" width="800" height="30" frameborder="0" ></iframe></td></tr><?php 
}
 } while ($row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos)); ?>
 
</table></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
</table>
</body>
</html><?php
mysql_free_result($RS_Materias);

?>
