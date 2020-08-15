<?php 
require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 
require_once('../archivo/Variables.php');

$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0">
  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="5" cellspacing="5">
<?php

$CodigoLeido = $_GET['CodigoLeido'];
if(strlen($CodigoLeido) > 8){
	$CodigoLeido = substr($CodigoLeido,0,strlen($CodigoLeido)-1);
	$CodigoLeido = substr($CodigoLeido,-8)*1;
}

if(isset($_GET['HH']))
	$Timestamp = mktime($_GET['HH'],$_GET['mm']-30,$_GET['ss'],$_GET['MM'],$_GET['DD'],$_GET['YY']);
else
	$Timestamp = date('Y-m-d H:i:s');

$Timestamp += 30*60;
$Fecha = date('Y-m-d',$Timestamp);
$Hora = date('H:i:s',$Timestamp);
$DiaSemana = date('N',$Timestamp);



if($CodigoLeido > 0){


	$sql = "SELECT * FROM Empleado
			WHERE 
			SW_activo = '1' AND
			(
			CodigoBarras = '$CodigoLeido'
			OR Cedula = '$CodigoLeido'
			)";
	//echo "11 ".$sql;		
	$RS = $mysqli->query($sql);
	if($row = $RS->fetch_assoc()){
		
		extract($row);
		//echo '<br>22 '.$Nombres.' '.$Apellidos.' '.$CodigoEmpleado;
		
		$sql = "SELECT * FROM Empleado_EntradaSalida
				WHERE Codigo_Registro_FMP = '".$_GET['Codigo_Registro_FMP']."'";	
		$RS = $mysqli->query($sql);
		//echo '<br>33 '.$sql.$row['Codigo'];
	
		if($row = $RS->fetch_assoc()){
			$sql1 = "UPDATE Empleado_EntradaSalida SET
					Codigo_Empleado = '$CodigoEmpleado',
					Fecha = '$Fecha',
					Hora = '$Hora',
					Obs = 'Asist',
					Registrado_Por = 'Ph'
					WHERE
					Codigo = '".$row['Codigo']."'"; }
		else {			
			$sql1 = "INSERT INTO Empleado_EntradaSalida
					(Codigo_Empleado, Fecha, Hora, Codigo_Registro_FMP, Registrado_Por, DiasSemana, Obs) VALUES
					('$CodigoEmpleado', '$Fecha', '$Hora', '".$_GET['Codigo_Registro_FMP']."', 'Ph', '$DiaSemana', '')
					"; }
	
	
		$row = $mysqli->query($sql1);
		
		//echo '<br>44 '.$sql1.'<br>';



?>
  <tr>
    <td align="center"><img src="../../../FotoEmp/150/<?php echo $CodigoEmpleado ?>.jpg" width="100" height="100" /></td>
  </tr>
  <tr>
    <td align="center" class="RTitulo"><p><?php echo ''.$Nombres.' '.$Apellidos.'<br>';
?>
<br><?php echo date('h:i a',$Timestamp)."<br>".$EntraLun; ?>&nbsp;</p>
      </td>
  </tr>
<?php if(date('H:i') < "12:00") {?>  
  <tr align="center">
    <td class="RTitulo">Buenos D&iacute;as</td>
  </tr>
<?php }else{?>
  <tr align="center">
    <td class="RTitulo">Buenas Tardes</td>
  </tr>
<?php } ?>  
 <?php 
 
 $sql_Horario = "SELECT * FROM Horario, Materias
					WHERE Horario.Descripcion = Materias.Codigo_Materia
					AND Horario.Cedula_Prof = '".$Cedula."'
					AND Horario.Dia_Semana = '".date('N')."'
					ORDER BY Horario.No_Bloque";
$RS_Horario = $mysqli->query($sql_Horario);

if($Cedula > 0 and $RS_Horario->num_rows > 0){

 
 ?> 
  <tr align="center">
    <td class="NombreCampoBIG">Horario</td>
  </tr>
  <tr align="center">
    <td class="BoletaNota">
      <table width="300" border="1" cellpadding="5">
<?php 
while ($row_Horario = $RS_Horario->fetch_assoc()) {
	if($DescripcionAnte != $row_Horario['Descripcion'] or $DescripcionAnte=""){

?>
        <tr>
          <td align="right"><?php 
		echo $row_Horario['Materia'];
?></td>
          <td><?php echo Curso($row_Horario['CodigoCurso']) ?>&nbsp; </td>
        </tr>
<?php 
	}
	$DescripcionAnte = $row_Horario['Descripcion'];
	}


?>        
        
      </table></td>
  </tr>
<?php }} else { ?>
  <tr>
    <td align="center" bgcolor="#CCFF00" class="MensajeDeError">Codigo no existe&nbsp;</td>
  </tr>
<? } ?>

<? } ?></table></td>
    <td valign="top"><table width="100%" border="0" cellpadding="3">
      <tr>
        <td colspan="4" nowrap="nowrap" class="NombreCampo">Faltan por marcar</td>
      </tr>
      <?php 
	$add_EntraHora = "Entra".DiaSemana(date('N'))." < '".date('H:i:s')."'";
	$add_Dia = "SW_".DiaSemana(date('N'))." = '1' ";
	  
	$sql = "SELECT * FROM Empleado
			WHERE $add_EntraHora 
			AND $add_Dia
			AND SW_activo = 1
			AND SW_Asistencia = 1
			ORDER BY SW_Reposo, TipoEmpleado, TipoDocente, Apellidos, Nombres";
			//echo $sql.'<br>';
	$RS = $mysqli->query($sql);
	while ($row = $RS->fetch_assoc()) {
		$sqlMarco = "SELECT * FROM Empleado_EntradaSalida
						WHERE Codigo_Empleado = '".$row['CodigoEmpleado']."'
						AND Fecha = '".date('Y-m-d')."'";
		$RS_Marco = $mysqli->query($sqlMarco);
		if($row_Marco = $RS_Marco->fetch_assoc()){}
		else {
			?>
      <tr <?php 
		if($row['SW_Reposo'] == '0')
			$sw=ListaFondo($sw,$Verde);
		else  
			echo "class='ListadoInParAzul'";	
	  ?>>
        <td><?	
			echo ++$j;
			echo ") ";
			?>
          &nbsp;</td>
        <td><?	
			echo $row['Apellidos'].' '.$row['Nombres'];
			?>
          &nbsp;</td>
        <td><?php echo substr($row['TipoEmpleado'],0,8). ' '.substr($row['TipoDocente'],0,5); ?>&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
      <?	
		}
	}
	  ?>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>