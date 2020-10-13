<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable,provee";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php');

$Usuario = new Usuario($Usuario = $_GET['Usuario']);
$Alumno = new Alumno("" , $AnoEscolar);
$Inventario = new Inventario($id = "");
$ShopCart = new ShopCart($id = "");
$Observaciones = new Observaciones();



$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

// Ejecuta $sql
//$RS = $mysqli->query($sql);
//$row = $RS->fetch_assoc();

$borde = 1;
$Ln = 10;

$pdf=new FPDF('P', 'mm', 'Letter');
$pdf->AddPage();
//Reticula($pdf);
$pdf->SetFillColor(255,255,255);
//$pdf->SetMargins(5,5,5);
//$pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/img/NombreCol.jpg' , 30, 5, 0, 12);

//$pdf->SetXY( 30,10 );
$pdf->SetFont('Arial','',10);



$sql = "SELECT * FROM ShopCart 
			WHERE id_user = '".$Usuario->id."'";
//echo $sql;
$RS = $mysqli->query($sql);
	
$pdf->Cell(80 , $Ln , "Usuario: " . $Usuario->view()["Usuario"] , $borde , 1 , "L" ,1); 


$Alumnos = $Usuario->Alumnos();


//if(array_count_values($Alumnos) > 0)
foreach($Alumnos as $id_alumno){
	$Alumno->id = $id_alumno;
	if($Alumno->Status($AnoEscolar) == "Aceptado" or $Alumno->Status($AnoEscolar) == "Inscrito" ){
		$pdf->Cell(100 , $Ln , "" . $Alumno->NombreApellidoCodigo() . " " . $Alumno->Status($AnoEscolar), $borde , 0 , "L" ,1); 
		$pdf->Cell(30 , $Ln , "" . $Alumno->AnoEscolar , $borde , 0 , "C" ,1); 
		$pdf->Cell(30 , $Ln , "" .  Curso($Alumno->CodigoCurso()) , $borde , 0 , "C" ,1); 
		$pdf->Ln($Ln);
} }


$pdf->Ln($Ln);

$pdf->Cell(10 , $Ln , "No" , $borde , 0 , 'C'); 
$pdf->Cell(70 , $Ln , "Descripcion" , $borde , 0 , 'L'); 
$pdf->Cell(20 , $Ln , "Cantidad" , $borde , 0 , 'L'); 
$pdf->Cell(20 , $Ln , "Precio" , $borde , 0 , 'L'); 
$pdf->Cell(20 , $Ln , "Total" , $borde , 0 , 'L'); 
$pdf->Cell(20 , $Ln , "Entregado" , $borde , 0 , 'L'); 
$pdf->Ln($Ln);




$RS = $ShopCart->view_pedidos("1" , $Usuario->id); // 11 Pedido a proveed

while ($row = $RS->fetch_assoc()){
	extract($row);	
	
		
	$Inventario->id = $id_inventario;
	
	$Articulo = $Inventario->view();
	
	
	$pdf->Cell(10 , $Ln , ++$n , $borde , 0 , 'C'); 
	$pdf->Cell(70 , $Ln , $Articulo["Descripcion"] , $borde , 0 , 'L',1,1); 
	
	//$Cantidad = $Articulo["Cantidad"];
	
	$pdf->Cell(20 , $Ln , $Cantidad , $borde , 0 , 'C',1,1); 
	$pdf->Cell(20 , $Ln , $Precio , $borde , 0 , 'C',1,1); 
	$pdf->Cell(20 , $Ln , $Cantidad*$Precio , $borde , 0 , 'C',1,1); 
	$TotalOrden += $Cantidad*$Precio;
	$pdf->Cell(20 , $Ln , "" , $borde , 0 , 'L'); 

	
	$pdf->Ln($Ln);

}


$pdf->Cell(120 , $Ln , "TotalOrden" , 0 , 0 , 'R'); 
$pdf->Cell(20 , $Ln , $TotalOrden , $borde , 0 , 'C',1,1 ); 
$pdf->Ln($Ln);


$pdf->Ln($Ln);



$Matriz = $Observaciones->view($Usuario->id , "Proveeduria");
/*echo "<pre>";
var_dump($Matriz);
*/

$Ln = 6;
foreach($Matriz as $row){
	$ajuste = 0;
	extract($row);	
	$pdf->Cell(20 , $Ln , DDMMAAAA($Fecha_Creacion) , $borde , 0 , 'L',1); 
	if($Codigo_Padre){
		$pdf->Cell(20 , $Ln , ">>" , $borde , 0 , 'L',1); 
		$ajuste = -20;
	}
	$pdf->Cell(150+$ajuste , $Ln , $Observacion , $borde , 0 , 'L',1);
	
	$pdf->Cell(20 , $Ln , substr( $Por,0,10 ) , $borde , 0 , 'L',1); 
	$pdf->Ln($Ln);
	
}
$pdf->Ln($Ln);










$pdf->Output();
?>