<?php 
if(true){
$MM_authorizedUsers = "2,99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable,provee";
$SW_omite_trace = false;
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

	
	

	
	
if(isset($_GET['CodigoAlumno'])){
		$sql = "SELECT * FROM AlumnoXCurso 
				WHERE CodigoAlumno='".$_GET['CodigoAlumno']."' 
				AND Ano='".$AnoEscolarProx."' ";
		$RS_sql = $mysqli->query($sql);
		$totalRows_RS = $RS_sql->num_rows;
	
		if($totalRows_RS == 0){
			$sql = "SELECT * FROM AlumnoXCurso 
					WHERE CodigoAlumno='".$_GET['CodigoAlumno']."' 
					AND Ano='".$AnoEscolar."' 
					AND Status = 'Inscrito'";
			
			
			
			$RS_sql = $mysqli->query($sql);
			$row_ = $RS_sql->fetch_assoc();
			$totalRows_RS = $RS_sql->num_rows;
			
			
			
			
			if($totalRows_RS == 1){
				$aux_Status = "Aceptado";
				$CodigoCurso = CodigoCursoProx($row_['CodigoCurso']);
			}else{
				$aux_Status = "Solicitando";
				$CodigoCurso = 44;
				}
						
			
				$sql = sprintf("INSERT INTO AlumnoXCurso (CodigoAlumno, Ano, CodigoCurso, Status, Status_por ) 
								VALUES (%s, %s, %s, %s, %s)",
							   GetSQLValueString($_GET['CodigoAlumno'], "text"),
							   GetSQLValueString($AnoEscolarProx, "text"),
							   GetSQLValueString($CodigoCurso, "text"),
							   GetSQLValueString($aux_Status, "text"),
							   GetSQLValueString($MM_Username, "text"));
				$mysqli->query($sql);
				 // $Result1 = mysql_query($sql, $bd) or die(mysql_error());
		//echo $sql.'<br>';	
				  
			}		
}


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO Alumno (Creador, CodigoFMP, Cedula, CedulaLetra, Nombres, Nombres2, Apellidos, Apellidos2, Sexo, FechaNac, Nacionalidad, ClinicaDeNac, Localidad, Entidad, Direccion, Urbanizacion, Ciudad, CodPostal, ViveCon, Email1, Email2, TelHab, TelCel, ColegioProcedencia, ColegioProcedenciaTelefono, CiudadColProc, MotivoRetiroColProced, PerEmergencia, PerEmerTel, PerEmerNexo, Peso, Vacunas, Enfermedades, TratamientoMed, AlergicoA, Observaciones, HaSolicitado , HaSolicitadoObs, TienePsicologo, TienePsicologoObs, RepresentanteAdministrativo, RepresentanteAdministrativoObs, HermanoSolicitando, HermanoCursando, HijoDeExalumno , HermanoCursandoObs, HijoDeExalumnoObs ,ReferenciasPersonales, Datos_Revisado_Fecha) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Creador'], "text"),
                       GetSQLValueString($_POST['CodigoFMP'], "text"),
                       GetSQLValueString($_POST['Cedula'], "text"),
                       GetSQLValueString($_POST['CedulaLetra'], "text"),
                       GetSQLValueString(ucwords(strtolower($_POST['Nombres'])), "text"),
                       GetSQLValueString(ucwords(strtolower($_POST['Nombres2'])), "text"),
                       GetSQLValueString(ucwords(strtolower($_POST['Apellidos'])), "text"),
                       GetSQLValueString(ucwords(strtolower($_POST['Apellidos2'])), "text"),
                       GetSQLValueString($_POST['Sexo'], "text"),
                       GetSQLValueString($_POST['FechaNac'], "date"),
                       GetSQLValueString($_POST['Nacionalidad'], "text"),
                       GetSQLValueString($_POST['ClinicaDeNac'], "text"),
                       GetSQLValueString($_POST['Localidad'], "text"),
                       GetSQLValueString($_POST['Entidad'], "text"),
                       GetSQLValueString($_POST['Direccion'], "text"),
                       GetSQLValueString($_POST['Urbanizacion'], "text"),
                       GetSQLValueString($_POST['Ciudad'], "text"),
                       GetSQLValueString($_POST['CodPostal'], "text"),
                       GetSQLValueString($_POST['ViveCon'], "text"),
                       GetSQLValueString($_POST['Email1'], "text"),
                       GetSQLValueString($_POST['Email2'], "text"),
                       GetSQLValueString($_POST['TelHab'], "text"),
                       GetSQLValueString($_POST['TelCel'], "text"),
                       GetSQLValueString($_POST['ColegioProcedencia'], "text"),
                       GetSQLValueString($_POST['ColegioProcedenciaTelefono'], "text"),
                       GetSQLValueString($_POST['CiudadColProc'], "text"),
                       GetSQLValueString($_POST['MotivoRetiroColProced'], "text"),
                       GetSQLValueString($_POST['PerEmergencia'], "text"),
                       GetSQLValueString($_POST['PerEmerTel'], "text"),
                       GetSQLValueString($_POST['PerEmerNexo'], "text"),
                       GetSQLValueString($_POST['Peso'], "text"),
                       GetSQLValueString($_POST['Vacunas'], "text"),
                       GetSQLValueString($_POST['Enfermedades'], "text"),
                       GetSQLValueString($_POST['TratamientoMed'], "text"),
                       GetSQLValueString($_POST['AlergicoA'], "text"),
                       GetSQLValueString($_POST['Observaciones'], "text"),
                       GetSQLValueString($_POST['HaSolicitado'], "text"),
                       GetSQLValueString($_POST['HaSolicitadoObs'], "text"),
                       GetSQLValueString($_POST['TienePsicologo'], "text"),
                       GetSQLValueString($_POST['TienePsicologoObs'], "text"),
                       GetSQLValueString($_POST['RepresentanteAdministrativo'], "text"),
                       GetSQLValueString($_POST['RepresentanteAdministrativoObs'], "text"),
                       GetSQLValueString($_POST['HermanoSolicitando'], "text"),
                       GetSQLValueString($_POST['HermanoCursando'], "text"),
                       GetSQLValueString($_POST['HijoDeExalumno'], "text"),
                       GetSQLValueString($_POST['HermanoCursandoObs'], "text"),
                       GetSQLValueString($_POST['HijoDeExalumnoObs'], "text"),
                       GetSQLValueString($_POST['ReferenciasPersonales'], "text"),
					   GetSQLValueString(date('Y-m-d'), "date"));
	$Result1 = $mysqli->query($insertSQL);
	
	
 // $Result1 = mysql_query($insertSQL, $bd) or die(mysql_error());

	$CodigoAlumnoNuevo = $mysqli->insert_id; //mysql_insert_id();

  $insertSQL = sprintf("INSERT INTO AlumnoXCurso (CodigoAlumno, Ano, CodigoCurso, Status ) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($CodigoAlumnoNuevo, "text"),
                       GetSQLValueString($AnoEscolarProx, "text"),
                       GetSQLValueString($_POST['CodigoCurso'], "text"),
                       GetSQLValueString('Solicitando', "text"));
	$Result1 = $mysqli->query($insertSQL);
 // $Result1 = mysql_query($insertSQL, $bd) or die(mysql_error());





  $insertGoTo = "index.php";
