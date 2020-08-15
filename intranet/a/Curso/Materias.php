<?php 
//$MM_authorizedUsers = "99,91,95,90,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
// Activa Inspeccion
$Insp = false ;



?><!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="ISO-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="Cobranza/common.css">
    <script type="text/javascript" charset="utf8" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.10.2.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>

    <link href="http://<?= $_SERVER['HTTP_HOST']; ?>/estilos2.css" rel="stylesheet" type="text/css" />
	
    <title><?php echo $TituloPag; ?></title>
</head>
<body>
<? require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/_Template/NavBar.php');  ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<p>&nbsp;</p><p>&nbsp;</p>
		</div>
	</div>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Header.php"); ?>
    <div class="row">
		<div class="col-md-12">
			<div>
<?
//echo "<pre>";
//var_dump($_POST);
//echo "</pre>";


// Guarda Forma
if(isset($_POST['Ma01'])){
	foreach ($_POST as $clave => $valor){
		//if($clave != 'Guardar' and $clave != 'CodigoEmpleado' ){
			$ValorAux = $_POST[$clave];
			$sql_update .= " ".$clave."='".$ValorAux."',";
		//	}
	}
		
	if(strlen($sql_update) > 10){
		$sql_update = "UPDATE CursoMaterias 
					   SET ".$sql_update." WHERE CodigoMaterias = '".$_GET['Curso']."'";
		$sql_update = str_replace(', WHERE',' WHERE',$sql_update);		
		//echo $sql_update;
		
		if(true)	
			$mysqli->query($sql_update);
			
		}
}


?>
            <!-- CONTENIDO -->
            <form action="" method="post"><table width="90%" border="1" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <th scope="col">&nbsp;</th>
      <th scope="col">Materia01 (Boleta)</th>
      <th scope="col">Ma01 (Resumen Final)</th>
      <th scope="col">Mat01</th>
      <th scope="col">Materia_01 (listados)</th>
    </tr>
<? $sql = "SELECT *  FROM CursoMaterias 
		   WHERE CodigoMaterias = '".$_GET['Curso']."'"; 
	$RS = $mysqli->query($sql);
	while ($row = $RS->fetch_assoc()) {
		foreach (array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12') as $fila_x) { 
		   ?>
    <tr>
      <td>&nbsp;<?= $fila_x ?></td>
      <td><input type="text" name="<?= 'Materia'.$fila_x ?>" id="<?= 'Materia'.$fila_x ?>" value="<?= $row['Materia'.$fila_x] ?>" size="50" ></td>
      <td><input type="text" name="<?= 'Ma'.$fila_x ?>" id="<?= 'Ma'.$fila_x ?>" value="<?= $row['Ma'.$fila_x] ?>" size="10"></td>
      <td><input type="text" name="<?= 'Mat'.$fila_x ?>" id="<?= 'Mat'.$fila_x ?>" value="<?= $row['Mat'.$fila_x] ?>" size="10"></td>
      <td><input type="text" name="<?= 'Materia_'.$fila_x ?>" id="<?= 'Materia_'.$fila_x ?>" value="<?= $row['Materia_'.$fila_x] ?>" size="50"></td>
    </tr>
    
<? }} ?>

    <tr>
      <td colspan="5" align="right"><button type="submit" class="btn btn-info btn-sm"  onclick="this.disabled=true;this.form.submit();">Guardar</button></td>
      </tr>


  </tbody>
</table>

            </form>
            </div>
		</div>
	</div>
</div>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Footer.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Footer_info.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/AfterHTML.php"); ?>