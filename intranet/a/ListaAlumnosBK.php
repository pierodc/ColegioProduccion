<?php
$MM_authorizedUsers = "99,91,95,90,secreAcad,secre,AsistDireccion";
require_once('../../inc_login_ck.php'); 
require_once('archivo/Variables.php'); 
require_once('../../Connections/bd.php'); 
require_once('../../inc/rutinas.php'); 



// Cambia CURSO 

if ($_POST['CambiarCurso']==1) {
	mysql_select_db($database_bd, $bd);
	$query = "UPDATE Alumno set CodigoCursoProxAno = '".$_POST['CodigoCurso']."' WHERE CodigoAlumno = '".$_POST['CodigoAlumno']."'";
	$rs = mysql_query($query, $bd) or die(mysql_error()); }

// fin Cambia CURSO



// Cambia Inscripcion_Condicional 

if ($_GET['Inscripcion_Condicional']==1) {

mysql_select_db($database_bd, $bd);

$query = "UPDATE Alumno set SWInsCondicional = '1' WHERE CodigoAlumno = '".$_GET['CodigoAlumno']."'";

$rs = mysql_query($query, $bd) or die(mysql_error()); }

// fin Cambia Inscripcion_Condicional

// Cambia Inscripcion_Condicional 

if ($_GET['Inscripcion_Condicional']==2) {

mysql_select_db($database_bd, $bd);

$query = "UPDATE Alumno set SWInsCondicional = '0' WHERE CodigoAlumno = '".$_GET['CodigoAlumno']."'";

$rs = mysql_query($query, $bd) or die(mysql_error()); }

// fin Cambia Inscripcion_Condicional



// Cambia PreInscribir 

if ($_GET['PreInscribir']==1) {

mysql_select_db($database_bd, $bd);

$query = "UPDATE Alumno set SW_pre_inscrito = '1' WHERE CodigoAlumno = '".$_GET['CodigoAlumno']."'";

$rs = mysql_query($query, $bd) or die(mysql_error()); }

// fin Cambia PreInscribir









$editFormAction = $_SERVER['PHP_SELF'];

if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);

}



if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "aceptar")) {

  $updateSQL = sprintf("UPDATE Alumno SET ObsvInsc=%s WHERE CodigoAlumno=%s",

                       GetSQLValueString($_POST['ObsvInsc'], "text"),

                       GetSQLValueString($_POST['CodigoAlumno'], "int"));



  mysql_select_db($database_bd, $bd);

  $Result1 = mysql_query($updateSQL, $bd) or die(mysql_error());



  $updateGoTo = "ListaAlumnos.php?CodigoClave=".$_GET['CodigoClave'];

  if (1==2) {

    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";

    $updateGoTo .= $_SERVER['QUERY_STRING'];

  }

  header(sprintf("Location: %s", $updateGoTo));

}



// Cambia Observaciones Caja

if ( isset($_GET['ObservacionesCaja'])) {

mysql_select_db($database_bd, $bd);

$query = "UPDATE Alumno set ObservacionesCaja = '".$_GET['ObservacionesCaja']."' WHERE CodigoAlumno = '".$_GET['CodigoAlumno']."'";

$rs = mysql_query($query, $bd) or die(mysql_error()); }

// fin Observaciones Caja



// Cambia Status a alumno = Aceptado

if ( isset($_POST['Aceptar']) and $_POST['Aceptar']=='1') {

$query = "UPDATE AlumnoXCurso SET Status = 'Aceptado' ,

				CodigoCurso = '".$_POST['CodigoCurso']."',

				Fecha_Aceptado = '".date('Y-m-d')."'

			WHERE CodigoAlumno = '".$_POST['CodigoAlumno']."' 

			AND Ano='".$AnoEscolarProx."'";

echo $Insp ?  $query." (4)<br>" : "";

$rs = mysql_query($query, $bd) or die(mysql_error()); 

}

// fin Cambia Status a aluno = Aceptado







