<?    
require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php'); 
require_once('../../../inc/rutinas.php'); 
require_once('../archivo/Variables_Privadas.php');


$Creador = $row_RS_Alumno['Creador'];
$CodigoAlumno = $CodigoAlumno;
?>


<table width="100%" border="0" cellspacing="1" cellpadding="1">
      <tr class="ListadoInPar">
        <td width="100" rowspan="2" align="center"><a href="Estado_de_Cuenta_Alumno.php?CodigoPropietario=<?php echo $_GET['CodigoPropietario']; ?>&Resumen2=<?php echo $_COOKIE['Resumen2']==1?0:1; ?>"><img src="http://<?= $_SERVER['SERVER_NAME'] ?>/i/order32.png" width="32" height="32"  /></a></td>
        <td rowspan="2" valign="top"><?php 
		
$sql = "SELECT * FROM  Alumno, AlumnoXCurso 
		WHERE Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno 
		AND Alumno.Creador = '".$Creador."' 
		AND Alumno.CodigoAlumno <> '".$CodigoAlumno."' 
		AND AlumnoXCurso.Ano = '$AnoEscolar'
		AND AlumnoXCurso.Status = 'Inscrito' 
		AND AlumnoXCurso.Tipo_Inscripcion <> 'Mp'";
	//echo $sql;
