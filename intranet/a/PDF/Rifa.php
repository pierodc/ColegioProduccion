<?php 
require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php'); 
require_once('../../../inc/rutinas.php'); 
require_once('../../../inc/fpdf.php');
//require_once('../../../inc/rpdf.php');  

if(isset($_GET['CodigoCurso']))
	header("Location: ".$_SERVER['PHP_SELF']."?Curso=".$_GET['CodigoCurso']);


if( !isset( $_GET['NumRifa'] ) ){
	$RS_Alumno = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
	$row_RS_Alumno = mysql_fetch_assoc($RS_Alumno);
	$totalRows_RS_Alumno = mysql_num_rows($RS_Alumno);
}
$borde=0;
$Ln = 4.68;

$pdf=new FPDF('P', 'mm', 'Letter');
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',10);

//if(isset($_GET['Desde']))
//	$NumRifa = ($_GET['Desde']*5)+$_GET['NumRifa'];
//else
	$NumRifa = 0;
$NoLista = 0;
do { 

	if( $totalRows_RS_Alumno > 0 ){
		extract($row_RS_Alumno);}

	if($CodigoCurso == $_GET['Curso']){
	$NoLista++;
	$pdf->AddPage();
 	$pdf->SetMargins(5,5,5);
	$i = 0;
	$y = 0;
		
	for($i = 0; $i <= 4; $i++){
		$pdf->SetDrawColor(0);
		$NumRifa = substr('000000'. ++$NumRifa*1 ,-5);

		$y = 5+($Ln*11*$i);
		$x = 5;

		$pdf->Image('../../../img/solcolegio.jpg' , 170 , $y , 0, 10);
		$pdf->Image('../../../img/SelloCol.jpg' , 200 , $y + 25, 0, 12);
		
		$pdf->SetXY($x,$y);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(60 , $Ln , 'U.E. Colegio San Francisco de Asís' , $borde , 1 , 'C'); 
		$pdf->Cell(60 , $Ln , 'Domingo Familiar 29-11-2015' , $borde , 1 , 'C'); 
		$pdf->Cell(60 , $Ln , 'No.'.$NumRifa , $borde , 1 , 'C'); 
		$pdf->Cell(60 , $Ln , 'Nombre:' , $borde , 1 , 'L'); 
		$pdf->Cell(60 , $Ln , '' , 'B' , 1 , 'L'); 
		$pdf->Cell(60 , $Ln , '' , 'B' , 1 , 'L'); 
		$pdf->Cell(60 , $Ln , 'Teléfono:' , $borde , 1 , 'L'); 
		$pdf->Cell(60 , $Ln , '' , 'B' , 1 , 'L'); 
		$pdf->Cell(60 , $Ln , '' , 'B' , 1 , 'L'); 
		$pdf->Cell(60 , $Ln , 'Invitado por Al. Cod.: '.$CodigoAlumno.' No.'. $NoLista  , $borde , 0 , 'L'); 
		$pdf->Cell(60 , $Ln , '.' , $borde , 1 , 'L'); 
		
		$pdf->SetDrawColor(200);
		//if($i != 0)		
		$pdf->Line(5, $y+50, 210, $y+50);
		$pdf->Line(70, 5, 70, 270);
		
		
		$x = 75;
		$pdf->SetFont('Times','B',13);
		//$y = $y - 0;
		$pdf->SetXY($x,$y); $pdf->Cell(110 , $Ln , 'U.E. Colegio San Francisco de Asís' , $borde , 0 , 'C'); 
		$pdf->SetFont('Arial','B',10);
				  $pdf->Cell(20 , $Ln , 'Rifa-Entrada' , $borde , 1 , 'R'); 	
		$pdf->SetFont('Arial','',7);
		$pdf->SetX($x);	  $pdf->Cell(110 , $Ln/2.5 , 'Rif:J-00137023-4' , $borde , 0 , 'C'); 
				  $pdf->Cell(20 , $Ln/2 , 'No.'.$NumRifa , $borde , 1 , 'R'); 
		$pdf->SetFont('Times','B',10);
		$pdf->SetX($x);	  $pdf->Cell(110 , $Ln/1.5 , 'Domingo Familiar 29 de noviembre de 2015' , $borde , 0 , 'C'); 
				  $pdf->Cell(20 , $Ln/1.5 , 'Valor Bs.500,oo' , $borde , 1 , 'R'); 
		$pdf->SetFont('Arial','',10);
		$pdf->SetX($x);	  $pdf->Cell(80 , $Ln/1.5 , 'PREMIOS:' , 0 , 1 , 'L'); 
		$pdf->SetFont('Arial','B',8);
		$pdf->SetX($x+2); $pdf->Cell(73 , $Ln/1.8 , '1º Tablet Android 7 Pulgadas con WiFi' , $borde , 0 , 'L'); 
		                  $pdf->Cell(70 , $Ln/1.8 , '2º Bs.15.000' , $borde , 1 , 'L'); 
		$pdf->SetX($x+2); $pdf->Cell(73 , $Ln/1.8 , '3º Cesta Navideña' , $borde , 0 , 'L'); 
		                  $pdf->Cell(60 , $Ln/1.8 , '4º MP4 digital 4GB' , $borde , 1 , 'L'); 
		$pdf->SetX($x+2); $pdf->Cell(73 , $Ln/1.8 , '5º Corneta portátil recargable Aigo' , $borde , 0 , 'L'); 
		                  $pdf->Cell(60 , $Ln/1.8 , '6º Cena para 2 en "El Gran Sasso"' , $borde , 1 , 'L'); 
		$pdf->SetX($x+2); $pdf->Cell(73 , $Ln/1.8 , '7º Masaje Cortesía Corpo Angelico Spa' , $borde , 0 , 'L'); 
		                  $pdf->Cell(60 , $Ln/1.8 , '8º Maletín Nike Cortesía de Assisi' , $borde , 1 , 'L'); 
		$pdf->SetX($x+2); $pdf->Cell(73 , $Ln/1.8 , '9º Bolsos deportivos Cortesía de Assisi Sport' , $borde , 1 , 'L'); 
		$pdf->SetX($x+2); $pdf->Cell(60 , $Ln/1.8 , '10º al 12º Koalas deportivos Cortesía de Assisi Sport' , $borde , 1 , 'L'); 
		$pdf->SetX($x+2); $pdf->Cell(73 , $Ln/1.8 , '13º al 15º GYM Baek Top Drawer. Cortesía de Assisi Sport' , $borde , 1 , 'L'); 
		$pdf->SetX($x+2); $pdf->Cell(73 , $Ln/1.8 , '16º y 17º Morral Abismo. Cortesía de Assisi Sport' , $borde , 1 , 'L'); 
		$pdf->SetX($x+2); $pdf->Cell(80 , $Ln/1.8 , '18º y 19º Lonchera Top Drawer. Cortesía de Assisi Sport' , $borde , 0 , 'L'); 
		                  $pdf->Cell(73 , $Ln/1.8 , '20º y 21º Cooler' , $borde , 1 , 'L'); 

		$pdf->SetFont('Times','',8);
		$pdf->SetX($x);		
if ( $totalRows_RS_Alumno > 0 )
	$InvitadoPor = 'Invitado por: '.$Apellidos.' '.$Nombres.' '.Curso($CodigoCurso);

$pdf->MultiCell(130, $Ln/1.7 ,"Nota: El sorteo se efectuará el domingo 29 de Noviembre a las 4 pm en la misma sede. 
Lugar: 7ma transv. entre 4ta y 5ta Ave. Los Palos Grandes Tel:0212.283.25.75. 
Ticket no cancelado no participará en el sorteo. 
Fecha tope para retirar el premio: 31 de enero de 2016. " . $InvitadoPor ,0,'L');
		$pdf->SetX($x);		
							//$pdf->Cell(80 , $Ln/1.5 , ' ' , $borde , 0 , 'L');
							//$pdf->Cell(20 , $Ln/1.5 , ' . ' , $borde , 0 , 'L');

		$pdf->SetXY(180,$y+45);		
				//$pdf->Ln(); 
				
							$pdf->Cell(30 , $Ln/1.5 , 'No.'.$NumRifa , $borde , 1 , 'R' ); 
							
		$pdf->Line(190, $y+50, 210, $y+30);

		$pdf->Ln(); 
				//$y = $y + 0;

		
	}}

// if($_GET['NumRifaHasta']>1 and $NumRifa < $_GET['NumRifaHasta'] ){
//	 $SWsigue = true;
//	 }
//	 else
//	 {
		if ( $totalRows_RS_Alumno > 0 ){
			$row_RS_Alumno = mysql_fetch_assoc($RS_Alumno);
			if($CodigoCurso != $_GET['Curso'])	
				$NumRifa = $NumRifa + 5;
			
			}
	//		echo $NumRifa.' ';
	
		if ( $row_RS_Alumno )
			$SWsigue = true;
		else
			$SWsigue = false;
	//}
 //echo ' Lista: '.++$NumLis.'<br>';
} while ( $SWsigue );  


$pdf->Output();


?>