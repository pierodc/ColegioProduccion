<?php 
$MM_authorizedUsers = "2,99,91,95,Contable";
require_once( $_SERVER['DOCUMENT_ROOT'] . "/Config/Autoload.php");
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');



$Alumno = new Alumno($_GET['CodigoPropietario']);

 // Busca todos los recibos
//$CodigoAlumno = $_GET['CodigoAlumno'];
$query_Recibos = "SELECT * FROM Recibo 
WHERE CodigoPropietario = '".$Alumno->Codigo() ."'
AND Fecha > '2018-08-01'
ORDER BY CodigoRecibo asc";
				  //echo $query_Recibos;
$Recibos = $mysqli->query($query_Recibos);
$totalRows_Recibos = $Recibos->num_rows;




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
  <title><?php echo "H: " . $Alumno->NombreApellidoCodigo(); ?></title>
  <link href="../estilos.css" rel="stylesheet" type="text/css" />
  <link href="../estilos2.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <table width="100%" border="0">
    <tr>
      <td class="NombreCampo">Fecha</td>
      <td align="center" class="NombreCampoTopeWin">Descripci&oacute;n</td>
      <td align="center" class="NombreCampoTopeWin">Ref</td>
      <td width="100" align="center" class="NombreCampoTopeWin">Pago</td>
      <td width="100" align="center" class="NombreCampoTopeWin">Abono</td>
      <td align="center" class="NombreCampoTopeWin">Saldo</td>
    </tr>
    <?php 
    
