<?php 
$MM_authorizedUsers = "2,99,95,90,91";
require_once('../inc_login_ck.php'); 
require_once('a/archivo/Variables.php'); 
require_once('../Connections/bd.php'); 
require_once('../inc/rutinas.php'); 

$colname_RS_Recibo = "-1";
if (isset($_GET['Codigo'])) {
  $colname_RS_Recibo = $_GET['Codigo'];
}
mysql_select_db($database_bd, $bd);
$query_RS_Recibo = sprintf("SELECT * FROM Recibo WHERE CodigoRecibo = %s", GetSQLValueString($colname_RS_Recibo, "int"));
$RS_Recibo = mysql_query($query_RS_Recibo, $bd) or die(mysql_error());
$row_RS_Recibo = mysql_fetch_assoc($RS_Recibo);
$totalRows_RS_Recibo = mysql_num_rows($RS_Recibo);

$colname_RS_Alumno = "-1";
if (isset($_GET['CodigoClave'])) {
  $colname_RS_Alumno = $_GET['CodigoClave'];
}
mysql_select_db($database_bd, $bd);
//$query_RS_Alumno = sprintf("SELECT * FROM Alumno, Curso WHERE Alumno.CodigoCurso=Curso.CodigoCurso AND Alumno.CodigoClave = %s", GetSQLValueString($colname_RS_Alumno, "text")); //echo $query_RS_Alumno;

$query_RS_Alumno = "SELECT * FROM Alumno, AlumnoXCurso  
						WHERE Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno AND
						AlumnoXCurso.Ano = '$AnoEscolar' AND
						AlumnoXCurso.Tipo_Inscripcion = 'Rg' AND
						AlumnoXCurso.Status = 'Inscrito' AND
						Alumno.CodigoClave = '$colname_RS_Alumno' 
					";



$RS_Alumno = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumno = mysql_fetch_assoc($RS_Alumno);
$totalRows_RS_Alumno = mysql_num_rows($RS_Alumno);

$CodigoPropietario = $row_RS_Alumno['CodigoAlumno'];
mysql_select_db($database_bd, $bd);
$query_RS_Mov_Contable_debe = "SELECT * FROM ContableMov WHERE CodigoPropietario = $CodigoPropietario AND MontoDebe > 0 AND CodigoRecibo = ".$_GET['Codigo']." ORDER BY CodigoRecibo ASC, Fecha ASC, Codigo ASC"; //echo $query_RS_Mov_Contable_debe;
$RS_Mov_Contable_debe = mysql_query($query_RS_Mov_Contable_debe, $bd) or die(mysql_error());
$row_RS_Mov_Contable_debe = mysql_fetch_assoc($RS_Mov_Contable_debe);
$totalRows_RS_Mov_Contable_debe = mysql_num_rows($RS_Mov_Contable_debe);

mysql_select_db($database_bd, $bd);
$query_RS_Mov_Contable_haber = "SELECT * FROM ContableMov, ContableCuenta WHERE ContableMov.CodigoCuenta = ContableCuenta.CodigoCuenta AND CodigoPropietario = $CodigoPropietario AND MontoHaber > 0 AND CodigoRecibo = ".$_GET['Codigo'];
$RS_Mov_Contable_haber = mysql_query($query_RS_Mov_Contable_haber, $bd) or die(mysql_error());
$row_RS_Mov_Contable_haber = mysql_fetch_assoc($RS_Mov_Contable_haber);
$totalRows_RS_Mov_Contable_haber = mysql_num_rows($RS_Mov_Contable_haber);


