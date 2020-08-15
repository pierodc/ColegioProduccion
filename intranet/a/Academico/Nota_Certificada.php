<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin";
//$MM_authorizedUsers = "91";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/notas.php');

header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
header("Pragma: no-cache"); //HTTP 1.0  
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado


$sw_activ = true;
if (!$sw_activ){
	echo "<pre>";
	var_dump($_POST);
	echo "</pre>";
}
//$sw_activ = true;

if (isset($_GET['CodigoAlumno'])){
	$CodigoAlumno = $_GET['CodigoAlumno'];
	}

if(isset($_POST['CambiaAlumno'])){
	header("Location: ".$_SERVER['PHP_SELF']."?CodigoAlumno=".$_POST['CodigoAlumno']);
}

if($_GET['CodigoAlumno'] > 1){
	$query_RS_Alumno = "SELECT * FROM Alumno 
						WHERE CodigoAlumno = '$_GET[CodigoAlumno]' ";
	
	$RS = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
	$row = mysql_fetch_assoc($RS);
	extract($row);	


	if($PlanDeEstudio == ""){
		$PlanDeEstudio = '1;Educación Media General;31059;* * * *:2;Educación Media General;31018;Ciencias:';
		$sql = "UPDATE Alumno SET PlanDeEstudio = '$PlanDeEstudio'
				WHERE CodigoAlumno = '$_GET[CodigoAlumno]'";
		if ($sw_activ)
			$mysqli->query($sql);
		else
			echo "<pre>".$sql."</pre>";
		header("Location: ".$_SERVER['PHP_SELF']."?CodigoAlumno=".$_GET['CodigoAlumno']);
	}

}

if(isset($_POST['FormaPlanDeEstudio'])){
	$PlanDeEstudio = $_POST['Pag1'].":".$_POST['Pag2'].":";
	$sql = "UPDATE Alumno
			SET PlanDeEstudio = '$PlanDeEstudio'
			WHERE CodigoAlumno = $CodigoAlumno";
	if ($sw_activ)
		$mysqli->query($sql);
	else
		echo "<pre>".$sql."</pre>";
	header("Location: ".$_SERVER['PHP_SELF']."?CodigoAlumno=".$_GET['CodigoAlumno']);
}

if(isset($_POST['FormaColegio']) and ($MM_UserGroup = 91 or $MM_UserGroup = 95 or $CodigoCurso < 43)){
	do{
		$i++;
		if($_POST[$i.'-Colegio']>'')
		$UpdateAlum .= $_POST[$i.'-Pag'].';'.$_POST[$i.'-No'].';'.$_POST[$i.'-Colegio'].';'.$_POST[$i.'-Localidad'].';'.$_POST[$i.'-Entidad'].':';
	} while ($_POST[$i.'-Colegio']>'');
	$UpdateAlum .= ';'.';'.';'.';'.':';
	
	$UpdateAlum .= '|'.$_POST['Observ1'].'|'.$_POST['Observ2'];
	
$sqlUpdateAlumno = " UPDATE Alumno
 					 SET ColegioNotasCert = '$UpdateAlum'
					 WHERE CodigoAlumno = $CodigoAlumno";

	if ($sw_activ)
		$mysqli->query($sqlUpdateAlumno);
	else
		echo "<pre>".$sqlUpdateAlumno."</pre>";


	header("Location: ".$_SERVER['PHP_SELF']."?CodigoAlumno=".$_GET['CodigoAlumno']);
}

$CodigoMaterias = array('7','7n','8','8n','9','9n','IV','IVn','V','Vn');






