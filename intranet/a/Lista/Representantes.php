<?php 
$MM_authorizedUsers = "99,95,90,91";
//$SW_omite_trace = false;
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 


$colname_RS_Representantes = "-1";
if (isset($_POST['Buscar']) and $_POST['Buscar']>'' ) {
  $colname_RS_Representantes = $_POST['Buscar'];


$aux = explode(" ", $_POST['Buscar'].$_GET['CodigoBuscar']);// echo "1: ". $aux[0]. " 2: ". $aux[1];



$query_RS_Representantes  = "SELECT * FROM Representante WHERE (";
$query_RS_Representantes .= "CONCAT_WS(' ', Nombres, Apellidos, Cedula, Empresa, ActividadEmpresa, Ocupacion, Profesion, Email1, Email2 ) LIKE '%%$aux[0]%%'";

if($aux[1]!=""){$query_RS_Representantes .=  " AND CONCAT_WS(' ', Nombres, Apellidos, Empresa, ActividadEmpresa, Ocupacion, Profesion ) LIKE '%%$aux[1]%%' ";}
if($aux[2]!=""){$query_RS_Representantes .=  " AND CONCAT_WS(' ', Nombres, Apellidos, Empresa, ActividadEmpresa, Ocupacion, Profesion ) LIKE '%%$aux[2]%%' ";}
if($aux[3]!=""){$query_RS_Representantes .=  " AND CONCAT_WS(' ', Nombres, Apellidos, Empresa, ActividadEmpresa, Ocupacion, Profesion ) LIKE '%%$aux[3]%%' ";}

$query_RS_Representantes .= ")  ORDER BY Apellidos ASC";

//echo $query_RS_Representantes;
$RS_Representantes = $mysqli->query($query_RS_Representantes); //
$row_RS_Representantes = $RS_Representantes->fetch_assoc();
$totalRows_RS_Representantes = $RS_Representantes->num_rows;
/*
$RS_Representantes = mysql_query($query_RS_Representantes, $bd) or die(mysql_error());
$row_RS_Representantes = mysql_fetch_assoc($RS_Representantes);
$totalRows_RS_Representantes = mysql_num_rows($RS_Representantes);*/
}


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Administraci&oacute;n SFDA</title>
<script src="../../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />


<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script src="../../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />

<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
a:link {
	color: #0000FF;
	text-decoration: none;
}
-->
</style>

<style type="text/css">
<!--
.style1 {
	font-size: 18px;
	font-family: "Times New Roman", Times, serif;
	color: #000066;
}
.style3 {font-size: 12px}
a:visited {
	color: #0000FF;
	text-decoration: none;
}
a:hover {
	color: #CCCC00;
	text-decoration: underline;
}
a:active {
	color: #FF0000;
	text-decoration: none;
}
-->
</style>
<link href="../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" align="center">
  <tr>
    <td colspan="2" align="left" nowrap="nowrap">
      <?php $TituloPantalla ="Representates";
	require_once('../TitAdmin.php'); ?>&nbsp;
    </td>
  </tr>
  <tr>
    <td width="50%" align="left" valign="top"><form id="form8" name="form8" method="post" action="">
            <label>
            <input name="Buscar" type="text" id="Buscar" value="<?php echo $_POST["Buscar"]; ?>" />
            </label>
            <label>
            <input type="submit" name="Submit" id="Submit" value="Buscar" />
            </label>
                              </form>
    <td align="right" valign="top"><a href="FotosFamilias.php">VER TODAS (usar con cautela)<br />
    este proceso recarga el servidor</a></td>
  </tr>
  <tr>
    <td colspan="2" align="center">
    <?php 
if($totalRows_RS_Representantes>0)	{	  
	
	?><table width="1000" border="0" cellpadding="5">
          <tr>
            <td class="NombreCampo">&nbsp;</td>
            <td class="NombreCampo">Cod</td>
            <td class="NombreCampo">Apellidos</td>
            <td class="NombreCampo">Nombres</td>
            <td class="NombreCampo">Usuario</td>
            <td class="NombreCampo">Cod. Hijos</td>
          </tr><?php  
do {	 
	  if ($totalRows_RS_Representantes > 0){
	  extract($row_RS_Representantes);  
	  	}

$query_RS_Hijos = "SELECT * FROM Alumno, AlumnoXCurso 
					WHERE Alumno.Creador = '$Creador' 
					AND Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno
					ORDER BY Alumno.CodigoAlumno, Ano DESC
					";
$RS_Hijos = $mysqli->query($query_RS_Hijos); //
$row_RS_Hijos = $RS_Hijos->fetch_assoc();
$totalRows_RS_Hijos = $RS_Hijos->num_rows;
	
	/*
$RS_Hijos = mysql_query($query_RS_Hijos, $bd) or die(mysql_error());
$row_RS_Hijos = mysql_fetch_assoc($RS_Hijos);
$totalRows_RS_Hijos = mysql_num_rows($RS_Hijos);*/
	   ?>
          <tr>
            <td class="Listado<?php echo $In ?>Par12">&nbsp;</td>
            <td class="Listado<?php echo $In ?>Par12"><?php echo $CodigoRepresentante ?>&nbsp;</td>
            <td class="Listado<?php echo $In ?>Par12"><?php echo $Apellidos ?>&nbsp;</td>
            <td class="Listado<?php echo $In ?>Par12"><?php echo $Nombres ?>&nbsp;</td>
            <td class="Listado<?php echo $In ?>Par12"><?php echo $Creador ?>&nbsp;</td>
            <td class="Listado<?php echo $In ?>Par12">
            <?php 
			do {
				if($CodigoAlumnoAnterior != $row_RS_Hijos["CodigoAlumno"]){
					if($row_RS_Hijos['Ano'] == $AnoEscolar)	{
						echo "<a href=\"http://www.colegiosanfrancisco.com/intranet/a/PlanillaImprimirADM.php?CodigoAlumno=".$row_RS_Hijos["CodigoAlumno"]."\" target=_blank>";}
						
					echo $row_RS_Hijos["CodigoAlumno"];
					
					if($row_RS_Hijos['Ano'] == $AnoEscolar){	
						echo "</a>  ";}
						echo "|";
				}
				$CodigoAlumnoAnterior = $row_RS_Hijos["CodigoAlumno"];
			} while ($row_RS_Hijos = $RS_Hijos->fetch_assoc());
			
		
			?>&nbsp;</td>
          </tr>
        <?php $In = $In==''?'In':'';
} while ($row_RS_Representantes = $RS_Representantes->fetch_assoc()); ?>
        </table><?php 
//mysql_free_result($RS_Hijos);
		
		} ?></td>
  </tr>
</table>
</body>
</html>