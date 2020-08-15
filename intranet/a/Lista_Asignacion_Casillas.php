<?php
$MM_authorizedUsers = "99,91,95,90";
require_once('../../inc_login_ck.php'); 
require_once('archivo/Variables.php'); 

require_once('../../Connections/bd.php'); 
require_once('../../inc/rutinas.php'); 

//mysql_select_db($database_bd, $bd);
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);
$bd = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);


if(isset($_POST['PagoNo'])){
	$auxPag = $_SERVER['PHP_SELF']."?CodigoAsignacion=".$_GET['CodigoAsignacion']."&Pagos=1&PagoNo=".$_POST['PagoNo'];
	header("Location: ".$auxPag);
	}
	
$CodigoAsignacion = "-1";
if (isset($_GET['CodigoAsignacion'])) {
  $CodigoAsignacion = $_GET['CodigoAsignacion'];
}

$Ano1 = "15";
$Ano2 = "16";
$AnoEscolar = "2015-2016";

$query_RS_Alumnos = "SELECT * FROM ContableMov, Alumno, AlumnoXCurso, Curso
			WHERE ContableMov.CodigoPropietario = Alumno.CodigoAlumno 
			AND Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno
			AND AlumnoXCurso.Ano = '$AnoEscolar'
			AND ContableMov.Fecha >= '".$Ano1."-09-01' 
			AND ContableMov.Referencia = '$CodigoAsignacion' 
			AND AlumnoXCurso.CodigoCurso = Curso.CodigoCurso 
			GROUP BY Alumno.CodigoAlumno 
			ORDER BY Curso.NivelCurso, Curso.Seccion, Alumno.Apellidos, Alumno.Apellidos2 ";
//echo $query_RS_Alumnos;
$RS_Alumnos = $mysqli->query($query_RS_Alumnos);


$query_RS_Asignacion = "SELECT * FROM Asignacion WHERE Codigo = '$CodigoAsignacion'";
$RS_Asignacion = $mysqli->query($query_RS_Asignacion);
$row_RS_Asignacion = $RS_Asignacion->fetch_assoc();



