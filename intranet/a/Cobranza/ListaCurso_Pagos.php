<?php
$MM_authorizedUsers = "99,91,95,90";
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 



if (isset($_GET['CodigoCurso'])) {
	$CodigoCurso = $_GET['CodigoCurso'];
	$query_RS_Curso = sprintf("SELECT * FROM Curso WHERE 
							   CodigoCurso = %s", $CodigoCurso);
	$resultado = $mysqli->query($query_RS_Curso);
	$resultado->data_seek(0);
	$fila = $resultado->fetch_assoc();
	$NombreCurso = $fila['NombreCompleto'];
	$NivelCurso = $fila['NivelCurso'];
}

$Curso = new Curso($_GET['CodigoCurso'] , $AnoEscolar);
$Curso->Ano = $AnoEscolar;
$Listado = $Curso->ListaCurso();

if($MM_Username == "piero"){
	echo '<pre>';
	//var_dump($Listado);
	echo '</pre>';
}

$RS_Alumnos = $mysqli->query($query_RS_Alumno);

$Ano1 = $AnoA = substr($AnoEscolar , 2 , 2);
$Ano2 = $AnoB = substr($AnoEscolar , 7 , 2);



//$AnoA= $Ano1;
//$AnoB= $Ano2;
//array("07",$AnoA),array("08",$AnoA),
$arrayEncabezado = array(array("Ins",$AnoA),array("09",$AnoA),array("10",$AnoA),array("11",$AnoA),array("12",$AnoA),
						 array("01",$AnoB),array("02",$AnoB),array("03",$AnoB),array("04",$AnoB),array("05",$AnoB),
						 array("06",$AnoB),array("07",$AnoB),array("08",$AnoB));
echo "<pre>";
//var_dump($arrayEncabezado);
echo "</pre>";
//echo $arrayEncabezado[2][1];



?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="/estilos2.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Lista: <?php echo $NombreCurso ?></title>
</head>

<body  onLoad="window.prrint()">
<table width="100%" border="0" cellpadding="2" >
  <tr  <?php ListaFondo($sw,$Verde); ?>>
    <td colspan="9"><table width="100%" border="0">
      <tr>
        <td width="71%" align="left" nowrap><a href="/intranet/a/index.php"><img src="/i/house.png" width="32" height="32" border="0" /></a></td>
        <td width="29%" align="center" nowrap>
<script type="text/javascript">
<!--
function MM_jumpMenu2(targ,selObj,restore){ //v3.0
  eval(targ+".location=\'"+selObj.options[selObj.selectedIndex].value+"\'");
  if (restore) selObj.selectedIndex=0;
}
//-->  
</script>
 <select name="CodigoAsignacion"  onchange="MM_jumpMenu2('parent',this,0)" >
 <option value="">Seleccione...</option>    
 <?php 
 
 $BasePag = $_SERVER['PHP_SELF'] .'?CodigoCurso='.$_GET['CodigoCurso'].
 								 '&CodigoRelacionado='.$_GET['CodigoRelacionado'].
								 "&CodigoAsignacion="; 

$sql = "SELECT * FROM Asignacion WHERE 
		Periodo = 'X' AND
		(NivelCurso LIKE '%$NivelCurso%' OR NivelCurso LIKE '00')
		AND SWActiva = 1";  
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	//extract($row);
    //echo "<br>";

 ?>   
 <option value="<?php echo $BasePag.$row['Codigo']; ?>&CodigoRelacionado=<?= $row['CodigoRelacionado'] ?>" <?php if($_GET['CodigoAsignacion'] == $row['Codigo']) { ?> selected="selected" <?php } ?> ><?php echo $row['Descripcion']." ".Fnum($row['Monto']) ?></option><?php } ?>
        
 </select>       
        </td>
        </tr>
      <tr>
        <td colspan="2"><?php 
   $actual = $_GET['CodigoCurso'];
   if($_GET['CodigoAsignacion'] > 0){
   		$Otros = "CodigoAsignacion=".$_GET['CodigoAsignacion']."&"."CodigoRelacionado=".$_GET['CodigoRelacionado']."&";}
   
   $extraOpcion = $_SERVER['PHP_SELF'] ."?".$Otros."CodigoCurso=";
   Ir_a_Curso($actual,$extraOpcion); ?></td>
        </tr> 
    </table>    </td>
    
    
    <?php foreach($arrayEncabezado as $Encabezado) { ?>
    
     <td rowspan="2" align="center">
     
     <?php echo substr(Mes($Encabezado[0]),0,3); ?><br />
    <a href="../Agrega_Mensualidad.php?CodigoCurso=<?php  echo $_GET['CodigoCurso']  ?>&Mes=<?php echo $Encabezado[0]; ?>&Ano=<?php echo $Encabezado[1]; ?>" target="_blank">
    <img src="/img/Trans_suma.gif" width="34" height="25" border="0" /></a><br />
    <?php if(isset($_GET["CodigoAsignacion"])){ ?>
    <a href="/intranet/a/Cobranza/Agrega_Extraordinario.php?CodigoCurso=<?php  echo $_GET['CodigoCurso']  ?>&Mes=<?php echo $Encabezado[0]; ?>&Ano=<?php echo $Encabezado[1]; ?>&CodigoAsignacion=<?php  echo $_GET['CodigoAsignacion']  ?>" target="_blank">
    <img src="/i/asterisk_yellow.png" alt="" width="16" height="16" border="0" />
    </a>
    <?php } ?>
    </td>
    
   <?php  } ?>
    
    
	
  </tr>
  <tr  <?php ListaFondo($sw,$Verde); ?>>
    <td width="1">No</td>
    <td width="1" align="center">C&oacute;d</td>
    <td><strong>Apellidos, </strong>Nombres<span class="ReciboRenglonMini">
      </span></td>
    <td>
