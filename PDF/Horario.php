<?php 
require_once('../Connections/bd.php'); 
require_once('../inc/rutinas.php'); 
require_once('../inc/fpdf.php'); 

$borde=1;
$Ln = 10;
mysql_select_db($database_bd, $bd);

$TituloPag = 'Horario';

$pdf=new FPDF('L', 'mm', 'Letter');
$pdf->SetFillColor(255,255,255);


$CodigoCurso = "-1";
if (isset($_GET['CodigoCurso'])) {
  $CodigoCurso = $_GET['CodigoCurso'];
  $add_SQL = " AND CodigoCurso = '$CodigoCurso'";
} 
else {
	$add_SQL = "";
} 
$query_RS_Curso = "SELECT * FROM Curso WHERE SW_activo = 1 AND NivelCurso>='31' $add_SQL";
//echo $query_RS_Curso;
$RS_Curso = mysql_query($query_RS_Curso, $bd) or die(mysql_error());


while($row_RS_Curso = mysql_fetch_assoc($RS_Curso)) {

// Bloque de horas del Horario
$query_RS_Bloques = "SELECT * FROM HorarioBloques WHERE Grupo = '".$row_RS_Curso['BloqueHorarioGrupo']."' ";
$RS_Bloques = mysql_query($query_RS_Bloques, $bd) or die(mysql_error());
$row_RS_Bloques = mysql_fetch_assoc($RS_Bloques);
$totalRows_RS_Bloques = mysql_num_rows($RS_Bloques);

$CodigoCurso = $row_RS_Curso['CodigoCurso'];

$pdf->AddPage();
$pdf->Image('../img/solcolegio.jpg', 10, 5, 0, 16);
$pdf->Image('../img/NombreCol.jpg' , 30, 5, 0, 12);
$pdf->SetY( 5 );
$pdf->SetFont('Arial','B',18);

$pdf->Cell(155 , $Ln , $TituloPag , 0 , 0 , 'R'); 
$pdf->Cell(100 , $Ln , Curso( $CodigoCurso ) , 0 , 1 , 'R'); 

//$pdf->Cell(55); //echo $row_RS_Curso['Cedula_Prof_Guia'];

$Prof_Guia = EmpleadoCI( $row_RS_Curso['Cedula_Prof_Guia'] );
$pdf->SetFont('Arial','B',14);
$pdf->Cell(255 , $Ln*2 , 'Prof. Guía: '.$Prof_Guia   , 0 , 0 , 'R'); 

$pdf->SetFont('Arial','B',18);

$pdf->SetY( 30 );

$pdf->SetFont('Arial','',11);



$sql=sprintf("SELECT * FROM Horario, Materias 
				WHERE Horario.Descripcion=Materias.Codigo_Materia  
				AND Horario.CodigoCurso = %s  
				ORDER BY Materias.Materia", GetSQLValueString($CodigoCurso, "int"));
//echo $sql;	
$RS_sql = mysql_query($sql, $bd) or die(mysql_error());
$row_RS_sql = mysql_fetch_assoc($RS_sql);

unset($Bloque);

do{
	extract($row_RS_sql);
	if( $Bloque[$Dia_Semana][$No_Bloque][0]=='')
		$Bloque[$Dia_Semana][$No_Bloque][0] = $Materia;
	else
		$Bloque[$Dia_Semana][$No_Bloque][1] = $Materia;
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


$pdf->SetFont('Arial','B',14);

for ($Dia_Semana = 1 ; $Dia_Semana <= 5 ; $Dia_Semana++){ // para cada dia
$Origen_X = $Origen_X0 * $Dia_Semana;
$Origen_Y = $Origen_Y0 ;

	for ($No_Bloque = 1 ; $No_Bloque <= 15 ; $No_Bloque++) { // para cada fila 
	$pdf->SetXY($Origen_X , $Origen_Y);
	$borde_aux = 1; 
	$Lab == 0;
	$alto = 1;
	
	if($Bloque[$Dia_Semana][$No_Bloque][0] == $Bloque[$Dia_Semana][$No_Bloque+1][0])
		$borde_aux = 'TLR';
	if($Bloque[$Dia_Semana][$No_Bloque][0] == $Bloque[$Dia_Semana][$No_Bloque-1][0])
		$borde_aux = 'BLR';
	
	if ($Bloque[$Dia_Semana][$No_Bloque][0]>''){
		$aux = $Bloque[$Dia_Semana][$No_Bloque][0];
		
		if ($Bloque[$Dia_Semana][$No_Bloque][0]==$Bloque[$Dia_Semana][$No_Bloque][1]) // Ingles Ingles
			$aux .= ' *';	
		elseif ($Bloque[$Dia_Semana][$No_Bloque][1]>'') 		//  Castellano / Fisica  -> 1 hora
			$aux .= '/'.$Bloque[$Dia_Semana][$No_Bloque][1];
		
		if(	$Bloque[$Dia_Semana][$No_Bloque][0]==$Bloque[$Dia_Semana][$No_Bloque+1][0] 
		and $Bloque[$Dia_Semana][$No_Bloque][1]==$Bloque[$Dia_Semana][$No_Bloque+1][1] ) // Busca similitud con el siguiente
			$aux = $Bloque[$Dia_Semana][$No_Bloque][0];
		
		elseif(	$Bloque[$Dia_Semana][$No_Bloque][0]==$Bloque[$Dia_Semana][$No_Bloque-1][0] 
		and $Bloque[$Dia_Semana][$No_Bloque][1]==$Bloque[$Dia_Semana][$No_Bloque-1][1] ) // Busca similitud con el anterior 
			$aux = $Bloque[$Dia_Semana][$No_Bloque][1];

			   
if($Bloque[$Dia_Semana][$No_Bloque][1]=='' and $Bloque[$Dia_Semana][$No_Bloque][0]==$Bloque[$Dia_Semana][$No_Bloque+1][0])
$alto = 2;

if($Bloque[$Dia_Semana][$No_Bloque][0]==$Bloque[$Dia_Semana][$No_Bloque][1] and $Bloque[$Dia_Semana][$No_Bloque][0]==$Bloque[$Dia_Semana][$No_Bloque-1][1])
	$aux = '';
						
if($Bloque[$Dia_Semana][$No_Bloque][0]==$Bloque[$Dia_Semana][$No_Bloque][1] and $Bloque[$Dia_Semana][$No_Bloque][0]==$Bloque[$Dia_Semana][$No_Bloque+1][1])
	{ $aux .= ' *'; 
	$alto = 2; }
	
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
		 $borde_aux = 'BLR';
		 $aux = $Bloque[$Dia_Semana][$No_Bloque][1];}
	elseif ( $Lab == 2 ){
		 $borde_aux = 'TLR';
		 $aux = $Bloque[$Dia_Semana][$No_Bloque][0];}
	elseif ( $Lab == 1 ){
		 $borde_aux = 'BLR';
		 $aux = $Bloque[$Dia_Semana][$No_Bloque][1];}
	$Lab = $Lab - 1 ; }
						
		$pdf->Cell(45 , $Ln*$alto , $aux , $borde_aux , 0, 'C'); 
	
	
	}else{
	if($No_Bloque!=3 and $No_Bloque!=8 and $No_Bloque!=11)
	$pdf->Cell(45, $Ln , ' ' , 1 );
	}
	
	$Origen_Y = $Origen_Y + $Ln;
	
	
	}  
	
}

}



$pdf->Output();


?>