function EdoCuentaMes($MesAno, $CodigoAlumno, $bd){
	if ( $_GET["Pagos"]==1 ) {
		$query_ = "SELECT * FROM ContableMov 
				WHERE CodigoPropietario = '$CodigoAlumno' 
				AND Referencia = '".$_GET["CodigoAsignacion"]."' 
				AND ReferenciaMesAno = '$MesAno'";
		//echo $query_;		
		$RS_ = $bd->query($query_);
		
		if($row_RS_ = $RS_->fetch_assoc()){
			if($row_RS_["SWCancelado"] == '1'){
				
				if($row_RS_["PagoPreveedorNo"] == 0 ){ //Asigna # Pago : Carrito - Link: CambiaPagoProveedor=GET['PagoNo']
					if($_GET['PagoNo']>0){
						echo "<a href='Procesa.php?CambiaPagoProveedor=".$_GET['PagoNo'];
						echo "&Codigo=".$row_RS_["Codigo"]."' target='_blanc'>";
						echo "<img src=\"../../i/";
						echo "cart_add.png";
						
						echo "\" width=\"32\" height=\"32\" /> <b>&radic;</b>";
						echo "</a>&nbsp;"; }
				}
					
				elseif($row_RS_["PagoPreveedorNo"] == $_GET['PagoNo']){ // Eliminar # Pago : Verde + link: CambiaPagoProveedor=0
					echo "<a href='Procesa.php?CambiaPagoProveedor=0";
					echo "&Codigo=".$row_RS_["Codigo"]."' target='_blanc'>";
					echo "<img src=\"../../i/script_edit.png\" width=\"32\" height=\"32\" />";
					echo "</a>";
					if($row_RS_["PagoProveedorAsistio"] == "0")
						echo "<img src=\"../../i/bullet_error.png\" width=\"32\" height=\"32\" />"; }
		
				else{//Proveedor > 0  // Pagado
					echo "<img src=\"../../i/bullet_green.png\" alt=\"".$row_RS_["PagoPreveedorNo"]."\" width=\"32\" height=\"32\" />";
					echo $row_RS_["PagoPreveedorNo"];
					if($row_RS_["PagoProveedorAsistio"] == "0")
						echo "<img src=\"../../i/bullet_error.png\" width=\"32\" height=\"32\" />"; }
			}
			else { //SWCancelado"] == '0' 
				echo "<img src=\"../../i/bullet_white.png\" alt=\"\" width=\"32\" height=\"32\"  />"; }	
		}	
	
			
		// Cambia Asistencia
		if($row_RS_["Codigo"]>''){
			echo "<a href='Procesa.php?PagoProveedorAsistio=";
			if($row_RS_["PagoProveedorAsistio"] == "1")
				echo "0";
			else
				echo "1";	
			echo "&Codigo=".$row_RS_["Codigo"]."' target='_blanc'>";
			echo "<img src=\"../../i/";
				if($row_RS_["PagoProveedorAsistio"]=="1")
					echo "bullet_error.png";
				else
					echo "bullet_delete.png";	
			echo "\" width=\"32\" height=\"32\" />";
			echo "</a>&nbsp;";
		}
			
		$Retorna[Monto]  = $row_RS_["MontoDebe"]*$row_RS_["SWCancelado"];
		$Retorna[PagoNo] = $row_RS_["PagoPreveedorNo"];
		$Retorna[SWCancelado] = $row_RS_["SWCancelado"];
		
		return $Retorna; // Devuelve el monto total de la asignacion
}}




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../../estilos2.css" rel="stylesheet" type="text/css" />
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
</style>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Lista: <?php echo $row_RS_Asignacion['Descripcion']; ?></title>
</head>
<?php //onLoad="window.print()"?>
<body  >
<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#666666">
  <tr>
    <td colspan="3"><table width="100%" border="0">
      <tr>
        <td align="center" nowrap><span class="style1"><strong>Colegio<br />
          San Francisco de As&iacute;s</strong><br />
<span class="style3">Los Palos Grandes</span></span></td>
        </tr>
      <tr>
        <td align="left"><form id="form1" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']."?CodigoAsignacion=".$_GET['CodigoAsignacion']."&Pagos=1&PagoNo=".$_POST['PagoNo']; ?>">
          Pago No.
              <label for="PagoNo"></label>
              <input name="PagoNo" type="text" id="PagoNo" value="<?php echo $_GET['PagoNo'] ?>" size="5" />
              <input type="submit" name="button" id="button" value="Ir..." />
        </form></td> 
        </tr>
    </table>    </td>
    <td rowspan="2" align="center" nowrap="nowrap">Desc</td>
    <td rowspan="2" align="center" nowrap="nowrap"><strong><?php echo $row_RS_Asignacion['Descripcion']; ?></strong><br />
(<?php echo date('d-m-Y') ?>)
<?php 
	

	
	?>
