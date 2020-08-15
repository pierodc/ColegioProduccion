<?php 
require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php'); 
require_once('../../../inc/rutinas.php'); 
require_once('../../../inc/fpdf.php'); 

mysql_select_db($database_bd, $bd);
$RS_Alumno = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumno = mysql_fetch_assoc($RS_Alumno);
$totalRows_RS_Alumno = mysql_num_rows($RS_Alumno);

if($totalRows_RS_Alumno>0){

$pdf=new FPDF('P', 'mm', 'Letter');
$pdf->SetMargins(5,5,5);
do{	
	extract($row_RS_Alumno);
	$MargDer = 1; 
	$fotoNew = '../../../'.$AnoEscolar.'/150/'.$CodigoAlumno.'.jpg';
	$fotoOld = '../../../'.$AnoEscolarAnte.'/150/'.$CodigoAlumno.'.jpg';
	
	if(file_exists($fotoNew)){
		$foto = $fotoNew;}
	else{
		$foto = $fotoOld;}
		
	if(file_exists($foto) or true){
		
		$pdf->AddPage();
		$pdf->SetAutoPageBreak(false);
		$borde = 0;
		$Ln = 4;
		
		$pdf->Image('../../../img/Boleta.jpg', 40, 80, 150);
		
		$pdf->SetY(20);
		
		$pdf->SetTextColor(0,0,150);
		$pdf->SetFont('Arial','B',14);
		$pdf->Cell($MargDer); $pdf->Cell(200 , 5 , 'U.E. COLEGIO' , $borde , 1 , 'C'); 
		$pdf->SetFont('Times','B',24);
		$pdf->Cell($MargDer); $pdf->Cell(200 , 6 , 'San Francisco de Asís' , $borde , 1 , 'C'); 
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell($MargDer); $pdf->Cell(200 , 4 , 'RIF: J-00137023-4' , $borde , 1 , 'C'); 
		
		$pdf->Ln();
		
		$pdf->SetFont('Times','B',14);
		$pdf->Cell($MargDer); $pdf->Cell(200 , 5 , 'Boletín Informativo' , $borde , 1 , 'C'); 
		$pdf->Cell($MargDer); $pdf->Cell(200 , 5 , 'Educación Primaria' , $borde , 1 , 'C'); 
		$pdf->Cell($MargDer); $pdf->Cell(200 , 5 , 'Año Escolar '.$AnoEscolar , $borde , 1 , 'C'); 
		
		
		$AnchoFoto = 40;
		
		if(file_exists($foto)){
			$pdf->Image($foto, 30  , 220 , $AnchoFoto);
		}
		
		$pdf->SetY(220);
		$pdf->SetFont('Arial','B',16);
		$pdf->SetTextColor(0,0,150);
		$pdf->Cell($MargDer+$AnchoFoto+25); $pdf->Cell(80 , 8 , $Nombres.' '.$Nombres2 , $borde , 1 , 'L'); 
		$pdf->Cell($MargDer+$AnchoFoto+25); $pdf->Cell(80 , 8 , $Apellidos.' '.$Apellidos2 , $borde , 1 , 'L'); 
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B',14);
		$pdf->Cell($MargDer+$AnchoFoto+25); $pdf->Cell(44 , 8 , Curso($CodigoCurso) , $borde , 1 , 'L'); 
		$Docente = DocenteGuia($CodigoCurso);
		$pdf->SetFont('Arial','B',12);
		
		if($Docente[0]>''){
			$pdf->Cell($MargDer+$AnchoFoto+25); $pdf->Cell(44 , 7 , 'Maestra: '.$Docente[0] , $borde , 1 , 'L'); }


		$pdf->SetY( 280 );
		$pdf->SetFont('Times','',6);
		$pdf->SetTextColor(120);
		$pdf->Cell($MargDer); $pdf->Cell(32 , 4 , ++$j , $borde , 0 , 'L'); 
		
	}
} while($row_RS_Alumno = mysql_fetch_assoc($RS_Alumno));


$pdf->Output();
}

?>