<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcadXXX,AsistDireccion,admin,secreBach";
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


if(isset($_GET["Cursos"])){
	setcookie("Cursos",$_GET["Cursos"]);
	header("Location: ".$_SERVER['PHP_SELF']);
}
elseif(isset($_POST["Cursos"])){
	setcookie("Cursos",$_POST["Cursos"]);
	$_Cursos = $_POST["Cursos"];
}
else{
	$_Cursos = $_COOKIE["Cursos"];
}


if(isset($_GET["CodigoAlumno"])){
	setcookie("CodigoAlumno",$_GET["CodigoAlumno"]);
	header("Location: ".$_SERVER['PHP_SELF']);
}
elseif(isset($_POST["CodigoAlumno"])){
	setcookie("CodigoAlumno",$_POST["CodigoAlumno"]);
	$_CodigoAlumno = $_POST["CodigoAlumno"];
}
else{
	$_CodigoAlumno = $_COOKIE["CodigoAlumno"];
}


$Alumno = new Alumno($_CodigoAlumno,$AnoEscolar);
$AlumnoXCurso = new AlumnoXCurso();
$_CodigoCurso = $Alumno->CodigoCurso();


if(isset($_GET["CodigoCurso"])){
	setcookie("CodigoCurso",$_GET["CodigoCurso"]);
	$_CodigoCurso = $_GET["CodigoCurso"];
	header("Location: ".$_SERVER['PHP_SELF']);
}
else{
	$_CodigoCurso = $_COOKIE["CodigoCurso"];
}






if (!$sw_activ){
	echo "<pre>";
	var_dump($_POST);
	echo "</pre>";
}

/*
if (isset($_GET['CodigoAlumno'])){
	$_CodigoAlumno = $_GET['CodigoAlumno'];
	}
*/



if(isset($_POST['CambiaAlumno'])){
	header("Location: ".$_SERVER['PHP_SELF']."?CodigoAlumno=".$_POST['CodigoAlumno']);
}

if($_CodigoAlumno > 1){
	$query_RS_Alumno = "SELECT * FROM Alumno 
						WHERE CodigoAlumno = '$_CodigoAlumno' ";
	
	$RS = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
	$row = mysql_fetch_assoc($RS);
	extract($row);	


	if($PlanDeEstudio == ""){
		$PlanDeEstudio = '1;Educación Media General;31059;* * * *:2;Educación Media General;31018;Ciencias:';
		$sql = "UPDATE Alumno SET PlanDeEstudio = '$PlanDeEstudio'
				WHERE CodigoAlumno = '$_CodigoAlumno'";
		if ($sw_activ)
			$mysqli->query($sql);
		else
			echo "<pre>".$sql."</pre>";
		header("Location: ".$_SERVER['PHP_SELF']."?CodigoAlumno=".$_CodigoAlumno);
	}

}

if(isset($_POST['FormaPlanDeEstudio'])){
	$PlanDeEstudio = $_POST['Pag1'].":".$_POST['Pag2'].":";
	$sql = "UPDATE Alumno
			SET PlanDeEstudio = '$PlanDeEstudio'
			WHERE CodigoAlumno = $_CodigoAlumno";
	if ($sw_activ)
		$mysqli->query($sql);
	else
		echo "<pre>".$sql."</pre>";
	header("Location: ".$_SERVER['PHP_SELF']."?CodigoAlumno=".$_GET['CodigoAlumno']);
}

