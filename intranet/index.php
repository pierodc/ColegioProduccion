<?php 
if(true){
$MM_authorizedUsers = "2,91,docente";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');

if($MM_UserGroup == 'docente')
	header("Location: "."http://www.colegiosanfrancisco.com/Docente/index.php");

// ACTUALIZA CAMBIO BCV
$Variable = new Variable();
$Var_Name = "Cambio_Dolar";
$Var = $Variable->view_row($Var_Name);
if( Dif_Tiempo($Var['Fecha_Modificacion']) > 90 ){
	$cambio_BCV = trim(coma_punto(cambio_BCV()));
	$Variable->edit($Var_Name, $cambio_BCV,"auto repre");
	$Var_Value = $cambio_BCV;
}
// FIN ACTUALIZA CAMBIO BCV


// actualiza codigos md5
mysql_select_db($database_bd, $bd);
$query = "UPDATE Alumno set CodigoClave = left(md5(CodigoAlumno),16) WHERE CodigoClave = '0'";
$rs = mysql_query($query, $bd) or die(mysql_error());
$query = "UPDATE Alumno set CodigoCreador = left(md5(Creador),16) WHERE CodigoCreador = '0'";
$rs = mysql_query($query, $bd) or die(mysql_error());
$query = "UPDATE Usuario set CodigoCreador = left(md5(Usuario),16) WHERE CodigoCreador = 'a'";
$rs = mysql_query($query, $bd) or die(mysql_error());
// fin actualiza codigos md5


if (isset($_COOKIE['MM_Username'])) {
  $MM_Username = (get_magic_quotes_gpc()) ? $_COOKIE['MM_Username'] : addslashes($_COOKIE['MM_Username']);
  $colname_RS_Alumnos = $_COOKIE['MM_Username'];
}

// Elimina Autorizado
if(isset($_GET['noAutorizano'])){
	$CodigoRepresentante = $_GET['CodigoAutorizado'];
	$CodigoAlumno = $_GET['CodigoAlumno'];
	$sql="UPDATE RepresentanteXAlumno 
			SET Nexo = 'ExAutorizado' 
			WHERE CodigoRepresentante = '$CodigoRepresentante' 
			AND CodigoAlumno =  '$CodigoAlumno'"; //	AND Creador = '$MM_Username'
	$Resultado = mysql_query($sql, $bd) or die(mysql_error());
}
// fin


// Elimina Conyugue
if(isset($_GET['EliminaRep'])){
	$CodigoRepresentante = $_GET['EliminaRep'];
	$CodigoAlumno = $_GET['CodigoAlumno'];
	$sql="UPDATE RepresentanteXAlumno 
			SET Nexo = 'ExConyu' 
			WHERE CodigoRepresentante = '$CodigoRepresentante' 
			AND CodigoAlumno =  '$CodigoAlumno'"; //	AND Creador = '$MM_Username'
	$Resultado = mysql_query($sql, $bd) or die(mysql_error());
}
// fin

if(isset($_GET['Crear']) and isset($_GET['Nexo'])){
	$Nexo = $_GET['Nexo'];
	$CodigoRepresentante = $_GET['CodigoRepresentante'];
	$CodigoAlumno = $_GET['CodigoAlumno'];
	$SW_Representante = $_GET['SW_Repre'];
	
	$sql="INSERT INTO RepresentanteXAlumno 
			(CodigoRepresentante, CodigoAlumno, Nexo, SW_Representante)
			VALUES
			('$CodigoRepresentante', '$CodigoAlumno', '$Nexo', '$SW_Representante')";
	$Resultado = mysql_query($sql, $bd) or die(mysql_error());
	header("Location: ".$_SERVER['PHP_SELF']);

}




?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Colegio San Francisco de As&iacute;s</title>

<link rel="shortcut icon" href="../img/favicon.ico">
<link href="../css/Level2_Arial_Text.css" rel="stylesheet" type="text/css">
<style type="text/css">
.style1 {color: #0000FF}
</style>
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
</style>
</head>
<body bgcolor="e7e7e9" leftmargin="0" topmargin="20" marginwidth="0" marginheight="0"  >
<!-- ImageReady Slices (index.psd) -->
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="Table_01">
<tr>
		<td bgcolor="#FFF8E8">
			<img src="../img/index_01.jpg" width="31" height="191" alt=""></td>
		<td colspan="2" align="left" bgcolor="#0A1B69">
			<img src="../img/TitSol.jpg" width="197" height="191" alt=""><img src="../img/TituloAzul.jpg" width="766" height="191" alt="Colegio San Francisco de Asis"></td>
		<td bgcolor="#FFF8E8">
			<img src="../img/index_04.jpg" width="31" height="191" alt=""></td>
	</tr>
	<tr>
		<td colspan="4" align="center" bgcolor="#F7F1E1">
			<img src="../img/index_05.jpg" width="1025" height="7" alt=""></td>
	</tr>
	<tr>
		<td align="center" bgcolor="#F7F1E1">
			<img src="../img/index_06.jpg" width="31" height="68" alt=""></td>
		<td bgcolor="#F7F1E1">&nbsp;</td>
		<td align="center" bgcolor="#F7F1E1">&nbsp;</td>
  <td bgcolor="#FFF8E8">
			<img src="../img/index_09.jpg" width="31" height="68" alt=""></td>
	</tr>
	<tr>
		<td colspan="4" align="center" bgcolor="#F7F1E1">
			<img src="../img/index_10.jpg" width="1025" height="6" alt=""></td>
	</tr>
	<tr>
		<td colspan="4" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="31" bgcolor="#FFF8E8">&nbsp;</td>
            <td colspan="2"><?php include('../inc_login.php'); ?></td>
            <td width="31" bgcolor="#FFF8E8">&nbsp;</td>
          </tr>
          <tr>
            <td width="31" bgcolor="#D1D0B4">&nbsp;</td>
            <td width="197" valign="top" bgcolor="#EBE4C8">
<?php $subDir = '../'; ?><?php include('../inc_menu.php'); ?></td>
            <td rowspan="3" align="center" valign="top" class="box1">
<img src="../img/b.gif" width="740" height="1"><br>
<table width="98%"  border="0" align="center" cellspacing="5" cellpadding="2">
  <tr>
    <td width="50" align="center" class="NombreCampoBIG" >&nbsp;</td>
  </tr>
  <tr>
    <td align="center"  class="ListadoNotasBC2"><p><a href="https://www.dropbox.com/s/3pfqzn8460cv3ih/CuestionarioDptodePsicologia.pdf?dl=0" target="_blank">Cuestionario Dpto de Psicolog&iacute;a </a> | <a href="https://www.dropbox.com/s/7o1c1itxsbjnkij/RecaudosInstrucciones.pdf?dl=0" target="_blank">Recaudos e Instrucciones</a> | <a href="https://www.dropbox.com/s/3bkg1el8j0bc8ke/PreguntasFrecuentes.pdf?dl=0" target="_blank">Preguntas Frecuentes</a><br>
        </p>
        <p><a href="Proveeduria/index.php"><img src="../i/cart_edit.png" width="32" height="32" alt=""/> Proveeduria</a></p></td>
  </tr>
  <tr>
    <td align="center" >&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><table width="100%" border="0" bordercolor="#666666">
          <tr>
            <td colspan="4" class="subtitle">Alumno</td>
          </tr>
<?php 



$query_RS_Alumnos = "SELECT * FROM Alumno WHERE Creador = '$MM_Username' ORDER BY FechaNac ASC";
$RS_Alumnos = mysql_query($query_RS_Alumnos, $bd) or die(mysql_error());
$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
$totalRows_RS_Alumnos = mysql_num_rows($RS_Alumnos);


if($totalRows_RS_Alumnos>0)
 do {  
 unset($Dato_OK);
 $SW_Actualizar = false;
 
 ?>
          <tr>
            <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td rowspan="2" bgcolor="#BCD5FF" class="RTitulo"><?php if ($totalRows_RS_Alumnos > 0) {  ?>
                  <a href="PlanillaInscAlum.php?CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno']; ?>">
				  <?php  echo $row_RS_Alumnos['Nombres']; ?>
                  <?php  echo $row_RS_Alumnos['Nombres2']; ?>
                  ,
                  <?php  echo $row_RS_Alumnos['Apellidos']; ?>
                  <?php  echo $row_RS_Alumnos['Apellidos2']; ?>
                  
                  <?php if(strtotime(date("Y-m-d")) - strtotime($row_RS_Alumnos['Datos_Revisado_Fecha']) > (30 * 86400) ) { $SW_Actualizar = true; ?>
                  <span class="MensajeDeError">ACTUALIZAR</span> 
                  <?php } ?>
                  
                  <img src="../i/vcard_edit.png" alt="" width="32" height="32" border="0" align="absmiddle"></a>
                  <?php } else { ?>
                  <span class="MensajeDeError"> 1) Ingrese los datos del alumno <a href="PlanillaInscAlum.php">Click Aqu&iacute;</a> </span>
                  <?php } 
				  
				  
				  
				  
// Status Actual				  
$SQLstatus = "SELECT * FROM AlumnoXCurso
				WHERE CodigoAlumno = '".$row_RS_Alumnos['CodigoAlumno']."'
				AND Ano = '".$AnoEscolar."'
				AND Tipo_Inscripcion <> 'Mp'";
$RS_Status = $mysqli->query($SQLstatus);
if($row_Status = $RS_Status->fetch_assoc()){
		//echo '<br>'.$AnoEscolar.': '.$row_Status['Status'].' '.Curso($row_Status['CodigoCurso']);
		$StatusActual = $row_Status['Status'];	
		$CodigoCursoProx = CodigoCursoProx($row_Status['CodigoCurso']);
		$CodigoCurso = $row_Status['CodigoCurso'];
}


if($StatusActual == "Inscrito"){
	echo '<br>'.$AnoEscolar.': '.$row_Status['Status'].' '.Curso($row_Status['CodigoCurso']);
		
	$SQLstatus = "SELECT * FROM AlumnoXCurso
					WHERE CodigoAlumno = '".$row_RS_Alumnos['CodigoAlumno']."'
					AND Ano = '".$AnoEscolarProx."'
					AND Tipo_Inscripcion <> 'Mp'";
	//echo $SQLstatus;				
	$RS_Status_Prox = $mysqli->query($SQLstatus);
		
		
		if($row_Status_Prox = $RS_Status_Prox->fetch_assoc()){ // Existe Prox Año
				if($row_Status_Prox['Status'] == 'Solicitando'){
					$sql = "UPDATE AlumnoXCurso SET Status = 'Aceptado'
							WHERE  CodigoAlumno = '".$row_RS_Alumnos['CodigoAlumno']."'
							AND Ano = '".$AnoEscolarProx."'
							AND Tipo_Inscripcion = 'Rg'";
					//echo "<br><br>".$sql;		
					//$mysqli->query($sql);
					}
				
				if($CodigoCurso == $row_Status_Prox['CodigoCurso']){
					$sql = "UPDATE AlumnoXCurso SET 
							CodigoCurso = '".$CodigoCursoProx."'  
							WHERE  CodigoAlumno = '".$row_RS_Alumnos['CodigoAlumno']."'
							AND Ano = '".$AnoEscolarProx."'
							AND Tipo_Inscripcion = 'Rg'";
					//echo "<br><br>".$sql;		
					//$mysqli->query($sql);
					}
				
			}
			
			
		else{ // No existe -> crear
			$sql = "INSERT INTO AlumnoXCurso 
					(CodigoAlumno, Ano, CodigoCurso, Status, Tipo_Inscripcion ) 
					VALUES 
					('".$row_RS_Alumnos['CodigoAlumno']."', '".$AnoEscolarProx."', 
						'$CodigoCursoProx', 'Aceptado','Rg')";		
			//$mysqli->query($sql);
			}
		
		//echo $sql;	
	} // FIN $StatusActual == "Inscrito"






$SQLstatus = "SELECT * FROM AlumnoXCurso
				WHERE CodigoAlumno = '".$row_RS_Alumnos['CodigoAlumno']."'
				AND Ano = '".$AnoEscolarProx."'
				AND Tipo_Inscripcion <> 'Mp'";
$RS_Status_Prox = $mysqli->query($SQLstatus);
if($row_Status_Prox = $RS_Status->fetch_assoc()){
	echo '<br>'.$AnoEscolarProx.': '.$row_Status_Prox['Status'];}
$Status_Prox = $row_Status_Prox['Status'];	


// Para activar o no Boletas
if($StatusActual == "Inscrito")
	$CodigoCursoActual = $row_Status['CodigoCurso'];
else
	$CodigoCursoActual = "";			

$Curso = new Curso($row_Status['CodigoCurso']);
	 
	 
				
mysql_select_db($database_bd, $bd);
$query_Pendiente = "SELECT * FROM ContableMov 
					WHERE CodigoPropietario = '".$row_RS_Alumnos['CodigoAlumno']."'"; 
$Pendiente = mysql_query($query_Pendiente, $bd) or die(mysql_error());
$row_Pendiente = mysql_fetch_assoc($Pendiente);
$totalRows_Pendiente = mysql_num_rows($Pendiente);

					
if($AnoEscolar != $AnoEscolarProx){	
	//echo "<br>";
	$SQLstatus = "SELECT * FROM AlumnoXCurso
					WHERE CodigoAlumno = '".$row_RS_Alumnos['CodigoAlumno']."'
					AND Ano = '".$AnoEscolarProx."'
					AND Tipo_Inscripcion <> 'Mp'";
	$RS_Status = $mysqli->query($SQLstatus);
	if($row_Status = $RS_Status->fetch_assoc()){
		echo ' <br><span><p class=" RTitulo">('.$AnoEscolarProx.': '.$row_Status['Status'].' '. Curso($row_Status['CodigoCurso']) .')</p>';
		if($totalRows_Pendiente == 0)
			echo '<p class="SW_Verde RTitulo">COMPLETE TODOS LOS DATOS FALTANTE luego <br>Espere ser notificado por email (aprox en 5 días) para registrar el pago. En caso de no ser notificado su solicitud queda en espera de liberación de cupo.</p>';
		
		if($row_RS_Alumnos['Deuda_Actual'] > 0)
			echo '<p class="SW_Verde RTitulo">Registre el pago en el link a la derecha --->>></p>';
		
		echo '</span>';
		}elseif($StatusActual == "" and $row_Status['Status'] == ""){
			echo ' <br><span class="MensajeDeError">';
			echo "INDIQUE EL CURSO DENTRO DE LOS DATOS DEL ALUMNO";
			echo '</span>';
			}
}
$StatusProx = $row_Status['Status'];
					
	//				echo $SW_Reinscripciones_Abiertas;
				  
				  ?></td>
                <td rowspan="2" bgcolor="#BCD5FF" class="RTitulo"><span class="BoletaNota">
                  <?php 
				$Codigo = $row_RS_Alumnos['CodigoAlumno'];
			  $Tipo = '';
			  $foto = "../f/solicitando/".$Codigo.$Tipo.".jpg";
			  if(file_exists($foto)){ ?>
                  <img src="<?php echo $foto; ?>" width="80"  /> <br />
                  <a href="Sube_Foto.php?CodigoPropietario=<?= $row_RS_Alumnos['CodigoClave'].'&Tipo='.$Tipo ?>" class="BoletaNota"><img src="../i/arrow_refresh_small.png" width="32" height="32" alt=""/>Cambiar</a>
                  <?php }else{ ?>
                  <a href="Sube_Foto.php?CodigoPropietario=<?= $row_RS_Alumnos['CodigoClave'].'&Tipo='.$Tipo ?>" class="BoletaNota"><img src="../i/camera_add.png" width="32" height="32" alt=""/><br />
Cargar Foto</a>
                  <?php } ?>
                </span></td>
                <td align="left" nowrap bgcolor="#BCD5FF" class="big">
                <?php if ($StatusActual == "Inscrito" or 
							$StatusProx == "Inscrito" ){ ?>
                <a href="CartelParabrisa_pdf.php?CodigoPropietario=<?php echo $row_RS_Alumnos['CodigoClave']; ?>" target="_blank"><img src="../i/car.png" width="32" height="32" alt=""/> Cartel Parabrisa</a><?php } ?></td>
                <td rowspan="2" align="right" bgcolor="#BCD5FF"><?php if ($StatusActual == "Inscrito" or 
							$StatusProx == "Inscrito" or 
							$StatusProx == "Aceptado" or 
							($StatusProx == "Solicitando" and $totalRows_Pendiente > 0)){ ?>
                  <a href="Pagos.php?CodigoPropietario=<?php echo $row_RS_Alumnos['CodigoClave']; ?>" class="big"><img src="../i/cash_register_2.png" alt="" width="32" height="32" border="0" align="absmiddle"><br>
Pagos</a><?php 
if(true) {// true boletas activas / false inactivas
			
		$CodigoAlumno = $row_RS_Alumnos['CodigoAlumno'];
		$query_Solvente = "SELECT * FROM ContableMov
							WHERE CodigoPropietario = '$CodigoAlumno'
							AND ReferenciaMesAno = '$MesAnoParaSolvencia'
							AND MontoDebe > 0
							AND SWCancelado = '0'";
		//echo $query_Solvente;					
		$RS_Solvente = mysql_query($query_Solvente, $bd) or die(mysql_error());
		if($row_Solvente = mysql_fetch_assoc($RS_Solvente)){   // bypass deuda -> and false  ?>
			<br>
			<span class="big"> Para visualizar la boleta y otros documentos<br>
			debe solicitar solvencia</span><?php 
		}
		else{
			if($Curso->NivelCurso() >= 31){
				?> <br><br><a href="PDF/Boleta.php?CodigoPropietario=<?php echo $row_RS_Alumnos['CodigoClave']; ?>" target="_blank" class="big">Ver Boleta</a>
				<?php
			}
			else{
				?> <br><br><a href="PDF/Boleta_Pr.php?Lapso=2&CodigoCurso=<?= $CodigoCursoActual ?>&idAlumno=<?php echo $row_RS_Alumnos['CodigoClave']; ?>" target="_blank" class="big">Ver Boleta</a>
			<?php
			}
			if($Curso->NivelCurso() == 42){
				?> <br><br><a href="PDF/Nota_Certificada.php?CodigoPropietario=<?php echo $row_RS_Alumnos['CodigoClave']; ?>" target="_blank" class="big">Nota Certificada</a>
				<?php
			}
			
		}
} ?>
<?php if($MM_Username == "piero@dicampo.com"){?>
                  <br>
                  <a href="Solicitud.php?CodigoPropietario=<?php echo $row_RS_Alumnos['CodigoClave']; ?>" class="big">Solicitud Documentos</a>
                  <?php }} ?></td>
              </tr>
              <tr>
                <td nowrap bgcolor="#BCD5FF" class="big"><?php if ($StatusActual == "Inscrito" or 
							$StatusProx == "Inscrito" ){ ?><a href="PDF/Carnet.php?CodigoPropietario=<?php echo $row_RS_Alumnos['CodigoClave']; ?>" target="_blank">
                  
                  <img src="../i/client_account_template.png" width="32" height="32" alt=""/> Carnet Repre.
                  
                </a><?php } ?></td>
              </tr>
            </table></td>
            </tr>
          <tr>
            <td colspan="2" class="NombreCampoBIG">Padre </td>
            <td colspan="2" class="NombreCampoBIG">Madre</td>
            </tr>
          <tr>
            <td width="40%" class="FondoCampo"><?php 
		
		
			
$Nexo = 'Padre'; 
$query_RS_Rp = "SELECT * FROM RepresentanteXAlumno, Representante 
					WHERE RepresentanteXAlumno.CodigoRepresentante = Representante.CodigoRepresentante
					AND RepresentanteXAlumno.Nexo = '$Nexo'
					AND RepresentanteXAlumno.CodigoAlumno = '".$row_RS_Alumnos['CodigoAlumno']."'";
$RS_Rp = mysql_query($query_RS_Rp, $bd) or die(mysql_error());
$row_RS_Rp = mysql_fetch_assoc($RS_Rp);
$totalRows_RS_Rp = mysql_num_rows($RS_Rp);

if ($totalRows_RS_Rp == 0) { // No hay el repre ?>
<span class="MensajeDeError"> 2) <?php echo $Nexo ?> del alumno <img src="../i/user_<?php echo $Nexo ?>.png" alt="" width="32" height="32" border="0" align="absmiddle"> </span><br>
	<?php if($CodigoAnterior[$Nexo] > 0){ // mismo repre?  ?>
        <a href="index.php?Crear=1&Nexo=<?php echo $Nexo ?>&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>&CodigoRepresentante=<?php echo $CodigoAnterior[$Nexo] ?>&SW_Repre=<?php echo $SW_RepreAnterior[$Nexo] ?>">
        Click  si hermanos por parte de <?php echo $Nexo ?>	
        <img src="../i/unit-completed32.png" width="32" height="32" border="0" align="absmiddle"></a><br>
    <?php } ?>
<a href="PlanillaInscRepre.php?Nexo=<?php echo $Nexo ?>&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>"> <?php echo $Nexo ?>  <?php if($CodigoAnterior[$Nexo] > 0){echo " DISTINTO ";} ?>
 Click  para ingresar datos<img src="../i/vcard_add.png" width="32" height="32" border="0" align="absmiddle"></a>
<?php } else { // Si hay un repre
$Dato_OK[$Nexo] = 1; 
$CodigoAnterior[$Nexo] = $row_RS_Rp['CodigoRepresentante'];
$SW_RepreAnterior[$Nexo] = $row_RS_Rp['SW_Representante'];
?><a href="PlanillaInscRepre.php?CodigoRepresentante=<?php echo $row_RS_Rp['CodigoRepresentante']; ?>&Nexo=<?php echo $Nexo ?>&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>">
<img src="../i/user_<?php echo $Nexo ?>.png" width="32" height="32" border="0" align="absmiddle"> <?php echo $row_RS_Rp['Apellidos']; ?>, <?php echo $row_RS_Rp['Nombres']; ?>&nbsp;</a>



<?php if(strtotime(date("Y-m-d")) - strtotime($row_RS_Rp['Fecha_Actualizacion']) > (30 * 86400) ) { $SW_Actualizar = true; ?>
<span class="MensajeDeError">ACTUALIZAR</span>
<?php } ?>


              <?php } 
			  
			  
			  
			  
			  ?></td>
            <td width="10%" align="right" class="FondoCampo"><?php 
			  $Tipo = 'p';
			  $foto = "../f/solicitando/".$Codigo.$Tipo.".jpg";
			  if(file_exists($foto)){ ?>
              <img src="<?php echo $foto; ?>" width="80"  /> <br />
              <a href="Sube_Foto.php?CodigoPropietario=<?= $row_RS_Alumnos['CodigoClave'].'&Tipo='.$Tipo ?>"><img src="../i/arrow_refresh_small.png" width="32" height="32" alt=""/>Cambiar</a>
              <?php }else{ ?>
              <a href="Sube_Foto.php?CodigoPropietario=<?= $row_RS_Alumnos['CodigoClave'].'&Tipo='.$Tipo ?>"><img src="../i/camera_add.png" width="32" height="32" alt=""/><br />
Cargar Foto</a>
              <?php } ?></td>
            <td width="40%" class="FondoCampo"><?php 
		
		
		
$Nexo = 'Madre'; 
$query_RS_Rp = "SELECT * FROM RepresentanteXAlumno, Representante 
					WHERE RepresentanteXAlumno.CodigoRepresentante = Representante.CodigoRepresentante
					AND RepresentanteXAlumno.Nexo = '$Nexo'
					AND RepresentanteXAlumno.CodigoAlumno = '".$row_RS_Alumnos['CodigoAlumno']."'";
$RS_Rp = mysql_query($query_RS_Rp, $bd) or die(mysql_error());
$row_RS_Rp = mysql_fetch_assoc($RS_Rp);
$totalRows_RS_Rp = mysql_num_rows($RS_Rp);

if ($totalRows_RS_Rp == 0) { // No hay el repre ?>
<span class="MensajeDeError"> 2) <?php echo $Nexo ?> del alumno <img src="../i/user_<?php echo $Nexo ?>.png" alt="" width="32" height="32" border="0" align="absmiddle"> </span><br>
	<?php if($CodigoAnterior[$Nexo] > 0){ // mismo repre?  ?>
        <a href="index.php?Crear=1&Nexo=<?php echo $Nexo ?>&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>&CodigoRepresentante=<?php echo $CodigoAnterior[$Nexo] ?>&SW_Repre=<?php echo $SW_RepreAnterior[$Nexo] ?>">
        Click  si hermanos por parte de <?php echo $Nexo ?>	
        <img src="../i/unit-completed32.png" width="32" height="32" border="0" align="absmiddle"></a><br>
    <?php } ?>
<a href="PlanillaInscRepre.php?Nexo=<?php echo $Nexo ?>&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>"> <?php echo $Nexo ?>  <?php if($CodigoAnterior[$Nexo] > 0){echo " DISTINTO ";} ?>
 Click  para ingresar datos<img src="../i/vcard_add.png" width="32" height="32" border="0" align="absmiddle"></a>
<?php } else { // Si hay un repre
$Dato_OK[$Nexo] = 1; 
$CodigoAnterior[$Nexo] = $row_RS_Rp['CodigoRepresentante'];
$SW_RepreAnterior[$Nexo] = $row_RS_Rp['SW_Representante'];
?><a href="PlanillaInscRepre.php?CodigoRepresentante=<?php echo $row_RS_Rp['CodigoRepresentante']; ?>&Nexo=<?php echo $Nexo ?>&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>">
<img src="../i/user_<?php echo $Nexo ?>.png" width="32" height="32" border="0" align="absmiddle"> <?php echo $row_RS_Rp['Apellidos']; ?>, <?php echo $row_RS_Rp['Nombres']; ?>&nbsp;</a>
             
             
              <?php } ?></td>
            <td width="10%" align="right" class="FondoCampo"><?php 
			  $Tipo = 'm';
			  $foto = "../f/solicitando/".$Codigo.$Tipo.".jpg";
			  if(file_exists($foto)){ ?>
              <img src="<?php echo $foto; ?>" width="80"  /> <br />
              <a href="Sube_Foto.php?CodigoPropietario=<?= $row_RS_Alumnos['CodigoClave'].'&Tipo='.$Tipo ?>"><img src="../i/arrow_refresh_small.png" width="32" height="32" alt=""/>Cambiar</a>
              <?php }else{ ?>
              <a href="Sube_Foto.php?CodigoPropietario=<?= $row_RS_Alumnos['CodigoClave'].'&Tipo='.$Tipo ?>"><img src="../i/camera_add.png" width="32" height="32" alt=""/><br />
Cargar Foto</a>
              <?php } ?></td>
            </tr>
          <tr>
            <td colspan="4" class="NombreCampo">en caso padres divorciados</td>
            </tr>
          <tr>
            <td colspan="2" nowrap="nowrap" class="FondoCampo">Cónyuge del Padre<br>
              <?php 
			
			
			
