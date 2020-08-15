<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable";
//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');

$TituloPantalla = "Alumno";
/*
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	extract($row);
    echo "<br>";
}
*/

if (isset($_POST['Buscar']) or isset($_GET['CodigoBuscar'])) {
	$aux = explode(" ",strtolower( $_POST['Buscar']));
	$sql  = "SELECT * FROM Alumno WHERE "; 
	if($aux[0]>0 and $aux[0]<9999){
		$sql .= " CodigoAlumno = '$aux[0]' ";
	}else{
		$sql .= " ";
		$sql .= " LOWER(CONCAT_WS(' ',CodigoAlumno,Nombres,Nombres2,Apellidos,Apellidos2,SMS_Caja)) LIKE '%$aux[0]%'";
		if($aux[1]!=""){$sql .= " AND LOWER(CONCAT_WS(' ',CodigoAlumno,Nombres,Nombres2,Apellidos,Apellidos2,SMS_Caja)) LIKE '%$aux[1]%'";}
		if($aux[2]!=""){$sql .= " AND LOWER(CONCAT_WS(' ',CodigoAlumno,Nombres,Nombres2,Apellidos,Apellidos2,SMS_Caja)) LIKE '%$aux[2]%'";}
		if($aux[3]!=""){$sql .= " AND LOWER(CONCAT_WS(' ',CodigoAlumno,Nombres,Nombres2,Apellidos,Apellidos2,SMS_Caja)) LIKE '%$aux[3]%'";}
		$sql .= " ORDER BY Alumno.Apellidos, Alumno.Apellidos2, Alumno.Creador, Alumno.Nombres, Alumno.Nombres2";
	}
	$RS = $mysqli->query($sql);
}



?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="ISO-8859-1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bootstrap - Prebuilt Layout</title>

<!-- Bootstrap -->
<link href="../../../css/bootstrap.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<?php include ($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/B/menu_boots.php');  ?>


<div class="container-fluid">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <h1 class="text-center"><?= $TituloPantalla ?></h1>
    </div>
  </div>
</div>
<div class="container">


  <div class="row text-center">
    <div class="col-md-4 col-md-offset-4 text-center">
		<form class="navbar-form navbar-left" role="search" action="Alumno.php" method="post"  >
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search" name="Buscar" value="<?= $_POST['Buscar'] ?>">
        </div>
        <button type="submit" class="btn btn-default">Buscar</button>
      </form>
    </div>
  </div>
  
  
  <hr>
<?php 
if(isset($_POST['Buscar']))
while ($row = $RS->fetch_assoc()) {
	extract($row);
?>  
   <div class="row">
    <div class="text-left col-md-12">
      <div class="well"><strong><a type="button" class="btn btn-primary btn-block" href="Alumno.php?CodigoClave=<?= $CodigoClave ?>" ><? echo $Apellidos." ".$Apellidos2." ".$Nombres." ".$Nombres2.""; ?></a></strong></div>
    </div>
  </div>
  
  <div class="row">
    <div class="text-justify col-sm-12">  </div>
  </div>
<?php } ?>


<?php include ($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/B/Footer.php');  ?>

</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="../../../js/jquery-1.11.2.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="../../../js/bootstrap.js"></script>
</body>
</html>
