<?php 
if(!isset($_GET['CodigoCurso']))
  header("Location: Horario_adm.php?CodigoCurso=35");

require_once('../../Connections/bd.php');
require_once('../../inc/rutinas.php');


  mysql_select_db($database_bd, $bd);

// Elimina Prof de un bloque
if ((isset($_GET['Codigo_Bloque'])) && ($_GET['Codigo_Bloque'] != "") && (isset($_GET['no_prof']))) {
  $deleteSQL = sprintf("UPDATE Horario SET Cedula_Prof='0' WHERE Codigo_Bloque=%s",
                       GetSQLValueString($_GET['Codigo_Bloque'], "int"));

  $Result1 = mysql_query($deleteSQL, $bd) or die(mysql_error());

  $deleteGoTo = "Close.html";
  header(sprintf("Location: %s", $deleteGoTo));
}




// Actualiza Prof Bloque
$be_var = $_POST;
foreach ( $be_var as $key => $value ) {
	if(substr($key,0,1)=='P'  ){
		
	$Cedula = substr($value, strpos($value, 'Cedula')+7, 8 )*1;
	$CodigoCurso = substr($value, strpos($value, 'CodigoCurso')+12, 2 )*1;
	$Descripcion = substr($value, strpos($value, 'Descripcion')+12 );
	
		if($value!='0'){
		$Codigo_Bloque = substr($key,1);
		
		if ($Cedula>0){
		$sql = "UPDATE Horario SET Cedula_Prof = '$Cedula' WHERE (Cedula_Prof IS NULL OR Cedula_Prof='0') 
		AND CodigoCurso='$CodigoCurso'
		AND Descripcion = '$Descripcion' ";
		//  
		//echo $value.'<br>';
		//echo $sql.'<br>';
		$Result1 = mysql_query($sql, $bd) or die(mysql_error());}

}}}




// Agrega materias
for ($v_dia = 1; $v_dia <= 5 ; $v_dia++) { // para cada dia
for ($v_Hora = 1; $v_Hora <= 15 ; $v_Hora++) { // para cada hora del dia
$aux = $v_dia.$v_Hora;
if(isset($_POST[$aux]) and $_POST[$aux]>'0'){
  $insertSQL = sprintf("INSERT INTO Horario ( CodigoCurso, Dia_Semana, No_Bloque, Descripcion) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_GET['CodigoCurso'], "int"),
                       GetSQLValueString($v_dia, "int"),
                       GetSQLValueString($v_Hora, "int"),
                       GetSQLValueString($_POST[$aux], "text"));
  $Result1 = mysql_query($insertSQL, $bd) or die(mysql_error());
    $GoTo = "Horario_adm.php?CodigoCurso=".$_GET['CodigoCurso'];
 // header(sprintf("Location: %s", $GoTo));
} 
}}



// Elimina un bloque
if ((isset($_GET['Codigo_Bloque'])) && ($_GET['Codigo_Bloque'] != "") && (isset($_GET['delete']))) {
  $deleteSQL = sprintf("DELETE FROM Horario WHERE Codigo_Bloque=%s",
                       GetSQLValueString($_GET['Codigo_Bloque'], "int"));

  $Result1 = mysql_query($deleteSQL, $bd) or die(mysql_error());

  $deleteGoTo = "Close.html";
  header(sprintf("Location: %s", $deleteGoTo));
}





// Actualiza Prof Guia
if(isset($_GET['CodigoCurso']) and isset($_GET['Cedula']) and isset($_GET['Guia'])){
  $insertSQL = sprintf("UPDATE Curso SET Cedula_Prof_Guia = %s WHERE CodigoCurso = %s",
                       GetSQLValueString($_GET['Cedula'], "text"),
                       GetSQLValueString($_GET['CodigoCurso'], "int"));

  $Result1 = mysql_query($insertSQL, $bd) or die(mysql_error());
    $GoTo = "Horario_adm.php?CodigoCurso=".$_GET['CodigoCurso'];
  header(sprintf("Location: %s", $GoTo));
} 



