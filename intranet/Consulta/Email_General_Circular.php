<?php 
//$MM_authorizedUsers = "99,91,95,90";
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

$Consulta = new Consulta();


if(true or isset($_GET['Email'])){


	$RS_Alumno = $mysqli->query($query_RS_Alumno);


	echo $query_RS_Alumno."<br><br>";
	
	while ($row_RS_Alumno = $RS_Alumno->fetch_assoc()) {
		
		
		
		$NumAlumnos++;
		
		//$Deuda_Alumno = ActulizaEdoCuentaDolar($row_RS_Alumno['CodigoAlumno'] , $Cambio_Dolar);
		
		
		//if($Deuda_Alumno > 1){
			
			
			
			$pdf='';
			$cabeceras = '';	
			$para='';
			$CodigoAlumno = $row_RS_Alumno['CodigoAlumno'];
			
			$asunto = 'Reenvio Circular '.$row_RS_Alumno['Apellidos']. " (".$CodigoAlumno.")";
			$cabeceras = 'MIME-Version: 1.0' . "\r\n";
			$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$cabeceras .= 'From: Colegio San Francisco de A. <colegio@colegiosanfrancisco.com>' . "\r\n";
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
						$EMails .= $row_RS_Repre['Email1']."  ";
					}
				} 
				//echo "<pre>$cabeceras</pre>";
				echo $CodigoAlumno . " " . $EMails."<br>";
				$EMails = "";
				$para .= ' Colegio San Francisco de A. <caja@sanfrancisco.e12.ve>';
				
				
				$pdf.='
				<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html>
				<head>
				
				<title>Untitled Document</title>
				</head>
				<body>';
				$pdf.='<br>';
				
				$pdf .= '<p>Estimado Sr. Representante del Alumno: ';
				
				$pdf .= $row_RS_Alumno['Nombres'].' '.$row_RS_Alumno['Nombres2'].' '.
							$row_RS_Alumno['Apellidos'].' '.$row_RS_Alumno['Apellidos2'].
							' ('.$row_RS_Alumno['CodigoAlumno'].') </p>';
				
				$pdf .= '<p>Curso: ' . Curso($row_RS_Alumno['CodigoCurso']).'</p>';
				
				$pdf .= '<p>Confiados en que cada familia está bien y con salud, nos dirigimos a ustedes para solicitarles revisen este link.</p>';
			
				$pdf .= '
				
				<h2><a href="http://www.colegiosanfrancisco.com/intranet/Consulta/Consulta.php?CodigoAlumno='.$row_RS_Alumno['CodigoClave'].'" target="_blank"> VER CONSULTA </a></h2>';
				
				$pdf .= '<p>Consulta a padres, madres, representates y responsables para la  aprobacion de asignacion de aporte por concepto de apoyo tecnológico.</p>';
				
				$pdf .= '<p>Este proceso debe hacerlo con cada hijo, en el caso de tener más de un estudiante en la institución.</p><p> Gracias y bendecido día</p>';
				
				$pdf .= '<p>Atentamente</p>';
				$pdf .= '<p>La Dirección</p>';
				//$pdf .= '<br>';
				//$pdf .= 'P.D. Si considera que hay algún error le pedimos disculpas y le agradecemos hacernos llegar sus comentarios.</p>';
				$pdf .= '</body></html>';
				
				
				
				echo $Consulta->Respuesta($CodigoAlumno , 1)."<br>";
				if( $Consulta->Respuesta($CodigoAlumno , 1) <> "Si" )
				if ( mail($para, $asunto, $pdf, $cabeceras )
					){
					echo ".<br>";
					
				} 
				
					++$No;
			}
		
		
		//} // if($totalRows_Pendiente>0 and $PendienteMes>1)
	
	
	} 
	
	
}
//echo "<pre>$pdf</pre>";


?>