<?php 
require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php'); 
require_once('../../../inc/rutinas.php'); 
require_once('../../../inc/notas.php'); 

$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

if (!isset($_POST['button'])){ 
$Campos = array('No','Codigo','Apellido1','Apellido2','Nombre1','Nombre2','FotoPeq','FotoGde','Cedula','Lugar Nac','FechaNac','Edad','Sexo');


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
<script type="text/javascript">
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function KW_simpleUpdateItems(d,o,n,fn) { //v3.0 By Paul Davis www.kaosweaver.com
  var i,s,l=MM_findObj(d),b,z=o.options[o.selectedIndex].value;
  l.length=0;l.options[0]=new Option('tbd','tbd');b=(z!='nill')?eval('KW_'+z+n):0;
  for(i=0;i<b.length;i++){s=b[i].split("|");l.options[i]=new Option(s[1],s[0]);}
  l.selectedIndex=0;if (!fn) return;eval(fn)
}
function MM_showHideLayers() { //v9.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
</script>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="600" border="1" align="center" cellpadding="3" cellspacing="0">
    <tr>
      <td colspan="16" nowrap="nowrap">Año Escolar
        <select name="AnoEscolar" id="select">
          <option value="<?php echo $AnoEscolarAnte; ?>"><?php echo $AnoEscolarAnte; ?></option>
          <option value="<?php echo $AnoEscolar; ?>" selected="selected"><?php echo $AnoEscolar; ?></option>
          <option value="<?php echo $AnoEscolarProx; ?>"><?php echo $AnoEscolarProx; ?></option>
        </select></td>
    </tr>
    <tr>
      <td colspan="16" nowrap="nowrap">
      
      
      
  <label for="Tipo"></label>
  Lista de:  
  <select name="Tipo" id="Tipo" onchange="KW_simpleUpdateItems('Rango',this,'_Data'); MM_showHideLayers('Rango','','show')">
    <option value="0">Seleccione...</option>
    <option value="Curso">Por Curso</option>
    <option value="Asignacion">Por Asignacion</option>
  </select>
  <label for="Rango"></label>
  <select name="Rango" id="Rango" >
    <option value="0">Seleccione</option>
  </select>
<script language="JavaScript">
// <select="kwTest" onChange="KW simpleUpdateItems('targetSelect',this,'kwData')">

 var KW_Asignacion_Data = new Array();
 KW_Asignacion_Data[KW_Asignacion_Data.length]="0|Todas"
 <?php 
$sql = "SELECT * FROM Asignacion WHERE SWActiva=1 AND Periodo='M' AND Orden>'02' ORDER BY Descripcion";
mysql_select_db($database_bd, $bd);
$RS = mysql_query($sql, $bd) or die(mysql_error());
$row = mysql_fetch_assoc($RS);
do{
	extract($row);
echo 'KW_Asignacion_Data[KW_Asignacion_Data.length]="'.$Codigo.'|'.$Descripcion.'"
';
	}while ($row = mysql_fetch_assoc($RS));		  
					  ?> 


 var KW_Curso_Data = new Array();
 KW_Curso_Data[KW_Curso_Data.length]="0|Todos"
 KW_Curso_Data[KW_Curso_Data.length]="Pre|Preescolar"
 KW_Curso_Data[KW_Curso_Data.length]="Pri|Primaria"
 KW_Curso_Data[KW_Curso_Data.length]="Bach|Bachillerato"
 KW_Curso_Data[KW_Curso_Data.length]="0|--"
 KW_Curso_Data[KW_Curso_Data.length]="Pri123|Primaria 1ro a 3ro"
 KW_Curso_Data[KW_Curso_Data.length]="Pri456|Primaria 4to a 6to"
 KW_Curso_Data[KW_Curso_Data.length]="Bach123|Bach 1ro a 3ro"
 KW_Curso_Data[KW_Curso_Data.length]="Bach45|Bach 4to a 5to"
 KW_Curso_Data[KW_Curso_Data.length]="0|--"
<?php 
$sql = 'SELECT * FROM Curso WHERE SW_activo=1 ORDER BY NivelCurso, Seccion';
mysql_select_db($database_bd, $bd);
$RS = mysql_query($sql, $bd) or die(mysql_error());
$row = mysql_fetch_assoc($RS);
do{
	extract($row);
	if ($CodigoCurso>0)
		echo ' KW_Curso_Data[KW_Curso_Data.length]="'.$CodigoCurso.'|'.$NombreCompleto.'"
		';
		//echo "<option value='".."'>".$NombreCompleto."</option>\r\n";	
	}while ($row = mysql_fetch_assoc($RS));		  
		  ?>

</script>
      
      
      
      
      
      
     &nbsp; / Notas
      <select name="Notas" id="Notas">
        <option value="0">Selecc..</option>
        <?php 
foreach($Lapsos as $Lapso){
	$Lapso = explode(';' , $Lapso);
echo '<option value="'.$Lapso[0].'">'.$Lapso[1].'</option>
';}
?>
      </select></td>
    </tr>
    <tr>
      <td colspan="16" nowrap="nowrap">Orden: 
        <label for="Orden"></label>
        <select name="Orden" id="Orden">
          <option value="ApellidoNombre">Apellido Nombre</option>
          <option value="Cedula">Cedula</option>
      </select></td>
    </tr>
    <tr>
      <td colspan="16" nowrap="nowrap"><label>Orientaci&oacute;n:
          <input name="Orientacion" type="radio" id="RadioGroup1_0" value="P" checked="checked"  />
        Vertical</label>
        
        <label>
          <input type="radio" name="Orientacion" value="L" id="RadioGroup1_1" />
          Horizontal</label>
      <br /></td>
    </tr>
    <tr>
      <td colspan="16" nowrap="nowrap">Reticula 
      <input name="Reticula" type="checkbox" id="Reticula" value="1" checked="checked" /> 
      Espaciado 
      <label for="Espacio"></label>
      <select name="Espacio" id="Espacio">
        <option value=".7">Simple</option>
        <option value="1" selected="selected">Espacio y medio</option>
        <option value="1.5">Doble</option>
      </select></td>
    </tr>
    <tr>
      <td colspan="16" nowrap="nowrap">Rifa Inicial: 
        <label for="RifaInicio"></label>
      <input name="RifaInicio" type="text" id="RifaInicio" size="5" /> 
      Cant por talonario 
      <input name="RifaCant" type="text" id="RifaCant" size="5" />
      -
      <input name="Familia" type="checkbox" id="Familia" value="1" /> 
      Indicar Hermano Ppal</td>
    </tr>
<tr>
      <td colspan="16" nowrap="nowrap">Casillas
        <input name="Casillas" type="text" id="Casillas" value="0" size="4" /> 
        | 
        <input name="Head1" type="text" id="Head1" size="8" />
        | 
        <input name="Head2" type="text" id="Head1" size="8" />
        | 
        <input name="Head3" type="text" id="Head1" size="8" />
        | 
        <input name="Head4" type="text" id="Head1" size="8" />
        | 
        <input name="Head5" type="text" id="Head1" size="8" />
        | 
        <input name="Head6" type="text" id="Head1" size="8" />
        | 
        <input name="Head7" type="text" id="Head1" size="8" />
        | 
        <input name="Head8" type="text" id="Head1" size="8" />
        | 
        <input name="Head9" type="text" id="Head1" size="8" />
        |</td>
    </tr>
    <tr>
      <td colspan="16" nowrap="nowrap">Solo Fotos 
        <input type="checkbox" name="SoloFoto" id="SoloFoto"  value="1" /></td>
    </tr>
    <tr>
      <td align="center" nowrap="nowrap">No</td>
      <td align="center" nowrap="nowrap">Foto</td>
      <td align="center" nowrap="nowrap">Cod</td>
      <td align="center" nowrap="nowrap">2do Apellido</td>
      <td align="center" nowrap="nowrap">2do Nombre</td>
      <td align="center" nowrap="nowrap">Foto</td>
      <td align="center" nowrap="nowrap">C&eacute;dula</td>
      <td align="center" nowrap="nowrap">Fecha Nac</td>
      <td align="center" nowrap="nowrap">Edad</td>
      <td align="center" nowrap="nowrap">Clinica Nac</td>
      <td align="center" nowrap="nowrap">Lugar Nac</td>
      <td align="center" nowrap="nowrap">Sexo</td>
      <td align="center" nowrap="nowrap">Materias</td>
      <td align="center" nowrap="nowrap">Hermanos</td>
      <td align="center" nowrap="nowrap">&nbsp;</td>
      <td align="center" nowrap="nowrap">Status </td>
    </tr>
    <tr>
      <td align="center" nowrap="nowrap"><input name="No" type="checkbox" id="No" value="1" checked="checked" /></td>
      <td align="center" nowrap="nowrap"><input name="Foto2" type="checkbox" id="No2" value="1" /></td>
      <td align="center" nowrap="nowrap"><input name="Cod" type="checkbox" id="No" value="1" checked="checked" /></td>
      <td align="center" nowrap="nowrap"><input name="2a" type="checkbox" id="No" value="1" /></td>
      <td align="center" nowrap="nowrap"><input name="2n" type="checkbox" id="No" value="1" /></td>
      <td align="center" nowrap="nowrap"><input name="Foto" type="checkbox" id="No2" value="1" /></td>
      <td align="center" nowrap="nowrap"><input name="Cedula" type="checkbox" id="Cedula" value="1" /></td>
      <td align="center" nowrap="nowrap"><input name="FNac" type="checkbox" id="No3" value="1" /></td>
      <td align="center" nowrap="nowrap"><input name="Edad" type="checkbox" id="No3" value="1" /></td>
      <td align="center" nowrap="nowrap"><input name="ClinicaNac" type="checkbox" id="ClinicaNac" value="1" /></td>
      <td align="center" nowrap="nowrap"><input name="LugNac" type="checkbox" id="LugNac" value="1" /></td>
      <td align="center" nowrap="nowrap"><input name="Sexo" type="checkbox" id="No" value="1" /></td>
      <td align="center" nowrap="nowrap"><input name="Materias" type="checkbox" id="Materias" value="1" /></td>
      <td align="center" nowrap="nowrap"><label for="Notas">
        <input name="Hermanos" type="checkbox" id="Hermanos" value="1" />
      </label></td>
      <td align="center" nowrap="nowrap">&nbsp;</td>
      <td align="center" nowrap="nowrap"><input name="Status" type="checkbox" id="Status" value="1" /></td>
    </tr>
    
    <tr>
      <td colspan="16" nowrap="nowrap"><input name="Direccion" type="checkbox" id="No" value="1" />
Direccion | 
  <input name="Telefono" type="checkbox" id="No" value="1" />
Tel&eacute;fono | 
<input name="Papa" type="checkbox" id="No" value="1" /> 
Papa | 
<input name="Mama" type="checkbox" id="No" value="1" />
Mama </td>
    </tr>
    
    <tr>
      <td colspan="16" nowrap="nowrap">Formato 
        <select name="Formato" id="Formato">
          <option value="pdf">PDF</option>
          <option value="xls">Excel</option>
      </select></td>
    </tr>
    <tr>
      <td colspan="16" nowrap="nowrap"><input type="submit" name="button" id="button" value="Submit" /></td>
    </tr>
    <tr>
      <td colspan="16" nowrap="nowrap">
      <?php for($i=1; $i<= 10; $i++) {?>
      
      
        <select name="<?php echo $i ?>">
         
          <option value="0">Seleccione...</option>
      <?php foreach($Campos as $Campo) {?>
          <option value="<?php echo $Campo ?>"><?php echo $Campo ?></option>
      <?php } ?>
        </select>
      <?php } ?>
      
      </td>
    </tr>
    <tr>
      <td colspan="16" nowrap="nowrap">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="16" nowrap="nowrap">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="16" nowrap="nowrap">&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
<?php } else {

$Formato = $_POST['Formato'];
$AnoEscolar = $_POST['AnoEscolar'];
$RifaInicio = $_POST['RifaInicio'];
$RifaCant = $_POST['RifaCant'];
mysql_select_db($database_bd, $bd);
	
	
	
$add_curso = '';
if($_POST['Rango']>0 and $_POST['Rango']<99){
	$add_sql = ' AND AlumnoXCurso.CodigoCurso = '.$_POST['Rango'] ;}

if($_POST['Rango']=='Pre'		) $add_sql = ' AND Curso.NivelCurso >=11 AND Curso.NivelCurso <=14 ' ;
if($_POST['Rango']=='Pri'		) $add_sql = ' AND Curso.NivelCurso >=21 AND Curso.NivelCurso <=26 ' ;
if($_POST['Rango']=='Pri123'	) $add_sql = ' AND Curso.NivelCurso >=21 AND Curso.NivelCurso <=23 ' ;
if($_POST['Rango']=='Pri456'	) $add_sql = ' AND Curso.NivelCurso >=24 AND Curso.NivelCurso <=26 ' ;
if($_POST['Rango']=='Bach'		) $add_sql = ' AND Curso.NivelCurso >=31 AND Curso.NivelCurso <=45 ' ;
if($_POST['Rango']=='Bach123'	) $add_sql = ' AND Curso.NivelCurso >=31 AND Curso.NivelCurso <=33 ' ;
if($_POST['Rango']=='Bach45' 	) $add_sql = ' AND Curso.NivelCurso >=44 AND Curso.NivelCurso <=45 ' ;
if( strrpos($_GET['Lapso'] , "mp") > 0) 
									  $add_sql .= " AND AlumnoXCurso.Tipo_Inscripcion  = 'Mp' " ;
else
									  $add_sql .= " AND AlumnoXCurso.Tipo_Inscripcion  = 'Rg' " ;

if ($_GET['Orden']=='Cedula' or $_POST['Orden']=='Cedula') 
	$add_Orden = ' ORDER BY Alumno.Cedula_int ';
else
	$add_Orden = ' ORDER BY Curso.NivelCurso, Curso.Seccion, Alumno.Apellidos, Alumno. Apellidos2, Alumno.Nombres, Alumno.Nombres2 ';


if($_POST['Tipo']=='Curso'){
	$add_sql .= " AND AlumnoXCurso.Ano = '$AnoEscolar' " ;

	$sql="SELECT * FROM Alumno , AlumnoXCurso, Curso 
		WHERE Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno 
		AND AlumnoXCurso.CodigoCurso = Curso.CodigoCurso 
		
		
		
		AND AlumnoXCurso.Status = 'Inscrito'
		$add_sql 
		GROUP BY Alumno.CodigoAlumno
		$add_Orden
		";}
else{
	if($_POST['Rango']>0){
		$add_sql = ' AND Asignacion.Codigo = '.$_POST['Rango'] ;}

			
	$sql="SELECT * FROM Alumno, AsignacionXAlumno, Asignacion , AlumnoXCurso, Curso 
		WHERE Alumno.CodigoAlumno = AsignacionXAlumno.CodigoAlumno 
		AND AsignacionXAlumno.Ano_Escolar ='$AnoEscolar'
		AND AsignacionXAlumno.CodigoAsignacion = Asignacion.Codigo
		
		$add_sql 
		
		AND Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno 
		AND AlumnoXCurso.CodigoCurso = Curso.CodigoCurso 
		AND AlumnoXCurso.Ano = '$AnoEscolar' 
		AND AlumnoXCurso.Status = 'Inscrito'
		AND Asignacion.Descripcion <> 'Escolaridad' 
		AND Asignacion.Descripcion <> 'Actividades Extracurriculares' 
		
		ORDER BY Asignacion.Descripcion, Curso.NivelCurso, Curso.Seccion, Alumno.Apellidos, Alumno. Apellidos2, Alumno.Nombres, Alumno.Nombres2 ";
}  
$RS = mysql_query($sql, $bd) or die(mysql_error());
$row = mysql_fetch_assoc($RS);


if($Formato == "pdf"){

	require_once('../../../inc/fpdf.php'); 
	require_once('../../../inc/rpdf.php'); 
	$pdf = new RPDF($_POST['Orientacion'], 'mm', 'Letter');
	
	$pdf->SetFillColor(255,255,255);
	$borde = $_POST['Reticula'];
	$Ln = 5.70 * $_POST['Espacio'];
} // pdf

do {
	extract($row);

	if($_POST['Tipo']=='Curso')
		$TituloPag = $NombreCompleto;
	else
		$TituloPag = $Descripcion;
	
	if($TituloAnterior != $TituloPag){ //ENCABEZADO
		$pdf->SetFont('Arial','B',14);
		$pdf->AddPage();
		$_y_mult = 0;
		$_x_mult = 0;

		if($_POST['Orientacion']=='P')
			$AnchoDisponible = 200;
		else
			$AnchoDisponible = 260;
			
		$pdf->SetY( 30 );
		$pdf->Image('../../../img/solcolegio.jpg', 10, 5, 0, 16);
		$pdf->Image('../../../img/NombreCol.jpg' , 30, 5, 0, 12);
		$pdf->SetY( 22 );
		$pdf->Cell(39 , $Ln , $TituloPag , 0 , 0 , 'L'); 
		
		foreach($Lapsos as $Lapso){
			$Lapso = explode(';' , $Lapso);
		if ($Lapso[0] == $_POST['Notas']) 
		$pdf->Cell(39 , $Ln , $Lapso[1] , 0 , 0 , 'R');} 
		
		$pdf->Ln();
		
		
		$pdf->SetFont('Arial','',10);
		$pdf->SetY( 30 );
		$i=0;
		$pdf->SetFont('Arial','',10);
		
	if(!$_POST['SoloFoto']){
		
		if($_POST['No']) 	$pdf->Cell(6 , $Ln , 'No' , $borde , 0 , 'C'); 
		if($_POST['Foto2']) $pdf->Cell(13.5 , $Ln , 'Foto' , $borde , 0 , 'C'); 	// Foto2

		if($_POST['Cod']) 	$pdf->Cell(10 , $Ln , 'Cod' , $borde , 0 , 'C');
							$pdf->Cell(65 , $Ln , 'Apellidos, Nombres' , $borde , 0 , 'L');   
		$AnchoDisponible-=78;
		if($_POST['Papa']) {	$pdf->Cell(50 , $Ln , 'Papá' , $borde , 0 , 'C');    $AnchoDisponible-=30;}
		if($_POST['Mama']) {	$pdf->Cell(50 , $Ln , 'Mamá' , $borde , 0 , 'C');    $AnchoDisponible-=30;}
		if($_POST['Sexo']) 	 {	$pdf->Cell(6 , $Ln , 'S.' , $borde , 0 , 'C');     $AnchoDisponible-=6;} 
		if($_POST['Cedula']) {	$pdf->Cell(27 , $Ln , 'Cédula' , $borde , 0 , 'C');    $AnchoDisponible-=30;}
		if($_POST['FNac']) 	 {	$pdf->Cell(22 , $Ln , 'Fecha Nac.' , $borde , 0 , 'C');    $AnchoDisponible-=22;} 
		if($_POST['Edad']) 	 {	$pdf->Cell(10 , $Ln , 'Edad' , $borde , 0 , 'C');    $AnchoDisponible-=22;} 
		if($_POST['ClinicaNac']) {	$pdf->Cell(20 , $Ln , 'Clinica Nac.' , $borde , 0 , 'C');    $AnchoDisponible-=20;} 
		if($_POST['LugNac']) {	$pdf->Cell(35 , $Ln , 'Lugar Nac.' , $borde , 0 , 'C');    $AnchoDisponible-=35;} 
		if($_POST['Tipo']!='Curso'){
							$pdf->Cell(30 , $Ln , 'Curso' , $borde , 0 , 'L'); $AnchoDisponible-=30;}
		$_x = $pdf->GetX();
		
		
		if($_POST['Materias'] or $_POST['Notas']) {
		$mm = $AnchoDisponible/13;
		$sql2 = "SELECT * FROM CursoMaterias WHERE CodigoMaterias = '$CodigoMaterias'";
		$RS2 = mysql_query($sql2, $bd) or die(mysql_error());
		$row2 = mysql_fetch_assoc($RS2);
		
		$pdf->SetXY($_x, 30-$Ln*3.5 );
		
		
		for ($j = 1; $j <= 13; $j++){ // Casillas en blanco para materias
			$pdf->Cell($mm , $Ln*4.5 , '' , $borde , 0 , 'C');}
		
		$_x = $_x + $mm/2 + 2;
		
		if($_POST['Notas']>'0') $_x = $_x-2;
		for ($j = 1; $j <= 13; $j++) { // Materias
		$pdf->TextWithDirection($_x , 35 , $row2['Materia_'.substr("0".$j, -2).''] , 'U' ); 
		$_x = $_x + $mm; }
		
		}elseif($_POST['Casillas']>0) { // Casillas titulo en blanco
			$mm = $AnchoDisponible/$_POST['Casillas'];
			$pdf->SetXY($_x, 30-$Ln*3.5 );
			for ($j = 1; $j <= $_POST['Casillas']; $j++) {
				$pdf->TextWithDirection($_x + $mm/2 + 1 , 35 , $_POST['Head'.$j] , 'U' );
				$_x = $_x + $mm;
				$pdf->Cell($mm , $Ln*4.5 , '' , $borde , 0 , 'C'); 
				}
		}
		
		$pdf->SetY( 30 );
		$pdf->Ln($Ln);
		$_x_add=1;
		if($_POST['RifaInicio']>0) 	{$AnchoDisponible-=30;}
		
		if($_POST['Notas']>'0'){ // espacio para estadisticas
			$Y_estad = $pdf->GetY();
			  $pdf->Ln(4*$Ln/1.5);
		}
	}
	else{
		
		// SOLO FOTOS
		
		}
		
	} //ENCABEZADO FIN
	
	
	
if($_POST['SoloFoto'] !=1 ){
	
	if($_POST['No']) 	 // No lista
		$pdf->Cell(6 , $Ln , ++$i , $borde , 0 , 'R'); 	
		
	if($_POST['Foto2']) 	{	// Foto2
		//$pdf->Cell($_x_add , $Ln , '' , 0 , 0 , 'L'); 
		$_x_Foto = $pdf->GetX()+.5; 
		$_y_Foto = $pdf->GetY()+.5;
		$Foto = '../../../'.$AnoEscolar.'/150/' .$CodigoAlumno. '.jpg';
		if(!file_exists($Foto))
			$Foto = '../../../'.$AnoEscolarAnte.'/150/' .$CodigoAlumno. '.jpg';
		if(!file_exists($Foto))
			$Foto = '../../../'.$AnoEscolarAnteAnte.'/150/' .$CodigoAlumno. '.jpg';
		if(file_exists($Foto))
			$pdf->Image($Foto , $_x_Foto, $_y_Foto, 12 , 0);
		//$_x_add = $_x_add+15;
		//if($_x_add == 76 ) $_x_add=1;
		$pdf->SetX($_x_Foto + 13);
	}
			
	
	if($_POST['Cod']) 	// Codigo Alumno
		$pdf->Cell(10 , $Ln , $CodigoAlumno , $borde , 0 , 'R'); 
	
	$Alumno = '';		// Nombres del alumno
	$Alumno = $Apellidos;
	
	if($_POST['2a']) 	// Segundo Apellido
		$Alumno = trim($Apellidos.' '.$Apellidos2);
	else 
		$Alumno = trim($Apellidos.' '.substr($Apellidos2,0,1));
	
	$Alumno=$Alumno.', '.$Nombres;
	
	if($_POST['2n']) 	// Segundo Nombre
		$Alumno = trim($Alumno.' '.$Nombres2);
	else 
		$Alumno = trim($Alumno.' '.substr($Nombres2,0,1));
	
	$pdf->Cell(65 , $Ln , $Alumno , $borde , 0 , 'L'); // Nombres del alumno

	if($_POST['Hermanos']){	// Hermanos
		$sql2 = "SELECT * FROM AlumnoXCurso, Alumno 
						WHERE Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno AND
						AlumnoXCurso.Ano = '$AnoEscolar' AND
						AlumnoXCurso.Tipo_Inscripcion = 'Rg' AND
						AlumnoXCurso.Status = 'Inscrito' AND
						Alumno.Creador = '$Creador' AND
						Alumno.Nombres <> '$Nombres' AND
						Alumno.Nombres <> '$Nombres2' 
						ORDER BY AlumnoXCurso.CodigoCurso
					";
		$RS2 = mysql_query($sql2, $bd) or die(mysql_error());
		$row2 = mysql_fetch_assoc($RS2);
		if($row2['Apellidos']>'')
			do{
				$pdf->Cell(40 , $Ln , substr($row2['Apellidos'],0,3).' '.$row2['Nombres'].' '.CursoSeccion($row2['CodigoCurso']).' ' , $borde , 0 , 'L');
			}while($row2 = mysql_fetch_assoc($RS2));
	}
		
	if($_POST['Foto']) 	{	// Foto
		if($_x_add < 2 ) 
			$_x_add = 90;
		$pdf->Cell($_x_add , $Ln , $Nombres.' >' , 0 , 0 , 'R'); 
		$_x_Foto = $pdf->GetX(); 
		$_y_Foto = $pdf->GetY();
		$Foto = '../../../'.$AnoEscolar.'/150/' .$CodigoAlumno. '.jpg';
		if(!file_exists($Foto))
			$Foto = '../../../'.$AnoEscolarAnte.'/150/' .$CodigoAlumno. '.jpg';
		if(file_exists($Foto))
			$pdf->Image($Foto , $_x_Foto, $_y_Foto, 20, 0);
		$_x_add = $_x_add - 20;
	}
	
	if($_POST['RifaInicio']>0) 	{ //Rifa
		$pdf->SetFont('Arial','B',12);
		$RifaFin = $RifaInicio+$RifaCant-1;
		$pdf->Cell(12 , $Ln , $RifaInicio  , 'TB' , 0 , 'L'); 
		$pdf->Cell(6 , $Ln , ' al ' , 'TB' , 0 , 'C'); 
		$pdf->Cell(12 , $Ln , $RifaFin , 'TB' , 0 , 'R'); 
		$RifaInicio=$RifaInicio+$RifaCant;
		$pdf->SetFont('Arial','',10);
	}
	
	if($_POST['Sexo']) 		// Sexo
		$pdf->Cell(6 , $Ln , $Sexo , $borde , 0 , 'C'); 
	if($_POST['Cedula']) 	// Rifa	
		$pdf->Cell(27 , $Ln , $CedulaLetra.'-'.$Cedula , $borde , 0 , 'R'); 
	if($_POST['FNac']) 		// Fecha Nacimiento
		$pdf->Cell(22 , $Ln , DDMMAAAA($FechaNac) , $borde , 0 , 'C'); 
	if($_POST['Edad']) 		// Fecha Nacimiento
		$pdf->Cell(10 , $Ln , Edad($FechaNac) , $borde , 0 , 'C'); 
	if($_POST['ClinicaNac']) 	// Lugar Nacimiento
		$pdf->Cell(20 , $Ln , ucwords(strtolower($ClinicaDeNac)) , $borde , 0 , 'L', 1 ); 
	if($_POST['LugNac']){ 	// Lugar Nacimiento
		$pdf->Cell(25 , $Ln , ucwords(strtolower($Localidad)) , $borde , 0 , 'L', 1); 
		$pdf->Cell(10 , $Ln , ucwords(strtolower($EntidadCorta.' '.$LocalidadPais)) , $borde , 0 , 'L', 1); 
		}
	

	
	if($_POST['Status']=='1') {	 // Status Año anterior vs actual
		
		if($AnoEscolarAnte <> $AnoEscolar){
			$sql3 = "SELECT * FROM AlumnoXCurso, Curso 
					WHERE AlumnoXCurso.CodigoCurso = Curso.CodigoCurso 
					AND AlumnoXCurso.Ano = '$AnoEscolarAnte'  
					AND AlumnoXCurso.Status = 'Inscrito'  
					AND AlumnoXCurso.CodigoAlumno=".$CodigoAlumno ;
			$RS3 = mysql_query($sql3, $bd) or die(mysql_error());
			$row3 = mysql_fetch_assoc($RS3);
			$pdf->Cell(30 , $Ln , $row3['Status'] , $borde , 0 , 'C');}

		$sql3 = "SELECT * FROM AlumnoXCurso, Curso 
				WHERE AlumnoXCurso.CodigoCurso = Curso.CodigoCurso 
				AND AlumnoXCurso.Ano = '$AnoEscolar'  
				AND AlumnoXCurso.Status = 'Inscrito'  
				AND AlumnoXCurso.CodigoAlumno=".$CodigoAlumno ;
		$RS3 = mysql_query($sql3, $bd) or die(mysql_error());
		$row3 = mysql_fetch_assoc($RS3);
		$pdf->Cell(30 , $Ln , $row3['Status'] , $borde , 0 , 'C');
	
		if($AnoEscolarProx <> $AnoEscolar){
			$sql3 = "SELECT * FROM AlumnoXCurso, Curso 
					WHERE AlumnoXCurso.CodigoCurso = Curso.CodigoCurso 
					AND AlumnoXCurso.Ano = '$AnoEscolarProx'  
					AND AlumnoXCurso.Status = 'Inscrito'  
					AND AlumnoXCurso.CodigoAlumno=".$CodigoAlumno ;
			$RS3 = mysql_query($sql3, $bd) or die(mysql_error());
			$row3 = mysql_fetch_assoc($RS3);
			$pdf->Cell(30 , $Ln , $row3['Status'] , $borde , 0 , 'C');}

		}
	
}
	/*
	if($_POST['ColectaNotas']) {
		$SQLaux = "DELETE FROM Notas_Certificadas 
					WHERE CodigoAlumno='".$CodigoAlumno."'" ;
		$RSaux = mysql_query($SQLaux, $bd) or die(mysql_error());
		$SQLinsert='';
		$pdf->Ln();
		$CodigoMaterias = array('7','8','9','IV');
		foreach($CodigoMaterias as $CodigoMateria){
			$SQLaux = "SELECT * FROM CursoMaterias 
						WHERE CodigoMaterias='".$CodigoMateria."'" ;
			$RSaux = mysql_query($SQLaux, $bd) or die(mysql_error());
			$ROWaux = mysql_fetch_assoc($RSaux);
			
			for ($j = 1; $j <= 13; $j++){
				$Mat[$CodigoMateria][oi($j)] = $ROWaux['Ma'.oi($j)];
				$Materia[$CodigoMateria][oi($j)] = $ROWaux['Materia'.oi($j)];}
			if($Mat[$CodigoMateria][10] == $Mat[$CodigoMateria][11]){
				$Mat[$CodigoMateria][11] = $Mat[$CodigoMateria][12];
				$Mat[$CodigoMateria][12] = '';
				$Materia[$CodigoMateria][11] = $Materia[$CodigoMateria][12];
				$Materia[$CodigoMateria][12] = '';}

			// NOTAS
			if($CodigoMateria == '7') $addSQL = "AND (CodigoCurso = '35' OR CodigoCurso = '36' OR CodigoCurso = '46')";
			if($CodigoMateria == '8') $addSQL = "AND (CodigoCurso = '37' OR CodigoCurso = '38' OR CodigoCurso = '48')";
			if($CodigoMateria == '9') $addSQL = "AND (CodigoCurso = '39' OR CodigoCurso = '40')";
			if($CodigoMateria =='IV') $addSQL = "AND (CodigoCurso = '41' OR CodigoCurso = '42')";
			
			// Notas final
			$sqlDEF = "SELECT * FROM Nota 
						WHERE CodigoAlumno='".$CodigoAlumno."'
						$addSQL 
						AND Lapso='Def' ";  
			$RS_notasDEF = mysql_query($sqlDEF, $bd) or die(mysql_error());
			$row_notasDEF = mysql_fetch_assoc($RS_notasDEF);

			// Notas revision
			$sqlRevDef = "SELECT * FROM Nota 
						WHERE CodigoAlumno='".$CodigoAlumno."'
						$addSQL 
						AND Lapso='RevDef' "; 
			//echo $sqlRevDef.'<br>';			 
			$RS_notasRevDef = mysql_query($sqlRevDef, $bd) or die(mysql_error());
			$row_notasRevDef = mysql_fetch_assoc($RS_notasRevDef);
			
			$Nota[$CodigoMateria] = $row_notasDEF;
			
			for ($j = 1; $j <= 13; $j++){
				$notaaux = $Nota[$CodigoMateria]['n'.oi($j)]*1;
				if($notaaux >= 1 and $notaaux <= 9){
					$Nota[$CodigoMateria]['n'.oi($j)] = ' r '.$row_notasRevDef['n'.oi($j)];
					$TE_sql[$j] = 'R';}
				else
					$TE_sql[$j] = 'F';

					
					//$Nota[$CodigoMateria][Ano_Escolar] = '';
				}
			
			if($CodigoMateria == '7' or $CodigoMateria == '8' or $CodigoMateria == '9'){
				$et1 = $row_notasDEF['n'.oi(10)];
				$et2 = $row_notasDEF['n'.oi(11)];
				$aux = round(($et1 + $et2)/2 , 0);
				
				$Nota[$CodigoMateria][n10] = Nota($aux);
				$Nota[$CodigoMateria][n11] = $Nota[$CodigoMateria][n12];
				$Nota[$CodigoMateria][n12] = '';
			}
				
		}
		
		
		$pdf->Ln();
		foreach($CodigoMaterias as $CodigoMateria){
			
			
			if($CodigoMateria == 'IV') $nMax = 12; else $nMax = 11;
			// Materias
			$pdf->SetFont('Arial','B',14);
			$pdf->Cell(20 , $Ln*2 , $CodigoMateria , 0 , 1 , 'C');
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(20 , $Ln , '' , $borde , 0 , 'C');
			for ($j = 1; $j <= $nMax; $j++){
				$Mat_sql[$j] = $Mat[$CodigoMateria][oi($j)];
				$Materia_sql[$j] = $Materia[$CodigoMateria][oi($j)];}
			$pdf->Cell(14 , $Ln , $Mat_sql[$j] , $borde , 0 , 'C');
			$pdf->Ln();
			
			// Notas
			$pdf->SetFont('Arial','B',14);
			$pdf->Cell(20 , $Ln*2 , 'Nota' , $borde , 0 , 'R');
			for ($j = 1; $j <= $nMax; $j++){
				if($Nota[$CodigoMateria]['n'.oi($j)] == ' r')
					$nota_sql[$j] = '';
				else	
					$nota_sql[$j] = $Nota[$CodigoMateria]['n'.oi($j)];
				$pdf->Cell(14 , $Ln*2 , $nota_sql[$j] , $borde , 0 , 'C');
			}
			$pdf->Ln();
			
			// Fecha
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(20 , $Ln , 'MesAno' , $borde , 0 , 'R');
			for ($j = 1; $j <= $nMax; $j++)	{
				if( strpos( $Nota[$CodigoMateria]['n'.oi($j)] , 'r' ) )	
					$Ano_sql[$j] = '';		
				else
					$Ano_sql[$j] = substr($Nota[$CodigoMateria][Ano_Escolar],-4);
				$pdf->Cell(14 , $Ln , $Ano_sql[$j] , $borde , 0 , 'C');}
			$pdf->Ln();
			
			
	//		$SQLinsert = "(CodigoAlumno, Grado, Orden, Materia, '".$nota_sql[$j]."', '".$Ano[$j]."'),";
			for ($j = 1; $j <= $nMax; $j++) 
				$SQLinsert .= "('".$CodigoAlumno."', '".$CodigoMateria."', '".$j."', '".$Materia_sql[$j]."', '".$nota_sql[$j]."', 'F', '07', '".$Ano_sql[$j]."', '1'),";
			
			if($CodigoMateria==7){//(CodigoAlumno, Grado, Orden, Materia, Nota, TE, Mes, Ano, Plantel)
				$SQLinsert .= "('".$CodigoAlumno."', '".$CodigoMateria."', '20', 'Informática','4','','ET','',''),";
				$SQLinsert .= "('".$CodigoAlumno."', '".$CodigoMateria."', '21', 'Nociones Básicas de Oficina','4','','ET','',''),";}
			
			if($CodigoMateria==8 or $CodigoMateria==9){
				$SQLinsert .= "('".$CodigoAlumno."', '".$CodigoMateria."', '20', 'Informática','4','','ET','',''),";
				$SQLinsert .= "('".$CodigoAlumno."', '".$CodigoMateria."', '21', 'Contabilidad','4','','ET','',''),";}
			
			// Colegio
			$pdf->Cell(20 , $Ln , 'Colegio' , $borde , 0 , 'R');
			for ($j = 1; $j <= $nMax; $j++)
				$pdf->Cell(14 , $Ln , '' , $borde , 0 , 'L');
			$pdf->Ln($Ln*2);
			
			}
		unset($Nota);	
		
		// V Año
		$jmat=1;
		$MateriasVano = array('Castellano','Inglés','Educación Física','Geograía Económica','Matemática','Biología','Química','Física','Ciencias de la Tierra','Pre-Militar','Italiano');
		foreach($MateriasVano as $MateriaVano)
			$SQLinsert .= "('".$CodigoAlumno."', 'V', '".$jmat++."', '".$MateriaVano."', '', 'F', '07', '', '1'),";
		
		$SQLinsert = substr($SQLinsert,0,strlen($SQLinsert)-1);
		$SQLinsert = "INSERT INTO Notas_Certificadas 
						(CodigoAlumno, Grado, Orden, Materia, Nota, TE, Mes, Ano, Plantel)
						VALUES
						$SQLinsert" ;
						$SQLinsert = str_replace('Computación','Educación para el Trabajo',$SQLinsert);
						//$SQLinsert = str_replace('Educación Física','Educación Física y Deporte',$SQLinsert);
						//echo $SQLinsert;
		$RSinsert = mysql_query($SQLinsert, $bd) or die(mysql_error());
		
		
		$pdf->AddPage();
			//unset($Mat_sq);
			unset($nota_sql);
			unset($Ano_sql);
			unset($TE_sql);
		} 
*/


	
	
	
	if($_POST['Tipo']!='Curso'){ // Curso por alumno
		$sql3 = "SELECT * FROM Alumno, AlumnoXCurso, Curso 
		WHERE Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno 
		AND AlumnoXCurso.CodigoCurso = Curso.CodigoCurso 
		AND AlumnoXCurso.Ano = '$AnoEscolar'  
		AND Alumno.CodigoAlumno=".$CodigoAlumno ;
	$RS3 = mysql_query($sql3, $bd) or die(mysql_error());
	$row3 = mysql_fetch_assoc($RS3);
	$pdf->Cell(30 , $Ln , $row3['NombreCompleto'] , $borde , 0 , 'L'); }
	
	
	
	if($_POST['Materias'] or $_POST['Notas']>'0') { //Casillas para notas
		$sql_notas = "SELECT * FROM Nota 
						WHERE CodigoAlumno = '$CodigoAlumno' 
						AND Ano_Escolar = '$AnoEscolar' 
						AND Lapso = '".$_POST['Notas']."'";
		$RS_Notas = mysql_query($sql_notas, $bd) or die(mysql_error());
		$row_notas = mysql_fetch_assoc($RS_Notas);

		$Aplaz = '';
		for ($j = 1; $j <= 12; $j++) {  // para materias
			if($_POST['Notas']>'0'){
				$id = 'n'.substr('00'.$j,-2);
				$nota = $row_notas[$id]*1;
				if($nota<10)
					$pdf->SetTextColor(255,0,0);

				$pdf->SetFont('Arial','',12);
				$pdf->Cell($mm , $Ln , Nota($row_notas[$id]) , $borde , 0 , 'C', 1);
				$pdf->SetFont('Arial','',10);
				
				if($nota>0 and $nota<=20)
					$NotaPromedia[$i][$j] = $nota;
				
				if($nota>=10) 				
					$Aprobados[$j]++;
				if($nota>=1 and $nota<10 and (strpos($_POST['Notas'],'0')>0 or strpos($_POST['Notas'],'D')>0)) 	{
					$Aplazados[$j]++;
					$Aplaz++;}
				
				$Promedio[$j] += $nota*1;
				
				$pdf->SetTextColor(0);
				} 
			else		
				$pdf->Cell($mm , $Ln , '' , $borde , 0 , 'C', 1); 
		}
		
		$pdf->SetFont('Arial','I',9);
		$pdf->SetTextColor(255,0,0);
		$pdf->Cell($mm , $Ln , $Aplaz , $borde , 0 , 'R', 1);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','',10);
	} 
	
	if($_POST['Familia'] and $PrincipalFamilia==0) 	 // Casillas si Rifa
		$pdf->Cell(50 , $Ln , 'TIENE HERMANO MAYOR - NO ENTREGAR TALONARIO' , 0 , 0 , 'L'); 
	elseif ($_POST['Casillas']>0) {		// para generico NO rifa
		for ($j = 1; $j <= $_POST['Casillas']; $j++) {
			$mm = $AnchoDisponible/$_POST['Casillas'];
			$pdf->Cell($mm , $Ln , '' , $borde , 0 , 'C', 1); 
		}
	}
		
	//Otros datos

	if($_POST['Papa']){ 		// Papa	
		$sql = "SELECT * FROM Representante
				WHERE Creador = '$Creador'
				AND Nexo LIKE 'Pa%'
				AND Creador = '$Creador'";
		$resultado = $mysqli->query($sql);
		$fila = $resultado->fetch_assoc();
		$pdf->Cell(50 , $Ln , ucwords(strtolower( $fila['Nombres'].' '.$fila['Apellidos'] )) , $borde , 0 , 'L', 1 ); } 

	if($_POST['Mama']){ 		// Mama	
		$sql = "SELECT * FROM Representante
				WHERE Creador = '$Creador'
				AND Nexo LIKE 'Ma%'
				AND Creador = '$Creador'";
		$resultado = $mysqli->query($sql);
		$fila = $resultado->fetch_assoc();
		$pdf->Cell(50 , $Ln , ucwords(strtolower( $fila['Nombres'].' '.$fila['Apellidos'] )) , $borde , 0 , 'L', 1 ); } 
	
	$pdf->Ln($Ln); 

	if($_POST['Direccion']){ 	// Direccion
		if($_POST['Foto2'])
			$pdf->SetX($_x_Foto + 13);
		$pdf->Cell(170 , $Ln , ucwords(strtolower($Urbanizacion.' '.$Direccion)) , $borde , 1 , 'L', 1); }
		
	if($_POST['Telefono']){ 		// Telefono	
		if($_POST['Foto2'])
			$pdf->SetX($_x_Foto + 13);
		$pdf->Cell(170 , $Ln , $PerEmerTel.' '.$TelHab.' '.$TelCel , $borde , 0 , 'L', 1); }

	if($_POST['Foto2'] or $_POST['Direccion'] or $_POST['Telefono'])
		$pdf->Ln($Ln); 
	
	if($_POST['SoloFoto']) 	{	// Foto
		if($CodigoAlumnoAnterior != $CodigoAlumno){
			$nFoto++;
			if($nFoto == 1){
				$_x_Origen = $pdf->GetX(); 
				$_y_Origen = $pdf->GetY();
				$_x_Foto = $_x_Origen;
				$_y_Foto = $_y_Origen;
				}
		
			$_x_Ancho = 40;
	
			if( $_x_mult == 5){ 
				$_x_mult = 0;
				$_y_mult++;
			}
			
			if($_y_mult == 4){
				$pdf->AddPage();
				$_y_mult = 0;
			}
			$_x_Foto = $_x_Origen + $_x_mult * $_x_Ancho;
			$_y_Foto = $_y_Origen + $_y_mult * ($_x_Ancho + 15) ;
			
			
			$Foto = '../../../'.$AnoEscolar.'/150/' .$CodigoAlumno. '.jpg';
			//if(!file_exists($Foto))
				//$Foto = '../../../'.$AnoEscolarAnte.'/150/' .$CodigoAlumno. '.jpg';
			if(file_exists($Foto))
				$pdf->Image($Foto , $_x_Foto , $_y_Foto, $_x_Ancho-2, 0);
	
	
			$pdf->SetXY($_x_Foto , $_y_Foto + $_x_Ancho-1.5);
			$pdf->Cell(($_x_Ancho-2)/2  , $Ln , $Nombres.' '.substr($Nombres2,0,1) , 'TBL' , 0 , 'L'); 
			$pdf->Cell(($_x_Ancho-2)/2  , $Ln , $CodigoAlumno , 'TBR' , 0 , 'R'); 
			
			$pdf->SetXY($_x_Foto , $_y_Foto + $_x_Ancho-1.5+$Ln);
			$pdf->Cell($_x_Ancho-2  , $Ln , $Apellidos.' '.substr($Apellidos2,0,1) , 1 , 0 , 'L'); 
			
			
				
			$_x_mult++;
		}
		$CodigoAlumnoAnterior = $CodigoAlumno;
		
	}


	$TituloAnterior = $TituloPag;
	
	
	if($row = mysql_fetch_assoc($RS)) // Siguiente Alumno
		extract($row); 
	
	if($_POST['Tipo']=='Curso') 
		 $TituloPag = $NombreCompleto;
	else 
		 $TituloPag = $Descripcion;
	
	
	// GRAFICOS DE NOTAS
	if($TituloAnterior != $TituloPag  or !$row){
	
	if($Aprobados[1]>0 or $Aprobados[3]>0 or $Aprobados[5]>0 or $Aprobados[7]>0 or $Aplazados[1]>0){
	$pdf->SetY($Y_estad);

	$pdf->SetFont('Arial','',9);
	
	$pdf->SetTextColor(0,0,255);
	$pdf->Cell(30 , 2*$Ln/1.5 , ' Aprobados ' , 'TBL' , 0 , 'R',1); 
	$pdf->SetTextColor(255,0,0);
	$pdf->Cell(22 , 2*$Ln/1.5 , ' Aplazados ' , 'TB' , 0 , 'L',1); 
	$pdf->SetTextColor(0);
	$pdf->Cell(26 , $Ln/1.5 , 'cantidad (#)' , 'TBR' , 0 , 'R',1); 
	
	for ($j = 1; $j <= 12; $j++) {	
		$pdf->SetTextColor(0,0,255);
		$pdf->Cell($mm/2 , $Ln/1.5 , $Aprobados[$j] , 'TBL' , 0 , 'L',1); 
		$pdf->SetTextColor(255,0,0);
		$pdf->Cell($mm/2 , $Ln/1.5 , $Aplazados[$j] , 'TBR' , 0 , 'R',1); 
		$pdf->SetTextColor(0);
	}
	$pdf->Cell($mm , $Ln/1.5 ,  ''  , $borde , 0 , 'R',1); 
	$pdf->Ln($Ln/1.5);
	
	$pdf->Cell(52 ); 
	$pdf->SetTextColor(0);
	$pdf->Cell(26 , $Ln/1.5 , 'porcentaje (%)' , 'TBR' , 0 , 'R',1); 
	
	for ($j = 1; $j <= 12; $j++) {	
		if($Aprobados[$j] > 0){
		$_Porcent_Aprob = round($Aprobados[$j]*100/($Aprobados[$j]+$Aplazados[$j]) , 0);
		$_Porcent_Aplaz = round(100-$_Porcent_Aprob , 0);} 
		else { $_Porcent_Aprob = $_Porcent_Aplaz=''; }
		
		if($_Porcent_Aplaz == 0){ 
			$ancho = $mm;
		}else{
			$ancho = $mm/2;}
		
		$pdf->SetTextColor(0,0,255);
		//if($_Porcent_Aprob==100) $_Porcent_Aprob = '100%';
		$pdf->Cell($ancho , $Ln/1.5 ,  $_Porcent_Aprob   , 'TBL' , 0 , 'L',1); 
		
		if($_Porcent_Aplaz != 0){ 
			$pdf->SetTextColor(255,0,0);
			$pdf->Cell($ancho , $Ln/1.5 ,  $_Porcent_Aplaz  , 'TBR' , 0 , 'R',1); 
		}
		
		// Grafico
		$pdf->SetFillColor(255,50,0); //Rojo
		$rango = 24.5;
		$Y0_graf = 10.5;
		if($_Porcent_Aplaz>0)
			$pdf->Rect(95+$mm*($j-1) ,$Y0_graf , 2 , $rango*$_Porcent_Aplaz/100 , 'F');
		$pdf->SetFillColor(0,100,255); //Azul
			$pdf->Rect(95+$mm*($j-1) ,$Y0_graf + $rango*$_Porcent_Aplaz/100 , 2 , $rango*$_Porcent_Aprob/100 , 'F');


		$pdf->SetFillColor(255);
		$pdf->SetTextColor(0);
	}
	$pdf->Cell($mm , $Ln/1.5 ,  ''  , $borde , 0 , 'R',1); 
	

	$pdf->Ln($Ln/1.5);
	$pdf->Cell(52 , 2*$Ln/1.5 , ' Estadísticos ' , 'TBL' , 0 , 'C',1); 
	//$pdf->Cell(52 ); 
	$pdf->SetTextColor(0);
	$pdf->Cell(26 , $Ln/1.5 , 'Promedio' , 'TBR' , 0 , 'R',1); 
	
	for ($j = 1; $j <= 12; $j++) {	
		if(($Aprobados[$j]+$Aplazados[$j])>0)
		$Promedio[$j] = round($Promedio[$j] / ($Aprobados[$j]+$Aplazados[$j]) , 1);
		if($Promedio[$j] == 0) $Promedio[$j]='';
		$pdf->Cell($mm , $Ln/1.5 ,  $Promedio[$j]  , '1' , 0 , 'C',1);
		$PromedioDePromedios += $Promedio[$j];
		if($Promedio[$j]>0) $CuentaDePromedios++;
	}
	$PromedioDePromedios = round($PromedioDePromedios / $CuentaDePromedios,1);
	$pdf->Cell($mm , $Ln/1.5 ,  $PromedioDePromedios  , '1' , 0 , 'C',1);
	$pdf->Ln($Ln/1.5);
	$pdf->Cell(52 ); 
	$pdf->SetTextColor(0);
	$pdf->Cell(26 , $Ln/1.5 , 'Desv. Estandar' , 'TBR' , 0 , 'R',1); 
	
	for ($j = 1; $j <= 12; $j++) {	
	
		for ($k = 1; $k <= $i; $k++)
			if($NotaPromedia[$k][$j]>0){
				$Desv[$j] += ($NotaPromedia[$k][$j] - $Promedio[$j])*($NotaPromedia[$k][$j] - $Promedio[$j]);
				$kmax[$j]++;}
		$Desv[$j] = round(sqrt($Desv[$j]/($kmax[$j]-1)),1);
		if($Desv[$j] == 0) $Desv[$j]='';
		$pdf->Cell($mm , $Ln/1.5 ,  $Desv[$j]  , '1' , 0 , 'C',1);
	}
	$pdf->Cell($mm , $Ln/1.5 ,  ''  , '1' , 0 , 'C',1);

	
	
	}

	unset($kmax);
	unset($Aprobados);
	unset($Aplazados);
	unset($Promedio);
	unset($NotaPromedia);
	unset($Desv);
	$PromedioDePromedios = $CuentaDePromedios = 0;
		
		if($_POST['Orientacion']=='P')
		$pdf->SetY( 257 );
		else
		$pdf->SetY( 190 );
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(50 , 2 , date('d').' '. Mes(date('m')) .' '. date('Y') , 0 , 0 , 'L');
		$pdf->Cell(100 , 2 , 'Pág.'.++$Pag , 0 , 0 , 'C');
		$pdf->Cell(50 , 2 , $TituloAnterior , 0 , 0 , 'R');
		$pdf->SetFont('Arial','',10);
	}

	

	
	
	
	
} while ($row);


$pdf->Output();

}
?>