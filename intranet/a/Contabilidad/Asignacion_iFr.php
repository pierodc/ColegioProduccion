<?php
$MM_authorizedUsers = "99,91,95,90,Contable";
require_once('../../../inc_login_ck.php'); 
require_once('../archivo/Variables.php'); 

require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 



$base_url = "Asignacion_iFr.php?CodigoAsignacion=".$_GET['CodigoAsignacion']."&MesAno=".$_GET['MesAno']."&CodigoAlumno=".$_GET['CodigoAlumno']."&PagoNo=".$_GET['PagoNo'];


if (isset($_GET['CambiaPagoProveedor'])) {
  $query = "UPDATE ContableMov SET PagoPreveedorNo = ".$_GET["CambiaPagoProveedor"]." WHERE Codigo = ".$_GET["Codigo"];
	$Result1 = $mysqli->query($query); 
 // if($Result1) 
  	//	echo $SQL;
	
	header("Location: ".$base_url);

}

//  
if (isset($_GET['PagoProveedorAsistio'])) {
  $SQL = "UPDATE ContableMov SET PagoProveedorAsistio = ".$_GET["PagoProveedorAsistio"]." WHERE Codigo = ".$_GET["Codigo"];
	$Result1 = $mysqli->query($SQL); 
  //if($Result1) 
  	//	echo $SQL;
	header("Location: ".$base_url);
	
}


function iFr_EdoCuentaMes($MesAno, $CodigoAlumno, $bd, $PagoNo, $CodigoAsignacion){
	
	//MesAno=10-15&CodigoAlumno=8265&Pagos=1&CodigoAsignacion=300
	
$base_url = "Asignacion_iFr.php?CodigoAsignacion=$CodigoAsignacion&MesAno=$MesAno&CodigoAlumno=".$_GET['CodigoAlumno']."&PagoNo=".$_GET['PagoNo'];
	
	//if ( $GetPagos == 1 ) {
		$query_ = "SELECT * FROM ContableMov 
					WHERE CodigoPropietario = '$CodigoAlumno' 
					AND Referencia = '$CodigoAsignacion' 
					AND ReferenciaMesAno = '$MesAno'";
		//echo $query_;		
		$RS_ = $bd->query($query_);
		
		if($row_RS_ = $RS_->fetch_assoc()){
			if($row_RS_["SWCancelado"] == '1'){
				
				if($row_RS_["PagoPreveedorNo"] == 0 and $row_RS_["PagoProveedorAsistio"] == "1"){ //Asigna # Pago : Carrito - Link: CambiaPagoProveedor=GET['PagoNo']
					if($_GET['PagoNo']>0 ){
						echo "<a href='$base_url&CambiaPagoProveedor=".$PagoNo;
						echo "&Codigo=".$row_RS_["Codigo"]."'>";
						echo "<img src=\"../../../i/";
						echo "cart_add.png";
						
						echo "\" width=\"32\" height=\"32\" />";
						echo "</a>&nbsp;"; }
				}
					
				elseif($row_RS_["PagoPreveedorNo"] == $PagoNo ){ // Eliminar # Pago : Verde + link: CambiaPagoProveedor=0
					echo "<a href='$base_url&CambiaPagoProveedor=0";
					echo "&Codigo=".$row_RS_["Codigo"]."' >";
					echo "<img src=\"../../../i/script_edit.png\" width=\"32\" height=\"32\" />";
					echo "</a>";
					//if($row_RS_["PagoProveedorAsistio"] == "0")
					//	echo "<img src=\"../../../i/bullet_error.png\" width=\"32\" height=\"32\" />"; 
						}
		
				else{//Proveedor > 0  // Pagado
					echo "<img src=\"../../../i/bullet_green.png\" alt=\"".$row_RS_["PagoPreveedorNo"]."\" width=\"32\" height=\"32\" />";
					echo $row_RS_["PagoPreveedorNo"];
					//if($row_RS_["PagoProveedorAsistio"] == "0")
						//echo "<img src=\"../../../i/bullet_error.png\" width=\"32\" height=\"32\" />"; 
						}
			}
			else { //SWCancelado"] == '0' 
				echo "<img src=\"../../../i/bullet_white.png\" alt=\"\" width=\"32\" height=\"32\"  />"; }	
		}	
	
	
	
	
			
		// Cambia Asistencia
		if($row_RS_["Codigo"]>''){
			echo "<a href='$base_url&PagoProveedorAsistio=";
			if($row_RS_["PagoProveedorAsistio"] == "1")
				echo "0";
			else
				echo "1";	
			echo "&Codigo=".$row_RS_["Codigo"]."' >";
			echo "<img src=\"../../../i/";
				if($row_RS_["PagoProveedorAsistio"]=="1")
					echo "user_green.png";
				else
					echo "user_delete.png";	
					
			echo "\" width=\"24\" height=\"24\" />";
			echo "</a>&nbsp;";
		}
			
		echo '<br>'.$row_RS_["MontoDebe_Dolares"];
		//echo '<br>'.$row_RS_["MontoAbono_Dolares"];
					
}//}


