<?
//$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable,provee";
require_once( $_SERVER['DOCUMENT_ROOT'] . "/Config/Autoload.php");
$Cursos = new Curso;
$ContableMov = new ContableMov($CodigoAlumno=0);

require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/BeforeHTML.php" );
?><!doctype html>
<html lang="es">
<head>
	<? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Head.php");  ?>
<title><?php echo $TituloPag; ?></title>
</head>
<body <? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Body_tag.php");  ?>>
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/NavBar.php");  ?>
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Header.php"); ?>


<table class="">
  <tbody>
    <tr>
      <th scope="col">Curso</th>
      <th scope="col">Alumnos</th>
      <th scope="col">Morosos</th>
      <th scope="col">Mora %</th>
      <th scope="col">email</th>
      <th scope="col">detalle</th>
      <th scope="col">total</th>
    </tr>
<? 

$_Cursos = $Cursos->view_all() ;
	  
foreach ($_Cursos as $Clave => $Valor){
	$Cursos->id = $Valor['CodigoCurso'];	
	$_Listado = $Cursos->ListaCurso();
	if(count($_Listado)){
?>
<tr>
 <td >
      <? echo $Valor['NombreCompleto']; ?><br>
      <? //echo $Cambio_Dolar . $DeudaCurso; $DeudaCurso = 0; ?>
 </td>

<td align="right">
<?
									   
									   
	
									   
	foreach($_Listado as $Alumno){
		$ContableMov->id_Alumno = $Alumno['CodigoAlumno'];
		$Pendiente = $ContableMov->Pendiente();
		
		
		if($Pendiente["resumen"]["MontoDebe_Dolares"] > 0){
			$_Detalle[] = $Pendiente["resumen"]["MontoDebe_Dolares"];
			$_TotalCurso += $Pendiente["resumen"]["MontoDebe_Dolares"];
			$_TotalGeneral += $Pendiente["resumen"]["MontoDebe_Dolares"];
			$_NumMorosos++;
		}
		$_NumAlumnos++;
	}
	echo $_NumAlumnos;								   
									   
	
?>
</td>
    
    <td align="right"><? echo $_NumMorosos; ?></td>
    <td align="right"><?  
		if($_NumAlumnos > 0)	{	
			$_PorcientoCurso = round($_NumMorosos/$_NumAlumnos*100,2);
			echo $_PorcientoCurso . "%";
			$_NumCursos++;
		}
		
									   
									   
		$_NumMorosos = $_NumAlumnos = 0;
		?></td>
     
      <td><iframe src="Aviso_de_Cobro_Email.php?porCurso=1&<?php echo "CodigoCurso=".$Valor['CodigoCurso']; ?>" width="40" height="40" scrolling="no" frameborder="0" seamless></iframe></td>
   
    <td>
    <? 
						 
		sort($_Detalle);				 
		foreach( $_Detalle as $value ){
			echo $value . " . ";
		}
		$_Detalle = array();
		?>
    </td>
     
      <td align="right"><? echo $_TotalCurso; $_TotalCurso=0; ?></td>
       
</tr>
<?
						}
	}

 ?>
 
 
 <tr>
 	<td></td>
 	<td></td>
 	<td></td>
 	<td></td>
 	<td></td>
 	<td><?= fnum($_TotalGeneral); ?></td>
 </tr>
  </tbody>
</table>

	<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer_info.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/AfterHTML.php"); ?>