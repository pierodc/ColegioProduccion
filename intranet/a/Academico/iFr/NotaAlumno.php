<?php 
$MM_authorizedUsers = "99,91,95,secreAcad,AsistDireccion,ce";
require_once('../../../../inc_login_ck.php'); 

require_once('../../../../Connections/bd.php'); 
require_once('../../../../inc/rutinas.php'); 
require_once('../../archivo/Variables.php'); 

require_once('../../../../inc/notas.php'); 

if (isset($_GET['AnoEscolar'])) {
  $AnoEscolar = $_GET['AnoEscolar'] ;
}


function echoNota ($nota){
	if ($nota > '00'){ echo $nota; }
}

$editFormAction = $php_self."?CodigoAlumno=".$_GET['CodigoAlumno']."&CodigoCurso=".$_GET['CodigoCurso']."&Lapso=".$_GET['Lapso']."&AnoEscolar=".$_GET['AnoEscolar']."&Guardado=1";

if(isset($_POST['MM_update']) or isset($_POST['MM_insert'])){
	
			
			if ((isset($_POST["MM_insert"]))) {
		  $insertSQL = sprintf("INSERT INTO Nota 
		  (CodigoAlumno, CodigoCurso, Ano_Escolar, Lapso, n01, n02, n03, n04, n05, n06, n07, n08, n09, n10, n11, n12, n13) 
		  VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
							   GetSQLValueString($_POST['CodigoAlumno'], "int"),
							   GetSQLValueString($_POST['CodigoCurso'], "int"),
							   GetSQLValueString($AnoEscolar, "text"),
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
		
		  //mysql_select_db($database_bd, $bd);
		  $Result1 = $mysqli->query($insertSQL); //mysql_query($insertSQL, $bd) or die(mysql_error());
		  
		  CalcDefinitivaLapso($_POST['CodigoAlumno'], substr($_POST['Lapso'],0,1) , $_POST['CodigoCurso'], $AnoEscolar, $database_bd, $bd);
		}
		
		if ((isset($_POST["MM_update"]))) {
		  $updateSQL = sprintf("UPDATE Nota SET CodigoAlumno=%s, CodigoCurso=%s, Ano_Escolar=%s, Lapso=%s, n01=%s, n02=%s, n03=%s, n04=%s, n05=%s, n06=%s, n07=%s, n08=%s, n09=%s, n10=%s, n11=%s, n12=%s, n13=%s WHERE Codigo=%s",
							   GetSQLValueString($_POST['CodigoAlumno'], "int"),
							   GetSQLValueString($_POST['CodigoCurso'], "int"),
							   GetSQLValueString($AnoEscolar, "text"),
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
		
		  //mysql_select_db($database_bd, $bd);
		  $Result1 = $mysqli->query($updateSQL); //mysql_query($updateSQL, $bd) or die(mysql_error());
		  //echo $updateSQL;
		  CalcDefinitivaLapso($_POST['CodigoAlumno'], substr($_POST['Lapso'],0,1) , $_POST['CodigoCurso'], $AnoEscolar, $database_bd, $bd);
		}
	
	
	header("Location: ".$editFormAction);
	}

//echo 'query_RS_Alumnos '.$query_RS_Alumno.'<br>';
$RS_Alumnos = $mysqli->query($query_RS_Alumno); //
$row_RS_Alumnos = $RS_Alumnos->fetch_assoc();
$totalRows_RS_Alumnos = $RS_Alumnos->num_rows;
/*
$RS_Alumnos = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
$totalRows_RS_Alumnos = mysql_num_rows($RS_Alumnos);
*/
$CodigoAlumno = $row_RS_Alumnos['CodigoAlumno'];

$query_RS_Curso = sprintf("SELECT * FROM Curso WHERE CodigoCurso = %s", $_GET['CodigoCurso']);
$RS_Curso = $mysqli->query($query_RS_Curso); //
$row_RS_Curso = $RS_Curso->fetch_assoc();

/*
$RS_Curso = mysql_query($query_RS_Curso, $bd) or die(mysql_error());
$row_RS_Curso = mysql_fetch_assoc($RS_Curso);
*/
if((strrpos($_GET['Lapso'], "mp") != 0) or (strrpos($_GET['Lapso'], "MatP") != 0))
	{$CodigoMaterias = $row_RS_Curso['CodigoMateriasPendiente']; }
else 
	{$CodigoMaterias = $row_RS_Curso['CodigoMaterias']; }

$query_RS_Materias = "SELECT * FROM CursoMaterias WHERE CodigoMaterias = '".$CodigoMaterias."'";
//echo $query_RS_Materias;
$RS_Materias = $mysqli->query($query_RS_Materias); //
$row_RS_Materias = $RS_Materias->fetch_assoc();

/*
$RS_Materias = mysql_query($query_RS_Materias, $bd) or die(mysql_error());
$row_RS_Materias = mysql_fetch_assoc($RS_Materias);
*/


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
<link href="../../../../estilos2.css" rel="stylesheet" type="text/css" />
	
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php 

$i = $i+1;
$Linea = $Linea + 1;
		 

$query_RS_Nota_Al = "SELECT * FROM Nota WHERE CodigoAlumno = '". $CodigoAlumno."' AND Lapso= '".$_GET['Lapso']."' AND Ano_Escolar='$AnoEscolar'";
$RS_Nota_Al = $mysqli->query($query_RS_Nota_Al); //
$row_RS_Nota_Al = $RS_Nota_Al->fetch_assoc();
$totalRows_RS_Nota_Al = $RS_Nota_Al->num_rows;
	
	/*
$RS_Nota_Al = mysql_query($query_RS_Nota_Al, $bd) or die(mysql_error());
$row_RS_Nota_Al = mysql_fetch_assoc($RS_Nota_Al);
$totalRows_RS_Nota_Al = mysql_num_rows($RS_Nota_Al);
*/
		 if($i==$_GET['Linea'])  $Verde = true; else $Verde = false; ?>
<?php 
	
	if(  true or  strrpos($_GET['Lapso'], "mp") == 0 or
	     ( $row_RS_Alumnos['Tipo_Inscripcion'] == "Mp" and strrpos($_GET['Lapso'], "mp") > 0)){

	
	?>
    <form id="form<?php echo $i+1; ?>" name="form" method="POST" action="<?php echo $editFormAction; ?>"><?php if ($_GET['Lapso']>" ") { 
	
	if ($_GET['Lapso']=="Revision"){
		$Materias_Cursa = explode(';',$row_RS_Alumnos['Materias_Cursa']);
		for ($i = 1; $i <= 13; $i++) 
			if( strpos(' '.$row_RS_Alumnos['Materias_Cursa'] , ';'.$i.';') > 0 )
				$_Desac[$i] = ' class="FondoCampoVerde"   ';
			else 
				$_Desac[$i] = ' class="ReciboRenglonMini" ';// disabled="true"
		$_clave=0;
	}
$ClassImput = ' "class="ReciboRenglonMini"';	
	?>
    <input name="Codigo" type="hidden" value="<?php echo $row_RS_Nota_Al['Codigo']; ?>" />
    <input name="CodigoAlumno" type="hidden" value="<?php echo $CodigoAlumno; ?>" />
    <input name="CodigoCurso" type="hidden" value="<?php echo $_GET['CodigoCurso']; ?>" />
    <input name="AnoEscolar" type="hidden" value="<?php echo $AnoEscolar; ?>" />
    <input name="Lapso" type="hidden" value="<?php echo $_GET['Lapso']; ?>" />
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr <?php if(isset($_GET['Guardado'])) echo 'bgcolor="#FFFFCC"'; ?>>
          <td width="2" align="center" class="ReciboRenglonMini">
            <input name="n01" type="text" id="n01" value="<?php $n01 = $row_RS_Nota_Al['n01']; echoNota($n01); ?>" size="2"  <?php echo $_Desac[++$_clave]; echo ' title="'.$row_RS_Materias['Materia01'].'"' . $ClassImput ?> /></td>
          <td width="2" align="center" class="ReciboRenglon">
            <input name="n02" type="text" id="n02" value="<?php $n02 = $row_RS_Nota_Al['n02']; echoNota($n02); ?>" size="2" <?php echo $_Desac[++$_clave]; echo ' title="'.$row_RS_Materias['Materia02'].'"' . $ClassImput ?> title="Nota02"/></td>
          <td width="2" align="center" class="ReciboRenglon">
            <input name="n03" type="text" id="n03" value="<?php $n03 = $row_RS_Nota_Al['n03']; echoNota($n03); ?>" size="2"  <?php echo $_Desac[++$_clave]; echo ' title="'.$row_RS_Materias['Materia03'].'"' . $ClassImput ?>/></td>
          <td width="2" align="center" class="ReciboRenglon">
            <input name="n04" type="text" id="n04" value="<?php $n04 = $row_RS_Nota_Al['n04']; echoNota($n04); ?>" size="2"  <?php echo $_Desac[++$_clave]; echo ' title="'.$row_RS_Materias['Materia04'].'"' . $ClassImput ?>/></td>
          <td width="2" align="center" class="ReciboRenglon">
            <input name="n05" type="text" id="n05" value="<?php $n05 = $row_RS_Nota_Al['n05']; echoNota($n05); ?>" size="2"  <?php echo $_Desac[++$_clave]; echo ' title="'.$row_RS_Materias['Materia05'].'"' . $ClassImput ?>/></td>
          <td width="2" align="center" class="ReciboRenglon">
            <input name="n06" type="text" id="n06" value="<?php $n06 = $row_RS_Nota_Al['n06']; echoNota($n06); ?>" size="2"  <?php echo $_Desac[++$_clave]; echo ' title="'.$row_RS_Materias['Materia06'].'"' . $ClassImput ?>/></td>
          <td width="2" align="center" class="ReciboRenglon">
            <input name="n07" type="text" id="n07" value="<?php $n07 = $row_RS_Nota_Al['n07']; echoNota($n07); ?>" size="2"  <?php echo $_Desac[++$_clave]; echo ' title="'.$row_RS_Materias['Materia07'].'"' . $ClassImput ?>/></td>
          <td width="2" align="center" class="ReciboRenglon">
            <input name="n08" type="text" id="n08" value="<?php $n08 = $row_RS_Nota_Al['n08']; echoNota($n08); ?>" size="2"  <?php echo $_Desac[++$_clave]; echo ' title="'.$row_RS_Materias['Materia08'].'"' . $ClassImput ?>/></td>
          <td width="2" align="center" class="ReciboRenglon">
            <input name="n09" type="text" id="n09" value="<?php $n09 = $row_RS_Nota_Al['n09']; echoNota($n09); ?>" size="2"  <?php echo $_Desac[++$_clave]; echo ' title="'.$row_RS_Materias['Materia09'].'"' . $ClassImput ?>/></td>
          <td width="2" align="center" class="ReciboRenglon">
            <input name="n10" type="text" id="n10" value="<?php $n10 = $row_RS_Nota_Al['n10']; echoNota($n10); ?>" size="2"  <?php echo $_Desac[++$_clave]; echo ' title="'.$row_RS_Materias['Materia10'].'"' . $ClassImput ?>/></td>
          <td width="2" align="center" class="ReciboRenglon">
            <input name="n11" type="text" id="n11" value="<?php $n11 = $row_RS_Nota_Al['n11']; echoNota($n11); ?>" size="2"  <?php echo $_Desac[++$_clave]; echo ' title="'.$row_RS_Materias['Materia11'].'"' . $ClassImput ?>/></td>
          <td width="2" align="center" class="ReciboRenglon">
            <input name="n12" type="text" id="n12" value="<?php $n12 = $row_RS_Nota_Al['n12']; echoNota($n12); ?>" size="2"  <?php echo $_Desac[++$_clave]; echo ' title="'.$row_RS_Materias['Materia12'].'"' . $ClassImput ?>/></td>
          <td width="2" align="center" class="ReciboRenglon">
            <input name="n13" type="text" id="n13" value="<?php $n13 = $row_RS_Nota_Al['n13']; echoNota($n13); ?>" size="2"  <?php echo $_Desac[++$_clave]; echo ' title="'.$row_RS_Materias['Materia13'].'"' . $ClassImput ?>/></td>
          <td width="2" align="center" class="ReciboRenglon"><?php  
		  unset( $_Desac );
		  
		    $Pr = ((int)$n01+(int)$n02+(int)$n03+(int)$n04+(int)$n05+(int)$n06+(int)$n07+(int)$n08+(int)$n09+(int)$n10+(int)$n11+(int)$n12+(int)$n13);
		   if( $Pr != 0 ){ 
		   $Cuenta = ($n01>0?1:0)+($n02>0?1:0)+($n03>0?1:0)+($n04>0?1:0)+($n05>0?1:0)+($n06>0?1:0)+($n07>0?1:0)+($n08>0?1:0)+($n09>0?1:0)+($n10>0?1:0);
		   $Cuenta += ($n11>0?1:0)+($n12>0?1:0)+($n13>0?1:0);
		   //echo $Pr/$Cuenta;
		   $Pr = round($Pr/$Cuenta,0);
		   }
		   ?>
           <input name="pro" type="text" id="n13" value="<?php echo $Pr; ?>" size="2" class="ReciboRenglonMini" disabled="disabled"/></td>
          <td width="2" align="center" <?php if(isset($_GET['Guardado'])) echo 'bgcolor="#00FF00"'; ?>  class="ReciboRenglon"><?php 
		  $_GET['Lapso'] = substr($_GET['Lapso'] , 0 , 4); //echo $row_RS_Curso['NivelMencion'];
		  if (($_GET['Lapso']!='1-De'and $_GET['Lapso']!='2-De'and $_GET['Lapso']!='3-De' and $_GET['Lapso']!='Def') or $row_RS_Curso['NivelMencion']==2 ){ ?><input type="submit" name="G" id="G" value="G"  onclick="this.disabled=true;this.value='..';this.form.submit();" /><?php } ?></td>
        </tr>
        <?php if(strrpos(' '.$_GET['Lapso'] , "1mp") > 0){ ?>
        <tr><td colspan="12"><?php 
	 echo $row_RS_Alumnos['Materias_Cursa'];
	?></td>
        </tr>
        <?php } ?>
      </table>
      <?php if ($totalRows_RS_Nota_Al==0) { ?><input type="hidden" name="MM_insert" value="form1" /><?php } else { ?><input type="hidden" name="MM_update" value="form1" /><?php } ?>
<?php } else { ?>Seleccione Lapso <?php } ?></form><?php } ?>
</body>
</html>