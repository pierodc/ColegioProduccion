<?
//$MM_authorizedUsers = "2,99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable,provee";
$SW_omite_trace = false;
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado


if(strlen($_GET["CodigoAlumno"]) > 10 ){
	$CodigoAlumno = $_GET["CodigoAlumno"];
}
$Canal = $_GET["Canal"];



$Alumno = new Alumno($CodigoAlumno);
$CodigoAlumno = $Alumno->id;

$Consulta = new Consulta();


$sql = "SELECT * FROM Voto_Respuesta 
		WHERE id_alumno = '".$CodigoAlumno."'
		AND id_pregunta = '1'";
$RS = $mysqli->query($sql);
if($row = $RS->fetch_assoc()){
	$Respuesta = $row['Respuesta'];
	$id = $row['id'];
	}
else{
	$sql = "INSERT INTO Voto_Respuesta 
			SET Respuesta = 'Asistio',
			id_alumno = '".$CodigoAlumno."',
			id_pregunta = '1',
			Observaciones = '$Canal'";
	$mysqli->query($sql);
}


if(isset($_POST['Voto']) ){
	
	//var_dump($_POST);
	
	if($id > 0){
		$sql = "UPDATE Voto_Respuesta 
				SET Respuesta = '". $_POST['Voto'] ."', 
				Fecha_Modificacion = NOW(),
				Observaciones = '$Canal'
				WHERE id_alumno = '".$CodigoAlumno."'
				AND id_pregunta = '1'";
	}
	else{
		$sql = "INSERT INTO Voto_Respuesta 
				SET Respuesta = '". $_POST['Voto'] ."',
				id_alumno = '".$CodigoAlumno."',
				id_pregunta = '1',
				Observaciones = '$Canal'";
	}
	
	//echo $sql;
	$mysqli->query($sql);
	header("Location: ".$php_self."?Voto=ok&CodigoAlumno=".$_GET['CodigoAlumno']);
	
}

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
	font-size:18px;
	<? 
	//if($MM_UserGroup <> "Coordinador")
	if(isset($_GET['Voto']) ) { 
		echo 'background-color:#95FFD9;';
	}
	else{
		echo 'background-color:#FFF8CC;';
		
	}
	
	?>
	
}
input{
	font-size:16px;
	font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
	font-style: normal;
	
	}
input[type=radio] {
    border: #2757FFpx;
    width: 80%;
    height: 2em;
}	
td {
	font-size:18px;
	font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
	font-style: normal;
	}
	
body,td,th {
	font-family: Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
}
</style>


    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    </head>
    <body  >
    <? if(isset($_GET['Voto']) or $Respuesta == "Si") {  ?>
    <h3>Muchas gracias por su participaci&oacute;n</h3>
    <? } else {  ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td align="right">
<form name="form1" method="post" id="ismForm" action="" >
    <?php 


if($MM_UserGroup == "2" or true)
	$JavaScript =  'onClick="this.form.submit()"';



?>
    <table width="80%" align="center" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td nowrap><label>
        <input name="Voto" type="radio" id="RadioGroup1_0"  value="Si" <?= $Respuesta == "Si"?"checked":""; ?>  <?= $JavaScript ?> >
        Si&nbsp;&nbsp;
        <input name="id_Alumno" value="<?= $_GET["CodigoAlumno"] ?>" type="hidden">
      </label></td>
      <td width="50%" nowrap>&nbsp;</td>
      <td nowrap><label>
        <input type="radio" name="Voto" value="No" id="RadioGroup1_1" <?= $Respuesta == "No"?"checked":""; ?> <?= $JavaScript ?> >
        No&nbsp;&nbsp;</label></td>
     
    </tr>
  </table>
</form>

<?  ?>
</td>
    </tr>
  </tbody>
</table><? } ?><?
		
echo $Consulta->Respuesta($CodigoAlumno , 1);		
		
		
		?>