$query_RS_Prof = "SELECT * FROM Empleado WHERE (TipoDocente LIKE '%Prof%' OR  TipoDocente LIKE '%Maestra%' ) AND SW_activo='1' ORDER BY Apellidos, Nombres";
$RS_Prof = mysql_query($query_RS_Prof, $bd) or die(mysql_error());
$row_RS_Prof = mysql_fetch_assoc($RS_Prof);
$totalRows_RS_Prof = mysql_num_rows($RS_Prof);

$colname_RS_Curso = "-1";
if (isset($_GET['CodigoCurso'])) {
  $colname_RS_Curso = $_GET['CodigoCurso'];
}

$query_RS_Curso = sprintf("SELECT * FROM Curso WHERE CodigoCurso = %s", GetSQLValueString($colname_RS_Curso, "int"));
$RS_Curso = mysql_query($query_RS_Curso, $bd) or die(mysql_error());
$row_RS_Curso = mysql_fetch_assoc($RS_Curso);
$totalRows_RS_Curso = mysql_num_rows($RS_Curso);

$query_RS_Bloques = "SELECT * FROM HorarioBloques WHERE Grupo = '".$row_RS_Curso['BloqueHorarioGrupo']."' ";
$RS_Bloques = mysql_query($query_RS_Bloques, $bd) or die(mysql_error());
$row_RS_Bloques = mysql_fetch_assoc($RS_Bloques);
$totalRows_RS_Bloques = mysql_num_rows($RS_Bloques);




$query_RS_Cursos = "SELECT * FROM Curso WHERE SW_activo ='1' ORDER BY NivelMencion, Curso, Seccion";
$RS_Cursos = mysql_query($query_RS_Cursos, $bd) or die(mysql_error());
$row_RS_Cursos = mysql_fetch_assoc($RS_Cursos);
$totalRows_RS_Cursos = mysql_num_rows($RS_Cursos);

$colname_RS_Conteo_Horario = "-1";
if (isset($_GET['CodigoCurso'])) {
  $colname_RS_Conteo_Horario = $_GET['CodigoCurso'];
}

