<?php 
require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 
require_once('../../../inc/fpdf.php'); 

mysql_select_db($database_bd, $bd);
$RS_Alumno = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumno = mysql_fetch_assoc($RS_Alumno);
$totalRows_RS_Alumno = mysql_num_rows($RS_Alumno);

$borde=0;
$Ln = 5;

$pdf=new FPDF('P', 'mm', 'Letter');
$pdf->SetFillColor(255,255,255);
$pdf->SetMargins(5,5,5);

// REGLAS
if(1==2){
	$posX=10;
	$posY=10;
	//$pdf->SetY($posY);
	//$pdf->SetX($posX);
	for ($i = 2; $i <= 26; $i++ ) {
		$pdf->Cell(10 , 10 , $i*10 , 1 , 0 , 'R'); 
	}
	$pdf->Ln(10);
	for ($i = 3; $i <= 25; $i++ ) {
		$pdf->Cell(10 , 10 , $i*10 , 1 , 1 , 'R'); 
	}
}
// FIN REGLA

do { 
$pdf->AddPage();
extract($row_RS_Alumno);

// COLEGIO
$pdf->Image('../../../img/Logo2012.jpg', 140, 50, 0, 50);
$pdf->Image('../../../img/NombreCol.jpg' , 130, 8, 70, 0);

$pdf->SetXY(105,25);$pdf->SetFont('Arial','',8);
$pdf->Cell(120 , 4 , 'RIF: J-00137023-4' , $borde , 1 , 'C'); 

$pdf->SetX(105);$pdf->SetFont('Arial','',8);
$pdf->Cell(120 , 4 , 'www.ColegioSanFrancisco.com' , $borde , 1 , 'C'); 

$pdf->SetX(105);
$pdf->Cell(120 , 4 , 'caja@colegiosanfrancisco.com' , $borde , 1 , 'C'); 

$pdf->SetX(105);
$pdf->Cell(120 , 4 , 'Tel: (0212) 283.25.75 / 62.79' , $borde , 1 , 'C'); 

$pdf->SetX(105);$pdf->SetFont('Arial','',12);
$pdf->Cell(120 , 8 , 'Año Escolar: '. $AnoEscolar , $borde , 0 , 'C'); 


$pdf->SetXY(135,100);


// ALUMNO
$pdf->SetX(115);$pdf->SetFont('Arial','',12);
$pdf->Cell(20 , 10 , 'Alumno: ' , $borde , 0 , 'R'); 

$pdf->SetFont('Arial','B',14);
$pdf->Cell(70 , 8 , ' ' . $Apellidos.', '.$Nombres.' '.$Nombres2 , 'B' , 1 , 'L'); 

$pdf->SetX(135);$pdf->SetFont('Arial','',8);
$pdf->Cell(95 , 5 , 'Usuario pág web: ' . $Creador , '' , 1 , 'L'); 

$pdf->SetX(115);$pdf->SetFont('Arial','',12);
$pdf->Cell(20 , 8 , 'Curso: ' , $borde , 0 , 'R');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(40 , 8 , ' ' . Curso($CodigoCurso) , 'B' , 0 , 'L');

$pdf->SetFont('Arial','',12);
$pdf->Cell(15 , 8 , 'Cod: ' , $borde , 0 , 'R'); 
$pdf->SetFont('Arial','B',12);
$pdf->Cell(15 , 8 , $CodigoAlumno , 'B' , 1 , 'C'); 


// FOTO ALUMNO
			$Foto = '../../../'.$AnoEscolar.'/' .$CodigoAlumno. '.jpg';
		if(file_exists($Foto))
			$pdf->Image($Foto , 120, 75, 15, 0);
		else{
			$Foto = '../../../'.$AnoEscolarAnte.'/' .$CodigoAlumno. '.jpg';
			if(file_exists($Foto))
				$pdf->Image($Foto , 120, 75, 15, 0);
		}



$pdf->SetX(105);$pdf->SetFont('Arial','',10);
$pdf->Cell(105 , 5 , '"Sólamente la Educación podrá salvar a la Humanidad."' , $borde , 1 , 'R'); 

$pdf->SetX(105);$pdf->SetFont('Arial','I',10);
$pdf->Cell(105 , 4 , 'Giacomo Di Campo' , $borde , 1 , 'R'); 


$pdf->SetFont('Arial','',10);
$pdf->SetXY(5,5);

$pdf->MultiCell(95, 4 ,'1. Esta Tarjeta de Control de Pago debe ser enviada todos los meses con el comprobante de depósito bancario o transferencia. Indique sobre el comprobante los datos del alumno. Exija que le sea devuelta a la brevedad posible firmada y sellada. 
2. El depósito debe ser hecho en efectivo y, por medidas de seguridad, le recomendamos acudir a cualquiera de los banco listados donde Ud. posea cuenta para realizar el retiro y deposito de manera simultánea a favor de:',0,'J');
$pdf->Ln(3);
$pdf->Cell(95 , 4 , 'Colegio San Francisco de Asís ' , $borde , 1 , 'C');
$pdf->Cell(95 , 4 , 'RIF J-00137023-4' , $borde , 1 , 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(95 , 4 , 'Banco Mercantil: 0105 0079 6680 7903 7183' , $borde , 1 , 'C');
$pdf->SetFont('Arial','BI',10);
$pdf->Cell(95 , 4 , 'transferencia desde el Mercantil.' , $borde , 1 , 'C');
$pdf->SetFont('Arial','B',10);
$pdf->Ln(3);
$pdf->Cell(95 , 4 , 'Banco Provincial 0108 0013 7801 0000 4268' , $borde , 1 , 'C');
$pdf->SetFont('Arial','BI',10);
$pdf->Cell(95 , 4 , 'transferencia desde todos los bancos.' , $borde , 1 , 'C');


$pdf->SetFont('Arial','',10);

$pdf->MultiCell(95, 4 ,'
3. Le pedimos registrar el pago por Internet y enviar el comprobante de pago lo antes posible en físico.
4. El costo anual o anualidad ha sido dividido en 12 cuotas pagaderas desde Septiembre hasta Agosto, ambas inclusive.
5. Las mensualidades deben ser pagadas por adelantado dentro de los primeros CINCO (5) días de cada mes.
',0,'J');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(95 , 8 , 'Le agradecemos su puntualidad' , $borde , 1 , 'C');
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(95, 4 ,'6. Le agradecemos notificarnos cualquier irregularidad que Ud. detecte telefonicamente o preferiblemente por escrito.',0,'J');
$pdf->Cell(95 , 4 , 'La Administración' , $borde , 1 , 'R');


  
} while ($row_RS_Alumno = mysql_fetch_assoc($RS_Alumno));  



$pdf->Ln($Ln);




$pdf->Output();


?>