if(isset($_POST['FormaNotas']) and ($MM_UserGroup = 91 or $MM_UserGroup = 95)){
	//echo "<pre>";
	//var_dump($_POST);
	
	$CodigoMaterias = array('7','7n','8','8n','9','9n','IV','IVn','V','Vn');
	$CodigoMateriaAnterioeres = "   --7--  ";
	
	foreach($CodigoMaterias as $CodigoMateria){
			/*if($CodigoMateria == 'IV') 
				$nMax = 12; 
			else*/ 
			$nMax = 25;
			for ($j = 1; $j <= $nMax; $j++){
				
				
				$pref = $CodigoMateria.'-'.$j.'-';
				if ($_POST[$pref.'Materia'] > ""){
					$sql .= "($CodigoAlumno, '$CodigoMateria', "
								."'".$_POST[$pref.'Orden']."',"
								."'".$_POST[$pref.'Materia']."',"
								."'".$_POST[$pref.'Mat']."',"
								."'".$_POST[$pref.'CiProf']."',";
								
					$sql .= "'".$_POST[$pref.'NotaOrigen']."', '"
						    .$_POST[$pref.'Nota']."', '"
							.$_POST[$pref.'TE']."', '"
							.$_POST[$pref.'Mes']."', '"
							.$_POST[$pref.'Ano']."', '"
							.$_POST[$pref.'Plantel']."')
,";
	
				$Matriz["$CodigoMateria-$j"] = array(	$j,
												$_POST[$pref.'Materia'], 
												$_POST[$pref.'Nota'], 
												$_POST[$pref.'TE'],  
												$_POST[$pref.'Mes'],  
												$_POST[$pref.'Ano'],  
												$_POST[$pref.'Plantel']);
				
				
				//echo "<pre>deleting ".$CodigoMateriaAnterioeres ."  =?  ".
		//			substr_count($CodigoMateriaAnterioeres,"--".$CodigoMateria."--")."   ".$CodigoMateria."</pre>";	
				
											
				if (substr_count($CodigoMateriaAnterioeres,"--".$CodigoMateria."--") == 1){
					$SQLaux = "DELETE FROM Notas_Certificadas 
								WHERE CodigoAlumno = '$CodigoAlumno'
								AND Grado = '$CodigoMateria'" ;
					if ($sw_activ){
						$mysqli->query($SQLaux);
						//echo "<pre>".$SQLaux."</pre>";
					}
					else
						echo "<pre>".$SQLaux."</pre>";
				}
				
				$CodigoMateriaAnterioeres .= "  --".$CodigoMateria."--  ";
				
				
				}	
			}
		}
	
	$sql = "INSERT INTO Notas_Certificadas (CodigoAlumno, Grado, Orden, Materia, Mat, CiProf, NotaOrigen, Nota, TE, Mes, Ano, Plantel) 
			VALUES 
".$sql;
	$sql = substr($sql,0,strlen($sql)-1);
	
	
	if ($sw_activ)
		$mysqli->query($sql);
	else
		echo "<pre>".$sql."<br></pre>";
		
	//var_dump($Matriz);
}


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<title>N.Cert. <?php echo $Apellidos ?>&nbsp;<?php echo $Nombres ?></title>
<link rel="stylesheet" type="text/css" href="../../../estilos2.css"/>
<link rel="stylesheet" type="text/css" href="../../../estilos.css"/>

 <script>
 function RepiteCampo(curso,cursoBase,campo){
	
	
	if( document.getElementById(curso+"-1-"+campo).value < 1 ) {
		var campoOrigen = cursoBase+"-1-"+campo;}
	else{	
		var campoOrigen = curso+"-1-"+campo;}
	
	
	
	<? for($i = 1 ; $i < 13 ; $i++){ ?>
	var campo<?= $i ?> = curso+"-<?= $i ?>-"+campo;
	document.getElementById(campo<?= $i ?>).value = document.getElementById(campoOrigen).value;
	<? } ?>
	 
	 
	 }
 </script>
 

</head>

<body>
<?
//$CodigoMaterias = array('7','8','9','IV','V');

if ($_GET['Cursos'] == "45")
	$CodigoMaterias = array('IV','IVn','V','Vn');
else
	$CodigoMaterias = array('7','7n','8','8n','9','9n');
?>

<? require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/_Template/NavBar.php');  ?>
<form action="" method="post">
<div class="container-fluid">
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Header.php"); ?>
    <div class="row">
		<div class="col-md-12">
        	<p>&nbsp;</p><p>&nbsp;</p>
		</div>
	</div>
  
  
   <div class="row">
		<div class="col-md-12">
            <table width="800" align="center">
                <tr><?php 
        //if($Deuda_Actual > 26000 and $MM_Username != "piero" ){
            ?><td align="right">Deuda Pendiente: <?php echo Fnum($Deuda_Actual); ?>&nbsp;</td><?php //}
            //else{  ?> 
        <td align="center"><p><a href="PDF/Nota_Certificada.php?Promedia=1&amp;CodigoAlumno=<?php echo $CodigoAlumno ?>" target="_blank"><img src="../../../i/printer.png"  width="32" height="32" /> <br />
          con promedio
          </a></p>
          <p><a href="PDF/Nota_Certificada_anterior.php?Promedia=1&amp;CodigoAlumno=<?php echo $CodigoAlumno ?>" target="_blank">Forma Vieja</a><br />
          </p></td>
        <td align="center"><p><a href="PDF/Nota_Certificada.php?CodigoAlumno=<?php echo $CodigoAlumno ?>" target="_blank"><img src="../../../i/printer.png" alt=""  width="32" height="32" /> <br />
          sin promedio</a></p>
          <p><a href="PDF/Nota_Certificada_anterior.php?CodigoAlumno=<?php echo $CodigoAlumno ?>" target="_blank">Forma Vieja</a></p></td>
    <?php //} ?>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right"><a href="Nota_Certificada.php?CodigoAlumno=<?= $CodigoAlumno ?>&Cursos=123">123</a> | <a href="Nota_Certificada.php?CodigoAlumno=<?= $CodigoAlumno ?>&Cursos=45">IV V</a></td>
        </tr>
            </table>
	  </div>
	</div>
        

