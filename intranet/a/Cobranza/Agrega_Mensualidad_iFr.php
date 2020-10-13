<?php 
$MM_authorizedUsers = "99,91,95,90";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');

header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>

<body><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">&nbsp;
<?php	
 
if(isset($_GET['Ejecutar'])){

//$row_RS_Alumno['SWAgostoFraccionado'];
$_Mes = $_GET['Mes'];
$_Ano = $_GET['Ano'];
$FechaValor = $_GET['Ano'].$_GET['Mes']."01";
mysql_select_db($database_bd, $bd);

if(isset($_GET['CodigoAlumno'])){
	$query_RS_Alumno = "SELECT * FROM Alumno, AlumnoXCurso, Curso 
						WHERE Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno 
						AND AlumnoXCurso.CodigoCurso = Curso.CodigoCurso
						AND AlumnoXCurso.Ano = '$AnoEscolar' 
						AND Alumno.CodigoAlumno = '".$_GET['CodigoAlumno']."'
						ORDER BY  AlumnoXCurso.Ano DESC ";
}

//echo $query_RS_Alumno;

$RS_Alumno = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumno = mysql_fetch_assoc($RS_Alumno);
$totalRows_RS_Alumno = mysql_num_rows($RS_Alumno);

$CodigoAlumno = $row_RS_Alumno['CodigoAlumno'];
	
do{
		
		//$AnoEscolar = "2019-2020";
		
		// Busca las asignaciones del alumno
		$query_RS_Asign_Alum = sprintf("SELECT * FROM AsignacionXAlumno, Asignacion 
						WHERE 
						(AsignacionXAlumno.Ano_Escolar = '2019-2020' or AsignacionXAlumno.Ano_Escolar = '2020-2021' )
						
						AND AsignacionXAlumno.CodigoAlumno = %s 
						AND AsignacionXAlumno.CodigoAsignacion = Asignacion.Codigo 
						ORDER BY Asignacion.Orden, AsignacionXAlumno.Codigo",         
                                                                      GetSQLValueString($CodigoAlumno, "int"));
		$RS_Asign_Alum = mysql_query($query_RS_Asign_Alum, $bd) or die(mysql_error());
		$row_RS_Asign_Alum = mysql_fetch_assoc($RS_Asign_Alum);
		$totalRows_RS_Asign_Alum = mysql_num_rows($RS_Asign_Alum);
		//echo "1 ".$query_RS_Asign_Alum.$totalRows_RS_Asign_Alum."<br>";
		
		
		$MontoMensualidad = 0;
		
		if($totalRows_RS_Asign_Alum > 0)
		do { // para cada asignacion del alumno
		
			$MontoMensualidad += $row_RS_Asign_Alum['Monto'] + $row_RS_Asign_Alum['Monto_Dolares'] - $row_RS_Asign_Alum['Descuento'] - round($row_RS_Asign_Alum['Monto']*$row_RS_Asign_Alum['DescuentoPorciento']/100 , 2);
			
			if($row_RS_Asign_Alum['Orden'] > "02" and $row_RS_Asign_Alum['Orden'] < "10"){
				$MontoMensualidadAgosto += $row_RS_Asign_Alum['Monto'] - $row_RS_Asign_Alum['Descuento'];}
			
			
			//echo $row_RS_Asign_Alum['Descripcion']; 
			//echo $row_RS_Asign_Alum['Monto']; 
			//echo $row_RS_Asign_Alum['Descuento']; 
			$MontoAsignacion = 0;  
			$MontoAsignacion = $row_RS_Asign_Alum['Monto'] + $row_RS_Asign_Alum['Monto_Dolares'] - $row_RS_Asign_Alum['Descuento'] - round($row_RS_Asign_Alum['Monto']*$row_RS_Asign_Alum['DescuentoPorciento']/100 , 2); 
			//echo $MontoAsignacion; 
			
			$ReferenciaMesAno = $_Mes."-".$_Ano;
			
			$Referencia = $row_RS_Asign_Alum['Codigo'];
			
			// Busca si la asignacion del mes existe
			$query_RS_Factura = "SELECT * FROM ContableMov 
								WHERE CodigoPropietario = $CodigoAlumno 
								AND ReferenciaMesAno = '$ReferenciaMesAno' 
								AND Referencia = $Referencia
								AND MontoDebe > 0"; 
								
			$RS_Factura = mysql_query($query_RS_Factura, $bd) or die(mysql_error());
			$row_RS_Factura = mysql_fetch_assoc($RS_Factura);
			$totalRows_RS_Factura = mysql_num_rows($RS_Factura);
			//echo $query_RS_Factura.$totalRows_RS_Factura."<br>";
		
			if($totalRows_RS_Factura == 0){ // si no existe la asignacion entonces se crea
				//echo "generar<br>";
				// Agrega una mensualidad de una asignacion
				if($_Mes=='09') 
					$add_sql = ' AND Asignacion.Num_Cuotas >= 12 '; 
				else 
					$add_sql = '';
					
				$sql = "";
				$sql = "INSERT INTO ContableMov (CodigoPropietario, Fecha, FechaValor, SWValidado, RegistradoPor, Referencia, ReferenciaMesAno, Descripcion, MontoDebe, MontoDebe_Dolares, SWiva) ";
				
				$sql.= "( SELECT 
				$CodigoAlumno,
				'$FechaValor',
				'$FechaValor',
				1,
				'".$MM_Username."', 
				'$Referencia' ,
				'".$_Mes."-".$_Ano."', 
				CONCAT( Asignacion.Descripcion, '')  , 
				
				
				(Asignacion.Monto - (Asignacion.Monto * AsignacionXAlumno.DescuentoPorciento / 100) ),  
				
				$MontoAsignacion,  
				
				
				Asignacion.SWiva 
				
				FROM  AsignacionXAlumno, Asignacion 
				WHERE (AsignacionXAlumno.Ano_Escolar = '2019-2020' or AsignacionXAlumno.Ano_Escolar = '2020-2021' )
				AND AsignacionXAlumno.CodigoAlumno = $CodigoAlumno 
				AND AsignacionXAlumno.CodigoAsignacion = Asignacion.Codigo 
				AND AsignacionXAlumno.CodigoAsignacion = $Referencia  
				$add_sql
				ORDER BY Asignacion.Orden, AsignacionXAlumno.Codigo )";   
				
				
				//echo $sql;
				$RS_sql = mysql_query($sql, $bd) or die(mysql_error());
			}
			
			else{
				//echo "existe";
			}
		
		} while ($row_RS_Asign_Alum = mysql_fetch_assoc($RS_Asign_Alum)); 
		
		
		
	
	
	
} while ($row_RS_Alumno = mysql_fetch_assoc($RS_Alumno));



$Redirect = "Agrega_Mensualidad_iFr.php?CodigoAlumno=". $_GET['CodigoAlumno'] ."&Mes=". $_GET['Mes'] ."&Ano=". $_GET['Ano'];
//header("Location: ".$Redirect);
 ?><img src="../../../i/control_stop.png" width="16" height="16" />
<?php

}
else{
	

?>
<a href="Agrega_Mensualidad_iFr.php?CodigoAlumno=<?php echo $_GET['CodigoAlumno'] ?>&amp;Mes=<?php echo $_GET['Mes'] ?>&amp;Ano=<?php echo $_GET['Ano'] ?>&amp;Ejecutar=1"><img src="../../../i/add.png" width="16" height="16" /></a>

<?php 
}


?></td>
  </tr>
</table></body>
</html>