<?php 
$MM_authorizedUsers = "";
require_once('../../../inc_login_ck.php'); 
require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php'); 
require_once('../../../inc/rutinas.php'); 

require_once('../../../inc/fpdf.php'); 

$ConstanciaDe = $_GET['ConstanciaDe'];

$sql = "SELECT * FROM  Empleado 
		WHERE CodigoEmpleado = '" . $_GET['CodigoEmpleado']."'";
$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();
extract($row);


$pdf=new FPDF('P', 'mm', 'Letter');
$pdf->AddPage();
$pdf->SetMargins(25, 0 ,20);
$borde=0;
$Ln = 8;

$pdf->Image('../img/solcolegio.jpg', 10, 10, 0, 25);

$pdf->SetFont('Arial','I',14);
$pdf->Ln(1); 
$pdf->Cell(170 , 7.5 , 'Colegio' , $borde , 1 , 'C'); 

$pdf->SetFont('Arial','i',27);
$pdf->Cell(170 , 9 , 'San Francisco de Asís' , $borde , 1 , 'C'); 

$pdf->SetFont('Arial','B',9);
$pdf->Cell(170 , 3.5 , 'Inscrito en el MPPE con el Código No. S0934D1507' , $borde , 1 , 'C'); 
$pdf->Cell(170 , 3.5 , 'Teléfonos/Fax: (0212) 283.25.75 / 283.62.79 / 284.05.20' , $borde , 1 , 'C'); 
$pdf->Cell(170 , 3.5 , '7ma. Transversal, entre 4ta y 5ta Ave., Los Palos Grandes' , $borde , 1 , 'C'); 
$pdf->Cell(170 , 3.5 , 'www.ColegioSanFrancisco.com  |  colegio@ColegioSanFrancisco.com' , $borde , 1 , 'C'); 

$pdf->Line( 10 , 43 , 210 , 43);

$pdf->SetY( 50 );


$pdf->SetFont('Times','B',16);
$pdf->Cell(170 , $Ln , 'CONSTANCIA DE TRABAJO' , $borde , 1 , 'C'); 
$pdf->Ln($Ln);
$pdf->SetFont('Times','',14);



$pdf->MultiCell(170 , $Ln , "     Quien suscribe, Lic. Vita María Di Campo C., portadora de la cédula de identidad No.V-6.973.243, en su carácter de Directora del Colegio San Francisco de Asís, por medio de la presente hace constar que el(la) ciudadano(a):" , $borde , 'J'); 
	 
$pdf->Ln($Ln/2);
	 
$NombreCompleto = $Nombres." ".$Nombres2." ".$Apellidos." ".$Apellidos2;
$pdf->SetFont('Times','B',16);
$pdf->Cell(170 , $Ln , $NombreCompleto , $borde , 1 , 'C'); 
$pdf->SetFont('Times','',14);


$pdf->MultiCell(170 , $Ln , "Portador(a) de la cédula de identidad No.".$CedulaLetra.'-'.$Cedula ." presta sus servicios en esta empresa como:", $borde , 'J'); 

$pdf->Ln($Ln/2);


$pdf->Cell(170 , $Ln , $CargoLargo , $borde , 1 , 'C');  
$pdf->Ln($Ln/2);
$pdf->SetFont('Times','',14);



$pdf->SetFont('Times','',14);
$pdf->MultiCell(170 , $Ln , '     Constancia que se expide a petición de la parte interesada en Caracas, el '. date("d").' de '. Mes(date('m')) .' de '.date("Y").'.' , $borde , 'J'); 
//$pdf->MultiCell(170 , $Ln , '     Sin más que agregar y quedando a su disposición para verificar la presente, se despide' , $borde , 'J'); 
//$pdf->Cell(170 , $Ln , '     Atentamente,' , $borde , 1 , 'L'); 
$pdf->Ln($Ln*3);
$pdf->Cell(170 , $Ln , 'Lic. Vita M. Di Campo C.' , $borde , 1 , 'C'); 
$pdf->Cell(170 , $Ln , 'Directora' , $borde , 1 , 'C'); 


$pdf->SetY(250);
$pdf->SetFont('Arial','I',8);
$pdf->Cell(0 , 5 , 'VMDCC / '.$MM_Iniciales ,0,0,'L');


$pdf->Output();


mysql_free_result($RS_Alumno);
?>