$RS_ = $mysqli->query($sql);
$row_ = $RS_->fetch_assoc();
$totalRows_RS_ = $RS_->num_rows;
if ($totalRows_RS_>0){
	echo 'Hnos:<br>';
	do {
		echo '<a href="Estado_de_Cuenta_Alumno.php?CodigoPropietario='.$row_['CodigoClave'].'" target="_blank">'. $row_['CodigoAlumno'].'</a><br>';	
	} while ($row_ = $RS_->fetch_assoc()); 	
}
		?></td>
        <td align="center"><?php  $CodigoPropietario = $CodigoAlumno;
		//$Ano1='12';
		//$Ano2='13';
		?></td>
        <td align="center">Jun <?php echo $Ano1 ?><br />
          <iframe src="Agrega_Mensualidad_iFr.php<?php echo "?CodigoAlumno=".$CodigoAlumno.'&Mes=06&Ano='.$Ano1; ?>" width="30" height="23" seamless frameborder="0" scrolling="no"></iframe>
        </td>
        <td align="center">Jul <?php echo $Ano1 ?><br />
          <iframe src="Agrega_Mensualidad_iFr.php<?php echo "?CodigoAlumno=".$CodigoAlumno.'&Mes=07&Ano='.$Ano1; ?>" width="30" height="23" seamless frameborder="0" scrolling="no"></iframe>
        </td>
        <td align="center">Ago <?php echo $Ano1 ?><br />
          <iframe src="Agrega_Mensualidad_iFr.php<?php echo "?CodigoAlumno=".$CodigoAlumno.'&Mes=08&Ano='.$Ano1; ?>" width="30" height="23" seamless frameborder="0" scrolling="no"></iframe>
         </td>
        <td align="center">Sep <?php echo $Ano1 ?><br />
          ins
          </td>
        <td align="center">Sep <?php echo $Ano1 ?><br />
          <iframe src="Agrega_Mensualidad_iFr.php<?php echo "?CodigoAlumno=".$CodigoAlumno.'&Mes=09&Ano='.$Ano1; ?>" width="30" height="23" seamless frameborder="0" scrolling="no"></iframe>
          </td>
        <td align="center">Oct <?php echo $Ano1 ?><br />
          <iframe src="Agrega_Mensualidad_iFr.php<?php echo "?CodigoAlumno=".$CodigoAlumno.'&Mes=10&Ano='.$Ano1; ?>" width="30" height="23" seamless frameborder="0" scrolling="no"></iframe>
         </td>
        <td align="center">Nov <?php echo $Ano1 ?><br />
          <iframe src="Agrega_Mensualidad_iFr.php<?php echo "?CodigoAlumno=".$CodigoAlumno.'&Mes=11&Ano='.$Ano1; ?>" width="30" height="23" seamless frameborder="0" scrolling="no"></iframe>
        </td>
        <td align="center">Dic <?php echo $Ano1 ?><br />
          <iframe src="Agrega_Mensualidad_iFr.php<?php echo "?CodigoAlumno=".$CodigoAlumno.'&Mes=12&Ano='.$Ano1; ?>" width="30" height="23" seamless frameborder="0" scrolling="no"></iframe>
        </td>
        <td align="center">Ene <?php echo $Ano2 ?><br />
          <iframe src="Agrega_Mensualidad_iFr.php<?php echo "?CodigoAlumno=".$CodigoAlumno.'&Mes=01&Ano='.$Ano2; ?>" width="30" height="23" seamless frameborder="0" scrolling="no"></iframe>
         </td>
        <td align="center">Feb <?php echo $Ano2 ?><br />
          <iframe src="Agrega_Mensualidad_iFr.php<?php echo "?CodigoAlumno=".$CodigoAlumno.'&Mes=02&Ano='.$Ano2; ?>" width="30" height="23" seamless frameborder="0" scrolling="no"></iframe>
         </td>
        <td align="center">Mar <?php echo $Ano2 ?><br />
		  <iframe src="Agrega_Mensualidad_iFr.php<?php echo "?CodigoAlumno=".$CodigoAlumno.'&Mes=03&Ano='.$Ano2; ?>" width="30" height="23" seamless frameborder="0" scrolling="no"></iframe>        
        </td>
        <td align="center">Abr <?php echo $Ano2 ?><br />
          <iframe src="Agrega_Mensualidad_iFr.php<?php echo "?CodigoAlumno=".$CodigoAlumno.'&Mes=04&Ano='.$Ano2; ?>" width="30" height="23" seamless frameborder="0" scrolling="no"></iframe>
         </td>
        <td align="center">May <?php echo $Ano2 ?><br />
          <iframe src="Agrega_Mensualidad_iFr.php<?php echo "?CodigoAlumno=".$CodigoAlumno.'&Mes=05&Ano='.$Ano2; ?>" width="30" height="23" seamless frameborder="0" scrolling="no"></iframe>
        </td>
        <td align="center">Jun <?php echo $Ano2 ?><br />
          <iframe src="Agrega_Mensualidad_iFr.php<?php echo "?CodigoAlumno=".$CodigoAlumno.'&Mes=06&Ano='.$Ano2; ?>" width="30" height="23" seamless frameborder="0" scrolling="no"></iframe>
         </td>
        <td align="center">Jul <?php echo $Ano2 ?><br />
          <iframe src="Agrega_Mensualidad_iFr.php<?php echo "?CodigoAlumno=".$CodigoAlumno.'&Mes=07&Ano='.$Ano2; ?>" width="30" height="23" seamless frameborder="0" scrolling="no"></iframe>
        </td>
        <td align="center">Ago <?php echo $Ano2 ?><br />
          <iframe src="Agrega_Mensualidad_iFr.php<?php echo "?CodigoAlumno=".$CodigoAlumno.'&Mes=08&Ano='.$Ano2; ?>" width="30" height="23" seamless frameborder="0" scrolling="no"></iframe>
          </td>
        <td align="center">Sep <?php echo $Ano2 ?><br />
          <iframe src="Agrega_Mensualidad_iFr.php<?php echo "?CodigoAlumno=".$CodigoAlumno.'&Mes=09&Ano='.$Ano2; ?>" width="30" height="23" seamless frameborder="0" scrolling="no"></iframe>
          </td>
      </tr>
      <tr class="ListadoInPar">
        <td valign="top" class="ReciboRenglonMini"><?php
 $$StopResumen = false;
