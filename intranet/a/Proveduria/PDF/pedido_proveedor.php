<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable,provee";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php');

$Inventario = new Inventario();

$ShopCart = new ShopCart();

$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

// Ejecuta $sql
//$RS = $mysqli->query($sql);
//$row = $RS->fetch_assoc();

$borde = 1;
$Ln = 4.25;

$pdf=new FPDF('L', 'mm', 'Letter');
$pdf->AddPage();
//Reticula($pdf);
$pdf->SetFillColor(255,255,255);
//$pdf->SetMargins(5,5,5);
//$pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/img/NombreCol.jpg' , 30, 5, 0, 12);

//$pdf->SetXY( 30,10 );
$pdf->SetFont('Arial','',10);

$pdf->Cell(10 , $Ln , "n" , $borde , 0 , 'L'); 
$pdf->Cell(80 , $Ln , "Descripcion" , $borde , 0 , 'L'); 
$pdf->Cell(30 , $Ln , "Autor" , $borde , 0 , 'L',1); 
$pdf->Cell(30 , $Ln , "Editorial" , $borde , 0 , 'L',1); 
$pdf->Cell(15 , $Ln , "Costo_Dolares" , $borde , 0 , 'R',1); 
//$pdf->Cell(15 , $Ln , "" , $borde , 0 , 'R',1); 
$pdf->Cell(25 , $Ln , "Ped nuevo" , $borde , 0 , 'L',1); 
$pdf->Cell(25 , $Ln , "Ped anterior" , $borde , 0 , 'L',1); 
//$pdf->Cell(15 , $Ln , " ? " , $borde , 0 , 'R',1); 
$pdf->Ln($Ln);

$RS = $Inventario->view_all($where , "Editorial");
while ($row = $RS->fetch_assoc()){
	extract($row);	
	
	$pdf->Cell(10 , $Ln , ++$n , $borde , 0 , 'L'); 
	$pdf->Cell(80 , $Ln , $Descripcion , $borde , 0 , 'L'); 
	$pdf->Cell(30 , $Ln , $Autor , $borde , 0 , 'L',1); 
	$pdf->Cell(30 , $Ln , $Editorial , $borde , 0 , 'L',1); 
	$pdf->Cell(15 , $Ln , $Costo_Dolares , $borde , 0 , 'R',1); 
	
	// Pedidos
		$ShopCart->id_inventario = $id;
		$pedidos = $ShopCart->view_pedidos(0);
					
	//	echo $pedidos->num_rows;
	//$pdf->Cell(15 , $Ln , "".$pedidos->num_rows . " => ". $ShopCart->cantidad_pedido(0,$id), $borde , 0 , 'R',1); 
	
	
	
	
	$ShopCart->id_inventario = $id;
	
	
		
	// pagados
	$pagados = $ShopCart->view_pedidos(1);
	$Num = $pagados->num_rows;
	if($Num == 0)
		$Num = "";
	
	
	
	$pagadosReal = $ShopCart->cantidad_pedido(1,$id);
	
	//	echo $pagados->num_rows;
	
	
	
	
	
	$Num = $pagados->num_rows;
	if($Num == 0)
		$Num = "";
	$pdf->Cell(25 , $Ln , "".$Num . " => ". $ShopCart->cantidad_pedido(1,$id) , $borde , 0 , 'R',1); 
	
	
	//enProceso
	$enProceso = $ShopCart->view_pedidos(2);
	$Num = $enProceso->num_rows;
	if($Num == 0)
		$Num = "";
	$pdf->Cell(25 , $Ln , "".$Num  . " => ". $ShopCart->cantidad_pedido(11,$id), $borde , 0 , 'R',1); 
	//
	
	
	// por pagar
	//	echo $pedidos->num_rows - $pagados->num_rows;
	$Num = $pedidos->num_rows - $pagados->num_rows - $enProceso->num_rows;
	if($Num == 0)
		$Num = "";
	//$pdf->Cell(15 , $Ln , $Num , $borde , 0 , 'R',1); 
	
	
	
	//Descripcion Autor Editorial Costo_Dolares Precio_Dolares   Pedidos Pagados Pendiente 
	
	
	$pdf->Ln($Ln);

}




//$pdf->Image('/img/SelloCol.jpg',145,108,0,18);
	





$pdf->Output();
?>