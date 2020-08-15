<?php 
$MM_authorizedUsers = "";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/notas.php'); 
//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rotation.php'); 

class PDF extends PDF_Rotate
{
function RotatedText($x,$y,$txt,$angle)
{
    //Text rotated around its origin
    $this->Rotate($angle,$x,$y);
    $this->Text($x,$y,$txt);
    $this->Rotate(0);
}

function RotatedImage($file,$x,$y,$w,$h,$angle)
{
    //Image rotated around its upper-left corner
    $this->Rotate($angle,$x,$y);
    $this->Image($file,$x,$y,$w,$h);
    $this->Rotate(0);
}
}

//$AnoEscolar = "2018-2019";


$linea = 2.7;
$tipologia = 'Arial';
$Borde = 1;
$pdf=new PDF('P', 'mm', 'Letter');

$pdf->SetAutoPageBreak(1,10);
$pdf->SetMargins(10,10,20);

$LapsoG = 3;
$Lapso = 3;

$Curso = new Curso();
$Curso->id = $_GET['CodigoCurso'];

$Curso->Ano = $AnoEscolar;

$Listado = $Curso->ListaCurso();
$NivelCurso = $Curso->NivelCurso();
$DocenteGuia = $Curso->DocenteGuia();
$DocenteEspecialista= $Curso->DocenteEspecialista();

//echo "DocenteGuia " . $DocenteGuia . "<br>";
if($DocenteGuia == $MM_Username){
	$SW_DocenteGuia = true;
	}
//echo "DocenteEspecialista " . var_dump($DocenteEspecialista) . "<br>";

if(isset($_GET['idAlumno'])){
	$Listado = array(array("CodigoAlumno" => $_GET['idAlumno']));
	} 
 