mysql_select_db($database_bd, $bd);
$query_Asignaciones =  "SELECT  AsignacionXAlumno.*, Asignacion.* FROM AsignacionXAlumno, Asignacion WHERE AsignacionXAlumno.CodigoAsignacion = Asignacion.Codigo AND CodigoAlumno = ".$CodigoPropietario. " ORDER BY Orden";
$Asignaciones = mysql_query($query_Asignaciones, $bd) or die(mysql_error());
$row_Asignaciones = mysql_fetch_assoc($Asignaciones);
$totalRows_Asignaciones = mysql_num_rows($Asignaciones);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>RECIBO</title>
<link href="../estilos.css" rel="stylesheet" type="text/css" />
<link href="../estilos2.css" rel="stylesheet" type="text/css" /></head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="window.print()">
<table width="650" height="850" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
  <tr>
    <td colspan="3"><div align="center">
      <table width="100%" border="0">
        <tr>
          <td width="88%" align="center"><span class="Times18">U.E.Colegio</span><br />
              <span class="Times22">San Francisco de As&iacute;s</span></span><br />
              <span class="Times12">Inscrito en el M.E.C.D. - R.I.F.J-00137023-4<br />
              7ma Transv, Los Palos Grandes. Teles. (0212. 283.25.75 / 62.79 / 286.04.37 Fax.284.05.20<br />
              www.ColegioSanFrancisco.com | Email:administracion@ColegioSanFrancisco.com</span></span></td>
          <td width="12%" align="right" valign="top" nowrap="nowrap" class="ReciboDatosPers">Control de Pago  No. <?php echo $_GET[Codigo]; ?><br />
            <br />
            ORIGINAL</span></td>
        </tr>
      </table>
      </div></td>
  </tr>
  <tr>
    <td colspan="3" class="ReciboDatosPers"><table width="100%" border="1" cellpadding="5" cellspacing="0">
      <tr>
        <td colspan="2" align="center" class="ReciboTitulos"  >Representante</td>
        <td align="center" class="ReciboTitulos"  >C.I.</td>
      </tr>
      <tr>
        <td colspan="2" align="left" class="ReciboDatosPers"  ><?php echo $row_RS_Alumno['Fac_Nombre']; ?><br />
<strong>Direcci&oacute;n:</strong> <?php echo $row_RS_Alumno['Fac_Direccion']; ?></td>
        <td align="left" class="ReciboDatosPers"  ><strong>RIF: </strong><?php echo $row_RS_Alumno['Fac_Rif']; ?><br />
          <strong>Tel&eacute;fono:</strong> <?php echo $row_RS_Alumno['Fac_Telefono']; ?></td>
      </tr>
      <tr>
        <td align="center" class="ReciboTitulos"  >Alumno</span></td>
        <td align="center" class="ReciboTitulos"  >C&oacute;digo</span></td>
        <td align="center" class="ReciboTitulos"  >Curso</span></td>
      </tr>
      <tr>
        <td align="center" class="ReciboDatosPers" ><?php echo $row_RS_Alumno['Apellidos']." ".$row_RS_Alumno['Apellidos2'].", ".$row_RS_Alumno['Nombres']." ".$row_RS_Alumno['Nombres2']; ?></td>
        <td align="center" class="ReciboDatosPers" ><?php echo $row_RS_Alumno['CodigoAlumno'] ?></td>
        <td align="center" class="ReciboDatosPers" ><?php echo Curso($row_RS_Alumno['CodigoCurso']) ?></td>
      </tr>
    </table>      
    <div align="right" class="style2"></div></td>
  </tr>
  <tr>
    <td valign="top">
          <table width="100%" border="1" cellpadding="3" cellspacing="0">
            <tr>
              <td class="ReciboTitulos"><strong>Forma de Pago</strong></td>
            </tr>

            <tr>
              <td>
              <table width="100%" border="0">
                    <tr>
                      <td class="ReciboRenglon">Forma</td>
                      <td class="ReciboRenglon">En</td>
                      <td align="center" class="ReciboRenglon">Fecha</td>
                    <td align="right" class="ReciboRenglon">Número</td>
                    <td align="right" class="ReciboRenglon">Monto</td>
                  </tr>
	<?php do { ?><tr>
                    <td class="ReciboRenglon"><?php echo FormaDePago($row_RS_Mov_Contable_haber['Tipo']); ?></td>
                    <td class="ReciboRenglon"><?php echo $row_RS_Mov_Contable_haber['Nombre'] ?></td>
                    <td align="center" class="ReciboRenglon"><?php echo DDMMAAAA($row_RS_Mov_Contable_haber['Fecha']); ?></td>
                    <td align="right" class="ReciboRenglon"><?php echo $row_RS_Mov_Contable_haber['ReferenciaBanco'] ?> <?php echo $row_RS_Mov_Contable_haber['Referencia'] ?></td>
                    <td align="right" class="ReciboRenglon"><?php echo $row_RS_Mov_Contable_haber['MontoHaber'] ?></td>
                  </tr><?php } while ($row_RS_Mov_Contable_haber = mysql_fetch_assoc($RS_Mov_Contable_haber)); ?>
				  <?php mysql_data_seek($RS_Mov_Contable_haber, 0);
	  $row_RS_Mov_Contable_haber = mysql_fetch_assoc($RS_Mov_Contable_haber); ?>
                </table>                </td>
          </tr>
      </table>
          <p align="center" style="font-weight: bold">&nbsp;</p>
          <p align="center" style="font-weight: bold">GRACIAS POR SU PUNTUALIDAD</p></td>
    <td colspan="2" valign="top"><table width="100%" border="1" cellpadding="3" cellspacing="0">
      <tr>
        <td colspan="2" class="ReciboTitulos"><strong>Concepto</strong></td>
        </tr>
        <tr>
          <td colspan="2" class="ReciboRenglon"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <?php 
  $total=0; if($totalRows_RS_Mov_Contable_debe > 10 ){$Mini="Mini";}
  do { ?>
              <tr>
                <td nowrap class="ReciboRenglon<?php echo $Mini ?>"><?php echo $row_RS_Mov_Contable_debe['Descripcion']; ?></td>
                <td nowrap class="ReciboRenglon<?php echo $Mini ?>"><?php echo  Mes_Ano ($row_RS_Mov_Contable_debe['ReferenciaMesAno']);  ?></td>
                <td align="right" nowrap class="ReciboRenglon<?php echo $Mini ?>"><?php 
				
				$auxMonto = $row_RS_Mov_Contable_debe['MontoDebe']- $row_RS_Mov_Contable_debe['MontoAbono'];
				echo Fnum($auxMonto); 
				$total+=$auxMonto; ?></td>
              </tr>
        <?php } while ($row_RS_Mov_Contable_debe = mysql_fetch_assoc($RS_Mov_Contable_debe)); 	?>
        <?php 	  
		mysql_data_seek($RS_Mov_Contable_debe, 0);
	    $row_RS_Mov_Contable_debe = mysql_fetch_assoc($RS_Mov_Contable_debe); ?>
            </table></td>
        </tr>
      <tr>
        <td align="right" class="ReciboDatosPers"><strong class=""><strong>Total Bs.</strong></strong></td>
        <td align="right" class="ReciboDatosPers"><strong><?php echo Fnum($total); ?></strong></td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td colspan="3"><table width="100%" border="1" cellspacing="0" cellpadding="5">
        <tr>
          <td align="center" class="ReciboTitulos"> por</td>
          <td align="center" class="ReciboTitulos">Fecha</td>
          <td align="center" class="ReciboTitulos">Firma</td>
        </tr>
        <tr>
          <td align="center"><?php echo $_COOKIE['MM_Username']; ?></td>
          <td align="center"><?php echo DDMMAAAA($row_RS_Recibo['Fecha']); ?></td>
          <td align="right"><img src="../img/b.gif" width="200" height="1" /></td>
        </tr>
      </table></td>
  </tr>
</table></td>
  </tr>
  <tr>
    <td valign="bottom"><table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
      <tr>
        <td colspan="3"><div align="center">
            <table width="100%" border="0">
              <tr>
                <td width="88%" align="center"><span class="Times18">U.E.Colegio</span><br />
                    <span class="Times22">San Francisco de As&iacute;s</span></span><br />
                    <span class="Times12">Inscrito en el M.E.C.D. - R.I.F.J-00137023-4<br />
                      7ma Transv, Los Palos Grandes. Teles. (0212. 283.25.75 / 62.79 / 286.04.37 Fax.284.05.20<br />
                      www.ColegioSanFrancisco.com | Email:administracion@ColegioSanFrancisco.com</span></span></td>
                <td width="12%" align="right" valign="bottom" nowrap="nowrap" class="ReciboDatosPers">Control de Pago  No. <?php echo $_GET[Codigo]; ?><br />
                    <br />
                  COPIA</span></td>
              </tr>
            </table>
        </div></td>
      </tr>
      <tr>
        <td colspan="3" class="ReciboDatosPers"><table width="100%" border="1" cellpadding="5" cellspacing="0">
            <tr>
              <td align="center" class="ReciboTitulos"  >Alumno</span></td>
              <td align="center" class="ReciboTitulos"  >C&oacute;digo</span></td>
              <td align="center" class="ReciboTitulos"  >Curso</span></td>
            </tr>
            <tr>
              <td align="center" class="ReciboDatosPers" ><?php echo $row_RS_Alumno['Apellidos']." ".$row_RS_Alumno['Apellidos2'].", ".$row_RS_Alumno['Nombres']." ".$row_RS_Alumno['Nombres2']; ?></td>
              <td align="center" class="ReciboDatosPers" ><?php echo $row_RS_Alumno['CodigoAlumno'] ?></td>
              <td align="center" class="ReciboDatosPers" ><?php echo Curso($row_RS_Alumno['CodigoCurso']) ?></td>
            </tr>
          </table>
            <div align="right" class="style2"></div></td>
      </tr>
      <tr>
        <td valign="top"><table width="100%" border="1" cellpadding="3" cellspacing="0">
            <tr>
              <td class="ReciboTitulos"><strong>Forma de Pago</strong></td>
            </tr>
            <tr>
              <td><table width="100%" border="0">
                  <tr>
                    <td class="ReciboRenglon">Forma</td>
                    <td class="ReciboRenglon">En</td>
                    <td align="center" class="ReciboRenglon">Fecha</td>
                    <td align="right" class="ReciboRenglon">N&uacute;mero</td>
                    <td align="right" class="ReciboRenglon">Monto</td>
                  </tr>
                  <?php do { ?>
                <tr>
                    <td class="ReciboRenglon"><?php echo FormaDePago($row_RS_Mov_Contable_haber['Tipo']); ?></td>
                  <td class="ReciboRenglon"><?php echo $row_RS_Mov_Contable_haber['Nombre'] ?></td>
                  <td align="center" class="ReciboRenglon"><?php echo DDMMAAAA($row_RS_Mov_Contable_haber['Fecha']); ?></td>
                  <td align="right" class="ReciboRenglon"><?php echo $row_RS_Mov_Contable_haber['ReferenciaBanco'] ?> <?php echo $row_RS_Mov_Contable_haber['Referencia'] ?></td>
                  <td align="right" class="ReciboRenglon"><?php echo $row_RS_Mov_Contable_haber['MontoHaber'] ?></td>
                </tr>
                <?php } while ($row_RS_Mov_Contable_haber = mysql_fetch_assoc($RS_Mov_Contable_haber)); ?>
                  <?php mysql_data_seek($RS_Mov_Contable_haber, 0);
	  $row_RS_Mov_Contable_haber = mysql_fetch_assoc($RS_Mov_Contable_haber); ?>
              </table></td>
            </tr>
          </table>
            <p align="center" style="font-weight: bold">&nbsp;</p>
          <p align="center" style="font-weight: bold">GRACIAS POR SU PUNTUALIDAD</p></td>
        <td colspan="2" valign="top"><table width="100%" border="1" cellpadding="3" cellspacing="0">
            <tr>
              <td colspan="2" class="ReciboTitulos"><strong>Concepto</strong></td>
            </tr>
            <tr>
              <td colspan="2" class="ReciboRenglon"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <?php 
  $total=0;
  do { ?>
                  <tr>
                    <td nowrap class="ReciboRenglon<?php echo $Mini ?>"><?php echo $row_RS_Mov_Contable_debe['Descripcion']; ?></td>
                    <td nowrap class="ReciboRenglon<?php echo $Mini ?>"><?php echo  Mes_Ano ($row_RS_Mov_Contable_debe['ReferenciaMesAno']);  ?></td>
                    <td align="right" nowrap class="ReciboRenglon<?php echo $Mini ?>"><?php 
				
				$auxMonto = $row_RS_Mov_Contable_debe['MontoDebe']- $row_RS_Mov_Contable_debe['MontoAbono'];
				echo Fnum($auxMonto); 
				$total+=$auxMonto; ?></td>
                  </tr>
                  <?php } while ($row_RS_Mov_Contable_debe = mysql_fetch_assoc($RS_Mov_Contable_debe)); 	?>
                  <?php 	  
		mysql_data_seek($RS_Mov_Contable_debe, 0);
	    $row_RS_Mov_Contable_debe = mysql_fetch_assoc($RS_Mov_Contable_debe); ?>
              </table></td>
            </tr>
            <tr>
              <td align="right" class="ReciboDatosPers"><strong><strong>Total Bs.</strong></strong></td>
              <td align="right" class="ReciboDatosPers"><strong><?php echo Fnum($total); ?></strong></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="3"><table width="100%" border="1" cellspacing="0" cellpadding="5">
            <tr>
              <td align="center" class="ReciboTitulos"> por</td>
              <td align="center" class="ReciboTitulos">Fecha</td>
              <td align="center" class="ReciboTitulos">Firma</td>
            </tr>
            <tr>
              <td align="center"><?php echo $_COOKIE['MM_Username']; ?></td>
              <td align="center"><?php echo DDMMAAAA($row_RS_Recibo['Fecha']); ?></td>
              <td align="right"><img src="../img/b.gif" alt="" width="200" height="1" /></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>

</body>
</html>
<?php
mysql_free_result($RS_Recibo);

mysql_free_result($Asignaciones);

mysql_free_result($RS_Alumno);

mysql_free_result($RS_Mov_Contable_debe);

mysql_free_result($RS_Mov_Contable_haber);
?>