$query_RS_Conteo_Horario = sprintf("SELECT * FROM Horario, Materias 
				WHERE Horario.Descripcion=Materias.Codigo_Materia 
				AND CodigoCurso = %s ORDER BY Materias.Materia ASC", GetSQLValueString($colname_RS_Conteo_Horario, "int"));
$RS_Conteo_Horario = mysql_query($query_RS_Conteo_Horario, $bd) or die(mysql_error());
$row_RS_Conteo_Horario = mysql_fetch_assoc($RS_Conteo_Horario);
$totalRows_RS_Conteo_Horario = mysql_num_rows($RS_Conteo_Horario);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Horario <?php echo $row_RS_Curso['NombreCompleto']; ?></title>
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<style type="text/css">
.azul {
	color: #00F;
	font-weight: bold;
}
.verde {
	color: #096;
	font-style: italic;
}
</style>
</head>

<body>




<?php

// Despliega Menu de materias
function Materias($Curso, $Dia, $Bloque, $database_bd, $bd, $CodigoMaterias){
	mysql_select_db($database_bd, $bd);
	$query_RS_Materia = "SELECT * FROM Curso, Materias 
							WHERE Curso.CodigoCurso = '$Curso' 
							AND Curso.CodigoMaterias = Materias.CodigoMaterias 
							ORDER BY Materias.Materia";
	$RS_Materia = mysql_query($query_RS_Materia, $bd) or die(mysql_error());
	$row_RS_Materia = mysql_fetch_assoc($RS_Materia);
	?>
	<select name="<?php echo $Dia.$Bloque; ?>">
		<option value="0">Materia...</option>
		<?php do { 
			extract($row_RS_Materia,1);
			?><option value="<?php echo $row_RS_Materia['Codigo_Materia']; ?>"><?php echo $row_RS_Materia['Materia']; ?></option>
        <?php } while ($row_RS_Materia = mysql_fetch_assoc($RS_Materia)); ?>
	</select>
	<?php 
  } // fin function ?>




<p align="center"><a href="Horario_Adm_Prof.php">Adm Horarios Porf</a>&nbsp; | <a href="Horario_Materias.php">Materias</a><br />
<a href="../../Horario_pdf.php?CodigoCurso=<?php echo $_GET['CodigoCurso']; ?>">Imprimir Curso actual</a> | <a href="../../Horario_pdf.php">Imprimir todos</a> | <a href="PDF/Horario_prof_pdf.php">Imprimir Profesores </a></p>
<table align="center">
  <tr>
    <td colspan="4"><form name="form" id="form">
      
        Curso:
        <select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)">
          <option value="Horario_adm.php" <?php if (!(strcmp("Horario_adm.php", $_GET['CodigoCurso']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
          <?php
do {  
?><option value="Horario_adm.php?CodigoCurso=<?php echo $row_RS_Cursos['CodigoCurso']?>"<?php if (!(strcmp($row_RS_Cursos['CodigoCurso'], $_GET['CodigoCurso']))) {echo "selected=\"selected\"";} ?>><?php echo $row_RS_Cursos['NombreCompleto']?></option>
          <?php
} while ($row_RS_Cursos = mysql_fetch_assoc($RS_Cursos));
  $rows = mysql_num_rows($RS_Cursos);
  if($rows > 0) {
      mysql_data_seek($RS_Cursos, 0);
	  $row_RS_Cursos = mysql_fetch_assoc($RS_Cursos);
  }
?>
        </select>
        
</form></td>
    <td colspan="3" align="right"><form name="form" id="form2">
      Profesor Gu&iacute;a:
          <select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)">
        <option value="Horario_adm.php" <?php if (!(strcmp("Horario_adm.php", $_GET['Cedula']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
        <?php
do {  
?>
        <option value="Horario_adm.php?CodigoCurso=<?php echo $_GET['CodigoCurso'] ?>&amp;Guia=1&amp;Cedula=<?php echo $row_RS_Prof['Cedula']?>"<?php if (!(strcmp($row_RS_Prof['Cedula'], $row_RS_Curso['Cedula_Prof_Guia']))) {echo "selected=\"selected\"";} ?>><?php echo $row_RS_Prof['Apellidos'].' '.$row_RS_Prof['Nombres'] ?></option>
        <?php
} while ($row_RS_Prof = mysql_fetch_assoc($RS_Prof));
  $rows = mysql_num_rows($RS_Prof);
  if($rows > 0) {
      mysql_data_seek($RS_Prof, 0);
	  $row_RS_Prof = mysql_fetch_assoc($RS_Prof);
  }
?>
        </select>
    </form></td>
  </tr>  
</table><form method="post" name="form22" id="form22"  >
<table border="1" align="center">
  
  <tr>
    <td width="150" colspan="2" align="center"><label>
      <input type="submit" name="button" id="button" value="Submit" />
    </label></td>
    <td width="150" align="center" nowrap="nowrap">Lunes</td>
    <td width="150" align="center">Martes</td>
    <td width="150" align="center">Mi&eacute;rcoles</td>
    <td width="150" align="center">Jueves</td>
    <td width="150" align="center"><p>Viernes</p>    </td>
  </tr>
<?php 

// Despliega el bloque
function Bloque($Curso,$Dia,$Bloque,$database_bd, $bd, $Cedula)
{
	mysql_select_db($database_bd, $bd);
	
		$sql="SELECT * FROM Horario, Materias 
				WHERE Horario.Descripcion=Materias.Codigo_Materia  
				AND Horario.CodigoCurso = '$Curso' 
				AND Horario.Dia_Semana = '$Dia' 
				AND Horario.No_Bloque = '$Bloque'";
		//echo $sql;
		$RS_sql = mysql_query($sql, $bd) or die(mysql_error());
		$row_RS_sql = mysql_fetch_assoc($RS_sql);
		$totalRows_RS_sql = mysql_num_rows($RS_sql);
		
		if ($totalRows_RS_sql>0) 
			do{
			
			echo '<span class="azul">'.$row_RS_sql['Materia'].'</span>';
			echo ' <a href="Horario_adm.php?CodigoCurso='.$_GET['CodigoCurso']
					."&delete=1&Codigo_Bloque=".$row_RS_sql['Codigo_Bloque'].'" target="_blank">x</a>';
			$Codigo_Bloque = $row_RS_sql['Codigo_Bloque'];
			$Descripcion = $row_RS_sql['Descripcion'];
			echo"<i>";Profesor($Curso,$Dia,$Bloque,$Codigo_Bloque,$Descripcion,$database_bd, $bd);echo"</i>";	
			$totalRows_RS_sql = $totalRows_RS_sql-1;
			if ($totalRows_RS_sql >0) echo '/<br>';			
					
			} while ($row_RS_sql = mysql_fetch_assoc($RS_sql));

} 

function Profesor($Curso,$Dia,$Bloque,$Codigo_Bloque,$Descripcion,$database_bd, $bd)
{
	mysql_select_db($database_bd, $bd);
	
		$sql="SELECT * FROM Horario, Empleado 
				WHERE Horario.Cedula_Prof=Empleado.Cedula  
				AND Horario.Codigo_Bloque = '$Codigo_Bloque'";
		//echo $sql;
		$RS_sql = mysql_query($sql, $bd) or die(mysql_error());
		$row_RS_sql = mysql_fetch_assoc($RS_sql);
		$totalRows_RS_sql = mysql_num_rows($RS_sql);
		
		if ($totalRows_RS_sql>0) {
			echo '<br>'.'<span class="verde">'.substr($row_RS_sql['Apellidos'], 0, 15).' '.substr($row_RS_sql['Nombres'], 0, 12).'</span>';
			echo " <a href='Horario_adm.php?CodigoCurso=".$Curso
					."&no_prof=1&Codigo_Bloque=".$row_RS_sql['Codigo_Bloque']."' target='_blank' >x</a>";
			$Cedula = $row_RS_sql['Cedula_Prof'];
		}else{
		

$query_RS_Prof = "SELECT * FROM Empleado WHERE (TipoDocente LIKE '%Prof%' OR TipoDocente LIKE '%Doc%' OR  TipoDocente LIKE '%Maestra%' ) AND SW_activo='1'  ORDER BY Apellidos, Nombres";
$RS_Prof = mysql_query($query_RS_Prof, $bd) or die(mysql_error());
$row_RS_Prof = mysql_fetch_assoc($RS_Prof);
?>  <br><?php // echo "P".$Codigo_Bloque ?>
<select name="<?php echo "P".$Codigo_Bloque ?>" >
          <option value="0" >Prof...</option>
          <?php
do {  

//$sql = "SELECT * FROM Horario WHERE Dia_Semana='".$Dia."' AND No_Bloque='".$Bloque."' AND Cedula_Prof='".$row_RS_Prof['Cedula']."'";
//$RS_ = mysql_query($sql, $bd) or die(mysql_error());
//$totalRows_RS_sql = mysql_num_rows($RS_);
if($totalRows_RS_sql==0 or true){

$Cedula = substr('000'.$row_RS_Prof['Cedula'] , -8);
?><option value="Horario_adm.php?CodigoCurso=<?php echo $Curso.'&Codigo_Bloque='.$Codigo_Bloque.'&Cedula='.$Cedula.'&Descripcion='.$Descripcion; ?>"><?php echo substr($row_RS_Prof['Apellidos'], 0, 12).' '.substr($row_RS_Prof['Nombres'], 0, 12) ?></option>
          <?php }
} while ($row_RS_Prof = mysql_fetch_assoc($RS_Prof));
?>
        </select>
  <?php }
} // Fin menu prof bloque


$Curso=$_GET['CodigoCurso'];
$Cedula=$_GET['Cedula'];

?>
  <?php do { ?>
    <tr>
      <td width="20" align="right"><?php echo ++$Bloque; echo')'; ?></td>
      <td align="center"><?php echo $row_RS_Bloques['Descripcion'];?></td>
      
      <td <?php if($row_RS_Bloques['Tipo']=='R' or $row_RS_Bloques['Tipo']=='A') echo ' colspan="5" align="center" bgcolor="#CCCCCC"'; ?>  nowrap="nowrap" valign="top"><?php 
	  
	  if($row_RS_Bloques['Tipo']=='R'){echo "RECESO";}elseif($row_RS_Bloques['Tipo']=='A'){echo "ALMUERZO";}else{


	  
	  $Dia = 1;
	  Bloque($Curso,$Dia,$Bloque,$database_bd, $bd, $Cedula); 
	  echo "<br>";
	  Materias($Curso,$Dia,$Bloque,$database_bd, $bd, $CodigoMaterias);
	  echo "</td>
      <td nowrap='nowrap' valign='top'>";
	
	  $Dia = 2;
	  Bloque($Curso,$Dia,$Bloque,$database_bd, $bd, $Cedula); 
	  echo "<br>";
	  Materias($Curso,$Dia,$Bloque,$database_bd, $bd, $CodigoMaterias);
	  echo "</td>
      <td nowrap='nowrap' valign='top'>";

	  $Dia = 3;
	  Bloque($Curso,$Dia,$Bloque,$database_bd, $bd, $Cedula); 
	  echo "<br>";
	  Materias($Curso,$Dia,$Bloque,$database_bd, $bd, $CodigoMaterias);
	  echo "</td>
      <td nowrap='nowrap' valign='top'>";

	  $Dia = 4;
	  Bloque($Curso,$Dia,$Bloque,$database_bd, $bd, $Cedula); 
	  echo "<br>";
	  Materias($Curso,$Dia,$Bloque,$database_bd, $bd, $CodigoMaterias);
	  echo "</td>
      <td nowrap='nowrap' valign='top'>";

	  $Dia = 5;
	  Bloque($Curso,$Dia,$Bloque,$database_bd, $bd, $Cedula); 
	  echo "<br>";
	  Materias($Curso,$Dia,$Bloque,$database_bd, $bd, $CodigoMaterias);

	  
	  }// recreo o almuerzo
	  ?></td>
    </tr>
    <?php } while ($row_RS_Bloques = mysql_fetch_assoc($RS_Bloques)); ?>
 
</table>
<p>&nbsp;</p>
</form>
<table width="180"  border="1" align="center">
  <tr><td>Materia</td><td nowrap="nowrap">Horas Sem</td>
</tr>
<?php 
$Mat = $row_RS_Conteo_Horario['Materia'];
$ContMat = 0;

do { 
if($Mat!=$row_RS_Conteo_Horario['Materia']){
echo "<tr>
    <td nowrap=nowrap>".$Mat."</td><td nowrap=nowrap width=20>".$ContMat."";
$ContMat = 0;
echo "</td>
  </tr>";
} 

$ContMat += 1;
$Mat = $row_RS_Conteo_Horario['Materia'];

 } while ($row_RS_Conteo_Horario = mysql_fetch_assoc($RS_Conteo_Horario)); ?>
</table>
<p>&nbsp;</p>
<p> |</p>
<p>&nbsp;</p>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>
<?php
mysql_free_result($RS_Bloques);

mysql_free_result($RS_Prof);

mysql_free_result($RS_Cursos);

mysql_free_result($RS_Conteo_Horario);

mysql_free_result($RS_Curso);
?>
