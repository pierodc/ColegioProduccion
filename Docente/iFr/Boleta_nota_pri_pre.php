<?
$MM_authorizedUsers = "";
$SW_omite_trace = true;
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado


if(isset($_GET['Lapso'])){
	$Lapso = $_GET['Lapso'];}
else {
	$Lapso = 2;}
	

if(isset($_GET['Promedio'])){
	echo $_GET['Promedio'];
	}
else{
	
require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
//extract($_POST);
//echo "Nota: ".$_POST['Nota']." ) ";

$sql = "SELECT * FROM Boleta_Nota 
		WHERE CodigoAlumno = '".$_GET['CodigoAlumno']."'
		AND Codigo_Indicador = '".$_GET['Codigo_Indicador']."'
		AND Ano = '$AnoEscolar'
		AND Lapso = '$Lapso'";
$RS = $mysqli->query($sql);
if($row = $RS->fetch_assoc()){
	$Nota = $row['Nota'];
	$CodigoExistente = $row['Codigo'];
	}

if($MM_UserGroup <> "Coordinador")
if(isset($_POST['Nota']) ){
	if( $CodigoExistente > 0) {
		$sql = "UPDATE Boleta_Nota 
				SET Nota = '".$_POST['Nota']."'
				WHERE CodigoAlumno = '".$_GET['CodigoAlumno']."'
				AND Codigo_Indicador = '".$_GET['Codigo_Indicador']."'
				AND Ano = '$AnoEscolar'
				AND Lapso = '$Lapso'";
		$mysqli->query($sql);
	}
	else{
		$sql = "INSERT INTO Boleta_Nota 
				SET Nota = '".$_POST['Nota']."',
				CodigoAlumno = '".$_GET['CodigoAlumno']."',
				Codigo_Indicador = '".$_GET['Codigo_Indicador']."',
				Ano = '$AnoEscolar',
				Lapso = '$Lapso'";
		$mysqli->query($sql);
		}
//header("Location: ".$php_self."?CodigoAlumno=".$_GET['CodigoAlumno']."&Codigo_Indicador=".$_GET['Codigo_Indicador']."&EscalaNota=".$_GET['EscalaNota']);
}
//echo $sql."<BR>";	

$sql = "SELECT * FROM Boleta_Nota 
		WHERE CodigoAlumno = '".$_GET['CodigoAlumno']."'
		AND Codigo_Indicador = '".$_GET['Codigo_Indicador']."'
		AND Ano = '$AnoEscolar'
		AND Lapso = '$Lapso'";
		//echo $sql;
$RS = $mysqli->query($sql);
if($row = $RS->fetch_assoc()){
	$Nota = $row['Nota'];
	$CodigoExistente = $row['Codigo'];
	}

//echo $sql."<BR>";	
?>
<html>
    <head>
    <script type="text/javascript">
    function submitForm() { // submits form
        document.getElementById("ismForm").submit();
    }
    function btnSearchClick()
    {
        if (document.getElementById("ismForm")) {
            setTimeout("submitForm()", 1000); // set timout 
       }
    }
    </script>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px; 
	font-size:10px;
	<? 
	if($MM_UserGroup <> "Coordinador")
		if(isset($_POST['Nota']) and $_POST['Nota']>"") { 
			echo 'background-color:#95FFD9;';}?>
	
}
input{
	font-size:11px;
	}
td {
	font-size:12px;
	}
	
</style>

<? /*/if(isset($_POST['Nota']) and $_POST['Nota']>"") {  ?>
<script>
$( "#Def_Mat2" ).load( "Boleta_nota_pri_pre.php?Promedio=333" );
</script>
<? //}*/ ?>

    </head>
    <body  >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td align="right">
<form name="form1" method="post" id="ismForm" action="" >
<?php 

if($_GET['EscalaNota']==5){ 
if($MM_UserGroup <> "Coordinador")
	$JavaScript =  'onClick="this.form.submit()"';



?><table width="200" align="right" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td nowrap><label>
        <input name="Nota" type="radio" id="RadioGroup1_0"  value="1" <?= $Nota=="1"?"checked":""; ?>  <?= $JavaScript ?> >Ne&nbsp;&nbsp;</label></td>
      <td nowrap><label>
        <input type="radio" name="Nota" value="2" id="RadioGroup1_1" <?= $Nota=="2"?"checked":""; ?> <?= $JavaScript ?> >I&nbsp;&nbsp;</label></td>
      <td nowrap><label>
        <input type="radio" name="Nota" value="3" id="RadioGroup1_2" <?= $Nota=="3"?"checked":""; ?> <?= $JavaScript ?> >Pi&nbsp;&nbsp;</label></td>
      <td nowrap><label>
        <input type="radio" name="Nota" value="4" id="RadioGroup1_3" <?= $Nota=="4"?"checked":""; ?> <?= $JavaScript ?> >Pa&nbsp;&nbsp;</label></td>
      <td nowrap><label>
        <input type="radio" name="Nota" value="5" id="RadioGroup1_4" <?= $Nota=="5"?"checked":""; ?> <?= $JavaScript ?> >C&nbsp;&nbsp;</label></td>
      <td nowrap><label>
        <input type="radio" name="Nota" value="" id="RadioGroup1_5" <?= $JavaScript ?> >=>()</label></td>
    </tr>
  </table><? }else{ ?><table border="0" cellspacing="2" cellpadding="0">
  <tbody>
    <tr>
      <td><? //echo $Nota ?><input name="Nota" type="text" id="Nota" onKeyUp="btnSearchClick();" value="<?= $Nota ?>" size="5"></td>
    </tr>
  </tbody>
</table><? }  // this.form.submit(); ?>
</form>
</td>
    </tr>
  </tbody>
</table><? } ?>