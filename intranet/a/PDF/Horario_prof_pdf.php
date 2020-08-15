<?php 
require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 
require_once('../../../inc/fpdf.php'); 

$borde=1;
$Ln = 10;
mysql_select_db($database_bd, $bd);

$TituloPag = 'Horario';

$pdf=new FPDF('L', 'mm', 'Letter');
$pdf->SetFillColor(255,255,255);


$query_RS_Prof = "SELECT * FROM Horario, Empleado 
				WHERE Horario.Cedula_Prof=Empleado.Cedula 
				AND Horario.Cedula_Prof > '0' 
				AND (Horario.CodigoCurso>='21' AND Horario.CodigoCurso<='44' OR (Horario.CodigoCurso = '0'))
				GROUP BY Horario.Cedula_Prof 
				ORDER BY Empleado.Apellidos, Empleado.Nombres";
$RS_Prof = mysql_query($query_RS_Prof, $bd) or die(mysql_error());
$row_RS_Prof = mysql_fetch_assoc($RS_Prof);

do {

// Bloque de horas del Horario
$query_RS_Bloques = "SELECT * FROM HorarioBloques WHERE Grupo = '2' ";
$RS_Bloques = mysql_query($query_RS_Bloques, $bd) or die(mysql_error());
$row_RS_Bloques = mysql_fetch_assoc($RS_Bloques);
$totalRows_RS_Bloques = mysql_num_rows($RS_Bloques);


$pdf->AddPage();
$pdf->Image('../../../img/solcolegio.jpg', 10, 5, 0, 16);
$pdf->Image('../../../img/NombreCol.jpg' , 30, 5, 0, 12);
$pdf->SetY( 5 );
$pdf->SetFont('Arial','B',18);

$pdf->Cell(255 , $Ln , $TituloPag , 0 , 1 , 'R'); 
$pdf->Cell(255 , $Ln , $row_RS_Prof['Apellidos'].' '.$row_RS_Prof['Nombres'] , 0 , 1 , 'R'); 

$pdf->SetY( 30 );

$pdf->SetFont('Arial','',11);



//AND (Horario.CodigoCurso>='35' AND Horario.CodigoCurso<='44' OR (Horario.CodigoCurso = '0'))
$sql=sprintf("SELECT * FROM Horario, Materias , Curso
				WHERE Horario.Descripcion = Materias.Codigo_Materia 
				AND Horario.CodigoCurso = Curso.CodigoCurso 
				
				AND Horario.Cedula_Prof = %s  
				ORDER BY Horario.Descripcion", GetSQLValueString($row_RS_Prof['Cedula_Prof'], "text"));
$RS_sql = mysql_query($sql, $bd) or die(mysql_error());
$row_RS_sql = mysql_fetch_assoc($RS_sql);
//echo $sql;
unset($Bloque);

	$_Horas_Acad = 0;
	$_Horas_Admi = 0;
do{
	extract($row_RS_sql);
		$aux = substr($NombreCompleto ,4,1)=='G'?'Gr ':'';
	if($Curso>0){
	$Describe = substr($NombreCompleto ,0,1).'º '. $aux .' '.$Seccion.' : '.substr($Materia,0,3);
	$_Horas_Acad = $_Horas_Acad +1;  }
	elseif($Curso==0) {
	$Describe = 'Admin'; $_Horas_Admi = $_Horas_Admi+1; }
	
	if( $Bloque[$Dia_Semana][$No_Bloque][0]=='')
		$Bloque[$Dia_Semana][$No_Bloque][0] = $Describe;
	else
		$Bloque[$Dia_Semana][$No_Bloque][1] = $Describe;
} while ($row_RS_sql = mysql_fetch_assoc($RS_sql));

//$pdf->Cell(40);

	$pdf->SetFont('Arial','B',14);

$pdf->Cell(35 , $Ln , '' , $borde , 0 , 'C'); 
$pdf->Cell(45 , $Ln , 'Lunes' , $borde , 0 , 'C'); 
$pdf->Cell(45 , $Ln , 'Martes' , $borde , 0 , 'C'); 
$pdf->Cell(45 , $Ln , 'Miércoles' , $borde , 0 , 'C'); 
$pdf->Cell(45 , $Ln , 'Jueves' , $borde , 0 , 'C'); 
$pdf->Cell(45 , $Ln , 'Viernes' , $borde , 1 , 'C'); 

$Origen_X0 = $pdf->GetX() + 35;
$Origen_Y0 = $pdf->GetY() + 0;


do{ // Imprime Horas y Recesos
	extract($row_RS_Bloques);
	$pdf->Cell(35 , $Ln , $Descripcion , $borde , 0 , 'C');
	if($Tipo == 'R')
		$pdf->Cell(225 , $Ln , 'R E C R E O' , $borde , 0 , 'C');
	if($Tipo == 'A')
		$pdf->Cell(225 , $Ln , 'A L M U E R Z O' , $borde , 0 , 'C');
$pdf->Ln();
}while ($row_RS_Bloques = mysql_fetch_assoc($RS_Bloques));


$pdf->SetFont('Arial','',10);
$pdf->Cell(100 , 5 , '* El curso se divide' , 0  , 0 , 'L'); 
$_Horas_Tot = $_Horas_Acad+$_Horas_Admi;
$pdf->Cell(160 , 5 , 'Hr:  Acad: ('.$_Horas_Acad.') + Admin ('.$_Horas_Admi. ') = Tot: ' .$_Horas_Tot , 0  , 0 , 'R'); 



$pdf->SetFont('Arial','B',14);

for ($Dia_Semana = 1 ; $Dia_Semana <= 5 ; $Dia_Semana++){ // para cada dia
$Origen_X = $Origen_X0 * $Dia_Semana;
$Origen_Y = $Origen_Y0 ;

	for ($No_Bloque = 1 ; $No_Bloque <= 15 ; $No_Bloque++) { // para cada fila 
	$pdf->SetXY($Origen_X , $Origen_Y);
	$borde_aux = 1; 
	$Lab == 0;
	$alto = 1;
	
	if ($Bloque[$Dia_Semana][$No_Bloque][0]>''){
		
		$aux = $Bloque[$Dia_Semana][$No_Bloque][0];
		if($Bloque[$Dia_Semana][$No_Bloque][1]>'')
		$aux .= ' *? '. substr( $Bloque[$Dia_Semana][$No_Bloque][1] , 0 , 3);
		
	if($Bloque[$Dia_Semana][$No_Bloque][0] == $Bloque[$Dia_Semana][$No_Bloque+1][0])
		{ $borde_aux = 'TLR'; $alto=2; }
	if($Bloque[$Dia_Semana][$No_Bloque][0] == $Bloque[$Dia_Semana][$No_Bloque-1][0])
		{ $borde_aux = 'BLR'; $aux = '';}
	
	if($Bloque[$Dia_Semana][$No_Bloque][0] == $Bloque[$Dia_Semana][$No_Bloque+1][0] 
	and $Bloque[$Dia_Semana][$No_Bloque][0] == $Bloque[$Dia_Semana][$No_Bloque+2][0]
	and $Bloque[$Dia_Semana][$No_Bloque][0] == $Bloque[$Dia_Semana][$No_Bloque+3][0] 
	and $Lab == 0 ) 	
		$Lab = 4;	
			
	if ( $Lab>0 ){
	if ( $Lab == 4 ){
		 $borde_aux = 'TLR';
		 $aux = $Bloque[$Dia_Semana][$No_Bloque][0];}
	elseif ( $Lab == 3 ){
		 $borde_aux = '0';
		 $aux = '';}
	elseif ( $Lab == 2 ){
		 $borde_aux = 'TLR';
		 $aux = $Bloque[$Dia_Semana][$No_Bloque][0];}
	elseif ( $Lab == 1 ){
		 $borde_aux = 'BLR';
		 $aux = '';}
	$Lab = $Lab - 1 ; }
		
	//if($Bloque[$Dia_Semana][$No_Bloque][0] == $Bloque[$Dia_Semana][$No_Bloque-1][0])
		//$aux = '';
		
		$pdf->Cell(45 , $Ln*$alto , $aux , $borde_aux , 0, 'C'); 
	
	
	}else{
	if($No_Bloque!=3 and $No_Bloque!=8 and $No_Bloque!=11)
	$pdf->Cell(45, $Ln , ' ' , 1 );
	}
	
	$Origen_Y = $Origen_Y + $Ln;
	
	
	}  
	
}

}while($row_RS_Prof = mysql_fetch_assoc($RS_Prof));



$pdf->Output();


?>