<? 
$CodigoMaterias = array('7','8','9','IV','V');

if ($_GET['Cursos'] == "45")
	$CodigoMaterias = array('IV','V');
else
	$CodigoMaterias = array('7','8','9');


foreach ($CodigoMaterias as $CodigoMate){
?>    
    <div class="row">
		<div class="col-md-12">
        	<h2> <?= $CodigoMate ?></h2>
		</div>
	</div>
    <div class="row">
    
    	<?php foreach (array("","n") as $n){ ?>
            <div class="col-md-6">
                <?= $CodigoMate.$n ?>
                <table width="100%" class="table-striped table-bordered table-hover">
      <tbody>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Materia</th>
          <th scope="col"><? if ($n == "n") { ?>
            Mat
              <? } ?></th>
          <th scope="col"><? if ($n == "n") { ?>
            CI Prof
              <? } ?></th>
          <th scope="col"><? if ($n == "n") { ?>Origen<? } ?></th>
          <th scope="col">Nota</th>
          <th scope="col"><div onclick="RepiteCampo('<?= $CodigoMate.$n ?>','<?= $CodigoMate ?>','TE');" >TE <img src="../../../i/control_repeat_blue.png" width="16" height="16" alt=""/></div></th>
          <th scope="col"><div onclick="RepiteCampo('<?= $CodigoMate.$n ?>','<?= $CodigoMate ?>','Mes');" >Mes <img src="../../../i/control_repeat_blue.png" width="16" height="16" alt=""/></div></th>
          <th scope="col"><div onclick="RepiteCampo('<?= $CodigoMate.$n ?>','<?= $CodigoMate ?>','Ano');" >Ano <img src="../../../i/control_repeat_blue.png" width="16" height="16" alt=""/></div></th>
          <th scope="col">Plantel</th>
        </tr>
 <? 
 $sql = "SELECT * FROM Notas_Certificadas 
		WHERE CodigoAlumno = '$CodigoAlumno'  
		AND Grado = '".$CodigoMate.$n."'
		AND Orden < 20
		ORDER BY Orden"; 
		//echo $sql.' 11<br>';
$RS = $mysqli->query($sql);
if ($RS->num_rows == 0) {
	 $sql = "SELECT * FROM Notas_Certificadas 
			WHERE CodigoAlumno = '1'  
			AND Grado = '".$CodigoMate.$n."'
			AND Orden < 20
			ORDER BY Orden"; 
			//echo $sql.' 11<br>';
	$RS = $mysqli->query($sql);
	}

$Orden_aux = 0;
while ($row = $RS->fetch_assoc()){
	$Orden_aux++;
	extract($row);
	$Orden = $Orden_aux;
	$CodigoAlumno = $_GET['CodigoAlumno'];
	$script = $Sumatoria = $ConteoProm = $Promedio = "";
	if($Materia > "") {
	if ($n == "n" and strlen($NotaOrigen) > 0 ){
		
		$Prom = explode("-",$NotaOrigen);
		foreach ($Prom as $valor){
			$Sumatoria +=  $MatrizNotas[$CodigoMate][$valor];
			$ConteoProm++;
			}
		$Promedio = round( $Sumatoria / $ConteoProm ,0);
		
		$script = ' onclick="this.value='.$Promedio.'" ';
		}
	elseif ($n != "n") {
		$MatrizNotas[$CodigoMate][$Orden] = $Nota;
		}

	if ($Nota == "" and $Promedio > ""){
		$Nota = $Promedio;
		}
 ?>       

       <tr>
          <th scope="row"><?= $Orden ?>
           	  <? Campo($CodigoMate.$n."-$Orden-Orden",'h',$Orden,30)  ?></th>
          <td><? Campo($CodigoMate.$n."-$Orden-Materia",$Tipo,$Materia,30)  ?></td>
          <td><? if ($n == "n") Campo($CodigoMate.$n."-$Orden-Mat",$Tipo,$Mat,5)  ?></td>
          <td><? if ($n == "n") Campo($CodigoMate.$n."-$Orden-CiProf",$Tipo,$CiProf,10)  ?></td>
          <td><? if ($n == "n") Campo($CodigoMate.$n."-$Orden-NotaOrigen",$Tipo,$NotaOrigen,5)  ?></td>
          <td><? Campo($CodigoMate.$n."-$Orden-Nota",$Tipo,$Nota,5,$script)  ?></td>
          <td><? Campo($CodigoMate.$n."-$Orden-TE",$Tipo,$TE,5) ?></td>
          <td><? Campo($CodigoMate.$n."-$Orden-Mes",$Tipo,$Mes,5)  ?></td>
          <td><? Campo($CodigoMate.$n."-$Orden-Ano",$Tipo,$Ano,5)  ?></td>
          <td><? Campo($CodigoMate.$n."-$Orden-Plantel",$Tipo,$Plantel,5)  ?></td>
        </tr>
 <? }} ?>         
        <tr>
          <th scope="row"><?= ++$Orden ?>
		  	  <? Campo($CodigoMate.$n."-$Orden-Orden",'h',$Orden,30)  ?></th>
          <td><? Campo($CodigoMate.$n."-$Orden-Materia",$Tipo,"",30)  ?></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><? Campo($CodigoMate.$n."-$Orden-Nota",$Tipo,"",5)  ?></td>
          <td><? Campo($CodigoMate.$n."-$Orden-TE",$Tipo,"",5) ?></td>
          <td><? Campo($CodigoMate.$n."-$Orden-Mes",$Tipo,$Mes,5)  ?></td>
          <td><? Campo($CodigoMate.$n."-$Orden-Ano",$Tipo,$Ano,5)  ?></td>
          <td><? Campo($CodigoMate.$n."-$Orden-Plantel",$Tipo,$Plantel,5)  ?></td>
        </tr>
 <? 
 $sql = "SELECT * FROM Notas_Certificadas 
		WHERE CodigoAlumno = '$CodigoAlumno'  
		AND Grado = '".$CodigoMate.$n."'
		AND Orden >= 20
		ORDER BY Orden"; 
		//echo $sql.' 11<br>';
$RS = $mysqli->query($sql);
if ($RS->num_rows == 0) {
	 $sql = "SELECT * FROM Notas_Certificadas 
			WHERE CodigoAlumno = '1'  
			AND Grado = '".$CodigoMate.$n."'
			AND Orden >= 20
			ORDER BY Orden"; 
			//echo $sql.' 11<br>';
	$RS = $mysqli->query($sql);
	}
	else{
		//$Orden = 19;
		}


while ($row = $RS->fetch_assoc()){
	extract($row); 
	$CodigoAlumno = $_GET['CodigoAlumno'];
	
	?>       
        <tr>
          <th scope="row"><?= $Orden ?>
          	  <? Campo($CodigoMate.$n."-$Orden-Orden",'h',$Orden,30)  ?></th>
          <td><? Campo($CodigoMate.$n."-".$Orden."-Materia",$Tipo,$Materia,30)  ?></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><? if ($n == "n") Campo($CodigoMate.$n."-$Orden-NotaOrigen",$Tipo,$NotaOrigen,5)  ?></td>
          <td><? Campo($CodigoMate.$n."-".$Orden.'-Nota',$Tipo,$Nota,5,$script)  ?></td>
          <td>&nbsp;</td>
          <td><? Campo($CodigoMate.$n."-".$Orden.'-Mes',"h","ET",5)  ?></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
 <? } ?>     
 
 <? if ($Orden < 19) { $Orden = 19; } ?>  
		<tr>
          <th scope="row"><?= ++$Orden ?>
          	  <? Campo($CodigoMate.$n."-$Orden-Orden",'h',$Orden,30)  ?></th>
          <td><? Campo($CodigoMate.$n."-".$Orden."-Materia",$Tipo,"",30)  ?>....</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><? Campo($CodigoMate.$n."-".$Orden.'-Nota',$Tipo,$Nota,5)  ?></td>
          <td>&nbsp;</td>
          <td><? Campo($CodigoMate.$n."-".$Orden.'-Mes',"h","ET",5)  ?></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </tbody>
    </table>
            </div>
        <? } ?>
	</div>
<? } ?>    
    
    
    