/*  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {

  $updateSQL = sprintf("UPDATE Alumno SET Cedula=%s, CedulaLetra=%s, Nombres=%s, Nombres2=%s, Apellidos=%s, Apellidos2=%s, Sexo=%s, FechaNac=%s, Nacionalidad=%s, ClinicaDeNac=%s, Localidad=%s, Entidad=%s, Direccion=%s, Urbanizacion=%s, Ciudad=%s, CodPostal=%s, ViveCon=%s, Email1=%s, Email2=%s, TelHab=%s, TelCel=%s, ColegioProcedencia=%s, ColegioProcedenciaTelefono=%s, CiudadColProc=%s, MotivoRetiroColProced=%s, PerEmergencia=%s, PerEmerTel=%s, PerEmerNexo=%s, Peso=%s, Vacunas=%s, Enfermedades=%s, TratamientoMed=%s, AlergicoA=%s, Observaciones=%s, HaSolicitado=%s , HaSolicitadoObs=%s, TienePsicologo=%s, TienePsicologoObs=%s, RepresentanteAdministrativo=%s, RepresentanteAdministrativoObs=%s, HermanoSolicitando=%s, HermanoCursando=%s, HijoDeExalumno=%s, HermanoCursandoObs=%s, HijoDeExalumnoObs=%s ,ReferenciasPersonales=%s, Datos_Revisado_Fecha=%s WHERE CodigoAlumno=%s",
                       GetSQLValueString($_POST['Cedula'], "text"),
                       GetSQLValueString($_POST['CedulaLetra'], "text"),
                       GetSQLValueString(ucwords(strtolower($_POST['Nombres'])), "text"),
                       GetSQLValueString(ucwords(strtolower($_POST['Nombres2'])), "text"),
                       GetSQLValueString(ucwords(strtolower($_POST['Apellidos'])), "text"),
                       GetSQLValueString(ucwords(strtolower($_POST['Apellidos2'])), "text"),
                       GetSQLValueString($_POST['Sexo'], "text"),
                       GetSQLValueString($_POST['FechaNac'], "date"),
                       GetSQLValueString($_POST['Nacionalidad'], "text"),
                       GetSQLValueString($_POST['ClinicaDeNac'], "text"),
                       GetSQLValueString($_POST['Localidad'], "text"),
                       GetSQLValueString($_POST['Entidad'], "text"),
                       GetSQLValueString($_POST['Direccion'], "text"),
                       GetSQLValueString($_POST['Urbanizacion'], "text"),
                       GetSQLValueString($_POST['Ciudad'], "text"),
                       GetSQLValueString($_POST['CodPostal'], "text"),
                       GetSQLValueString($_POST['ViveCon'], "text"),
                       GetSQLValueString($_POST['Email1'], "text"),
                       GetSQLValueString($_POST['Email2'], "text"),
                       GetSQLValueString($_POST['TelHab'], "text"),
                       GetSQLValueString($_POST['TelCel'], "text"),
                       GetSQLValueString($_POST['ColegioProcedencia'], "text"),
                       GetSQLValueString($_POST['ColegioProcedenciaTelefono'], "text"),
                       GetSQLValueString($_POST['CiudadColProc'], "text"),
                       GetSQLValueString($_POST['MotivoRetiroColProced'], "text"),
                       GetSQLValueString($_POST['PerEmergencia'], "text"),
                       GetSQLValueString($_POST['PerEmerTel'], "text"),
                       GetSQLValueString($_POST['PerEmerNexo'], "text"),
                       GetSQLValueString($_POST['Peso'], "text"),
                       GetSQLValueString($_POST['Vacunas'], "text"),
                       GetSQLValueString($_POST['Enfermedades'], "text"),
                       GetSQLValueString($_POST['TratamientoMed'], "text"),
                       GetSQLValueString($_POST['AlergicoA'], "text"),
                       GetSQLValueString($_POST['Observaciones'], "text"),
                       GetSQLValueString($_POST['HaSolicitado'], "text"),
                       GetSQLValueString($_POST['HaSolicitadoObs'], "text"),
                       GetSQLValueString($_POST['TienePsicologo'], "text"),
                       GetSQLValueString($_POST['TienePsicologoObs'], "text"),
                       GetSQLValueString($_POST['RepresentanteAdministrativo'], "text"),
                       GetSQLValueString($_POST['RepresentanteAdministrativoObs'], "text"),
                       GetSQLValueString($_POST['HermanoSolicitando'], "text"),
                       GetSQLValueString($_POST['HermanoCursando'], "text"),
                       GetSQLValueString($_POST['HijoDeExalumno'], "text"),
                       GetSQLValueString($_POST['HermanoCursandoObs'], "text"),
                       GetSQLValueString($_POST['HijoDeExalumnoObs'], "text"),
                       GetSQLValueString($_POST['ReferenciasPersonales'], "text"),
					   GetSQLValueString(date('Y-m-d'), "date"),
                       GetSQLValueString($_POST['CodigoAlumno'], "int"));
	$Result1 = $mysqli->query($updateSQL);	
	//echo $updateSQL;
 // $Result1 = mysql_query($updateSQL, $bd) or die(mysql_error());


$sql = "SELECT * FROM AlumnoXCurso 
		WHERE CodigoAlumno='".$_POST['CodigoAlumno']."' 
		AND Ano='".$AnoEscolarProx."' ";


$RS_sql = $mysqli->query($sql);
$totalRows_RS = $RS_sql->num_rows;	
	
	/*
$RS_sql = 	mysql_query($sql, $bd) or die(mysql_error());
$totalRows_RS = mysql_num_rows($RS_sql);*/
	
