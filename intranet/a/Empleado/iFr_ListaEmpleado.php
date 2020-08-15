<?php 
$MM_authorizedUsers = "99,91,95,90,secreAcad,AsistDireccion,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');

$Variable = new Variable();


$SwListaActiva = $_COOKIE['SwListaActiva'];

// Menu Navegacion
$Region_Pantalla = array('SW_Activo','Sueldo','BonoAlim','Fecha','Fideicomiso','Horario','Cargo','Mensaje','Foto','Cedula','Contacto','Asistencia');

//$Region_Pantalla_iFr = array('SW_Activo','Sueldo','BonoAlim','Fecha','Fideicomiso','Horario','Cargo','Mensaje','Contacto');


if(isset($_GET['SwListaInActiva']) or isset($_GET['SwListaActiva']) ){
	if(isset($_GET['SwListaActiva'])){ // Boton Activar
		$SwListaActiva = $SwListaActiva . ' ' . $_GET['SwListaActiva']; }
	if(isset($_GET['SwListaInActiva'])){ // Boton Desactivar
		$SwListaActiva = str_replace($_GET['SwListaInActiva'],'',$SwListaActiva); }
	header("Location: ".$php_self); } 

if($SwListaActiva == '')
	$SwListaActiva = ' SW_Activo Cargo Foto ';

setcookie("SwListaActiva",$SwListaActiva,time()+86000000);

unset($Dsp);
foreach($Region_Pantalla as $Region){
	if(strpos($SwListaActiva, $Region))	
		$Dsp[$Region] = true; }


// Crea Usuario si no existe 
if(isset($_POST['Cedula'])){
	$sql = "SELECT * FROM Usuario
			WHERE Usuario = '".$_POST['Cedula']."'";
	$RS_Usuario = $mysqli->query($sql);
	if( ! $row_RS_Usuario = $RS_Usuario->fetch_assoc() ){
		$sql = "INSERT INTO Usuario 
				(Usuario, Clave, Privilegios, Email) VALUES
				('".$_POST['Cedula']."', '".$_POST['Cedula']."', 'docente', '".$_POST['Email']."')";
		$mysqli->query($sql);
		}
	else{	
		$sql = "UPDATE Usuario
				SET Email = '".$_POST['Email']."',
					Role = 'Docente'
				WHERE Usuario = '".$_POST['Cedula']."'";
		$RS_Usuario = $mysqli->query($sql);
	}
}



// Guarda Forma
if(isset($_POST['Guardar'])){
	foreach ($_POST as $clave => $valor){
		if($clave != 'Guardar' and $clave != 'CodigoEmpleado' ){
			
			//$Vars .= $clave.',';
			//$Vals .= $_POST[$clave].',';
			
			if(substr($_POST[$clave],0,1) > 0 and substr($_POST[$clave],0,1) <= 9) 
				$ValorAux = coma_punto($_POST[$clave]);
			else
				$ValorAux = $_POST[$clave];
			
			
			
			
			if(substr($clave,0,5) == "Fecha" and $ValorAux == "")
				$ValorAux = '0000-00-00';
				
			$sql_update .= " ".$clave."='".$ValorAux."',";
			}
	}
		
	if(strlen($sql_update) > 10)
		$sql_update = "UPDATE Empleado SET ".$sql_update." WHERE CodigoEmpleado = '".$_POST['CodigoEmpleado']."'";
	$sql_update = str_replace(', WHERE',' WHERE',$sql_update);		

	if(true or Acceso($Acceso_US,"EditaEmpleado")){	
		echo '<pre>';
		//print_r($_POST);
		//echo 'sql_update = '.$sql_update.'<br>';
		echo '</pre>';
		$mysqli->query($sql_update);
		}
}
	

$CodigoEmpleado = $_GET['CodigoEmpleado'];



$query_RS_Empleados = "SELECT * FROM Empleado 
						WHERE CodigoEmpleado = '$CodigoEmpleado'";
//echo $query_RS_Empleados;
$RS_Empleados = $mysqli->query($query_RS_Empleados);
$row_RS_Empleados = $RS_Empleados->fetch_assoc();






// Calcula Sueldo
$Sueldo_Tabla = $Variable->view($row_RS_Empleados[TipoDocente]." SUELDO");
$Sueldo_Minimo = $Variable->view("Sueldo Minimo");
$Bono_Anos_Servicio = $Variable->view("Bono Anos Servicio") * Edad($row_RS_Empleados[FechaIngreso]);

$Horas = $row_RS_Empleados[HrAcad] + $row_RS_Empleados[HrAdmi];

if ($Horas > 0){
	$FactorHoras = $Horas / 40 ;
}
else {
	$FactorHoras = 1;
	}


$Base_Sueldo = round($Sueldo_Tabla * $Sueldo_Minimo * $FactorHoras , 2); 

$Valor_Hora = round($Sueldo_Tabla * $Sueldo_Minimo / 4 / 40 , 2); 

$Sueldo_Calculado_aux = $Base_Sueldo + $Bono_Anos_Servicio;
$Nuevo_Sueldo_Base = round($Sueldo_Calculado_aux / 2 , 2); // Quincenal


$sql_update = "UPDATE Empleado 
				SET SueldoBase = $Nuevo_Sueldo_Base
				WHERE CodigoEmpleado = '$CodigoEmpleado'";
$mysqli->query($sql_update);




$RS_Empleados = $mysqli->query($query_RS_Empleados);
$row_RS_Empleados = $RS_Empleados->fetch_assoc();
while (list($clave, $valor) = each($row_RS_Empleados)) { // Coloca los valores del empleado en $Emp
	$Emp[$i][$clave] = 	$valor;
}





?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">

<title>Administraci&oacute;n SFDA</title>
<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
a:link {
	color: #0000FF;
	text-decoration: none;
}
-->
</style>