</td>
    <td rowspan="2" align="center" nowrap="nowrap"><?php if ($_GET["Pagos"]==1) {echo "Sep ".$Ano1;} ?></td>
    <td rowspan="2" align="center" nowrap="nowrap"><?php if ($_GET["Pagos"]==1) {echo "Oct ".$Ano1;} ?></td>
    <td rowspan="2" align="center" nowrap="nowrap"><?php if ($_GET["Pagos"]==1) {echo "Nov ".$Ano1;} ?></td>
    <td rowspan="2" align="center" nowrap="nowrap"><?php if ($_GET["Pagos"]==1) {echo "Dic ".$Ano1;} ?></td>
    <td rowspan="2" align="center" nowrap="nowrap"><?php if ($_GET["Pagos"]==1) {echo "Ene ".$Ano2;} ?></td>
    <td rowspan="2" align="center" nowrap="nowrap"><?php if ($_GET["Pagos"]==1) {echo "Feb ".$Ano2;} ?></td>
    <td rowspan="2" align="center" nowrap="nowrap"><?php if ($_GET["Pagos"]==1) {echo "Mar ".$Ano2;} ?></td>
    <td rowspan="2" align="center" nowrap="nowrap"><?php if ($_GET["Pagos"]==1) {echo "Abr ".$Ano2;} ?></td>
    <td rowspan="2" align="center" nowrap="nowrap"><?php if ($_GET["Pagos"]==1) {echo "May ".$Ano2;} ?></td>
    <td rowspan="2" align="center" nowrap="nowrap"><?php if ($_GET["Pagos"]==1) {echo "Jun ".$Ano2;} ?></td>
    <td rowspan="2" align="center" nowrap="nowrap"><?php if ($_GET["Pagos"]==1) {echo "Jul ".$Ano2;} ?></td>
  </tr>
  <tr>
    <td width="1">No</td>
    <td width="1" align="center">C&oacute;d</td>
    <td width="1"><strong>Apellidos, </strong>Nombres</td>
  </tr>
        <?php while ($row_RS_Alumnos = $RS_Alumnos->fetch_assoc()) { ?>
        <?php if ($RS_Alumnos) { // Show if recordset not empty ?>
          
        <tr>
    <td nowrap="nowrap"><?php echo ++$i; ?></td>
    <td align="center" nowrap="nowrap"><?php echo $row_RS_Alumnos['CodigoAlumno']; ?></td>
    <td nowrap="nowrap"><b><?php Titulo( $row_RS_Alumnos['Apellidos']. " " .$row_RS_Alumnos['Apellidos2']); ?>,</b> <em><?php Titulo( $row_RS_Alumnos['Nombres']. " " .$row_RS_Alumnos['Nombres2']) ?></em></td>
    <td width="40" nowrap><?php 
	
	$sql = "SELECT * FROM AsignacionXAlumno 
			WHERE CodigoAlumno   = '".$row_RS_Alumnos['CodigoAlumno']."'
			AND CodigoAsignacion = '$CodigoAsignacion'
			AND Ano_Escolar = '$AnoEscolar'";
			// echo $sql;
	//$RS_ = mysql_query($sql, $bd) or die(mysql_error());
	//$row_RS_ = mysql_fetch_assoc($RS_);
	$RS_ = $mysqli->query($sql);
	$row_RS_ = $RS_->fetch_assoc();

	if($row_RS_['Descuento']>0) 
		echo Fnum($row_RS_['Descuento']);
		
	?>&nbsp;</td>
    <td width="40" valign="middle" nowrap><?php echo Curso($row_RS_Alumnos['CodigoCurso']); ?></td>
    <td align="center" valign="middle" nowrap="nowrap"><?php 
	
	$Retorna = EdoCuentaMes("09-".$Ano1, $row_RS_Alumnos['CodigoAlumno'], $bd);
	$auxMonto1 += $Retorna[Monto];
	$PagoMonto[$Retorna[PagoNo]] += $Retorna[Monto];
	$CantidadPagos[$Retorna[PagoNo]] += $Retorna[SWCancelado];

?>&nbsp;</td>
    <td align="center" valign="middle" nowrap="nowrap"><?php 
	$Retorna = EdoCuentaMes("10-".$Ano1, $row_RS_Alumnos['CodigoAlumno'], $bd);
	$auxMonto2 += $Retorna[Monto];
	$PagoMonto[$Retorna[PagoNo]] += $Retorna[Monto];
	$CantidadPagos[$Retorna[PagoNo]] += $Retorna[SWCancelado];

?></td>
    <td align="center" valign="middle" nowrap="nowrap"><?php 
	$Retorna = EdoCuentaMes("11-".$Ano1, $row_RS_Alumnos['CodigoAlumno'], $bd);
	$auxMonto3 += $Retorna[Monto];
	$PagoMonto[$Retorna[PagoNo]] += $Retorna[Monto];
	$CantidadPagos[$Retorna[PagoNo]] += $Retorna[SWCancelado];

?></td>
    <td align="center" valign="middle" nowrap="nowrap"><?php 
	$Retorna = EdoCuentaMes("12-".$Ano1, $row_RS_Alumnos['CodigoAlumno'], $bd);
	$auxMonto4 += $Retorna[Monto];
	$PagoMonto[$Retorna[PagoNo]] += $Retorna[Monto];
	$CantidadPagos[$Retorna[PagoNo]] += $Retorna[SWCancelado];

?></td>
    <td align="center" valign="middle" nowrap="nowrap"><?php 
	$Retorna = EdoCuentaMes("01-".$Ano2, $row_RS_Alumnos['CodigoAlumno'], $bd);
	$auxMonto5 += $Retorna[Monto];
	$PagoMonto[$Retorna[PagoNo]] += $Retorna[Monto];
	$CantidadPagos[$Retorna[PagoNo]] += $Retorna[SWCancelado];

?></td>
    <td align="center" valign="middle" nowrap="nowrap"><?php 
	$Retorna = EdoCuentaMes("02-".$Ano2, $row_RS_Alumnos['CodigoAlumno'], $bd);
	$auxMonto6 += $Retorna[Monto];
	$PagoMonto[$Retorna[PagoNo]] += $Retorna[Monto];
	$CantidadPagos[$Retorna[PagoNo]] += $Retorna[SWCancelado];

?></td>
    <td align="center" valign="middle" nowrap="nowrap"><?php 
	$Retorna = EdoCuentaMes("03-".$Ano2, $row_RS_Alumnos['CodigoAlumno'], $bd);
	$auxMonto7 += $Retorna[Monto];
	$PagoMonto[$Retorna[PagoNo]] += $Retorna[Monto];
	$CantidadPagos[$Retorna[PagoNo]] += $Retorna[SWCancelado];

?></td>
    <td align="center" valign="middle" nowrap="nowrap"><?php 
	$Retorna = EdoCuentaMes("04-".$Ano2, $row_RS_Alumnos['CodigoAlumno'], $bd);
	$auxMonto8 += $Retorna[Monto];
	$PagoMonto[$Retorna[PagoNo]] += $Retorna[Monto];
	$CantidadPagos[$Retorna[PagoNo]] += $Retorna[SWCancelado];

?></td>
    <td align="center" valign="middle" nowrap="nowrap"><?php 
	$Retorna = EdoCuentaMes("05-".$Ano2, $row_RS_Alumnos['CodigoAlumno'], $bd);
	$auxMonto9 += $Retorna[Monto];
	$PagoMonto[$Retorna[PagoNo]] += $Retorna[Monto];
	$CantidadPagos[$Retorna[PagoNo]] += $Retorna[SWCancelado];

?></td>
    <td align="center" valign="middle" nowrap="nowrap"><?php 
	$Retorna = EdoCuentaMes("06-".$Ano2, $row_RS_Alumnos['CodigoAlumno'], $bd);
	$auxMonto10 += $Retorna[Monto];
	$PagoMonto[$Retorna[PagoNo]] += $Retorna[Monto];
	$CantidadPagos[$Retorna[PagoNo]] += $Retorna[SWCancelado];

?></td>
    <td align="center" valign="middle" nowrap="nowrap"><?php 
	$Retorna = EdoCuentaMes("07-".$Ano2, $row_RS_Alumnos['CodigoAlumno'], $bd);
	$auxMonto11 += $Retorna[Monto];
	$PagoMonto[$Retorna[PagoNo]] += $Retorna[Monto];
	$CantidadPagos[$Retorna[PagoNo]] += $Retorna[SWCancelado];

?></td>
  </tr>
        <?php } // Show if recordset not empty ?>
<?php }  ?>
<tr>
              <td nowrap="nowrap">&nbsp;</td>
              <td align="center" nowrap="nowrap">&nbsp;</td>
              <td nowrap="nowrap">&nbsp;</td>
              <td nowrap>&nbsp;</td>
              <td nowrap>&nbsp;</td>
    		  <td align="center" nowrap="nowrap"><?php //echo Fnum($auxMonto1); ?></td>
              <td align="center" nowrap="nowrap"><?php //echo Fnum($auxMonto2); ?></td>
              <td align="center" nowrap="nowrap"><?php //echo Fnum($auxMonto3); ?></td>
              <td align="center" nowrap="nowrap"><?php //echo Fnum($auxMonto4); ?></td>
              <td align="center" nowrap="nowrap"><?php //echo Fnum($auxMonto5); ?></td>
              <td align="center" nowrap="nowrap"><?php //echo Fnum($auxMonto6); ?></td>
              <td align="center" nowrap="nowrap"><?php //echo Fnum($auxMonto7); ?></td>
              <td align="center" nowrap="nowrap"><?php //echo Fnum($auxMonto8); ?></td>
              <td align="center" nowrap="nowrap"><?php //echo Fnum($auxMonto9); ?></td>
              <td align="center" nowrap="nowrap"><?php //echo Fnum($auxMonto10); ?></td>
              <td align="center" nowrap="nowrap"><?php //echo Fnum($auxMonto11); ?></td>
