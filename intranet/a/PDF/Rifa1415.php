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
		$pdf->Cell(60 , $Ln , 'Domingo Familiar 07-12-2014' , $borde , 1 , 'C'); 
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
		$pdf->SetXY($x,$y);	$pdf->Cell(110 , $Ln , 'U.E. Colegio San Francisco de Asís' , $borde , 0 , 'C'); 
		$pdf->SetFont('Arial','B',10);
							$pdf->Cell(20 , $Ln , 'Rifa-Entrada' , $borde , 1 , 'R'); 	
		$pdf->SetFont('Arial','',7);
		$pdf->SetX($x);		$pdf->Cell(110 , $Ln/2.5 , 'Rif:J-00137023-4' , $borde , 0 , 'C'); 
							$pdf->Cell(20 , $Ln/2 , 'No.'.$NumRifa , $borde , 1 , 'R'); 
		$pdf->SetFont('Times','B',10);
		$pdf->SetX($x);		$pdf->Cell(110 , $Ln/1.5 , 'Domingo Familiar 07 de diciembre de 2014' , $borde , 0 , 'C'); 
							$pdf->Cell(20 , $Ln/1.5 , 'Valor Bs.140,oo' , $borde , 1 , 'R'); 
		$pdf->SetFont('Arial','',10);
		$pdf->SetX($x);		$pdf->Cell(80 , $Ln/1.5 , 'PREMIOS:' , 0 , 1 , 'L'); 
		$pdf->SetFont('Arial','B',8);
		$pdf->SetX($x+5); $pdf->Cell(130 , $Ln/1.8 , '1º Premio: Tablet 2 Spidertab PT-350 Premium' , $borde , 1 , 'L'); 
		$pdf->SetX($x+5); $pdf->Cell(60 , $Ln/1.8 , '2º Premio: Bs.5.000' , $borde , 0 , 'L'); 
						  $pdf->Cell(85 , $Ln/1.8 , '3º Premio: Cesta Navideña' , $borde , 1 , 'L'); 
		$pdf->SetX($x+5); $pdf->Cell(60 , $Ln/1.8 , '4º Premio: MP4 digital 2.0' , $borde , 0 , 'L'); 
						  $pdf->Cell(85 , $Ln/1.8 , '5º Premio: Cena para 2 personas en "El Gran Sasso"' , $borde , 1 , 'L'); 
		$pdf->SetX($x+5); $pdf->Cell(60 , $Ln/1.8 , '6º Premio: Masaje de anti-estrés' , $borde , 0 , 'L'); 
						  $pdf->Cell(60 , $Ln/1.8 , '7º Premio: Balón de fútbol Molten' , $borde , 1 , 'L'); 
		$pdf->SetX($x+5); $pdf->Cell(130 , $Ln/1.8 , '8º y 9º Premio: Maletín con ruedas Nike. Cortesía de Assisi Sport' , $borde , 1 , 'L'); 
		$pdf->SetX($x+5); $pdf->Cell(130 , $Ln/1.8 , '10º al 24º Premios: Bolsos deportivos. Cortesía de Assisi Sport' , $borde , 1 , 'L'); 
		$pdf->SetX($x+5); $pdf->Cell(130 , $Ln/1.8 , '25º al 29º Premios: Koalas deportivos. Cortesía de Assisi Sport' , $borde , 1 , 'L'); 
		$pdf->SetX($x+5); $pdf->Cell(130 , $Ln/1.8 , '25º al 29º Premios: GYM Baek Top Drawer. Cortesía de Assisi Sport' , $borde , 1 , 'L'); 
		$pdf->SetX($x+5); $pdf->Cell(130 , $Ln/1.8 , '38º al 42º Premios: Pasamontañas Nike. Cortesía de Assisi Sport' , $borde , 1 , 'L'); 

		$pdf->SetFont('Times','',8);
		$pdf->SetX($x);		
if ( $totalRows_RS_Alumno > 0 )
	$InvitadoPor = 'Invitado por: '.$Apellidos.' '.$Nombres.' '.Curso($CodigoCurso);

$pdf->MultiCell(130, $Ln/1.7 ,"Nota: El sorteo se efectuará el domingo 7 de Diciembre a las 4 pm en la misma sede. 
Lugar: 7ma transv. entre 4ta y 5ta Ave. Los Palos Grandes Tel:0212.283.25.75. 
Ticket no cancelado no participará en el sorteo. 
Fecha tope para retirar el premio: 31 de enero de 2015. " . $InvitadoPor ,0,'L');
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