?></td> 
        <?php $BB = false; ?><?php if( $_COOKIE['Resumen2']==1 ) {	?>
        <td valign="top" class="ReciboRenglonMini"><?php $ReferenciaMesAno = "06-".$Ano1; Resumen2($ReferenciaMesAno, $CodigoPropietario, $database_bd, $bd, $row_RS_Alumno['SWAgostoFraccionado'], $Mensualidad, $BB); ?></td>
        <td valign="top" class="ReciboRenglonMini"><?php $ReferenciaMesAno = "07-".$Ano1; Resumen2($ReferenciaMesAno, $CodigoPropietario, $database_bd, $bd, $row_RS_Alumno['SWAgostoFraccionado'], $Mensualidad, $BB); ?></td>
        <td valign="top" class="ReciboRenglonMini"><?php $ReferenciaMesAno = "08-".$Ano1; Resumen2($ReferenciaMesAno, $CodigoPropietario, $database_bd, $bd, $row_RS_Alumno['SWAgostoFraccionado'], $Mensualidad, $BB); ?></td>
        <td valign="top" class="ReciboRenglonMini"><?php $ReferenciaMesAno = "Ins 18"; Resumen2($ReferenciaMesAno, $CodigoPropietario, $database_bd, $bd, $row_RS_Alumno['SWAgostoFraccionado'], $Mensualidad, $BB); ?></td><td valign="top" class="ReciboRenglonMini"><?php $ReferenciaMesAno = "09-".$Ano1; Resumen2($ReferenciaMesAno, $CodigoPropietario, $database_bd, $bd, $row_RS_Alumno['SWAgostoFraccionado'], $Mensualidad, $BB); ?></td>
        <td valign="top" class="ReciboRenglonMini"><?php $ReferenciaMesAno = "10-".$Ano1; Resumen2($ReferenciaMesAno, $CodigoPropietario, $database_bd, $bd, $row_RS_Alumno['SWAgostoFraccionado'], $Mensualidad, $BB); ?></td>
        <td valign="top" class="ReciboRenglonMini"><?php $ReferenciaMesAno = "11-".$Ano1; Resumen2($ReferenciaMesAno, $CodigoPropietario, $database_bd, $bd, $row_RS_Alumno['SWAgostoFraccionado'], $Mensualidad, $BB); ?></td>
        <td valign="top" class="ReciboRenglonMini"><?php $ReferenciaMesAno = "12-".$Ano1; Resumen2($ReferenciaMesAno, $CodigoPropietario, $database_bd, $bd, $row_RS_Alumno['SWAgostoFraccionado'], $Mensualidad, $BB); ?></td>
        <td valign="top" class="ReciboRenglonMini"><?php $ReferenciaMesAno = "01-".$Ano2; Resumen2($ReferenciaMesAno, $CodigoPropietario, $database_bd, $bd, $row_RS_Alumno['SWAgostoFraccionado'], $Mensualidad, $BB); ?></td>
        <td valign="top" class="ReciboRenglonMini"><?php $ReferenciaMesAno = "02-".$Ano2; Resumen2($ReferenciaMesAno, $CodigoPropietario, $database_bd, $bd, $row_RS_Alumno['SWAgostoFraccionado'], $Mensualidad, $BB); ?></td>
        <td valign="top" class="ReciboRenglonMini"><?php $ReferenciaMesAno = "03-".$Ano2; Resumen2($ReferenciaMesAno, $CodigoPropietario, $database_bd, $bd, $row_RS_Alumno['SWAgostoFraccionado'], $Mensualidad, $BB); ?></td>
        <td valign="top" class="ReciboRenglonMini"><?php $ReferenciaMesAno = "04-".$Ano2; Resumen2($ReferenciaMesAno, $CodigoPropietario, $database_bd, $bd, $row_RS_Alumno['SWAgostoFraccionado'], $Mensualidad, $BB); ?></td>
        <td valign="top" class="ReciboRenglonMini"><?php $ReferenciaMesAno = "05-".$Ano2; Resumen2($ReferenciaMesAno, $CodigoPropietario, $database_bd, $bd, $row_RS_Alumno['SWAgostoFraccionado'], $Mensualidad, $BB); ?></td>
        <td valign="top" class="ReciboRenglonMini"><?php $ReferenciaMesAno = "06-".$Ano2; Resumen2($ReferenciaMesAno, $CodigoPropietario, $database_bd, $bd, $row_RS_Alumno['SWAgostoFraccionado'], $Mensualidad, $BB); ?></td>
        <td valign="top" class="ReciboRenglonMini"><?php $ReferenciaMesAno = "07-".$Ano2; Resumen2($ReferenciaMesAno, $CodigoPropietario, $database_bd, $bd, $row_RS_Alumno['SWAgostoFraccionado'], $Mensualidad, $BB); ?></td>
        <td valign="top" class="ReciboRenglonMini"><?php $ReferenciaMesAno = "08-".$Ano2; Resumen2($ReferenciaMesAno, $CodigoPropietario, $database_bd, $bd, $row_RS_Alumno['SWAgostoFraccionado'], $Mensualidad, $BB); ?></td>
        <td valign="top" class="ReciboRenglonMini"><?php $ReferenciaMesAno = "09-".$Ano2; Resumen2($ReferenciaMesAno, $CodigoPropietario, $database_bd, $bd, $row_RS_Alumno['SWAgostoFraccionado'], $Mensualidad, $BB); echo $ReferenciaMesAno; ?></td><?php } ?>
      </tr>
     
    </table>