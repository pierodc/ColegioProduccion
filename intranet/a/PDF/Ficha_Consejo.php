<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin";
require_once('../../../inc_login_ck.php'); 

require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 
require_once('../archivo/Variables.php');
require_once('../../../inc/notas.php');  

$TituloPantalla = "TituloPantalla";

mysql_select_db($database_bd, $bd);
// $query_RS_Alumno = $query_RS_Alumno.' LIMIT 18,18'; // LIMIT   desde,cantidad
$RS_Alumno = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumno = mysql_fetch_assoc($RS_Alumno);

$CodigoCurso = "-1";
if (isset($row_RS_Alumno['CodigoCurso'])) {
  $CodigoCurso = $row_RS_Alumno['CodigoCurso'];
}

$query_RS_Curso = "SELECT * FROM Curso WHERE CodigoCurso = ".$CodigoCurso; 
$RS_Curso = mysql_query($query_RS_Curso, $bd) or die(mysql_error());
$row_RS_Curso = mysql_fetch_assoc($RS_Curso);
$NombreCompleto = $row_RS_Curso['NombreCompleto'];


$Nombre = $row_RS_Alumno['Apellidos'].' '.$row_RS_Alumno['Apellidos2'].' '.
		  $row_RS_Alumno['Nombres'].' '.$row_RS_Alumno['Nombres2'].
		  '  ('. $row_RS_Alumno['CodigoAlumno'].')';


$fotoNew = '../../../'.$AnoEscolar.'/'.$row_RS_Alumno['CodigoAlumno'].'.jpg';
$fotoOld = '../../../'.$AnoEscolarAnte.'/'.$row_RS_Alumno['CodigoAlumno'].'.jpg';
if(file_exists($fotoNew)){
	$foto = $fotoNew;}
