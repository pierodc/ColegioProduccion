<?php 
$MM_authorizedUsers = "2";
$SW_omite_trace = false;
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

	

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO Representante (Creador, Nexo, SWrepre, Cedula, Apellidos, Nombres, LugarNac, Nacionalidad, EdoCivil, FechaNac, TelHab, TelCel, TelTra, Email1, Email2, Direccion, Urbanizacion, Ciudad, CodPostal, Ocupacion, Profesion, GradoInstruccion, Empresa, ActividadEmpresa, TiempoEmpresa, CargoEmpresa, Remuneracion, DireccionTra, Fecha_Actualizacion) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Creador'], "text"),
                       GetSQLValueString($_POST['Nexo'], "text"),
                       GetSQLValueString($_POST['SWrepre'], "text"),
                       GetSQLValueString($_POST['Cedula'], "text"),
                       GetSQLValueString($_POST['Apellidos'], "text"),
                       GetSQLValueString($_POST['Nombres'], "text"),
                       GetSQLValueString($_POST['LugarNac'], "text"),
                       GetSQLValueString($_POST['Nacionalidad'], "text"),
                       GetSQLValueString($_POST['EdoCivil'], "text"),
                       GetSQLValueString($_POST['FechaNac'], "date"),
                       GetSQLValueString($_POST['TelHab'], "text"),
                       GetSQLValueString($_POST['TelCel'], "text"),
                       GetSQLValueString($_POST['TelTra'], "text"),
                       GetSQLValueString($_POST['Email1'], "text"),
                       GetSQLValueString($_POST['Email2'], "text"),
                       GetSQLValueString($_POST['Direccion'], "text"),
                       GetSQLValueString($_POST['Urbanizacion'], "text"),
                       GetSQLValueString($_POST['Ciudad'], "text"),
                       GetSQLValueString($_POST['CodPostal'], "text"),
                       GetSQLValueString($_POST['Ocupacion'], "text"),
                       GetSQLValueString($_POST['Profesion'], "text"),
                       GetSQLValueString($_POST['GradoInstruccion'], "text"),
                       GetSQLValueString($_POST['Empresa'], "text"),
                       GetSQLValueString($_POST['ActividadEmpresa'], "text"),
                       GetSQLValueString($_POST['TiempoEmpresa'], "text"),
                       GetSQLValueString($_POST['CargoEmpresa'], "text"),
                       GetSQLValueString($_POST['Remuneracion'], "double"),
                       GetSQLValueString($_POST['DireccionTra'], "text"),
					   GetSQLValueString(date('Y-m-d'), "date"));

  $Result1 = $mysqli->query($insertSQL) ; //mysql_query($insertSQL, $bd) or die(mysql_error());

$CodigoAlumno = $_POST['CodigoAlumno'];
$CodigoRepresentante = $mysqli->insert_id;
$Nexo = $_POST['Nexo'];	
if(strpos('   '.strtolower($_POST['SWrepre']) ,'s') >=1 )
	 $SWrepre='1';
else
	 $SWrepre='0';
 