$Nexo = 'Conyuge Padre'; 

$query_RS_Rp = "SELECT * FROM RepresentanteXAlumno, Representante 
					WHERE RepresentanteXAlumno.CodigoRepresentante = Representante.CodigoRepresentante
					AND RepresentanteXAlumno.Nexo = '$Nexo'
					AND RepresentanteXAlumno.CodigoAlumno = '".$row_RS_Alumnos['CodigoAlumno']."'";

$RS_Rp = mysql_query($query_RS_Rp, $bd) or die(mysql_error());
$row_RS_Rp = mysql_fetch_assoc($RS_Rp);
$totalRows_RS_Rp = mysql_num_rows($RS_Rp);

if ($totalRows_RS_Rp == 0) { ?>

<?php 
if($CodigoAnterior[$Nexo] > 0){
	?>
<a href="index.php?Crear=1&Nexo=<?php echo $Nexo ?>&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>&CodigoRepresentante=<?php echo $CodigoAnterior[$Nexo] ?>&SW_Repre=<?php echo $SW_RepreAnterior[$Nexo] ?>">	
	<?php
	echo "  Click aquí si mismo ".$Nexo."  ";
	?><img src="../i/unit-completed32.png" width="32" height="32" border="0" align="absmiddle"></a><br>
	<?php
	}

?>
<a href="PlanillaInscRepre.php?Nexo=<?php echo $Nexo ?>&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>">  ingresar datos&nbsp;<?php if($CodigoAnterior[$Nexo] > 0){echo " DISTINTO ";} ?> <img src="../i/vcard_add.png" width="32" height="32" border="0" align="absmiddle"></a>
              <?php } else { 
			  $Dato_OK[$Nexo] = 1; 
			  $CodigoAnterior[$Nexo] = $row_RS_Rp['CodigoRepresentante'];
			  $SW_RepreAnterior[$Nexo] = $row_RS_Rp['SW_Representante'];
			  
			  ?><a href="PlanillaInscRepre.php?CodigoRepresentante=<?php echo $row_RS_Rp['CodigoRepresentante']; ?>&Nexo=<?php echo $Nexo ?>&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>">
              <img src="../i/user_female.png" width="32" height="32" border="0" align="absmiddle"> <?php echo $row_RS_Rp['Apellidos']; ?>, <?php echo $row_RS_Rp['Nombres']; ?>&nbsp;</a>
              - <a href="index.php?CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>&EliminaRep=<?php echo $row_RS_Rp['CodigoRepresentante']; ?>">Eliminar</a><?php } 
			  
			  


			  
			   ?></td>
            <td colspan="2" nowrap="nowrap" class="FondoCampo">Cónyuge de la Madre<br>
              <?php 
			