<style type="text/css">
<!--
.style1 {
	font-size: 18px;
	font-family: "Times New Roman", Times, serif;
	color: #000066;
}
.style3 {font-size: 12px}
a:visited {
	color: #0000FF;
	text-decoration: none;
}
a:hover {
	color: #CCCC00;
	text-decoration: underline;
}
a:active {
	color: #FF0000;
	text-decoration: none;
}
-->
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form action="" method="post" name="form1" id="form1">
<?php if(!isset($_GET['vertical'])) { ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td>&nbsp;</td>
  <td><table width="100%" border="0" cellpadding="0">

    <?php 
if(TieneAcceso($Acceso_US,"Sueldo"))
	if ($Dsp['SW_Activo']==1) { ?>
    <tr>
      <td width="100%" class="FondoCampo"><?php 
	  
$ClaveCampo = 'CodigoEmpleado';
$ClaveValor = $Emp[$i][CodigoEmpleado];
$Tabla = 'Empleado';

echo "Activo ";
Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,'SW_activo',$Emp[$i][SW_activo]); echo " | ";
echo "Fideicomiso ";
Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,'SW_Antiguedad',$Emp[$i][SW_Antiguedad]); echo " | ";
if( $Emp[$i][NumCuenta] > '' and	$Emp[$i][NumCuentaA] > '' ){
	echo "Fid incorporacion";
	Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,'SW_Antiguedad_Inc',$Emp[$i][SW_Antiguedad_Inc]); echo " | ";}

echo "IVSS ";
Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,'SW_ivss',$Emp[$i][SW_ivss]); echo " | ";
echo "LPH ";
Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,'SW_lph',$Emp[$i][SW_lph]); echo " | ";
echo "SPF ";
Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,'SW_spf',$Emp[$i][SW_spf]);echo " | ";
echo "ISLR ";
Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,'SW_islr',$Emp[$i][SW_islr]);echo " | ";
echo "Reposo ";
Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,'SW_Reposo',$Emp[$i][SW_Reposo]);echo " | ";
echo "Pago Vacaciones ";
Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,'SW_PagoVacac',$Emp[$i][SW_PagoVacac]);echo " | ";
echo "Pago Bono Prd  ";
Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,'SW_PagoBono',$Emp[$i][SW_PagoBono]);echo " | ";
echo "Pago Bono P/Hora  ";
Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,'SW_BonoProfHora',$Emp[$i][SW_BonoProfHora]);
	  
	  
	  
	  
	?>&nbsp;<input name="FechaFinReposo" type="date" id="FechaFinReposo" value="<?php echo $Emp[$i][FechaFinReposo]; ?>" size="4" />

        </td>
      </tr>
    <?php } 


if(TieneAcceso($Acceso_US,"Sueldo"))
if ($Dsp['Cargo']==1) { ?>
    <tr>
      <td width="100%" class="FondoCampo">Cargo: Tipo Emp:
        <select name="TipoEmpleado" id="TipoEmpleado">
          <option value="">Seleccione...</option>
          <?php 
// Ejecuta $sql
$sql = "SELECT * FROM Empleado
		WHERE SW_activo = '1'
		GROUP BY TipoEmpleado
		ORDER BY TipoEmpleado";

// Ejecuta $sql y While
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	extract($row);
	echo '<option value="'.$TipoEmpleado.'"';
	if($Emp[$i][TipoEmpleado] == $TipoEmpleado)
		echo ' selected="selected"';
	echo '>'.$TipoEmpleado.'</option>'."\r\n";
}
?>                        
          </select>
        
        
        Tipo Doc: 
        <select name="TipoDocente" id="TipoDocente">
          <option value="">Seleccione...</option>
          <?php 
// Ejecuta $sql
$sql = "SELECT * FROM Empleado
		WHERE SW_activo = '1'
		AND TipoEmpleado = '".$Emp[$i][TipoEmpleado]."'
		GROUP BY TipoDocente
		ORDER BY TipoDocente";

// Ejecuta $sql y While
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	extract($row);
	echo '<option value="'.$TipoDocente.'"';
	if($Emp[$i][TipoDocente] == $TipoDocente)
		echo ' selected="selected"';
	echo '>'.$TipoDocente.'</option>'."\r\n";
}
?>                        
          </select> 
          Pagina: 
          <select name="Pagina" id="select">
<option>Seleccione</option>
<option value="1" <?php if($Emp[$i]['Pagina'] == 1) echo 'selected="selected"';  ?>>Profesor</option>
<option value="21" <?php if($Emp[$i]['Pagina'] == 21) echo 'selected="selected"';  ?>>Inicial Maestra</option>
<option value="22" <?php if($Emp[$i]['Pagina'] == 22) echo 'selected="selected"';  ?>>Inicial Auxiliar</option>
<option value="23" <?php if($Emp[$i]['Pagina'] == 23) echo 'selected="selected"';  ?>>Primaria Maestra</option>
<option value="3" <?php if($Emp[$i]['Pagina'] == 3) echo 'selected="selected"';  ?>>Admin</option>
<option value="4" <?php if($Emp[$i]['Pagina'] == 4) echo 'selected="selected"';  ?>>Mant</option>
<option value="5" <?php if($Emp[$i]['Pagina'] == 5) echo 'selected="selected"';  ?>>Ita y Otros</option>
<option value="6" <?php if($Emp[$i]['Pagina'] == 6) echo 'selected="selected"';  ?>>Directivo</option>
<option value="7" <?php if($Emp[$i]['Pagina'] == 7) echo 'selected="selected"';  ?>>TD</option>
</select>          
          
