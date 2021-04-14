<?php 
$MM_authorizedUsers = "2,91,99";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');



//echo $CodigoAlumno;

$_var = new Variable();
$Cambio_Dolar = $_var->view('Cambio_Dolar');
ActulizaEdoCuentaDolar($CodigoAlumno ); 



// ELIMINA Movimiento
if ((isset($_GET['Codigo'])) && ($_GET['Codigo'] != "") && (isset($_GET['EliminarMov']))) {
$deleteSQL = "DELETE FROM ContableMov 
				WHERE Codigo='".$_GET['Codigo']."'
				AND RegistradoPor = '".$MM_Username."'";
$mysqli->query($deleteSQL);				
header("Location: Pagos.php?CodigoPropietario=".$_GET['CodigoPropietario']);
}


// UBICA REF DUPLICADA
$colname_RS_Busca_Referencia = "-1";
if (isset($_POST['Referencia'])) {
	$colname_RS_Busca_Referencia = $_POST['Referencia'];
}

$query_RS_Busca_Referencia = sprintf("SELECT * FROM ContableMov 
									  WHERE Referencia = %s 
									  AND MontoHaber = %s
									  AND (Tipo = 1 OR Tipo = 2)", 
									  GetSQLValueString($colname_RS_Busca_Referencia, "int"),
									  GetSQLValueString(coma_punto($_POST['MontoHaber']), "double"));


$RS_Busca_Referencia = $mysqli->query($query_RS_Busca_Referencia);
$row_RS_Busca_Referencia = $RS_Busca_Referencia->fetch_assoc();
$totalRows_RS_Busca_Referencia = $RS_Busca_Referencia->num_rows;

/*

$RS_Busca_Referencia = mysql_query($query_RS_Busca_Referencia, $bd) or die(mysql_error());
$row_RS_Busca_Referencia = mysql_fetch_assoc($RS_Busca_Referencia);
$totalRows_RS_Busca_Referencia = mysql_num_rows($RS_Busca_Referencia);
*/


$mensaje = "";
if ($_GET["mensaje"]=='duplicado') {
$mensaje = "El instrumento de pago ya fue utilizado. El pago no se registr&oacute;";}


if ($totalRows_RS_Busca_Referencia > 0 ) { // REFERENCIA DUPLICADA 
	$retorna = $_SERVER['PHP_SELF']."?CodigoPropietario=".$_GET['CodigoPropietario']."&mensaje=duplicado";
	header("Location: ".$retorna); 
}// FIN UBICA REF DUPLICADA

else { // REFERENCIA unica

	$editFormAction = $_SERVER['PHP_SELF'];
	if (isset($_SERVER['QUERY_STRING'])) {
		$editFormAction .= "?"."CodigoPropietario=".$_GET['CodigoPropietario'];
	}


	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1") and $_POST["Email_Pago"] > "") {
		$sql = "UPDATE Alumno SET Email_Pago = '".$_POST["Email_Pago"]."'
				WHERE CodigoAlumno = '".$_POST["CodigoPropietario"]."'";
		$mysqli->query($sql);		
	}

	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {


		$Fecha = $_POST['FY_Fecha'].'-'.$_POST['FM_Fecha'].'-'.$_POST['FD_Fecha'];

		//$_POST['MontoHaber'];

		$insertSQL = sprintf("INSERT INTO ContableMov 
		(BancoOrigen, CodigoCuenta, CodigoPropietario, Tipo, Fecha, Referencia, ReferenciaOriginal, Descripcion, MontoHaber, RegistradoPor, CodigoReciboCliente, CiRifEmisor, Observaciones, Whatsapp) 
		VALUES (%s,%s,%s,%s,%s, %s,%s,%s,%s,%s, %s,%s,%s,%s)",
					GetSQLValueString($_POST['BancoOrigen'], "text"),
					GetSQLValueString($_POST['CodigoCuenta'], "int"),
					GetSQLValueString($_POST['CodigoPropietario'], "int"),
					GetSQLValueString($_POST['Tipo'], "text"),
					GetSQLValueString($Fecha , "date"),

					GetSQLValueString($_POST['Referencia']*1, "text"),
					GetSQLValueString($_POST['Referencia']*1, "text"),
					GetSQLValueString($_POST['Descripcion'], "text"),
					GetSQLValueString(coma_punto($_POST['MontoHaber']), "double"),
					GetSQLValueString($_POST['RegistradoPor'], "text"),

					GetSQLValueString($_POST['CodigoReciboCliente'], "text"),
					GetSQLValueString($_POST['CiRifEmisor'], "text"),
					GetSQLValueString($_POST['Observaciones'], "text"),
					GetSQLValueString($_POST['Whatsapp'], "text"));

		$Result1 = mysql_query($insertSQL, $bd) or die(mysql_error());
		$mensaje = "Pago registrado. Deber&aacute; ser verificado por la administraci&oacute;n";

		//echo $insertSQL;
	}
}// fin REFERENCIA unica