$Nexo = 'Conyuge Madre';

$query_RS_Rp = "SELECT * FROM RepresentanteXAlumno, Representante 
					WHERE RepresentanteXAlumno.CodigoRepresentante = Representante.CodigoRepresentante
					AND RepresentanteXAlumno.Nexo = '$Nexo'
					AND RepresentanteXAlumno.CodigoAlumno = '".$row_RS_Alumnos['CodigoAlumno']."'";

$RS_Rp = mysql_query($query_RS_Rp, $bd) or die(mysql_error());
$row_RS_Rp = mysql_fetch_assoc($RS_Rp);
$totalRows_RS_Rp = mysql_num_rows($RS_Rp);

if ($totalRows_RS_Rp == 0) { ?>

<?php 
if($CodigoAnterior[$Nexo] > 0){
	?>
<a href="index.php?Crear=1&Nexo=<?php echo $Nexo ?>&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>&CodigoRepresentante=<?php echo $CodigoAnterior[$Nexo] ?>&SW_Repre=<?php echo $SW_RepreAnterior[$Nexo] ?>">	
	<?php
	echo "  Click aquí si mismo ".$Nexo."  ";
	?><img src="../i/unit-completed32.png" width="32" height="32" border="0" align="absmiddle"></a><br>
	<?php
	}

?>
<a href="PlanillaInscRepre.php?Nexo=<?php echo $Nexo ?>&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>">  ingresar datos&nbsp;<?php if($CodigoAnterior[$Nexo] > 0){echo " DISTINTO ";} ?> <img src="../i/vcard_add.png" width="32" height="32" border="0" align="absmiddle"></a>
              <?php } else { 
			  $Dato_OK[$Nexo] = 1; 
			  $CodigoAnterior[$Nexo] = $row_RS_Rp['CodigoRepresentante'];
			  $SW_RepreAnterior[$Nexo] = $row_RS_Rp['SW_Representante'];
			  
			  ?><a href="PlanillaInscRepre.php?CodigoRepresentante=<?php echo $row_RS_Rp['CodigoRepresentante']; ?>&Nexo=<?php echo $Nexo ?>&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>">
              <img src="../i/user_suit.png" width="32" height="32" border="0" align="absmiddle"> <?php echo $row_RS_Rp['Apellidos']; ?>, <?php echo $row_RS_Rp['Nombres']; ?>&nbsp;</a>
              - <a href="index.php?CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>&EliminaRep=<?php echo $row_RS_Rp['CodigoRepresentante']; ?>">Eliminar</a><?php } 
			  

			  
			  
			  ?></td>
            </tr>
          <tr>
            <td colspan="4" class="NombreCampoBIG">Datos de los Abuelos (est&eacute;n vivos o no)</td>
            </tr>
          <tr>
            <td align="right" class="NombreCampo">Abuelo Paterno</td>
            <td class="NombreCampo">Abuela Paterna</td>
            <td align="right" class="NombreCampo">Abuelo Materno</td>
            <td align="left" class="NombreCampo">Abuela Materno</td>
          </tr>
          <tr>
            <td align="right" nowrap="nowrap" class="FondoCampo"><?php 
			
			
			
