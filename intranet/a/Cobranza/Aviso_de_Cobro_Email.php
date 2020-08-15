<?php 
$MM_authorizedUsers = "99,91,95,90";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');



if(isset($_GET['porCurso'])){
?><a href="<?php  echo "Aviso_de_Cobro_Email.php?procesando=1&CodigoCurso=".$_GET['CodigoCurso'];  ?>&Email=1" ><img src="/i/email_go.png" width="32" height="32" border="0" /></a><?
}

if(isset($_GET['porAlumno'])){
?><a href="<?php  echo "Aviso_de_Cobro_Email.php?procesando=1&CodigoAlumno=".$_GET['CodigoAlumno'];  ?>&Email=1" ><img src="/i/email_go.png" width="32" height="32" border="0" /></a><?
}


if(isset($_GET['Email'])){


	$RS_Alumno = $mysqli->query($query_RS_Alumno);


//echo $query_RS_Alumno;
	$DeudaCurso = 0;
	while ($row_RS_Alumno = $RS_Alumno->fetch_assoc()) {
		
		$Deuda_Alumno = ActulizaEdoCuentaDolar($row_RS_Alumno['CodigoAlumno'] , $Cambio_Dolar);
		
		//echo $row_RS_Alumno['CodigoAlumno'] ." ". $Cambio_Dolar. "<br>";
		
		//echo $row_RS_Alumno['CodigoAlumno'] ." ". $Deuda_Alumno. "<br>";
		
		if($Deuda_Alumno > 1){
			
			$DeudaCurso += $row_RS_Alumno['Deuda_Actual'];
			$saldo=0;
			$pdf='';
			$cabeceras = '';	
			$para='';
			$CodigoAlumno = $row_RS_Alumno['CodigoAlumno'];
			
			$asunto = 'Aviso de Cobro '.$row_RS_Alumno['Apellidos']. " (".$CodigoAlumno.")";
			$cabeceras = 'MIME-Version: 1.0' . "\r\n";
			$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$cabeceras .= 'From: Colegio San Francisco de A. <caja@sanfrancisco.e12.ve>' . "\r\n";
			$cabeceras .= 'Cco: Giampiero Di Campo <piero@sanfrancisco.e12.ve>' . "\r\n";
				
			$query_RS_Repre = "SELECT * FROM RepresentanteXAlumno, Representante 
								WHERE RepresentanteXAlumno.CodigoRepresentante = Representante.CodigoRepresentante
								AND RepresentanteXAlumno.SW_Representante <> 'no'
								AND RepresentanteXAlumno.SW_Representante <> 'n'
								AND RepresentanteXAlumno.SW_Representante <> 'NO'
								AND RepresentanteXAlumno.SW_Representante <> 'N'
								AND (RepresentanteXAlumno.Nexo = 'Padre' OR RepresentanteXAlumno.Nexo = 'Madre')
								AND RepresentanteXAlumno.CodigoAlumno = '".$CodigoAlumno."'";
			
			$RS_Repre = $mysqli->query($query_RS_Repre);
			$totalRows_RS_Repre = $RS_Repre->num_rows;
		
			$cabeceras .= 'To: ';
			if($totalRows_RS_Repre > 0){
				while ($row_RS_Repre = $RS_Repre->fetch_assoc()) {
					if($row_RS_Repre['Email1']>' '){
						$cabeceras .= $row_RS_Repre['Nombres'].' '.
									  $row_RS_Repre['Apellidos']. 
									  ' <'.$row_RS_Repre['Email1'].'>, ';
					}
				} 
				//echo "<pre>$cabeceras</pre>";
	
				$para .= ' Colegio San Francisco de A. <caja@sanfrancisco.e12.ve>';
				
				
				
				
				
				
				
				
				$pdf.='
				<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html>
				<head>
				
				<title>Untitled Document</title>
				</head>
				<body>';
				$pdf.='Aviso de Cobro<br>';
				
				$pdf .= '<p>Estimado Sr. Representante del Alumno: ';
				
				$pdf .= $row_RS_Alumno['Nombres'].' '.$row_RS_Alumno['Nombres2'].' '.
							$row_RS_Alumno['Apellidos'].' '.$row_RS_Alumno['Apellidos2'].
							' ('.$row_RS_Alumno['CodigoAlumno'].') </p>';
				
				$pdf .= '<p>Curso: ' . Curso($row_RS_Alumno['CodigoCurso']).'</p>';
				
				//$pdf .= '<p>Cumpla con su compromiso a tiempo para poder ir directamente a reunirse con el docente de su representado el día de entrega de boletas de calificaciones.</p>';
				
				$pdf .= '<h3>Esperamos esten muy bien y resguardados en casa. En el colegio estamos haciendo nuestro mayor esfuerzo para poder cumplir con el soporte de los docentes y demas personal, sin embargo no es posible cumplir a cabalidad sin el aporte de los padres.</h3>';
				
				$pdf .= '<p>Quedamos a su disposición por el whatsapp +58.414.303.44.44 para resolver sus situación de manera mas expedita y asi poder pasar por caja directamente a retirar su factura.</p>';
				
				$pdf .= "<p>Le indicamos que nuestro sistema indica para el dia de hoy que Ud tiene una deuda con la institución.</p>";
				
				$pdf .= '<p>El cuerpo docente y demás empleados contamos con su pago puntual para superar la difícil situación que estamos viviendo.</p>';
				
				$pdf .= '<p>A continuación puede visualizar su</p>
				
				<h2><a href="http://www.colegiosanfrancisco.com/Aviso_de_Cobro.php?CodigoPropietario='.$row_RS_Alumno['CodigoClave'].'"> AVISO DE COBRO </a></h2>';
				
				
				$pdf .= '<p>Agradecemos completar exaustivamente el formulario de <b>registro de pago</b> para poder conciliar su trasacción lo antes posible.</p>';
				
				
				$pdf .= '<p>Se despide<br>';
				$pdf .= 'Atentamente<br>';
				$pdf .= 'La Administración<br>';
				$pdf .= '<br>';
				//$pdf .= 'P.D. Si considera que hay algún error le pedimos disculpas y le agradecemos hacernos llegar sus comentarios.</p>';
				$pdf .= '</body></html>';
				
				
				
				
				
				
				
				
				
				$saldo = $saldo*1;
				
				if ( mail($para, $asunto, $pdf, $cabeceras )){
					echo ".";
					
				} 
				
					++$No;
			}
		} // if($totalRows_Pendiente>0 and $PendienteMes>1)
	} 
	echo "<br>Deudores: ".$No."<br>";
	echo 'DeudaCurso ' . Fnum($DeudaCurso);
	
}
//echo "<pre>$pdf</pre>";


?>