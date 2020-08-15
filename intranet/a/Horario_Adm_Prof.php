<?php 
if(!isset($_GET['Cedula_Prof']))
  header("Location: Horario_Adm_Prof.php?Cedula_Prof=3250116");

require_once('../../Connections/bd.php');
require_once('../../inc/rutinas.php');

mysql_select_db($database_bd, $bd);

$colname_RS_Bloque_Prof = "-1";
if (isset($_GET['Cedula_Prof'])) {
  $Cedula_Prof = $_GET['Cedula_Prof'];
}

if(isset($_GET['Cedula_Prof']) and isset($_GET['Dia']) and isset($_GET['No_Bloque']) and isset($_GET['add'])){
	$sql = 'INSERT INTO Horario (Cedula_Prof,Dia_Semana,No_Bloque,Descripcion) VALUES ('.$_GET['Cedula_Prof'].','.$_GET['Dia'].','.$_GET['No_Bloque'].',200) ';
	$RS_sql = mysql_query($sql, $bd) or die(mysql_error());
	header("Location: Close.html");
}

if(isset($_GET['Cedula_Prof']) and isset($_GET['Dia']) and isset($_GET['No_Bloque']) and isset($_GET['delete'])){
	$sql = "DELETE FROM Horario 
			WHERE Cedula_Prof='".$_GET['Cedula_Prof']."' 
			AND Dia_Semana='".$_GET['Dia']."' 
			AND No_Bloque='".$_GET['No_Bloque']."' 
			AND Descripcion='200' ";
			//echo $sql;
	$RS_sql = mysql_query($sql, $bd) or die(mysql_error());
	header("Location: Close.html");
}
//AND (Horario.CodigoCurso>='35' AND Horario.CodigoCurso<='44' OR (Horario.CodigoCurso = '0'))
$sql=sprintf("SELECT * FROM Horario, Materias , Curso
				WHERE Horario.Descripcion = Materias.Codigo_Materia 
				AND Horario.CodigoCurso = Curso.CodigoCurso 
				
				AND Horario.Cedula_Prof = %s  
				ORDER BY Horario.Descripcion", GetSQLValueString($Cedula_Prof, "text"));
$RS_sql = mysql_query($sql, $bd) or die(mysql_error());
$row_RS_sql = mysql_fetch_assoc($RS_sql);
//echo $sql;
unset($Bloque);

do{
	extract($row_RS_sql);
	if($Curso>0)
	$Describe = substr($NombreCompleto ,0, 6).' '.$Seccion.'  :  '.substr($Materia,0,3);
	elseif($Curso==0)
	$Describe = 'Adm';
	
	if( $Bloque[$Dia_Semana][$No_Bloque][0]=='')
		$Bloque[$Dia_Semana][$No_Bloque][0] = $Describe;
	else
		$Bloque[$Dia_Semana][$No_Bloque][1] = $Describe;
} while ($row_RS_sql = mysql_fetch_assoc($RS_sql));




// Bloque de horas del Horario
$query_RS_Bloques = "SELECT * FROM HorarioBloques WHERE Grupo = '2' ";
$RS_Bloques = mysql_query($query_RS_Bloques, $bd) or die(mysql_error());
$row_RS_Bloques = mysql_fetch_assoc($RS_Bloques);
$totalRows_RS_Bloques = mysql_num_rows($RS_Bloques);
	$i=1;
	do{ // Imprime Horas y Recesos
	extract($row_RS_Bloques);
	$Hora[$i][0] = $Descripcion ;
	
	if($Tipo == 'R')
		$Hora[$i][1] = 'R E C R E O';
	if($Tipo == 'A')
		$Hora[$i][1] = 'A L M U E R Z O';
		
	$i=$i+1;	

}while ($row_RS_Bloques = mysql_fetch_assoc($RS_Bloques));

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</head>

<body>
<p align="center">
  <?php 
$query_RS_Prof = "SELECT * FROM Empleado 
					WHERE (TipoDocente 
					LIKE '%Prof%' OR TipoDocente 
					LIKE '%Doc%' OR  TipoDocente 
					LIKE '%Maestra%' ) 
					AND SW_activo='1'  
					ORDER BY Apellidos, Nombres";
$RS_Prof = mysql_query($query_RS_Prof, $bd) or die(mysql_error());
$row_RS_Prof = mysql_fetch_assoc($RS_Prof);

?>
  <select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)">
    <option value="Horario_adm.php" >Seleccione...</option>
    <?php
do {  
?>
    <option value="Horario_Adm_Prof.php?Cedula_Prof=<?php echo $row_RS_Prof['Cedula'] ?>" <?php if (!(strcmp($row_RS_Prof['Cedula'], $_GET['Cedula_Prof']))) {echo "selected=\"selected\"";} ?>><?php echo $row_RS_Prof['Apellidos'].' '.$row_RS_Prof['Nombres'] ?></option>
    <?php
} while ($row_RS_Prof = mysql_fetch_assoc($RS_Prof));
  $rows = mysql_num_rows($RS_Prof);
  if($rows > 0) {
      mysql_data_seek($RS_Prof, 0);
	  $row_RS_Prof = mysql_fetch_assoc($RS_Prof);
  }
?>
  </select>
</p>
<table width="800" border="1" align="center">
  <tr>
    <td width="10%" nowrap="nowrap">&nbsp;</td>
<?php 
foreach($DiasSemana as $Dia)
	echo '<td align="center" width="18%"> '.$Dia.' &nbsp;</td>';
 ?>   
  </tr>
<?php 
for ($No_Bloque = 1; $No_Bloque <= 15; ) {	?>
  <tr> 
    <td align="center" nowrap="nowrap"><?php echo $Hora[$No_Bloque][0] ?>&nbsp;</td>
<?php
foreach($NoDiasSemana as $Dia){
		if($Dia == 1 and ($No_Bloque==3 or $No_Bloque==8 or $No_Bloque==11)) {	
			echo '<td align="center" nowrap="nowrap" colspan="5"> '.$Hora[$No_Bloque][1];
			echo' &nbsp;</td>';}
			
		if(!($No_Bloque==3 or $No_Bloque==8 or $No_Bloque==11))	
			if ($Bloque[$Dia][$No_Bloque][0]>'')
				if($Bloque[$Dia][$No_Bloque][0]=='Adm'){
					echo '<td align="center" nowrap="nowrap"> Admin ';
					echo '(<a href="Horario_Adm_Prof.php?';
					echo 'Cedula_Prof='.$Cedula_Prof.'&Dia='.$Dia.'&No_Bloque='.$No_Bloque.'&delete=1" ';
					echo 'target="_blank">elimi&nbsp;</a>)';
					echo ' &nbsp;</td>'; }
				else	{
					echo '<td align="center" nowrap="nowrap"> '.$Bloque[$Dia][$No_Bloque][0].$Bloque[$Dia][$No_Bloque][1];
					echo' &nbsp;</td>';}
			else {
				echo '<td align="center" nowrap="nowrap">';
				echo '<a href="Horario_Adm_Prof.php?';
				echo 'Cedula_Prof='.$Cedula_Prof.'&Dia='.$Dia.'&No_Bloque='.$No_Bloque.'&add=1" ';
				echo 'target="_blank">+adm&nbsp;</a>';
				echo '</td>';
					}
			
	
 } ?> 
  </tr>
  <?php $No_Bloque++; } ?>
</table>


<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>
<?php
mysql_free_result($RS_sql);
?>