$Nexo = 'Abuelo Paterno'; 
$img  = 'Abuelo';
$query_RS_Rp = "SELECT * FROM RepresentanteXAlumno, Abuelos 
					WHERE RepresentanteXAlumno.CodigoRepresentante = Abuelos.CodigoAbuelo
					AND RepresentanteXAlumno.Nexo = '$Nexo'
					AND RepresentanteXAlumno.CodigoAlumno = '".$row_RS_Alumnos['CodigoAlumno']."'";
$RS_Rp = mysql_query($query_RS_Rp, $bd) or die(mysql_error());
$row_RS_Rp = mysql_fetch_assoc($RS_Rp);
$totalRows_RS_Rp = mysql_num_rows($RS_Rp);

if ($totalRows_RS_Rp == 0) { // No hay el repre ?>
<span class="MensajeDeError"><?php echo $Nexo ?> <img src="../i/user_<?php echo $img ?>.png" alt="" width="32" height="32" border="0" align="absmiddle"> </span><br>
	<?php if($CodigoAnterior[$Nexo] > 0){ // mismo repre?  ?>
        <a href="index.php?Crear=1&Nexo=<?php echo $Nexo ?>&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>&CodigoRepresentante=<?php echo $CodigoAnterior[$Nexo] ?>&SW_Repre=<?php echo $SW_RepreAnterior[$Nexo] ?>">
        Click  si <br>mismo <?php echo $Nexo ?><br>
        <img src="../i/unit-completed32.png" width="32" height="32" border="0" align="absmiddle"></a><br>
    <?php } ?>
<a href="PlanillaInscAbuelo.php?Nexo=<?php echo $Nexo ?>&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>"> 
Click  para ingresar datos  <br><?php echo $Nexo ?> <?php if($CodigoAnterior[$Nexo] > 0){echo " DISTINTO ";} ?> <br><img src="../i/vcard_add.png" width="32" height="32" border="0" align="absmiddle"></a>
<?php } else { // Si hay un repre
$Dato_OK[$Nexo] = 1; 
$CodigoAnterior[$Nexo] = $row_RS_Rp['CodigoRepresentante'];
$SW_RepreAnterior[$Nexo] = $row_RS_Rp['SW_Representante'];
?><a href="PlanillaInscAbuelo.php?CodigoRepresentante=<?php echo $row_RS_Rp['CodigoRepresentante']; ?>&Nexo=<?php echo $Nexo ?>&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>">
<?php echo $row_RS_Rp['Nombres']; ?>&nbsp;<img src="../i/user_<?php echo $img ?>.png" width="32" height="32" border="0" align="absmiddle"></a>
              <?php } 

	  
	  ?></td>
            <td nowrap="nowrap" class="FondoCampo"><?php 
			
