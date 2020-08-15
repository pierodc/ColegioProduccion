<?php
$MM_authorizedUsers = "99,91,95,90,secreAcad,secre,AsistDireccion,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');


if (isset($_POST['Buscar']) or isset($_GET['Buscar'])) {
	
	$aux = strtolower($_POST['Buscar'].$_GET['Buscar']." ");
	//echo $aux;
	$aux = explode(" ",$aux);
	
	
	$query_RS_Alumnos  = "SELECT * FROM Alumno WHERE "; 
	if($aux[0]>0 and $aux[0]<99999){
		$query_RS_Alumnos .= " CodigoAlumno = '$aux[0]' ";
	}else{
		$query_RS_Alumnos .= " ";
		$query_RS_Alumnos .= " LOWER(CONCAT_WS(' ',CodigoAlumno,Nombres,Nombres2,Apellidos,Apellidos2,SMS_Caja)) LIKE '%$aux[0]%'";
		if($aux[1]!=""){$query_RS_Alumnos .= " AND LOWER(CONCAT_WS(' ',CodigoAlumno,Nombres,Nombres2,Apellidos,Apellidos2,SMS_Caja)) LIKE '%$aux[1]%'";}
		if($aux[2]!=""){$query_RS_Alumnos .= " AND LOWER(CONCAT_WS(' ',CodigoAlumno,Nombres,Nombres2,Apellidos,Apellidos2,SMS_Caja)) LIKE '%$aux[2]%'";}
		if($aux[3]!=""){$query_RS_Alumnos .= " AND LOWER(CONCAT_WS(' ',CodigoAlumno,Nombres,Nombres2,Apellidos,Apellidos2,SMS_Caja)) LIKE '%$aux[3]%'";}
		$query_RS_Alumnos .= " ORDER BY Alumno.Creador, Alumno.Apellidos, Alumno.Apellidos2, 
								Alumno.Nombres, Alumno.Nombres2";
	}
	
echo $query_RS_Alumnos;
	$RS_Alumnos = mysql_query($query_RS_Alumnos, $bd) or die(mysql_error());
	$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
	$totalRows_RS_Alumnos = mysql_num_rows($RS_Alumnos);
} 


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">


<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
 
<title>Administraci&oacute;n SFDA</title>
<link href="/estilos.css" rel="stylesheet" type="text/css" />
<link href="/estilos2.css" rel="stylesheet" type="text/css" />

<script src="/SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="/SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="/SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />

<script src="/SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="/SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="/SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="/SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />

<script src="/SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="/SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />

<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>

<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>


</head>
<body onLoad="Buscar.focus()">
<div class="container-fluid">
  
  
  
  <div class="row">
    <?php $TituloPantalla ="Alumnos";
	require_once($_SERVER['DOCUMENT_ROOT'] .'/intranet/a/TitAdmin.php'); ?>
  </div>
  
  
  
  
  <form class="form-inline">
<fieldset>

<!-- Form Name -->
<legend></legend>


<!-- Search input-->
<div class="form-group">
  <label class="col-md-2 control-label" for="Buscar">Buscar</label>
  <div class="col-md-4">
    <input id="Buscar" name="Buscar" type="search" placeholder="Alumno" class="form-control input-md" required="" value="<?= $_GET['Buscar'] ?>">
  </div>
<!--/div>


<!-- Multiple Radios (inline) -->
<!--div class="form-group"-->
  <div class="col-md-4"> 
    <label class="radio-inline" for="Inscrito-0">
      <input type="radio" name="Inscrito" id="Inscrito-0" value="1" <?php if($_GET['Inscrito']==1){ ?>checked="checked"<?php }?>>
      Inscrito
    </label> 
    <label class="radio-inline" for="Inscrito-1">
      <input type="radio" name="Inscrito" id="Inscrito-1" value="0" <?php if($_GET['Inscrito']==0){ ?>checked="checked"<?php }?>>
      Todos
    </label>
  </div>
  <div class="col-md-2">
  <button type="submit" class="btn btn-default">Buscar</button>
</div>
</div>

</fieldset>
</form>

  
<!--div class="row">
    <div class="col-lg-12">
        <table width="100%"  border="0" align="center">
            <tr>
            <td colspan="2" align="left" ><table border="0" cellspacing="0" cellpadding="0">
            <tr>
            <td class="subtitle">Buscar</td>
            </tr>
            <tr>
            <td align="center" nowrap="nowrap">
            <form action="ListaAlumnos.php" method="post" name="form3" id="form3">
            <input name="SWinscrito" type="checkbox" id="SWinscrito" value="1" <?php if($_POST['SWinscrito'] == 1 or !isset($_POST['Buscar'])  ) echo 'checked="checked"'; ?> />Inscrito <input name="Buscar" type="text" id="Buscar" value="<?php echo $_POST['Buscar']; ?>" />
            <input type="submit" name="Submit" value="Buscar" />
            </form></td>
            </tr>
        </table>
    </div>
  </div-->

 

<h1>Alumnos</h1>


<?php if ($totalRows_RS_Alumnos > 0) {  
do { 
extract($row_RS_Alumnos);

$sqlStatus = "SELECT * FROM AlumnoXCurso
				WHERE CodigoAlumno = '".$CodigoAlumno."'
				AND Ano = '$AnoEscolar'
				AND Status = 'Inscrito'";
$RS_Status = $mysqli->query($sqlStatus);


if (($_GET['Inscrito']==1 and $row = $RS_Status->fetch_assoc() )
		or ($aux[0]>0 and $aux[0]<9999)
		or $_GET['Inscrito']==0 ) {

if($CodigoAlumnoAnterior != $CodigoAlumno){


?>

<a href="PlanillaImprimirADM.php?CodigoAlumno=<?php echo $CodigoAlumno; ?>" class="btn btn-block btn-lg btn-primary"><?= "($CodigoAlumno) $Apellidos $Apellidos2, $Nombres $Nombres2  "; ?></a>

  


<div class="row" >
    <div class="col-lg-1">  Status
    </div>
    <div class="col-lg-1"><a href="Cobranza/Estado_de_Cuenta_Alumno.php?CodigoPropietario=<?php echo $CodigoClave; ?>" target="_self">Caja</a>
    </div>
    
</div>    


<div class="row">

    <div class="col-sm-2">
	<?php 
		$Ruta = Foto($CodigoAlumno, $id , 300 , "H");
		?><img src="<?php echo $Ruta ?>" alt="" height="150" border="0" />
    </div>
    
    
    <?php 
	$Familia = array('p','m','a1','a2','a3');
   	foreach($Familia as $id){
	$Ruta = Foto($CodigoAlumno, $id , 300 , "H");
	?>
	 <div class="col-sm-2"><?php  echo $Ruta;
		?><img src="<?php echo $Ruta ?>" alt="" height="150" border="0" />
    </div>
	<?php } ?>
    
 </div>   
    
   
    
    
    
    <?php if ($MM_Username=="piero"){ ?>
    <div class="row">

    <div class="col-lg-12">  
      <a href="Procesa.php?CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno']; ?>&EliminaAlumno=1" target="_blank">Eliminar</a>

    </div></div> <?php } ?>

 
 
 <?php 
}}
$CodigoAlumnoAnterior = $CodigoAlumno;
$Creador_AlumnoAnterior = $Creador;

} while ($row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos));}
 ?>
 
 
</div>
<div class="container-fluid">
 
 
  <div class="row">
    <div class="col-lg-12"><?php 
	include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; 
	?> </div>
  </div>  
  
  </div>

</body>

</html>