else{
	$foto = $fotoOld;}



	// LLENA MATRIZ notas Trimestres
	foreach (array(1, 2, 3) as $_Lapso) { // cada LAPSO
		foreach (array('-70','-30','-Def','-BConduc','i','mp') as $_Eval) { // Cada Evaluacion
			
			$query_Nota = "SELECT * FROM Nota 
							WHERE CodigoAlumno = ". $row_RS_Alumno['CodigoAlumno']." 
							AND Lapso= '$_Lapso"."$_Eval' 
							AND Ano_Escolar='$AnoEscolar'";
							
			$_Nota = mysql_query($query_Nota, $bd) or die(mysql_error());
			$_row_Nota = mysql_fetch_assoc($_Nota);
			$_totalRows = mysql_num_rows($_Nota);
			
			if($_totalRows == 0 and $_Eval=='-30'){
				//echo $query_Nota.'<br>';
				$query_Nota = "SELECT * FROM Nota 
								WHERE CodigoAlumno = ". $row_RS_Alumno['CodigoAlumno']." 
								AND Lapso= '$_Lapso"."-70' 
								AND Ano_Escolar='$AnoEscolar'";
				$_Nota = mysql_query($query_Nota, $bd) or die(mysql_error());
				$_row_Nota = mysql_fetch_assoc($_Nota);
				$_totalRows = mysql_num_rows($_Nota);
				}
			

			if($_totalRows > 0)
			foreach (array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12') as $fila_x) { // Cada Materia
				$Matriz[$_Lapso][$_Eval][$fila_x] = Nota($_row_Nota['n'.$fila_x]);
				
				if($_row_Nota['n'.$fila_x] > '' and $_row_Nota['n'.$fila_x] <> '*' and $_Eval == 'mp'){
					$Matriz[$_Lapso][mp] = $_row_Nota['n'.$fila_x];
					$Matriz[$_Lapso][mp]['n'.$fila_x] = $_row_Nota['n'.$fila_x];
					}
					
				if( $_row_Nota['n'.$fila_x] > 0 and $_Eval == '-Def' ) { 
					$Matriz[$_Lapso][promedio][suma] += $_row_Nota['n'.$fila_x]; 
					$Matriz[$_Lapso][promedio][cuenta]++;
//					$Matriz[definitiva][cuenta][$fila_x]++;
//					$Matriz[definitiva][suma][$fila_x] = $_row_Nota['n'.$fila_x];
					}
				if($_Eval=='-Def') 
					$Matriz[$_Lapso][Pos][$fila_x] = Posicion ($database_bd, $bd, 'n'.$fila_x, $_row_Nota['n'.$fila_x], $CodigoCurso, $_Lapso."-Def", $AnoEscolar);
				if($_Eval=='i'){ 
					$Matriz[definitiva][i][$fila_x]+=$_row_Nota['n'.$fila_x]; }
			}
		}
	}
	
	
				// Llema Matriz de las definitivas del año
				$query_Nota = "SELECT * FROM Nota 
								WHERE CodigoAlumno = '". $row_RS_Alumno['CodigoAlumno']."' 
								AND Lapso= 'Def' 
								AND Ano_Escolar='$AnoEscolar'";
				$_Nota = mysql_query($query_Nota, $bd) or die(mysql_error());
				$_row_Nota = mysql_fetch_assoc($_Nota);
				$_totalRows = mysql_num_rows($_Nota);
				
				if($_totalRows == 1 or date('m') == '06' or date('m') == '07' or date('m') == '08')
				foreach (array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12') as $fila_x) { // Cada Materia
					$Matriz[definitiva][$fila_x] = $_row_Nota['n'.$fila_x];
					if( $_row_Nota['n'.$fila_x] > 0 ){
						$Matriz[definitiva][promedio][suma] += $_row_Nota['n'.$fila_x]; 
						$Matriz[definitiva][promedio][cuenta]++;}
						$Matriz[definitiva][Pos][$fila_x] = Posicion ($database_bd, $bd, 'n'.$fila_x, $_row_Nota['n'.$fila_x], $CodigoCurso, "Def", $AnoEscolar);


				}
	
	
	
	// llena matriz con materias
	$query_RS_Curso = "SELECT * FROM Curso, CursoMaterias WHERE Curso.CodigoMaterias = CursoMaterias.CodigoMaterias AND Curso.CodigoCurso = ".$row_RS_Alumno['CodigoCurso'];
	$RS_Curso = mysql_query($query_RS_Curso, $bd) or die(mysql_error());
	$row_RS_Curso = mysql_fetch_assoc($RS_Curso);
	foreach (array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12') as $fila_x) {
		$Matriz[materia][$fila_x] = $row_RS_Curso['Materia'.$fila_x];
	}
	



/*
// Conectar
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

// Ejecuta $sql
$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();


// Ejecuta $sql y While
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	extract($row);
    echo "<br>";
}

$RS->data_seek(0);

if(isset($_POST['button'])){
	$sql = "INSERT INTO Table (Codigo) VALUES
			('".$_POST['Codigo']."')";
	$mysqli->query($sql);
}

*/

 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title><?php echo $TituloPantalla ="Lista Notas"; ?></title>
<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>

<script src="../../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />

<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />

<script src="../../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<body>

<table border="1">
  <tr>
    &nbsp;
<?php 
foreach (array(1, 2, 3) as $_Lapso) { ?>
<?php 
	foreach (array('-Def','i') as $_Eval) {
		?><td>
        <table width="30" border="1"><?php 
		foreach (array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12') as $fila_x) { // Nota Evaluaciones
				$BConduc='';
				if($_Eval=="-Def") {
					$b='B';
					if($Matriz[$_Lapso]['-BConduc'][$fila_x]==1) $BConduc = '•';
					if($Matriz[$_Lapso]['-BConduc'][$fila_x]> 1) $BConduc = ':';
					} 
				else $b=''; 
				
				$nota_aux = $Matriz[$_Lapso][$_Eval][$fila_x];
	
				if($_Eval == 'i' and $nota_aux > 0) 
					$nota_aux = $nota_aux * 1;
				?>
  <tr>
    <td>&nbsp;<?php echo $BConduc.$nota_aux; ?></td>
  </tr>
<?php 
		}
	?></table></td>
	<?php } 
}
?>
</tr>
</table>



</body>
</html>