$Nexo = 'Abuela Paterna'; 
$img  = 'Abuela';
$query_RS_Rp = "SELECT * FROM RepresentanteXAlumno, Abuelos 
					WHERE RepresentanteXAlumno.CodigoRepresentante = Abuelos.CodigoAbuelo
					AND RepresentanteXAlumno.Nexo = '$Nexo'
					AND RepresentanteXAlumno.CodigoAlumno = '".$row_RS_Alumnos['CodigoAlumno']."'";
$RS_Rp = mysql_query($query_RS_Rp, $bd) or die(mysql_error());
$row_RS_Rp = mysql_fetch_assoc($RS_Rp);
$totalRows_RS_Rp = mysql_num_rows($RS_Rp);

if ($totalRows_RS_Rp == 0) { // No hay el repre ?>
<span class="MensajeDeError"> <img src="../i/user_<?php echo $img ?>.png" alt="" width="32" height="32" border="0" align="absmiddle"> <?php echo $Nexo ?></span><br>
	<?php if($CodigoAnterior[$Nexo] > 0){ // mismo repre?  ?>
        <a href="index.php?Crear=1&Nexo=<?php echo $Nexo ?>&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>&CodigoRepresentante=<?php echo $CodigoAnterior[$Nexo] ?>&SW_Repre=<?php echo $SW_RepreAnterior[$Nexo] ?>">
        Click  si <br>mismo <?php echo $Nexo ?><br>
        <img src="../i/unit-completed32.png" width="32" height="32" border="0" align="absmiddle"></a><br>
    <?php } ?>
<a href="PlanillaInscAbuelo.php?Nexo=<?php echo $Nexo ?>&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>"> 
Click  para ingresar datos  <br><?php echo $Nexo ?> <?php if($CodigoAnterior[$Nexo] > 0){echo " DISTINTO ";} ?> <br><img src="../i/vcard_add.png" width="32" height="32" border="0" align="absmiddle"></a>
<?php } else { // Si hay un repre
$Dato_OK[$Nexo] = 1; 
$CodigoAnterior[$Nexo] = $row_RS_Rp['CodigoRepresentante'];
$SW_RepreAnterior[$Nexo] = $row_RS_Rp['SW_Representante'];
?><a href="PlanillaInscAbuelo.php?CodigoRepresentante=<?php echo $row_RS_Rp['CodigoRepresentante']; ?>&Nexo=<?php echo $Nexo ?>&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>">
<img src="../i/user_<?php echo $img ?>.png" width="32" height="32" border="0" align="absmiddle"><?php echo $row_RS_Rp['Nombres']; ?>&nbsp;</a>
              <?php } 



 ?></td>
            <td align="right" nowrap="nowrap" class="FondoCampo"><?php 
			
		