if ($totalRows_Recibos>0){ 
  $saldo=0; $Par = true;  
while ($row_Recibos = $Recibos->fetch_assoc()) { // RECIBOS 

  $CodigoRecibo = $row_Recibos['CodigoRecibo'];
  $query_Recibos_Hijos = "SELECT * FROM ContableMov 
                          WHERE CodigoRecibo = $CodigoRecibo 
                          ORDER BY MontoHaber DESC, Fecha ASC, Codigo ASC";//echo $query_Recibos;
  $Recibos_Hijos = $mysqli->query($query_Recibos_Hijos);
  $totalRows_Recibos_Hijos = $Recibos_Hijos->num_rows;

  if ($totalRows_Recibos_Hijos > 1) {
	  $row_Recibos_Hijos = $Recibos_Hijos->fetch_assoc();
  ?>


  <tr>
    <td colspan="6" bgcolor="#0033FF"><img src="../img/b.gif" width="1" height="1" /></td>
  </tr>

  <tr >
    <td colspan="2" class="subtitle" ><b><?php echo DDMMAAAA($row_Recibos['Fecha']); ?></b></td>
    <td align="center"  class="subtitle" >&nbsp;</td>
    <td colspan="3" align="right" nowrap="nowrap" class="subtitle" >
    <?php 
    if($row_Recibos['NumeroFactura'] > 0){
        echo "Factura No.".$row_Recibos['NumeroFactura']; 
      }
      ?></td>
   </tr> 


<tr class="ListadoInPar">
    <td colspan="2" valign="top" ><?
    
	if($row_Recibos_Hijos['MontoHaber'] > 0){

		echo FormaDePago($row_Recibos_Hijos['Tipo']).'<br>';
		echo $row_Recibos_Hijos['ReferenciaBanco'].'  ';
		echo $row_Recibos_Hijos['Referencia'].'  '; 
		echo FNum($MontoBancoAux);

		if($row_Recibos_Hijos['Referencia'] != $row_Recibos_Hijos['ReferenciaOriginal'] 
		  and $row_Recibos_Hijos['ReferenciaOriginal'] > 0 ){
		  echo '  /  Orig: '.$row_Recibos_Hijos['ReferenciaOriginal'];}
		
		if($row_RS_del_Banco['Fecha']>"2000-01-01") 
		  echo '<br>'.DDMMAAAA($row_RS_del_Banco['Fecha']);
		echo '<br>'.$row_RS_del_Banco['Descripcion'];
		


	  }
              
	
	?></td>
    <td valign="top" ><? 
	if($row_Recibos_Hijos['Descripcion'] == 'Abono a cuenta'){
                if ($row_Recibos['NumeroFactura']==0) { ?>
                  Facturado a: 
                  <?php 
                  $sql = "SELECT * FROM ReciboCliente
                  WHERE CodigoAlumno = '$CodigoAlumno'";
                  $RS = $mysqli->query($sql);
                  $totalRows = $Recibos->num_rows;


                  while($row = $RS->fetch_assoc()){
                    extract($row);
                    if($row_Recibos_Hijos['CodigoReciboCliente'] == $row['Codigo']) 
                      echo $Nombre;
                  }

                } 

              }

	
	echo "<br>Obs: ".$row_Recibos_Hijos['Observaciones']; ?></td>
    <td valign="top" align="right"><b>
              <?php if($row_Recibos_Hijos['MontoHaber']>0) {
				  echo Fnum($row_Recibos_Hijos['MontoHaber']);} ?>
            </b></td>
    <td valign="top" >&nbsp;</td>
    <td valign="top" class="ListadoInPar<?php 
    $MontoBancoAux='';
                // Ubica si esta en banco
    $query_RS_del_Banco = "SELECT * FROM Contable_Imp_Todo 
							WHERE Referencia = '".$row_Recibos_Hijos['Referencia']."'
							ORDER BY Fecha DESC";
    $RS_del_Banco = $mysqli->query($query_RS_del_Banco);
    $row_RS_del_Banco = $RS_del_Banco->fetch_assoc();
    $totalRows_RS_del_Banco = $RS_del_Banco->num_rows;


	/*
    if($row_Recibos_Hijos['MontoHaber'] <= $row_RS_del_Banco['MontoHaber'] and
    $row_Recibos_Hijos['MontoHaber'] > 0) {

      if($row_Recibos_Hijos['MontoHaber']==$row_RS_del_Banco['MontoHaber']){	
        echo "FondoCampoVerde"; }
        elseif($row_Recibos_Hijos['MontoHaber']<=$row_RS_del_Banco['MontoHaber']){	
          echo "FondoCampoAmarillo"; 
          $MontoBancoAux=$row_RS_del_Banco['MontoHaber'];
        }

      } 
      elseif ($row_Recibos_Hijos['MontoHaber']>0){ 

        if( $row_Recibos_Hijos['Tipo']==3) {
          echo "FondoCampoAzul";}
          elseif($row_Recibos_Hijos['Tipo']==4) {
            echo "FondoCampoNaranja";}
            elseif($row_Recibos_Hijos['MontoHaber']>0){
              echo "SW_Rojo"; }

              } else{
                echo 'Listado' . $In . 'Par';
              }

*/

              ?>">&nbsp;</td>
</tr> 






<?php // Busca los movimientos hijos del recibo

$Par = false;
do { // Hijos del Recibo ?>


  <tr >
    <?php if ($Par) {$In = "In"; $Par=false;}else{$In = ""; $Par=true;} ?>
    <td class="Listado<?php echo $In; ?>Par"><div align="center"></div></td>


    <td nowrap="nowrap" class="Listado<?php echo $In; ?>Par"><?php 
              if($row_Recibos_Hijos['Descripcion'] != 'Abono a cuenta'){
                // Nombres de conceptos
                echo ''.$row_Recibos_Hijos['Descripcion'].'';
              }

              ?></td>



              <td class="Listado<?php echo $In; ?>Par">
              <div align="left"><?php 

              if ($row_Recibos_Hijos['ReferenciaMesAno'] != 0) {
                echo Mes_Ano($row_Recibos_Hijos['ReferenciaMesAno']);			
              }

              ?></span>

            </div></td>
            <td align="right" class="Listado<?php echo $In; ?>Par"></td>
            <td align="right" class="Listado<?php echo $In; ?>Par"><em>
              <?php if($row_Recibos_Hijos['SWValidado']>0  and $row_Recibos_Hijos['MontoAbono']>0) {
                echo Fnum($row_Recibos_Hijos['MontoAbono']);} ?>
              </em></td>
              <td align="right" class="Listado<?php echo $In; ?>Par"><b>
                <?php if($row_Recibos_Hijos['SWValidado']>0) {$auxMonto = $row_Recibos_Hijos['MontoDebe']-$row_Recibos_Hijos['MontoAbono']; echo Fnum($auxMonto);} ?>
              </b>                <div align="center"></div></td>
            </tr>






            <?php			  

          } while ($row_Recibos_Hijos = $Recibos_Hijos->fetch_assoc()); // Hijos del Recibo
          
        }
      }  
      
      
    } // fin SI Existen recibos if ($totalRows_Recibos>0) ?>
  </table>

  <?php //include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>
