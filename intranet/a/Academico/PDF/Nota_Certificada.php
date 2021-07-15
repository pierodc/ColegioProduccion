<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable,secreBach";
$SW_omite_trace = false;
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php'); 
//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rotation.php'); 

if($MM_Username != "piero" AND $MM_Username != "mariangelaguevara36@gmail.com" )
	exit;


//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php'); 


/*
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
*/


if (isset($_GET['test'])) {
	$test=true;} 
else {
	$test=false;}
$borde=0;

//header("Content-Type: text/html;charset=utf-8");

$CodigoCurso_URL = "0";
 
$Ln = 4.5;

$pdf=new FPDF('P', 'mm', 'Legal');

$Alumno = new Alumno($_GET['CodigoAlumno']);
$row_RS_Alumnos = $Alumno->view_all();

$PlanDeEstudio = explode(':',$row_RS_Alumnos['PlanDeEstudio']); 




$ColegioNotasCert = '';
$PagNum = 0;	
$EdTrabOrden = 0;
$IndiceAcademico = 0;
$IndiceAcademicoFactor = 0;
unset($Plantel);
extract($row_RS_Alumnos);

if($ColegioNotasCert=='')
	$ColegioNotasCert = '1;1;U.E. Col San Fco. de Asís;Los Palos Grandes;MI:2;1;U.E. Col San Fco. de Asís;Los Palos Grandes;MI:';
$Colegios_Observaciones = explode(':|',$ColegioNotasCert); 
$Colegios 				= explode(':',$Colegios_Observaciones[0]); 
$Observaciones 			= explode('|',$Colegios_Observaciones[1]); 
foreach($Colegios as $Colegio) {
	$Cole  = explode(';',$Colegio); 
	$Plantel[$Cole[0]][$Cole[1]]["Nombre"] = $Cole[2];
	$Plantel[$Cole[0]][$Cole[1]]["Localidad"] = $Cole[3];
	$Plantel[$Cole[0]][$Cole[1]]["EF"] = $Cole[4];
}

$Pagina = array(array('7','8','9'), array('IV','V',''));
$Pagina = array(array('7','8','9'));
$Pagina = array(array('7n','8n','9n','IVn','Vn'));
$LineasPorCurso = array(7,7,9,9,10);
$NumMaterias = array('7n'=>7,'8n'=>7,'9n'=>9,'IVn'=>9,'Vn'=>10);
$NombreCurso = array('7n'=>"PRIMER AÑO",'8n'=>"SEGUNDO AÑO",'9n'=>"TERCER AÑO",'IVn'=>"CUARTO AÑO",'Vn'=>"QUINTO AÑO");


