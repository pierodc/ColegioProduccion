<?php require_once('../../Connections/bd.php'); ?><?php require_once('../../inc/rutinas.php'); ?><?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

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


$contenido = ' 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<p><strong>Circular Importante</strong></p>
<p>Estimado Sr. Representante del Alumno: <strong>'. $row_RS_Alumno['Nombres'] .' '. $row_RS_Alumno['Nombres2'] .' '. $row_RS_Alumno['Apellidos'] .' '. $row_RS_Alumno['Apellidos2']. '</strong></p>
<p></p>
<p>Estamos creando una lista de correo (Email) para poder enviarle las comunicaciones del Colegio.</p>
<p>Para ello le solicitamos que ingrese su direcci&oacute;n en el recuadro siguiente, haga click en "Suscribirse"</p>
<p>ATENCION: luego de suscribirse recibir&aacute; un correo donde DEBER&Aacute; confirmar su suscripci&oacute;n</p>
<p></p>
<p></p>

  <form action="http://groups.google.com/group/colegio-sfda/boxsubscribe">
  <input type=hidden name="hl" value="es">
  Correo electrónico: <input type=text name=email>
  <input type=submit name="sub" value="Suscribirse">
</form>



<p>Se despide</p>
<p>Atentamente</p>
<p>La Administraci&oacute;n</p>
<p></p>
<p></p>
</body>
</html>';



$para .= 'piero@dicampo.com';
// asunto
$asunto = 'Circular Importante';


// Para enviar correo HTML, la cabecera Content-type debe definirse
$cabeceras .= 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Cabeceras adicionales
//$cabeceras .= 'To: María <piero@dicampo.com>, Kelly <pierodc@dicampo.com>' . "\r\n";
$cabeceras .= 'From:Colegio San Francisco de A.<colegio@sanfrancisco.e12.ve>' . "\r\n";
$cabeceras .= 'Cc:colegio@sanfrancisco.e12.ve' . "\r\n";
$cabeceras .= 'Bcc:piero@dicampo.com' . "\r\n";
// Enviarlo
if(isset($_GET['Email'])){
echo mail($para, $asunto, $contenido, $cabeceras); 
}

mysql_free_result($RS_Alumno);

mysql_free_result($RS_Repre);

mysql_free_result($Pendiente);


echo $contenido;
?>
