<?php 
if(!isset($_GET['sms']))
	header("Location: ".$php_self."?sms=1");

//$MM_authorizedUsers = "99,91,95,90,secreAcad";
//require_once('inc_login_ck.php'); 
require_once('Connections/bd.php'); 
require_once('intranet/a/archivo/Variables.php'); 
require_once('inc/rutinas.php'); 

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
<link href="estilos2.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="http://www.colegiosanfrancisco.com/img/SFA.png" type="image/png" />
</head>

<body>
<table width="100%" border="0" cellpadding="5">
  <tr class="NombreCampoBIG">
    <td colspan="2" align="center"><?php echo date('d-m-Y') ?></td>
  </tr>
  <tr class="NombreCampoBIG">
    <td width="50%" align="center">Marc&oacute;</td>
    <td width="50%" align="center">Falta por Marcar</td>
  </tr>
  <tr>
    <td valign="top">      <table width="100%" border="0">
<?php 
	$add_EntraHora = "Entra".DiaSemana(date('N'))." < '".date('H:i:s')."'";
	$add_Dia = "SW_".DiaSemana(date('N'))." = '1' ";
	  
	$sql = "SELECT * FROM Empleado_EntradaSalida, Empleado
			WHERE Empleado_EntradaSalida.Codigo_Empleado = Empleado.CodigoEmpleado
			AND Fecha = '".date('Y-m-d')."'
			AND Empleado.$add_Dia 
			AND Empleado.$add_EntraHora < '".date('H:i:s')."'
			GROUP BY Codigo_Empleado
			ORDER BY Apellidos, Nombres";
			//echo $sql.'<br>';
	$RS = $mysqli->query($sql);
	if($RS->num_rows >0)
	while ($row = $RS->fetch_assoc()) {
	?><tr <?php $sw=ListaFondo($sw,$Verde);?>>
          <td><?	
		echo ++$i;
		echo ") ";
	?>&nbsp;</td>
          <td><?	
		echo $row['Apellidos'].' '.$row['Nombres'];
	?>&nbsp;</td>
          <td align="right"><?	
		echo $row['Hora'];
	?></td>
        </tr>
<?	
	}

	  
	  ?>
       
    </table></td>
    <td valign="top"> <table width="100%" border="0"><?php 
	$sw = "";
	
	
	$sql = "SELECT * FROM Empleado
			WHERE $add_EntraHora 
			AND $add_Dia
			AND SW_activo = 1
			AND SW_Asistencia = 1
			ORDER BY SW_Reposo, TipoEmpleado, TipoDocente, Apellidos, Nombres";
			//echo $sql.'<br>';
	$RS = $mysqli->query($sql);
	if($RS->num_rows >0)
	while ($row = $RS->fetch_assoc()) {
		$sqlMarco = "SELECT * FROM Empleado_EntradaSalida
						WHERE Codigo_Empleado = '".$row['CodigoEmpleado']."'
						AND Fecha = '".date('Y-m-d')."'";
		$RS_Marco = $mysqli->query($sqlMarco);
		if($row_Marco = $RS_Marco->fetch_assoc()){}
		else {
			
			$sql = "";
			if($row['SW_Reposo'] == '1' and $row['FechaFinReposo'] >= date('Y-m-d'))
				$Reposo = true;
			else
				$Reposo = false;
				
			?><tr <?php 
			if($Reposo)
				echo "class='ListadoInParAzul'";	
			else  
				$sw=ListaFondo($sw,$Verde);
			?>>
          <td><?	
			echo ++$j;
			echo ") ";
			?>&nbsp;</td>
          <td><?	
			echo $row['Apellidos'].' '.$row['Apellido2'].' '.$row['Nombres'].' '.$row['Nombre2'];
			?>&nbsp;</td>
          <td><?	
			echo $row['TipoEmpleado'].' '.$row['TipoDocente'];
			?>&nbsp;</td>
          <td align="right"><?php 
		  if(!$Reposo and $row['TelefonoCel']>""){
		  ?><iframe src="http://www.colegiosanfrancisco.com/inc/sms.php?sms=1&destino=<?php echo $row['TelefonoCel']; ?>&texto=COL-SFA <?php echo $row['Nombres'] ?> la presente es para recordarle su compromiso de marcar su entrada y salida. Gracias. Si no asistio recuerde el justificativo." width="32" height="32" frameborder="0"></iframe><?php }?>&nbsp;</td>
        </tr>
      <?	
		}
	}
	  ?>
    </table></td>
  </tr>
  <?php if(false){?>
  <tr>
    <td colspan="2" valign="top"><table width="100%%" border="0">
      <tr>
      
<?php 


$sql = "SELECT *  FROM HorarioBloques 
		WHERE Grupo = '2'
		ORDER BY HorarioBloques.No_Bloque ASC";
$RS_Bloques = $mysqli->query($sql);
while ($row_Bloques = $RS_Bloques->fetch_assoc()) {
	
	$Bloque[$row_Bloques['No_Bloque']][Hora_0] = $row_Bloques['Hora_0'];
	$Bloque[$row_Bloques['No_Bloque']][Hora_1] = $row_Bloques['Hora_1'];
	$Bloque[$row_Bloques['No_Bloque']][Tipo] = $row_Bloques['Tipo'];
	$MaxBloque = $row_Bloques['No_Bloque'];
	}
	$sql = "SELECT * FROM Curso 
			WHERE NivelCurso >=31
			AND SW_activo = 1
			ORDER BY Curso, Seccion";
	$RS_Curso = $mysqli->query($sql);
	while ($row_Curso = $RS_Curso->fetch_assoc()) {
		$sql = "SELECT * FROM Horario, Materias
				WHERE Horario.Descripcion = Materias.Codigo_Materia
				AND Horario.CodigoCurso = '".$row_Curso['CodigoCurso']."'
				AND Horario.Dia_Semana = '".date('N')."'
				ORDER BY Horario.No_Bloque";
		$RS_Horario = $mysqli->query($sql);
		while ($row_Horario = $RS_Horario->fetch_assoc()) {
			$Bloque[$row_Horario['No_Bloque']][$row_Curso['CodigoCurso']][Materia] .= $row_Horario['Materia'];
			
		}
	}


// Para cada Curso 
	$sql = "SELECT * FROM Curso 
			WHERE NivelCurso >=31
			AND SW_activo = 1
			ORDER BY Curso, Seccion";
	$RS_Curso = $mysqli->query($sql);
	while ($row_Curso = $RS_Curso->fetch_assoc()) {
	  ?>
        <td valign="top"><table width="100%%" border="0">
          <tr>
            <td align="center" nowrap="nowrap" class="NombreCampoBIG"> <?php echo Curso($row_Curso['CodigoCurso']) ?></td>
          </tr>
<?php // Para cada Curso 
	$sql = "SELECT * FROM Horario, Materias, HorarioBloques
			WHERE Horario.Descripcion = Materias.Codigo_Materia
			AND Horario.No_Bloque = HorarioBloques.No_Bloque
			AND HorarioBloques.Grupo = 2
			AND Horario.CodigoCurso = '".$row_Curso['CodigoCurso']."'
			AND Horario.Dia_Semana = '".date('N')."'
			ORDER BY Horario.No_Bloque";
	$RS_Horario = $mysqli->query($sql);
	while ($row_Horario = $RS_Horario->fetch_assoc()) {
	  ?>
          <tr <?php 
//		  	if("09:00" > $row_Horario['Hora_0'] and "09:00" < $row_Horario['Hora_1']) 
		  	if(date('H:i') > $row_Horario['Hora_0'] 
				and date('H:i') < $row_Horario['Hora_1']) 
		  		$Verde = true; 
			else 
				$Verde = false;
		  $sw=ListaFondo($sw,$Verde);?>>
            <td nowrap="nowrap" <?php 
			$TimeToStart = strtotime($row_Horario['Hora_1']) - strtotime(date('H:i'));
			if($TimeToStart > 0 and $TimeToStart < 1200)
				echo 'class="FondoCampoAmarillo"';
			?>><?php echo $row_Horario['Materia'] ?>
            <?php if($Verde) { ?>
            <span class="ReciboRenglonMini">(<?php echo (strtotime($row_Horario['Hora_1'])-strtotime(date('H:i')))/60 ?>m)<br>
			<?php 
			$sql_Prof = "SELECT * FROM Empleado
						WHERE Cedula = '".$row_Horario['Cedula_Prof']."'";
			$RS_Prof = $mysqli->query($sql_Prof);
			if($row_Prof = $RS_Prof->fetch_assoc())
			echo $row_Prof['Nombres']." ".$row_Prof['Apellidos'];
			 ?></span>
			<?php } ?></td>
          </tr>
      <?php } // FIN Para cada Curso ?>
        </table></td>
      <?php } // FIN Para cada Curso ?>
        
       
      </tr>
    </table></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="2">
    <table width="100%%" border="0" cellpadding="3">
<tr><td align="center" nowrap="nowrap">\</td><?php 

	$sql = "SELECT * FROM Curso 
			WHERE NivelCurso >=31
			AND SW_activo = 1
			ORDER BY Curso, Seccion";
	$RS_Curso = $mysqli->query($sql);
	while ($row_Curso = $RS_Curso->fetch_assoc()) {
		?><td nowrap="nowrap" class="NombreCampoBIG"><?php echo Curso($row_Curso['CodigoCurso']) ?></td><?
	}

?></tr><?



$sql = "SELECT *  FROM HorarioBloques 
		WHERE Grupo = '2'
		ORDER BY HorarioBloques.No_Bloque ASC";
$RS_Bloques = $mysqli->query($sql);
while ($row_Bloques = $RS_Bloques->fetch_assoc()) {
?>
      <tr <?php 
$HoraActual = date('H:i');	  
//$HoraActual = "08:25";	  
	  
if($HoraActual > $row_Bloques['Hora_0'] and $HoraActual < $row_Bloques['Hora_1']) 
	$Verde = true; 
else 
	$Verde = false;

$TimeToStart = strtotime($row_Bloques['Hora_0']) - strtotime($HoraActual);

if($TimeToStart > 0 and $TimeToStart < 1200 and !$Verde)
	echo 'class="FondoCampoAmarillo"';
else
	$sw=ListaFondo($sw,$Verde); 
	
	?>>
        <td align="center" nowrap="nowrap"><?php echo $row_Bloques['Descripcion'];
		
		 if($Verde) { ?><br>
            <span class="ReciboRenglonMini">(<?php echo (strtotime($row_Bloques['Hora_1'])-strtotime($HoraActual))/60 ?>m)</span><?php }?>
		
		 </td>
<?php 
	$sql = "SELECT * FROM Curso 
			WHERE NivelCurso >=31
			AND SW_activo = 1
			ORDER BY Curso, Seccion";
	$RS_Curso = $mysqli->query($sql);
	while ($row_Curso = $RS_Curso->fetch_assoc()) {

		$sql = "SELECT * FROM Horario, Materias, HorarioBloques
				WHERE Horario.Descripcion = Materias.Codigo_Materia
				AND Horario.No_Bloque = HorarioBloques.No_Bloque
				AND HorarioBloques.Grupo = 2
				AND HorarioBloques.No_Bloque = '".$row_Bloques['No_Bloque']."'
				AND Horario.CodigoCurso = '".$row_Curso['CodigoCurso']."'
				AND Horario.Dia_Semana = '".date('N')."'
				ORDER BY Horario.No_Bloque";
		$RS_Horario = $mysqli->query($sql);


?>        
        <td nowrap="nowrap"><?php 
		while ($row_Horario = $RS_Horario->fetch_assoc()) {
			echo $row_Horario['Materia'].'<br>';
			
			
			 if($Verde) { ?><span class="ReciboRenglonMini">
			<?php 
			$sql_Prof = "SELECT * FROM Empleado
						WHERE Cedula = '".$row_Horario['Cedula_Prof']."'";
			$RS_Prof = $mysqli->query($sql_Prof);
			if($row_Prof = $RS_Prof->fetch_assoc())
				echo $row_Prof['Nombres']." ".$row_Prof['Apellidos'];
			 ?></span><br>
			<?php } 
			
			
			
		} 
		 ?></td>
        
        
        
<?php } ?>      

      </tr>
<?php } ?>      
    </table></td></tr>
</table>
</body>
</html>