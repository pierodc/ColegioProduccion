<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php');

if(isset($_GET['Codigo'])){
	$sql_GASTO = "SELECT * FROM Contabilidad 
					WHERE Codigo = '$_GET[Codigo]'";
	$RS = $mysqli->query($sql_GASTO);
	$row_Edita = $RS->fetch_assoc();
	extract($row_Edita);
}


//$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

// Ejecuta $sql
//$RS = $mysqli->query($sql);
//$row = $RS->fetch_assoc();

$borde = 1;
$Ln = 4.25;

$pdf=new FPDF('P', 'mm', 'Letter');
$pdf->AddPage();

$pdf->SetFillColor(255,255,255);
//$pdf->SetMargins(5,5,5);
//$pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/img/NombreCol.jpg' , 30, 5, 0, 12);

//$pdf->SetXY( 30,10 );
$pdf->SetFont('Arial','',12);


//$pdf->SetXY( 30,10 );
$pdf->Cell(100 , $Ln , "COMPROBANTE DE RETENCIÓN DEL IMPUESTO AL VALOR AGREGADO" ,$borde ,1,'C'); 

$pdf->MultiCell(100 , $Ln , "(Ley IVA - Art. 11: \"Serán responsables del pago del impuesto en calidad de agentes de retención, los compradores o adquirientes de determinados bienes muebles y los receptores de ciertos servicios, a quienes la Administración Tributaria designe como tal)." ,$borde ,'C'); 

$pdf->Cell(100 , $Ln , "0. NRO. COMPROBANTE" ,$borde ,1,'C'); 
$pdf->Cell(100 , $Ln , "1. FECHA" ,$borde ,1,'C'); 
$pdf->Cell(100 , $Ln , "2. NOMBRE O RAZÓN SOCIAL DEL AGENTE DE RETENCIÓN" ,$borde ,1,'C'); 
$pdf->Cell(100 , $Ln , "3. REGISTRO DE INFORMACIÓN FISCAL DEL AGENTE DE RETENCIÓN" ,$borde ,1,'C'); 
$pdf->Cell(100 , $Ln , "4. PERÍODO FISCAL" ,$borde ,1,'C'); 
$pdf->Cell(100 , $Ln , "5. DIRECCIÓN FISCAL DEL AGENTE DE RETENCIÓN" ,$borde ,1,'C'); 
$pdf->Cell(100 , $Ln , "6. NOMBRE O RAZÓN SOCIAL DEL SUJETO RETENIDO" ,$borde ,1,'C'); 
$pdf->Cell(100 , $Ln , "7. REGISTRO DE INFORMACIÓN FISCAL DEL SUJETO RETENIDO (R.I.F.)" ,$borde ,1,'C'); 


$pdf->Cell(100 , $Ln , "COMPRAS INTERNAS O IMPORTACIONES" ,$borde ,1,'C'); 

$pdf->Cell(100 , $Ln , "IMPORTACIONES" ,$borde ,1,'C'); 




$pdf->SetFont('Arial','',6);
$borde="1";
$_y = 150;
$Ln = 3;
$pdf->SetXY( 10,$_y ); $pdf->MultiCell(10 , $Ln , "OPER. NRO" ,$borde ,'C'); 
$pdf->SetXY( 20,$_y ); $pdf->MultiCell(16 , $Ln , "FECHA DE LA FACTURA" ,$borde ,'C'); 
$pdf->SetXY( 40,$_y ); $pdf->MultiCell(15 , $Ln , "NUMERO DE FACTURA" ,$borde ,'C'); 
$pdf->SetXY( 60,$_y ); $pdf->MultiCell(15 , $Ln , "NUMERO DE CONTROL" ,$borde ,'C'); 
$pdf->SetXY( 80,$_y ); $pdf->MultiCell(12 , $Ln , "Nº NOTA DE CRDTO" ,$borde ,'C'); 
$pdf->SetXY( 100,$_y ); $pdf->MultiCell(12 , $Ln , "TIPO DE TRANSAC" ,$borde ,'C');  
$pdf->SetXY( 120,$_y ); $pdf->MultiCell(12 , $Ln , "N° DE FACTURA AFECTADA" ,$borde ,'C');  
$pdf->SetXY( 140,$_y ); $pdf->MultiCell(20 , $Ln , "TOTAL COMPRAS INCLUYENDO EL IVA" ,$borde ,'C');  
$pdf->SetXY( 160,$_y ); $pdf->MultiCell(20 , $Ln , "COMPRAS SIN DERECHO A CRÉDITO IVA" ,$borde ,'C');  
$pdf->SetXY( 180,$_y ); $pdf->MultiCell(20 , $Ln , "BASE IMPONIBLE" ,$borde ,'C');  
$pdf->SetXY( 200,$_y ); $pdf->MultiCell(5 , $Ln , "%" ,$borde ,'C'); 
$pdf->SetXY( 220,$_y ); $pdf->MultiCell(15 , $Ln , "IMPUESTO IVA" ,$borde ,'C'); 
$pdf->SetXY( 240,$_y ); $pdf->MultiCell(15 , $Ln , "IVA RETENIDO" ,$borde ,'C'); 

$_y = 160;
$pdf->SetXY( 190,$_y ); $pdf->MultiCell(20 , $Ln , "99.999.999,99" ,$borde ,'C'); 

/*




*/


$pdf->SetXY( 10,$_y+30 );
$pdf->Cell(100 , $Ln , "FIRMA Y SELLO AGENTE DE RETENCIÓN" ,$borde ,0,'C'); 
$pdf->Cell(100 , $Ln , "RECIBI CONFORME ESTA CONSTANCIA DE RETENCION" ,$borde ,0,'C'); 













$pdf->Output();
?>