//mysql_select_db($database_bd, $bd);
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);
$bd = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);


if(isset($_POST['PagoNo'])){
	$auxPag = $_SERVER['PHP_SELF']."?CodigoAsignacion=".$_GET['CodigoAsignacion']."&Pagos=1&PagoNo=".$_POST['PagoNo'];
	header("Location: ".$auxPag);
	}
	

$MesAno = $_GET['MesAno'];
$CodigoAlumno = $_GET['CodigoAlumno'];
$CodigoAsignacion = $_GET['CodigoAsignacion'];
$Ano1 = "15";
$Ano2 = "16";
$AnoEscolar = "2015-2016";

$query_RS_Alumnos = "SELECT * FROM ContableMov, Alumno, AlumnoXCurso, Curso
			WHERE ContableMov.CodigoPropietario = Alumno.CodigoAlumno 
			AND Alumno.CodigoAlumno = '$CodigoAlumno'
			AND AlumnoXCurso.Ano = '$AnoEscolar'
			AND ContableMov.Fecha >= '".$Ano1."-09-01' 
			AND ContableMov.Referencia = '$CodigoAsignacion' 
			AND AlumnoXCurso.CodigoCurso = Curso.CodigoCurso 
			GROUP BY Alumno.CodigoAlumno 
			ORDER BY Curso.NivelCurso, Curso.Seccion, Alumno.Apellidos, Alumno.Apellidos2 ";
//echo $query_RS_Alumnos;
$RS_Alumnos = $mysqli->query($query_RS_Alumnos);
$row_RS_Alumnos = $RS_Alumnos->fetch_assoc();

$query_RS_Asignacion = "SELECT * FROM Asignacion WHERE Codigo = '$CodigoAsignacion'";
$RS_Asignacion = $mysqli->query($query_RS_Asignacion);
$row_RS_Asignacion = $RS_Asignacion->fetch_assoc();



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />
<style type="text/css">
a:link {
	color: #6FF;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #0C0;
}
a:hover {
	text-decoration: underline;
	color: #9F3;
}
a:active {
	text-decoration: none;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Lista: <?php echo $row_RS_Asignacion['Descripcion']; ?></title>
</head>
<?php //onLoad="window.print()"?>
<body  >
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#666666">

       
           
        <tr>
    <td align="center" valign="middle" nowrap="nowrap"><?php 
	
	iFr_EdoCuentaMes($MesAno, $CodigoAlumno, $bd, $_GET['PagoNo'], $CodigoAsignacion) ;
	

?></td>
  </tr>
  
</table>
<?php //echo Fnum($auxMonto5); ?>
</body>
</html><?php 
//mysql_free_result($RS_Asignacion);
//mysql_free_result($RS_Alumnos);
?>