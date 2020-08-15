<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 

require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php'); 
require_once('../../../inc/rutinas.php'); 

$CodigoAlumno = $_GET['CodigoAlumno'];

// Eliminar AsignacionXAlumno 
if ((isset($_GET['Codigo'])) && ($_GET['Codigo'] != "") && (isset($_GET['EliminarAsignacion']))) {
	  $query = sprintf("DELETE FROM AsignacionXAlumno WHERE Codigo=%s",
						   GetSQLValueString($_GET['Codigo'], "int"));//echo "delete";
	$Result1 = $mysqli->query($query); 
	  //if($Result1) echo "DELETE Asignacion $_GET[Codigo] ";
	  header("Location: Asignaciones_EdoCuenta.php?CodigoAlumno=".$CodigoAlumno);
}
//echo $query;



// Asignacion por Alumno Agregar
if ((isset($_POST["MM_insert"])) and ($_POST["MM_insert"] == "form2") and $_POST['CodigoAsignacion'] > 0) { //echo"insert 2";
	$insertSQL = sprintf("INSERT INTO AsignacionXAlumno (CodigoAsignacion, CodigoAlumno, Descuento, Ano_Escolar, DescuentoPorciento, CreadoPor) VALUES (%s, %s, %s, %s,%s,%s)",
					   GetSQLValueString($_POST['CodigoAsignacion'], "int"),
					   GetSQLValueString($_POST['CodigoAlumno'], "int"),
					   GetSQLValueString($_POST['Descuento']*1, "double"),
					   GetSQLValueString($_POST['Ano_Escolar'], "text"),
					   GetSQLValueString($_POST['DescuentoPorciento']*1, "double"),
					   GetSQLValueString($MM_Username , "text"));
	$mysqli->query($insertSQL); }
//echo $insertSQL;

// Asignaciones X Alumno
$query_RS_AsignacionesXAlumno = "
		SELECT  AsignacionXAlumno.*, Asignacion.*, AsignacionXAlumno.Codigo as CodAsi 
		FROM AsignacionXAlumno, Asignacion 
		WHERE AsignacionXAlumno.CodigoAsignacion = Asignacion.Codigo 
		AND (AsignacionXAlumno.Ano_Escolar = '$AnoEscolarProx' OR AsignacionXAlumno.Ano_Escolar = '$AnoEscolar' OR AsignacionXAlumno.Ano_Escolar = '$AnoEscolarAnte')
		AND AsignacionXAlumno.CodigoAlumno = '".$CodigoAlumno. "' 
		ORDER BY AsignacionXAlumno.Ano_Escolar DESC, Orden";
echo $Insp ?  $query_RS_AsignacionesXAlumno." (13)<br>" : "";
$RS_AsignacionesXAlumno = $mysqli->query($query_RS_AsignacionesXAlumno);
$totalRows_RS_AsignacionesXAlumno = $RS_AsignacionesXAlumno->num_rows;
//echo $query_RS_AsignacionesXAlumno;


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
<link href="/estilos.css" rel="stylesheet" type="text/css" />
<link href="/css/estilosFinal.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>

<body><form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
  <table width="100%" border="0">
<caption>Asignaciones</caption>
            <tr>
              <td class="TituloLeftWindow">&nbsp;</td>
              <td class="TituloLeftWindow">Nombre</td>
              <td class="TituloLeftWindow"><div align="center">Per&iacute;odo</div></td>
              <td align="center" nowrap="nowrap" class="TituloLeftWindow"><div align="center">A&ntilde;o Escolar</div></td>
              <td align="center" nowrap="nowrap" class="TituloLeftWindow">&nbsp;</td>
              <td class="TituloLeftWindow"><div align="center">Monto</div></td>
              <td colspan="2" class="TituloLeftWindow"><div align="center">Descuento</div></td>
              <td class="TituloLeftWindow"><div align="center">Total</div></td>
            </tr>
            <tr>
              <td align="center" class="FondoCampo"><img src="../../../i/add.png" width="16" height="16" /></td>
              <td class="FondoCampo"><?php 
$query_RS_Asignaciones_Curso = "SELECT * FROM Asignacion 
								WHERE (Periodo = 'M' OR Periodo = 'MF') 
								AND SWActiva = '1' 
								AND (NivelCurso = '00' OR NivelCurso LIKE '%".$NivelCursoActual."%') 
								ORDER BY Orden, Descripcion";
$RS_Asignaciones_Curso = $mysqli->query($query_RS_Asignaciones_Curso);
$row_RS_Asignaciones_Curso = $RS_Asignaciones_Curso->fetch_assoc();
$totalRows_RS_Asignaciones_Curso = $RS_Asignaciones_Curso->num_rows;

?>
                <select name="CodigoAsignacion" id="CodigoAsignacion">
                  <option value="" selected="selected">Seleccione...</option>
                  <?php
					
do {  
?>
                  <option  value="<?php echo $row_RS_Asignaciones_Curso['Codigo']?>" <?
						  if ($row_RS_Asignaciones_Curso['Descripcion'] == "Escolaridad")
							  echo ' selected="selected"';
						  ?> ><?php echo $row_RS_Asignaciones_Curso['Descripcion'] ?> --> <?php echo $row_RS_Asignaciones_Curso['Monto'] ?></option>
                  <?php
} while ($row_RS_Asignaciones_Curso = $RS_Asignaciones_Curso->fetch_assoc());
 