</div>
<input type="hidden" name="FormaNotas" value="1" />
<input type="submit" name="button2" id="button2" value="Guardar" />
</form>



<hr />

<form id="form2" name="form2" method="post" action="">
 
  <table width="800" align="center" cellpadding="2" cellspacing="2">
    <tr>
      <td align="center"><input name="CodigoAlumno" type="text" id="CodigoAlumno" value="<?php echo $_GET['CodigoAlumno']; ?>" /><input name="CambiaAlumno" type="hidden" value="1" />
  <input type="submit" name="button3" id="button3" value="Submit" /></td>
    </tr>
  </table>
</form>
<?php 


$Promedio = 0;
$FactorPromedio=0;

//var_dump($MatrizNotas);

/*
?>
<form action="" method="post" name="FormNotas">
  <table width="800" border="0" align="center" cellpadding="0">
  <tr>
    <td class="subtitle">&nbsp;<?php echo $CodigoAlumno ?>
      <input type="hidden" name="CodigoAlumno" value="<?php echo $CodigoAlumno ?>" />
      <input type="hidden" name="FormaNotas_old" value="1" /></td>
    <td colspan="4" class="subtitle">&nbsp;<?php echo $Apellidos ?>&nbsp;<?php echo $Apellidos2 ?>&nbsp;<?php echo $Nombres ?>&nbsp;<?php echo $Nombres2 ?></td>
    <td class="subtitle">&nbsp;</td>
    <td class="subtitle">&nbsp;</td>
    </tr>
<?php foreach($CodigoMaterias as $CodigoMateria){ ?>
  <tr>
    <td class="NombreCampoTITULO">&nbsp;Curso</td>
    <td colspan="6" class="NombreCampoTITULO">&nbsp;<?php echo $CodigoMateria ?></td>
    </tr>
  <tr>
    <td align="center" class="NombreCampo">No.</td>
    <td class="NombreCampo">Materia</td>
    <td align="center" class="NombreCampo">Nota</td>
    <td align="center" class="NombreCampo">TE</td>
    <td align="center" class="NombreCampo">Mes</td>
    <td align="center" class="NombreCampo">Ano</td>
    <td align="center" class="NombreCampo">Plantel</td>
    </tr>
  <?php 
$Orden = 0;
$CodigoAlumno = $_GET['CodigoAlumno'];

$sql = "SELECT * FROM Notas_Certificadas 
		WHERE CodigoAlumno = '$CodigoAlumno'  
		AND Grado = '$CodigoMateria'
		ORDER BY Orden"; 
		//echo $sql.' 11<br>';
$RSnotas = mysql_query($sql, $bd) or die(mysql_error());
$row_notas = mysql_fetch_assoc($RSnotas);

		


if($row_notas){ // Existe Notas del nivel
	$Base = true;}
else { // NO EXISTE Notas del nivel, usar generico  
	   // Busca Alumno Generico para materias
	$Base = false;
	$sql = "SELECT * FROM Notas_Certificadas 
			WHERE CodigoAlumno = 1 
			AND Grado = '$CodigoMateria'
			ORDER BY Orden";
			//echo $sql.' 22<br>';
	$RSnotas = mysql_query($sql, $bd) or die(mysql_error());
	$row_notas = mysql_fetch_assoc($RSnotas);
}	



$Ano00[$CodigoMateria][1] = $row_notas["Ano"];


do{
	extract($row_notas);
	if(!$Base){
		$Nota = '';
		$Ano = '';}
		
	if($Mes != 'ET'){
		if($Nota >= 10) {
			$Promedio+=$Nota;
			$FactorPromedio++;
		}
				

$Matriz["$CodigoMateria-".$Orden] 
					= array($Orden,
							$row_notas['Materia'], 
							$row_notas['Nota'], 
							$row_notas['TE'],  
							$row_notas['Mes'],  
							$row_notas['Ano'],  
							$row_notas['Plantel']);
		
	
				?>




  <!--  <?php echo 'no ET = CodigoMateria: '.$CodigoMateria.' - Orden: '.$Orden.''; ?> -->
  <tr>
    <td align="center" class="FondoCampo">
    	<input name="<?php echo $CodigoMateria.'-'.$Orden.'-'; ?>Accion" type="hidden" value="<?php echo $Base?'update':'insert'; ?>" />
    	<input name="<?php echo $CodigoMateria.'-'.$Orden.'-'; ?>Orden" type="hidden" value="<?php echo $Orden ?>" size="3" /><?php echo $Orden ?>
    </td>
    <td class="FondoCampo">
    	<input name="<?php echo $CodigoMateria.'-'.$Orden.'-'; ?>Materia" type="text" value="<?php echo $Materia ?>" size="30" /></td>
    <td align="center" class="FondoCampo">
   	 	<input name="<?php echo $CodigoMateria.'-'.$Orden.'-'; ?>Nota" type="text" value="<?php echo $Nota ?>" size="3" />
    </td>
    <td align="center" class="FondoCampo">
    	<input name="<?php echo $CodigoMateria.'-'.$Orden.'-'; ?>TE" type="text" value="<?php echo $TE ?>" size="3" />
    </td>
    <td align="center" class="FondoCampo">
    	<input name="<?php echo $CodigoMateria.'-'.$Orden.'-'; ?>Mes" type="text" value="<?php echo $Mes ?>" size="3" />
     </td>
     <td align="center" class="FondoCampo">
     	<input name="<?php echo $CodigoMateria.'-'.$Orden.'-'; ?>Ano" type="text" value="<?php echo $Ano ?>" size="3" <?php if($Ano=='') echo ' onfocus="this.value='.$Ano00[$CodigoMateria][1].'"';  ?> />
      </td>
    <td align="center" class="FondoCampo">
    	<input name="<?php echo $CodigoMateria.'-'.$Orden.'-'; ?>Plantel" type="text" value="<?php echo $Plantel ?>" size="3" />
     </td>
    </tr>
  
  
  
  <?php $OrdenUltimo = $Orden; ?>
  <?php } // no TE ?>
  
  
  
  <?php } while($row_notas = mysql_fetch_assoc($RSnotas) ); ?>
<?php $Orden = $OrdenUltimo+1; ?>
  <!--  <?php echo 'extra no ET = CodigoMateria: '.$CodigoMateria.' - Orden: '.$Orden.''; ?> -->
  <tr>
    <td colspan="7" align="left" class="FondoCampo">&nbsp;</td>
    </tr>
  <tr>
   
   
    <td align="center" class="FondoCampo">
    <img src="../../../i/add.png" alt="" width="19" height="19" />
      <input name="<?php echo $CodigoMateria.'-'.$Orden.'-'; ?>Orden" type="hidden" value="<?php echo $Orden ?>" size="3" /><?php echo $Orden ?>
      </td>
    <td class="FondoCampo">
    	<input name="<?php echo $CodigoMateria.'-'.$Orden.'-'; ?>Materia" type="text" value="" size="30" />
    </td>
    <td align="center" class="FondoCampo">
    	<input name="<?php echo $CodigoMateria.'-'.$Orden.'-'; ?>Nota" type="text" value="" size="3" />
    </td>
    <td align="center" class="FondoCampo">
    	<input name="<?php echo $CodigoMateria.'-'.$Orden.'-'; ?>TE" type="text" value="" size="3" />
    </td>
    <td align="center" class="FondoCampo">
    	<input name="<?php echo $CodigoMateria.'-'.$Orden.'-'; ?>Mes" type="text" value="" size="3" />
    </td>
     <td align="center" class="FondoCampo">
     	<input name="<?php echo $CodigoMateria.'-'.$Orden.'-'; ?>Ano" type="text" value="" size="3" <?php if($Ano=='') echo ' onfocus="this.value='.$Ano00[$CodigoMateria][1].'"';  ?> />
     </td>
    <td align="center" class="FondoCampo">
    	<input name="<?php echo $CodigoMateria.'-'.$Orden.'-'; ?>Plantel" type="text" value="" size="3" />
    </td>
    
    </tr>



<?php if ($CodigoMateria==7 or $CodigoMateria==8 or $CodigoMateria==9) { ?>
  <tr>
    <td colspan="7" align="left" class="NombreCampo">Educaci&oacute;n Para el Trabajo</td>
    </tr>
  <tr>
    <td align="center" class="NombreCampo">Curso</td>
    <td align="left" class="NombreCampo">Materia</td>
    <td align="center" class="NombreCampo">Hr/Sem</td>
    <td align="left" class="NombreCampo">&nbsp;</td>
    <td align="left" class="NombreCampo">&nbsp;</td>
    <td align="left" class="NombreCampo">&nbsp;</td>
    <td align="left" class="NombreCampo">&nbsp;</td>
    </tr>
  
  <?php 
  
  	$RSnotas = mysql_query($sql, $bd) or die(mysql_error());
	$row_notas = mysql_fetch_assoc($RSnotas);

  do{
	  extract($row_notas);
	  if($Mes == 'ET'){
  ?>
  <!--  <?php echo 'si ET = CodigoMateria: '.$CodigoMateria.' - Orden: '.$Orden.''; ?> -->
  <tr>
    <td align="center" class="FondoCampo"><?php echo $Orden ?>
      	<input name="<?php echo $CodigoMateria.'-'.$Orden.'-'; ?>Orden" type="hidden" value="<?php echo $Orden ?>" size="3" />
      </td>
    <td class="FondoCampo">
    	<input name="<?php echo $CodigoMateria.'-'.$Orden.'-'; ?>Materia" type="text" value="<?php echo $Materia ?>" size="30" />
    </td>
    <td align="center" class="FondoCampo">
    	<input name="<?php echo $CodigoMateria.'-'.$Orden.'-'; ?>Nota" type="text" value="<?php echo $Nota ?>" size="3" />
    </td>
    <td align="center" class="FondoCampo">&nbsp;</td>
    <td align="center" class="FondoCampo">
    	<input name="<?php echo $CodigoMateria.'-'.$Orden.'-'; ?>Mes" type="hidden" value="ET" size="3" />
    </td>
    <td align="center" class="FondoCampo">&nbsp;</td>
    <td align="center" class="FondoCampo">&nbsp;</td>
    </tr>
  <?php } ?>
  <?php } while($row_notas = mysql_fetch_assoc($RSnotas) ); ?>

  <!--  <?php echo 'extra = CodigoMateria: '.$CodigoMateria.' - Orden: '.++$Orden.''; ?> -->

<?php if ($CodigoMateria=='7' or $CodigoMateria=='8' or $CodigoMateria=='9'){ 
if($Orden<20)
	$Orden=20;
?>
  <tr>
    <td colspan="7" align="left" class="FondoCampo">&nbsp;</td>
    </tr>
  <tr>
    <td align="center" class="FondoCampo"><img src="../../../i/add.png" alt="" width="19" height="19" />
      <input name="<?php echo $CodigoMateria.'-'.$Orden.'-'; ?>Orden" type="hidden" value="<?php echo $Orden ?>" size="3" /><?php echo $Orden ?></td>
    <td class="FondoCampo"><input name="<?php echo $CodigoMateria.'-'.$Orden.'-'; ?>Materia" type="text" value="" size="30" /></td>
    <td align="center" class="FondoCampo"><input name="<?php echo $CodigoMateria.'-'.$Orden.'-'; ?>Nota" type="text" value="" size="3" /></td>
    <td align="center" class="FondoCampo">&nbsp;</td>
    <td align="center" class="FondoCampo"><input name="<?php echo $CodigoMateria.'-'.$Orden.'-'; ?>Mes" type="hidden" value="ET" size="3" /></td>
    <td align="center" class="FondoCampo">&nbsp;</td>
    <td align="center" class="FondoCampo">&nbsp;</td>
    </tr>

  <?php } ?>
  
  
  <?php } ?>
<?php } ?>
  <tr>
    <td colspan="7" align="center"><input type="submit" name="button" id="button" value="Guardar" /></td>
    </tr>
</table>
</form>
<p>&nbsp;</p>
<?php  */