if($totalRows_RS == 1){
	$sql = "UPDATE AlumnoXCurso SET CodigoCurso = '".$_POST['CodigoCurso']."' 
			WHERE CodigoAlumno = '".$_POST['CodigoAlumno']."'
			AND Ano='".$AnoEscolarProx."'";}
else{
	
	$sql = "SELECT * FROM AlumnoXCurso 
			WHERE CodigoAlumno='".$_POST['CodigoAlumno']."' 
			AND Ano='".$AnoEscolarAnte."' 
			AND Status = 'Inscrito'";
	$RS_sql = $mysqli->query($sql);
$totalRows_RS = $RS_sql->num_rows;	
	
	/*$RS_sql = 	mysql_query($sql, $bd) or die(mysql_error());
	$totalRows_RS = mysql_num_rows($RS_sql);
	*/
	if($totalRows_RS == 1){
		$aux_Status = "Aceptado";}
	else{
		$aux_Status = "Solicitando";}
	
	$sql = sprintf("INSERT INTO AlumnoXCurso (CodigoAlumno, Ano, CodigoCurso, Status ) VALUES (%s, %s, %s, %s)",
					   GetSQLValueString($_POST['CodigoAlumno'], "text"),
					   GetSQLValueString($AnoEscolar, "text"),
					   GetSQLValueString($_POST['CodigoCurso'], "text"),
					   GetSQLValueString($aux_Status, "text"));
	}		
  $Result1 = $mysqli->query($sql);			 //$Result1 = mysql_query($sql, $bd) or die(mysql_error());


  $updateGoTo = "index.php";
/*  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  header(sprintf("Location: %s", $updateGoTo));
}
/*
	mysql_select_db($database_bd, $bd);
	$query_Recordset1 = "SELECT * FROM Alumno";
	$Recordset1 = mysql_query($query_Recordset1, $bd) or die(mysql_error());
	$row_Recordset1 = mysql_fetch_assoc($Recordset1);
	$totalRows_Recordset1 = mysql_num_rows($Recordset1);
*/

$Usuario_RS_Alumno = "0";
if (isset($_COOKIE['MM_Username'])) {
  $Usuario_RS_Alumno = $_COOKIE['MM_Username'];
}
$CodigoAlumno = "1";
if (isset($_GET['CodigoAlumno'])) {
  $CodigoAlumno = $_GET['CodigoAlumno'];
}

//mysql_select_db($database_bd, $bd);
$query_RS_Alumno = sprintf("SELECT * FROM Alumno WHERE CodigoAlumno = '%s' AND Creador = '$MM_Username' ", $CodigoAlumno);


$RS_Alumno = $mysqli->query($query_RS_Alumno);
$row_RS_Alumno = $RS_Alumno->fetch_assoc();
$totalRows_RS_Alumno = $RS_Alumno->num_rows;	
	
	/*
$RS_Alumno = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumno = mysql_fetch_assoc($RS_Alumno);
$totalRows_RS_Alumno = mysql_num_rows($RS_Alumno);
*/
$query_RS_Cursos = "SELECT * FROM Curso 
					WHERE SW_activo=1 
					ORDER BY Curso.NivelCurso, Curso.Seccion, Curso.Seccion";
$RS_Cursos = $mysqli->query($query_RS_Cursos);
$row_RS_Cursos = $RS_Cursos->fetch_assoc();
$totalRows_RS_Cursos = $RS_Cursos->num_rows;	
/*
$RS_Cursos = mysql_query($query_RS_Cursos, $bd) or die(mysql_error());
$row_RS_Cursos = mysql_fetch_assoc($RS_Cursos);
$totalRows_RS_Cursos = mysql_num_rows($RS_Cursos);*/
 
function DayNumDate ($num) {
return substr($num, 8, 2);}

function MonthNumDate ($num) {
return substr($num, 5, 2);}


$sql = "SELECT * FROM AlumnoXCurso 
		WHERE 
		CodigoAlumno='".$row_RS_Alumno['CodigoAlumno']."' 
		AND ((Ano='".$AnoEscolarAnte."' AND Status = 'Inscrito') 
			OR
			(Ano='".$AnoEscolar."' AND Status = 'Inscrito'))
		";
//echo $sql;

$RS_sql = $mysqli->query($sql);
$row_RS = $RS_sql->fetch_assoc();
$totalRows_RS = $RS_sql->num_rows;
	/*
$RS_sql = mysql_query($sql, $bd) or die(mysql_error());
$row_RS = mysql_fetch_assoc($RS_sql);
$totalRows_RS = mysql_num_rows($RS_sql);*/

if($totalRows_RS == 0 or $row_RS_Alumno['CodigoAlumno']==''){ //Modificable Datos ME
	$SW_mod_ME = true; 
	//echo "e";
	}
else{
	$SW_mod_ME = false;}

		
		
		

?><!doctype html>
<head>
<meta charset="ISO-8859-1">
<title>Colegio San Francisco de As&iacute;s</title>

<link rel="shortcut icon" href="../img/favicon.ico">
<link href="../css/Level2_Arial_Text.css" rel="stylesheet" type="text/css">
<style type="text/css">
.style1 {color: #0000FF}
</style>
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
<script src="../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css">
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<link href="../estilos2.css" rel="stylesheet" type="text/css">
<link href="../estilos.css" rel="stylesheet" type="text/css">

</head>

<script language="javascript" type="text/javascript">
    //*** Este Codigo permite Validar que sea un campo Numerico
    function Solo_Numerico(variable){
        Numer=parseInt(variable);
        if (isNaN(Numer)){
            return "";
        }
        return Numer;
    }
    function ValNumero(Control){
        Control.value=Solo_Numerico(Control.value);
    }
    //*** Fin del Codigo para Validar que sea un campo Numerico
</script>


<body bgcolor="e7e7e9" leftmargin="0" topmargin="20" marginwidth="0" marginheight="0"  >
<!-- ImageReady Slices (index.psd) -->
<table width="1025" border="0" align="center" cellpadding="0" cellspacing="0" id="Table_01">
<tr>
		<td bgcolor="#FFF8E8">
			<img src="../img/index_01.jpg" width="31" height="191" alt=""></td>
		<td bgcolor="#FFFFFF">
			<img src="../img/TitSol.jpg" width="197" height="191" alt=""></td>
		<td bgcolor="#0A1B69">
			<img src="../img/TituloAzul.jpg" width="766" height="191" alt="Colegio San Francisco de Asis"></td>
		<td bgcolor="#FFF8E8">
			<img src="../img/index_04.jpg" width="31" height="191" alt=""></td>
	</tr>
	<tr>
		<td colspan="4">
			<img src="../img/index_05.jpg" width="1025" height="7" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="../img/index_06.jpg" width="31" height="68" alt=""></td>
		<td bgcolor="#F3F3F3">&nbsp;</td>
		<td>&nbsp;</td>
  <td bgcolor="#FFF8E8">
			<img src="../img/index_09.jpg" width="31" height="68" alt=""></td>
	</tr>
	<tr>
		<td colspan="4">
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
<table width="95%" border="0" >
  <tr>
    <td><img src="../img/b.gif" width="740" height="1"></td>
  </tr>
  <tr>
    <td><p class="Tit_Pagina">Datos del Alumno</p></td>
  </tr>
  <tr>
    <td><a href="../intranet"><img src="../i/navigate-left32.png" width="32" height="32" border="0" align="absmiddle"> Regresar</a></td>
  </tr>
</table>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table border="0" align="center" width="95%">
        <tr valign="baseline">
          <td colspan="4" align="left" nowrap="nowrap" class="subtitle">
            <div align="left">
              Datos personales
              <input name="Creador" type="hidden" id="Creador" value="<?php echo $_COOKIE['MM_Username']; ?>">       
              &nbsp;
              <input name="CodigoAlumno" type="hidden" id="CodigoAlumno" value="<?php echo $row_RS_Alumno['CodigoAlumno']; ?>">
            </div></td>
        <td nowrap="nowrap" class="subtitle">
        <input name="CodigoFMP" type="hidden" class="TextosSimples" value="<?php echo $row_RS_Alumno['CodigoFMP']; ?>" size="8">
        <input name="SWinscritoAnoAnte" type="hidden" class="TextosSimples" value="<?php echo $row_RS_Alumno['SWinscritoAnoAnte']; ?>" size="8"></td>
      </tr>
        <tr valign="baseline">
          <td colspan="2" align="right" valign="top" nowrap="nowrap"><table width="100%"  border="0">
            <tr>
              <td class="NombreCampo">C&eacute;dula            </td>
            <td nowrap="nowrap" class="FondoCampo">
			<?php  ?>
            <input name="CedulaLetra"  type="<?php echo $SW_mod_ME?'text':'hidden'; ?>" class="TextosSimples" value="<?php echo $row_RS_Alumno['CedulaLetra']; ?>" size="2">
              <span id="sprytextfield15">
        <input name="Cedula" type="<?php echo $SW_mod_ME?'text':'hidden'; ?>"  onkeyup="return ValNumero(this);"  class="TextosSimples" value="<?php echo $row_RS_Alumno['Cedula']; ?>" size="12">
        <span class="textfieldInvalidFormatMsg">S&oacute;lo N&uacute;meros</span></span><?php if($SW_mod_ME){}else{ echo $row_RS_Alumno['CedulaLetra']."-".$row_RS_Alumno['Cedula'];} ?>        </td>
          </tr>
            <tr>
              <td class="NombreCampo">1er Nombre</td>
            <td class="FondoCampo"><span id="sprytextfield1">
              <input name="Nombres" type="<?php echo $SW_mod_ME?'text':'hidden'; ?>" class="TextosSimples" value="<?php echo $row_RS_Alumno['Nombres']; ?>" size="20">
              <span class="textfieldRequiredMsg">Requerido</span></span><?php  if($SW_mod_ME){ }else{echo $row_RS_Alumno['Nombres'];} ?></td>
          </tr>
            <tr>
              <td class="NombreCampo">2do Nombre</td>
            <td class="FondoCampo"><?php  ?><input name="Nombres2" type="<?php echo $SW_mod_ME?'text':'hidden'; ?>" class="TextosSimples" value="<?php echo $row_RS_Alumno['Nombres2']; ?>" size="20"><?php if($SW_mod_ME){}else{echo $row_RS_Alumno['Nombres2'];} ?></td>
          </tr>
            <tr>
              <td class="NombreCampo">1er Apellido</td>
            <td class="FondoCampo"><?php  ?><span id="sprytextfield2">
              <input name="Apellidos" type="<?php echo $SW_mod_ME?'text':'hidden'; ?>" class="TextosSimples" value="<?php echo $row_RS_Alumno['Apellidos']; ?>" size="20">
              <span class="textfieldRequiredMsg">Requerido</span></span><?php if($SW_mod_ME){}else{echo $row_RS_Alumno['Apellidos'];} ?></td>
          </tr>
            <tr>
              <td class="NombreCampo">2do Apellido</td>
            <td class="FondoCampo"><?php  ?><input name="Apellidos2" type="<?php echo $SW_mod_ME?'text':'hidden'; ?>" class="TextosSimples" value="<?php echo $row_RS_Alumno['Apellidos2']; ?>" size="20"><?php if($SW_mod_ME){}else{echo $row_RS_Alumno['Apellidos2'];} ?></td>
          </tr>
            <tr>
              <td class="NombreCampo">Nacionalidad</td>
            <td class="FondoCampo"><?php  ?><span id="sprytextfield3">
              <input name="Nacionalidad" type="<?php echo $SW_mod_ME?'text':'hidden'; ?>" class="TextosSimples"  value="<?php echo $row_RS_Alumno['Nacionalidad']; ?>"  size="20">
              <span class="textfieldRequiredMsg">Requerido</span></span><?php if($SW_mod_ME){}else{echo $row_RS_Alumno['Nacionalidad'];} ?></td>
          </tr>
            </table></td>
        <td colspan="3" align="right" valign="top" nowrap="nowrap"><table width="100%"  border="0">
          <tr>
            <td nowrap="nowrap" class="NombreCampo">Curso<br>
(<?php echo $AnoEscolarProx ?>)</td>
            <td nowrap="nowrap" class="FondoCampo">
			<?php if($SW_mod_ME){ ?>
            <span id="spryselect1">
            <?php 
			
$sql = "SELECT * FROM AlumnoXCurso 
		WHERE CodigoAlumno='".$row_RS_Alumno['CodigoAlumno']."' 
		AND Ano='".$AnoEscolarProx."' 
		AND (Status = 'Solicitando' OR Status = 'Aceptado')";
		//echo $sql;
			

$RS_sql = $mysqli->query($sql);
$row_RS = $RS_sql->fetch_assoc();
$totalRows_RS = $RS_sql->num_rows;			
			
	/*		
$RS_sql = mysql_query($sql, $bd) or die(mysql_error());
$row_RS = mysql_fetch_assoc($RS_sql);
$totalRows_RS = mysql_num_rows($RS_sql);*/
if($totalRows_RS == 1 )
	$CodigoCurso = $row_RS['CodigoCurso'];
else
	$CodigoCurso = 0;

//echo Curso($row_RS['CodigoCurso']);

// siguiente linea activa con ins abiertas
if($SW_Inscripciones_Abiertas){
	MenuCurso($CodigoCurso,'SW_CupoDisp'); 
	echo "<br>Solo se despliegan los cursos con disponibilidad";
}
else{
?><input name="CodigoCurso" type="hidden" id="CodigoCurso" value="<?php echo $row_RS['CodigoCurso']; ?>">
<?php } ?>
            <span class="selectInvalidMsg">Requerido</span>
            <span class="selectRequiredMsg">Requerido</span></span>
<?php 

}
else{ 
		  
$sql = "SELECT * FROM AlumnoXCurso 
		WHERE CodigoAlumno='".$row_RS_Alumno['CodigoAlumno']."' 
		AND (Ano='".$AnoEscolarProx."' ) 
		ORDER BY Codigo";
	
$RS_sql = $mysqli->query($sql);
$row_RS = $RS_sql->fetch_assoc();
	/*
$RS_sql = 	mysql_query($sql, $bd) or die(mysql_error());
$row_RS = mysql_fetch_assoc($RS_sql);*/

echo Curso($row_RS['CodigoCurso']);


 ?><input name="CodigoCurso" type="hidden" id="CodigoCurso" value="<?php echo '"'.$row_RS['CodigoCurso'].'"'; ?>"><?php }  ?>
 
 
<?php  ?>

</td>
          </tr>
          <tr>
            <td class="NombreCampo">Fecha de Nacimiento</td>
            <td nowrap="nowrap" class="FondoCampo"><?php  ?><input name="FechaNac" type="hidden" id="FechaNac" value="<?php echo $row_RS_Alumno['FechaNac']; ?>">
              <?php if($SW_mod_ME){ Fecha('FechaNac', $row_RS_Alumno['FechaNac']) ?><?php }else{echo DDMMAAAA($row_RS_Alumno['FechaNac']);} ?></td>
          </tr>
          <tr>
            <td class="NombreCampo">Clinica Donde Naci&oacute;</td>
            <td class="FondoCampo"><?php ?><input name="ClinicaDeNac"  type="<?php echo $SW_mod_ME?'text':'hidden'; ?>"  class="TextosSimples"  value="<?php echo $row_RS_Alumno['ClinicaDeNac']; ?>"  size="20"><?php if($SW_mod_ME){ }else{echo $row_RS_Alumno['ClinicaDeNac'];} ?></td>
          </tr>
          <tr>
            <td class="NombreCampo">Localidad,<br> 
              Ciudad o Municipio</td>
            <td class="FondoCampo"><input name="Localidad"  type="<?php if($SW_mod_ME) echo "text"; else echo "hidden"; ?>"  class="TextosSimples"  value="<?php echo $row_RS_Alumno["Localidad"]; ?>"  size="20"><?php  if($SW_mod_ME){ }else{echo $row_RS_Alumno["Localidad"];} ?></td>
          </tr>
          <tr>
            <td class="NombreCampo">Entidad o Estado</td>
            <td class="FondoCampo"><?php  ?><input name="Entidad"  type="<?php echo $SW_mod_ME?'text':'hidden'; ?>"  class="TextosSimples"  value="<?php echo $row_RS_Alumno['Entidad']; ?>"  size="20"><?php if($SW_mod_ME){}else{echo $row_RS_Alumno['Entidad'];} ?></td>
          </tr>
          <tr>
            <td class="NombreCampo">Sexo</td>
            <td class="FondoCampo"><?php if($SW_mod_ME){ ?><input name="Sexo" type="radio" value="F" <?php if ($row_RS_Alumno['Sexo']=='F') echo checked;  ?>>
              F
              <input type="radio" name="Sexo" value="M" <?php if ($row_RS_Alumno['Sexo']=='M') echo checked;  ?>>
              M<?php }else{echo $row_RS_Alumno['Sexo'];  ?>
              <input name="Sexo" type="hidden" value="<?php echo $row_RS_Alumno['Sexo']   ?>" ><?php } ?></td>
          </tr>
          </table></td>
        </tr>
        <tr valign="baseline">
          <td colspan="5" align="right" valign="top" nowrap="nowrap" class="subtitle"><div align="left">Informaci&oacute;n de contacto </div></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="top" nowrap="nowrap" class="NombreCampo"><div align="right">Direcci&oacute;n:</div></td>
        <td align="right" nowrap="nowrap" class="FondoCampo"><div align="left"><span id="sprytextarea1">
          <textarea name="Direccion" cols="20" rows="4" class="TextosSimples"><?php echo $row_RS_Alumno['Direccion']; ?></textarea>
          <span id="countsprytextarea1">&nbsp;</span> <span class="textareaRequiredMsg">Requerido</span></span></div></td>
        <td colspan="3" align="right" valign="top" nowrap="nowrap"><table width="100%"  border="0">
          <tr>
            <td width="50%" nowrap="nowrap" class="NombreCampo">Urbanizacion</td>
            <td width="50%" class="FondoCampo"><span id="sprytextfield4">
              <input name="Urbanizacion" type="text" class="TextosSimples"  value="<?php echo $row_RS_Alumno['Urbanizacion']; ?>" size="20">
              <span class="textfieldRequiredMsg">Requerido</span></span></td>
          </tr>
          <tr>
            <td nowrap="nowrap" class="NombreCampo">Ciudad</td>
            <td class="FondoCampo"><span id="sprytextfield5">
              <input name="Ciudad" type="text" class="TextosSimples" value="<?php echo $row_RS_Alumno['Ciudad']; ?>" size="20">
              <span class="textfieldRequiredMsg">Requerido</span></span></td>
          </tr>
          <tr>
            <td nowrap="nowrap" class="NombreCampo">Codigo Postal</td>
            <td class="FondoCampo"><span id="sprytextfield6">
              <input name="CodPostal" type="text" class="TextosSimples" value="<?php echo $row_RS_Alumno['CodPostal']; ?>" size="20">
              </span></td>
          </tr>
          </table></td>
      </tr>
        <tr valign="baseline">
          <td align="right" valign="top" class="NombreCampo"><div align="right">Email alumno</div></td>
        <td align="right" nowrap="nowrap" class="FondoCampo"><div align="left"><span id="sprytextfield13">
          <input name="Email1" type="text" class="TextosSimples" value="<?php echo $row_RS_Alumno['Email1']; ?>" size="20">
          <span class="textfieldInvalidFormatMsg">Inv&aacute;lido</span></span></div></td>
        <td align="right" valign="top" class="NombreCampo">Email secundario</td>
        <td colspan="2" nowrap="nowrap" class="FondoCampo"><span id="sprytextfield14">
          <input name="Email2" type="text" class="TextosSimples" value="<?php echo $row_RS_Alumno['Email2']; ?>" size="20">
          <span class="textfieldInvalidFormatMsg">Inv&aacute;lido</span></span></td>
      </tr>
        <tr valign="baseline">
          <td align="right" valign="top" nowrap="nowrap" class="NombreCampo"><div align="right">Tel&eacute;fono Hab</div></td>
        <td align="right" nowrap="nowrap" class="FondoCampo"><div align="left"><span id="sprytextfield7">
          <input name="TelHab" type="text" class="TextosSimples" value="<?php echo $row_RS_Alumno['TelHab']; ?>" size="20">
          <span class="textfieldRequiredMsg">Requerido</span></span></div></td>
        <td align="right" valign="top" nowrap="nowrap" class="NombreCampo">Tel&eacute;fono Cel</td>
        <td colspan="2" nowrap="nowrap" class="FondoCampo"><span id="sprytextfield8">
          <input name="TelCel" type="text" class="TextosSimples" value="<?php echo $row_RS_Alumno['TelCel']; ?>" size="20">
          <span class="textfieldRequiredMsg">Requerido</span></span></td>
      </tr>
        <tr valign="baseline">
          <td align="right" valign="top" nowrap="nowrap" class="NombreCampo">Con quien Vive</td>
        <td nowrap="nowrap" class="FondoCampo"><span id="sprytextfield12">
          <input type="text" name="ViveCon" value="<?php echo $row_RS_Alumno['ViveCon']; ?>"  class="TextosSimples"  size="20">
          <span class="textfieldRequiredMsg">Requerido</span></span></td>
        <td align="right" valign="top" nowrap="nowrap" class="NombreCampo">&nbsp;</td>
        <td colspan="2" nowrap="nowrap" class="FondoCampo"></td>
      </tr>
        <tr valign="baseline" >
          <td colspan="5" align="right" valign="top" nowrap="nowrap" class="subtitle"><div align="left">En caso de emergencia llamar a: </div></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="top" nowrap="nowrap" class="NombreCampo">Nombre</td>
        <td align="left" nowrap="nowrap" class="FondoCampo"><span id="sprytextfield9">
          <input name="PerEmergencia" type="text" class="TextosSimples" value="<?php echo $row_RS_Alumno['PerEmergencia']; ?>" size="20">
          <span class="textfieldRequiredMsg">Requerido</span></span></td>
        <td align="right" valign="top" nowrap="nowrap" class="NombreCampo">&nbsp;</td>
        <td colspan="2" align="right" valign="top" nowrap="nowrap" class="FondoCampo">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="top" nowrap="nowrap" class="NombreCampo"><div align="right">Tel&eacute;fono</div></td>
        <td align="right" nowrap="nowrap" class="FondoCampo"><div align="left"><span id="sprytextfield10">
          <input name="PerEmerTel" type="text" class="TextosSimples" value="<?php echo $row_RS_Alumno['PerEmerTel']; ?>" size="20">
          <span class="textfieldRequiredMsg">Requerido</span></span></div></td>
        <td align="right" valign="top" nowrap="nowrap" class="NombreCampo">      Nexo</td>
        <td colspan="2" valign="top" nowrap="nowrap" class="FondoCampo"><span id="sprytextfield11">
          <input name="PerEmerNexo" type="text" class="TextosSimples" value="<?php echo $row_RS_Alumno['PerEmerNexo']; ?>" size="15">
          <span class="textfieldRequiredMsg">Requerido</span></span></td>
        </tr>
        <tr valign="baseline">
          <td colspan="5" align="right" valign="top" nowrap="nowrap" class="subtitle"><div align="left">Informaci&oacute;n M&eacute;dica </div></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="top" nowrap="nowrap" class="NombreCampo"><div align="right">Peso</div></td>
        <td align="right" nowrap="nowrap" class="FondoCampo"><div align="left">
          <input name="Peso" type="text" class="TextosSimples" value="<?php echo $row_RS_Alumno['Peso']; ?>" size="20">
          </div></td>
        <td align="right" valign="top" nowrap="nowrap" class="NombreCampo">Vacunas</td>
        <td colspan="2" nowrap="nowrap" class="FondoCampo"><input name="Vacunas" type="text" class="TextosSimples" value="<?php echo $row_RS_Alumno['Vacunas']; ?>" size="20"></td>
      </tr>
        <tr valign="baseline">
          <td align="right" valign="top" nowrap="nowrap" class="NombreCampo"><div align="right">Enfermedades</div></td>
        <td align="right" nowrap="nowrap" class="FondoCampo"><div align="left">
          <input name="Enfermedades" type="text" class="TextosSimples" value="<?php echo $row_RS_Alumno['Enfermedades']; ?>" size="20">
          </div></td>
        <td align="right" valign="top" class="NombreCampo">Tratamiento M&eacute;dico</td>
        <td colspan="2" nowrap="nowrap" class="FondoCampo"><input name="TratamientoMed" type="text" class="TextosSimples" value="<?php echo $row_RS_Alumno['TratamientoMed']; ?>" size="20"></td>
      </tr>
        <tr valign="baseline">
          <td align="right" valign="top" nowrap="nowrap" class="NombreCampo"><div align="right">Alergico a</div></td>
        <td align="right" nowrap="nowrap" class="FondoCampo"><div align="left">
          <input name="AlergicoA" type="text" class="TextosSimples" value="<?php echo $row_RS_Alumno['AlergicoA']; ?>" size="20">
          </div></td>
        <td align="right" valign="top" nowrap="nowrap" class="NombreCampo">&nbsp;</td>
        <td colspan="2" nowrap="nowrap" class="FondoCampo">&nbsp;</td>
      </tr>
        <tr>
          <td colspan="5" nowrap="nowrap" class="subtitle">Colegio de procedencia</td>
                </tr>
        <tr>
          <td align="right" nowrap="nowrap" class="NombreCampo">Nombre</td>
                        <td nowrap="nowrap" class="FondoCampo"><input name="ColegioProcedencia" type="text" class="TextosSimples" value="<?php echo $row_RS_Alumno['ColegioProcedencia']; ?>" size="20"></td>
                        <td align="right" nowrap="nowrap" class="NombreCampo">Urbanizaci&oacute;n</td>
                        <td nowrap="nowrap" colspan="2" class="FondoCampo"><input name="CiudadColProc" type="text" class="TextosSimples" value="<?php echo $row_RS_Alumno['CiudadColProc']; ?>" size="20"></td>
                </tr>
        <tr>
          <td align="right" nowrap="nowrap" class="NombreCampo">Motivo de retiro</td>
                        <td nowrap="nowrap" class="FondoCampo"><input name="MotivoRetiroColProced" type="text"  class="TextosSimples" value="<?php echo $row_RS_Alumno['MotivoRetiroColProced']; ?>" size="20"></td>
                        <td align="right" nowrap="nowrap" class="NombreCampo">Tel&eacute;fono Col. anterior</td>
                        <td nowrap="nowrap" colspan="2" class="FondoCampo"><input name="ColegioProcedenciaTelefono" type="text" class="TextosSimples" id="ColegioProcedenciaTelefono" value="<?php echo $row_RS_Alumno['CiudadColProc']; ?>" size="20"></td>
                </tr>
        <tr valign="baseline">
          <td align="right" valign="top" nowrap="nowrap" class="NombreCampo">Observaciones</td>
        <td colspan="4" nowrap="nowrap" class="FondoCampo"><p>
          <textarea name="Observaciones" cols="40" rows="3" class="TextosSimples" id="Observaciones"><?php echo $row_RS_Alumno['Observaciones']; ?></textarea>
        </p></td>
        </tr>
        <tr valign="baseline">
          <td colspan="5" nowrap="nowrap" class="subtitle">Otros Datos</td>
          </tr>
        <tr valign="baseline">
          <td align="right" valign="top" nowrap="nowrap" class="NombreCampo">Ha Solicitado Cupo en el colegio antes:</td>
          <td valign="top" nowrap="nowrap" class="FondoCampo"><table width="150">
            <tr>
              <td class="FondoCampo">
                <label>
                  <input type="radio" name="HaSolicitado" value="Si" id="HaSolicitado_0" <?php if( $row_RS_Alumno['HaSolicitado']=="Si") echo "checked"; ?> >
                  Si</label>
                </span></td>
              </tr>
            <tr>
              <td><span class="FondoCampo">
                <label>
                  <input type="radio" name="HaSolicitado" value="No" id="HaSolicitado_1" <?php if( $row_RS_Alumno['HaSolicitado']=="No") echo "checked"; ?> >
                  No</label>
              </span></td>
              </tr>
          </table></td>
          <td colspan="3" valign="top" nowrap="nowrap" class="FondoCampo">Indique: Cuando y
            <label for="HaSolicitadoCuando"></label>
            razones por la que no ingreso:<br>
            <label for="HaSolicitadoObs"></label>
            <textarea name="HaSolicitadoObs" cols="40" rows="4" id="HaSolicitadoObs"><?php echo $row_RS_Alumno['HaSolicitadoObs']; ?></textarea></td>
          </tr>
        <tr valign="baseline">
          <td align="right" valign="top" nowrap="nowrap" class="NombreCampo"><p>Tiene seguimiento de alg&uacute;n especialista<br>
            (
Psicologo, psicopedagogo, etc)</p></td>
          <td valign="top" nowrap="nowrap" class="FondoCampo"><table width="150">
            <tr>
              <td class="FondoCampo"><label>
                <input type="radio" name="TienePsicologo" value="Si" id="TienePsicologo_0" <?php if( $row_RS_Alumno['TienePsicologo']=="Si") echo "checked"; ?> >
                Si</label></td>
            </tr>
            <tr>
              <td class="FondoCampo"><label>
                <input type="radio" name="TienePsicologo" value="No" id="TienePsicologo_1" <?php if( $row_RS_Alumno['TienePsicologo']=="No") echo "checked"; ?> >
                No</label></td>
            </tr>
          </table></td>
          <td colspan="3" valign="top" nowrap="nowrap" class="FondoCampo">Indique: Nombre del especialista, motivo, desde cuando:<br>
            <label for="TienePsicologoObs"></label>
            <textarea name="TienePsicologoObs" cols="40" rows="4" id="TienePsicologoObs"><?php echo $row_RS_Alumno['TienePsicologoObs']; ?></textarea></td>
          </tr>
        <tr valign="baseline">
          <td align="right" valign="top" nowrap="nowrap" class="NombreCampo">Representante Administrativo</td>
          <td nowrap="nowrap" class="FondoCampo"><table width="200">
            <tr>
              <td class="FondoCampo"><label>
                <input type="radio" name="RepresentanteAdministrativo" value="Padre" id="RepresentanteAdministrativo_0" <?php if( $row_RS_Alumno['RepresentanteAdministrativo']=="Padre") echo "checked"; ?> >
                Padre</label></td>
            </tr>
            <tr>
              <td class="FondoCampo"><label>
                <input type="radio" name="RepresentanteAdministrativo" value="Madre" id="RepresentanteAdministrativo_1" <?php if( $row_RS_Alumno['RepresentanteAdministrativo']=="Madre") echo "checked"; ?> >
                Madre</label></td>
            </tr>
            <tr>
              <td class="FondoCampo"><label>
                <input type="radio" name="RepresentanteAdministrativo" value="Otro" id="RepresentanteAdministrativo_2" <?php if( $row_RS_Alumno['RepresentanteAdministrativo']=="Otro") echo "checked"; ?> >
                Otro</label></td>
            </tr>
          </table>            <label for="RepresentanteAdministrativo"></label></td>
          <td colspan="3" valign="top" nowrap="nowrap" class="FondoCampo">Si es otro indique: Nombre, Nexo, Telefono, Email:<br>
            <textarea name="RepresentanteAdministrativoObs" cols="40" rows="4" id="RepresentanteAdministrativoObs"><?php echo $row_RS_Alumno['RepresentanteAdministrativoObs']; ?></textarea></td>
          </tr>
        <tr valign="baseline">
          <td align="right" valign="top" nowrap="nowrap" class="NombreCampo">Tiene Hermanos solicitando cupo</td>
          <td colspan="4" valign="top" nowrap="nowrap" class="FondoCampo">Indique: Nombre y curso que solicitan:<br>
            <textarea name="HermanoSolicitando" cols="60" rows="4" id="Hermano"><?php echo $row_RS_Alumno['HermanoSolicitando']; ?></textarea></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="top" nowrap="nowrap" class="NombreCampo">Tiene Hermanos  cursando en el Colegio</td>
          <td valign="top" nowrap="nowrap" class="FondoCampo"><table width="150">
            <tr>
              <td class="FondoCampo"><label>
                <input type="radio" name="HermanoCursando" value="Si" id="HermanoCursando_2" <?php if( $row_RS_Alumno['HermanoCursando']=="Si") echo "checked"; ?> >
                Si</label></td>
            </tr>
            <tr>
              <td class="FondoCampo"><label>
                <input type="radio" name="HermanoCursando" value="No" id="HermanoCursando_3" <?php if( $row_RS_Alumno['HermanoCursando']=="No") echo "checked"; ?> >
                No</label></td>
            </tr>
          </table></td>
          <td colspan="3" valign="top" nowrap="nowrap" class="FondoCampo">Indique: Nombre y curso:<br>
            <textarea name="HermanoCursandoObs" cols="60" rows="4" id="HermanoCursando"><?php echo $row_RS_Alumno['HermanoCursandoObs']; ?></textarea></td>
          </tr>
        <tr valign="baseline">
          <td align="right" valign="top" nowrap="nowrap" class="NombreCampo">Es Hijo De Exalumno</td>
          <td valign="top" nowrap="nowrap" class="FondoCampo"><table width="150">
            <tr>
              <td class="FondoCampo"><label>
                <input type="radio" name="HijoDeExalumno" value="Si" id="TienePsicologo_4" <?php if( $row_RS_Alumno['HijoDeExalumno']=="Si") echo "checked"; ?> >
                Si</label></td>
            </tr>
            <tr>
              <td class="FondoCampo"><label>
                <input type="radio" name="HijoDeExalumno" value="No" id="TienePsicologo_5" <?php if( $row_RS_Alumno['HijoDeExalumno']=="No") echo "checked"; ?> >
                No</label></td>
            </tr>
          </table></td>
          <td colspan="3" valign="top" class="FondoCampo">Indique: Nombre, desde que a&ntilde;o curso, hasta que a&ntilde;o, <br>
            indique si se gradu&oacute;:<br>
            <textarea name="HijoDeExalumnoObs" cols="60" rows="4" id="HijoDeExalumno"><?php echo $row_RS_Alumno['HijoDeExalumnoObs']; ?></textarea></td>
          </tr>
        <tr valign="baseline">
          <td align="right" valign="top" nowrap="nowrap" class="NombreCampo">Indique los datos de 2 representantes<br>
            de la familia Franciscana quienes<br>
            le otorgan cartas de referencia</td>
          <td colspan="4" valign="top" nowrap="nowrap" class="FondoCampo">Indique: Nombre, tel&eacute;fono, Alumno y grado:<br>
            <textarea name="ReferenciasPersonales" cols="60" rows="4" id="ReferenciasPersonales"><?php echo $row_RS_Alumno['ReferenciasPersonales']; ?></textarea></td>
        </tr>
        <tr valign="baseline">
          <td colspan="5" align="right" nowrap="nowrap">
      <?php //if ( $row_RS_Alumno['SWinscrito']!=1 or $_COOKIE['MM_UserGroup']==99) { ?> 
            <div align="center">
              <input type="submit" value="Guardar">
              <br>
              (si no guarda verifique datos faltantes en la planilla)<br>
            </div>
            <?php //} ?></td>
        </tr>
        </table>
      <?php //if ( $row_RS_Alumno['SWinscrito']!=1 or $_COOKIE['MM_UserGroup']==99) { ?>
      <?php if ($totalRows_RS_Alumno == 1) { ?>
      <input type="hidden" name="MM_update" value="form1"><?php } else {  ?>
      <input type="hidden" name="MM_insert" value="form1"><?php }?>
	  <?php // } ?>
</form>
    <p>&nbsp;</p>
    <script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {hint:"1er Nombre", validateOn:["blur", "change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {hint:"1er Apellido", validateOn:["blur", "change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {hint:"Nacionalidad", validateOn:["blur", "change"]});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {invalidValue:"0", validateOn:["change", "blur"]});
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {counterId:"countsprytextarea1", hint:"Calle o ave, Casa o Edif, Piso, Apto", validateOn:["blur", "change"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {hint:"Urbanizaci\xF3n", validateOn:["blur", "change"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {hint:"Ciudad", validateOn:["blur", "change"]});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "none", {isRequired:false, validateOn:["blur", "change"]});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "none", {validateOn:["blur", "change"]});
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8", "none", {validateOn:["blur", "change"]});
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9", "none", {validateOn:["blur", "change"]});
var sprytextfield10 = new Spry.Widget.ValidationTextField("sprytextfield10", "none", {validateOn:["blur", "change"]});
var sprytextfield11 = new Spry.Widget.ValidationTextField("sprytextfield11", "none", {validateOn:["blur", "change"]});
var sprytextfield12 = new Spry.Widget.ValidationTextField("sprytextfield12", "none", {validateOn:["blur", "change"]});
var sprytextfield13 = new Spry.Widget.ValidationTextField("sprytextfield13", "email", {validateOn:["blur", "change"], isRequired:false});
var sprytextfield14 = new Spry.Widget.ValidationTextField("sprytextfield14", "email", {validateOn:["blur", "change"], isRequired:false});
var sprytextfield15 = new Spry.Widget.ValidationTextField("sprytextfield15", "integer", {validateOn:["blur", "change"], isRequired:false});
//-->
    </script>



</td>
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
		<td colspan="4" bgcolor="#FFFFFF">
			<img src="../img/Pie1.jpg" width="1025" height="9" alt=""></td>
	</tr>
	<tr>
		<td bgcolor="#0A1B69">
			<img src="../img/PieA.jpg" width="31" height="58" alt=""></td>
		<td colspan="2" align="center" bgcolor="#0A1B69"><strong class="medium"><font color="#FFFFFF">Todos los derechos reservados Colegio San Francisco de As&iacute;s &copy; 2010</font></strong></td>
<td bgcolor="#0A1B69">
			<img src="../img/PieB.jpg" width="31" height="58" alt=""></td>
	</tr>
</table>
<!-- End ImageReady Slices -->
</body>
</html><?php } ?>