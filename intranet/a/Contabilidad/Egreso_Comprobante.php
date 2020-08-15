<?php 
$MM_authorizedUsers = "91,99,Contable";
require_once('../../../inc_login_ck.php'); 
require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 
require_once('../../../inc/fpdf.php'); 
// Conectar
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

$borde='LB';
$Ln = 6;

$pdf=new FPDF('P', 'mm', 'Letter');
$pdf->SetFillColor(255,255,255);
$pdf->AddPage();
$pdf->SetMargins(20, 10);

if (isset($_GET['Codigo'])){
	$Codigo=$_GET['Codigo'];
	$query_RS_Recibos = "SELECT * FROM Contabilidad 
							WHERE Codigo = '$Codigo'";
	$RS = $mysqli->query($query_RS_Recibos);
	$row = $RS->fetch_assoc();
	extract($row);
	
	$Espacio = 150;
	for ($i = 0; $i <= 0; $i++){
		
		$pdf->Image('../../../img/solcolegio.jpg', 20 , 15 + $i*$Espacio, 0, 16);
		$pdf->Image('../../../img/NombreCol.jpg' , 40 , 15 + $i*$Espacio, 0, 12);
		
		$pdf->SetY(  27.3 + $i*$Espacio);
		
		$pdf->SetFont('Arial','', 8);
		$pdf->Cell(26); $pdf->Cell(40 , $Ln/2 , 'Rif: J-00137023-4'  , 0, 1 , 'C'); 
		$pdf->Cell(26); $pdf->Cell(40 , $Ln/2 , 'Calle 7 Entre 4ta y 5ta Ave.'  , 0 , 1 , 'C'); 
		$pdf->Cell(26); $pdf->Cell(40 , $Ln/2 , 'Los Palos Grandes. Tel.283.25.75'  , 0 , 1 , 'C'); 


		$pdf->SetXY( 135, 30 + $i*$Espacio);
		$pdf->SetFont('Arial','B', 16);
		$pdf->Cell(60 , $Ln , 'Por Bs. ' . Fnum($Monto) , 0, 1 , 'R'); 
	
	
	
		$pdf->SetY(45 + $i*$Espacio);
		
		$pdf->SetFont('Arial','', 12);
		$pdf->Cell(35 , $Ln , 'He recibido del: '  , 0 , 0 , 'L'); 
		$pdf->Cell(145 , $Ln , 'Colegio San Francisco de Asís, c.a. '  , 0 , 0 , 'L'); 
		$pdf->Ln($Ln*1.5);
		
		$pdf->SetFont('Arial','', 12);
		$pdf->Cell(35 , $Ln , 'La cantidad de: '  , 0 , 0 , 'L'); 
		$pdf->MultiCell(150 , $Ln , ' ' . Fnum_Letras($Monto) , $borde,  'L'); 
		$pdf->Ln($Ln*1);
		
		$pdf->Cell(35 , $Ln , 'Por concepto de: '  , 0 , 0 , 'L'); 
		$pdf->MultiCell(150 , $Ln , ' ' . $Descripcion , $borde, 'L'); 
		$pdf->Ln($Ln);

		if($FormaPago > ""){
			if($FormaPago == "Ef"){
				$PagadoEn = "Efectivo";
				}
			elseif($FormaPago == "Ch"){
				$PagadoEn = "Cheque";
				}
			elseif($FormaPago == "Tr"){
				$PagadoEn = "Transferencia";
				}
				
			if($Banco == "1" and $FormaPago != "Ef"){
				$_Banco = "   Banco: Mercantil   Numero: ".$Numero;
				}
			elseif($Banco == "2" and $FormaPago != "Ef"){
				$_Banco = "   Banco: Provincial   Numero: ".$Numero;
				}				
			
			if($PagadoEn > ""){	
				$pdf->SetFont('Arial','', 12);
				$pdf->Cell(35 , $Ln , 'Pagado en: '  , 0 , 0 , 'L'); 
				$pdf->Cell(145 , $Ln , $PagadoEn.$_Banco  , $borde , 0 , 'L'); 
			}
		}
		$pdf->Ln($Ln*1.5);
		
		$pdf->Cell(20 , $Ln , 'Nombre: '  , 0 , 0 , 'L'); 
		$pdf->Cell(70 , $Ln , ' ' . $BeneficiarioNombre , $borde, 0 , 'L'); 
		$pdf->Ln($Ln*1.5);
		
		$pdf->Cell(20 , $Ln , 'C.I.: '  , 0 , 0 , 'L'); 
		$pdf->Cell(70 , $Ln , ' ' . $BeneficiarioRif , $borde, 0 , 'L'); 
		$pdf->Cell(25);
		//$pdf->Cell(70 , $Ln , ' ' , 'B', 0 , 'L'); // Linea Firma
		$pdf->Ln($Ln*1.5);
		
		$pdf->Cell(20 , $Ln , 'Caracas: ' , 0, 0 , 'L'); 
		$pdf->Cell(70 , $Ln , ' ' . date('d / m / Y') , $borde , 0 , 'L'); 
		$pdf->Cell(15);
		$pdf->Cell(80 , $Ln , 'Firma' , 'T' , 0, 'C'); 
		
		$pdf->Ln($Ln/2);
		$pdf->SetFont('Arial','', 8);
		$pdf->Cell(185 , $Ln , $MM_Iniciales.' '.$Codigo , 0, 0 , 'R'); 
		
		
		
		
		
		$pdf->Ln($Ln);
	}


$pdf->Output();
}

echo 'ERROR'. $query_RS_Recibos;

?>