$PlanDeEstudio = explode(':',$PlanDeEstudio); 

?>
<form id="form3" name="form3" method="post" action="">
  <table width="600" border="0" align="center">
    <tr>
      <td colspan="2" class="subtitle">Plan de estudio</td>
    </tr>
    <tr>
      <td width="50%" class="NombreCampo">Pag 1</td>
      <td width="50%" class="FondoCampo">
        <select name="Pag1" id="select">
          <option value="xxx">Seleccione...</option>
          
          <option value="1;Educación Media General;31059;* * * *" <?php 
		  if ($PlanDeEstudio[0] == "1;Educación Media General;31059;* * * *")  
		  echo ' selected="selected"'; ?>>31059 Educaci&oacute;n Media General</option>
          
          <option> -- </option>
          
          <option value="1;Educación Media General;32011;* * * *" <?php 
		  if ($PlanDeEstudio[0] == "1;Educación Media General;32011;* * * *")  
		  echo ' selected="selected"'; ?>>32011 Educaci&oacute;n Media General</option>
          
          <option value="1;III Etapa de Educación Básica;32011;* * * *" <?php 
		  if ($PlanDeEstudio[0] == "1;III Etapa de Educación Básica;32011;* * * *")  
		  echo ' selected="selected"'; ?>>32011 III Etapa de Educaci&oacute;n B&aacute;sica (7-8-9-1-2)</option>
          
          <option value="1;Ciclo Básico Común;32001;* * * *" <?php 
		  if ($PlanDeEstudio[0] == "1;Ciclo Básico Común;32001;* * * *")  
		  echo ' selected="selected"'; ?>>32001 Ciclo B&aacute;sico Com&uacute;n</option>
          
      </select></td>
    </tr>
    <tr>
      <td width="50%" class="NombreCampo">Pag 2</td>
      <td width="50%" class="FondoCampo">
        <select name="Pag2" id="select">
          <option value="xxx">Seleccione...</option>
          
          <option value="2;Educación Media General;31018;Ciencias" <?php 
		  if ($PlanDeEstudio[1] == "2;Educación Media General;31018;Ciencias")  
		  echo ' selected="selected"'; ?>>31018 Educaci&oacute;n Media General</option>
          
          <option value="2;Media Diversificada y Profesional;31018;Ciencias" <?php 
		  if ($PlanDeEstudio[1] == "2;Media Diversificada y Profesional;31018;Ciencias")  
		  echo ' selected="selected"'; ?>>31018 Media Diversificada y Profesional</option>

          <option value="2;Ciclo Diversificado;31018;Ciencias" <?php 
		  if ($PlanDeEstudio[1] == "2;Ciclo Diversificado;31018;Ciencias")  
		  echo ' selected="selected"'; ?>>31018 Ciclo Diversificado</option>
          
      </select></td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <input name="FormaPlanDeEstudio" type="hidden" id="FormaColegios2" value="1" />
      <input type="hidden" name="CodigoAlumno2" value="<?php echo $CodigoAlumno ?>" />        <input type="submit" name="button4" id="button4" value="Guardar plan" /></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