Contable: <input name="TipoEmpleadoContabilidad" type="text" id="TipoEmpleadoContabilidad" value="<?php echo $Emp[$i][TipoEmpleadoContabilidad] ?>"  size="4"  />
<br />
        Nivel Acad&eacute;mico: 
        <select name="NivelAcademico" id="NivelAcademico">
          <option>Seleccione..</option>
          <option value="1.Primaria" <?php if($Emp[$i][NivelAcademico] == "1.Primaria")	echo ' selected="selected"';?>>1.Primaria</option>
          <option value="2.Bachiller" <?php if($Emp[$i][NivelAcademico] == "2.Bachiller")	echo ' selected="selected"';?>>2.Bachiller</option>
          <option value="3.Est TSU" <?php if($Emp[$i][NivelAcademico] == "3.Est TSU")	echo ' selected="selected"';?>>3.Est TSU</option>
          <option value="4.TSU" <?php if($Emp[$i][NivelAcademico] == "4.TSU")	echo ' selected="selected"';?>>4.TSU</option>
          <option value="5.Est Lic" <?php if($Emp[$i][NivelAcademico] == "5.Est Lic")	echo ' selected="selected"';?>>5.Est Lic</option>
          <option value="6.Lic" <?php if($Emp[$i][NivelAcademico] == "6.Lic")	echo ' selected="selected"';?>>6.Lic</option>
          <option value="7.Especialización" <?php if($Emp[$i][NivelAcademico] == "7.Especialización")	echo ' selected="selected"';?>>7.Especializaci&oacute;n</option>
          <option value="8.Master" <?php if($Emp[$i][NivelAcademico] == "8.Master")	echo ' selected="selected"';?>>8.Master</option>
          <option value="9.Doc" <?php if($Emp[$i][NivelAcademico] == "9.Doc")	echo ' selected="selected"';?>>9.Doc</option>
        </select>        
        <?php 
  echo "Titulo ";
   Campo('Titulo' , 't' , $Emp[$i][Titulo] , 30,''); 

  echo "<br>";
	  
$sql_Curso = "SELECT * FROM Curso 
				WHERE Cedula_Prof_Guia LIKE '%".$Emp[$i][Cedula]."%' ";  
$RS = $mysqli->query($sql_Curso);
if ($row = $RS->fetch_assoc()) {
	echo "Docente: ".$row['NombreCompleto'];
}

$sql_Curso = "SELECT * FROM Curso 
				WHERE Cedula_Prof_Aux LIKE '%".$Emp[$i][Cedula]."%' ";  
$RS = $mysqli->query($sql_Curso);
if ($row = $RS->fetch_assoc()) {
	echo "Aux: ".$row['NombreCompleto'];
}

	 

  echo "<br>Cargo Largo: ";
   Campo('CargoLargo' , 't' , $Emp[$i][CargoLargo] , 20,''); 
  echo " Cargo Corto: ";
   Campo('CargoCorto' , 't' , $Emp[$i][CargoCorto] , 12,''); 
  echo "<br>Funciones: ";
   Campo('Funciones' , 't' , $Emp[$i][Funciones] , 20,''); 
  echo " Horario Trab: ";
   Campo('HorarioTrab' , 't' , $Emp[$i][HorarioTrab] , 20,''); 
  



  ?>
        Asignaturas:
        <?php Campo('Asignaturas' , 't' , $Emp[$i][Asignaturas] , 20,''); ?></td>
      </tr>
    <?php } 

// Movimiento salarial
if(false and TieneAcceso($Acceso_US,"Sueldo"))
if ($Dsp['Sueldo']==1) {
$DiferenciaSep = 0;	
	 ?>

<tr><td><table width="100%%" border="0" cellspacing="0" cellpadding="3">
  <tbody>
    <tr class="NombreCampo">
      <td>&nbsp;Codigo_Quincena</td>
      <td>&nbsp;Concepto</td>
      <td>&nbsp;Monto</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
<?php 
$query_RS_Empleados_Pagos = "SELECT * FROM Empleado_Pago 
								WHERE Codigo_Empleado = '".$Emp[$i][CodigoEmpleado]."' 
								AND Monto > 0
								ORDER BY Codigo_Quincena DESC";// = '+SueldoBase'
//echo $query_RS_Empleados_Pagos;											
$RS_Empleados_Pagos = mysql_query($query_RS_Empleados_Pagos, $bd) or die(mysql_error());
while($row_RS_Empleados_Pagos = mysql_fetch_assoc($RS_Empleados_Pagos) and $num < 15){
$num++;	
extract($row_RS_Empleados_Pagos);

if($Concepto == '+SueldoBase')
	$MontoQuincena[$Codigo_Quincena] = $Monto;

?>    
    <tr class="FondoCampo">
      <td>&nbsp;<?= $Codigo_Quincena ?></td>
      <td>&nbsp;<?= $Concepto ?></td>
      <td>&nbsp;<?= $Monto ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
<?php } 
$MontoAbonar = 0;
$MontoAbonar = round($MontoQuincena['2017 09 2'] - $MontoQuincena['2017 07 2'],2);
//$MontoAbonar = 600;
$insertSQL = "INSERT INTO Empleado_Deducciones 
(Codigo_Empleado, Tipo, Quincena, Mes, Ano, Descripcion, Monto, RegistradoPor, Fecha_Registro) 
VALUES ('".$Emp[$i][CodigoEmpleado]."', 'PA', '2', '10', '2017', 'Diferencia Cesta Ticket Octubre', $MontoAbonar, '$MM_Username', '".date('Y-m-d')."')";
if(true or $MontoQuincena['2017 09 2'] > 0 and $MontoQuincena['2017 07 2'] > 0 and $MontoAbonar > 0){
	//echo $insertSQL.'<br>';
	//$mysqli->query($insertSQL);
	$UpdatePagoExtra = "UPDATE Empleado 
						SET Pago_Extra2 = $MontoAbonar
						WHERE CodigoEmpleado = '".$Emp[$i][CodigoEmpleado]."'";
	//$mysqli->query($UpdatePagoExtra);
	//echo $UpdatePagoExtra;				
	}
	
	
?>    
	 <tr class="FondoCampo">
      <td>2da Jul: &nbsp;<?= $MontoQuincena['2017 07 2'] ?></td>
      <td>1ra Sep: &nbsp;<?= $MontoQuincena['2017 09 1'] ?></td>
      <td>2da Sep: &nbsp;<?= $MontoQuincena['2017 09 2'] ?></td>
      <td>2da Oct: &nbsp;<?= $MontoQuincena['2017 10 2'] ?></td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
</td></tr>
<?
}
// Movimiento salarial FIN