</tr></table>
<p>&nbsp;</p>
<table width="300" border="1" cellpadding="3" cellspacing="0">
  <tr>
    <td colspan="3">Pago Relacionado: <?php echo $_GET['PagoNo']; ?>
</td>
    <td align="center">Monto</td>
  </tr>
  <tr>
    <td colspan="3">Relacionado</td>
    <td align="right"><?php echo Fnum($PagoMonto[$_GET['PagoNo']]); ?></td>
  </tr>
  <tr>
    <td colspan="3"> Sin IVA</td>
    <td align="right"><?php echo Fnum(round($PagoMonto[$_GET['PagoNo']]/1.12 , 2) ); ?></td>
  </tr>
  <tr>
    <td colspan="4">Alumno-Couta del pago:&nbsp;<?php echo $CantidadPagos[$_GET['PagoNo']] ?></td>
  </tr>
  <tr>
    <td align="right">1/3 </td>
    <td align="left">&nbsp;<?php echo Fnum(round($PagoMonto[$_GET['PagoNo']]/1.12/3 , 2) ); ?></td>
    <td align="right">2/3</td>
    <td align="left"><?php echo Fnum(round($PagoMonto[$_GET['PagoNo']]/1.12*2/3 , 2) ); ?></td>
  </tr>
  <tr>
    <td colspan="4" id="celda1" ><a href="#" onmousemove="celda1.bgcolor()='#CCCCCC';">test</a></td>
  </tr>
  <tr>
    <td colspan="3" align="right"> 1/2</td>
    <td align="left"><?php echo Fnum(round($PagoMonto[$_GET['PagoNo']]/1.12/2 , 2) ); ?></td>
  </tr>
</table>
<p>Total Cancelado Sin IVA: &nbsp;
  <?php 

$auxMonto = $auxMonto1+$auxMonto2+$auxMonto3+$auxMonto4+$auxMonto5+$auxMonto6+$auxMonto7+$auxMonto8+$auxMonto9+$auxMonto10+$auxMonto11;
//echo Fnum($auxMonto);
echo " -->> ";
echo Fnum(round($auxMonto/1.12,2));
 ?>
</p>
<p><img src="../../i/bullet_delete.png" width="32" height="32" /></p>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html><?php 
//mysql_free_result($RS_Asignacion);
//mysql_free_result($RS_Alumnos);
?>