foreach($Listado as $Alumno) 	{	
	
	$Alumno = new Alumno($Alumno['CodigoAlumno']);
	$Suma_Lapso = $Cuenta_Lapso = 0;
	
	$pdf->AddPage();
	//Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])
	
	$pdf->Image('../../img/solcolegio.jpg',10,10,0,25);
	$pdf->Image('../../img/NombreCol_az.jpg',45, 14, 0, 15);
	
	
	$pdf->SetFont('Arial','B',100);
	$pdf->SetTextColor(200);
	$pdf->RotatedText(50,100,'Facsímil',15);
	$pdf->SetTextColor(0);
	
	
	$pdf->SetFont('Arial','B',14);
	$pdf->SetXY(90,15);
	$pdf->Cell(150,$linea*1.5, "Informe del Desempeño Académico" ,0,0,'C');
	$pdf->SetXY(90,25);
	$pdf->Cell(150,$linea*1.5, "del $LapsoG º Lapso - $AnoEscolar" ,0,0,'C');
	$pdf->SetFont('Arial','B',12);
	$pdf->SetXY(10,35);
	$pdf->Cell(20,$linea*1.5, "Alumno: " ,0,0,'L');
	$pdf->Cell(110,$linea*1.5, $Alumno->NombreApellido() ,"LB",0,'L');
	//$pdf->SetXY(10,60);
	$pdf->Cell(20,$linea*1.5, "Curso: " ,0,0,'R');
	$pdf->Cell(50,$linea*1.5, $Curso->NombreCurso() ,"LB",1,'L');
	
	
	
	//$pdf->Ln($linea);
	/*
	if($Curso->NivelCurso() >= "21"){
		$sql = "SELECT * FROM Boleta_Indicadores
				WHERE 
				Ano = '$AnoEscolar'
				AND 
				((NivelCurso = '".$Curso->NivelCurso()."' AND Lapso = '$LapsoG')
				OR Dimen_o_Indic = 'D')
				ORDER BY Dimen_o_Indic, Orden_Grupo, Materia_Grupo, Orden";}
	else{
		$sql = "SELECT * FROM Boleta_Indicadores
				WHERE Ano = '$AnoEscolar'
				AND NivelCurso = '".$Curso->NivelCurso()."' AND Lapso = '$LapsoG'
				ORDER BY Dimen_o_Indic, Orden_Grupo, Materia_Grupo, Orden";} //AND Dimen_o_Indic = 'I'
	//echo $sql;
	*/
	
	
	if($Curso->NivelCurso() >= "21"){
		$sql = "SELECT * FROM Boleta_Indicadores
				WHERE Ano = '$AnoEscolar'
				AND Lapso = '$Lapso'
				AND (NivelCurso = '".$Curso->NivelCurso()."' OR (NivelCurso = '21' AND Dimen_o_Indic = 'D')) 
				ORDER BY Dimen_o_Indic, Orden_Grupo, Materia_Grupo, Orden";
	}
	else{
		$sql = "SELECT * FROM Boleta_Indicadores
				WHERE Ano = '$AnoEscolar'
				AND Lapso = '$Lapso'
				AND NivelCurso = '".$Curso->NivelCurso()."'  
				ORDER BY Dimen_o_Indic, Orden_Grupo, Materia_Grupo, Orden";
	} //AND Dimen_o_Indic = 'I'
	
	
	
	$RS = $mysqli->query($sql);
	$row = $RS->fetch_assoc();
	extract($row);
	$sw_continua = true;
	do{
		
		if($Dimen_o_Indic_Ante != $Dimen_o_Indic){	
			$pdf->SetFont('Arial','B',10);
			$pdf->Ln($linea);
			$pdf->Cell(200,$linea*1.5, $Dimen_o_Indic=="I"?"Indicador":"Dimensión" ,$Borde,0,'L');
			$pdf->Ln($linea*1.5);
		} 

		
		
		// Titulo grupo
		$pdf->SetFont('Arial','B',8);
		if($Materia_Grupo_Ante != $Materia_Grupo){ 
			if( $pdf->GetY() > 250 ){
				$pdf->AddPage();
			}
			$Sumatoria = $cuenta = 0;
			$pdf->Ln(1);
			if($EscalaNota == 5){
				$pdf->Cell(165,$linea*1.5, $Materia_Grupo ,"TL",0,'L');			
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(7,$linea*1.5, "Ne" ,$Borde,0,'C');
				$pdf->Cell(7,$linea*1.5, "I" ,$Borde,0,'C');
				$pdf->Cell(7,$linea*1.5, "Pi" ,$Borde,0,'C');
				$pdf->Cell(7,$linea*1.5, "Pa" ,$Borde,0,'C');
				$pdf->Cell(7,$linea*1.5, "C" ,$Borde,1,'C');
				}
			else{
				$pdf->Cell(200,$linea*1.5, $Materia_Grupo ,"TL",1,'L');}
		}
		
		
		// Notas
		if( $pdf->GetY() > 260 ){
			$pdf->AddPage();
			}
		$pdf->SetFont('Arial','',8);
		$pdf->MultiCell(165, $linea, "- ".$Descripcion ,0,"L",0);
		$pdf->Ln(-$linea);
		
		$sql_nota = "SELECT * FROM Boleta_Nota 
					WHERE CodigoAlumno = '".$Alumno->id."'
					AND Codigo_Indicador = '".$Codigo."'
					AND Lapso = '$LapsoG'";
					//echo $sql_nota."<br>";
		$RS_nota = $mysqli->query($sql_nota);
		$row_nota = $RS_nota->fetch_assoc();
		$Nota = $row_nota['Nota'];
		if($EscalaNota == "A" and $Orden <> "0"){
			if($Nota > "01" and $Nota <= "20"){
				$Sumatoria += $Nota;
				$cuenta++;
				}
			// Line(float x1, float y1, float x2, float y2)
			//SetDrawColor(int r [, int g, int b])
			//SetLineWidth(float width)
			$pdf->SetDrawColor(200,200,200);
			//$pdf->Line($pdf->GetX(),$pdf->GetY(),195,$pdf->GetY());
			
			$pdf->SetDrawColor(0,0,0);
			$pdf->SetXY(200, $pdf->GetY());
			$pdf->Cell(10,$linea, $Nota.""  ,$Borde,0,'C'); //. $pdf->GetY()
		}
		elseif($EscalaNota == "5" and $Orden <> "0"){ 
			$NotaEscala[$Nota] = "X";
			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(175, $pdf->GetY());
			$pdf->Cell(7,$linea, $NotaEscala[1] ,$Borde,0,'C');
			$pdf->Cell(7,$linea, $NotaEscala[2] ,$Borde,0,'C');
			$pdf->Cell(7,$linea, $NotaEscala[3] ,$Borde,0,'C');
			$pdf->Cell(7,$linea, $NotaEscala[4] ,$Borde,0,'C');
			$pdf->Cell(7,$linea, $NotaEscala[5] ,$Borde,0,'C');
			unset($NotaEscala);
		}
		
		
		$pdf->Ln();
		
		
		
		
		
		// temina notas
		$Materia_Grupo_Ante = $Materia_Grupo;
		$Dimen_o_Indic_Ante = $Dimen_o_Indic;
		if($row = $RS->fetch_assoc()){
			$sw_continua = true;
			extract($row);}
		else{
			$sw_continua = false;}
	
	
		if($Materia_Grupo_Ante != $Materia_Grupo and $cuenta > 0){ 
		// Cierra promedio materia
			$Promedio_Materia = round($Sumatoria/$cuenta,0);
			
			$pdf->SetX(110);
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(100,$linea*1.5 , "Promedio ".$Materia_Grupo_Ante .": ". $Promedio_Materia ." " ,"BR",0,'R'); 
			$pdf->Ln();
			
			$Suma_Lapso += $Promedio_Materia;
			$Cuenta_Lapso++;
		}
	
	
		
	} while ($sw_continua);
	
	//Cierre boleta
	if($Cuenta_Lapso > 0){ 
	// Cierra promedio materia
		$Promedio_Boleta = round($Suma_Lapso/$Cuenta_Lapso,0);
		$pdf->Ln(1);
		$pdf->SetX(110);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(100,$linea*1.2, "Promedio Boleta:  ". $Promedio_Boleta."  "  ,"BR",0,'R'); //. $pdf->GetY()
		//$pdf->Ln();
	}
		
		
	$query_Observaciones = "SELECT * FROM Observaciones 
							WHERE CodigoAlumno = $Alumno->id 
							AND Area = 'Boleta'
							AND Lapso = '$LapsoG'
							AND Ano = '$AnoEscolar'
							ORDER BY Fecha DESC, Hora DESC";
	//echo 	$query_Observaciones;					
	$Observaciones = $mysqli->query($query_Observaciones);
	if($row_Observaciones = $Observaciones->fetch_assoc()){
		$pdf->Ln($linea*1.2);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(190,$linea*1.5, "Observaciones "  ,$Borde,1,'L');
		$pdf->SetFont('Arial','',9);
		$pdf->write($linea, $row_Observaciones['Observacion']);
		
		}











	if ($LapsoG == 3 and $Curso->NivelCurso() >= 20){
		$linea = $linea *1.5;
		$pdf->AddPage();
		
		$pdf->Image('../../img/solcolegio.jpg',10,10,0,40);
		$pdf->Image('../../img/NombreCol_az.jpg',80, 14, 0, 20);
	
		$pdf->SetFont('Arial','B',18);
		$pdf->SetXY(30,40);
		$pdf->Cell(190,$linea*1.5, "Resumen de Calificaciones" ,0,0,'C');
		$pdf->SetXY(30,48);
		$pdf->Cell(190,$linea*1.5, " " ,0,0,'C');
		$pdf->SetFont('Arial','B',14);
		$pdf->SetXY(10,60);
		$pdf->Cell(25,$linea*1.5, "Alumno: " ,0,0,'L');
		$pdf->Cell(100,$linea*1.5, $Alumno->NombreApellido() ,"LB",1,'L');
		$pdf->SetXY(10,75);
		$pdf->Cell(25,$linea*1.5, "Curso: " ,0,0,'L');
		$pdf->Cell(100,$linea*1.5, $Curso->NombreCurso() ,"LB",1,'L');
	
	
	
		$pdf->Ln(20);
					
		
		
		
		
		
		$pdf->SetX(25);
		$pdf->Cell(80,$linea, "Materia"  ,$Borde,0,'L');
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(20 ,$linea, "1 Lapso"  ,$Borde,0,'C');
		$pdf->Cell(20 ,$linea, "2 Lapso"  ,$Borde,0,'C');
		$pdf->Cell(20 ,$linea, "3 Lapso"  ,$Borde,0,'C');
		$_x_prom = $pdf->GetX();
		$pdf->Cell(30 ,$linea, "Promedio"  ,$Borde,0,'C');
				
		
		//foreach (array(1,2,3) as $Lap ) {
			
			$sql = "SELECT * FROM Boleta_Indicadores, Boleta_Nota
					WHERE Boleta_Indicadores.Codigo = Boleta_Nota.Codigo_Indicador
					AND Boleta_Indicadores.NivelCurso = '".$Curso->NivelCurso()."' 
					AND Boleta_Nota.CodigoAlumno = '".$Alumno->id."'
					AND Boleta_Indicadores.Ano = '$AnoEscolar'
					GROUP BY Boleta_Nota.Codigo_Indicador
					ORDER BY Boleta_Indicadores.Dimen_o_Indic,
					Boleta_Indicadores.Orden_Grupo,  Boleta_Indicadores.Lapso"; 
			//echo $sql;		
			$RS = $mysqli->query($sql);
			$Sumatoria = $cuenta = 0 ;
			$row = $RS->fetch_assoc();
			do{ // Indicadores - Materias
				
				if($Materia_Grupo_ante != $row['Materia_Grupo'] and $row['Nota'] >= 1){
					$pdf->Ln();
					$pdf->SetFont('Arial','',12);
					$pdf->SetX(25);
					$pdf->Cell(80,$linea, $row['Materia_Grupo']  ,$Borde,0,'L');
					//$pdf->Ln();
					}
				
				
				$Nota = $row['Nota'];
				if($Nota > 1 and $Nota <= 20){
					$Sumatoria += $Nota;
					$cuenta++;
					
					$pdf->SetFont('Arial','',8);
					//$pdf->Cell(8,$linea, $Nota  ,$Borde,0,'C');
					
					}
				
				
				
				
				
				
				
				$Materia_Grupo_ante = $row['Materia_Grupo'];
				$Lapso_ante = $row['Lapso'];
				
				if ($row = $RS->fetch_assoc()){
					$Continua = true;
					}
				else{
					$Continua = false;
					}	
				
				
				
				if($Lapso_ante != $row['Lapso'] or !$Continua){
					if( $cuenta > 0 ){
						$Def = round($Sumatoria/$cuenta , 0);
						$pdf->SetFont('Arial','',12);
						$pdf->Cell(20,$linea, $Def  ,$Borde,0,'C');}
					$Sumatoria_Materia += $Def;
					$cuenta_Materia++;
					$Def = "";
					$Sumatoria = $cuenta = "" ;
					//$pdf->Ln();
					}
				
				
				
				if($Materia_Grupo_ante != $row['Materia_Grupo'] and $Materia_Grupo_ante > ""){
					if($cuenta_Materia > 0 and $Sumatoria_Materia > 0){
						$Promedio_Materia = round($Sumatoria_Materia / $cuenta_Materia , 0);
						$Sumatoria_Anual += $Promedio_Materia;
						$cuenta_Anual++;
						$pdf->SetFont('Arial','B',12);
						$pdf->SetX($_x_prom);
						$pdf->Cell(30,$linea, $Promedio_Materia  , $Borde,0,'C');}
					$Sumatoria_Materia = $cuenta_Materia = $Promedio_Materia = "";
					
				}
			} while($Continua);
			
			if($Sumatoria_Anual > 0 and $cuenta_Anual > 0){
				$pdf->Ln();
				$Promedio_Anual = round($Sumatoria_Anual / $cuenta_Anual , 0);
				$pdf->SetFont('Arial','B',14);
				$pdf->SetX(25);
				$pdf->Cell(140,$linea, "Definitiva del Año Escolar" ,$Borde,0,'R');
				$pdf->Cell(30,$linea, $Promedio_Anual  ,$Borde,0,'C');
				}
					
			
			$pdf->Ln(20);
			$pdf->SetFont('Arial','',12);
			$pdf->SetX(30); $pdf->Cell(130,$linea, "Según lo antes expuesto el(la) alumno(a) " ,0,1,'L');
			$pdf->SetX(30); $pdf->Cell(130,$linea, $Alumno->NombreApellido() ,0,1,'L');
			
			$pdf->SetX(30); $pdf->Cell(130,$linea, "alcanzó el literal ".Nota_Letra($Promedio_Anual).", correspondiente a la calificación " .$Promedio_Anual. " puntos," ,0,1,'L');
			$pdf->SetX(30); $pdf->Cell(130,$linea, "siendo promovido a: " ,0,1,'L');
			
			$pdf->SetX(30); $pdf->Cell(130,$linea, substr($Curso->NombreCurso($Curso->CodigoCursoProx()), 0,strlen($Curso->NombreCurso($Curso->CodigoCursoProx()))-2) ." de ".$Curso->MencionCurso($Curso->CodigoCursoProx()) ,0,1,'L');
			
			$pdf->Ln(20);
			$pdf->SetX(30); $pdf->Cell(130,$linea, "Los Palos Grandes, a los ".date('d') ." días del mes de julio de ".date("Y") ,0,1,'L');
					
				
			//$Matriz[$Lap][$row['Materia_Grupo']] = round($Sumatoria/$cuenta , 2);
			
			//$pdf->Cell(20,$linea*1.5, " "  ,$Borde,1,'L');
			
		//}
		$linea = $linea /1.5;
		$Promedio_Anual = $Sumatoria_Anual = $cuenta_Anual = "";
		
					
}


if ($pdf->PageNo() %2==0){
   // echo "el $numero es par";
}else{
    $pdf->AddPage();
}





//break; // dev
}

// Cierra boleta
if($Cuenta_Lapso > 0){ 
	$Promedio_Lapso = round($Suma_Lapso/$Cuenta_Lapso,0);
	// Promedio del lapso $Promedio_Lapso; 	   
}





$pdf->Output();

?>