<iframe src="Aviso_de_Cobro_Email.php?porCurso=1&<?php echo "CodigoCurso=".$_GET['CodigoCurso']; ?>" width="40" height="40" scrolling="no" frameborder="0" seamless="seamless"></iframe>

    
    
    <!--a href="<?php  echo "Aviso_de_Cobro_Email.php?CodigoCurso=".$_GET['CodigoCurso'];  ?>&Email=1" target="_blank"><img src="/i/email_go.png" width="32" height="32" border="0" /-->
    
    </a></td>
    <td>&nbsp;</td>
    <td nowrap="nowrap"><a href="<?php  echo "Aviso_de_Cobro_PDF.php".$_GET['CodigoCurso'];  ?>" target="_blank">Aviso PDF</a><br /><br />
    <a href="/intranet/a/Cobranza/Agrega_Fact_Inscripcion.php?CodigoCurso=<?php echo $_GET['CodigoCurso'];  ?>" target="_blank">Fac. Ins. Todos</a></td>
    <td width="-1" nowrap="nowrap">Asig.</td>
    <td width="-1" nowrap="nowrap">&nbsp;</td>
    <td width="0" nowrap="nowrap">Pend.</td>
  </tr>
       
       
       
       
<?php 
	
	
	while($row_RS_Alumnos = $RS_Alumnos->fetch_assoc()) { 
		
		if ($row_RS_Alumnos['CodigoAlumno'] > 0) { // Show if recordset not empty ?>
		
		
  <tr  <?php $sw=ListaFondo($sw,$Verde); ?>>
    <td nowrap="nowrap"><?php echo ++$i; ?></td>
    <td align="center" nowrap="nowrap"><?php echo $row_RS_Alumnos['CodigoAlumno']; ?>
      <?php 

$CodigoPropietario = $row_RS_Alumnos['CodigoAlumno']; 
$SWAgostoFraccionado = $row_RS_Alumnos['SWAgostoFraccionado']; 
	  
	  $CodigoAlumno = $CodigoPropietario;

												  
ActulizaEdoCuentaDolar($CodigoAlumno , $Cambio_Dolar); //
												  
	/*												  
// Calc Cambio del dia	  
$sql_busca_Dolares = "SELECT * FROM ContableMov WHERE CodigoPropietario = $CodigoAlumno
									AND SWCancelado = '0' 
									AND MontoDebe_Dolares > 0";
$RS_busca_Dolares = $mysqli->query($sql_busca_Dolares);
$totalRows_RS_busca_Dolares = $RS_busca_Dolares->num_rows;

if( $totalRows_RS_busca_Dolares > 0 )									
while($row_busca_Dolares = $RS_busca_Dolares->fetch_assoc()){
	$MontoDebe_Dolares = round($row_busca_Dolares['MontoDebe_Dolares'] * $Cambio_Dolar ,2);
	$sql_Upt_Dolares = "UPDATE ContableMov 
						SET MontoDebe = '$MontoDebe_Dolares' 
						WHERE Codigo = '".$row_busca_Dolares['Codigo']."'";
	$mysqli->query($sql_Upt_Dolares);			
	}



	  
  
$query_RS_AsignacionesXAlumno = "SELECT * FROM AsignacionXAlumno, Asignacion WHERE AsignacionXAlumno.CodigoAsignacion = Asignacion.Codigo AND AsignacionXAlumno.CodigoAlumno = ".$row_RS_Alumnos['CodigoAlumno']. " AND AsignacionXAlumno.Ano_Escolar='2010-2011'  ";

$RS_AsignacionesXAlumno = $mysqli->query($query_RS_AsignacionesXAlumno);

												  
												  
// Calcula el monto de la mansualidad
$Mensualidad = 0;
while ($row_RS_AsignacionesXAlumno = $RS_AsignacionesXAlumno->fetch_assoc()) {
	$Mensualidad += $row_RS_AsignacionesXAlumno['Monto'] - $row_RS_AsignacionesXAlumno['Descuento'];
}    
$MontoMensualidad = $Mensualidad; 
  */
												  
												  
	  ?></td>
    <td ><a href="/intranet/a/Cobranza/Estado_de_Cuenta_Alumno.php?CodigoPropietario=<?php echo $row_RS_Alumnos['CodigoClave']; ?>" target="_blank"><img src="/i/coins_in_hand.png" alt="" width="16" height="16" /><?php echo "<b>". Titulo_Mm( $row_RS_Alumnos['Apellidos']. " " .$row_RS_Alumnos['Apellidos2'].',</b> '.$row_RS_Alumnos['Nombres']. " " .$row_RS_Alumnos['Nombres2']); ?></a> | <a href="/intranet/a/PlanillaImprimirADM.php?CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno']; ?>"><img src="/i/participation_rate.png" alt="" width="16" height="16" /></a><?php 
	
$sql = "SELECT * FROM  Alumno, AlumnoXCurso 
		WHERE Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno 
		AND AlumnoXCurso.Ano = '$AnoEscolar' 
		AND Alumno.Creador = '".$row_RS_Alumnos['Creador']."' 
		AND Alumno.CodigoAlumno <> '".$row_RS_Alumnos['CodigoAlumno']."'";
$RS = $mysqli->query($sql);

	//	AND AlumnoXCurso.Tipo_Inscripcion = 'Rg'

if ($RS){
	echo '<br>Hnos: ';
while ($row_ = $RS->fetch_assoc()) {
	//do {
	echo '<a href="/intranet/a/Cobranza/Estado_de_Cuenta_Alumno.php?CodigoPropietario='.$row_['CodigoClave'].'" target="_blank">'. $row_['CodigoAlumno'].' ('.$row_['PrincipalFamilia'].') / '.'</a> &nbsp;&nbsp;';	
	} //while ($row_ = mysql_fetch_assoc($RS_)); 	
}
	
	?>
    
    </td>
    <td nowrap="nowrap" >
      <iframe src="Aviso_de_Cobro_Email.php?porAlumno=1&<?php echo "CodigoAlumno=".$row_RS_Alumnos['CodigoAlumno']; ?>" width="40" height="40" scrolling="no" frameborder="0" seamless="seamless"></iframe>
    </td>
    <td align="center" nowrap="nowrap" ><iframe src="/intranet/a/sms_caja.php?SoloBot=1&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno']; ?>" width="40" height="40" frameborder="0"></iframe></td>
    <td valign="top" nowrap="nowrap" class="ReciboRenglonMini">
    <?php 
	 $_sql = "SELECT * FROM ContableMov WHERE CodigoPropietario = ".$row_RS_Alumnos['CodigoAlumno']." AND ReferenciaMesAno = 'Ins ".$Ano1."' AND Descripcion = 'Matrícula' ";
	 //  echo $_sql;
	 
$_RS = $mysqli->query($_sql); //
$_row_RS = $_RS->fetch_assoc();
$_totalRows = $_RS->num_rows;
	/* 
$_RS = mysql_query($_sql, $bd) or die(mysql_error());
$_row_RS = mysql_fetch_assoc($_RS);
$_totalRows = mysql_num_rows($_RS);*/
if($_totalRows==0){
	?>
    <a href="Agrega_Fact_Inscripcion.php?CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>" target="_blank">Fac.Ins.</a> <?php } ?><?php echo $row_RS_Alumnos['PrincipalFamilia'] ?><br />
    
    <?php 	 
	
	
$_sql = "SELECT * FROM ContableMov 
		 WHERE CodigoPropietario = ".$row_RS_Alumnos['CodigoAlumno']." 
		 AND FechaIngreso > '20".$Ano1."-08-01' 
		 AND (Descripcion LIKE 'Libro%' 
		   OR Descripcion LIKE 'Ins%' 
		   OR Descripcion LIKE 'Agenda%' 
		   OR Descripcion LIKE 'Sociedad%' 
		   OR Descripcion LIKE 'Cuaderno%') ";
//echo $_sql."<br>";
$_RS = $mysqli->query($_sql); //
$_row_RS = $_RS->fetch_assoc();
$_totalRows = $_RS->num_rows;
	/*
$_RS = mysql_query($_sql, $bd) or die(mysql_error());
$_row_RS = mysql_fetch_assoc($_RS);
$_totalRows = mysql_num_rows($_RS); */
if($_totalRows>0){
	do{	
		$desc = substr($_row_RS['Descripcion'],0,5);
		if($desc=='Ins. ' or $desc=='Ins.D')
			echo '<span class="azul">';
		echo substr($_row_RS['Descripcion'],0,8). ' ' .$_row_RS['MontoDebe'].'<br>';
		if($desc=='Ins. ' or $desc=='Ins.D')
			echo '</span>';
	
	} while ($_row_RS = $_RS->fetch_assoc());}




?></td>
    <td valign="top" nowrap="nowrap" class="ReciboRenglonMini"><?php 	 
	
$query_RS_AsignacionesXAlumno = "
		SELECT  AsignacionXAlumno.*, Asignacion.*, AsignacionXAlumno.Codigo as CodAsi 
		FROM AsignacionXAlumno, Asignacion 
		WHERE AsignacionXAlumno.CodigoAsignacion = Asignacion.Codigo 
		AND Ano_Escolar = '$AnoEscolar' 
		AND CodigoAlumno = ".$row_RS_Alumnos['CodigoAlumno']. " 
		ORDER BY Ano_Escolar, Orden";
/*
$RS_AsignacionesXAlumno = mysql_query($query_RS_AsignacionesXAlumno, $bd) or die(mysql_error());
$row_RS_AsignacionesXAlumno = mysql_fetch_assoc($RS_AsignacionesXAlumno);
$totalRows_RS_AsignacionesXAlumno = mysql_num_rows($RS_AsignacionesXAlumno);
*/
$RS_AsignacionesXAlumno = $mysqli->query($query_RS_AsignacionesXAlumno);



if($RS_AsignacionesXAlumno){
	while ($row_RS_AsignacionesXAlumno = $RS_AsignacionesXAlumno->fetch_assoc()) {

	//do{
	if($row_RS_AsignacionesXAlumno['Num_Cuotas']<12){
	echo '<span class="azul">';
	
	if($row_RS_AsignacionesXAlumno['Descripcion']=='Fútbol Primaria') 	
			$MontoIns = 130;
	elseif($row_RS_AsignacionesXAlumno['Descripcion']=='Fútbol Bachillerato')
			$MontoIns = 130;
	elseif($row_RS_AsignacionesXAlumno['Descripcion']=='Natación')
		 	$MontoIns = 150;
	else  
			$MontoIns = 90;
	
	echo '<a href="Agrega_Ins_Act.php?CodigoAsignacion=insA&Descripcion='.$row_RS_AsignacionesXAlumno['Descripcion'].'&MontoDebe='.$MontoIns.'&CodigoAlumno='.$CodigoPropietario.'" target="_blank">';
	}
	
	
		if($row_RS_AsignacionesXAlumno['Descripcion']=='Escolaridad')
			echo 'E/';
			elseif($row_RS_AsignacionesXAlumno['Descripcion']=='Actividades Extracurriculares')
				echo 'A<br>';
				else 
					echo substr($row_RS_AsignacionesXAlumno['Descripcion'],0,5).'<br>';
					
	if($row_RS_AsignacionesXAlumno['Num_Cuotas']<12){
	echo '</a>';
	echo '</span>';	
	}
	} //while ($row_RS_AsignacionesXAlumno = mysql_fetch_assoc($RS_AsignacionesXAlumno));
	}




?></td>
    <td valign="top" nowrap="nowrap" class="ReciboRenglonMini"><?= $row_RS_Alumnos['Descuentos'] ?>&nbsp;</td>
    <td align="right" valign="top" nowrap="nowrap"  class="ReciboRenglonMini">
      <?php
			  
// Calculo de deuda pendiente			  
$colname_RS_ContableMov = $row_RS_Alumnos['CodigoAlumno'];
$query_RS_ContableMov = sprintf("SELECT * FROM ContableMov, Alumno WHERE Alumno.CodigoAlumno = %s and Alumno.CodigoAlumno=ContableMov.CodigoPropietario AND SWCancelado = '0' ORDER BY MontoHaber DESC, ContableMov.Fecha ASC, Codigo ASC", GetSQLValueString($colname_RS_ContableMov, "text"));


$RS_ContableMov = $mysqli->query($query_RS_ContableMov);
/*
$RS_ContableMov = mysql_query($query_RS_ContableMov, $bd) or die(mysql_error());
$row_RS_ContableMov = mysql_fetch_assoc($RS_ContableMov);
$totalRows_RS_ContableMov = mysql_num_rows($RS_ContableMov);
*/
		  
			  $Saldo = 0;
			  while ($row_RS_ContableMov = $RS_ContableMov->fetch_assoc()) {
//do {
			  $Saldo += $row_RS_ContableMov['MontoDebe']-$row_RS_ContableMov['MontoAbono'];
			  } //while ($row_RS_ContableMov = mysql_fetch_assoc($RS_ContableMov));			
			  echo Fnum($Saldo);

// Actualiza Deuda_Actual en alumno			  
$sql = 'UPDATE Alumno SET Deuda_Actual='.$Saldo.' WHERE CodigoAlumno = '.$row_RS_Alumnos['CodigoAlumno'];			
$mysqli->query($sql);

//$RS_sql = mysql_query($sql, $bd) or die(mysql_error());
			  
$MontoDeuda[0] += $Saldo;			  
			  $$StopResumen = false;
			  
			  
			  
			  $BB = false;
			  
			  
			   ?></td>
<?

//$Referencias_MesAno = array("07-".$Ano1, "08-".$Ano1, "09-".$Ano1, "10-".$Ano1, "11-".$Ano1, "12-".$Ano1, 
//					"01-".$Ano2, "02-".$Ano2, "03-".$Ano2, "04-".$Ano2, "05-".$Ano2, "06-".$Ano2, "07-".$Ano2, "08-".$Ano2);
$Mensualidad = 0;
foreach ($arrayEncabezado as $ReferenciaMesAno) {
?>	
<td valign="top" nowrap="nowrap">
<?php 

$MontoMes = Resumen2 ($ReferenciaMesAno[0]."-".$ReferenciaMesAno[1], $CodigoPropietario, $database_bd, $bd, $SWAgostoFraccionado, $MontoMensualidad, $BB, true); 
echo $MontoMes;
$Mensualidad++;
//echo '<br>'.$Mensualidad;

if($MontoMes > 1)
	$Morosidad[$Mensualidad] = $Morosidad[$Mensualidad]+1;
$MontoDeuda[$Mensualidad] += (float)$MontoMes;
//}


 if(isset($_GET["CodigoAsignacion"])  ){ //and $MontoMes > 0 ?><br>
    <a href="Agrega_Extraordinario.php?CodigoAlumno=<?= $row_RS_Alumnos['CodigoAlumno']; ?>&amp;CodigoCurso=<?php  echo $_GET['CodigoCurso']  ?>&amp;Mes=<?php echo $ReferenciaMesAno[0]; ?>&amp;Ano=<?php echo $ReferenciaMesAno[1]; ?>&amp;CodigoAsignacion=<?php  echo $_GET['CodigoAsignacion']  ?>" target="_blank">
    <img src="/i/asterisk_yellow.png" alt="" width="16" height="16" border="0" />
    </a>
    <?php } ?></td>	   
<? } ?>	

<td><a href="/intranet/a/Cobranza/Estado_de_Cuenta_Alumno.php?CodigoPropietario=<?php echo $row_RS_Alumnos['CodigoClave']; ?>" target="_blank"><img src="/i/coins_in_hand.png" alt="" width="16" height="16" /></a></td>


  </tr>
        <?php } // Show if recordset not empty 
         } // ($row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos));

if($MM_Username == 'piero'){
?>
<tr>
<td>&nbsp;</td><td>&nbsp;</td><td>Morosidad</td><td colspan="2">&nbsp;</td><td>&nbsp;</td><td colspan="2">&nbsp;</td>
<td align="right" class="FondoCampo" valign="top"><?= Fnum($MontoDeuda[0])?></td>

<? 
//echo $MM_Username;

for ($j = 1; $j <= 14; $j++) {
	echo '<td align="right" class="FondoCampo" valign="top">';
	echo round($Morosidad[$j],0)." <br> "; 
	if($i>0)
	echo round($Morosidad[$j]/$i * 100 , 0) . "%";
	//echo '<br>'.$j;
	echo '<br>'.Fnum($MontoDeuda[$j]);
	//echo $i; 
	echo "</td>";
}

?>

</tr>
<?php } ?>
</table>
<p>&nbsp;</p>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  
</table>
<p>&nbsp;</p>
</body>
</html><?php
?>