$sql_insert = "INSERT INTO RepresentanteXAlumno 
				(CodigoAlumno, CodigoRepresentante, Nexo, SW_Representante) 
				VALUES 
				('$CodigoAlumno', '$CodigoRepresentante', '$Nexo', '$SWrepre')";
				 
 $Result1 = $mysqli->query($sql_insert) ;//$Result1 = mysql_query($sql_insert, $bd) or die(mysql_error());

  $insertGoTo = "index.php";
  /*if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE Representante SET Creador=%s, Nexo=%s, SWrepre=%s, Cedula=%s, Apellidos=%s, Nombres=%s, LugarNac=%s, Nacionalidad=%s, EdoCivil=%s, FechaNac=%s, TelHab=%s, TelCel=%s, TelTra=%s, Email1=%s, Email2=%s, Direccion=%s, Urbanizacion=%s, Ciudad=%s, CodPostal=%s, Ocupacion=%s, Profesion=%s, GradoInstruccion=%s, Empresa=%s, ActividadEmpresa=%s, TiempoEmpresa=%s, CargoEmpresa=%s, Remuneracion=%s, DireccionTra=%s, Fecha_Actualizacion=%s WHERE CodigoRepresentante=%s",
                       GetSQLValueString($_POST['Creador'], "text"),
                       GetSQLValueString($_POST['Nexo'], "text"),
                       GetSQLValueString($_POST['SWrepre'], "text"),
                       GetSQLValueString($_POST['Cedula'], "text"),
                       GetSQLValueString($_POST['Apellidos'], "text"),
                       GetSQLValueString($_POST['Nombres'], "text"),
                       GetSQLValueString($_POST['LugarNac'], "text"),
                       GetSQLValueString($_POST['Nacionalidad'], "text"),
                       GetSQLValueString($_POST['EdoCivil'], "text"),
                       GetSQLValueString($_POST['FechaNac'], "date"),
                       GetSQLValueString($_POST['TelHab'], "text"),
                       GetSQLValueString($_POST['TelCel'], "text"),
                       GetSQLValueString($_POST['TelTra'], "text"),
                       GetSQLValueString($_POST['Email1'], "text"),
                       GetSQLValueString($_POST['Email2'], "text"),
                       GetSQLValueString($_POST['Direccion'], "text"),
                       GetSQLValueString($_POST['Urbanizacion'], "text"),
                       GetSQLValueString($_POST['Ciudad'], "text"),
                       GetSQLValueString($_POST['CodPostal'], "text"),
                       GetSQLValueString($_POST['Ocupacion'], "text"),
                       GetSQLValueString($_POST['Profesion'], "text"),
                       GetSQLValueString($_POST['GradoInstruccion'], "text"),
                       GetSQLValueString($_POST['Empresa'], "text"),
                       GetSQLValueString($_POST['ActividadEmpresa'], "text"),
                       GetSQLValueString($_POST['TiempoEmpresa'], "text"),
                       GetSQLValueString($_POST['CargoEmpresa'], "text"),
                       GetSQLValueString($_POST['Remuneracion'], "text"),
                       GetSQLValueString($_POST['DireccionTra'], "text"),
					   GetSQLValueString(date('Y-m-d'), "date"),
                       GetSQLValueString($_POST['CodigoRepresentante'], "int"));

  //mysql_select_db($database_bd, $bd);
  $Result1 = $mysqli->query($updateSQL) ;// mysql_query($updateSQL, $bd) or die(mysql_error());

  $updateGoTo = "index.php";
/*  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  header(sprintf("Location: %s", $updateGoTo));
}

//mysql_select_db($database_bd, $bd);
$query_Recordset1 = "SELECT * FROM Representante";


$Recordset1 = $mysqli->query($query_Recordset1);
$row_Recordset1 = $Recordset1->fetch_assoc();
$totalRows_Recordset1 = $Recordset1->num_rows;
/*
$Recordset1 = mysql_query($query_Recordset1, $bd) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
*/
$Creador_RS_Repre = "0";
if (isset($_COOKIE['MM_Username'])) {
  $Creador_RS_Repre =  $_COOKIE['MM_Username'] ;
}
$colname_RS_Repre = "0";
if (isset($_GET['CodigoRepresentante'])) {
  $colname_RS_Repre = $_GET['CodigoRepresentante'] ;
}
if(isset($_GET['Creador'])) {
  $Creador_RS_Repre = $_GET['Creador'] ;
}

//mysql_select_db($database_bd, $bd);
$query_RS_Repre = sprintf("SELECT * FROM Representante WHERE CodigoRepresentante = '%s' AND Creador = '%s'", $colname_RS_Repre,$Creador_RS_Repre);


$RS_Repre = $mysqli->query($query_RS_Repre);
$row_RS_Repre = $RS_Repre->fetch_assoc();
$totalRows_RS_Repre = $RS_Repre->num_rows;