$RS_Asignaciones_Curso = $mysqli->query($query_RS_Asignaciones_Curso);
$row_RS_Asignaciones_Curso = $RS_Asignaciones_Curso->fetch_assoc();
?>
              </select></td>
              <td class="FondoCampo">&nbsp;</td>
              <td align="center" class="FondoCampo"><select name="Ano_Escolar" id="select">
                <option value="<?php echo $AnoEscolar ?>" selected="selected"><?php echo $AnoEscolar ?></option>
                <option value="<?php echo $AnoEscolarProx ?>"><?php echo $AnoEscolarProx ?></option>
              </select></td>
              <td align="center" class="FondoCampo">&nbsp;</td>
              <td class="FondoCampo"><input name="CodigoAlumno" type="hidden" id="CodigoAlumno" value="<?php echo $_GET['CodigoAlumno'] ?>" />
              <input type="hidden" name="MM_insert" value="form2" /></td>
              <td align="right" nowrap="nowrap" class="FondoCampo">
              <input name="Descuento" type="text" id="Descuento" size="8" /></div></td>
              <td align="right" nowrap="nowrap" class="FondoCampo">
              <input name="DescuentoPorciento" type="text" id="DescuentoPorciento" size="8"  />
              &nbsp;% </td>
              <td align="right" class="FondoCampo"><input type="submit" name="button" id="button" value="Agregar" /></td>
    </tr>
			
<?php 

$SumaMensual = 0;

while ($row_RS_AsignacionesXAlumno = $RS_AsignacionesXAlumno->fetch_assoc()) { ?>
            <tr class="<?php if ($AnoEscolarProx != $row_RS_AsignacionesXAlumno['Ano_Escolar']) 
								echo "ListadoPar"; 
							else 
								echo "promo"; ?>">
              <td><div align="center"><a href="Asignaciones_EdoCuenta.php?EliminarAsignacion=1&amp;Codigo=<?php echo $row_RS_AsignacionesXAlumno['CodAsi']; ?>&amp;CodigoAlumno=<?php echo $_GET['CodigoAlumno']; ?>" ><img src="../../../img/b_drop.png" alt="" width="16" height="16" border="0" /></a></div></td>
              <td><?php echo $row_RS_AsignacionesXAlumno['Descripcion']; ?></td>
              <td><div align="center"><?php echo $row_RS_AsignacionesXAlumno['Periodo']; $subtotal = 0; ?></div></td>
              <td align="center"><?php echo $row_RS_AsignacionesXAlumno['Ano_Escolar'];  ?></td>
              <td align="center"><?php echo Fnum($row_RS_AsignacionesXAlumno['Monto_Dolares']); ?></td>
              <td align="right"><?php echo Fnum($row_RS_AsignacionesXAlumno['Monto']); ?></td>
              <td align="right">&nbsp;<?php 
			  
			  echo Fnum($row_RS_AsignacionesXAlumno['Descuento']); 
			 // $subtotal = $row_RS_AsignacionesXAlumno['Monto'] - $row_RS_AsignacionesXAlumno['Descuento'];  
			  
			  $subtotal = $row_RS_AsignacionesXAlumno['Monto'] - $row_RS_AsignacionesXAlumno['Descuento'] - 
				($row_RS_AsignacionesXAlumno['Monto'] * ($row_RS_AsignacionesXAlumno['DescuentoPorciento'] / 100));  
			  
			  if ($AnoEscolar == $row_RS_AsignacionesXAlumno['Ano_Escolar']){
					  $SumaMensualidad += $subtotal;
				  }
			  
			  ?></td>
              <td align="right"><?=  Fnum($row_RS_AsignacionesXAlumno['DescuentoPorciento']); ?></td>
              <td align="right"><?php echo Fnum($subtotal); ?>                <?php //echo Fnum($SumaMensualidad); ?></td>
            </tr>
            <?php 
			$CodigoAlumno = $row_RS_AsignacionesXAlumno['CodigoAlumno'];
}  

$sql = "SELECT * FROM Alumno 
		WHERE CodigoAlumno = '".$CodigoAlumno."'";
$RS_Alumno = $mysqli->query($sql);
$row_RS_Alumno = $RS_Alumno->fetch_assoc();

 if($row_RS_Alumno['SWAgostoFraccionado']) {?>
           <tr>
              <td align="right">&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td colspan="2" align="right">&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td colspan="2" align="right" class="FondoCampo">&nbsp;SubTotal</td>
              <td align="right" class="FondoCampo"><?php echo Fnum($SumaMensualidad); ?></td>
            </tr>
            
            <tr>
              <td align="right">&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td colspan="2" align="right">&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td colspan="2" align="right" class="FondoCampo">&nbsp;Frac </td>
              <td align="right" class="FondoCampo"><?php 
			  $Fraccion = round($SumaMensualidad/10 , 2);
			  echo Fnum($Fraccion); 
			  $SumaMensualidad += $Fraccion;
			  ?></td>
            </tr>
<?php } ?>        
            <tr>
              <td align="right">&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td colspan="2" align="right">&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td colspan="2" align="right" class="FondoCampo"><strong class="BoletaMateria">Total Mensual</strong> <?php echo $AnoEscolarProx; ?></td>
              <td align="right" class="FondoCampo"><?php echo Fnum($SumaMensualidad); ?></td>
            </tr>
            
            
            
</table></form></body>
</html>