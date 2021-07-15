<?php
$MM_authorizedUsers = "91,95,secreAcad,AsistDireccion,secreBach";
if (!(isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
	$SW_omite_trace = true;
}
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 


//mysql_select_db($database_bd, $bd);

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {

$LocalidadPais = ucwords(strtolower(trim($_POST['LocalidadPais'])));

$Localidad = ucwords(strtolower(trim($_POST['Localidad'])));
$Entidad = ucwords(strtolower(trim($_POST['Entidad'])));
$EntidadCorta = ucwords(strtolower(trim($_POST['EntidadCorta'])));	
if($EntidadCorta == 'Dc' or $EntidadCorta == 'Df')
	$EntidadCorta = strtoupper($EntidadCorta);	

switch ($Localidad) {
   case "Chacao":
         $Entidad = "Estado Miranda";
		 $EntidadCorta = "Mi";
         break;
   case "Baruta":
         $Entidad = "Estado Miranda";
		 $EntidadCorta = "Mi";
         break;
   case "xxxSucre":
         $Entidad = "Estado Miranda";
		 $EntidadCorta = "Mi";
         break;
   case "xxxLibertador":
         $Entidad = "Distrito Capital";
		 $EntidadCorta = "DC";
         break;
//case   "Caracas":
//       $Entidad = "Distrito Capital";
//		 $EntidadCorta = "DC";
//        break;
}

$Entidad = Entidad($EntidadCorta);

if(strlen($_POST['Cedula']) >= 8)	
	$CedulaMama	= substr($_POST['Cedula'], -8);
else 
	$CedulaMama	= "";
	
  $updateSQL = sprintf("UPDATE Alumno SET Actualizado_el=%s, Actualizado_por=%s, Cedula=%s, CedulaMama=%s, Cedula_int=%s, CedulaLetra=%s, Nombres=%s, Nombres2=%s, Apellidos=%s, Apellidos2=%s, Sexo=%s, FechaNac=%s, Nacionalidad=%s, ClinicaDeNac=%s, Localidad=%s, LocalidadPais=%s, Entidad=%s, EntidadCorta=%s , Datos_Revisado_por=%s, Datos_Revisado_Fecha=NOW(), Datos_Observaciones=%s,
  Datos_Observaciones_Planilla=%s, EscolaridadObserv=%s WHERE CodigoAlumno=%s",
                       GetSQLValueString($_POST['Actualizado_el'], "date"),
                       GetSQLValueString($_POST['Actualizado_por'], "text"),
                       GetSQLValueString(trim($_POST['Cedula']), "text"),
                       GetSQLValueString($CedulaMama, "text"),
                       GetSQLValueString($_POST['Cedula']*1, "text"),
                       GetSQLValueString(ucwords(strtoupper(trim($_POST['CedulaLetra']))), "text"),
                       GetSQLValueString(ucwords(strtolower(trim($_POST['Nombres']))), "text"),
                       GetSQLValueString(ucwords(strtolower(trim($_POST['Nombres2']))), "text"),
                       GetSQLValueString(ucwords(strtolower(trim($_POST['Apellidos']))), "text"),
                       GetSQLValueString(ucwords(strtolower(trim($_POST['Apellidos2']))), "text"),
                       GetSQLValueString(ucwords(strtoupper(trim($_POST['Sexo']))), "text"),
                       GetSQLValueString($_POST['FechaNac'], "date"),
                       GetSQLValueString(ucwords(strtolower(trim($_POST['Nacionalidad']))), "text"),
                       GetSQLValueString(ucwords(strtolower(trim($_POST['ClinicaDeNac']))), "text"),
                       GetSQLValueString($Localidad, "text"),
                       GetSQLValueString($LocalidadPais, "text"),
                       GetSQLValueString($Entidad, "text"),
                       GetSQLValueString($EntidadCorta , "text"),
                       GetSQLValueString(ucwords(strtolower(trim($MM_Username))) , "text"),
                       GetSQLValueString(trim($_POST['Datos_Observaciones']), "text"),
                       GetSQLValueString(trim($_POST['Datos_Observaciones_Planilla']), "text"),
					   GetSQLValueString(trim($_POST['EscolaridadObserv']), "text"),
					   
					   
                       GetSQLValueString($_POST['CodigoAlumno'], "int"));
//echo $updateSQL;
  $Result1 = $mysqli->query($updateSQL); //mysql_query($updateSQL, $bd) or die(mysql_error());
}

$query_RS_Alumno = "SELECT * FROM Alumno WHERE CodigoAlumno = '".$_GET['CodigoAlumno']."'";
$RS_Alumno = $mysqli->query($query_RS_Alumno); //
$row_RS_Alumno = $RS_Alumno->fetch_assoc();
$totalRows_RS_Alumno = $RS_Alumno->num_rows;
/*
$RS_Alumno = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumno = mysql_fetch_assoc($RS_Alumno);
$totalRows_RS_Alumno = mysql_num_rows($RS_Alumno);
*/

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Administraci&oacute;n SFDA</title>
<link href="../../../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../../../estilos2.css" rel="stylesheet" type="text/css" />
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
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
<?php 
if(isset($_POST['Apellidos']))
	echo '	background-color: #FFFFCC;';
 ?>}