if (isset($_POST['Buscar']) or isset($_GET['CodigoBuscar'])) {



$aux = explode(" ",strtolower( $_POST['Buscar'].$_GET['CodigoBuscar']));// echo "1: ". $aux[0]. " 2: ". $aux[1];



/*echo $_POST['Buscar'].$_GET['CodigoBuscar'].'<br>';

echo $aux[0].'<br>';

echo $aux[1].'<br>';

echo $aux[2].'<br>';

echo $aux[3].'<br>';

echo $aux[4].'<br>';

echo $aux[5].'<br>';*/





mysql_select_db($database_bd, $bd);

$query_RS_Alumnos  = "SELECT * FROM Alumno, AlumnoXCurso 

						WHERE Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno  

						";//AND (AlumnoXCurso.Ano = '$AnoEscolar' OR AlumnoXCurso.Ano = '$AnoEscolarProx' )







if($aux[0]>0 and $aux[0]<9999){

$query_RS_Alumnos .= " AND Alumno.CodigoAlumno = '$aux[0]' ";

}else{



if (isset($_POST['SWinscrito']) and $_POST['SWinscrito']==1) {

$query_RS_Alumnos .=  " AND AlumnoXCurso.Ano='$AnoEscolar' 

						AND AlumnoXCurso.Status = 'Inscrito' 

						AND AlumnoXCurso.Tipo_Inscripcion = 'Rg'"; }

	

$query_RS_Alumnos .= " AND (";

$query_RS_Alumnos .= "CONCAT_WS(' ', LOWER(Alumno.CodigoAlumno), LOWER(Alumno.Nombres), LOWER(Alumno.Nombres2), LOWER(Alumno.Apellidos), LOWER(Alumno.Apellidos2 )) LIKE '%$aux[0]%'";

if($aux[1]!=""){$query_RS_Alumnos .=  " AND  CONCAT_WS(' ', LOWER(Alumno.CodigoAlumno), LOWER(Alumno.Nombres), LOWER(Alumno.Nombres2), LOWER(Alumno.Apellidos), LOWER(Alumno.Apellidos2 )) LIKE '%$aux[1]%' ";}

if($aux[2]!=""){$query_RS_Alumnos .=  " AND  CONCAT_WS(' ', LOWER(Alumno.CodigoAlumno), LOWER(Alumno.Nombres), LOWER(Alumno.Nombres2), LOWER(Alumno.Apellidos), LOWER(Alumno.Apellidos2 )) LIKE '%$aux[2]%' ";}

if($aux[3]!=""){ $query_RS_Alumnos .=  " AND CONCAT_WS(' ', LOWER(Alumno.CodigoAlumno), LOWER(Alumno.Nombres), LOWER(Alumno.Nombres2), LOWER(Alumno.Apellidos), LOWER(Alumno.Apellidos2 )) LIKE '%$aux[3]%' ";}

$query_RS_Alumnos .= ") ORDER BY AlumnoXCurso.Ano DESC, Alumno.Apellidos, Alumno.Apellidos2, Alumno.Nombres, Alumno.Nombres2";

}



//$query_RS_Alumnos .= "GROUP BY AlumnoXCurso.Ano";







//echo $query_RS_Alumnos;

$RS_Alumnos = mysql_query($query_RS_Alumnos, $bd) or die(mysql_error());

$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);

$totalRows_RS_Alumnos = mysql_num_rows($RS_Alumnos);

} 



$colname_RS_Alumno = "-1";

if (isset($_GET['CodigoClave'])) {

  $colname_RS_Alumno = $_GET['CodigoClave'];

}

mysql_select_db($database_bd, $bd);

$query_RS_Alumno = sprintf("SELECT * FROM Alumno WHERE CodigoAlumno = %s", GetSQLValueString($colname_RS_Alumno, "text"));

$RS_Alumno = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());

$row_RS_Alumno = mysql_fetch_assoc($RS_Alumno);

$totalRows_RS_Alumno = mysql_num_rows($RS_Alumno);





mysql_select_db($database_bd, $bd);

$query_RS_Cursos = "SELECT * FROM Curso ORDER BY Curso.NivelMencion, Curso.Curso, Curso.Seccion";

$RS_Cursos = mysql_query($query_RS_Cursos, $bd) or die(mysql_error());

$row_RS_Cursos = mysql_fetch_assoc($RS_Cursos);

$totalRows_RS_Cursos = mysql_num_rows($RS_Cursos);



?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

 

<title>Busca Alumnos</title>



<link href="../../estilos.css" rel="stylesheet" type="text/css" />



<script src="../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>

<link href="../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />

<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>

<script src="../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>

<link href="../../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />

<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<link href="../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />

<script src="../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>

<link href="../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />



<link href="../../estilos2.css" rel="stylesheet" type="text/css" />

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

<link href="../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />

</head>



<body onLoad="Buscar.focus()">