if(isset($_POST['FormaColegio']) and ($MM_UserGroup = 91 or $MM_UserGroup = 95 or $MM_UserGroup = "secreBach" or $CodigoCurso < 43)){
	do{
		$i++;
		if($_POST[$i.'-Colegio']>'')
		$UpdateAlum .= $_POST[$i.'-Pag'].';'.$_POST[$i.'-No'].';'.$_POST[$i.'-Colegio'].';'.$_POST[$i.'-Localidad'].';'.$_POST[$i.'-Entidad'].':';
	} while ($_POST[$i.'-Colegio']>'');
	$UpdateAlum .= ';'.';'.';'.';'.':';
	
	$UpdateAlum .= '|'.$_POST['Observ1'].'|'.$_POST['Observ2'];
	
$sqlUpdateAlumno = " UPDATE Alumno
 					 SET ColegioNotasCert = '$UpdateAlum'
					 WHERE CodigoAlumno = $_CodigoAlumno";

	if ($sw_activ)
		$mysqli->query($sqlUpdateAlumno);
	else
		echo "<pre>".$sqlUpdateAlumno."</pre>";


	header("Location: ".$_SERVER['PHP_SELF']."?CodigoAlumno=".$_CodigoAlumno);
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
					$sql .= "($_CodigoAlumno, '$CodigoMateria', "
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
												$_POST[$pref.'Mat'], 
												$_POST[$pref.'Nota'], 
												$_POST[$pref.'TE'],  
												$_POST[$pref.'Mes'],  
												$_POST[$pref.'Ano'],  
												$_POST[$pref.'Plantel']);
				
				
				//echo "<pre>deleting ".$CodigoMateriaAnterioeres ."  =?  ".
		//			substr_count($CodigoMateriaAnterioeres,"--".$CodigoMateria."--")."   ".$CodigoMateria."</pre>";	
				
											
				if (substr_count($CodigoMateriaAnterioeres,"--".$CodigoMateria."--") == 1){
					$SQLaux = "DELETE FROM Notas_Certificadas 
								WHERE CodigoAlumno = '$_CodigoAlumno'
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
<link rel="stylesheet" type="text/css" href="/css/estilosFinal.css"/>
<link rel="stylesheet" type="text/css" href="/css/tabla.css"/>

<style>
table.position_fixed{
	position: fixed;
	left: 5px;
	box-shadow:5px 5px 5px grey;
	}
</style>


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

if ($_Cursos == "45")
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
			<table width="800" align="center">
			<tr><?php 
	//if($Deuda_Actual > 26000 and $MM_Username != "piero" ){
		?><td align="right">Deuda Pendiente: <?php echo Fnum($Deuda_Actual); ?>&nbsp;</td><?php //}
		//else{  ?> 
	<td align="center"><p><a href="PDF/Nota_Certificada.php?Promedia=1&amp;CodigoAlumno=<?php echo $_CodigoAlumno ?>" target="_blank"><img src="../../../i/printer.png"  width="32" height="32" /> <br />
	  con promedio
	  </a></p>
	  <p><a href="PDF/Nota_Certificada_anterior.php?Promedia=1&amp;CodigoAlumno=<?php echo $_CodigoAlumno ?>" target="_blank">Forma Vieja</a><br />
	  </p></td>
	<td align="center"><p><a href="PDF/Nota_Certificada.php?CodigoAlumno=<?php echo $_CodigoAlumno ?>" target="_blank"><img src="../../../i/printer.png" alt=""  width="32" height="32" /> <br />
	  sin promedio</a></p>
	  <p><a href="PDF/Nota_Certificada_anterior.php?CodigoAlumno=<?php echo $_CodigoAlumno ?>" target="_blank">Forma Vieja</a></p></td>
<?php //} ?>
	<td align="right">&nbsp;</td>
	<td align="right">&nbsp;</td>
	<td align="right"><a href="Nota_Final.php?CodigoAlumno=<?php echo $_CodigoAlumno ?>" target="_blank">calc def </a></td>
	<td align="right"><a href="Nota_Certificada.php?Cursos=123">123</a> | <a href="Nota_Certificada.php?Cursos=45">IV V</a></td>
	</tr>
		</table>
		</div>
	</div>
  
  
<div class="row">
	<div class="col-md-3">
 
<!-- MENU ALUMNOS -->    		    		
<div class="table">
	<div class="caption subtitle">
		Alumnos <? echo $_CodigoAlumno; ?>
	</div>
	<div class="tr">
		<span class="td NombreCampo">
			No
		</span>
		<span class="td NombreCampo">
			Apellido Nombre
		</span>
	</div>
<?
	
	 $AlumnosDelCurso = $AlumnoXCurso->view($_CodigoCurso);
	 while( $row = $AlumnosDelCurso->fetch_assoc()){
		 ?><div class="tr"><?
		 
		extract($row);
		$Alumno->id = $CodigoAlumno;
			
		 ?><span class="td"><span class="seleccionado"><?
		 echo $CodigoAlumno;
		 ?></span></span><? 
		 
		 ?><span class="td">
		 <a href="<? echo $php_self . "?CodigoAlumno=" . $CodigoAlumno ?>"><?
		 echo $Alumno->Apellido()." ".$Alumno->Nombre()
			 ?></a></span><? 
		 
		 ?></div><?
	 }  
	 ?>

	</div>
	
</div>
    		
		
	<div class="col-md-9">		
		
<!-- NOTAS RESUMEN FINAL -->
<? $Alumno->id = $_CodigoAlumno; ?>
<div class="row">		
	<div class="col-md-12">
	<? echo $Alumno->ApellidosNombres() ?>
	</div>
</div>		
<div class="row">		
<div class="col-md-9">
   			
			<?
	// Notas de resumen final 	
			$sql = "SELECT * FROM Nota 
				WHERE CodigoAlumno = '$_CodigoAlumno'
				AND Lapso = 'Def_Ministerio'
				ORDER BY Ano_Escolar";
			//echo $sql;

			$RS_Def_Ministerio = $mysqli->query($sql);	
			if($RS_Def_Ministerio->num_rows > 0)	
				$row_Def_Ministerio = $RS_Def_Ministerio->fetch_assoc()	;				 
				?>
   			
   			<div class="table">
				<div class="caption subtitle">
						notas Def_Mnisterio
				</div>
			<? if($RS_Def_Ministerio->num_rows > 0){ ?>	
			 <div class="tr NombreCampo">
			 <?
				 foreach($row_Def_Ministerio as $campo => $valor){
					 ?><span class="td NombreCampo"><?
						
					 echo $campo;
					 
					 ?></span><? 
				 }  
				 ?>
				
			</div>
			
			
			
			 
   			<?
		
		
		// Notas de resumen final 		
		do {
			?><div class="tr"><?
			foreach($row_Def_Ministerio as $campo => $valor){
				 ?><span class="td"><?
					if($campo == "CodigoCurso")
						echo Curso($valor);
					else
						echo $valor;
				
				?></span><?
			} 
			?></div><?
		}while($row_Def_Ministerio = $RS_Def_Ministerio->fetch_assoc());
								 
	
}
		?>
			
    </div>
		
		
		
		
		
  </div>
</div>
	
	

	








<!-- NOTAS POR CURSO -->
<? 
$CodigoMaterias = array('7','8','9','IV','V');

if ($_Cursos == "45")
	$CodigoMaterias = array('IV','V');
else
	$CodigoMaterias = array('7','8','9');

	  
foreach ($CodigoMaterias as $CodigoMate){
?> 
    <div class="row">
    	<?php 
			foreach (array("n") as $n){  // "",    ?>
            <div class="col-md-9">
                <? //$CodigoMate.$n ?>
                

                
<!-- TITULOS GRUPOS -->                                                
<div class="table">
	<div class="caption subtitle">
		<?= $CodigoMate//.$n ?>
	</div>
	<div class="tr NombreCampo">
		<span class="td NombreCampo">No</span>
		<span class="td NombreCampo">Materia</span>
		
		<!--span class="td NombreCampo">CI Prof</span>
		<span class="td NombreCampo">Origen</span-->
		<? if($_CodigoAlumno == 1){ ?>
			<span class="td NombreCampo">Mat</span>
			<span class="td NombreCampo">Ci Prof</span>
		<? }
		else { ?>
		<span class="td NombreCampo">Nota</span>
		<? } ?>
		<span class="td NombreCampo"><div onclick="RepiteCampo('<?= $CodigoMate.$n ?>','<?= $CodigoMate ?>','TE');" >TE <img src="../../../i/control_repeat_blue.png" width="16" height="16" alt=""/></div></span>
		<span class="td NombreCampo"><div onclick="RepiteCampo('<?= $CodigoMate.$n ?>','<?= $CodigoMate ?>','Mes');" >Mes <img src="../../../i/control_repeat_blue.png" width="16" height="16" alt=""/></div></span>
		<span class="td NombreCampo"><div onclick="RepiteCampo('<?= $CodigoMate.$n ?>','<?= $CodigoMate ?>','Ano');" >Ano <img src="../../../i/control_repeat_blue.png" width="16" height="16" alt=""/></div></span>
		<span class="td NombreCampo">Plantel</span>
	</div>
	
	
	
	
	
	 <? 
				
									   
$sql = "SELECT * FROM Notas_Certificadas 
		WHERE CodigoAlumno = '$_CodigoAlumno'  
		AND Grado = '".$CodigoMate.$n."'
		AND Orden < 20
		ORDER BY Orden"; 
		//echo $sql.' 101<br>';
$RS = $mysqli->query($sql); // Busca notas/materias del alumno
if ($RS->num_rows == 0) { // si no existen cargar
	 $sql = "SELECT * FROM Notas_Certificadas 
			WHERE CodigoAlumno = '1'  
			AND Grado = '".$CodigoMate.$n."'
			AND Orden < 20
			ORDER BY Orden"; 
			//echo $sql.' 101<br>';
	$RS = $mysqli->query($sql);
	}

$Orden_aux = 0;
while ($row = $RS->fetch_assoc()){
	$Orden_aux++;
	extract($row);
	$Orden = $Orden_aux;
	$script = $Sumatoria = $ConteoProm = $Promedio = "";
	if($Materia > "") {
	if ($n == "n" and strlen($NotaOrigen) > 0 ){
		
		$Prom = explode("-",$NotaOrigen);
		foreach ($Prom as $valor){
			$Sumatoria +=  $MatrizNotas[$CodigoMate][$valor];
			$ConteoProm++;
			}
		$Promedio = round( $Sumatoria / $ConteoProm ,0);
		
		//$script = ' onclick="this.value='.$Promedio.'" ';
		}
	elseif ($n != "n") {
		$MatrizNotas[$CodigoMate][$Orden] = $Nota;
		}

	if ($Nota == "" and $Promedio > ""){
		$Nota = $Promedio;
		}
 ?>   
 <!-- MATERIAS MENOR A ORDEN 20 -->  
	<div class="tr ">
		<span class="td"><?= $Orden ?><? Campo($CodigoMate.$n."-$Orden-Orden",'h',$Orden,30)  ?></span>
		<span class="td"><? Campo($CodigoMate.$n."-$Orden-Materia",$Tipo,$Materia,30)  ?></span>
		<!--span class="td"></span>
		<span class="td"><? if ($n == "n") Campo($CodigoMate.$n."-$Orden-CiProf",$Tipo,$CiProf,10)  ?></span>
		<span class="td"><? if ($n == "n") Campo($CodigoMate.$n."-$Orden-NotaOrigen",$Tipo,$NotaOrigen,5)  ?></span-->
		<span class="td">
			<? if($_CodigoAlumno == 1){ ?>
				<? if ($n == "n") Campo($CodigoMate.$n."-$Orden-Mat",$Tipo,$Mat,5)  ?>
				<? if ($n == "n") Campo($CodigoMate.$n."-$Orden-CiProf",$Tipo,$CiProf,10)  ?>
			<? }
			else { ?>
			<? Campo($CodigoMate.$n."-$Orden-Nota",$Tipo,$Nota,5,$script)  ?>
			<? } ?>
		</span>
		<span class="td"><? Campo($CodigoMate.$n."-$Orden-TE",$Tipo,$TE,5) ?></span>
		<span class="td"><? Campo($CodigoMate.$n."-$Orden-Mes",$Tipo,$Mes,5)  ?></span>
		<span class="td"><? Campo($CodigoMate.$n."-$Orden-Ano",$Tipo,$Ano,5)  ?></span>
		<span class="td"><? Campo($CodigoMate.$n."-$Orden-Plantel",$Tipo,$Plantel,5)  ?></span>
	</div>
	 <? }
} ?>
	

 <!-- MATERIAS MENOR A ORDEN 20 NUEVA --> 		
	<div class="tr ">
		<span class="td"><?= ++$Orden ?><? Campo($CodigoMate.$n."-$Orden-Orden",'h',$Orden,30)  ?></span>
		<span class="td"><? Campo($CodigoMate.$n."-$Orden-Materia",$Tipo,"",30)  ?></span>
		<!--span class="td"></span>
		<span class="td"><? if ($n == "n") Campo($CodigoMate.$n."-$Orden-CiProf",$Tipo,"",10)  ?></span>
		<span class="td"><? if ($n == "n") Campo($CodigoMate.$n."-$Orden-NotaOrigen",$Tipo,"",5)  ?></span-->
		
		<span class="td">
			<? if($_CodigoAlumno == 1){ ?>
				<? if ($n == "n") Campo($CodigoMate.$n."-$Orden-Mat",$Tipo,"",5)  ?>
				<?  Campo($CodigoMate.$n."-$Orden-CiProf",$Tipo,"",10)  ?>
			<? }
			else { ?>
			<? Campo($CodigoMate.$n."-$Orden-Nota",$Tipo,"",5,$script)  ?>
			<? } ?>
		</span>
		
		
		<span class="td"><? Campo($CodigoMate.$n."-$Orden-TE",$Tipo,$TE,5) ?></span>
		<span class="td"><? Campo($CodigoMate.$n."-$Orden-Mes",$Tipo,"",5)  ?></span>
		<span class="td"><? Campo($CodigoMate.$n."-$Orden-Ano",$Tipo,"",5)  ?></span>
		<span class="td"><? Campo($CodigoMate.$n."-$Orden-Plantel",$Tipo,"",5)  ?></span>
	</div>
	
	
	
	
	
	<? 
 $sql = "SELECT * FROM Notas_Certificadas 
		WHERE CodigoAlumno = '$_CodigoAlumno'  
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
	
	?>       
<!-- MATERIAS MAYOR IGUAL A ORDEN 20 --> 
        <div class="tr ">
          <span class="td"><?= $Orden ?>
          	  <? Campo($CodigoMate.$n."-$Orden-Orden",'h',$Orden,30)  ?></span>
          <span class="td"><? Campo($CodigoMate.$n."-".$Orden."-Materia",$Tipo,$Materia,30)  ?></span>
          <!--span class="td">&nbsp;</span>
          <span class="td">&nbsp;</span>
          <span class="td"><? if ($n == "n") Campo($CodigoMate.$n."-$Orden-Nota",$Tipo,$Nota,5,$script)  ?></span-->
          
          <span class="td">
			<? if($_CodigoAlumno == 1){ ?>
				<?  Campo($CodigoMate.$n."-$Orden-CiProf",$Tipo,$CiProf,10)  ?>
			<? }
			else { ?>
			<? Campo($CodigoMate.$n."-$Orden-Nota",$Tipo,"$Nota",5,$script)  ?>
			<? } ?>
		</span>
		
          
          <span class="td">&nbsp;</span>
          <span class="td"><? Campo($CodigoMate.$n."-".$Orden.'-Mes',"h","ET",5)  ?></span>
          <span class="td">&nbsp;</span>
          <span class="td">&nbsp;</span>
        </div>
 <? } ?>     
 
 		
 		<? if($Orden < 20)
			$Orden = 19; ?>
			
 <!-- MATERIAS MAYOR IGUAL A ORDEN 20 NUEVA -->
 		<div class="tr ">
          <span class="td"><?= ++$Orden ?>
          	  <? Campo($CodigoMate.$n."-$Orden-Orden",'h',$Orden,30)  ?></span>
          <span class="td"><? Campo($CodigoMate.$n."-".$Orden."-Materia",$Tipo,"",30)  ?></span>
          <!--span class="td">&nbsp;</span>
          <span class="td">&nbsp;</span>
          <span class="td"><? if ($n == "n") Campo($CodigoMate.$n."-$Orden-Nota",$Tipo,"",5)  ?></span-->
          <span class="td">
			<? if($_CodigoAlumno == 1){ ?>
				<?  Campo($CodigoMate.$n."-$Orden-CiProf",$Tipo,"",10)  ?>
			<? }
			else { ?>
			<? Campo($CodigoMate.$n."-$Orden-Nota",$Tipo,"",5,$script)  ?>
			<? } ?>
		</span>
		<span class="td">&nbsp;</span>
          <span class="td"><? Campo($CodigoMate.$n."-".$Orden.'-Mes',"h","ET",5)  ?></span>
          <span class="td">&nbsp;</span>
          <span class="td">&nbsp;</span>
        </div>
	
	
	
	
	
</div>    
            
                
                
<!--             
                
<table width="100%" >
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
		WHERE CodigoAlumno = '$_CodigoAlumno'  
		AND Grado = '".$CodigoMate.$n."'
		AND Orden < 20
		ORDER BY Orden"; 
		//echo $sql.' 11<br>';
$RS = $mysqli->query($sql); // Busca notas/materias del alumno
if ($RS->num_rows == 0) { // si no existen cargar
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
	$script = $Sumatoria = $ConteoProm = $Promedio = "";
	if($Materia > "") {
	if ($n == "n" and strlen($NotaOrigen) > 0 ){
		
		$Prom = explode("-",$NotaOrigen);
		foreach ($Prom as $valor){
			$Sumatoria +=  $MatrizNotas[$CodigoMate][$valor];
			$ConteoProm++;
			}
		$Promedio = round( $Sumatoria / $ConteoProm ,0);
		
		//$script = ' onclick="this.value='.$Promedio.'" ';
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
		WHERE CodigoAlumno = '$_CodigoAlumno'  
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
    </table>
           
 -->         
          
          
           
            </div>
            
        <? } ?>
	</div>
<? } ?>    
    
    
    

<input type="hidden" name="FormaNotas" value="1" />
<input type="submit" name="button2" id="button2" value="Guardar" />
</form>











<hr />

<form id="form2" name="form2" method="post" action="">
 
  <table width="800" align="center" cellpadding="2" cellspacing="2">
    <tr>
      <td align="center"><input name="CodigoAlumno" type="text" id="CodigoAlumno" value="<?php echo $_CodigoAlumno; ?>" /><input name="CambiaAlumno" type="hidden" value="1" />
  <input type="submit" name="button3" id="button3" value="Submit" /></td>
    </tr>
  </table>
</form>
<?php 


$Promedio = 0;
$FactorPromedio=0;

//var_dump($MatrizNotas);

	
	
	
	
	
	
	
	
	
	
	
	
	
	

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
      <input type="hidden" name="CodigoAlumno2" value="<?php echo $_CodigoAlumno ?>" />        <input type="submit" name="button4" id="button4" value="Guardar plan" /></td>
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
    <td colspan="5" align="right" valign="middle"><a href="<?php echo $_SERVER['PHP_SELF']."?CodigoAlumno=".$_CodigoAlumno ?>">Actualizar <img src="../../../img/Reload.png" width="31" height="27"  /></a></td>
    </tr>
  <tr>
    <td colspan="5" valign="middle" class="subtitle">Colegios</td>
  </tr>
  <tr>
    <td class="NombreCampo">&nbsp;Pag.</td>
    <td class="NombreCampo">&nbsp;No.</td>
    <td class="NombreCampo">&nbsp;Colegio
      <input type="hidden" name="CodigoAlumno" value="<?php echo $_CodigoAlumno ?>" />
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