if(TieneAcceso($Acceso_US,"Sueldo"))
if ($Dsp['Sueldo']==1) { ?>
    <tr>
      <td width="100%"><table border="0" cellpadding="3">
        <tr class="NombreCampo">
          <td nowrap="nowrap">Sueldo</td>
          <td nowrap="nowrap">&nbsp;</td>
          <td align="center" nowrap="nowrap">Base 1</td>
          <td align="center" nowrap="nowrap">Base 2</td>
          <td align="center" nowrap="nowrap">Base 3</td>
          <td align="center" nowrap="nowrap">Hr Acad</td>
          <td align="center" nowrap="nowrap">Bs/Hr</td>
          <td align="center" nowrap="nowrap">Hr Adm</td>
          <td align="center" nowrap="nowrap">Bs/Hr</td>
          <td align="right" nowrap="nowrap">Quincenal</td>
          <td align="right" nowrap="nowrap">Mensual</td>
          <td align="right" nowrap="nowrap">Semanal</td>
          <td align="right" nowrap="nowrap">Diario</td>
        </tr>
        <tr>
          <td nowrap="nowrap" class="NombreCampo">Sueldo:
          <?php 
	  	//echo $Emp[$i][SueldoBase_anterior].' -> ';
		//Campo('SueldoBase_anterior' , 'h' , $Emp[$i][SueldoBase_anterior] , 6,''); 
		/*
		$JavaSueldo = ' onkeyup="SueldoBase.value=Number(SueldoBase_1.value) + Number(SueldoBase_2.value) + Number(SueldoBase_3.value) + Number(HrAcad.value)*Number(BsHrAcad.value)*2 + Number(HrAdmi.value)*Number(BsHrAdmi.value)*2; SueldoBase_Disp.value=SueldoBase.value; "  onfocus="if(this.value==\'0.00\'){this.value=\'\'}" ';
		
		$JavaSueldo_prox = ' onkeyup="SueldoBase_prox.value=Number(SueldoBase_1_prox.value) + Number(SueldoBase_2_prox.value) + Number(SueldoBase_3_prox.value) + Number(HrAcad_prox.value)*Number(BsHrAcad_prox.value)*2 + Number(HrAdmi_prox.value)*Number(BsHrAdmi_prox.value)*2; SueldoBase_prox_Disp.value=SueldoBase_prox.value; "  onfocus="if(this.value==\'0.00\'){this.value=\'\'}" ';
		
		//$SueldoConAumento = round($Emp[$i][SueldoBase_anterior] * 1.36 , 2);
		//$Emp[$i][SueldoBase_1]==0?'onfocus="this.value='.$SueldoConAumento.'";onfocus="SueldoBase.value='.$SueldoConAumento.'"':
	  	
		$sql = "SELECT * FROM Horario WHERE Cedula_Prof = '".$Emp[$i][Cedula]."' AND Descripcion <> '200'";
		$RS_sql = $mysqli->query($sql);
		$row_RS_sql = $RS_sql->fetch_assoc();
		$HrAcadHorario = $RS_sql->num_rows;
		
		$sql = "SELECT * FROM Horario WHERE Cedula_Prof = '".$Emp[$i][Cedula]."' AND Descripcion = '200'";
		$RS_sql = $mysqli->query($sql);
		$row_RS_sql = $RS_sql->fetch_assoc();
		$HrAdmiHorario = $RS_sql->num_rows;
		
		if($HrAcadHorario>0 or $HrAdmiHorario>0){
			for($j = 1; $j <= 5; $j++){
				$sql = "SELECT * FROM Horario 
						WHERE Cedula_Prof = '".$Emp[$i][Cedula]."' 
						AND Dia_Semana ='".$j."'";
				$RS_sql = $mysqli->query($sql);
				$HrDia[$j] = $RS_sql->num_rows * 1; }
			}
		else 
			$HrDia = '';
		*/
		 ?></td>
          <td nowrap="nowrap" class="FondoCampo"><input name="SueldoBase_Mes" type="hidden" id="SueldoBase_Mes" value="<?php echo $Emp[$i][SueldoBase_Mes]; ?>"  size="10" onclick="this.value=<?php 
		  //echo $Emp[$i][SueldoBase_1] * 2.87;
		  if($Emp[$i][SueldoBase] < $SueldoMinimoMensual/2)
		  		echo $SueldoMinimoMensual 
		  
		  ?>"  onkeyup="SueldoBase_1.value=Number(SueldoBase_Mes.value)/2"  <?php echo $JavaSueldo ?> /></td>
          <td align="center" nowrap="nowrap" class="FondoCampo"><?php echo Fnum(round($Sueldo_Tabla * $Sueldo_Minimo * $FactorHoras ,2)); ?><input name="SueldoBase_1" type="hidden" id="SueldoBase_1" value="<?php echo $Emp[$i][SueldoBase_1]; ?>"  size="10" onclick="this.value=<?php 
		  //echo $Emp[$i][SueldoBase_1] * 2.87;
		  
		  if($Emp[$i][SueldoBase_1] < $SueldoMinimoMensual/2)
		  	echo $SueldoMinimoMensual/2 
		  
		  ?>" <?php echo $JavaSueldo ?> /></td>
          <td align="center" nowrap="nowrap" class="FondoCampo"><input name="SueldoBase_2" type="hidden" id="SueldoBase_2" value="<?php echo $Emp[$i][SueldoBase_2] ?>"  size="10" <?php echo $JavaSueldo ?> /></td>
          <td align="center" nowrap="nowrap" class="FondoCampo"><?php echo Fnum($Bono_Anos_Servicio); ?>
          
          <input name="SueldoBase_3" type="hidden" id="SueldoBase_3" value="<?php echo $Emp[$i][SueldoBase_3] ?>"  size="10" <?php echo $JavaSueldo ?> onclick="if(this.value>=0 )this.value=0.5*<?php echo Edad($Emp[$i][FechaIngreso]) ?>*100<?php // 1134 -> 1674 -> 3255 -> 3255 -> 5338 ?>" /></td>
          <td align="center" nowrap="nowrap" class="FondoCampo"><input name="HrAcad" type="text" id="HrAcad" size="5" value="<?php echo $Emp[$i][HrAcad] ?>"  <?php echo $JavaSueldo ?> /></td>
          <td align="center" nowrap="nowrap" class="FondoCampo"><?php echo Fnum($Valor_Hora) ; ?><input name="BsHrAcad" type="hidden" id="BsHrAcad" size="5" value="<?php /*echo $BsHrProf;*/  echo $Emp[$i][BsHrAcad] ?>"  <?php echo $JavaSueldo ?>  /></td>
          <td align="center" nowrap="nowrap" class="FondoCampo"><input name="HrAdmi" type="text" id="HrAdmi" size="5" value="<?php echo $Emp[$i][HrAdmi] ?>"  <?php echo $JavaSueldo ?>/></td>
          <td align="center" nowrap="nowrap" class="FondoCampo"><?php echo Fnum($Valor_Hora) ; ?><input name="BsHrAdmi" type="hidden" id="BsHrAdmi" size="5" value="<?php echo $Emp[$i][BsHrAdmi] ?>"  <?php echo $JavaSueldo ?>/></td>
          <td align="right" nowrap="nowrap" class="FondoCampo"><input name="SueldoBase" type="hidden" id="SueldoBase" value="<?php echo $Emp[$i][SueldoBase] ?>" size="15" />
          <input name="SueldoBase_Disp" type="text" disabled="disabled" id="SueldoBase_Disp" value="<?php echo Fnum($Emp[$i][SueldoBase]) ?>" size="15" /></td>
          <td align="right" nowrap="nowrap" class="<?php 
		  
		  $CantHoras = $Emp[$i][HrAdmi]+$Emp[$i][HrAcad];
		  if($CantHoras > 0){
			  	$SueldoMinimoMensual = round(($CantHoras/40) * $SueldoMinimoMensual , 2);
		  }
		  if((($Emp[$i][SueldoBase]*2)) < $SueldoMinimoMensual){
			  
			   echo "SW_Amarillo"; } else { echo "FondoCampo"; } ?>">&nbsp;<?php echo Fnum(round($Emp[$i][SueldoBase]*2 , 2)) ?></td>
          <td align="right" nowrap="nowrap" class="FondoCampo"><?php echo round($Emp[$i][SueldoBase]*24/52,2) ?></td>
          <td align="right" nowrap="nowrap" class="FondoCampo"><?php echo round($Emp[$i][SueldoBase]*24/360,2) ?></td>
        </tr>

     <?php if(true) {
		 
		 $sql = "SELECT * FROM Empleado_Pago 
		 		 WHERE Codigo_Empleado = '".$Emp[$i][CodigoEmpleado]."'
				 AND ( Codigo_Quincena = '".$Variable->view("Compara_Q_1")."' 
				 OR Codigo_Quincena = '".$Variable->view("Compara_Q_2")."' )
				 AND Concepto = '+SueldoBase'
				 ORDER BY Codigo_Quincena ";
		 $RS_Pagos = $mysqli->query($sql);
		 $row_Pagos = $RS_Pagos->fetch_assoc();
		 
		 ?>     
        <tr>
          <td nowrap="nowrap" class="NombreCampo">Benef Adic</td>
          <td nowrap="nowrap" class="FondoCampo">&nbsp;</td>
          <td align="center"  class="FondoCampo" nowrap="nowrap">&nbsp;</td>
          <td align="center" class="FondoCampo" nowrap="nowrap"><? echo $row_Pagos['Codigo_Quincena'] ?></td>
          <td align="center" class="FondoCampo" nowrap="nowrap"><? $Monto1 = $row_Pagos['Monto']; echo $Monto1; ?></td>
          <td align="center" class="FondoCampo" nowrap="nowrap">&nbsp;<? $row_Pagos = $RS_Pagos->fetch_assoc(); ?></td>
          <td align="center" class="FondoCampo" nowrap="nowrap"><? echo $row_Pagos['Codigo_Quincena'] ?></td>
          <td align="center" class="FondoCampo" nowrap="nowrap"><? $Monto2 = $row_Pagos['Monto']; echo $Monto2; ?></td>
          <td align="center" class="FondoCampo" nowrap="nowrap">&nbsp;</td>
          <td class="FondoCampo" align="right" nowrap="nowrap"><? 
		  
		  $MontoDif = max(round(($Monto2-$Monto1),2),0); 
		 
		  //$AnosLaborados = round( Fecha_Meses_Laborados($Emp[$i]['FechaIngreso'], date('Y').'-12-31') , 2 );
		
		//if ($AnosLaborados > 1)
		//	$AnosLaborados = 1;
		
		  //$MontoDif = $MontoDif * $AnosLaborados;
		  echo $MontoDif;//." x ( $AnosLaborados )"; 
		  
		  
		  ?></td>
          <td class="FondoCampo" align="right" nowrap="nowrap">&nbsp;</td>
          <td align="right" nowrap="nowrap" class="FondoCampo"> </td>
          <td class="FondoCampo" align="right" nowrap="nowrap">&nbsp;</td>
        </tr>
     <?php } ?>

        <tr>
          <td nowrap="nowrap" class="NombreCampo">Pago Extra:</td>
          <td nowrap="nowrap" class="FondoCampo"><input name="islr_porciento" type="hidden"  id="islr_porciento" value="<?php echo $Emp[$i][islr_porciento] ?>" size="10"   /></td>
          <td colspan="2" align="center" nowrap="nowrap" class="FondoCampo">
<input name="Pago_extra" type="text"  id="Pago_extra" value="<?php echo $Emp[$i][Pago_extra] ?>" size="10" <?php  ?> onClick="this.value=(<?= $MontoDif ?>)" /> 
           -
            <input name="Pago_extra_deduc" type="text"  id="Pago_extra_deduc" value="<?php echo $Emp[$i][Pago_extra_deduc] ?>" size="10"  onClick="this.value=(SueldoBase.value-SueldoBase_prox.value)*2*0.945"  /></td>

          <td colspan="2" align="center" nowrap="nowrap" class="FondoCampo"><input name="Pago_extra2" type="text"  id="Pago_extra2" value="<?php echo $Emp[$i][Pago_extra2] ?>" size="10" <?php //onClick="this.value=(SueldoBase.value-SueldoBase_prox.value)*2*0.945" ?> />            -
            <input name="Pago_extra2_deduc" type="text"  id="Pago_extra2_deduc" value="<?php echo $Emp[$i][Pago_extra2_deduc] ?>" size="10" <?php //onClick="this.value=(SueldoBase.value-SueldoBase_prox.value)*2*0.945" ?> /></td>
          <td align="center" nowrap="nowrap" class="FondoCampo">&nbsp;</td>
          <td align="center" nowrap="nowrap" class="FondoCampo">&nbsp;</td>
          <td align="center" nowrap="nowrap" class="FondoCampo">&nbsp;</td>
          <td align="right" nowrap="nowrap" class="FondoCampo">&nbsp;</td>
          <td align="right" nowrap="nowrap" class="FondoCampo">&nbsp;</td>
          <td align="right" nowrap="nowrap" class="FondoCampo"></td>
          <td align="right" nowrap="nowrap" class="FondoCampo">&nbsp;</td>
        </tr>



        <!--tr>
          <td colspan="12"><?php 
		  echo "<pre>";
		  echo $Emp[$i][SueldoAnteriorDesglose];
		  echo "</pre>";
		  ?></td>
          </tr-->
      </table>
        </td>
      </tr>
    <?php } 