/*
$RS_Repre = mysql_query($query_RS_Repre, $bd) or die(mysql_error());
$row_RS_Repre = mysql_fetch_assoc($RS_Repre);
$totalRows_RS_Repre = mysql_num_rows($RS_Repre);
*/
?>
<html>
<head>
<title>Colegio San Francisco de As&iacute;s</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<meta name="google-site-verification" content="uCJ89hMiFA3PQcDx27Y2aAfIrDaon9rzD_jNGEEmc3w" />
<link rel="shortcut icon" href="../img/favicon.ico">
<link href="../n/CSS/Level2_Arial_Text.css" rel="stylesheet" type="text/css">
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<style type="text/css">
.style1 {color: #0000FF}
</style>
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
            <p><img src="../img/b.gif" width="740" height="1"></p>
            <p class="Tit_Pagina">Datos  <?php echo $_GET['Nexo']; ?></p>
            <form method="POST" name="form1" action="<?php echo $editFormAction; ?>">
  <p class="MensajeDeError">Complete todos los campos</p>
  <table width="80%"  border="0" align="center">
    <tr>
      <td colspan="4" class="subtitle">Datos Personales
        <input name="CodigoAlumno" value="<?php echo $_GET['CodigoAlumno'] ?>" type="hidden" > 
        <input name="CodigoRepresentante" type="hidden" value="<?php echo $_GET["CodigoRepresentante"]; ?>">        </td>
      </tr>
    <tr>
      <td align="right" class="NombreCampo">
        <input name="Creador" type="hidden" id="Creador" value="<?php echo $_COOKIE['MM_Username']; ?>">
      Nexo</td>
      <td class="FondoCampo"><?php if (isset($_GET["Nexo"])) {echo $_GET["Nexo"]; 
	  ?><input name="Nexo" type="hidden" value="<?php echo $_GET["Nexo"]; ?>"><?php 
	  } else { ?><input name="Nexo" type="text" class="TextosSimples" id="Nexo" value="<?php echo $row_RS_Repre['Nexo']; ?>" size="20">
      <?php } ?></td>
      <td align="right" class="NombreCampo">Representante</td>
      <td class="FondoCampo"><span id="sprytextfield12">
        <input name="SWrepre" type="text" class="TextosSimples" id="SWrepre" disabled size="5" value="<?php 
		if($row_RS_Repre['SWrepre']>"")
			echo $row_RS_Repre['SWrepre']; 
		else
			echo "SI";	
		?>" >
        <span class="textfieldRequiredMsg">Requerido</span></span> 
         <br>(en caso negativo debe traer documento que certifique)</td>
    </tr>
    <tr>
      <td align="right" class="NombreCampo">Apellidos</td>
      <td nowrap class="FondoCampo"><span id="sprytextfield1">
        <input name="Apellidos" type="text" class="TextosSimples"  size="20" value="<?php echo $row_RS_Repre['Apellidos']; ?>" >
        <span class="textfieldRequiredMsg">Requerido</span></span></td>
      <td align="right" class="NombreCampo">C&eacute;dula</td>
      <td class="FondoCampo"><span id="sprytextfield4">
        <input name="Cedula" type="text" class="TextosSimples"  size="20"  onKeyUp="return ValNumero(this);"  value="<?php echo $row_RS_Repre['Cedula']; ?>" >
        <span class="textfieldRequiredMsg">Requerido</span></span></td>
    </tr>
    <tr>
      <td align="right" class="NombreCampo">Nombres</td>
      <td class="FondoCampo"><span id="sprytextfield2">
        <input name="Nombres" type="text" class="TextosSimples"  size="20" value="<?php echo $row_RS_Repre['Nombres']; ?>" >
        <span class="textfieldRequiredMsg">Requerido</span></span></td>
      <td align="right" class="NombreCampo">Edo Civil</td>
      <td class="FondoCampo"><input name="EdoCivil" type="text" class="TextosSimples"  size="20" value="<?php echo $row_RS_Repre['EdoCivil']; ?>" ></td>
    </tr>
    <tr>
      <td align="right" class="NombreCampo">Lugar de Nacimiento</td>
      <td class="FondoCampo"><span id="sprytextfield3">
        <input name="LugarNac" type="text" class="TextosSimples"  size="20" value="<?php echo $row_RS_Repre['LugarNac']; ?>" >
        <span class="textfieldRequiredMsg">Requerido</span></span></td>
      <td align="right" class="NombreCampo">Nacionalidad</td>
      <td class="FondoCampo"><span id="sprytextfield5">
        <input name="Nacionalidad" type="text" class="TextosSimples"  size="20" value="<?php echo $row_RS_Repre['Nacionalidad']; ?>" >
        <span class="textfieldRequiredMsg">Requerido</span></span></td>
    </tr>
    <tr>
      <td align="right" class="NombreCampo">Fecha de Nacimiento</td>
      <td class="FondoCampo"><input type="hidden" name="FechaNac" id="FechaNac" value="<?php echo $row_RS_Repre['FechaNac']; ?>">
                        <?php Fecha('FechaNac', $row_RS_Repre['FechaNac']); ?></td>
      <td align="right" class="NombreCampo">&nbsp;</td>
      <td class="FondoCampo">&nbsp;</td>
    </tr>
    <tr>
      <td align="right" class="NombreCampo">&nbsp;</td>
      <td class="FondoCampo">&nbsp;</td>
      <td align="right" class="NombreCampo">&nbsp;</td>
      <td class="FondoCampo">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" class="subtitle">Informaci&oacute;n de Contacto</td>
      </tr>
    <tr>
      <td align="right" class="NombreCampo">Tel&eacute;fono Habitaci&oacute;n</td>
      <td class="FondoCampo"><span id="sprytextfield6">
        <input name="TelHab" type="text" class="TextosSimples"  size="20" value="<?php echo $row_RS_Repre['TelHab']; ?>" >
        <span class="textfieldRequiredMsg">Requerido</span></span></td>
      <td align="right" class="NombreCampo">Email principal </td>
      <td class="FondoCampo"><span id="sprytextfield10">
      <input name="Email1" type="text" class="TextosSimples"  size="20" value="<?php echo $row_RS_Repre['Email1']; ?>" >
      <span class="textfieldInvalidFormatMsg">Inv&aacute;lido</span></span></td>
    </tr>
    <tr>
      <td align="right" class="NombreCampo">Tel&eacute;fono Celular</td>
      <td class="FondoCampo"><span id="sprytextfield7">
        <input name="TelCel" type="text" class="TextosSimples"  size="20" value="<?php echo $row_RS_Repre['TelCel']; ?>" >
        <span class="textfieldRequiredMsg">Requerido</span></span></td>
      <td align="right" class="NombreCampo">Email secundario </td>
      <td class="FondoCampo"><span id="sprytextfield11">
      <input name="Email2" type="text" class="TextosSimples"  size="20" value="<?php echo $row_RS_Repre['Email2']; ?>" >
      <span class="textfieldInvalidFormatMsg">Inv&aacute;lido</span></span></td>
    </tr>
    <tr>
      <td align="right" class="NombreCampo">Tel&eacute;fono Trabajo</td>
      <td class="FondoCampo"><input name="TelTra" type="text" class="TextosSimples"  size="20" value="<?php echo $row_RS_Repre['TelTra']; ?>" ></td>
      <td align="right" class="NombreCampo">&nbsp;</td>
      <td class="FondoCampo">&nbsp;</td>
    </tr>
    <tr>
      <td align="right" class="NombreCampo">Direcci&oacute;n Habitaci&oacute;n</td>
      <td class="FondoCampo"><span id="sprytextarea1">
        <textarea name="Direccion" cols="30" rows="4" class="TextosSimples"><?php echo $row_RS_Repre['Direccion']; ?></textarea>
        <span class="textareaRequiredMsg">Requerido</span></span></td>
      <td colspan="2"><table width="100%"  border="0">
        <tr>
          <td align="right" class="NombreCampo">Urbanizaci&oacute;n</td>
          <td class="FondoCampo"><span id="sprytextfield8">
            <input name="Urbanizacion" type="text" class="TextosSimples"  size="20" value="<?php echo $row_RS_Repre['Urbanizacion']; ?>" >
            <span class="textfieldRequiredMsg">Requerido</span></span></td>
        </tr>
        <tr>
          <td align="right" class="NombreCampo">Ciudad</td>
          <td class="FondoCampo"><span id="sprytextfield9">
            <input name="Ciudad" type="text" class="TextosSimples"  size="20" value="<?php echo $row_RS_Repre['Ciudad']; ?>" >
            <span class="textfieldRequiredMsg">Requerido</span></span></td>
        </tr>
        <tr>
          <td align="right" class="NombreCampo">Cod Postal</td>
          <td class="FondoCampo"><input name="CodPostal" type="text" class="TextosSimples"  size="20" value="<?php echo $row_RS_Repre['CodPostal']; ?>" ></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td colspan="4" class="subtitle">Informaci&oacute;n del Trabajo </td>
      </tr>
    <tr>
      <td align="right" class="NombreCampo">Ocupaci&oacute;n</td>
      <td class="FondoCampo"><input name="Ocupacion" type="text" class="TextosSimples"  size="20" value="<?php echo $row_RS_Repre['Ocupacion']; ?>" ></td>
      <td align="right" class="NombreCampo">Profesi&oacute;n</td>
      <td class="FondoCampo"><input name="Profesion" type="text" class="TextosSimples"  size="20" value="<?php echo $row_RS_Repre['Profesion']; ?>" ></td>
    </tr>
    <tr>
      <td align="right" class="NombreCampo">Empresa</td>
      <td class="FondoCampo"><input name="Empresa" type="text" class="TextosSimples"  size="20" value="<?php echo $row_RS_Repre['Empresa']; ?>" ></td>
      <td align="right" class="NombreCampo">Grado<br>
        de 
        Instrucci&oacute;n</td>
      <td class="FondoCampo"><input name="GradoInstruccion" type="text" class="TextosSimples"  size="20" value="<?php echo $row_RS_Repre['GradoInstruccion']; ?>" ></td>
    </tr>
    <tr>
      <td align="right" class="NombreCampo">Actividad Empresa</td>
      <td class="FondoCampo"><input name="ActividadEmpresa" type="text" class="TextosSimples" size="20" value="<?php echo $row_RS_Repre['ActividadEmpresa']; ?>" ></td>
      <td align="right" class="NombreCampo">Cargo en la<br>
        Empresa</td>
      <td class="FondoCampo"><input name="CargoEmpresa" type="text" class="TextosSimples" size="20" value="<?php echo $row_RS_Repre['CargoEmpresa']; ?>" ></td>
    </tr>
    <tr>
      <td align="right" class="NombreCampo">Tiempo en la<br>
Empresa</td>
      <td class="FondoCampo"><input name="TiempoEmpresa" type="text" class="TextosSimples"  size="20" value="<?php echo $row_RS_Repre['TiempoEmpresa']; ?>" ></td>
      <td align="right" class="NombreCampo"><?php 
	  if ($row_RS_Repre['Remuneracion']>1000 or strlen($row_RS_Repre['Remuneracion'])>3) 
	  		$_sw_remuneracion = false; 
	  //else 
	  		$_sw_remuneracion = true; ?>
	  <?php if ($_sw_remuneracion){ ?>Remuneraci&oacute;n<br>
        mensual<?php }else{echo '&nbsp;';}  ?></td>
      <td class="FondoCampo">
      
      
      <input name="Remuneracion" type="<?php if ($_sw_remuneracion){ ?>text<?php }else{echo 'hidden';}  ?>" class="TextosSimples" size="20" value="<?php echo $row_RS_Repre['Remuneracion']; ?>" ></td>
    </tr>
    <tr>
      <td align="right" class="NombreCampo">Direcci&oacute;n del Trabajo </td>
      <td class="FondoCampo"><textarea name="DireccionTra" cols="30" rows="4" class="TextosSimples"><?php echo $row_RS_Repre['DireccionTra']; ?></textarea></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4"><div align="center">
        <input type="hidden" name="Datos_Revisado_Fecha" id="Datos_Revisado_Fecha" value="<?php echo date("Y-m-d") ?>">
        <input type="submit" value="Guardar">
        <br>
        <div align="center">(si no guarda verifique datos faltantes en la planilla)<br>
        </div>
        </div></td>
      </tr>
  </table>
  <?php if ($totalRows_RS_Repre == 1) { ?>
<input type="hidden" name="MM_update" value="form1"><?php } else {  ?>
  <input type="hidden" name="MM_insert" value="form1"><?php }?>
</form>
<p>&nbsp;</p>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur", "change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur", "change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur", "change"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur", "change"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {validateOn:["blur", "change"]});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "none", {validateOn:["blur", "change"]});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "none", {validateOn:["blur", "change"]});
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {validateOn:["blur", "change"]});
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8", "none", {validateOn:["blur", "change"]});
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9", "none", {validateOn:["blur", "change"]});
var sprytextfield10 = new Spry.Widget.ValidationTextField("sprytextfield10", "email", {isRequired:false, validateOn:["blur", "change"]});
var sprytextfield11 = new Spry.Widget.ValidationTextField("sprytextfield11", "email", {isRequired:false, validateOn:["blur", "change"]});
var sprytextfield12 = new Spry.Widget.ValidationTextField("sprytextfield12", "none", {validateOn:["blur", "change"]});
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
</html>