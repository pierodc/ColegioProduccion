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
$pdf->SetMargins(0,0,0);
do{	 
extract($row_RS_Alumno);
$PagDer = 20; 



$pdf->AddPage();
$pdf->SetAutoPageBreak(false);
$borde=0;
$Ln = 4;

$pdf->Image('../../../img/Boleta.jpg', 40, 80, 150);

$pdf->Ln(10);

$pdf->SetTextColor(0,0,150);
$pdf->SetFont('Arial','B',14);
$pdf->Cell($PagDer); $pdf->Cell(170 , 5 , 'COLEGIO' , $borde , 1 , 'C'); 
$pdf->SetFont('Times','B',24);
$pdf->Cell($PagDer); $pdf->Cell(170 , 6 , 'San Francisco de Asís' , $borde , 1 , 'C'); 
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','',8);
$pdf->Cell($PagDer); $pdf->Cell(170 , 4 , 'RIF: J-00137023-4' , $borde , 1 , 'C'); 

$pdf->Ln();

$pdf->SetFont('Times','B',14);
$pdf->Cell($PagDer); $pdf->Cell(170 , 5 , 'Boletín Informativo' , $borde , 1 , 'C'); 
$pdf->Cell($PagDer); $pdf->Cell(170 , 5 , 'Educación Inicial' , $borde , 1 , 'C'); 
$pdf->Cell($PagDer); $pdf->Cell(170 , 5 , 'Año Escolar '.$AnoEscolar , $borde , 1 , 'C'); 

$fotoNew = '../../../'.$AnoEscolar.'/150/'.$CodigoAlumno.'.jpg';
$fotoOld = '../../../'.$AnoEscolarAnte.'/150/'.$CodigoAlumno.'.jpg';
if(file_exists($fotoNew)){
	$foto = $fotoNew;}
else{
	$foto = $fotoOld;}

if(file_exists($foto)){
	$pdf->Image($foto, $PagDer  , 155+70, 30);
}

$pdf->SetY(230);
$pdf->SetFont('Arial','B',16);
$pdf->SetTextColor(0,0,150);
$pdf->Cell($PagDer+40); $pdf->Cell(80 , 8 , $Nombres.' '.$Nombres2 , $borde , 1 , 'L'); 
$pdf->Cell($PagDer+40); $pdf->Cell(80 , 8 , $Apellidos.' '.$Apellidos2 , $borde , 1 , 'L'); 
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',14);
$pdf->Cell($PagDer+40); $pdf->Cell(44 , 8 , Curso($CodigoCurso) , $borde , 1 , 'L'); 
$Docente = DocenteGuia($CodigoCurso);
$pdf->SetFont('Arial','B',12);
$pdf->Cell($PagDer+40); $pdf->Cell(44 , 7 , 'Maestra: '.$Docente[0] , $borde , 1 , 'L'); 
$pdf->Cell($PagDer+40); $pdf->Cell(44 , 7 , 'Aux: '.$Docente[3].' '.$Docente[4] , $borde , 1 , 'L'); 



/*
$pdf->Image('../../../img/Tao.jpg', 110, 125, 60);

$pdf->SetY( 50 );
$pdf->SetFont('Times','B',16);

$PagDer=40;
$pdf->Cell($PagDer); $pdf->Cell(44 , 6 , 'Señor,' , $borde , 1 , 'L'); 
$pdf->Cell($PagDer); $pdf->Cell(44 , 6 , 'hazme instrumento de tu paz:' , $borde , 1 , 'L'); 
$pdf->Cell($PagDer); $pdf->Cell(44 , 6 , 'que donde haya odio,' , $borde , 1 , 'L'); 
$pdf->Cell($PagDer); $pdf->Cell(44 , 6 , '     siembre yo amor;' , $borde , 1 , 'L'); 
$pdf->Cell($PagDer); $pdf->Cell(44 , 6 , 'donde haya duda, fe;' , $borde , 1 , 'L'); 
$pdf->Cell($PagDer); $pdf->Cell(44 , 6 , '' , $borde , 1 , 'L'); 
$pdf->Cell($PagDer); $pdf->Cell(44 , 6 , 'donde haya desesperación,' , $borde , 1 , 'L'); 
$pdf->Cell($PagDer); $pdf->Cell(44 , 6 , '     esperanza;' , $borde , 1 , 'L'); 
$pdf->Cell($PagDer); $pdf->Cell(44 , 6 , 'donde haya tinieblas, luz;' , $borde , 1 , 'L'); 
$pdf->Cell($PagDer); $pdf->Cell(44 , 6 , 'donde haya tristeza, alegría.' , $borde , 1 , 'L'); 
$pdf->Cell($PagDer); $pdf->Cell(44 , 6 , '' , $borde , 1 , 'L'); 
$pdf->Cell($PagDer); $pdf->Cell(44 , 6 , 'Concédeme, Maestro bueno:' , $borde , 1 , 'L'); 
$pdf->Cell($PagDer); $pdf->Cell(44 , 6 , 'que no busque ser consolado,' , $borde , 1 , 'L'); 
$pdf->Cell($PagDer); $pdf->Cell(44 , 6 , '     sino consolar;' , $borde , 1 , 'L'); 
$pdf->Cell($PagDer); $pdf->Cell(44 , 6 , 'Ser comprendido,' , $borde , 1 , 'L'); 
$pdf->Cell($PagDer); $pdf->Cell(44 , 6 , '     sino comprender,' , $borde , 1 , 'L'); 
$pdf->Cell($PagDer); $pdf->Cell(44 , 6 , 'ser amado, sino amar.' , $borde , 1 , 'L'); 
$pdf->Cell($PagDer); $pdf->Cell(44 , 6 , '' , $borde , 1 , 'L'); 
$pdf->Cell($PagDer); $pdf->Cell(44 , 6 , 'Pues es dando' , $borde , 1 , 'L'); 
$pdf->Cell($PagDer); $pdf->Cell(44 , 6 , '     como recibimos;' , $borde , 1 , 'L'); 
$pdf->Cell($PagDer); $pdf->Cell(44 , 6 , 'perdonando' , $borde , 1 , 'L'); 
$pdf->Cell($PagDer); $pdf->Cell(44 , 6 , '     como somos perdonados' , $borde , 1 , 'L'); 
$pdf->Cell($PagDer); $pdf->Cell(44 , 6 , 'y muriendo' , $borde , 1 , 'L'); 
$pdf->Cell($PagDer); $pdf->Cell(44 , 6 , '     como nacemos a la vida verdadera.' , $borde , 1 , 'L'); 

$pdf->Cell($PagDer); $pdf->Cell(100 , 10 , 'Amen' , $borde , 1 , 'R'); 
$pdf->Cell($PagDer); $pdf->Cell(100 , 10 , 'San Francisco de Asís' , $borde , 1 , 'R'); 
*/

$pdf->SetY( 280 );
$pdf->SetFont('Times','b',6);
$pdf->SetTextColor(120);
$pdf->Cell($PagDer); $pdf->Cell(32 , 4 , ++$j , $borde , 0 , 'L'); 


} while($row_RS_Alumno = mysql_fetch_assoc($RS_Alumno));


$pdf->Output();
}

?>