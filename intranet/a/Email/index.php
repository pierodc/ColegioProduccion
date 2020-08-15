<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');

$CodigoAlumno = $_GET['CodigoAlumno'];
$Email = $_GET['Email'];

$Variable = new Variable();
$Cambio_Dolar = $Variable->view("Cambio_Dolar");


//SiEntro
if($Email == 'Aceptado'){
	$Observacion = 'Enviado Email Aceptado';
	$Area = "SolCupo";
	$lineas = file('NuevosIngresos_Aceptado.html', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	foreach ($lineas as $linea) {
		$txt.= $linea;
	}
}

//SiEntro
if($Email == 'SiEntro'){
	$Observacion = 'Enviado Email Ingreso';
	$Area = "SolCupo";
	$lineas = file('NuevosIngresos_Si_Entro.html', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	foreach ($lineas as $linea) {
		$txt.= $linea;
	}
}

//NuevosIngresos_Reunion_1er_G_1
if(substr($Email,0,4) == 'Cita'){
	$Fecha = DDMMAAAA(substr($Email,5,10));
	$Hora = substr($Email,15,7);
	$Observacion = $Email;
	$Area = "SolCupo";
	$lineas = file('NuevosIngresos_Citar.html', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	foreach ($lineas as $linea) {
		$txt.= $linea;
	}
}


//NoEntroEspera
if($Email == 'NoEntroEspera'){
	$Observacion = 'Enviado Email No Entro -> Lista de Espera';
	$Area = "SolCupo";
	$lineas = file('NuevosIngresos_No_Entro_Espera.html', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	foreach ($lineas as $linea) {
		$txt.= $linea;
	}
}

//NoEntroProxAno
if($Email == 'NoEntroProxAno'){
	$Observacion = 'Enviado Email No Entro -> Prox Ano';
	$Area = "SolCupo";
	$lineas = file('NuevosIngresos_No_Entro_ProxAno.html', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	foreach ($lineas as $linea) {
		$txt.= $linea;
	}
}

// Nuevo Ingreso Cuota
if($Email == 'NueIng_Cuota'){
	$Observacion = 'Enviado Email nueva cuota pago';
	$Area = "SolCupo";
	$lineas = file('NueIng_Cuota.html', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	foreach ($lineas as $linea) {
		$txt.= $linea;
	}
}


//Pagos Al PROVINCIAL
if($Email == 'Pagos_a_Provincial'){
	$Observacion = 'Pagos_a_Provincial';
	$Area = "Estado de Cuenta";
	
	$CodigoPago = $_GET['CodigoPago'];
	$sql = "SELECT * FROM ContableMov
		WHERE Codigo = '".$CodigoPago."'";
	$RS_pago = $mysqli->query($sql);
	$row_pago = $RS_pago->fetch_assoc();
	
	
	
	$lineas = file('Pagos_a Provincial.html', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	foreach ($lineas as $linea) {
		$txt.= $linea;
	}
	
	$sql = "UPDATE ContableMov
			SET FechaSolicitud = CURRENT_TIMESTAMP
			WHERE Codigo = '".$CodigoPago."'";
	$mysqli->query($sql);
	
	$txt = str_replace("#FechaPago#", DDMMAAAA($row_pago['Fecha']) ,$txt);
	$txt = str_replace("#Referencia#", $row_pago['Referencia'] ,$txt);
	$txt = str_replace("#MontoHaber#", Fnum($row_pago['MontoHaber']) ,$txt);

	
}


$sql = "SELECT * FROM Alumno
		WHERE CodigoAlumno = '".$CodigoAlumno."'";
$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();
extract($row);
$Alumno = Titulo_Mm($Nombres." ".$Nombres2." ".$Apellidos." ".$Apellidos2);


$sql = "SELECT * FROM Usuario
		WHERE Usuario = '".$Creador."'";
$RS_Usuario = $mysqli->query($sql);
$row_Usuario = $RS_Usuario->fetch_assoc();


$insertSQL = "INSERT INTO Observaciones (CodigoAlumno, Area, Observacion, Fecha, Hora, Por) 
	VALUES ('$CodigoAlumno','$Area','$Observacion $Creador','".date('Y-m-d')."', '".date('H:i:s')."','".$_COOKIE['MM_Username']."')";
$Result1 = $mysqli->query($insertSQL); 

echo $insertSQL;

$cabeceras = '';	
$para='';
$CodigoAlumno = $row_RS_Alumno['CodigoAlumno'];

$asunto = 'Proceso Nuevos Ingresos '.$CodigoAlumno;
$cabeceras = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$cabeceras .= 'From: Colegio San Francisco de A. <colegio@colegiosanfrancisco.com>' . "\r\n";
//$cabeceras .= 'Cco: Giampiero Di Campo <piero@sanfrancisco.e12.ve>' . "\r\n";

//$para = ' Giampiero Di Campo <piero@dicampo.com>';

$para = ' '.$row_Usuario['Nombres'] .' '.$row_Usuario['Apellidos'].' <'.$row_Usuario['Usuario'].'>';

$txt = str_replace("#Alumno#",$Alumno ,$txt);
$txt = str_replace("#CodigoPropietario#",$CodigoPropietario ,$txt);
$txt = str_replace("#Fecha#",$Fecha ,$txt);
$txt = str_replace("#Hora#",$Hora ,$txt);
$txt = str_replace("#AnoEscolarProx#",$AnoEscolarProx ,$txt);
$txt = str_replace("#Costo_Proceso_Sol_Cupo#" , Fnum($Costo_Proceso_Sol_Cupo * $Cambio_Dolar) ,$txt);
$txt = str_replace("#Costo_Dolares_Proceso_Sol_Cupo#" , Fnum($Costo_Dolares_Proceso_Sol_Cupo) ,$txt);
$txt = str_replace("#Costo_Reserva_Cupo#" , Fnum($Costo_Reserva_Cupo * $Cambio_Dolar) ,$txt);
$txt = str_replace("#Costo_Cuota_Familia#" , Fnum($Costo_Cuota_Familia * $Cambio_Dolar ) ,$txt);



$Resultado = mail($para, $asunto, $txt, $cabeceras); 
 

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Email</title>
</head>

<body  onload="setTimeout('window.close()',10000)" >
Enviando Email ...<br><br>
<?php 
	echo ' '.$row_Usuario['Nombres'] .' '.$row_Usuario['Apellidos']. " &lt;" .$row_Usuario['Usuario'] . "&gt; ->> " ; 
	
	if( $Resultado ) 
		echo " <B>EXITO </B>"; 
	
	?>
	<br><br><br><br><br><br>

<?php echo $txt; ?>
</body>
</html>