$Nexo = 'Abuelo Materno'; 
$img  = 'Abuelo';
$query_RS_Rp = "SELECT * FROM RepresentanteXAlumno, Abuelos 
					WHERE RepresentanteXAlumno.CodigoRepresentante = Abuelos.CodigoAbuelo
					AND RepresentanteXAlumno.Nexo = '$Nexo'
					AND RepresentanteXAlumno.CodigoAlumno = '".$row_RS_Alumnos['CodigoAlumno']."'";
$RS_Rp = mysql_query($query_RS_Rp, $bd) or die(mysql_error());
$row_RS_Rp = mysql_fetch_assoc($RS_Rp);
$totalRows_RS_Rp = mysql_num_rows($RS_Rp);

if ($totalRows_RS_Rp == 0) { // No hay el repre ?>
<span class="MensajeDeError"> <?php echo $Nexo ?><img src="../i/user_<?php echo $img ?>.png" alt="" width="32" height="32" border="0" align="absmiddle"> </span><br>
	<?php if($CodigoAnterior[$Nexo] > 0){ // mismo repre?  ?>
        <a href="index.php?Crear=1&Nexo=<?php echo $Nexo ?>&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>&CodigoRepresentante=<?php echo $CodigoAnterior[$Nexo] ?>&SW_Repre=<?php echo $SW_RepreAnterior[$Nexo] ?>">
        Click  si <br>mismo <?php echo $Nexo ?><br>
        <img src="../i/unit-completed32.png" width="32" height="32" border="0" align="absmiddle"></a><br>
    <?php } ?>
<a href="PlanillaInscAbuelo.php?Nexo=<?php echo $Nexo ?>&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>"> 
Click  para ingresar datos  <br><?php echo $Nexo ?> <?php if($CodigoAnterior[$Nexo] > 0){echo " DISTINTO ";} ?> <br><img src="../i/vcard_add.png" width="32" height="32" border="0" align="absmiddle"></a>
<?php } else { // Si hay un repre
$Dato_OK[$Nexo] = 1; 
$CodigoAnterior[$Nexo] = $row_RS_Rp['CodigoRepresentante'];
$SW_RepreAnterior[$Nexo] = $row_RS_Rp['SW_Representante'];
?><a href="PlanillaInscAbuelo.php?CodigoRepresentante=<?php echo $row_RS_Rp['CodigoRepresentante']; ?>&Nexo=<?php echo $Nexo ?>&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>">
<?php echo $row_RS_Rp['Nombres']; ?>&nbsp;<img src="../i/user_<?php echo $img ?>.png" width="32" height="32" border="0" align="absmiddle"></a>
              <?php } 


			  
			   ?></td>
            <td nowrap="nowrap" class="FondoCampo"><?php 

	
$Nexo = 'Abuela Materna'; 
$img  = 'Abuela';
$query_RS_Rp = "SELECT * FROM RepresentanteXAlumno, Abuelos 
					WHERE RepresentanteXAlumno.CodigoRepresentante = Abuelos.CodigoAbuelo
					AND RepresentanteXAlumno.Nexo = '$Nexo'
					AND RepresentanteXAlumno.CodigoAlumno = '".$row_RS_Alumnos['CodigoAlumno']."'";