<?php 
if($ColegioNotasCert=='')
	$ColegioNotasCert = '1;1;U.E. Col San Fco. de Asís;Los Palos Grandes;MI:2;1;U.E. Col San Fco. de Asís;Los Palos Grandes;MI:';
	
$Colegios_Observaciones = explode(':|',$ColegioNotasCert); 
$Colegios 				= explode(':',$Colegios_Observaciones[0]); 
$Observaciones 			= explode('|',$Colegios_Observaciones[1]); 

if($FactorPromedio > 0)
	$Promedio = round($Promedio/$FactorPromedio,2);

?>
<form id="form1" name="form1" method="post" action="">
<table width="600" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="5" align="right" valign="middle"><a href="<?php echo $_SERVER['PHP_SELF']."?CodigoAlumno=".$_GET['CodigoAlumno'] ?>">Actualizar <img src="../../../img/Reload.png" width="31" height="27"  /></a></td>
    </tr>
  <tr>
    <td colspan="5" valign="middle" class="subtitle">Colegios</td>
  </tr>
  <tr>
    <td class="NombreCampo">&nbsp;Pag.</td>
    <td class="NombreCampo">&nbsp;No.</td>
    <td class="NombreCampo">&nbsp;Colegio
      <input type="hidden" name="CodigoAlumno" value="<?php echo $CodigoAlumno ?>" />
      <input name="FormaColegio" type="hidden" id="FormaColegios" value="1" />
    </td>
    <td class="NombreCampo">&nbsp;Localidad</td>
    <td class="NombreCampo">&nbsp;E.F.</td>
  </tr>
  <?php 
