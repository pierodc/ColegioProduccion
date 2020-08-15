<?php 
require_once('../../Connections/bd.php');
require_once('../../inc/rutinas.php');


mysql_select_db($database_bd, $bd);

//

//echo $array[3][1];

if(isset($_POST['mats'])){
$mats = $_POST['mats'];
$i=0;
do{
	
$sql =  " UPDATE Materias 
			SET Materia = '".$mats[$i][mat] . "' , 
			Cedula = '".$mats[$i][ced] . "' , 
			Hr_Semanales = '".$mats[$i][hrs] . "' 
			WHERE Codigo_Materia = '".$mats[$i][cod]."'";
//echo $sql.'<br>';			
$Result1 = mysql_query($sql, $bd) or die(mysql_error());

$i=$i+1;
} while ($mats[$i][cod]>'');
}
/* Actualiza
foreach ( $_POST as $key => $value ) {
	//if(substr($key,0,1)=='P'  ){
		
	//$Cedula = substr($value, strpos($value, 'Cedula')+7, 8 )*1;
	//$CodigoCurso = substr($value, strpos($value, 'CodigoCurso')+12, 2 )*1;
	//$Descripcion = substr($value, strpos($value, 'Descripcion')+12 );
	
		if($value!='0'){
		$Codigo_Bloque = substr($key,1);
		
		if ($Cedula>0){
		$sql = "UPDATE Horario SET Cedula_Prof = '$Cedula' WHERE (Cedula_Prof IS NULL OR Cedula_Prof='0') AND Descripcion = '$Descripcion' ";
		//  AND CodigoCurso='$CodigoCurso'
		//echo $value.'<br>';
		//echo $sql.'<br>';
		$Result1 = mysql_query($sql, $bd) or die(mysql_error());}

//}
}}
*/

$query_RS_Materias = "SELECT * FROM  Materias, Curso
						WHERE Materias.CodigoMaterias = Curso.CodigoMaterias
						AND Curso.NivelCurso >= '31'
						GROUP BY Materias.Codigo_Materia 
						ORDER BY Curso.NivelCurso, Materia ASC";
$RS_Materias = mysql_query($query_RS_Materias, $bd) or die(mysql_error());
$row_RS_Materias = mysql_fetch_assoc($RS_Materias);
$totalRows_RS_Materias = mysql_num_rows($RS_Materias);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
</head>

<body>

<?php 
/*function Campo($name, $value, $type, $size){
	if ($size<1) $size=10;
	if ($type=='') $type='text';
	echo '<input name="'.$name.'" type="'.$type.'" value="'.$value.'" size="'.$size.'" />';}
*/?>
<form action="" method="post" name="form">
<table border="1" cellpadding="3" >
  <tr>
    <td colspan="2">Curso</td>
    <td>C.I. Prof</td>
    <td>Hr/Semana</td>
    <td>&nbsp;</td>
  </tr>
<?php 
$i=0;
do {
extract($row_RS_Materias);	
if($CodigoMateriasAnterior != $CodigoMaterias){
?>
  <tr>
    <td colspan="5"><?php echo $NombreCompleto; ?>&nbsp;
      <input type="submit" name="button" id="button" value="Submit" /></td>
  </tr>
<?php } ?>
  <tr>
    <td><?php Campo('mats['.$i.'][cod]', 'hidden', $Codigo_Materia, 1,'')  ?>&nbsp;</td>
    <td><?php Campo('mats['.$i.'][mat]', $type, $Materia, 20,'')  ?>&nbsp;</td>
    <td><?php Campo('mats['.$i.'][ced]', $type, $Cedula, $size,'') ?>&nbsp;</td>
    <td><?php Campo('mats['.$i.'][hrs]', $type, $Hr_Semanales, 4,'') ?>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
<?php 
$CodigoMateriasAnterior = $CodigoMaterias;
$i=$i+1;
} while ($row_RS_Materias = mysql_fetch_assoc($RS_Materias));
?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table></form>

</body>
</html>
<?php
//var_dump($_POST['mats']);
mysql_free_result($RS_Materias);
?>