$colname_RS_ContableMov = "-1";
if (isset($_GET['CodigoPropietario'])) {
	$colname_RS_ContableMov = $_GET['CodigoPropietario'];
}

$query_RS_ContableMov = sprintf("SELECT * FROM ContableMov, Alumno 
								WHERE Alumno.CodigoClave = %s 
								AND Alumno.CodigoAlumno=ContableMov.CodigoPropietario 
								ORDER BY ContableMov.Fecha ASC, Codigo ASC"
								, GetSQLValueString($colname_RS_ContableMov, "text"));


$RS_ContableMov = $mysqli->query($query_RS_ContableMov);
$row_RS_ContableMov = $RS_ContableMov->fetch_assoc();
$totalRows_RS_ContableMov = $RS_ContableMov->num_rows;

/*


$RS_ContableMov = mysql_query($query_RS_ContableMov, $bd) or die(mysql_error());
$row_RS_ContableMov = mysql_fetch_assoc($RS_ContableMov);
$totalRows_RS_ContableMov = mysql_num_rows($RS_ContableMov);*/

$colname_RS_Alumno = "-1";
if (isset($_GET['CodigoPropietario'])) {
	$colname_RS_Alumno = $_GET['CodigoPropietario'];
}

$query_RS_Alumno = sprintf("SELECT * FROM Alumno WHERE CodigoClave = %s", GetSQLValueString($colname_RS_Alumno, "text"));


$RS_Alumno = $mysqli->query($query_RS_Alumno);
$row_RS_Alumno = $RS_Alumno->fetch_assoc();
$totalRows_RS_Alumno = $RS_Alumno->num_rows;

/*

$RS_Alumno = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumno = mysql_fetch_assoc($RS_Alumno);
$totalRows_RS_Alumno = mysql_num_rows($RS_Alumno);*/

$Email_Pago = $row_RS_Alumno['Email_Pago'];

$colname_Pendiente = "-1";
if (isset($_GET['CodigoPropietario'])) {
	$CodigoAlumno = $row_RS_Alumno['CodigoAlumno'];
}

$query_Pendiente = sprintf("SELECT * FROM ContableMov, Alumno 
						WHERE ContableMov.CodigoPropietario = %s 
						AND Alumno.CodigoAlumno=ContableMov.CodigoPropietario 
						AND SWCancelado = '0' 
						AND (MontoDebe > 1 OR MontoHaber > 1 OR MontoDebe_Dolares > .01 OR MontoHaber_Dolares > .01)
						ORDER BY MontoHaber DESC, ContableMov.Fecha ASC, Codigo ASC",
						GetSQLValueString($CodigoAlumno, "int")); 
//echo $query_Pendiente;


$Pendiente = $mysqli->query($query_Pendiente);
//$$row_Pendiente = $Pendiente->fetch_assoc();
$totalRows_Pendiente = $Pendiente->num_rows;

/*
$Pendiente = mysql_query($query_Pendiente, $bd) or die(mysql_error());
//$row_Pendiente = mysql_fetch_assoc($Pendiente);
$totalRows_Pendiente = mysql_num_rows($Pendiente);*/