$RS_Rp = mysql_query($query_RS_Rp, $bd) or die(mysql_error());
$row_RS_Rp = mysql_fetch_assoc($RS_Rp);
$totalRows_RS_Rp = mysql_num_rows($RS_Rp);

if ($totalRows_RS_Rp == 0) { // No hay el repre ?>
<span class="MensajeDeError"><img src="../i/user_<?php echo $img ?>.png" alt="" width="32" height="32" border="0" align="absmiddle"> <?php echo $Nexo ?> </span><br>
	<?php if($CodigoAnterior[$Nexo] > 0){ // mismo repre?  ?>
        <a href="index.php?Crear=1&Nexo=<?php echo $Nexo ?>&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>&CodigoRepresentante=<?php echo $CodigoAnterior[$Nexo] ?>&SW_Repre=<?php echo $SW_RepreAnterior[$Nexo] ?>">
        Click  si <br>mismo <?php echo $Nexo ?><br>
        <img src="../i/unit-completed32.png" width="32" height="32" border="0" align="absmiddle"></a><br>
    <?php } ?>
<a href="PlanillaInscAbuelo.php?Nexo=<?php echo $Nexo ?>&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>"> 
Click  para ingresar datos  <br><?php echo $Nexo ?> <?php if($CodigoAnterior[$Nexo] > 0){echo " DISTINTO ";} ?> <br><img src="../i/vcard_add.png" width="32" height="32" border="0" align="absmiddle"></a>
<?php } else { // Si hay un repre
$Dato_OK[$Nexo] = 1; 
$CodigoAnterior[$Nexo] = $row_RS_Rp['CodigoRepresentante'];
$SW_RepreAnterior[$Nexo] = $row_RS_Rp['SW_Representante'];
?><a href="PlanillaInscAbuelo.php?CodigoRepresentante=<?php echo $row_RS_Rp['CodigoRepresentante']; ?>&Nexo=<?php echo $Nexo ?>&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>">
<img src="../i/user_<?php echo $img ?>.png" width="32" height="32" border="0" align="absmiddle"><?php echo $row_RS_Rp['Nombres']; ?>&nbsp;</a>
              <?php } 
			  
			  ?></td>
          </tr>
          <tr>
            <td colspan="4" class="NombreCampoBIG">Personas Autorizadas: (no incluir Padre ni Madre) <a href="Sube_Foto.php?CodigoPropietario=<?= $row_RS_Alumnos['CodigoClave']; ?>">fotos</a></td>
            </tr>
          <tr>
            <td colspan="4" class="FondoCampo"><?php 
			

$Nexo = 'Autorizado'; 
$query_RS_Rp = "SELECT * FROM RepresentanteXAlumno, Representante 
					WHERE RepresentanteXAlumno.CodigoRepresentante = Representante.CodigoRepresentante
					AND RepresentanteXAlumno.Nexo = '$Nexo'
					AND RepresentanteXAlumno.CodigoAlumno = '".$row_RS_Alumnos['CodigoAlumno']."'";

/*$query_RS_Rp = "SELECT * FROM RepresentanteXAlumno, Representante 
					WHERE RepresentanteXAlumno.CodigoRepresentante = Representante.CodigoRepresentante
					AND RepresentanteXAlumno.Nexo = '$Nexo'
					AND Representante.Creador = '$MM_Username'
					GROUP BY Representante.CodigoRepresentante";
					//echo $query_RS_Rp;*/
$RS_Rp = mysql_query($query_RS_Rp, $bd) or die(mysql_error());
$row_RS_Rp = mysql_fetch_assoc($RS_Rp);
$totalRows_RS_Rp = mysql_num_rows($RS_Rp);

if ($totalRows_RS_Rp == 0) {  ?>
              <span class="ConflictoHorario"> Agregue a las personas autorizadas <img src="../i/reseller_programm.png" alt="" width="32" height="32" align="absmiddle"> <a href="PlanillaInscAutorizado.php?Nexo=Autorizado&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>">Clik Aqu&iacute;&nbsp;<img src="../i/vcard_edit.png" alt="" width="32" height="32" border="0" align="absmiddle"></a> </span>
              <?php } else { ?>
              <?php do { ?><a href="PlanillaInscAutorizado.php?CodigoRepresentante=<?php echo $row_RS_Rp['CodigoRepresentante']; ?>&Nexo=Autorizado&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>">
              <img src="../i/user.png" alt="" width="32" height="32" border="0" align="absmiddle"><?php echo $row_RS_Rp['Apellidos']; ?>, <?php echo $row_RS_Rp['Nombres']; ?> (<?php echo $row_RS_Rp['Ocupacion']; ?>)&nbsp;<img src="../i/vcard_edit.png" width="32" height="32" border="0" align="absmiddle"></a> - <a href="index.php?noAutorizano=1&CodigoAutorizado=<?php echo $row_RS_Rp['CodigoRepresentante']; ?>&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>"> Eliminar</a><br>
              <?php } while ($row_RS_Rp = mysql_fetch_assoc($RS_Rp)); ?></td>
          </tr>
          <tr>
            <td colspan="4" class="FondoCampo">
Para agregar autorizados
      haga <a href="PlanillaInscAutorizado.php?Nexo=Autorizado&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>">Clik Aqu&iacute;<img src="../i/vcard_add.png" width="32" height="32" align="absmiddle"></a>
      <?php } ?>
&nbsp;</td>
          </tr>
          <tr>
        <td colspan="4"><?php 
		
$StatusAnoProx = $StatusAnoActual = "";		
		
$PlanillaOK = true;	
foreach(array('Padre','Madre','Abuelo Paterno','Abuela Paterna','Abuelo Materno','Abuela Materna') as $Nexo)
	if($Dato_OK[$Nexo] != 1) $PlanillaOK = false;	
		
		
		$StatusAnoActual = $StatusAnoProx = "";
		
		$sql = "SELECT * FROM AlumnoXCurso 
				WHERE CodigoAlumno='".$row_RS_Alumnos['CodigoAlumno']."' 
				AND Ano='".$AnoEscolar."' ";
		//echo $sql."<br>";
		$RS_sql = 	mysql_query($sql, $bd) or die(mysql_error());
		if($row_RS = mysql_fetch_assoc($RS_sql))
			$StatusAnoActual = $row_RS['Status'];
		//echo $StatusAnoActual."<br>";
		
		$sql = "SELECT * FROM AlumnoXCurso 
				WHERE CodigoAlumno='".$row_RS_Alumnos['CodigoAlumno']."' 
				AND Ano='".$AnoEscolarProx."' ";
		//echo $sql."<br>";
		$RS_sql = 	mysql_query($sql, $bd) or die(mysql_error());
		if($row_RS = mysql_fetch_assoc($RS_sql))
			$StatusAnoProx = $row_RS['Status'];
		//echo $StatusAnoProx."<br>";
		
		//echo $PlanillaOK."<br>";
		//echo $row_RS_Alumnos['Deuda_Actual']."<br>";
		//echo $totalRows_Pendiente."<br>";