if(TieneAcceso($Acceso_US,"CestaTicket"))
if ($Dsp['BonoAlim']==1) { ?>
    <tr>
      <td width="100%" class="FondoCampo">Bono Alimentaci&oacute;n
        <?php   
		
$ClaveCampo = "CodigoEmpleado";
$ClaveValor = $Emp[$i][CodigoEmpleado];
$Tabla = "Empleado";		
		  
echo "Activo ";
Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,'SW_cestaT',$Emp[$i][SW_cestaT]); echo " | ";

echo "Adicional ".$CT_BonoAdicional;
Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,'SW_cestaT_Adicional',$Emp[$i][SW_cestaT_Adicional]); echo " ";


echo " / Emision ";
Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,'SW_CestaTnew',$Emp[$i][SW_CestaTnew]); echo " ";
 ?>
        :
        
        (base <?php echo $UnidadTributaria ?> x 
        <input name="CestaTiketPorcentaje" type="text" id="CestaTiketPorcentaje" value="<?php echo $Emp[$i][CestaTiketPorcentaje]; ?>" size="8" />
        %
        = <?php echo round($UnidadTributaria*$Emp[$i][CestaTiketPorcentaje]/100 , 2) ?>)  + 
        <input name="BonifAdicCT" type="text" id="BonifAdicCT" value="<?php echo $Emp[$i][BonifAdicCT]; ?>" size="12" />
        
        | Inasistencias:
