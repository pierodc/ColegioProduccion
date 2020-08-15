<?
require_once( $_SERVER['DOCUMENT_ROOT'] . "/Config/Autoload.php");

$Cursos = new Curso;
echo "<pre>";
$Cursos->view_all();

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
</body>
</html>