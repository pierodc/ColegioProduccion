<?php 
//$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 

header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

$Alumno = new Alumno($_GET['CodigoAlumno']);
$Al = $Alumno->Todo();

$TituloPag = $Alumno->Codigo()." - ".$Alumno->NombresApellidos();

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

    <link href="http://<?= $_SERVER['HTTP_HOST']; ?>/estilos.css" rel="stylesheet" type="text/css" />
	
    <title><?php echo $TituloPag; ?></title>
</head>
<body>
<? require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/_Template/NavBar.php');  ?>
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Header.php"); ?>
    
    
    <div class="row h3 subtitle">
		<div class="col-sm-12">
			<div class="">
            	<?= $Alumno->NombresApellidos(); ?>
            </div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-2">
			<img src="<?php echo $Alumno->Foto("","h") ?>" width="150" height="150"  border="0" />
		</div>
		<div class="col-sm-5">
			<div class="col-sm-12 CampoContenido" align="left">
				<?= DDMMAAAA($Alumno->FechaNac()); ?> 
				( <?= Edad_Dif($Alumno->FechaNac(),date(Y)."-09-16") ?> )
				
			</div>
			<div class="col-sm-4 CampoContenido"   align="left">
				<?= $Alumno->Nacionalidad(); ?>
			</div>
			<div class="col-sm-5 CampoContenido" align="left">
				<?= $Alumno->Entidad(); ?> - 
				<?= $Alumno->Localidad(); ?>
			</div>
		</div>
	</div>
	
	
	
	<div class="row h4 NombreCampoTITULO">
		<div class="col-sm-12">
            	Contacto
		</div>
	</div>
	
	<div class="row ">
		<div class="col-sm-12 CampoContenido">
            	<?= $Alumno->DireccionCompleta(); ?>
		</div>
	</div>
	<div class="row ">
		<div class="col-sm-12 CampoContenido">
            	<?= $Alumno->Telefonos(); ?>
		</div>
	</div>
	<div class="row ">
		<div class="col-sm-12 CampoContenido">
            	Emergencia: <?= $Alumno->Emergencia(); ?>
		</div>
	</div>
	
	
	
	<div class="row h4 NombreCampoTITULO">
		<div class="col-sm-12">
            Información médica
		</div>
	</div>
	<div class="row ">
		<div class="col-sm-3 ">
			<div class="CampoNombre">Tiene Psicologo</div>
		</div>
		<div class="col-sm-8 ">
			<div class="CampoContenido"><?= $Al['TienePsicologo'] . " - " . $Al['TienePsicologoObs'] ?></div>
		</div>
	</div>
	<div class="row ">
		<div class="col-sm-3 ">
			<div class="CampoNombre">Otros</div>
		</div>
		<div class="col-sm-8 ">
			<div class="CampoContenido"><?= "Peso: " . $Al['Peso'] . " - Vacunas: " . $Al['Vacunas'] . " - Enfermedades: " . $Al['Enfermedades'] . " - TratamientoMed: " . $Al['TratamientoMed'] . " - Alergico a: " . $Al['AlergicoA'] ?></div>
		</div>
	</div>
	
	
	
	
	
	<div class="row h4 NombreCampoTITULO">
		<div class="col-sm-12">
            Otra Info
		</div>
	</div>
	<div class="row ">
		<div class="col-sm-3 ">
			<div class="CampoNombre">Colegio Procedencia</div>
		</div>
		<div class="col-sm-8 ">
			<div class="CampoContenido"><?= $Al['ColegioProcedencia'] . " - " . $Al['ColegioProcedenciaCiudad'] . " Tlf: " . $Al['ColegioProcedenciaTelefono'] . " / Retiro:" . $Al['MotivoRetiroColProced']; ?></div>
		</div>
	</div>
	
	<div class="row ">
		<div class="col-sm-3 ">
			<div class="CampoNombre">Observaciones</div>
		</div>
		<div class="col-sm-8">
			<div class="CampoContenido"><?= $Al['Observaciones'] ?></div>
		</div>
	</div>
	<div class="row ">
		<div class="col-sm-3 ">
			<div class="CampoNombre">Ha solicitado antes</div>
		</div>
		<div class="col-sm-8 ">
			<div class="CampoContenido"><?= $Al['HaSolicitado'] . " " . $Al['HaSolicitadoObs'] ?></div>
		</div>
	</div>
	<div class="row ">
		<div class="col-sm-3 ">
			<div class="CampoNombre">Hermano</div>
		</div>
		<div class="col-sm-8 ">
			<div class="CampoContenido"><?= "Sol: ". $Al['HermanoSolicitando'] . " Cursando: " . $Al['HermanoCursando'] ?></div>
		</div>
	</div>
	
	<div class="row ">
		<div class="col-sm-3 ">
			<div class="CampoNombre">Hijo de Exalumno</div>
		</div>
		<div class="col-sm-8 ">
			<div class="CampoContenido"><?= "". $Al['HijoDeExalumno'] . " : " . $Al['HijoDeExalumnoObs'] ?></div>
		</div>
	</div>
	<div class="row ">
		<div class="col-sm-3 ">
			<div class="CampoNombre">Referencias Personales</div>
		</div>
		<div class="col-sm-8 ">
			<div class="CampoContenido"><?= "". $Al['ReferenciasPersonales']  ?></div>
		</div>
	</div>
	
	
	
	
	<? 
		$Represntante_id = $Alumno->Representante_id("p"); 
		$Representante = new Representante($Represntante_id);
		$Rep = $Representante->view();
	?>
	
	
	<div class="row h3 subtitle">
		<div class="col-sm-12">
			<div class="">
            	<?= $Rep["Nombres"] . ", " . $Rep["Apellidos"]; ?>
            </div>
		</div>
	</div>
	
	
	<div class="row">
		<div class="col-sm-2">
			<img src="<?php echo $Alumno->Foto("p","h") ?>" width="150" height="150"  border="0" />
		</div>
	</div>
	
	<div class="row ">
		<div class="col-sm-3 ">
			<div class="CampoNombre">Cédula</div>
		</div>
		<div class="col-sm-8">
			<?= "". $Rep['Cedula'] ." - ". $Rep['Nacionalidad'] ." - ". $Rep['LugarNac'] 
				." - ". DDMMAAAA($Rep['FechaNac']) ." (". Edad_Dif($Rep['FechaNac'],date("Y-m-d")) .")" ?>
		</div>
	</div>
	<div class="row ">
		<div class="col-sm-3 ">
			<div class="CampoNombre">Dirección</div>
		</div>
		<div class="col-sm-8">
			<?= "". $Rep['Direccion'] ." - ". $Rep['Urbanizacion'] ." - ". $Rep['Ciudad'] ." - ". $Rep['CodPostal']  ?>
		</div>
	</div>
	<div class="row ">
		<div class="col-sm-3 ">
			<div class="CampoNombre">Email</div>
		</div>
		<div class="col-sm-8">
			<?= "". $Rep['Email1'] ." - ". $Rep['Email2']  ?>
		</div>
	</div>
	
	

<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Footer.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Footer_info.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/AfterHTML.php"); ?>