<input name="DiasInasistencia" type="text" id="DiasInasistencia" value="<?php echo $Emp[$i][DiasInasistencia]; ?>" size="3" />
        <?php
		
		$sql_aux = "SELECT * FROM Empleado_EntradaSalida
					WHERE Codigo_Empleado = '".$Emp[$i][CodigoEmpleado]."'
					AND Fecha >= '".date("Y-m-01")."'
					AND Fecha <= '".date("Y-m-31")."'
					AND Obs = 'Falto'";
		//echo $sql_aux;			
		$RS_Inas = $mysqli->query($sql_aux);
		while($row_RS_Empleados = $RS_Inas->fetch_assoc()){
			
			echo $row_RS_Empleados['Fecha'].' ';
			
			}
		
		 ?> Observ:
        <input name="ObservacionesCestaT" type="text" id="ObservacionesCestaT" value="<?php echo $Emp[$i][ObservacionesCestaT]; ?>" size="10" />
        <br />
        horario: <?php 
$ClaveCampo = "CodigoEmpleado";
$ClaveValor = $Emp[$i][CodigoEmpleado];
$Tabla = "Empleado";		

echo "Lunes ";
Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,'SW_Lun',$Emp[$i][SW_Lun]); echo " | ";
echo "Martes ";
Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,'SW_Mar',$Emp[$i][SW_Mar]); echo " | ";
echo "Miercoles ";
Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,'SW_Mie',$Emp[$i][SW_Mie]); echo " | ";
echo "Jueves ";
Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,'SW_Jue',$Emp[$i][SW_Jue]); echo " | ";
echo "Viernes ";
Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,'SW_Vie',$Emp[$i][SW_Vie]); 
if($MM_Username == "piero"){
	echo " | ";
	echo "Sab ";
	Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,'SW_Sab',$Emp[$i][SW_Sab]); echo " | ";
	echo "Dom ";
	Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,'SW_Dom',$Emp[$i][SW_Dom]); echo " | ";
}
		
		?> </td>
      </tr>
    <?php } 



if(TieneAcceso($Acceso_US,"Sueldo"))
if ($Dsp['Fecha']==1) { ?>
    <tr>
      <td width="100%" class="FondoCampo">Fecha Ingreso:
        <?php Campo('FechaIngreso' , 'd' , $Emp[$i][FechaIngreso] , 12,'');  ?>
        
        <?php echo "(". Edad($Emp[$i][FechaIngreso]) .")"; ?>
        
        Egreso:
        <?php Campo('FechaEgreso' , 'd' , $Emp[$i][FechaEgreso] , 12,'');  ?></td>
      </tr>
    <?php } 