foreach($Colegios as $Colegio) {
  $Cole  = explode(';',$Colegio); 
  $NumCole++;
  if($Cole[2] > ""){  
 ?> 
  <tr>
    <td class="FondoCampo">
      <input name="<?php echo $NumCole ?>-Pag" type="text" id="textfield" value="<?php echo $Cole[0] ?>" size="2" />
    </td>
    <td class="FondoCampo">
      <input name="<?php echo $NumCole ?>-No" type="text" id="textfield" value="<?php echo $Cole[1] ?>" size="2" />
    </td>
    <td class="FondoCampo">
      <input name="<?php echo $NumCole ?>-Colegio" type="text" id="textfield" value="<?php echo $Cole[2] ?>" size="40" />
    </td>
    <td class="FondoCampo">
      <input name="<?php echo $NumCole ?>-Localidad" type="text" id="textfield" value="<?php echo $Cole[3] ?>" size="30" />
    </td>
    <td class="FondoCampo"><input name="<?php echo $NumCole ?>-Entidad" type="text" id="textfield" value="<?php echo $Cole[4] ?>" size="5" /></td>
  </tr>
  <?php }} 
if(true){?>
  <tr>
    <td class="FondoCampo">
      <input name="<?php echo $NumCole ?>-Pag" type="text" id="textfield"  size="2" />
    </td>
    <td class="FondoCampo">
      <input name="<?php echo $NumCole ?>-No" type="text" id="textfield" size="2" />
    </td>
    <td class="FondoCampo">
      <input name="<?php echo $NumCole ?>-Colegio" type="text" id="textfield" size="40" />
    </td>
    <td class="FondoCampo">
      <input name="<?php echo $NumCole ?>-Localidad" type="text" id="textfield" size="30" />
    </td>
    <td class="FondoCampo"><input name="<?php echo $NumCole ?>-Entidad" type="text" id="textfield" size="5" /></td>
  </tr>
<?php } ?>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="subtitle">Observaciones</td>
    </tr>
  <tr>
    <td colspan="2" align="right" class="NombreCampo">Pag 1</td>
    <td colspan="3" class="FondoCampo"><label for="textfield2"></label>
      <textarea name="Observ1" cols="80" rows="4" id="textfield2"><?php echo $Observaciones[0] ?></textarea></td>
    </tr>
  <tr>
    <td colspan="2" align="right" class="NombreCampo">Pag 2</td>
    <td colspan="3" class="FondoCampo"><textarea name="Observ2" cols="80" rows="4" id="textfield3"><?php echo $Observaciones[1] ?></textarea></td>
    </tr>
  <tr>
    <td colspan="5" align="center"><input type="submit" name="button2" id="button2" value="Guardar Colegio y Observ" /></td>
    </tr>
</table></form>
<? 

//echo "<pre>";

//var_dump($Matriz); ?>



<?php include $_SERVER['DOCUMENT_ROOT']."/inc/Footer_info.php"; ?>

</body>
</html>