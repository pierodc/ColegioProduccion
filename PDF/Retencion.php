<?php 
//$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 
//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php');



$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

// Ejecuta $sql
//$RS = $mysqli->query($sql);
//$row = $RS->fetch_assoc();

$borde = 1;
$Ln = 5;

$LnNueva;

$pdf=new FPDF('P', 'mm', 'Letter');
$pdf->AddPage();
//Reticula($pdf);
$pdf->SetFillColor(255,255,255);
//$pdf->SetMargins(5,5,5);
//$pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/img/NombreCol.jpg' , 30, 5, 0, 12);

//$pdf->SetXY( 30,10 );
//

// Ejecuta $sql y While
/*
$sql = "SELECT * FROM ReciboCliente
		WHERE Codigo = '1997'";
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	
	extract($row);
	$pdf->Cell(8.85 , $Ln , "texto" , $borde , 0 , 'C'); 
	$pdf->Ln($Ln);

}
*/

function TitCon ($Ln,$with,$x,$y,$tit,$cont,$pdf) {
	$pdf->SetFont('Arial','',6);
	$pdf->SetXY($x,$y);
	$pdf->Cell($with, $Ln*.7, $tit, 1, 0, 'C');
	
	$pdf->SetFont('Arial','B',8);
	$pdf->SetXY($x,$y+$Ln*.7);
	$pdf->Cell($with, $Ln*1.3, $cont, 1, 0, 'C');

	
	}





$sql = "SELECT * FROM Retencion, ReciboCliente
		WHERE Retencion.CodigoProveedor = ReciboCliente.Codigo
		AND Retencion.Codigo = '".$_GET['c']."'";
		
$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();
extract($row);




$pdf->SetFont('Arial','B',10);
$pdf->SetXY(10,10);
$pdf->Cell(100, $Ln, 'COMPROBANTE DE RETENCION DEL IMPUESTO AL VALOR AGREGADO', 1, 0, 'L');

$pdf->SetXY(10,20);
$pdf->Cell(100, $Ln, 'Ley IVA - Art 11 ""', 1, 0, 'L');


// TitCon ($Ln,$with,$x,$y,$tit,$cont,$pdf)

$LnNueva = 30;
TitCon ($Ln,35, 140,$LnNueva,'0. NRO COMPROBANTE',$NumeroRetencion,$pdf);
TitCon ($Ln,25, 180,$LnNueva,'1. FECHA',DDMMAAAA($FechaRetencion),$pdf);

$LnNueva += $Ln*2 + $Ln/3;
TitCon ($Ln,70, 10,$LnNueva,'2. NOMBRE O RAZON SOCIAL DEL AGENTE DE RETENCION','COLEGIO SAN FRANCISCO DE ASIS CA',$pdf);
TitCon ($Ln,75, 85,$LnNueva,'3. REGISTRO DE INFORMACION FISCAL DEL AGENTE DE RETENCION','J-00137023-4',$pdf);
TitCon ($Ln,40, 165,$LnNueva,'4. PERIODO FISCAL','AÑO: 2018 / MES: 12',$pdf);

$LnNueva += $Ln*2 + $Ln/3;
TitCon ($Ln, 195, 10,$LnNueva,'5. DIRECCION FISCAL DEL AGENTE DE RETENCION',$Colegio_Direccion,$pdf);

$LnNueva += $Ln*2 + $Ln/3;
TitCon ($Ln,95, 10,$LnNueva,'6. NOMBRE O RAZON SOCIAL DEL SUJETO RETENIDO',$Nombre,$pdf);
TitCon ($Ln,95, 110,$LnNueva,'7. REGISTRO DE INFORMACION FISCAL DEL AGENTE DE RETENCION',$RIF,$pdf);

$titulos = array (
			array(8 , "OPER No"),
			array(15 , "Fecha de la factura"),
			array(15 , "Número de la factura"),
			array(15 , "Número de control"),
			array(15 , "No Nota de Crédito"),
			array(15 , "Tipo de transacción"),
			array(15 , "No de factura afectada"),
			array(20 , "Total compras inclueyndo el IVA"),
			array(24 , "Compras sin derecho a crédito IVA"),
			array(15 , "Base imponible"),
			array(8  , "\r\n%"),
			array(15 , "\r\nImpuesto IVA"),
			array(15 , "\r\nRetenido")
			);

$Factura = array(
			array ("1", "30-11-2018", "00031201", "ZGA0002499", "", "", "", "13.333,75", "", "11.494,61", "16", "0", "1.379,36"),
			array ("1", "04-12-2018", "00031209", "ZGA0002499", "", "", "", "10.988,02", "", "", "16", "0", "1.379,36"));

$pdf->SetFont('Arial','',6);


$LnNueva += $Ln*2 + $Ln/3;
$pdf->SetXY(152 , $LnNueva);
$pdf->MultiCell(38, $Ln, "Compras internas o Importaciones" ,1,"C",1);


$LnNueva += $Ln;
$x_inicial = 10; 
foreach ($titulos as $titulo){
	$pdf->SetXY($x_inicial , $LnNueva);
	$x_inicial += $titulo[0];
	$pdf->MultiCell($titulo[0], $Ln*.8, $titulo[1] ,1,"C",1);
}


$LnNueva += $Ln*.8*2 ;
$x_inicial = 10; 
$i = 0;

foreach ($titulos as $titulo){
	$pdf->SetXY($x_inicial , $LnNueva);
	$x_inicial += $titulo[0];
	$pdf->MultiCell($titulo[0], $Ln, $Factura[0][$i++] ,1,"C",1);
}




$LnNueva += $Ln*2 + $Ln/3;

$pdf->Image($_SERVER['DOCUMENT_ROOT'] .'/img/SelloCol.jpg',75,$LnNueva+3,0,18);
	
	
TitCon ($Ln,95, 10,$LnNueva,'Firma y sello del agente de retención','',$pdf);
TitCon ($Ln,95, 110,$LnNueva,'Recibí conforme esta constancia de retención','',$pdf);








$pdf->Output();
?>