if(TieneAcceso($Acceso_US,"Sueldo"))
if ($Dsp['Horario']==1) { ?>
    <tr>
      <td width="100%" class="FondoCampo"><?php
//echo $Emp[$i][DiasSemana];
//Campo('DiasSemana' , 'h' , $Emp[$i][DiasSemana] , 6,''); 

	
  $DiasSemana = ceil($HrDia[1]/1000)+ceil($HrDia[2]/1000)+ceil($HrDia[3]/1000)+ceil($HrDia[4]/1000)+ceil($HrDia[5]/1000);
  $DiasSemana='';
  for($j = 1; $j <= 5; $j++)
  if(ceil($HrDia[$j]/1000) > 0) $DiasSemana .= $j;
  //echo $DiasSemana;

  
  $tot_Semanal = $HrDia[1]+$HrDia[2]+$HrDia[3]+$HrDia[4]+$HrDia[5]; 
  
  $CantDias=0;
  for($j = 1; $j <= 5; $j++)
  	$CantDias += $HrDia[$j]>0?1:0;
 
  ?>
        <table border="0" cellpadding="1" cellspacing="1">
          <tr>
            <td align="center"><a href="../Horario_Adm_Prof.php?Cedula_Prof=<?php echo $Emp[$i][Cedula] ?>" target="_blank">Horario</a></td>
            <td align="center"<?php 
		  if($HrDia[1]>0 and !$Emp[$i][SW_Lun]) 
		  	echo ' bgcolor="#FF0000"'; ?>>Lu</td>
            <td align="center"<?php 
		  if($HrDia[2]>0 and !$Emp[$i][SW_Mar]) 
		  	echo ' bgcolor="#FF0000"'; ?>>Ma</td>
            <td align="center"<?php 
		  if($HrDia[3]>0 and !$Emp[$i][SW_Mie])
		  	echo ' bgcolor="#FF0000"'; ?>>Mi</td>
            <td align="center"<?php 
		  if($HrDia[4]>0 and !$Emp[$i][SW_Jue])
		  	echo ' bgcolor="#FF0000"'; ?>>Ju</td>
            <td align="center"<?php 
		  if($HrDia[5]>0 and !$Emp[$i][SW_Vie])
		  	echo ' bgcolor="#FF0000"'; ?>>Vi</td>
            <td align="center"<?php 
		  if($HrDia[6]>0 and !$Emp[$i][SW_Sab])
		  	echo ' bgcolor="#FF0000"'; ?>>Sa</td>
            <td align="center"<?php 
		  if($HrDia[7]>0 and !$Emp[$i][SW_Dom])
		  	echo ' bgcolor="#FF0000"'; ?>>Do</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td align="center"><?php
$ClaveCampo='CodigoEmpleado';
$ClaveValor=$Emp[$i][CodigoEmpleado];
$Tabla='Empleado';
									 Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,'SW_Lun',$Emp[$i][SW_Lun]);
			?></td>
            <td align="center"><?php Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,'SW_Mar',$Emp[$i][SW_Mar]); ?></td>
            <td align="center"><?php Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,'SW_Mie',$Emp[$i][SW_Mie]); ?></td>
            <td align="center"><?php Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,'SW_Jue',$Emp[$i][SW_Jue]); ?></td>
            <td align="center"><?php Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,'SW_Vie',$Emp[$i][SW_Vie]); ?></td>
            <td align="center"><?php Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,'SW_Sab',$Emp[$i][SW_Sab]); ?></td>
            <td align="center"><?php Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,'SW_Dom',$Emp[$i][SW_Dom]); ?></td>
            <td>&nbsp;</td>
            </tr>
          <?php if($tot_Semanal>0 ){ ?>
          <tr>
            <td width="40" align="center">&nbsp;</td>
            <td width="40" align="center"<?php 
		  if($HrDia[1]>0 and !$Emp[$i][SW_Lun]) 
		  	echo ' bgcolor="#FF0000"'; ?>><?php echo $HrDia[1]; ?></td>
            <td width="40" align="center"<?php 
		  if($HrDia[2]>0 and !$Emp[$i][SW_Mar]) 
		  	echo ' bgcolor="#FF0000"'; ?>><?php echo $HrDia[2]; ?></td>
            <td width="40" align="center"<?php 
		  if($HrDia[3]>0 and !$Emp[$i][SW_Mie])
		  	echo ' bgcolor="#FF0000"'; ?>><?php echo $HrDia[3]; ?></td>
            <td width="40" align="center"<?php 
		  if($HrDia[4]>0 and !$Emp[$i][SW_Jue])
		  	echo ' bgcolor="#FF0000"'; ?>><?php echo $HrDia[4]; ?></td>
            <td width="40" align="center"<?php 
		  if($HrDia[5]>0 and !$Emp[$i][SW_Vie])
		  	echo ' bgcolor="#FF0000"'; ?>><?php echo $HrDia[5]; ?></td>
            <td width="40" align="center"<?php 
		  if($HrDia[6]>0 and !$Emp[$i][SW_Sab])
		  	echo ' bgcolor="#FF0000"'; ?>><?php echo $HrDia[6]; ?></td>
            <td width="40" align="center"<?php 
		  if($HrDia[7]>0 and !$Emp[$i][SW_Dom])
		  	echo ' bgcolor="#FF0000"'; ?>><?php echo $HrDia[7]; ?></td>
            <td>&nbsp;
              <?php 
if($tot_Semanal>0 and $Emp[$i][HrAcad]>0){ 
	$PromDiario = round( $tot_Semanal / $CantDias , 2);
	echo $tot_Semanal.'/sem'; echo ' (prom/dia: '. $PromDiario .')'; 
} ?></td>
            </tr>
          <?php } ?>
          <tr>
            <td align="center">&nbsp;</td>
            <td align="center">
              <select name="EntraLun" id="EntraLun">