-->
</style>
</head>

<body>
<table width="100%" border="0" align="center">
<?php if ($totalRows_RS_Alumno > 0) { // Show if recordset not empty ?>
        <tr>
          <td width="5" nowrap="nowrap" ><strong><?php echo substr("0".$_GET['No'],-2); echo ") "; ?></strong> </td>
          <td  nowrap="nowrap"  >
          <form id="form2" name="form2" method="POST" action="">
          
<?php  

$query_RS_Repre = "SELECT * FROM Representante WHERE Creador='".$row_RS_Alumno['Creador']."' AND Nexo LIKE '%%Ma%%'";//echo $query_RS_Repre;
$RS_Repre = $mysqli->query($query_RS_Repre); //
$row_RS_Repre = $RS_Repre->fetch_assoc();
$totalRows_RS_Repre = $RS_Repre->num_rows;
									 
	/*								 
$RS_Repre = mysql_query($query_RS_Repre, $bd) or die(mysql_error());
$row_RS_Repre = mysql_fetch_assoc($RS_Repre);
$totalRows_RS_Repre = mysql_num_rows($RS_Repre);
*/


 ?><a href="../../PlanillaImprimirADM.php?CodigoAlumno=<?php echo  $row_RS_Alumno['CodigoAlumno'] ?>" target="_blank"><?php echo  $row_RS_Alumno['CodigoAlumno'] ?></a>
             
             <!--a href="../PDF/Titulo_Bachiller.php?CodigoAlumno=<?php echo  $row_RS_Alumno['CodigoAlumno'] ?>" target="_blank"> | Titulo</a-->
             
             <a name="lista" id="<?php if($i > 15 ) {echo $i-1;} ?>"></a> 
              <input name="CodigoAlumno" type="hidden" id="hiddenField" value="<?php echo  $row_RS_Alumno['CodigoAlumno'] ?>" />
              <input name="Actualizar_FMP" type="hidden" id="hiddenField" value="1" />
              <input name="Actualizado_el" type="hidden" id="hiddenField" value="<?php echo  date('Y-m-d'); ?>" />
              <input name="Actualizado_por" type="hidden" id="hiddenField" value="<?php echo  $MM_Username ?>" />
              <input name="CedulaLetra" type="text" id="CedulaLetra" value="<?php if($row_RS_Alumno['CedulaLetra']=='') echo "V"; else echo  $row_RS_Alumno['CedulaLetra'] ?>" size="1" /><?php if($row_RS_Alumno['CedulaLetra']=='') echo "*"; ?>
             
              <input name="Cedula" type="text" id="Cedula" value="<?php 
			  
			  if($row_RS_Alumno['Cedula']=='')  {
			  
			  $ciMama = str_replace('.','', $row_RS_Repre['Cedula']);
			  $ciMama = str_replace('-','', $ciMama);
			  $ciMama = str_replace('v','', $ciMama);
			  $ciMama = str_replace('V','', $ciMama);
			  $ciMama = str_replace('e','', $ciMama);
			  $ciMama = str_replace('E','', $ciMama);
			  $ciMama = substr("000000000".$ciMama, -8);
			  
			  echo '1'.substr($row_RS_Alumno['FechaNac'],2,2).$ciMama;} else echo  $row_RS_Alumno['Cedula']; 
			  
			  
			  ?>" size="14" />
              <?php if($row_RS_Alumno['Cedula']=='')  {  echo '*';} ?>
              <input name="Apellidos" type="text" id="Apellidos" value="<?php echo  $row_RS_Alumno['Apellidos'] ?>" size="9" />
              <input name="Apellidos2" type="text" id="Apellidos2" value="<?php echo  $row_RS_Alumno['Apellidos2'] ?>" size="9" />
              <input name="Nombres" type="text" id="Nombres" value="<?php echo  $row_RS_Alumno['Nombres'] ?>" size="9" />
              <input name="Nombres2" type="text" id="Nombres2" value="<?php echo  $row_RS_Alumno['Nombres2'] ?>" size="9" />
              <input name="Sexo" type="text" id="Sexo" value="<?php echo  $row_RS_Alumno['Sexo'] ?>" size="1" />
              
              <?php if(true) { ?>
              <input name="FechaNac" type="date" id="FechaNac" value="<?php echo  $row_RS_Alumno['FechaNac'] ?>" size="10" />
              <input name="Nacionalidad" type="text" id="Nacionalidad" value="<?php echo  $row_RS_Alumno['Nacionalidad'] ?>" size="2" />
              <input name="ClinicaDeNac" type="text" id="ClinicaDeNac" value="<?php echo  $row_RS_Alumno['ClinicaDeNac'] ?>" size="15" />
              <input name="Localidad" type="text" id="Localidad" value="<?php echo  $row_RS_Alumno['Localidad'] ?>" size="15" />
              <input name="EntidadCorta" type="text" id="EntidadCorta" value="<?php echo  $row_RS_Alumno['EntidadCorta'] ?>" size="2" />
              <input name="Entidad" type="text" disabled="disabled" id="Entidad" value="<?php echo  $row_RS_Alumno['Entidad'] ?>" size="20" />
              <input name="LocalidadPais" type="text" id="LocalidadPais" value="<?php echo  $row_RS_Alumno['LocalidadPais'] ?>" size="10" />
              
              
               <input name="Datos_Observaciones_Planilla" type="text" id="Datos_Observaciones" value="<?php echo  $row_RS_Alumno['Datos_Observaciones_Planilla'] ?>" size="15" />
             
              
              
              
              
              <input name="Datos_Observaciones" type="text" id="Datos_Observaciones" value="<?php echo  $row_RS_Alumno['Datos_Observaciones'] ?>" size="5" />
              <input name="EscolaridadObserv" type="hidden" id="EscolaridadObserv" value="<?php echo  $row_RS_Alumno['EscolaridadObserv'] ?>" size="10" />
              <?php } ?>
              <label>
              <input name="Datos_Revisado_por" type="hidden" id="Datos_Revisado_por" value="<?php echo  $row_RS_Alumno['Datos_Revisado_por'] ?>" size="2" />
              <?php echo  $row_RS_Alumno['Datos_Revisado_por'] ?>&nbsp;
			  <?php echo $row_RS_Alumno['Datos_Revisado_Fecha'] ?>
              <input type="submit" name="Guardar" id="Guardar" value="G" />
              </label>

 <?php if ( $MM_UserGroup == 91 or $MM_UserGroup == 95 or $MM_UserGroup == "secreAcad" or $MM_UserGroup == "secreBach" ){ ?>
          <input type="hidden" name="MM_update" value="form2" />
		  <?php } ?>
              
              <?php 
			  if($MM_Username == "piero" and false){
				  
				  	$sql = "SELECT * FROM AlumnoXCurso WHERE
				  			CodigoAlumno = '".$row_RS_Alumno['CodigoAlumno']."' AND
							Ano = '$AnoEscolar'";
				  	$RS_Curso_Prox = mysql_query($sql, $bd) or die(mysql_error());
					$row_RS_Alumno_Curso = mysql_fetch_assoc($RS_Curso_Prox);
					echo '<a href="../../Cobranza/Estado_de_Cuenta_Alumno.php?CodigoAlumno='.$row_RS_Alumno['CodigoAlumno'].'" target="_blank">';
					
					echo Curso($row_RS_Alumno_Curso['CodigoCurso']).' ';
					
					if($row_RS_Alumno_Curso['Status'] == "Solicitando" or $row_RS_Alumno_Curso['Status'] == "")
						echo "<b> '".$row_RS_Alumno_Curso['Status']."'</b> ";
					elseif($row_RS_Alumno_Curso['Status'] == "Aceptado")
						echo "".$row_RS_Alumno_Curso['Status'].' ';
					
					
					
					echo $row_RS_Alumno['CodigoAlumno'];
					echo " --> </a>";
					
					echo $row_RS_Alumno_Curso['Status_por'];
			
				  	//echo $sql;			
				  	
					
				  }
			  ?>
              
              
              <?php if ($row_RS_Alumno['Datos_Observaciones'] > " " and false) { ?><br /><b><?php echo $row_RS_Alumno['Datos_Observaciones']; } ?></b>
          </form></td>
    </tr>
        <?php } // Show if recordset not empty ?>
</table>
</body>
</html>
