<?php require_once('../../Connections/bd.php'); ?>
<?php require_once('../../inc/rutinas.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
</head>

<body ><?php 


mysql_select_db($database_bd, $bd);


$RS_Alumnos = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
$totalRows_RS_Alumnos = mysql_num_rows($RS_Alumnos);
echo 'Cantidad de Alumnos = '. $totalRows_RS_Alumnos ;
$ReferenciaMesAno = $_GET['Mes']."-".$_GET['Ano'];

do{ // Para cada Alumno  
		echo '<br><br>'.++$i.') '.$row_RS_Alumnos['Apellidos'].': ';
		$CodigoPropietario = $row_RS_Alumnos['CodigoAlumno']; 
		$SWAgostoFraccionado = $row_RS_Alumnos['SWAgostoFraccionado']; 
		// Busca las asignaciones
		$query_RS_Asign_Alum = "SELECT * FROM AsignacionXAlumno, Asignacion 
								WHERE AsignacionXAlumno.Ano_Escolar = '$AnoEscolar' 
								AND AsignacionXAlumno.CodigoAlumno = '$CodigoPropietario'  
								AND AsignacionXAlumno.CodigoAsignacion = Asignacion.Codigo 
								ORDER BY Asignacion.Orden, AsignacionXAlumno.Codigo";
		$RS_Asign_Alum = mysql_query($query_RS_Asign_Alum, $bd) or die(mysql_error());
		$row_RS_Asign_Alum = mysql_fetch_assoc($RS_Asign_Alum);
		$totalRows_RS_Asign_Alum = mysql_num_rows($RS_Asign_Alum);
		echo "<br><b>query_RS_Asign_Alum: $totalRows_RS_Asign_Alum </b>".$query_RS_Asign_Alum;						
		if ( $totalRows_RS_Asign_Alum > 0 ){ // Si tiene asignaciones
		if (($SWAgostoFraccionado == 1 and $_GET['Mes']!='08') or ($SWAgostoFraccionado != 1 and $_GET['Mes']=='08'))
		do {	  
				$Referencia = $row_RS_Asign_Alum['Codigo'];
				
				$query_RS_Factura = "SELECT * FROM ContableMov 
										WHERE CodigoPropietario = '$CodigoPropietario' 
										AND ReferenciaMesAno = '$ReferenciaMesAno' 
										AND Referencia = '$Referencia'"; 
				$RS_Factura = mysql_query($query_RS_Factura, $bd) or die(mysql_error());
				$row_RS_Factura = mysql_fetch_assoc($RS_Factura);
				$totalRows_RS_Factura = mysql_num_rows($RS_Factura); 
				echo "<br><b>query_RS_Factura: $totalRows_RS_Factura </b>".$query_RS_Factura;
				
				if($totalRows_RS_Factura==0){ // Si la asignacion no existe
				// echo "generar mens ";
				// Agrega una mensualidad de una asignacion
					if($_GET['Mes']=='09') 
						$add_sql = ' AND Asignacion.Num_Cuotas>=12 '; else $add_sql = '';
					$sql = "";
					$sql = "INSERT INTO ContableMov (CodigoPropietario, Fecha, FechaValor, SWValidado, RegistradoPor, Referencia, ReferenciaMesAno, Descripcion, MontoDebe, SWiva) ";
					
					
					$sql.= "( SELECT 
					$CodigoAlumno,
					'".$_GET['Ano'].$_GET['Mes']."01',
					'".$_GET['Ano'].$_GET['Mes']."01',
					1,
					'".$MM_Username."', 
					'$Referencia' ,
					'".$_GET['Mes']."-".$_GET['Ano']."', 
					CONCAT( Asignacion.Descripcion, '')  , 
					(Asignacion.Monto - AsignacionXAlumno.Descuento),  
					Asignacion.SWiva 
					FROM  AsignacionXAlumno, Asignacion 
					WHERE AsignacionXAlumno.Ano_Escolar = '$AnoEscolar' 
					AND AsignacionXAlumno.CodigoAlumno = $CodigoAlumno 
					AND AsignacionXAlumno.CodigoAsignacion = Asignacion.Codigo 
					AND AsignacionXAlumno.CodigoAsignacion = '$Referencia'  
					$add_sql
					ORDER BY Asignacion.Orden, AsignacionXAlumno.Codigo )";   
					echo $sql;
					echo '<br><b>sql: </b>'.$sql;
					echo 'm';
					$RS_sql = mysql_query($sql, $bd) or die(mysql_error());
				
				}else{
					echo "existe mensualidad ";
				}
		} while ($row_RS_Asign_Alum = mysql_fetch_assoc($RS_Asign_Alum)); 	  
			  
				if( $SWAgostoFraccionado == 1  and $_GET['Mes']!='09'){
					  
				$query_RS_Factura = "SELECT * FROM ContableMov WHERE CodigoPropietario = $CodigoPropietario AND ReferenciaMesAno = '$ReferenciaMesAno' AND Referencia = 'FrA'"; 
				echo $query_RS_Factura;
				$RS_Factura = mysql_query($query_RS_Factura, $bd) or die(mysql_error());
				$row_RS_Factura = mysql_fetch_assoc($RS_Factura);
				$totalRows_RS_Factura = mysql_num_rows($RS_Factura);
				
						if($totalRows_RS_Factura==0 ){ // Crear fraccion agosto
							echo ' a';
							$query_RS_AsignacionesXAlumno = "
							SELECT  AsignacionXAlumno.*, Asignacion.* 
							FROM AsignacionXAlumno, Asignacion 
							WHERE AsignacionXAlumno.CodigoAsignacion = Asignacion.Codigo AND Ano_Escolar='$AnoEscolar' AND CodigoAlumno = ".$CodigoPropietario. "";

								//$query_RS_AsignacionesXAlumno = "SELECT * FROM AsignacionXAlumno, Asignacion 
								//									WHERE AsignacionXAlumno.CodigoAsignacion = Asignacion.Codigo 
								//									AND AsignacionXAlumno.CodigoAlumno = ".$CodigoPropietario. " 
								//									AND AsignacionXAlumno.Ano_Escolar='$AnoEscolar'  ";
								echo '<br><b>query_RS_AsignacionesXAlumno: </b>'.$query_RS_AsignacionesXAlumno;									
								$RS_AsignacionesXAlumno = mysql_query($query_RS_AsignacionesXAlumno, $bd) or die(mysql_error());
								$row_RS_AsignacionesXAlumno = mysql_fetch_assoc($RS_AsignacionesXAlumno);
								
								// Calcula el monto de la mansualidad
								$Mensualidad = 0;
								do {
									$Mensualidad += $row_RS_AsignacionesXAlumno['Monto'] - $row_RS_AsignacionesXAlumno['Descuento'];
								}  while ($row_RS_AsignacionesXAlumno = mysql_fetch_assoc($RS_AsignacionesXAlumno)); 
								
								$MontoFraccMensualidad = round ($Mensualidad/10 , 2);
						
				echo "<br>generar agosto ".$MontoFraccMensualidad;
				// Agrega fraccion de AGOSTO
				$sql = "";
				$sql = "INSERT INTO ContableMov (CodigoPropietario, Fecha, FechaIngreso, FechaValor, SWValidado, RegistradoPor, Referencia, ReferenciaMesAno, Descripcion, MontoDebe) ";
				$sql.= "VALUES ($CodigoPropietario, '20".$_GET['Ano']."-".$_GET['Mes']."-01', NOW(), '20".$_GET['Ano']."-".$_GET['Mes']."-01', 1, 'auto', ";
				$sql.= "'FrA' , '".$_GET['Mes']."-".$_GET['Ano']."', CONCAT( 'Fraccion de Agosto', ' ".$_GET['Mes']."-".$_GET['Ano']."')  , $MontoFraccMensualidad )"; 
				echo '<br><b>Agosto: </b>'.$sql;
				echo ' a';
				$RS_sql = mysql_query($sql, $bd) or die(mysql_error());


						} //  if( $SWAgostoFraccionado ==1  and $_GET['Mes']!='09')
				} //  if($totalRows_RS_Factura==0 )	 
				} //if($totalRows_RS_Asign_Alum>0){ 
	
} while  ($row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos)); 
	  
?></body>
</html>