foreach($Pagina as $CodigoMaterias){
	
$PagNum++;
foreach($CodigoMaterias as $CodigoMateria){
	$sql = "SELECT * FROM Notas_Certificadas 
			WHERE CodigoAlumno = $CodigoAlumno 
			AND Grado = '$CodigoMateria'
			ORDER BY Grado, Orden"; 
			//echo $sql;
	$RSnotas = $mysqli->query($sql); //
	$row_notas = $RSnotas->fetch_assoc();
/*
	$RSnotas = mysql_query($sql, $bd) or die(mysql_error());
	$row_notas = mysql_fetch_assoc($RSnotas);*/
	
	do{	
		if($row_notas['["Mes"]']!='ET')
			$Renglon[$CodigoMateria][$row_notas['Orden']] =	$row_notas;	
			
		elseif($row_notas['["Mes"]']=='ET'){
			$EdTrabOrden++;
			if($row_notas['Grado'] > 6) 
				$GradoET = $row_notas['Grado']-6;
								
			$EdTrab[$EdTrabOrden]['Grado']   = $GradoET;
			$EdTrab[$EdTrabOrden]['Materia'] = $row_notas['Materia'];
			$EdTrab[$EdTrabOrden]['Horas']   = $row_notas['Nota'];	}

		$Renglon[$CodigoMateria][$row_notas['Orden']] =	$row_notas;	
		
	} while ($row_notas = $RSnotas->fetch_assoc());
}
			$EdTrabOrden++;
			$EdTrab[$EdTrabOrden]['Grado']   = '*';
			$EdTrab[$EdTrabOrden]['Materia'] = '* * *';
			$EdTrab[$EdTrabOrden]['Horas']   = '*';

if($PagNum == 2) unset($EdTrab);

$AnchoPagina = 202;

$pdf->AddPage();
$pdf->SetMargins(5,5,5);
$pdf->SetFont('Arial','',10);

// Encabezado Página
$pdf->Image('../../../../img/LogoME2018.jpg', 5, 5, 100, 20);
$pdf->SetY( 5 ); 
$pdf->Ln($Ln);
$pdf->Cell(125); $pdf->Cell(70  , $Ln , 'CERTIFICACIÓN DE CALIFICACIONES EMG' , 'B' , 0 , 'C');
$pdf->Ln($Ln);
//$pdf->Cell(125); $pdf->Cell(70  , $Ln , ' Código del Formato: RR-DEA-03-03 ' , 0 , 0 , 'C');
//$pdf->Ln($Ln);

$PlanDeEstudio12 = explode(':',$PlanDeEstudio); 
$PlanDeEstudioPag1 = explode(';',$PlanDeEstudio12[0]); 
$PlanDeEstudioPag2 = explode(';',$PlanDeEstudio12[1]); 

// 2;Educación Media General;31018;Ciencias

if($PagNum == 1) {
	$CodigoPlanDeEstudio = $PlanDeEstudioPag1[2];
	$NombrePlanDeEstudio = $PlanDeEstudioPag1[1];
	$Mencion = $PlanDeEstudioPag1[3];
	}
else {
	$CodigoPlanDeEstudio = $PlanDeEstudioPag2[2];
	$NombrePlanDeEstudio = $PlanDeEstudioPag2[1];
	//$NombrePlanDeEstudio = "BACHILLER";
	$Mencion = $PlanDeEstudioPag2[3];
	}
	
	
	
//echo $NombrePlanDeEstudio;
	
if($NombrePlanDeEstudio == "III Etapa de Educación Básica")	{
	$GradosP1 = "789";
	}
if($NombrePlanDeEstudio == "Media Diversificada y Profesional" or $NombrePlanDeEstudio == "Ciclo Diversificado")	{
	$GradosP2 = "12";
	}
//$NombrePlanDeEstudio = "EDUCACIÓN MEDIA GENERAL";
//$CodigoPlanDeEstudio = "31059";
	
$pdf->Cell(100);  $pdf->Cell(35  , $Ln , 'I. Plan de Estudio: ' , 0 , 0 , 'L');
				 $pdf->Cell(70  , $Ln , ' '.$NombrePlanDeEstudio  , 'B' , 1 , 'L');
$pdf->Cell(100);	 $pdf->Cell(46  , $Ln , 'Código del Plan de Estudio:  ' , 0 , 0 , 'L');
				 $pdf->Cell(59  , $Ln , ' '.$CodigoPlanDeEstudio , 'B' , 1 , 'L');
//$pdf->Cell(100);  $pdf->Cell(17  , $Ln , 'Mención: ' , 0 , 0 , 'L');
//				 $pdf->Cell(88  , $Ln , ' '. $Mencion , 'B' , 0 , 'L');
$pdf->Cell(100); $pdf->Cell(48  , $Ln , 'Lugar y Fecha de Expedición:' , 0 , 0 , 'L');
				 $pdf->Cell(57  , $Ln , ' Caracas: ' . date('d-m-Y')  , 'B' , 0 , 'L'); // $Fecha_Nota_Certificada. 
$pdf->Ln($Ln);
			
			
$pdf->SetFont('Arial','B',10);
$pdf->Cell(50  , $Ln , 'II.    Datos del Plantel' , $borde , 0 , 'L');
$pdf->Ln($Ln);

$pdf->Cell(20  , $Ln , 'Cód.DEA: ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(30  , $Ln , ' S0934D1507 ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(20  , $Ln , ' Nombre: ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(101  , $Ln , $Colegio_Nombre , $borde , 0 , 'L');
//$pdf->SetFont('Arial','B',10);
//$pdf->Cell(20  , $Ln , ' Dtto.Esc.: ' , $borde , 0 , 'L');
//$pdf->SetFont('Arial','',10);
//$pdf->Cell(10  , $Ln , ' 7 ' , $borde , 0 , 'L');
$pdf->Ln($Ln);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(20  , $Ln , 'Dirección: ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(116  , $Ln , ' 7ma. transv. entre 4ta y 5ta Av. Los Palos Grandes ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(20  , $Ln , ' Teléfono: ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(45  , $Ln , ' 283.25.75 ' , $borde , 0 , 'L');
$pdf->Ln($Ln);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(20  , $Ln , 'Municipio: ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(46  , $Ln , ' Chacao ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25  , $Ln , ' Ent. Federal: ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(45  , $Ln , ' Estado Miranda ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(30  , $Ln , ' Zona Educativa: ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(35  , $Ln , ' Miranda ' , $borde , 0 , 'L');
$pdf->Ln($Ln);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(50  , $Ln , 'III.    Datos de Identificación del Alumno:' , 0 , 0 , 'L');
$pdf->Ln($Ln);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(30  , $Ln , 'Céd. Identidad: ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(68  , $Ln , $CedulaLetra.$Cedula  ,$borde, 0 , 'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40  , $Ln , ' Fecha de Nacimiento: ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(40  , $Ln , DDMMMMAAAA($FechaNac)  , $borde , 0 , 'L');
$pdf->Ln($Ln);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(20  , $Ln , 'Apellidos: ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(78  , $Ln , $Apellidos.' '.$Apellidos2  , $borde , 0 , 'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(20  , $Ln , ' Nombres: ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(83  , $Ln , $Nombres.' '.$Nombres2 , $borde , 0 , 'L');
$pdf->Ln($Ln);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(38  , $Ln , 'Lugar de Nacimiento: ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(60  , $Ln , $Localidad , $borde , 0 , 'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(35  , $Ln , ' Ent. Federal o País: ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(55  , $Ln , $Entidad.$LocalidadPais , $borde , 0 , 'L');
$pdf->Ln($Ln*2);


$pdf->SetFont('Arial','B',10);
$pdf->Cell(101  , $Ln , 'IV.   Planteles donde cursó estos estudios: ' , 1 , 0 , 'L');
$pdf->Cell(7    , $Ln , 'Nº' , 1 , 0 , 'C');
$pdf->Cell(52   , $Ln , 'Nombre del Plantel' , 1 , 0 , 'C');
$pdf->Cell(32   , $Ln , 'Localidad' , 1 , 0 , 'C');
$pdf->Cell(10   , $Ln , 'E.F.' , 1 , 0 , 'C');
$pdf->Ln($Ln);

$pdf->Cell(7    , $Ln , 'Nº' , 1 , 0 , 'C');
$pdf->Cell(52   , $Ln , 'Nombre del Plantel' , 1 , 0 , 'C');
$pdf->Cell(32   , $Ln , 'Localidad' , 1 , 0 , 'C');
$pdf->Cell(10   , $Ln , 'E.F.' , 1 , 0 , 'C');

$pdf->SetFont('Arial','',10);
$pdf->Cell(7    , $Ln , '3' , 1 , 0 , 'C');
$pdf->Cell(52   , $Ln , $Plantel[$PagNum][3]["Nombre"] , 1 , 0 , 'L');
$pdf->Cell(32   , $Ln , $Plantel[$PagNum][3]["Localidad"] , 1 , 0 , 'C');
$pdf->Cell(10   , $Ln , $Plantel[$PagNum][3]["EF"] , 1 , 0 , 'C');
$pdf->Ln($Ln);

$pdf->Cell(7    , $Ln , '1' , 1 , 0 , 'C');
$pdf->Cell(52   , $Ln , $Plantel[$PagNum][1]["Nombre"] , 1 , 0 , 'L');
$pdf->Cell(32   , $Ln , $Plantel[$PagNum][1]["Localidad"] , 1 , 0 , 'C');
$pdf->Cell(10   , $Ln , $Plantel[$PagNum][1]["EF"] , 1 , 0 , 'C');
$pdf->Cell(7    , $Ln , '4' , 1 , 0 , 'C');
$pdf->Cell(52   , $Ln , $Plantel[$PagNum][4]["Nombre"] , 1 , 0 , 'L');
$pdf->Cell(32   , $Ln , $Plantel[$PagNum][4]["Localidad"] , 1 , 0 , 'C');
$pdf->Cell(10   , $Ln , $Plantel[$PagNum][4]["EF"] , 1 , 0 , 'C');
$pdf->Ln($Ln);

$pdf->Cell(7    , $Ln , '2' , 1 , 0 , 'C');
$pdf->Cell(52   , $Ln , $Plantel[$PagNum][2]["Nombre"] , 1 , 0 , 'L');
$pdf->Cell(32   , $Ln , $Plantel[$PagNum][2]["Localidad"] , 1 , 0 , 'C');
$pdf->Cell(10   , $Ln , $Plantel[$PagNum][2]["EF"] , 1 , 0 , 'C');
$pdf->Cell(7    , $Ln , '5' , 1 , 0 , 'C');
$pdf->Cell(52   , $Ln , $Plantel[$PagNum][5]["Nombre"] , 1 , 0 , 'L');
$pdf->Cell(32   , $Ln , $Plantel[$PagNum][5]["Localidad"] , 1 , 0 , 'C');
$pdf->Cell(10   , $Ln , $Plantel[$PagNum][5]["EF"] , 1 , 0 , 'C');
$pdf->Ln($Ln);

$pdf->Ln($Ln);
$coorY = $pdf->GetY();
// FIN Encabezado

$pdf->SetFont('Arial','B',10);
$pdf->Cell($AnchoPagina , $Ln , 'V. Pensum de Estudio:' , 1 , 1 , 'L');

$AnchoCurso = $AnchoPagina / 2 - .5;

$_Col[0] = $AnchoCurso * .455;   // Materia
$_Col[1] = $AnchoCurso * .070; // nota
$_Col[2] = $AnchoCurso * .2;   // letras
$_Col[3] = $AnchoCurso * .06;   // te
$_Col[4] = $AnchoCurso * .065; // ["Mes"]
$_Col[5] = $AnchoCurso * .1; // ano
$_Col[6] = $AnchoCurso * .05;  // plantel

$_x_origen = $_x = $pdf->GetX();
$_y_origen = $pdf->GetY();
$sw_Columna_A = true;	
foreach($CodigoMaterias as $CodigoMateria){
	$IndiceAcademico = $IndiceAcademicoFactor = 0;
	
	$pdf->SetFont('Arial','',9);
	
	$pdf->SetX($_x); $pdf->Cell($AnchoCurso , $Ln ,$NombreCurso[ $CodigoMateria ] , 0 , 1 , 'C');
	
	$pdf->SetX($_x); 
	$pdf->Cell($_Col[0] , $Ln*2 , 'ÁREAS DE FORMACIÓN' , 1 , 0 , 'C');
	$pdf->Cell($_Col[1]+$_Col[2] , $Ln , 'Calificación' , 1 , 0 , 'C');
	$pdf->Cell($_Col[3] , $Ln*2 , 'T-E' , 1 , 0 , 'C');
	$pdf->Cell($_Col[4]+$_Col[5] , $Ln , 'Fecha' , 1 , 0 , 'C');
	$pdf->Cell($_Col[6] , $Ln*2 , '' , 1 , 0 , 'C');
	
	$_x_Plantel = $pdf->GetX() - $Ln/2 + .5;
	$_y_Plantel = $pdf->GetY() + 2*$Ln - .5;
	
	$pdf->SetFont('Arial','',7);
	$pdf->RotatedText($_x_Plantel,$_y_Plantel,'Plantel',90);

	$pdf->SetFont('Arial','',9);
	$pdf->Ln($Ln);
	
	$pdf->SetX($_x); 
	$pdf->Cell($_Col[0]);
	$pdf->Cell($_Col[1] , $Ln , 'Nº' , 1 , 0 , 'C');
	$pdf->Cell($_Col[2] , $Ln , 'LETRAS' , 1 , 0 , 'C');
	$pdf->Cell($_Col[3]);
	$pdf->Cell($_Col[4], $Ln , 'Mes' , '1' , 0 , 'C');
	$pdf->Cell($_Col[5], $Ln , 'Año' , '1' , 0 , 'C');
	$pdf->Ln($Ln);
	
	$pdf->SetFont('Arial','',10); $pdf->SetX($_x); 
	//$i_mat = 0;
	//while (strlen($Renglon[$CodigoMateria][++$i_mat]["Materia"]) > 1){
	//$i_mat++;
	for ($i_mat = 1 ; $i_mat <= $NumMaterias[$CodigoMateria] ; $i_mat++){
		
		
		$pdf->SetX($_x); 
	
		if (strlen($Renglon[$CodigoMateria][$i_mat]["Materia"]) > 35)
			$pdf->SetFont('Arial','B',7);
		elseif (strlen($Renglon[$CodigoMateria][$i_mat]["Materia"]) > 22)
			$pdf->SetFont('Arial','',8);
		$pdf->Cell($_Col[0] , $Ln , $Renglon[$CodigoMateria][$i_mat]["Materia"] , 1 , 0 , 'L');
		$pdf->SetFont('Arial','',10); 
	
		
		if( $Renglon[$CodigoMateria][$i_mat]["Nota"] < ' ' or 
			$Renglon[$CodigoMateria][$i_mat]["Nota"] == '*'  )	{
				
					$Renglon[$CodigoMateria][$i_mat]["Nota"]='*';
					$Renglon[$CodigoMateria][$i_mat]["TE"]='*';
					$Renglon[$CodigoMateria][$i_mat]["Mes"]='*';
					$Renglon[$CodigoMateria][$i_mat]["Ano"]='*';
					$Renglon[$CodigoMateria][$i_mat]["Plantel"]='*';
			
			}
		else{
				if($Renglon[$CodigoMateria][$i_mat]["Nota"] >= '10' 
						and $Renglon[$CodigoMateria][$i_mat]["Nota"] <= '20' 
						and $Renglon[$CodigoMateria][$i_mat]["Materia"]>''){
					$IndiceAcademico += $Renglon[$CodigoMateria][$i_mat]["Nota"];	
					$IndiceAcademicoFactor++;	}
			}
			
			
			
		
		$NotaRenglon = $Renglon[$CodigoMateria][$i_mat]["Nota"];
		if($Renglon[$CodigoMateria][$i_mat]["Materia"] > ''){
			if($NotaRenglon >= '01' and $NotaRenglon <= '09')
				$NotaRenglon = "P";
			$pdf->Cell($_Col[1] , $Ln , $NotaRenglon , 1 , 0 , 'C');}
		else
			$pdf->Cell($_Col[1] , $Ln , '*' , 1 , 0 , 'C');
				
		
		
		if($Renglon[$CodigoMateria][$i_mat]["Nota"]<>'Ex'){
			if($Renglon[$CodigoMateria][$i_mat]["Materia"] > ''){
				$pdf->Cell($_Col[2] , $Ln , EnLetras($NotaRenglon) , 1 , 0 , 'C');}
			else
				$pdf->Cell($_Col[2] , $Ln , '*' , 1 , 0 , 'C');
			
			$TE_Renglon = $Renglon[$CodigoMateria][$i_mat]["TE"];
			$Renglon_["Mes"] = $Renglon[$CodigoMateria][$i_mat]["Mes"];
			$Renglon_Ano = $Renglon[$CodigoMateria][$i_mat]["Ano"];
			
			if($NotaRenglon == 'P' or $NotaRenglon == '-' or $NotaRenglon == '--'){
				$TE_Renglon = '*';
				$Renglon_["Mes"] = "";
				$Renglon_Ano = "";
				}
			
			$pdf->Cell($_Col[3] , $Ln , $TE_Renglon , 1 , 0 , 'C');
			$pdf->Cell($_Col[4] , $Ln , $Renglon_["Mes"] , 1 , 0 , 'C');
			$pdf->Cell($_Col[5] , $Ln , $Renglon_Ano , 1 , 0 , 'C');
			
			
			$pdf->Cell($_Col[6] , $Ln , $Renglon[$CodigoMateria][$i_mat]["Plantel"] , 1 , 0 , 'C'); 
		}
		else {
			$pdf->Cell($_Col[2] , $Ln , 'Exonerada' , 1 , 0 , 'C');
			$pdf->Cell($_Col[3] , $Ln , "*" , 1 , 0 , 'C');
			$pdf->Cell($_Col[4] , $Ln , "*" , 1 , 0 , 'C');
			$pdf->Cell($_Col[5] , $Ln , "*" , 1 , 0 , 'C');
			$pdf->Cell($_Col[6] , $Ln , "*" , 1 , 0 , 'C'); 
			
			
			
			
			//$pdf->SetFont('Arial','',9);
			//$pdf->Cell($_Col[3]+$_Col[4]+$_Col[5]+$_Col[6] , $Ln , 'Art.134 R.G.L.O.E.' , 1 , 0 , 'C');
			$pdf->SetFont('Arial','',10);
			}
		$pdf->Ln($Ln);
}

	if($sw_Columna_A) {
		// termina columna A
		$_x = $_x_origen + $AnchoCurso + 1;
		
		$_y_fin_A = $pdf->GetY();
		$pdf->SetY($_y_origen);
		
		$sw_Columna_A = false;
		}
	else{ 
		// termina columna B
		$_x = $_x_origen;
		
		$_y_origen = $pdf->GetY();
		$pdf->SetY($_y_origen);
		
		$sw_Columna_A = true;
		}
	
	if ($IndiceAcademicoFactor > 0)
		$PromedioCurso[$CodigoMateria] = round($IndiceAcademico/$IndiceAcademicoFactor , 2);
}
			









// Obj
foreach ($CodigoMaterias as $CodigoMateria) {
	
	$NotaOrientacion[$CodigoMateria] = "*  *  *";
	$MateriaFormacion[$CodigoMateria] = "*  *  *";
	$PosOrientacion[$CodigoMateria] = 0;
	$PosFormacion[$CodigoMateria] = 0;
	
	
	if( strpos(" ".$Renglon[$CodigoMateria][20]["Materia"] ,"Orientac") > 0 ){
		$PosOrientacion[$CodigoMateria] = 20;
		$PosFormacion[$CodigoMateria] = 21;
		}
	elseif( strpos(" ".$Renglon[$CodigoMateria][21]["Materia"] ,"Orientac") > 0 ){
		$PosOrientacion[$CodigoMateria] = 21;
		$PosFormacion[$CodigoMateria] = 20;
		}
	
	if ($PosOrientacion[$CodigoMateria] > 0)
		$NotaOrientacion[$CodigoMateria] = Nota_Letra($Renglon[$CodigoMateria][$PosOrientacion[$CodigoMateria]]["Nota"]);
	if ($Renglon[$CodigoMateria][$PosOrientacion[$CodigoMateria]]["Nota"] == "--"){
		$NotaOrientacion[$CodigoMateria] = "Exonerada";
	}
	
	
	
	if ($PosFormacion[$CodigoMateria] > 0){
		$NotaFormacion[$CodigoMateria] = Nota_Letra($Renglon[$CodigoMateria][$PosFormacion[$CodigoMateria]]["Nota"]);
		$MateriaFormacion[$CodigoMateria] = $Renglon[$CodigoMateria][$PosFormacion[$CodigoMateria]]["Materia"];
	}
	if($MateriaFormacion[$CodigoMateria] == "Exonerada" or $MateriaFormacion[$CodigoMateria] == "*  *  *" ){
		$NotaFormacion[$CodigoMateria] = "*";
		}
		

}

// fin Obj


	$pdf->SetX($_x); $pdf->Cell($AnchoCurso , $Ln , "ÁREAS DE FORMACIÓN" , 0 , 1 , 'C');
	
	$pdf->SetX($_x); 
	$pdf->SetFont('Arial','',9);
	$pdf->Cell($_Col[0] , $Ln , 'ÁREA DE FORMACIÓN' , 1 , 0 , 'C');
	$pdf->Cell($_Col[1] , $Ln , 'año' , 1 , 0 , 'C');
	$pdf->Cell($_Col[2]+$_Col[3]+$_Col[4]+$_Col[5]+$_Col[6] , $Ln , 'LITERAL' , 1 , 0 , 'C');
	$pdf->Ln($Ln);
	
	$_y = $pdf->GetY();
	$pdf->SetX($_x); 
		$pdf->Cell($_Col[0] , $Ln*5 , "" , 1 , 0 , 'C');
	$pdf->SetXY($_x , $_y+$Ln*1.5); 
		$pdf->Cell($_Col[0] , $Ln , "ORIENTACIÓN Y" , 0 , 0 , 'C');
	$pdf->SetXY($_x , $_y+$Ln*2.5); 
		$pdf->Cell($_Col[0] , $Ln , "CONVIVENCIA" , 0 , 0 , 'C');
	
	$pdf->SetXY($_x,$_y); 
	
	$i = 0;
	foreach ($CodigoMaterias as $CodigoMateria) {
	//for ($i = 1 ; $i <= 5 ; $i++){
		$i++;
		$pdf->SetX($_x + $_Col[0]); 
		$pdf->Cell($_Col[1] , $Ln , $i."º" , 1 , 0 , 'C');
		
		$Nota = $NotaOrientacion[$CodigoMateria];
		$pdf->Cell($_Col[2]+$_Col[3]+$_Col[4]+$_Col[5]+$_Col[6] , $Ln , $Nota , 1 , 0 , 'C');
		$pdf->Ln($Ln);
	}













	$pdf->SetX($_x); 
	$pdf->SetFont('Arial','',9);
	$pdf->Cell($_Col[0] , $Ln , 'ÁREA DE FORMACIÓN' , 1 , 0 , 'C');
	$pdf->Cell($_Col[1] , $Ln , 'año' , 1 , 0 , 'C');
	$pdf->Cell($_Col[2]+$_Col[3]+$_Col[4] , $Ln , 'GRUPO' , 1 , 0 , 'C');
	$pdf->Cell($_Col[5]+$_Col[6] , $Ln , 'LITERAL' , 1 , 0 , 'C');
	$pdf->Ln($Ln);
	
	$_y = $pdf->GetY();
	$pdf->SetX($_x); 
		$pdf->Cell($_Col[0] , $Ln*5 , "" , 1 , 0 , 'C');
	$pdf->SetXY($_x , $_y+$Ln); 
		$pdf->MultiCell($_Col[0] , $Ln , "PARTICIPACIÓN EN GRUPOS DE CREACIÓN Y PRODUCCIÓN" , 0 , 'C');
	
	$pdf->SetXY($_x,$_y); 
	
	$i = 0;
	foreach ($CodigoMaterias as $CodigoMateria) {
	//for ($i = 1 ; $i <= 5 ; $i++){
		$i++;
		$pdf->SetX($_x + $_Col[0]); 
		$pdf->Cell($_Col[1] , $Ln , $i."º" , 1 , 0 , 'C');
		
		/*if ($Renglon[$CodigoMateria][21]["Nota"] > "" or $Renglon[$CodigoMateria][20]["Materia"] == "Exonerada")
			$materia = $Renglon[$CodigoMateria][20]["Materia"];
		else*/
		
		$materia = $MateriaFormacion[$CodigoMateria];
		
		$pdf->Cell($_Col[2]+$_Col[3]+$_Col[4] , $Ln , $materia."" , 1 , 0 , 'C');
		
		/*if ($Renglon[$CodigoMateria][21]["Materia"] == "Exonerada")
			$Nota = "*";
		elseif ($Nota = $Renglon[$CodigoMateria][21]["Nota"] > "")	
			$Nota = Nota_Letra($Renglon[$CodigoMateria][21]["Nota"]);
		else
		*/
		
		
		$Nota = $NotaFormacion[$CodigoMateria];
		
		if($materia == "Exonerada")
			$Nota = "*";
		
		$pdf->Cell($_Col[5]+$_Col[6] , $Ln , $Nota , 1 , 0 , 'C');
		
			
		$pdf->Ln($Ln);
	}













foreach ($CodigoMaterias as $CodigoMateria) {
	if ($PromedioCurso[$CodigoMateria] > 0)
		$Promedio_Conteo++;
	$Promedio_Sumatoria += $PromedioCurso[$CodigoMateria];
}

if ($Promedio_Conteo > 0 and $_GET['Promedia'] == 1)	{
	$Promedio_ = round ($Promedio_Sumatoria / $Promedio_Conteo , 2);
	$Obs = $Obs." Promedio = " . $Promedio_;
}


$pdf->MultiCell(202 , $Ln , 'VI.  Observaciones: ' . $Obs . $Observaciones[$PagNum-1] , 'B', 'L');
$pdf->Ln($Ln);



$_x = 5;
$pdf->SetX($_x); $pdf->Cell($AnchoCurso , $Ln , "VII. PLANTEL" , 1 , 1 , 'L');
$AnchoA = $_Col[0]+$_Col[1];
$pdf->SetX($_x); $pdf->Cell($AnchoA , $Ln , "Director(a):" , 1 , 0 , 'L');
$_y = $pdf->GetY();
$pdf->MultiCell($AnchoCurso-$AnchoA , $Ln*7 , "SELLO DEL PLANTEL" , 1 , 'C');

$pdf->SetXY($_x,$_y+$Ln); $pdf->Cell($AnchoA , $Ln , "Apellidos y Nombres:" , 1 , 1 , 'L');
$pdf->SetX($_x); $pdf->Cell($AnchoA , $Ln , "$Director_Nombre" , 1 , 1 , 'R'); //VITA MARIA DI CAMPO
$pdf->SetX($_x); $pdf->Cell($AnchoA , $Ln , "Número de C.I.:" , 1 , 1 , 'L');
$pdf->SetX($_x); $pdf->Cell($AnchoA , $Ln ,"$Director_CI" , 1 , 1 , 'R'); // V-6973243
$pdf->SetX($_x); $pdf->Cell($AnchoA , $Ln , "Firma:" , 1 , 1 , 'L');
$pdf->SetX($_x); $pdf->Cell($AnchoA , $Ln , "Para efecto de su validéz Nacional" , 1 , 1 , 'C');



$_x = 5+$AnchoCurso;
$_y = $pdf->GetY();
$pdf->SetXY($_x,$_y-$Ln*8); $pdf->Cell($AnchoCurso , $Ln , "VIII. Zona Educativa" , 1 , 1 , 'L');
$AnchoA = $_Col[0]+$_Col[1];
$pdf->SetX($_x); $pdf->Cell($AnchoA , $Ln , "Director(a):" , 1 , 0 , 'L');
$_y = $pdf->GetY();
$pdf->Cell($AnchoCurso-$AnchoA , $Ln*7 , "" , 1 , 0 , 'L');

$pdf->Ln($Ln*2.5);
$pdf->SetX($_x+$AnchoA); $pdf->MultiCell($AnchoCurso-$AnchoA , $Ln , "SELLO DE LA ZONA EDUCATIVA" , 0 , 'C');

$pdf->SetXY($_x,$_y+$Ln); $pdf->Cell($AnchoA , $Ln , "Apellidos y Nombres:" , 1 , 1 , 'L');
$pdf->SetX($_x); $pdf->Cell($AnchoA , $Ln , "" , 1 , 1 , 'R');
$pdf->SetX($_x); $pdf->Cell($AnchoA , $Ln , "Número de C.I.:" , 1 , 1 , 'L');
$pdf->SetX($_x); $pdf->Cell($AnchoA , $Ln , "", 1 , 1 , 'R');
$pdf->SetX($_x); $pdf->Cell($AnchoA , $Ln , "Firma:" , 1 , 1 , 'L');
$pdf->SetFont('Arial','',8);
$pdf->SetX($_x); $pdf->Cell($AnchoA , $Ln , "Para efecto de su validéz Internacional" , 1 , 1 , 'C');
$pdf->SetFont('Arial','',10);


	
	
	
	
	
	
	
	
	
			
// DORSO
$pdf->AddPage();
$pdf->SetY(20);

$pdf->SetFont('Arial','B', 14);
$pdf->SetX(15); $pdf->Cell(20 , 6 , 'Verificado y Revisado por:' , '',1 , 'L');
/*
$pdf->SetFont('Arial','', 12);
$pdf->SetX(15); $pdf->Cell(20 , 6 , 'Omaira J. Fernández G.' , '',1 , 'L');
$pdf->SetX(15); $pdf->Cell(20 , 6 , 'C.I.5.223.338' , '',1 , 'L');
$pdf->Ln(6);

$pdf->SetFont('Arial','B', 12);
$pdf->SetX(15); $pdf->Cell(20 , 6 , 'Revisado por:' , '',1 , 'L');
*/
	
$pdf->SetFont('Arial','', 12);

$pdf->SetX(15); $pdf->Cell(20 , 6 , 'Lic. Angela J. Reale H.' , '',1 , 'L');
$pdf->SetX(15); $pdf->Cell(20 , 6 , 'C.I.5.220.494' , '',1 , 'L');
$pdf->SetX(15); $pdf->Cell(20 , 6 , 'Dpto. de Control de Estudio y Evaluación' , '',1 , 'L');
//$pdf->SetX(15); $pdf->Cell(20 , 6 , 'Lic. Ronald E. Rincón P.' , '',1 , 'L');
//$pdf->SetX(15); $pdf->Cell(20 , 6 , 'C.I.14.018.534' , '',1 , 'L');

$pdf->Ln(6);
//$pdf->SetX(15); $pdf->Cell(20 , 6 , 'Caracas, 30 de Julio de 2020'  , '',1 , 'L');
 $pdf->SetX(15); $pdf->Cell(20 , 6 , 'Caracas, ' .date('d').' de ' . Mes(date('m')) .' de '.date('Y') , '' ,1 , 'L');
		
		
}


$pdf->Output();


?>
