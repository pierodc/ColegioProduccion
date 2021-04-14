<?php 
//$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable,provee";
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 


$colname_RS_Alumno = "-1";
if (isset($_GET['CodigoAlumno'])) {
  $colname_RS_Alumno = $_GET['CodigoAlumno'];
}
mysql_select_db($database_bd, $bd);
$query_RS_Alumno = sprintf("SELECT * FROM Alumno WHERE CodigoAlumno = %s", GetSQLValueString($colname_RS_Alumno, "int"));
$RS_Alumno = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumno = mysql_fetch_assoc($RS_Alumno);
$totalRows_RS_Alumno = mysql_num_rows($RS_Alumno);

mysql_select_db($database_bd, $bd);
$query_RS_Repre = "SELECT * FROM Representante WHERE Creador = '".$row_RS_Alumno['Creador']."' AND SWrepre LIKE '%%s%%'";

	$query_RS_Repre = "SELECT * FROM RepresentanteXAlumno , Representante 
						WHERE RepresentanteXAlumno.CodigoRepresentante = Representante.CodigoRepresentante  
						RepresentanteXAlumno.CodigoAlumno = '".$row_RS_Alumno['CodigoAlumno']."' 
						AND SWrepre LIKE '%%s%%'";

$RS_Repre = mysql_query($query_RS_Repre, $bd) or die(mysql_error());
$row_RS_Repre = mysql_fetch_assoc($RS_Repre);
$totalRows_RS_Repre = mysql_num_rows($RS_Repre);

$cabeceras .= 'To: ';
do {
$cabeceras .= $row_RS_Repre['Nombres'].' '.$row_RS_Repre['Apellidos']. ' <'.$row_RS_Repre['Email1'].'>, ';
$destinatarios .= $row_RS_Repre['Email1'].'<br>';
echo $row_RS_Repre['Email1']. '<br>';
} while ($row_RS_Repre = mysql_fetch_assoc($RS_Repre)); 
$cabeceras .= "\r\n";



$CodigoAlumno = "-1";
if (isset($_GET['CodigoAlumno'])) {
  $CodigoAlumno = $_GET['CodigoAlumno'];
}
mysql_select_db($database_bd, $bd);
$query_Pendiente = sprintf("SELECT * FROM ContableMov, Alumno WHERE ContableMov.CodigoPropietario = %s and Alumno.CodigoAlumno=ContableMov.CodigoPropietario AND SWCancelado = '0' ORDER BY MontoHaber DESC, ContableMov.Fecha ASC, Codigo ASC", GetSQLValueString($CodigoAlumno, "int")); //echo $query_Pendiente;
$Pendiente = mysql_query($query_Pendiente, $bd) or die(mysql_error());
$row_Pendiente = mysql_fetch_assoc($Pendiente);
$totalRows_Pendiente = mysql_num_rows($Pendiente);

$contenido = ' 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<p><strong>Aviso de Cobro</strong></p>
<p>Estimado Sr. Representante del Alumno: <strong>'. $row_RS_Alumno['Nombres'] .' '. $row_RS_Alumno['Nombres2'] .' '. $row_RS_Alumno['Apellidos'] .' '. $row_RS_Alumno['Apellidos2']. '</strong></p>
<p>Nuestros registros indican que Ud. tiene una deuda con el Colegio seg&uacute;n le indicamos a continuaci&oacute;n</p>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td>Descripci&oacute;n</td>
    <td align="center">Per&iacute;odo</td>
    <td align="right">Monto Pendiente</td>
  </tr>';
  do { 
  
 $PendienteMes = $row_Pendiente['MontoDebe']-$row_Pendiente['MontoHaber']-$row_Pendiente['MontoAbono'];
  
  if ($PendienteMes>0) {
  
  
$contenido = $contenido. ' <tr>
      <td>'. $row_Pendiente['Descripcion'].'</td>
      <td align="center">'. Mes_Ano( $row_Pendiente['ReferenciaMesAno']). '</td>
      <td align="right">';
	  
	  if($row_Pendiente['SWValidado']=='1'){
	  
	   $saldo=$saldo+$row_Pendiente['MontoDebe']-$row_Pendiente['MontoHaber']-$row_Pendiente['MontoAbono'];
	   
	   $contenido = $contenido.Fnum($row_Pendiente['MontoDebe']-$row_Pendiente['MontoHaber']-$row_Pendiente['MontoAbono']);} 
	  
	  
	  $contenido = $contenido.'</td>
    </tr>
    '; } } while ($row_Pendiente = mysql_fetch_assoc($Pendiente)); 
$contenido = $contenido. '  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><strong>Saldo '. Fnum($saldo). '</strong></td>
  </tr>
</table>
<p>Le agradecemos hacer efectivo su compromiso con el Colegio dentro de los primeros 5 d&iacute;as de cada mes</p>
<p>Le recordamos los n&uacute;meros de cuenta del Colegio</p>
<p>Banco Mercantil 0105-0079-66-8079-03718-3 (Transferencias s&oacute;lo desde Mercantil)</p>
<p>Banco Provincial 0108-0013-7801-0000-4268 (Transferencias desde otros bancos)</p>
<p>Favor enviar comprobante de pago por este correo caja@sanfrancisco.e12.ve</p>
<p>Se despide</p>
<p>Atentamente</p>
<p>La Administraci&oacute;n</p>
<p></p>
<p>Si Ud. no recibe las circulares del Colegio v&iacute;a correo electr&oacute;nico <br />
<br />
le pedimos env&iacute;e un correo en blanco a la siguiente dirección: colegio-sfda+subscribe@googlegroups.com </p>
<p></p>
<p>P.D. Si considera que este mensaje es un error por favor responda al mismo con sus comentarios</p>
<p>Este Correo fue enviado a las direcciones:</p>';
$contenido = $contenido. $destinatarios;

$contenido = $contenido.'</body>
</html>';



// asunto
$asunto = 'Aviso de Cobro';
// mensaje
$aa= '
<html>
<head>
  <title>Observacion Caja</title>
</head>
<body>
  <p><a href=http://www.colegiosanfrancisco.com/intranet/a/Estado_de_Cuenta_Alumno.php?CodigoPropietario='.$_GET['CodigoPropietario'].'>ver</a></p>
  <p>'.$_POST['Observacion'].'</p>
</body>
</html>
';

// Para enviar correo HTML, la cabecera Content-type debe definirse
$cabeceras .= 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Cabeceras adicionales
//$cabeceras .= 'To: María <piero@dicampo.com>, Kelly <pierodc@dicampo.com>' . "\r\n";
$cabeceras .= 'From:Colegio San Francisco de A.<caja@sanfrancisco.e12.ve>' . "\r\n";
//$cabeceras .= 'Cc:caja@sanfrancisco.e12.ve' . "\r\n";
//$cabeceras .= 'Bcc:piero@dicampo.com' . "\r\n";
// Enviarlo
if(isset($_GET['Email'])){
 

mail($para, $asunto, $contenido, $cabeceras); 
}

mysql_free_result($RS_Alumno);

mysql_free_result($RS_Repre);

mysql_free_result($Pendiente);


echo $contenido;
?>