?>
<html>
<head>
<title>Colegio San Francisco de As&iacute;s</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="shortcut icon" href="../img/favicon.ico">
<link href="../css/Level2_Arial_Text.css" rel="stylesheet" type="text/css">
<style type="text/css">
.style1 {color: #0000FF}
</style>
<script src="../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
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
    function ValDecimal(Control){
        Control.value = Control.value.replace(/[^0-9,]+/g,'');
		return Control;
    }
    
	//*** Fin del Codigo para Validar que sea un campo Numerico

</script>

</head>
<body bgcolor="e7e7e9" leftmargin="0" topmargin="20" marginwidth="0" marginheight="0"  >
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="Table_01">
<tr>
		<td bgcolor="#FFF8E8" width="31">
			<img src="../img/index_01.jpg" width="31" height="191" alt=""></td>
		<td bgcolor="#FFFFFF" width="197">
			<img src="../img/TitSol.jpg" width="197" height="191" alt=""></td>
		<td bgcolor="#0A1B69" align="left" width="100%">
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
    <td colspan="2"><img src="../img/b.gif" width="740" height="1"></td>
  </tr>
  <tr>
    <td colspan="2"><p class="Tit_Pagina">Estado de Cuenta</p></td>
  </tr>
  <tr>
    <td><a href="../intranet"><img src="../i/navigate-left32.png" width="32" height="32" border="0" align="absmiddle"> Regresar</a></td>
    <td align="center"></td>
  </tr>

  <tr>
    <td colspan="2" align="center"><p>Puede realizar los pagos en Deposito o Transferencia en: </p>
            <p>Banco Provincial:  0108-0013-7801-0000-4268 (Transferencias desde otros bancos)<br>
              Banco Mercantil:&nbsp; 0105-0079-6680-7903-7183 (Transferencias s&oacute;lo desde Mercantil)</p>
            <p> a nombre de: Colegio San Francisco de As&iacute;s. RIF No. J-00137023-4</p></td>
  </tr>

<?php if(isset($_GET["mensaje"])){ ?>
  <tr>
    <td colspan="2"><span align="center" class="MensajeDe<?php if($_GET["mensaje"]=='duplicado') { echo "Error";} else { echo "OK";} ?>"><?php echo $mensaje; ?></span></td>
  </tr>
<?php } ?>





<tr><td colspan="2" align="center">

 <? /*
<form method="post" name="form1" id="form1" action="<?php echo $editFormAction; ?>">



<table width="100%" border="0" align="center" bordercolor="#333333">
   
  
    <tr valign="baseline">
        <td colspan="3" valign="baseline" nowrap class="Tit_Blanco"><?php 
		echo $row_RS_Alumno['Apellidos'].", ".$row_RS_Alumno['Nombres']; ?></td>
    </tr>
    

    <tr valign="baseline">
        <td colspan="3" valign="baseline" nowrap class="subtitle">Registrar Pago</td>
    </tr>
    

    <tr valign="baseline">
      <td width="50%" align="right" valign="top" nowrap class="NombreCampo">Tipo de transacci&oacute;n</td>
      <td width="50%" class="FondoCampo"><span id="spryselect1">
        <select name="Tipo" required id="Tipo"  onChange="showHide(this)">
          <option value="-1">Seleccione...</option>
          <option value="1">Deposito</option>
          <option value="2">Transferencia</option>
        </select>
        <span class="selectInvalidMsg">Requerido</span><span class="selectRequiredMsg">Requerido</span></span></td>
    </tr>
    <tr valign="baseline">
     
      <td colspan="3" align="right">
        
        
        
          <table width="100%%" border="0" cellpadding="2">
            <tr>
              <td width="50%" align="right" class="NombreCampo">Fecha</td>
              <td width="50%" class="FondoCampo"><input name="Fecha" type="hidden" value="2008-00-00">
                <?php FechaFutura('Fecha', date('Y-m-d')) ?></td>
              </tr>
            <tr>
              <td align="right" class="NombreCampo">a la Cuenta del Colegio en</td>
              <td class="FondoCampo"><span id="spryselect2">
                <label>
                  <select name="CodigoCuenta" id="CodigoCuenta">
                    <option>Seleccione Banco</option>
                    <option value="1">Mercantil</option>
                    <option value="2">Provincial</option>
                    <?php  if ($_COOKIE['MM_UserGroup']=='99'){  ?>
                    <option value="3">Venezuela</option>
                    <option value="4">V. de Cred.</option><?php } ?>
                    </select>
                  </label>
                <span class="selectRequiredMsg">Requerido</span></span></td>
              </tr>
            <tr>
              <td align="right" class="NombreCampo">Numero de Movimiento o Confirmaci&oacute;n</td>
              <td class="FondoCampo"><span id="Referencia">
  <input type="text" name="Referencia" value="" size="15">
              </span></td>
              </tr>
            <tr>
              <td align="right" class="NombreCampo">Monto</td>
              <td class="FondoCampo"><span id="MontoHaber">
  <input type="text" name="MontoHaber" value="" size="15" onKeyUp="return ValDecimal(this);" >
              </span></td>
              </tr>
            </table>
            
        <div id="div2">
          <table width="100%%" border="0" cellpadding="2">
            <tr>
              <td width="50%" align="right" class="NombreCampo">Transferencia desde (su Banco)</td>
              <td width="50%" class="FondoCampo"><input type="text" name="BancoOrigen" id="BancoOrigen"></td>
            </tr>
            <tr>
              <td align="right" class="NombreCampo">Cedula o Rif emisor</td>
              <td class="FondoCampo"><input type="text" name="CiRifEmisor" id="CiRifEmisor"></td>
              </tr>
            </table>
  <script type="text/javascript">
<!--
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {validateOn:["blur", "change"], invalidValue:"-1"});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect2", {validateOn:["blur", "change"], invalidValue:"-1"});
//-->
  </script>
  </div>    
      </td>
      </tr>
    <tr valign="baseline">
        <td align="right" nowrap class="NombreCampo">Facturar a</td>
        <td align="left" class="FondoCampo"><select name="CodigoReciboCliente" id="select">
          <option value="0">
            <?php 
if($row_RS_Alumno['Fact_Nombre']>'')
echo $row_RS_Alumno['Fact_Nombre'];
else
echo "Seleccione..."; ?>
            </option>
          <?php 
$sql = "SELECT * FROM ReciboCliente
		WHERE CodigoAlumno = '$CodigoAlumno'";
$RS = mysql_query($sql, $bd) or die(mysql_error());
$row = mysql_fetch_assoc($RS);
$totalRows = mysql_num_rows($RS);
if($totalRows >= 1){
	do{
		extract($row);
		echo "<option value=\"$Codigo\">$Nombre</option>";
	} while($row = mysql_fetch_assoc($RS));
}
?>
        </select></td>
        </tr>
    <tr valign="baseline">
      <td align="right" nowrap class="NombreCampo">IMPORTANTE: indique los conceptos que está cancelando con este pago</td>
      <td  align="left" class="FondoCampo"><input name="Observaciones" required type="text" id="Observaciones" size="40"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap class="NombreCampo">numero de WhatsApp para resolver dudas</td>
      <td  align="left" class="FondoCampo"><input type="text" name="Whatsapp" id="Whatsapp"></td>
    </tr>
    <tr valign="baseline">
        <td align="right" nowrap class="NombreCampo">Si desea ser notificado sobre este pago<br>
          ingrese su email</td>
        <td  align="left" class="FondoCampo"><input name="Email_Pago" type="text" id="Email_Pago" size="40" value="<?php echo $Email_Pago ?>"></td>
        </tr>
    


    <tr valign="baseline">
      <td colspan="2" align="center" nowrap><p><br>
        <input type="submit" value="Guardar" <?php // onclick="this.disabled=true;this.form.submit();"?> >
        </p>
        <p class="FondoCampoInput">Estos pagos se verifican en el lapso de 48 Horas h&aacute;biles<br>
          <br>
        </p></td>
      </tr>
    
<tr>
  <td>
<input type="hidden" name="CodigoPropietario" value="<?php echo $row_RS_Alumno['CodigoAlumno']; ?>">
<input type="hidden" name="RegistradoPor" value="<?php echo $MM_Username; ?>">
<input type="hidden" name="Descripcion" value="Abono a cuenta">
<input type="hidden" name="MM_insert" value="form1">
</td>
  <td align="center"><a href="Historial_de_Pagos_Repre.php?CodigoPropietario=<?= $_GET['CodigoPropietario'] ?>"><img src="../i/book_previous.png" width="32" height="32" alt=""/><br>
       Historial de pagos</a></td>
  <td>&nbsp;</td>
    </tr>
	
	
	
	
	
</table></form>

*/ ?>


<a href="Historial_de_Pagos_Repre.php?CodigoPropietario=<?= $_GET['CodigoPropietario'] ?>"><img src="../i/book_previous.png" width="32" height="32" alt=""/><br>
       Historial de pagos</a>

</td></tr>
<tr>
  <td colspan="2" align="center" class="NombreCampoBIG">Para registrar pagos utilice el formulario siguiendo este <a href="../Aviso_de_Cobro.php?CodigoPropietario=<?= $CodigoPropietario ?>">LINK --&gt;</a></td>
</tr>



<tr>
  <td colspan="2"><table width="100%" align="center" cellpadding="3" bordercolor="#333333">
    <tr>
      <td colspan="12" class="subtitle">Estado de Cuenta (propuesto en asamblea)</td>
    </tr>
    <tr>
      <td class="NombreCampo">&nbsp;</td>
      <td class="NombreCampo">Fecha</td>
      <td class="NombreCampo" align="left">Descripci&oacute;n</td>
      <td class="NombreCampo" align="center">Mes</td>
      <td class="NombreCampo" align="center">&nbsp;</td>
      <td width="49" align="center" class="NombreCampo" >Base</td>
      <td width="49" align="center" class="NombreCampo" >IVA <?= $P_IVA_2 ."%"; ?></td>
      <td width="100" align="center" class="NombreCampo" >Debe</td>
      <td width="100" align="center" class="NombreCampo" >Haber/Abono</td>
      <td width="23" align="center" class="NombreCampo" >&nbsp;</td>
      <td width="24" align="center" class="NombreCampo" >Saldo</td>
      <td width="49" align="center" class="NombreCampo" >Estatus</td>
    </tr>
    <?php  $saldo=0; $Par = true; ?>
    <?php 
	
	while ( $row_Pendiente = $Pendiente->fetch_assoc()) { 
	extract($row_Pendiente);
	
	if($SWiva == 1) 
		$MontoIVA = round($MontoDebe * $P_IVA_2/100 , 2);
	else
		$MontoIVA = 0;
					
	if ($ReferenciaMesAno_Anterior <> $ReferenciaMesAno and $ReferenciaMesAno_Anterior > "") {
		?>
 <tr <?= $Etiqueta_Class ?>>
      <td colspan="12" align="right" nowrap class="TextosSimples"><? //$ReferenciaMesAno_Anterior ?>        <?php //if($SaldoMes>0) echo Fnum( $SaldoMes); $SaldoMes = 0; ?></td>
      </tr>
    		
		<?
		  if($In==''){
			  $In = "In";}
		  else{
			  $In = ""; }
		
	   }
	   $Etiqueta_Class =  ' class="Listado'.$In.'Par'.$Azul.'"';
	  
	// if ($totalRows_Pendiente > 0) { // Show if recordset not empty ?>
     
     
   
    
    <tr <?= $Etiqueta_Class ?>>

<td nowrap ><?php if ( $row_Pendiente['RegistradoPor'] == $MM_Username  and $row_Pendiente['RegistradoPor'] > ""){ ?>
<a href="Pagos.php?CodigoPropietario=<?php echo $_GET['CodigoPropietario']."&EliminarMov=1&Codigo=".$row_Pendiente['Codigo'] ?>"><img src="../img/b_drop.png" alt="" width="16" height="16"></a>
<?php }?></td>

<td nowrap ><?php echo date('d-m-Y', strtotime($row_Pendiente['Fecha']));  ?></td>

<td nowrap class="TextosSimples"><?php 
if($row_Pendiente['MontoHaber']>0){
	if($row_Pendiente['Tipo']==1) echo 'Dep ';
	if($row_Pendiente['Tipo']==2) echo 'Trans ';
	echo $row_Pendiente['BancoOrigen'].' '.$row_Pendiente['ReferenciaOriginal'];
}
else
	echo $row_Pendiente['Descripcion'];  
?></td>

<td nowrap class="TextosSimples"><?php 
if ($row_Pendiente['ReferenciaMesAno'] > '0' )
echo Mes_Ano( $row_Pendiente['ReferenciaMesAno']);  ?></td>
<td nowrap class="TextosSimples">&nbsp;<? 
		
		echo Fnum($MontoDebe_Dolares); 
		$TotalDeuda_Dolares += $MontoDebe_Dolares - $MontoAbono_Dolares; 
	
	?></td>

<td align="right" nowrap class="TextosSimples"><?= Fnum($MontoDebe); ?></td>

<td align="right" nowrap class="TextosSimples"><?= Fnum($MontoIVA); ?></td>

<td align="right" nowrap class="TextosSimples"><?= Fnum($MontoDebe + $MontoIVA); ?></td>

<td align="right" nowrap class="TextosSimples"><?php 

if ($MontoAbono > 0) {
	if ($MontoIVA > 0)
		$MontoAbono = round($MontoAbono  *  (1+($P_IVA_2/100)) , 2);
	echo "(".Fnum($MontoAbono).")";
	}
	
	
	if($MontoHaber>0) echo "(".$MontoHaber.")"; ?></td>

<td align="right" nowrap class="TextosSimples">&nbsp;</td>
<td align="right" nowrap class="TextosSimples"><?php 
$saldo += $MontoDebe + $MontoIVA - $MontoAbono - $MontoHaber; 

$SaldoMes += $MontoDebe + $MontoIVA - $MontoAbono - $MontoHaber; 

echo Fnum($saldo);  ?></td>

<td align="right" nowrap><?php if($row_Pendiente['SWValidado']=='1'){ ?>
  <img src="../img/b.gif" alt="" width="20" height="20">
  <?php } else { ?>
  <img src="../i/clock_edit.png" alt="" width="32" height="32">
  <?php } ?></td>

</tr>

<?php 
$ReferenciaMesAno_Anterior = $ReferenciaMesAno;
}  ?>

 <tr <?= $Etiqueta_Class ?>>
      <td colspan="12" align="right" nowrap class="TextosSimples"><? //$ReferenciaMesAno_Anterior ?>        <?php //echo Fnum( $SaldoMes); $SaldoMes = 0; ?></td>
      </tr>



    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;<? echo Fnum($TotalDeuda_Dolares) ?></td>
      <td colspan="5" align="right" nowrap  class="RTitulo"><strong>Saldo Pendiente</strong></td>
      <td align="right"  class="RTitulo"><strong><?php echo Fnum($saldo);?></strong></td>
      <td align="right" >&nbsp;</td>
    </tr>
  </table></td></tr>
<tr>
  <td colspan="2" align="center"><iframe width="100%" height="150" src="http://www.colegiosanfrancisco.com/intranet/a/Observacion.php?Area=PagosRepre&CodigoAlumno=<?php echo $row_RS_Alumno['CodigoClave']; ?>" frameborder="1" id="SWframe2"></iframe></td>
</tr>





</table>











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
<script type="text/javascript">
 
function showHide(elem) {
    if(elem.selectedIndex != 0) {
         //hide the divs
         for(var i=0; i < divsO.length; i++) {
             divsO[i].style.display = 'none';
        }
        //unhide the selected div
        document.getElementById('div'+elem.value).style.display = 'block';
    }
}
 
window.onload=function() {
    //get the divs to show/hide
    divsO = document.getElementById("form1").getElementsByTagName('div');
         for(var i=0; i < divsO.length; i++) {
             divsO[i].style.display = 'none';
        }
}
</script>

</body>
</html>