<table width="1000" border="0" align="center">

  <tr>

    <td><?php   

	$TituloPantalla ="Alumnos";

	require_once('TitAdmin.php'); ?></td>

  </tr>

  <tr>

    <td colspan="2" align="center">      <div align="center"><?php if ($_GET['Aceptar'] == '1') { ?>

        <form action="<?php echo $editFormAction; ?>" method="post" name="aceptar" id="aceptar">

          <table width="90%" border="0">

            <tr>

              <td colspan="2" class="subtitle">Aceptar alumno

                <input name="Status" type="hidden" id="Status" value="Aceptado" />

                  <input name="SWInscrito" type="hidden" id="SWInscrito" value="0" />

                  <input name="CodigoAlumno" type="hidden" id="CodigoAlumno" value="<?php echo $row_RS_Alumno['CodigoAlumno'] ?>" />

                  <input name="Aceptar" type="hidden" id="Aceptar" value="1" /></td>

            </tr>

            <tr>

              <td class="NombreCampo">Alumno</td>

              <td class="FondoCampo"><?php echo $row_RS_Alumno['Nombres'].", ".$row_RS_Alumno['Apellidos']; ?></td>

            </tr>

            <tr>

              <td class="NombreCampo">Curso</td>

              <td class="FondoCampo">



                  <?php

				  

$sql = "SELECT * FROM AlumnoXCurso 

		WHERE CodigoAlumno='".$row_RS_Alumno['CodigoAlumno']."' 

		AND Ano='".$AnoEscolarProx."' ";

$RS_sql = 	mysql_query($sql, $bd) or die(mysql_error());

$row_RS = mysql_fetch_assoc($RS_sql);

$totalRows_RS = mysql_num_rows($RS_sql);



MenuCurso($row_RS['CodigoCurso'],'');

				  

?></td>

            </tr>

            <tr>

              <td class="NombreCampo">Observaciones</td>

              <td class="FondoCampo"><label>

                <textarea name="ObsvInsc" id="ObsvInsc" cols="40" rows="4"></textarea>

              </label></td>

            </tr>

            <tr>

              <td>&nbsp;</td>

              <td><label>

                <input type="submit" name="button" id="button" value="Aceptar" />

              </label></td>

            </tr>

          </table>

          <input type="hidden" name="MM_update" value="aceptar" />

        </form>

        <?php } else {  ?>

        <table width="90%"  border="0" align="center">

          <tr>

            <td colspan="2" align="left" ><table border="0" cellspacing="0" cellpadding="0">

                <tr>

                  <td class="subtitle">Buscar</td>

                </tr>

                <tr>

                  <td align="center" nowrap="nowrap"><form action="ListaAlumnos.php" method="post" name="form3" id="form3">

                    <input name="SWinscrito" type="checkbox" id="SWinscrito" value="1" checked="checked" />Inscrito <input name="Buscar" type="text" id="Buscar" value="<?php echo $_POST['Buscar']; ?>" />

                    <input type="submit" name="Submit" value="Buscar" />

            </form></td>

                </tr>

              </table></td>

          </tr>

          <tr>

            <td colspan="2"></td>

          </tr>

          <tr>

            <td width="50%" class="subtitle">Listado de Alumnos </td>

            <td width="50%" align="right" class="subtitle"> cant: <?php echo $totalRows_RS_Alumnos ?></td>

          </tr>

            <tr>

            <td colspan="2"><?php if ($totalRows_RS_Alumnos > 0) { // Show if recordset not empty ?>

            

<table width="100%" border="0" cellpadding="3" cellspacing="0">

<?php do { 



if($CodigoAlumnoAnterior != $row_RS_Alumnos['CodigoAlumno']){

?>



<tr>

<td align="left" valign="top" nowrap="nowrap" class="NombreCampoBIG"><?php echo ++$K ?></td>

<td colspan="3" align="left" valign="top" nowrap="nowrap" class="NombreCampoBIG"><a href="PlanillaImprimirADM.php?CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno']; ?>" target="_blank">(<?php echo $row_RS_Alumnos['CodigoAlumno']; ?>) <strong> <?php echo $row_RS_Alumnos['Apellidos'].' '. $row_RS_Alumnos['Apellidos2'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'. $row_RS_Alumnos['Nombres'].' '. $row_RS_Alumnos['Nombres2']; ?></strong></a>

<span class="titlebar"><?php 
				  
				  
					$SQLstatus = "SELECT * FROM AlumnoXCurso
									WHERE CodigoAlumno = '".$row_RS_Alumnos['CodigoAlumno']."'
									AND Ano = '".$AnoEscolar."'";
					$RS_Status_Actual = $mysqli->query($SQLstatus);
					if($row_Status_Actual = $RS_Status_Actual->fetch_assoc())
						echo ' '.$AnoEscolar.': '.$row_Status_Actual['Status'];
					
					if($AnoEscolar != $AnoEscolarProx){	
						$SQLstatus = "SELECT * FROM AlumnoXCurso
										WHERE CodigoAlumno = '".$row_RS_Alumnos['CodigoAlumno']."'
										AND Ano = '".$AnoEscolarProx."'";
						$RS_Status_Prox = $mysqli->query($SQLstatus);
						if($row_Status_Prox = $RS_Status_Prox->fetch_assoc())
							echo ' '.$AnoEscolarProx.': '.$row_Status_Prox['Status'];
					}
	//				echo $SW_Reinscripciones_Abiertas;
						
				  
				  ?></span>

</td>

<td colspan="7" align="right" valign="top" nowrap="nowrap" <?php if($Creador_AlumnoAnterior != $row_RS_Alumnos['Creador']) echo ' class="NombreCampoBIG"'; ?>><?php echo $row_RS_Alumnos['Creador'] ; ?></td>

</tr>







                  

<tr>

    <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>

    <td align="left" valign="top" nowrap="nowrap"><?php echo CursoAlumno($row_RS_Alumnos['CodigoAlumno'], $AnoEscolar ) ?>

      <br />

      <?php 

    if ($MM_Username=="piero"){ ?>
      <a href="Procesa.php?CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno']; ?>&EliminaAlumno=1" target="_blank">Eliminar</a>
      <br />
      <br />
<?php } 

    if ($MM_Username=="piero"){		  //INSCRIBIR				  

    if($AnoEscolar != $AnoEscolarProx){


    $sql = "SELECT * FROM AlumnoXCurso 
			WHERE CodigoAlumno = '".$row_RS_Alumnos['CodigoAlumno']."' 
			AND Ano='$AnoEscolarProx'
			AND Tipo_Inscripcion = 'Rg'
			ORDER BY Codigo DESC";
    $RS_ = mysql_query($sql, $bd) or die(mysql_error());
    $row_Curso_Prox = mysql_fetch_assoc($RS_);
    $totalRows_RS_ = mysql_num_rows($RS_);

    if( $row_Curso_Prox['Status'] == 'Inscrito' ) 
    	$SWinscrito_Prox = 1; 
    else 
	    $SWinscrito_Prox = 0;

    

    if($row_Curso_Prox['Codigo']>0 and $row_Curso_Prox['SeRetira']!='1'){	
		if($SWinscrito_Prox){
			?>Preinscrito<br>
			  <a href="Procesa.php?<?php echo 'Retirar=1&CodigoAlumno='.$row_RS_Alumnos['CodigoAlumno'].'&AnoEscolar='.$AnoEscolarProx; ?>" target="_blank">Retirar <?php echo $AnoEscolarProx ?></a><?php 
			}
		else{
			$sql="SELECT * FROM Curso WHERE CodigoCurso='".$row_RS_Alumnos['CodigoCurso']."'";
			$RS_ = mysql_query($sql, $bd) or die(mysql_error());
			$row_ = mysql_fetch_assoc($RS_);
			$CodigoCursoProxAno = $row_Curso_Prox['CodigoCurso'];
			$NivelCurso = $row_['NivelCurso'];
			$NombreCurso = $row_['NombreCompleto'];
			if($row_Curso_Prox['Status'] == "Aceptado" and $row_RS_Alumnos['Deuda_Actual'] <1 or $MM_Username=="piero" or $MM_Username=="mary"){
				?><a href="Procesa.php?<?php echo 'Inscribir=1&CodigoAlumno='.$row_RS_Alumnos['CodigoAlumno'].'&AnoEscolar='.$AnoEscolarProx; ?>" target="_blank">Inscribir<br />
				<?php echo Curso($CodigoCursoProxAno).'<br>'.$AnoEscolarProx ?></a> <br><?php 
			}
		
			else
				echo "Deuda:<br>".Fnum($row_RS_Alumnos['Deuda_Actual']); 
			} 
	}
	}

	

	// echo $row_Curso_Prox['SeRetira'];

	if($row_Status_Actual['SeRetira']=='0'){

	?><br />

      <a href="Procesa.php?<?php echo 'SeRetira=1&CodigoAlumno='.$row_RS_Alumnos['CodigoAlumno'].'&AnoEscolar='.$AnoEscolar; ?>" target="_blank">Se Retira</a>

      <?php

	}

	elseif($row_Status_Actual['SeRetira']=='1')

	{ echo "Se retira";}

	}

    

    ?>
<br />
<a href="Procesa.php?<?php echo 'Retirar=1&CodigoAlumno='.$row_RS_Alumnos['CodigoAlumno'].'&AnoEscolar='.$AnoEscolar; ?>" target="_blank">Retirar <?php echo $AnoEscolar ?></a>
<br />

<?php if (($MM_UserGroup=='99' or $MM_UserGroup=='91' or  $MM_UserGroup=='95' or $MM_UserGroup=='secre') and $row_RS_Alumnos['Status'] == 'Solicitando'){ ?>

      <a href="ListaAlumnos.php?Aceptar=1&amp;CodigoClave=<?php echo $row_RS_Alumnos['CodigoAlumno']; ?>"><?php echo $row_RS_Alumnos['Status'] ?> ACEPTAR</a>

      <?php } ?>

      <br />

      <a href="ListaAlumnos.php?Inscripcion_Condicional=<?php if($row_RS_Alumnos['SWInsCondicional']==1) echo '2'; else echo '1';  ?>&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno']; ?>">Ins Cond. = <?php echo $row_RS_Alumnos['SWInsCondicional']; ?></a> <br />

      <a href="Sube_Foto.php?Tipo=Alumno&Codigo=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>" target="_blank">Foto</a><br />

      <?php //echo "<br>".$row_RS_Alumnos['CodigoFamilia'].'-'.$row_RS_Alumnos['PrincipalFamilia']; ?>      <br /></td>

    <td align="left" valign="top" nowrap="nowrap">Constancia de:<br />

      <?php 
	  $sql = "SELECT * FROM AlumnoXCurso 
	  			WHERE CodigoAlumno = '".$row_RS_Alumnos['CodigoAlumno']."' 
				AND Ano = '$AnoEscolarProx'
				AND Status = 'Inscrito'";
    //echo $sql;
    $RS_ = mysql_query($sql, $bd) or die(mysql_error());
    $row_Prox = mysql_fetch_assoc($RS_);
    if($row_Prox['Codigo'] > 0){

    ?>
      <a href="../Constancia.php?CodigoClave=<?php echo $row_RS_Alumnos['CodigoClave']; ?>&ConstanciaDe=Inscrito" target="_blank"> Inscrito</a><br />

      <a href="../Constancia.php?CodigoClave=<?php echo $row_RS_Alumnos['CodigoClave']; ?>&ConstanciaDe=PreInscrito" target="_blank">PRE-Insc</a><br /><?php 
	  
	  } ?>

      <a href="../Constancia.php?CodigoClave=<?php echo $row_RS_Alumnos['CodigoClave']; ?>&ConstanciaDe=Estudio" target="_blank">Estudio</a><br />

      <a href="../Constancia.php?CodigoClave=<?php echo $row_RS_Alumnos['CodigoClave']; ?>&ConstanciaDe=BuenaConducta" target="_blank">BuenaConducta</a><br />

      <a href="../Constancia.php?CodigoClave=<?php echo $row_RS_Alumnos['CodigoClave']; ?>&ConstanciaDe=Retiro" target="_blank">Retiro</a><br />

      <br /></td>

    <td align="left" valign="top" nowrap="nowrap"><a href="Estado_de_Cuenta_Alumno.php?CodigoPropietario=<?php echo $row_RS_Alumnos['CodigoClave']; ?>" target="_self"><img src="../../i/coins_in_hand.png" width="32" height="32" /></a><?php echo $row_RS_Alumnos['Deuda_Actual']; ?>

<br />

<a href="../PlanillaInscripcion_pdf.php?CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoClave']; ?>" target="_blank">
<img src="../../i/paste_plain.png" width="32" height="32" />Planilla Inscr</a>

<br />

<a href="PDF/Carnet.php?CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno']; ?>" target="_blank">
<img src="../../i/vcard.png" width="32" height="32" />Carnet</a>

<br />

<a href="Academico/Nota_Certificada.php?CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno']; ?>" target="_blank">
<img src="../../i/application_view_detail.png" width="32" height="32" />Nota Certif.</a></td>

<td align="center" nowrap="nowrap">

<a href="Estado_de_Cuenta_Alumno.php?CodigoPropietario=<?php echo $row_RS_Alumnos['CodigoClave']; ?>" target="_self">

    <?php 

    	$nombreFoto = '../../'. $AnoEscolar.'/150/'.$row_RS_Alumnos['CodigoAlumno'].'.jpg';

    if (!file_exists($nombreFoto)) { 

    	$nombreFoto = '../../'. $AnoEscolarAnte.'/'.$row_RS_Alumnos['CodigoAlumno'].'.jpg';}

    if (!file_exists($nombreFoto)) { 

	    $nombreFoto = '../../'. $AnoEscolarAnteAnte.'/'.$row_RS_Alumnos['CodigoAlumno'].'.jpg';}

    ?><img src="<?php echo $nombreFoto ?>" width="150" height="150"  border="0" />

    </a><br />

    &nbsp;</td><?php

	 

	$Familia = array('p','m','a1','a2','a3');

    

    foreach($Familia as $id){



		?>  

		<td align="center"><?php 

		$nombreFoto = '../Foto_Repre/'. $row_RS_Alumnos['CodigoAlumno'].$id.'.jpg';

		$Actualizar = 'Actualizar';

		if (!file_exists($nombreFoto)) { 

			$nombreFoto = '../Foto_Repre/x_'. $row_RS_Alumnos['CodigoAlumno'].$id.'.jpg';

			$Actualizar = 'Solicitada';

		}

		if(file_exists($nombreFoto)){

			?><img src="<?php echo $nombreFoto ?>" alt="" height="150" border="0" /><br />

			<a href="Procesa.php?ActualizaFoto=1&Foto=<?php echo $row_RS_Alumnos['CodigoAlumno'].$id.'.jpg' ?>" target="_blank"><?php echo $Actualizar ?></a>

			</td><?php 

		}  

    

    } ?>

    

    

    

    

    

    

    <td align="center"><?php 

    $sql = "SELECT * FROM  Alumno, AlumnoXCurso 
			WHERE Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno 
			AND Alumno.Creador = '".$row_RS_Alumnos['Creador']."' 
			AND Alumno.CodigoAlumno <> '".$row_RS_Alumnos['CodigoAlumno']."' 
			AND (Alumno.Nombres <> '".$row_RS_Alumnos['Nombres']."' AND Alumno.Nombres2 <> '".$row_RS_Alumnos['Nombres2']."')
			AND (AlumnoXCurso.Ano = '$AnoEscolar' OR AlumnoXCurso.Ano = '$AnoEscolarProx') 
			GROUP BY AlumnoXCurso.CodigoAlumno";


    $RS_ = mysql_query($sql, $bd) or die(mysql_error());

    $row_ = mysql_fetch_assoc($RS_);

    $totalRows_RS_ = mysql_num_rows($RS_);

    if ($totalRows_RS_>0){

		do {

			$nombreFoto = '../../'. $AnoEscolar.'/'.$row_['CodigoAlumno'].'.jpg';

			if (!file_exists($nombreFoto)) { 

				$nombreFoto = '../../'. $AnoEscolarAnte.'/150/'.$row_['CodigoAlumno'].'.jpg';}

			?><img src="<?php echo $nombreFoto ?>" alt="" width="30" height="30" border="0" /><br><?php echo $row_['CodigoAlumno']; ?><br><?php

		} while ($row_ = mysql_fetch_assoc($RS_)); 	

    }

    ?></td>

</tr>

                  

                  <?php 

				  

				  }

				  

				  $CodigoAlumnoAnterior = $row_RS_Alumnos['CodigoAlumno'];

				  $Creador_AlumnoAnterior = $row_RS_Alumnos['Creador'];

				  

				  } while ($row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos)); ?>

                </table>

              &nbsp; <br />

                <?php } // Show if recordset not empty ?>            </td>

          </tr>

          <tr>

            <td colspan="2">&nbsp;</td>

          </tr>

          <tr>

            <td colspan="2">&nbsp;</td>

          </tr>

          <tr>

            <td colspan="2">&nbsp;</td>

          </tr>

        </table>

        <?php } ?>

    </div></td>

  </tr>

</table>



</body>



</html>



<?php

//mysql_free_result($RS_Alumno);



?>