echo $StatusAnoProx .' . prox '. $row_RS_Alumnos['Deuda_Actual'] . '<br>' ;

/*
$Deuda_Actual_SQL = "SELECT * FROM ContableMov 
					 WHERE CodigoPropietario = '".$row_RS_Alumno['CodigoAlumno']."'
					 AND ReferenciaMesAno = 'Ins 16'";
$RS_Deuda_Actual = mysql_query($Deuda_Actual_SQL, $bd) or die(mysql_error());
$Deuda_Actual = $row_RS_Alumno['Deuda_Actual'];
if($row_Deuda_Actual = mysql_fetch_assoc($RS_Deuda_Actual)){
	$Deuda_Actual = 0;}
*/

if( $PlanillaOK ){
		
if($StatusAnoProx == "Solicitando" ){
	
			
	$query_Pago_Solicitud = "SELECT * FROM ContableMov 
							 WHERE CodigoPropietario = '".$row_RS_Alumnos['CodigoAlumno']."'
							 AND ReferenciaMesAno = 'Sol ".$AnoEscolarProx."'
							";  // AND CodigoRecibo > 0
	//echo $query_Pago_Solicitud;					 
	$Pago_Solicitud = mysql_query($query_Pago_Solicitud, $bd) or die(mysql_error());
	$row_Pago_Solicitud = mysql_fetch_assoc($Pago_Solicitud);
	$totalRows_Pago_Solicitud = mysql_num_rows($Pago_Solicitud);
			
			
	if($totalRows_Pago_Solicitud > 0)	{ 
	?>
             
 <!-- PLANILLA DE SOLICITUD-->            
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td nowrap class="FondoCampoVerdeGde"><a href="PlanillaSolicitaCupo_pdf.php?CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoClave']; ?>" target="_blank">
    <img src="../i/printer.png" alt="" width="32" height="32" border="0" align="absmiddle">&nbsp; 
    <span>Imprimir Planilla de Solicitud de Cupo (<?php  echo $row_RS_Alumnos['Nombres']." ".$row_RS_Alumnos['Nombres2']; ?>)</span></a></td>
    <td align="right">
        <a href="http://get.adobe.com/es/reader/" class="expanded">
        Necesita tener instalado <br>
        el adobe reader <br>
        para abrir la planilla<br>
        <img src="../img/get_adobe_reader.gif" alt="" width="88" height="31" border="0"></a>
    </td>
  </tr>
</table>
        
        
        <?php  }
		
		}
	
	
	
elseif($StatusAnoProx == "Aceptado" or $StatusAnoActual == "Aceptado" or $StatusAnoActual == "Inscrito"){
			
				 ?>
        
 <!-- PLANILLA DE INSCRIPCION-->         
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="FondoCampoVerdeGde">
    
    <?php if($SW_Actualizar){?>
    <span class="MensajeDeError">debe ACTUALIZAR los datos del alumno y padres<br>para imprimir la planilla</span>
<?php }else{?>
    
    <a href="Imprimir_Planilla.php?CodigoPropietario=<?php echo $row_RS_Alumnos['CodigoClave']; ?>">
    <img src="../i/printer.png" alt="" width="32" height="32" border="0" align="absmiddle">&nbsp; 
    <span>Imprimir <strong>Planilla de INSCRIPCIÓN</strong> (<?php  echo $row_RS_Alumnos['Nombres']." ".$row_RS_Alumnos['Nombres2']; ?>) </span></a><?php } ?></td>
    <td align="right"><a href="http://get.adobe.com/es/reader/" class="expanded">
        Necesita tener instalado <br>
        el adobe reader <br>
        para abrir la planilla<br>
        <img src="../img/get_adobe_reader.gif" alt="" width="88" height="31" border="0"></a>
   	</td>
  </tr>
</table>
		
		<?php }	} ?></td>
        </tr>
        
<?php if( !$PlanillaOK ) { ?>        
        <tr>
          <td colspan="4"><?php
foreach(array('Padre','Madre','Abuelo Paterno','Abuela Paterna','Abuelo Materno','Abuela Materna') as $Nexo)
	if($Dato_OK[$Nexo]=='') {
		echo '<p class="MensajeDeError">Faltan datos de '.$Nexo.'</p>';}
?>&nbsp;</td>
        </tr>
<?php } ?>

        <tr>
          <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4">&nbsp; </td>
        </tr>
		<?php } while ($row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos)); ?>
      <?php if(date('Y-m-d') > $Fecha_Inicio_Solicitud_Cupo ){ ?>   
         <tr>
          <td colspan="4"><a href="PlanillaInscAlum.php" class="navLinkAct">
              <img src="../i/group_add.png" alt="" width="32" height="32" border="0" align="middle">
              Crear Registro de Alumno Nuevo</a>
          </td>
        </tr>
         <?php }else{ ?>
         <tr>
           <td colspan="4" class="FondoCampoVerdeGde">El Proceso de Nuevos Ingresos  inicia el Lunes 18</td>
         </tr>
         <?php } ?>
      </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  
<?php if (false){ ?>  
<?php } ?>
  
  <tr>
    <td align="center" class="TextosSimples">Si necesita asistencia con el uso del sistema, <br>
      env&iacute;e un email a: <a href="mailto:piero@sanfrancisco.e12.ve">piero@sanfrancisco.e12.ve</a> o <br>
       por Whatsapp  0414.303.44.44</td>
  </tr>
</table></td>
            <td width="31" bgcolor="#FFF8E8">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#DBBE96">&nbsp;</td>
            <td valign="top" bgcolor="#EECCA6" class="medium">&nbsp;</td>
            <td bgcolor="#FFF8E8">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#FFF8E8">&nbsp;</td>
            <td valign="top">&nbsp;</td>
            <td bgcolor="#FFF8E8">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#FFF8E8">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td width="31" bgcolor="#FFF8E8">&nbsp;</td>
          </tr>
        </table>
		  <p>&nbsp;</p>
	    <p>&nbsp;</p></td>
  </tr>
	<tr>
		<td colspan="4" align="center" bgcolor="#54587D">
			<p><img src="../img/Pie1.jpg" width="1025" height="9" alt=""></p></td>
	</tr>
	<tr>
		<td bgcolor="#0A1B69">
			<img src="../img/PieA.jpg" width="31" height="58" alt=""></td>
		<td colspan="2" align="center" bgcolor="#0A1B69"><strong class="medium"><font color="#FFFFFF">Todos los derechos reservados Colegio San Francisco de As&iacute;s &copy; 2010</font> </td>
<td align="right" bgcolor="#0A1B69">
			<img src="../img/PieB.jpg" width="31" height="58" alt=""></td>
	</tr>
</table>
<!-- End ImageReady Slices -->
<?php //include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>
</body>
</html><?php } ?>