<?php $HorasEntrada = explode(",",$HorasEntrada);
		foreach ($HorasEntrada as $Hora) {
			echo "<option value=\"$Hora:00\" ";
			if($Emp[$i][EntraLun]==$Hora.":00") 
				echo 'selected="selected"'; 
			echo ">$Hora</option>
		";} 
?>              
              </select></td>
            <td align="center"><select name="EntraMar" id="EntraMar">
<?php foreach ($HorasEntrada as $Hora) {
			echo "<option value=\"$Hora:00\" ";
			if($Emp[$i][EntraMar]==$Hora.":00") 
				echo 'selected="selected"'; 
			echo ">$Hora</option>
		";} 
?>              
            </select></td>
            <td align="center"><select name="EntraMie" id="EntraMie">
<?php foreach ($HorasEntrada as $Hora) {
			echo "<option value=\"$Hora:00\" ";
			if($Emp[$i][EntraMie]==$Hora.":00") 
				echo 'selected="selected"'; 
			echo ">$Hora</option>
		";} 
?>              
            </select></td>
            <td align="center"><select name="EntraJue" id="EntraJue">
<?php foreach ($HorasEntrada as $Hora) {
			echo "<option value=\"$Hora:00\" ";
			if($Emp[$i][EntraJue]==$Hora.":00") 
				echo 'selected="selected"'; 
			echo ">$Hora</option>
		";} 
?>              
            </select></td>
            <td align="center"><select name="EntraVie" id="EntraVie">
<?php foreach ($HorasEntrada as $Hora) {
			echo "<option value=\"$Hora:00\" ";
			if($Emp[$i][EntraVie]==$Hora.":00") 
				echo 'selected="selected"'; 
			echo ">$Hora</option>
		";} 
?>              
            </select></td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          </table></td>
      </tr>
    <?php } 


if ($Dsp['Mensaje']==1) { ?>
    <tr>
      <td width="100%" class="FondoCampo">Mensaje Marca Tarjeta: 
        <input name="MensajeMarcaTarjeta" type="text" value="<?= $Emp[$i][MensajeMarcaTarjeta] ?>" size="100" /></td>
      </tr>
    <?php } 

if(TieneAcceso($Acceso_US,"EditaEmpleado"))
if ($Dsp['Contacto']==1) { ?>
    <tr>
      <td width="100%" class="FondoCampo">CI: <?php echo $Emp[$i][Cedula] ?> 
        <? 
		$sql_usuario = "SELECT * FROM Usuario WHERE Usuario = '".$Emp[$i][Cedula]."'";
		//echo $sql_usuario;
		$RS_Usuario = $mysqli->query($sql_usuario);
		echo "cl: ";
		if($row_RS_Usuario = $RS_Usuario->fetch_assoc() ){
			echo $row_RS_Usuario['Clave']." Privilegios: ".$row_RS_Usuario['Privilegios'];
			
			}
		
		
		?>
        Cuenta: <?php echo $Emp[$i][NumCuentaA] ?><?php echo $Emp[$i][NumCuenta] ?>
 <input name="NumCuentaB" type="text" id="NumCuentaB" value="<?php echo $Emp[$i][NumCuentaB] ?>" size="40" />
       
        <select name="FormaDePago" id="FormaDePago">
          <option value="">Forma de Pago</option>
          <option value="E" <?php if ($Emp[$i][FormaDePago]=="E") {echo ' selected="selected" ';}?>>Efectivo</option>
          <option value="C" <?php if ($Emp[$i][FormaDePago]=="C") {echo ' selected="selected" ';}?>>Cheque</option>
          <option value="T" <?php if ($Emp[$i][FormaDePago]=="T") {echo ' selected="selected" ';}?>>Transferencia</option>
        </select>
        <br />
        Cel
<input name="TelefonoCel" type="text" id="TelefonoCel" value="<?php echo $Emp[$i][TelefonoCel] ?>" size="30" />
        CargasFamiliares
        <input name="CargasFamiliares" type="text" id="CargasFamiliares" value="<?php echo $Emp[$i][CargasFamiliares] ?>" size="8" />
        <br />
        TipoContrato
<input name="TipoContrato" type="text" id="TipoContrato" value="<?php echo $Emp[$i][TipoContrato] ?>" size="8" title="TD - TI - OD" />
        Email
        <input name="Email" type="text" id="Email" value="<?php echo $Emp[$i][Email] ?>" size="30" />
        <br /></td>
      </tr>
    <?php  }
	else {?>
	<input name="Email" type="hidden" id="Email" value="<?php echo $Emp[$i][Email] ?>" />
	<? }
	
	
//if(TieneAcceso($Acceso_US,"Sueldo"))
if ($Dsp['Asistencia']==1) { ?>
    <tr>
      <td width="100%" class="FondoCampo"><a href="MarcaTarjeta.php?CodigoLeido=<?php echo $Emp[$i][Cedula] ?>" target="_blank">Asistencia</a><?php 
	  
	$sql = "SELECT * FROM Empleado_EntradaSalida
			WHERE Codigo_Empleado = '".$Emp[$i][CodigoEmpleado]."'
			GROUP BY Fecha
			ORDER BY Fecha DESC";
			//echo $sql.'<br>';
	$RS = $mysqli->query($sql); 
	$j=0;
	while ($row = $RS->fetch_assoc() and $j < 5) {
		if(date('Y-m-d') == $row['Fecha']) $Hoy = true; else $Hoy = false; 
		if($Hoy) echo '<b>';
		echo DDMMAAAA($row['Fecha']).'  ';
		if($Hoy) { echo $row['Hora'].' </b> - ';}
		
		$j++;
	}

	  
	  ?></td>
      </tr>
    <?php  } ?>
    
    
  </table></td><td align="right"><input name="Guardar" type="submit" value="G" id="Guardar"  onclick="this.value='...';this.form.submit();" />
<input name="CodigoEmpleado" type="hidden" id="CodigoEmpleado" value="<?php echo $Emp[$i][CodigoEmpleado] ?>" />
<input name="Cedula" type="hidden" id="Cedula" value="<?php echo $Emp[$i][Cedula] ?>" />

</td></tr></table>

</form>
<?php }else{?>


<form action="" method="post" name="form2" id="form2">
<table width="100%" border="0" cellspacing="0" cellpadding="3">

  <tbody>
    <tr>
      <td><img src="../../../i/b.png" width="200" height="1" alt=""/></td>
      <td><img src="../../../i/b.png" width="200" height="1" alt=""/></td>
      <td><img src="../../../i/b.png" width="200" height="1" alt=""/></td>
      <td><img src="../../../i/b.png" width="200" height="1" alt=""/></td>
      <td><img src="../../../i/b.png" width="200" height="1" alt=""/></td>
      </tr>
    <tr>
      <td class="NombreCampoBIG"><?= $Emp[$i][Apellidos].', '.$Emp[$i][Nombres] ?></td>
      <td class="NombreCampoBIG"><?= $Emp[$i][Cedula] ?></td>
      <td class="FondoCampo">
        dep 
        <input name="Monto_Fidei_Depositado" type="text" id="Monto_Fidei_Depositado" value="<?= $Emp[$i][Monto_Fidei_Depositado] ?>" size="20" />
      </td>
      <td class="FondoCampo">
        disp
        <input name="Monto_Fidei_Disponible" type="text" id="Monto_Fidei_Disponible" value="<?= $Emp[$i][Monto_Fidei_Disponible] ?>" size="20" />
      </td>
      <td align="right">&nbsp;
        <input name="Guardar" type="submit" value="G" id="Guardar"  onclick="this.value='...';this.form.submit();" />
        <input name="CodigoEmpleado" type="hidden" id="CodigoEmpleado" value="<?php echo $Emp[$i][CodigoEmpleado] ?>" />      </td>
      </tr>
  </tbody>
</table>
</form>
<?php } ?>

</body>
</html>