<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<script language="JavaScript" type="text/javascript">
    function n(id){
    document.getElementById('hide').style.display="inline";//MOSTRAR EL LINK ALTERNATIVO
    document.getElementById('see').style.display="none";//OCULTAR LINK INICIAL
    document.getElementById(id).style.display="block";//MOSTRAR BLOQUE IFRAME
    }
    function v(id){
    document.getElementById('hide').style.display="none";//OCULTAR EL LINK ALTERNATIVO
    document.getElementById('see').style.display="block";//MOSTRAR LINK INICIAL
    document.getElementById(id).style.display="none";//OCULTAR BLOQUE IFRAME
    }
</script>
 
<style>
table,iframe{
border:0.1mm Solid #C2C2C2;
}
#marco{
display:none;
}
#see{
display:inline;
}
#hide{
display:none;
}
 
</style>
</head>

<body>
<input name="see" value="iframe on" type="button" onClick="n('marco')" target="_self" id="see"/>
<input name="see" value="iframe off" type="button" id="hide" onClick="v('marco')"">
<iframe id="marco" src="http://www.programacionweb.net" width="496" heigth="100" frameborder="0"></iframe>
 
<table width="500">
  <tr>
    <td><h2>Utilidad de la etiqueta iFrame con Javascript </h2></td>
  </tr>
    <tr>
    <td>Ejemplo de uso de la etiqueta iFrame para aplicaciones web en las cuales se necesite la previsualizaci&oacute;n de un archivo o p&aacute;gina vinculada. </td>
  </tr>
    <tr bgcolor="#C2C2C2">
      <td bgcolor="#EEEEEE"><em>Este script fue probado en los navegadores Internet Explorer y Mozilla Firefox y comprobada su compatibilidad. </em></td>
  </tr>
</table>
 
</body>
</html>